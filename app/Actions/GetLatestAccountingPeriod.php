<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Settings\ChartOfAccounts\AccountingPeriods;

class GetLatestAccountingPeriod
{
    use AsAction;

    public function handle($accounting_system_id)
    {
        return AccountingPeriods::where('accounting_system_id', $accounting_system_id)
            ->latest()
            ->first();
    }
}
