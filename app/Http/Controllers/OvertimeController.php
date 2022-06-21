<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Overtime;
use Illuminate\Http\Request;
use App\Http\Requests\HumanResource\StoreOvertimeRequest;


class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $overtimes = Employee::join(
            'overtimes',
            'overtimes.employee_id',
            '=',
            'employees.id'
        )->select(
            'overtimes.id',
            'overtimes.date',
            'overtimes.from',
            'overtimes.to',
            'overtimes.is_weekend_holiday',
            'employees.first_name',
            'employees.type',
        )->where('overtimes.accounting_system_id', session('accounting_system_id'))
        ->get();
        return view('hr.overtime.index', compact('overtimes'));
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
    public function store(StoreOvertimeRequest $request)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        for($i = 0; $i < count($request->employee); $i++)
        {
            // Store
            $overtime = new Overtime;
            $overtime->accounting_system_id = $accounting_system_id;
            $overtime->employee_id =  $request->employee[$i]->value;;
            $overtime->date = $request->date;
            if($request->is_weekend_holiday != null)
            {
                $overtime->is_weekend_holiday = 'yes';
            }
            else
            {
                $overtime->is_weekend_holiday = 'no';
            }
            $overtime->from = $request->from[$i];
            $overtime->to = $request->to[$i];
            $overtime->description = $request->description;
            $overtime->save();
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function show(Overtime $overtime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtime $overtime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Overtime $overtime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete
        $overtime = Overtime::find($id);
        $overtime->delete();
        
        return redirect('overtime/')->with('danger', "Successfully deleted overtime");
    }
}
