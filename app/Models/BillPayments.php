<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference_id',
        'payment_reference_number',
        'chart_of_account_id',
        'cheque_number',
        'amount_paid',
        'discount_account_number',
    ];

    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'payment_reference_id');
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'chart_of_account_id');
    }
}
