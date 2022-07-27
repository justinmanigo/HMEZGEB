<?php

namespace App\Actions\Hr\Payroll;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Employee;
use App\Models\Settings\PayrollRules\OvertimePayrollRules;


class CalculateHourRate
{
    use AsAction;

    public function handle($employee_id,$accounting_system_id)
    {
        $employee = Employee::find($employee_id);
        $overtime_payroll_rules = OvertimePayrollRules::where('accounting_system_id', $accounting_system_id)->first();
        $hourRate = ($employee->basic_salary / $overtime_payroll_rules->working_days/$overtime_payroll_rules->working_hours);
        return $hourRate;
    }
}
