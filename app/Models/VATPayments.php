<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VATPayments extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'payment_reference_id',
        'payment_reference_number',
        'accounting_period_id',
        'chart_of_account_id',
        'type',
        'previous_period_vat_payable',
        'current_period_vat_payable',
        'current_period_vat_receivable',
        'current_receivable',
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
