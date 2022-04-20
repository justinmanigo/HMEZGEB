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
        $employees = Employee::get();
        return view('hr.employee.index', compact('employees'));
    }

    public function store(Request $request)
    {

        // return $request;
        // TODO: Restrictions if any

        // Create Employee
        Employee::create([
            'first_name' => $request->first_name,
            'father_name' => $request->father_name,
            'given_father_name' => $request->given_father_name,
            'date_of_birth' => $request->date_of_birth,
            'mobile_number' => $request->mobile_number,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'tin_number' => $request->tin_number,
            'type' => $request->type,
            'basic_salary' => $request->basic_salary,
            'date_started_working' => $request->date_started_working,
            'date_ended_working' => $request->is_still_working == 'on'
                ? null
                : $request->date_ended_working,
            'emergency_contact_person' => $request->emergency_contact_person,
            'emergency_contact_number' => $request->contact_number,
        ]);
        return back()->with('success', 'Successfully created an employee record.');
    }

    public function update(Employee $employee, Request $request)
    {
        // TODO: Restrictions if any

        $employee->update([
            'first_name' => $request->first_name,
            'father_name' => $request->father_name,
            'given_father_name' => $request->given_father_name,
            'date_of_birth' => $request->date_of_birth,
            'mobile_number' => $request->mobile_number,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'tin_number' => $request->tin_number,
            'type' => $request->type,
            'date_started_working' => $request->date_started_working,
            'date_ended_working' => $request->date_ended_working,
            'emergency_contact_person' => $request->emergency_contact_person,
            'emergency_contact_number' => $request->contact_number,
        ]);
        return back()->with('success', 'Successfully updated an employee record.');
    }

    public function destroy(Employee $employee)
    {
        // TODO: Restrictions if any

        $employee->delete();
        return back()->with('success', 'Successfully deleted an employee record.');
    }

    /*======================== */

    public function ajaxGetEmployee(Employee $employee)
    {
        return $employee;
    }

    
    public function queryEmployees($query)
    {   
        $employee = Employee::select('id as value', 'first_name','tin_number')
            ->where('first_name', 'LIKE', '%' . $query . '%')->get();
        return $employee;
    }
}
