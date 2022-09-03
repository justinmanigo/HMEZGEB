<?php

namespace App\Http\Controllers;

use App\Actions\Hr\IsAccountingPeriodLocked;
use App\Models\Addition;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use App\Http\Requests\HumanResource\StoreAdditionRequest;

class AdditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $additions = Employee::join(
            'additions',
            'additions.employee_id',
            '=',
            'employees.id'
        )->select(
            'additions.id',
            'additions.date',
            'additions.price',
            'employees.first_name',
            'employees.type',
        )->where('additions.accounting_system_id', session('accounting_system_id'))->get();
        return view('hr.addition.index' ,compact('additions'));
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
    public function store(StoreAdditionRequest $request)
    {        
        for($i = 0; $i < count($request->employee); $i++)
         {

             // Store
                $addition = new Addition;
                $addition->accounting_system_id = session('accounting_system_id');
                $addition->employee_id = $request->employee[$i]->value;
                $addition->date = $request->date;
                $addition->price = $request->price[$i];
                $addition->description = $request->description;
                $addition->save();
         }
        //  return redirect()->back()->with('success', 'Addition has been added.');
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function show(Addition $addition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function edit(Addition $addition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Addition $addition)
    {
        //
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        // Disable create if payroll is generated for current accounting period.
        $payroll = Payroll::where('accounting_system_id', $accounting_system_id)->get();
        if(!$payroll->isEmpty())
        return redirect()->back()->with('danger', 'Payroll already created! Unable to update addition in current accounting period.');
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addition $addition)
    {
        //
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        // Disable create if payroll is generated for current accounting period.
        $payroll = Payroll::where('accounting_system_id', $accounting_system_id)->get();
        if(!$payroll->isEmpty())
        return redirect()->back()->with('danger', 'Payroll already created! Unable to delete addition in current accounting period.');
          
        if(isset($addition->payroll_id))
        {
            return redirect()->back()->with('danger', 'Addition already pending in payroll.');
        }
        else
        {
            $addition->delete();
            return redirect()->back()->with('success', 'Addition has been deleted.');
        }      
    }
}
