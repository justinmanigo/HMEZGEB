<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;
        
    protected $fillable = [
        'payment_reference_id',
        'withholding_payment_id',
        'bill_number',
        'purchase_order_number',
        'due_date',
        'chart_of_account_id',
        'sub_total',
        'discount',
        'tax',
        'grand_total',
        'withholding',
        'payment_method',
        'amount_received',
    ];
        public function paymentReference()
        {
            return $this->belongsTo(PaymentReferences::class, 'payment_reference_id');
        }
        
        public function withholdingPayment()
        {
            return $this->belongsTo(WithholdingPayments::class, 'withholding_payment_id');
        }

        public function chartOfAccount()
        {
            return $this->belongsTo(ChartOfAccounts::class, 'chart_of_account_id');
        }
}
