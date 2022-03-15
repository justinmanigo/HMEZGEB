<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccounts extends Model
{
    use HasFactory;
    

    public function journalPostings()
    {
        return $this->hasMany(JournalPostings::class, 'chart_of_accounts_id','id');
    }
    public function periodOfAccounts()
    {
        return $this->hasMany(PeriodOfAccounts::class, 'chart_of_accounts_id','id');
    }
}
