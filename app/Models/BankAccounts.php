<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;

class BankAccounts extends Model
{
    use HasFactory;

    protected $fillable = [
        'chart_of_account_id',
        'bank_branch',
        'bank_account_number',
        'bank_account_type',
    ];
    
    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'chart_of_account_id','id');
    }
}
