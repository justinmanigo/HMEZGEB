<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proformas extends Model
{
    use HasFactory;

    public function receipts()
    {
        return $this->hasOne(Proformas::class, 'proforma_id','id');
    }
    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'receipt_reference_id');
    }
    
}
