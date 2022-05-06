<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Overtime;
use Illuminate\Http\Request;


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
            'employees.first_name',
            'employees.type',
        )->get();
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
    public function store(Request $request)
    {

        for($i = 0; $i < count($request->employee); $i++)
        {
            $employee = json_decode($request->employee[$i]);
            $e[$i] = $employee[0]; // decoded json always have index 0, thus it needs to be removed.
            
            // Store
            $overtime = new Overtime;
            $overtime->employee_id = $e[$i]->value;
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
        return redirect()->back()->with('success', 'Overtime has been added.');
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
