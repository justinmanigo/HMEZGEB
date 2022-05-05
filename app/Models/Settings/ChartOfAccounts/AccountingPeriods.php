<?php

namespace App\Models\Settings\ChartOfAccounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingPeriods extends Model
{
    use HasFactory;

    public function periodOfAccounts()
    {
        return $this->hasMany(PeriodOfAccounts::class, 'accounting_period_id','id');
    }
    public function journalPostings()
    {
        return $this->hasMany(JournalPostings::class, 'chart_of_accounts_id','id');
    }
}
