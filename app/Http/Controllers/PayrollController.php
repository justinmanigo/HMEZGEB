<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\PayrollPeriod;
use App\Models\AccountingSystem;
use App\Models\Employee;
use App\Models\Pension;
use App\Models\TaxPayroll;
use App\Models\BasicSalary;
use App\Models\Addition;
use App\Models\Deduction;
use App\Models\Overtime;
use App\Models\Loan;
use App\Models\Settings\ChartOfAccounts\AccountingPeriods;
use App\Models\Settings\PayrollRules\IncomeTaxPayrollRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $accounting_system_id = $this->request->session()->get('accounting_system_id');
        // $payrolls = Payroll::where('accounting_system_id', $accounting_system_id)
        //     ->orderBy('created_at', 'desc')->get();
        
        // // get accounting_periods with no payrolls for select menu
        $accounting_periods_with_no_payroll = AccountingPeriods::where('accounting_system_id', session('accounting_system_id'))
            ->whereDoesntHave('payrollPeriod')
            ->get();

        $subQuery = DB::table('payrolls')
            ->select('payroll_period_id as id', DB::raw('COUNT(payroll_period_id) as employee_count'))
            ->groupBy('payroll_period_id');

        $payroll_periods = DB::table('accounting_periods')
            ->select(
                'accounting_periods.period_number',
                'accounting_periods.date_from',
                'accounting_periods.date_to',
                'payroll_periods.id as payroll_period_id',
                'payroll_periods.is_paid',
                DB::raw('IFNULL(p.employee_count, 0) as employee_count'),
                'payroll_periods.created_at',
                'payroll_periods.updated_at',
            )
            ->leftJoin('payroll_periods', 'payroll_periods.period_id', 'accounting_periods.id')
            ->leftJoinSub($subQuery, 'p', function($join){
                $join->on('p.id', '=', 'payroll_periods.id');
            })
            ->where('accounting_periods.accounting_system_id', session('accounting_system_id'))
            ->get();

        // return $payroll_periods;

        return view('hr.payroll.index', compact(
            'accounting_periods_with_no_payroll',
            'payroll_periods',
        ));
    
        // return view('hr.payroll.index', compact('payrolls', 'accounting_periods_with_no_payroll'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get Accounting Period
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $accounting_period = AccountingPeriods::where('id',$request->period)->first(); 
        if($accounting_period){
            // get id from Accounting system related to the period
            $accounting_system = AccountingSystem::where('id', $accounting_period->accounting_system_id)->first();
            
            //Get salary
            $employees = Employee::where('accounting_system_id',$accounting_system->id)->where('type','employee')
            ->get();
                       
            if($employees->isEmpty())
                return redirect()->route('payrolls.payrolls.index')->with('error','No records to create Payroll');

            // Create Payroll Period
            $payroll_period = new PayrollPeriod;
            $payroll_period->period_id = $accounting_period->id;
            $payroll_period->accounting_system_id = $accounting_system_id;
            $payroll_period->save();

            foreach($employees as $employee){
                $additions = Addition::where('accounting_system_id',$accounting_system->id)->where('employee_id',$employee->id)
                ->whereBetween('date', [$accounting_period->date_from, $accounting_period->date_to])
                ->get();
                $deductions = Deduction::where('accounting_system_id',$accounting_system->id)->where('employee_id',$employee->id)
                ->whereBetween('date', [$accounting_period->date_from, $accounting_period->date_to])
                ->get();
                $overtimes = Overtime::where('accounting_system_id',$accounting_system->id)->where('employee_id',$employee->id)
                ->whereBetween('date', [$accounting_period->date_from, $accounting_period->date_to])
                ->get();
                $loans = Loan::where('accounting_system_id',$accounting_system->id)->where('employee_id',$employee->id)
                ->whereBetween('date', [$accounting_period->date_from, $accounting_period->date_to])
                ->get();            
                
                
                // Create Payroll
                $payroll = new Payroll;
                $payroll->payroll_period_id = $payroll_period->id;
                $payroll->status = 'pending';
                $payroll->employee_id = $employee->id;
                $payroll->accounting_system_id = $accounting_system_id;
                $payroll->save();

                // employee SALARY
                $total_salary = 0;
                $total_salary = $total_salary + $employee->basic_salary;
                
                $salary = new BasicSalary();
                $salary->accounting_system_id = $accounting_system_id;
                $salary->employee_id = $employee->id;
                $salary->payroll_id = $payroll->id;
                $salary->price = $employee->basic_salary;
                $salary->save();
              
                // Update payroll total salary
                $payroll->total_salary = $total_salary;
                $payroll->save();
            
                // employee ADDITIONS
                $total_addition = 0;
                foreach($additions as $add){
                    $total_addition = $total_addition + $add->price;

                    $add->payroll_id = $payroll->id;
                    $add->save();
                }
                // Update payroll total addition
                $payroll->total_addition = $total_addition;
                $payroll->save();

                // employee DEDUCTIONS
                $total_deduction = 0;
                foreach($deductions as $ded){
                    $total_deduction = $total_deduction + $ded->price;

                    $ded->payroll_id = $payroll->id;
                    $ded->save();
                }
                // Update payroll total deduction
                $payroll->total_deduction = $total_deduction;
                $payroll->save();

                // employee OVERTIME
                $total_overtime = 0;
                foreach($overtimes as $ot){
                    $total_overtime = $total_overtime + $ot->price;

                    $ot->payroll_id = $payroll->id;
                    $ot->save();
                }
                // Update payroll total overtime
                $payroll->total_overtime = $total_overtime;
                $payroll->save();

                    // employee LOANS
                $total_loan = 0;
                foreach($loans as $loan){
                    $total_loan = $total_loan + $loan->loan;

                    $loan->payroll_id = $payroll->id;
                    $loan->save();
                }
                // Update payroll total loan
                $payroll->total_loan = $total_loan;
                $payroll->save();
                
                // Pension
                $pension = new Pension();
                $pension->accounting_system_id = $accounting_system_id;
                $pension->employee_id = $employee->id;
                $pension->payroll_id = $payroll->id;
                $pension->pension_07_amount = $employee->basic_salary * 0.07;
                $pension->pension_11_amount = $employee->basic_salary * 0.11;
                $pension->save();
                
                $total_pension_7 = $employee->basic_salary * 0.07;
                $payroll->total_pension_7 = $total_pension_7;
                $total_pension_11 = $employee->basic_salary * 0.11;
                $payroll->total_pension_11= $total_pension_11;
                $payroll->save();
           
                // Tax
                // add all total_salary , total_addition , total_overtime 
                $taxable_income = $total_salary + $total_addition + $total_overtime;

                // get tax settings
                $tax_settings = IncomeTaxPayrollRules::where('accounting_system_id',$accounting_system->id)->get();
                $tax_amount=0;
                foreach($tax_settings as $tax_setting){
                    if($taxable_income>$tax_setting->income){
                        $tax_amount = ($taxable_income*($tax_setting->rate/100)) - $tax_setting->deduction;
                        $tax = new TaxPayroll();
                        $tax->accounting_system_id = $accounting_system_id;
                        $tax->employee_id = $employee->id;
                        $tax->payroll_id = $payroll->id;
                        $tax->taxable_income = $taxable_income;
                        $tax->tax_rate = $tax_setting->rate;
                        $tax->tax_deduction = $tax_setting->deduction;
                        $tax->tax_amount = $tax_amount;
                        $tax->save();
                        
                        $payroll->total_tax = $tax_amount;
                        $payroll->save();
                        break;
                    }
                }
                // Net Pay
                $net_pay = $total_salary + $total_addition + $total_overtime - $total_pension_7 - $total_pension_11 - $total_deduction - $total_loan - $tax_amount;
                $payroll->net_pay = $net_pay;
                $payroll->save();
        }
        }
        return redirect()->route('payrolls.index')->with('success','Payroll Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show(PayrollPeriod $payroll_period)
    {
        if($payroll_period->accounting_system_id != session('accounting_system_id'))
            abort(404);

        $payroll_period->period;

        $payrolls = DB::table('payrolls')
            ->select(
                'employees.id as employee_id',
                'employees.first_name',
                'employees.father_name',
                'employees.grandfather_name',
                'payrolls.total_salary',
                'payrolls.total_addition',
                'payrolls.total_deduction',
                'payrolls.total_overtime',
                'payrolls.total_loan',
                'payrolls.total_tax',
                'payrolls.total_pension_7',
                'payrolls.total_pension_11',
                'payrolls.net_pay',
            )
            ->leftJoin('employees', 'employees.id', 'payrolls.employee_id')
            ->where('payrolls.payroll_period_id', $payroll_period->id)
            ->where('payrolls.accounting_system_id', session('accounting_system_id'))
            ->get();

        // return [
        //     'payroll_period' => $payroll_period,
        //     'payrolls' => $payrolls,
        // ];
        
        // TODO: Show breakdown by user (in a separate page)
        // get all related basic salary, additions, deductions, overtimes, loans, pensions, tax related to payroll
        // $payroll_items = DB::table('basic_salaries')
        // ->select('id','employee_id','payroll_id','price as amount','type')
        // ->where('payroll_id',$id)
        // ->union(DB::table('additions')
        // ->select('id','employee_id','payroll_id','price as amount','type')
        // ->where('payroll_id',$id))
        // ->union(DB::table('deductions')
        // ->select('id','employee_id','payroll_id','price as amount','type')
        // ->where('payroll_id',$id))
        // ->union(DB::table('overtimes')
        // ->select('id','employee_id','payroll_id','price as amount','type')
        // ->where('payroll_id',$id))
        // ->union(DB::table('loans')
        // ->select('id','employee_id','payroll_id','loan as amount','type')
        // ->where('payroll_id',$id))
        // ->union(DB::table('pensions')
        // ->select('id','employee_id','payroll_id','pension_07_amount as amount','type')
        // ->where('payroll_id',$id))
        // ->union(DB::table('pensions')
        // ->select('id','employee_id','payroll_id','pension_11_amount as amount','type')
        // ->where('payroll_id',$id))
        // ->union(DB::table('tax_payrolls')
        // ->select('id','employee_id','payroll_id','tax_amount as amount','type')
        // ->where('payroll_id',$id))
        // ->get();


        return view('hr.payroll.show', compact(
            'payroll_period',
            'payrolls',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayrollPeriod $payroll_period)
    {
        $payroll_period->payrolls;

        if($payroll_period->is_paid) {
            return redirect()->route('payrolls.index')->with('error','Error Deleting Payroll. Payroll Already Paid');
        }

        foreach($payroll_period->payrolls as $payroll)
        {
            BasicSalary::where('payroll_id',$payroll->id)->delete();
            Addition::where('payroll_id',$payroll->id)->update(['payroll_id'=>null]);
            Deduction::where('payroll_id',$payroll->id)->update(['payroll_id'=>null]);
            Overtime::where('payroll_id',$payroll->id)->update(['payroll_id'=>null]);
            Loan::where('payroll_id',$payroll->id)->update(['payroll_id'=>null]);
            Pension::where('payroll_id',$payroll->id)->delete();
            TaxPayroll::where('payroll_id',$payroll->id)->delete();
            $payroll->delete();
        }

        $payroll_period->delete();   

        return redirect()->route('payrolls.index')->with('success','Payroll Deleted Successfully');
    }
}
