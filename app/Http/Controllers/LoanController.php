<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Employee;

use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        for($i = 0; $i < count($request->employee); $i++)
        {
        $employee = json_decode($request->employee[$i]);
            $e[$i] = $employee[0]; // decoded json always have index 0, thus it needs to be removed.
            
            // Store
               $loan = new Loan;
               $loan->accounting_system_id = $accounting_system_id;
               $loan->employee_id = $e[$i]->value;
               $loan->date = $request->date;
               $loan->loan = $request->loan[$i];
               $loan->paid_in = $request->paid_in[$i];
               $loan->description = $request->description;
               $loan->save();
        }
        return redirect()->back()->with('success', 'Loan has been added.');
    }
}
