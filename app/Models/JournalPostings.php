<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalPostings extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_entry_id',
        'chart_of_account_id',
        'accounting_period_id',
        'type',
        'amount',
        'updated_balance',
    ];

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'chart_of_accounts_id');
    }
    public function accountingPeriod()
    {
        return $this->belongsTo(AccountingPeriods::class, 'accounting_period_id');
    }
    public function journalEntry()
    {
        return $this->belongsTo(JournalEntries::class, 'journal_entry_id');
    }
    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'model_reference_id');
    }
    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'model_reference_id');
    }
    // Bank_Reconciliations not yet added
    // public function bankReconciliations()
    // {
    //     return $this->belongsTo(JournalEntries::class, 'journal_entry_id');
    // }
}
