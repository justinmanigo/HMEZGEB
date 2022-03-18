<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntries extends Model
{
    use HasFactory;

    public function journalPostings()
    {
        return $this->hasMany(JournalPostings::class, 'journal_entry_id','id');
    }
    public function journalVoucher()
    {
        return $this->hasOne(JournalVouchers::class, 'journal_entry_id','id');
    }
    public function bankReconciliation()
    {
        return $this->belongsTo(BankReconciliations::class, 'model_reference_id','id');
    }
    public function receiptReferences()
    {
        return $this->belongsTo(ReceiptReferences::class, 'model_reference_id','id');
    }
    public function paymentReferences()
    {
        return $this->belongsTo(PaymentReferences::class, 'model_reference_id','id');
    }
}
