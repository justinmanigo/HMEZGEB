<?php

namespace App\Models\Settings\ChartOfAccounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingPeriods extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'date_from',
        'date_to',
        'date_from_ethiopian',
        'date_to_ethiopian',
    ];

    public function periodOfAccounts()
    {
        return $this->hasMany(PeriodOfAccounts::class, 'accounting_period_id','id');
    }
    public function journalPostings()
    {
        return $this->hasMany(JournalPostings::class, 'chart_of_accounts_id','id');
    }
}
