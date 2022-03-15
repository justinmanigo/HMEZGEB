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
}
