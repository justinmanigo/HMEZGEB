<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\PayrollItems;
use App\Models\Employee;
use App\Models\AccountingSystem;
use App\Models\Addition;
use App\Models\Deduction;
use App\Models\Overtime;
use App\Models\Loan;
use App\Models\Settings\ChartOfAccounts\AccountingPeriods;
use Illuminate\Http\Request;
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
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $payrolls = Payroll::where('accounting_system_id', $accounting_system_id)
            ->orderBy('created_at', 'desc')->get();
        return view('hr.payroll.index', compact('payrolls'));
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
        $accounting_period = AccountingPeriods::where('period_number',$request->period)->where('accounting_system_id', $accounting_system_id)->first(); 
        if($accounting_period){
            // get id from Accounting system related to the period
            $accounting_system = AccountingSystem::where('id', $accounting_period->accounting_system_id)->first();

            $employees = Employee::where('accounting_system_id',$accounting_system->id)->where('type','employee')->get();
           
            foreach($employees as $employee){
                $additions = Addition::where('accounting_system_id',$accounting_system->id)->where('employee_id',$employee->id)->get();
                $deductions = Deduction::where('accounting_system_id',$accounting_system->id)->where('employee_id',$employee->id)->get();
                $overtimes = Overtime::where('accounting_system_id',$accounting_system->id)->where('employee_id',$employee->id)->get();
                $loans = Loan::where('accounting_system_id',$accounting_system->id)->where('employee_id',$employee->id)->get();            
               
                // Create Payroll
                $payroll = new Payroll;
                $payroll->period_id = $accounting_period->id;
                $payroll->status = 'pending';
                $payroll->employee_id = $employee->id;
                $payroll->accounting_system_id = $accounting_system_id;
                $payroll->save();

                // employee SALARY
                $total_salary = 0;
                $total_salary = $total_salary + $employee->basic_salary;
                
                $salary = new PayrollItems();
                $salary->payroll_id = $payroll->id;
                $salary->source = 'salary'; 
                $salary->status = 'pending';
                $salary->amount = $employee->basic_salary;
                $salary->save();
              
                // Update payroll total salary
                $payroll->total_salary = $total_salary;
                $payroll->save();
            
                // employee ADDITIONS
                $total_addition = 0;
                foreach($additions as $add){
                    $total_addition = $total_addition + $add->price;

                    $addition = new PayrollItems();
                    $addition->payroll_id = $payroll->id;
                    $addition->source = 'addition';
                    $addition->status = 'pending';
                    $addition->amount = $add->price;
                    $addition->save();
                }
                // Update payroll total addition
                $payroll->total_addition = $total_addition;
                $payroll->save();

                // employee DEDUCTIONS
                $total_deduction = 0;
                foreach($deductions as $ded){
                    $total_deduction = $total_deduction + $ded->price;

                    $deduction = new PayrollItems();
                    $deduction->payroll_id = $payroll->id;
                    $deduction->source = 'deduction';
                    $deduction->status = 'pending';
                    $deduction->amount = $ded->price;
                    $deduction->save();
                }
                // Update payroll total deduction
                $payroll->total_deduction = $total_deduction;
                $payroll->save();

                // employee OVERTIME
                $total_overtime = 0;
                foreach($overtimes as $ot){
                    $total_overtime = $total_overtime + $ot->price;

                    $overtime = new PayrollItems();
                    $overtime->payroll_id = $payroll->id;
                    $overtime->source = 'overtime';
                    $overtime->status = 'pending';
                    $overtime->amount = $ot->price;
                    $overtime->save();
                }
                // Update payroll total overtime
                $payroll->total_overtime = $total_overtime;
                $payroll->save();

                    // employee LOANS
                $total_loan = 0;
                foreach($loans as $loan){
                    $total_loan = $total_loan + $loan->loan_amount;

                    $loan_item = new PayrollItems();
                    $loan_item->payroll_id = $payroll->id;
                    $loan_item->source = 'loan';
                    $loan_item->status = 'pending';
                    $loan_item->amount = $loan->loan;
                    $loan_item->save();
                }
                // Update payroll total loan
                $payroll->total_loan = $total_loan;
                $payroll->save();
            }
        
            // TODO: Check if records are empty
            // if($salary->isEmpty() && $additions->isEmpty() && $deductions->isEmpty() && $overtimes->isEmpty())
            // return redirect()->route('payrolls.payrolls.index')->with('error','No records to create Payroll');

        }
        return redirect()->route('payrolls.payrolls.index')->with('success','Payroll Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show(Payroll $payroll)
    {
        //
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
    public function destroy(Payroll $payroll)
    {
        //
    }
}
