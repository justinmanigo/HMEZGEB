<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees = Employee::all();

        return view('hr.employee.index' , compact('employees'));
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
        //
        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->father_name = $request->father_name;
        $employee->grandfather_name = $request->grandfather_name;
        $employee->date_of_birth = $request->date_of_birth;
        $employee->mobile_number = $request->mobile_number;
        $employee->telephone = $request->telephone;
        $employee->email = $request->email;
        $employee->tin_number = $request->tin_number;
        $employee->type = $request->type;
        $employee->basic_salary = $request->basic_salary;
        $employee->date_started_working = $request->date_started_working;
        $employee->date_ended_working = $request->date_ended_working;
        $employee->emergency_contact_person = $request->emergency_contact_person;
        $employee->emergency_contact_number = $request->emergency_contact_number;
        $employee->save();
        return redirect('employee/')->with('success', "Successfully added new employee.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    
    public function queryEmployees($query)
    {   
        $employee = Employee::select('id as value', 'first_name','tin_number')
            ->where('first_name', 'LIKE', '%' . $query . '%')->get();
        return $employee;
    }
}
