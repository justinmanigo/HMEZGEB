<?php

namespace App\Models\Settings\ChartOfAccounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JournalVouchers;
use App\Models\BankReconciliatation;
use App\Models\ReceiptReferences;
use App\Models\PaymentReferences;

class JournalEntries extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'date',
        'notes',
    ];

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
        return $this->belongsTo(BankReconciliatation::class, 'model_reference_id','id');
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
