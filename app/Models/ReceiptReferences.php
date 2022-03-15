<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptReferences extends Model
{
    use HasFactory;

        
    public function receipt()
    {
        return $this->hasOne(Receipts::class, 'receipt_reference_id','id');
    }
    public function proforma()
    {
        return $this->hasOne(Proformas::class, 'receipt_reference_id','id');
    }
    public function receiptCashTransactions()
    {
        return $this->hasMany(ReceiptCashTransactions::class, 'receipt_reference_id','id');
    }
    public function advanceRevenue()
    {
        return $this->hasOne(AdvanceRevenues::class, 'receipt_reference_id','id');
    }
    public function creditReceipt()
    {
        return $this->hasOne(CreditReceipts::class, 'receipt_reference_id','id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}