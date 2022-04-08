<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_id',
        'receipt_reference_id',
        'quantity',
        'price',
        'total_price'
    ];

    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class);
    }
}
