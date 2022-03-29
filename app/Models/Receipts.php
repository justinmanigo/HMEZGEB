<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipts extends Model
{
    use HasFactory;

    
    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'receipt_reference_id');
    }
    public function proforma()
    {
        return $this->belongsTo(Proformas::class, 'proforma_id');
    }

    public function receiptItems()
    {
        return $this->hasMany(ReceiptItem::class);
    }
}
