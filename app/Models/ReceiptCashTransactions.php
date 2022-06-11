<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptCashTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'receipt_reference_id',
        'for_receipt_reference_id',
        'amount_received',
        'is_deposited',
    ];

    
    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'receipt_reference_id');
    }
    public function forReceiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'receipt_reference_id');
    }
}
