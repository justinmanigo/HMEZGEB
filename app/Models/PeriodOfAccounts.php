<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodOfAccounts extends Model
{
    use HasFactory;

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'chart_of_accounts_id');
    }
    public function accountingPeriod()
    {
        return $this->belongsTo(AccountingPeriods::class, 'accounting_period_id');
    }
}
