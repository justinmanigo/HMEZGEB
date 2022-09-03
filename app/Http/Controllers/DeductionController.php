<?php

namespace App\Http\Controllers;

use App\Actions\Hr\IsAccountingPeriodLocked;
use App\Models\Deduction;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use App\Http\Requests\HumanResource\StoreDeductionRequest;

class DeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $deductions = Employee::join(
            'deductions',
            'deductions.employee_id',
            '=',
            'employees.id'
        )->select(
            'deductions.id',
            'deductions.date',
            'deductions.price',
            'employees.first_name',
            'employees.type',
        )->where('deductions.accounting_system_id', session('accounting_system_id'))
        ->get();
        return view('hr.deduction.index' ,compact('deductions'));
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
    public function store(StoreDeductionRequest $request)
    {            
        for($i = 0; $i < count($request->employee); $i++)
        {        
            // Store
               $deduction = new Deduction;
               $deduction->accounting_system_id = session('accounting_system_id');
               $deduction->employee_id = $request->employee[$i]->value;
               $deduction->date = $request->date;
               $deduction->price = $request->price[$i];
               $deduction->description = $request->description;
               $deduction->save();
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function show(Deduction $deduction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function edit(Deduction $deduction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deduction $deduction)
    {
        // Disable create if payroll is generated for current accounting period.
        if(IsAccountingPeriodLocked::run($deduction->date))
            return redirect()->back()->with('danger', 'Payroll already created! Unable to update deduction in current accounting period.');
        
        // TODO: Update Deduction
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deduction $deduction)
    {
        // Disable create if payroll is generated for current accounting period.
        if(IsAccountingPeriodLocked::run($deduction->date))
            return redirect()->back()->with('danger', 'Payroll already created! Unable to delete deduction in current accounting period.');
        
        if(isset($deduction->payroll_id))
        {
            return redirect()->back()->with('danger', 'Deduction already pending in payroll.');
        }
        else
        {
            $deduction->delete();
            return redirect()->back()->with('success', 'Deduction has been deleted.');
        }           
    }
}
