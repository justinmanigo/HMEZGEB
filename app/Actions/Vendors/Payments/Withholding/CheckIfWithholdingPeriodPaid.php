<?php

namespace App\Actions\Vendors\Payments\Withholding;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class CheckIfWithholdingPeriodPaid
{
    use AsAction;

    public function handle($date)
    {
        // DB Withholding Payments
        // Left Join Payment References
        // Left Join Accounting Period

        return DB::table('withholding_payments')
            ->leftJoin('payment_references', 'withholding_payments.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('accounting_periods', 'withholding_payments.accounting_period_id', '=', 'accounting_periods.id')
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->where(function ($query) use ($date) {
                $query->where('accounting_periods.date_to', '>=', $date)
                    ->where('accounting_periods.date_from', '<=', $date);
            })
            ->count() ? true : false;
    }
}
