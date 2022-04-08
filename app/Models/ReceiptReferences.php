<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptReferences extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'date',
        'type',
        'status',
        'is_void',
        'customer_id',
    ];
        
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
    public function bankReconciliation()
    {
        return $this->hasOne(BankReconciliations::class, 'journal_entry_id','id');
    }
    public function journalEntry()
    {
        return $this->hasOne(JournalEntries::class, 'model_reference_id','id');
    }
    public function receiptItems()
    {
        return $this->hasMany(ReceiptItem::class);
    }
}