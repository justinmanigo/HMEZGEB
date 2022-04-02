<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Show the employees page of human resource menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('hr.employee.index');
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
            'contact_number' => $request->contact_number,
        ]);
        return back()->with('success', 'Successfully created an employee record.');
    }
    }
}
