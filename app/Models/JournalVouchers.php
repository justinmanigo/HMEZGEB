<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalVouchers extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_entry_id',
        'reference_number'
    ];

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntries::class, 'journal_entry_id');
    }   
}
