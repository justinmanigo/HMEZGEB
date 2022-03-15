<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceRevenues extends Model
{
    use HasFactory;

    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'receipt_reference_id');
    }
}
