<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithholdingPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference_id',
        'accounting_period_id',
        'chart_of_account_id',
        'total_paid',
    ];
    
    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'payment_reference_id');
    }

    public function accountingPeriod()
    {
        return $this->belongsTo(AccountingPeriods::class, 'accounting_period_id');
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'chart_of_account_id');
    }
}
