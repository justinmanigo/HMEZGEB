<?php

namespace App\Actions\Hr;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class IsAccountingPeriodLocked
{
    use AsAction;

    public function handle($date)
    {
        return DB::table('payrolls')
            ->leftJoin('payroll_periods', 'payroll_periods.period_id', '=', 'payrolls.payroll_period_id')
            ->leftJoin('accounting_periods', 'accounting_periods.id', '=', 'payroll_periods.period_id')
            ->where('payrolls.accounting_system_id', session('accounting_system_id'))
            ->where('accounting_periods.date_from', '<=', $date)
            ->where('accounting_periods.date_to', '>=', $date)
            ->count();
    }
}
