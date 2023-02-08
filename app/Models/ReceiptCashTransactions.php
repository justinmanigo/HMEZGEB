<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptCashTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'chart_of_account_id', // where the cash is headed to
        'receipt_reference_id',
        'for_receipt_reference_id',
        'amount_received',
    ];

    public function depositItem()
    {
        return $this->hasOne(DepositItems::class, 'receipt_cash_transaction_id');
    }
    
    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'receipt_reference_id');
    }
    public function forReceiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'for_receipt_reference_id');
    }
}
