<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;

class Deposits extends Model
{
    use HasFactory;

    protected $fillable = [
        'chart_of_account_id',
        'deposit_ticket_date',
        'total_amount',
        'status',
        'remark',
    ];

    public function depositItems()
    {
        return $this->hasMany(DepositItems::class);
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class);
    }


}
