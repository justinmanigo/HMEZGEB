<?php

namespace App\Models\Settings\ChartOfAccounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BankAccounts;

class ChartOfAccounts extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'accounting_system_id',
        'chart_of_account_category_id',
        'chart_of_account_no',
        'account_name',
        'current_balance',
        'status',
    ];

    public function journalPostings()
    {
        return $this->hasMany(JournalPostings::class, 'chart_of_accounts_id','id');
    }
    public function periodOfAccounts()
    {
        return $this->hasMany(PeriodOfAccounts::class, 'chart_of_accounts_id','id');
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccounts::class, 'id','chart_of_accounts_id');
    }

    public function category()
    {
        return $this->hasOne(ChartOfAccountCategory::class, 'id','chart_of_account_category_id');
    }

    public function deposits()
    {
        return $this->hasMany(Deposits::class, 'chart_of_account_id','id');
    }

}
