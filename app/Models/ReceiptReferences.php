<?php

namespace App\Models;

use App\Models\Customers\Receipts\Sale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\JournalEntries;

class ReceiptReferences extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'journal_entry_id',
        'reference_number',
        'date',
        'type',
        'status',
        'is_void',
        'customer_id',
    ];
        
    public function sale()
    {
        return $this->hasOne(Sale::class, 'receipt_reference_id','id');
    }

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
        return $this->belongsTo(Customers::class, 'customer_id','id');
    }
    public function bankReconciliation()
    {
        return $this->hasOne(BankReconciliations::class, 'journal_entry_id','id');
    }
    public function journalEntry()
    {
        return $this->hasOne(JournalEntries::class, 'id', 'journal_entry_id');
    }
    public function receiptItems()
    {
        return $this->hasMany(ReceiptItem::class, 'receipt_reference_id', 'id');
    }

    public function depositItems()
    {
        return $this->hasMany(DepositItems::class, 'receipt_reference_id','id');
    }
}