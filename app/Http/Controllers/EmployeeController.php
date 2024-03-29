<?php

namespace App\Http\Controllers;

use App\Actions\Hr\IsAccountingPeriodLocked;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Settings\ChartOfAccounts\AccountingPeriods;
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
        $employees = Employee::where('accounting_system_id', session('accounting_system_id'))->get();
        return view('hr.employee.index', compact('employees'));
    }

    public function store(Request $request)
    {

        // return $request;
        // TODO: Restrictions if any    
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        
        // Disable creation of new employees if payroll is generated for current accounting period.
        if(IsAccountingPeriodLocked::run($request->date_started_working))
            return back()->with('error', 'Payroll already created! Unable to generate new employee in current accounting period.');
        
        // Create Employee
        Employee::create([
            'accounting_system_id' => $accounting_system_id,
            'first_name' => $request->first_name,
            'father_name' => $request->father_name,
            'grandfather_name' => $request->grandfather_name,
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
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        // Get range of current accounting period
        if(IsAccountingPeriodLocked::run($request->date_started_working))
            return back()->with('error', 'Start of working date should be within accounting period range.');

        $employee->update([
            'accounting_system_id' => $accounting_system_id,
            'first_name' => $request->first_name,
            'father_name' => $request->father_name,
            'grandfather_name' => $request->grandfather_name,
            'date_of_birth' => $request->date_of_birth,
            'mobile_number' => $request->mobile_number,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'tin_number' => $request->tin_number,
            'type' => $request->type,
            'basic_salary' => $request->basic_salary,
            'date_started_working' => $request->date_started_working,
            'date_ended_working' => $request->date_ended_working,
            'emergency_contact_person' => $request->emergency_contact_person,
            'emergency_contact_number' => $request->contact_number,
        ]);
        return back()->with('success', 'Successfully updated an employee record.');
    }

    public function destroy(Employee $employee)
    {
        if(IsAccountingPeriodLocked::run($employee->date_started_working))
            return back()->with('error', "Can't delete employee. Employee is already included in payroll.");

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

    // ajaxSearchCommission
    public function ajaxSearchCommission(Employee $employee)
    {
        $employees = Employee::select('id as value', 'name','tin_number')
        ->where('type', '=', 'Commission Agent')->get();
        return $employees;
    }

}