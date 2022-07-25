<?php

namespace App\Actions\Hr\Payroll;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Settings\PayrollRules\OvertimePayrollRules;

class NightRate
{
    use AsAction;

    public function handle($amount,$accounting_system_id)
    {
        $overtime_payroll_rules = OvertimePayrollRules::where('accounting_system_id', $accounting_system_id)->first();
        return $overtime_payroll_rules->night_rate*$amount;
    }
}
