<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankReconciliatation extends Model
{
    use HasFactory;

    public function journalEntry()
    {
        return $this->hasOne(JournalEntries::class, 'model_reference_id','id');
    }
}
