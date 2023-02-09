<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;

class Deposits extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'chart_of_account_id',
        'deposit_ticket_date',
        'remark',
        'reference_number',
        'is_direct_deposit',
    ];

    public function depositItems()
    {
        return $this->hasMany(DepositItems::class, 'deposit_id', 'id');
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class);
    }


}
