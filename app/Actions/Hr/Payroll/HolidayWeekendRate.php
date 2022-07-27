<?php

namespace App\Actions\Hr\Payroll;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Settings\PayrollRules\OvertimePayrollRules;

class HolidayWeekendRate
{
    use AsAction;

    public function handle($amount,$accounting_system_id)
    {
        $overtime_payroll_rules = OvertimePayrollRules::where('accounting_system_id', $accounting_system_id)->first();
        return $overtime_payroll_rules->holiday_weekend_rate*$amount;
    }
}
