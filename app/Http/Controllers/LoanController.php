<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use App\Http\Requests\HumanResource\StoreLoanRequest;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $loans = Employee::join(
            'loans',
            'loans.employee_id',
            '=',
            'employees.id'
        )->select(
            'loans.id',
            'loans.date',
            'loans.loan',
            'loans.paid_in',
            'employees.first_name',
            'employees.type',
        )->where('loans.accounting_system_id', session('accounting_system_id'))
        ->get();
        return view('hr.loan.index' , compact('loans'));
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
    public function store(StoreLoanRequest $request)
    {
        //
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        // Disable create if payroll is generated for current accounting period.
        $payroll = Payroll::where('accounting_system_id', $accounting_system_id)->get();
        if(!$payroll->isEmpty())
        return redirect()->back()->with('danger', 'Payroll already created! Unable to generate new loan in current accounting period.');
            
        
        for($i = 0; $i < count($request->employee); $i++)
        {

            // Store
               $loan = new Loan;
               $loan->accounting_system_id = $accounting_system_id;
               $loan->employee_id = $request->employee[$i]->value;
               $loan->date = $request->date;
               $loan->loan = $request->loan[$i];
               $loan->paid_in = $request->paid_in[$i];
               $loan->description = $request->description;
               $loan->save();
        }
        return redirect()->back()->with('success', 'Loan has been added.');
    }

    public function update(Request $request, Loan $loan)
    {
        //
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        // Disable create if payroll is generated for current accounting period.
        $payroll = Payroll::where('accounting_system_id', $accounting_system_id)->get();
        if(!$payroll->isEmpty())
        return redirect()->back()->with('danger', 'Payroll already created! Unable to update loan in current accounting period.');
          
    }

    public function destroy(Loan $loan)
    {
        //
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        // Disable create if payroll is generated for current accounting period.
        $payroll = Payroll::where('accounting_system_id', $accounting_system_id)->get();
        if(!$payroll->isEmpty())
        return redirect()->back()->with('danger', 'Payroll already created! Unable to delete loan in current accounting period.');
          
        if(isset($loan->payroll_id))
        {
            return redirect()->back()->with('danger', 'Loan already pending in payroll.');
        }
        else
        {
            $loan->delete();
            return redirect()->back()->with('success', 'Loan has been deleted.');
        }          
    }
}
