<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\JournalEntries;

class DepositItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'deposit_id',
        'receipt_cash_transaction_id',
        'journal_entry_id',
        'is_void',
    ];

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntries::class);
    }

    public function deposit()
    {
        return $this->belongsTo(Deposits::class);
    }

    public function receiptCashTransaction()
    {
        return $this->belongsTo(ReceiptCashTransactions::class);
    }
}
