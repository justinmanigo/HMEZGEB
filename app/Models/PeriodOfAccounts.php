<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodOfAccounts extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'chart_of_account_id',
        'accounting_period_id',
        'beginning_balance',
        'closing_balance',
    ];

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'chart_of_accounts_id');
    }
    public function accountingPeriod()
    {
        return $this->belongsTo(AccountingPeriods::class, 'accounting_period_id');
    }
}
