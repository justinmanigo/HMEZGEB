<?php

namespace App\Http\Controllers;

use App\Models\OvertimePayrollRules;
use App\Models\IncomeTaxPayrollRules;
use Illuminate\Http\Request;


class SettingPayrollRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $overtime_payroll_rules = OvertimePayrollRules::all()->first();
        $income_tax_payroll_rules = IncomeTaxPayrollRules::all();
        return view('settings.payroll_rules.index' ,compact('overtime_payroll_rules','income_tax_payroll_rules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIncomeTaxRules(Request $request)
    {
        // return $request;

        // Delete all records first
        IncomeTaxPayrollRules::truncate();

        for($i = 0; $i < count($request->income); $i++)
        {
            // Store new records
            $income_tax_payroll_rules = new IncomeTaxPayrollRules;
            $income_tax_payroll_rules->income = $request->income[$i];
            $income_tax_payroll_rules->rate = $request->rate[$i];
            $income_tax_payroll_rules->deduction = $request->deduction[$i];
            $income_tax_payroll_rules->save();
        }
        return redirect()->back()->with('success', 'Income Tax Rule has been updated.');
    }

    public function storeOvertimeRules(Request $request)
    {
        //
        // return $request;

        // Delete all records first
        OvertimePayrollRules::truncate();
        // Store new records
        $overtime_rules = new OvertimePayRollRules();
        $overtime_rules->working_days = $request->working_days;
        $overtime_rules->working_hours = $request->working_hours;
        $overtime_rules->day_rate = $request->day_rate;
        $overtime_rules->night_rate = $request->night_rate;
        $overtime_rules->holiday_weekend_rate = $request->holiday_weekend_rate;
        $overtime_rules->save();

        return redirect()->back()->with('success', 'Overtime Rule has been updated.');

    }
}
