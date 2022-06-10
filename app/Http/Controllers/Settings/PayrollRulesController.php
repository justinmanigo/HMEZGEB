<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\PayrollRules\OvertimePayrollRules;
use App\Models\Settings\PayrollRules\IncomeTaxPayrollRules;

class PayrollRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->accounting_system_id = $this->request->session()->get('accounting_system_id');

        $overtime_payroll_rules = OvertimePayrollRules::where('accounting_system_id', $this->accounting_system_id)->first();
        $income_tax_payroll_rules = IncomeTaxPayrollRules::where('accounting_system_id', $this->accounting_system_id)->get();

        return view('settings.payroll_rules.index', [
            'overtime_payroll_rules' => $overtime_payroll_rules,
            'income_tax_payroll_rules' => $income_tax_payroll_rules,
        ]);
    }

    /**
     * Updates the income tax rules of a company.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateIncomeTaxRules(Request $request)
    {
        $this->accounting_system_id = $this->request->session()->get('accounting_system_id');
        
        // Delete all records first
        IncomeTaxPayrollRules::where('accounting_system_id', $this->accounting_system_id)->delete();

        for($i = 0; $i < count($request->income); $i++)
        {
            // Store new records
            $income_tax_payroll_rules = new IncomeTaxPayrollRules;
            $income_tax_payroll_rules->accounting_system_id = $this->accounting_system_id;
            $income_tax_payroll_rules->income = $request->income[$i];
            $income_tax_payroll_rules->rate = $request->rate[$i];
            $income_tax_payroll_rules->deduction = $request->deduction[$i];
            $income_tax_payroll_rules->save();
        }
        
        return redirect()->back()->with('success', 'Income Tax Rule has been updated.');
    }

    /**
     * Updates the overtime tax rules of a company.
     * 
     * @param \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateOvertimeRules(Request $request)
    {
        $this->accounting_system_id = $this->request->session()->get('accounting_system_id');
        
        // Delete all records first
        OvertimePayrollRules::where('accounting_system_id', $this->accounting_system_id)->delete();

        // Store new records
        $overtime_rules = new OvertimePayRollRules();
        $overtime_rules->accounting_system_id = $this->accounting_system_id;
        $overtime_rules->working_days = $request->working_days;
        $overtime_rules->working_hours = $request->working_hours;
        $overtime_rules->day_rate = $request->day_rate;
        $overtime_rules->night_rate = $request->night_rate;
        $overtime_rules->holiday_weekend_rate = $request->holiday_weekend_rate;
        $overtime_rules->save();

        return redirect()->back()->with('success', 'Overtime Rule has been updated.');
    }
}
