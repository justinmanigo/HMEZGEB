<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use App\Models\Employee;

use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        for($i = 0; $i < count($request->employee); $i++)
        {
        $employee = json_decode($request->employee[$i]);
            $e[$i] = $employee[0]; // decoded json always have index 0, thus it needs to be removed.
            
            // Store
               $deduction = new Deduction;
               $deduction->accounting_system_id = $accounting_system_id;
               $deduction->employee_id = $e[$i]->value;
               $deduction->date = $request->date;
               $deduction->price = $request->price[$i];
               $deduction->description = $request->description;
               $deduction->save();
        }
        return redirect()->back()->with('success', 'Deduction has been added.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $deduction = Deduction::find($id);
        $deduction->delete();
        
        return redirect('deduction/')->with('danger', "Successfully deleted deduction");
    }
}
