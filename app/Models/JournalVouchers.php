<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\JournalEntries;

class JournalVouchers extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_entry_id',
        'reference_number',
        'accounting_system_id',
    ];

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntries::class, 'journal_entry_id');
    }   

    public function accountingSystem()
    {
        return $this->belongsTo(AccountingSystem::class, 'accounting_system_id');
    }
}
