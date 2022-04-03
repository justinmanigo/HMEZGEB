<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_id',
        'receipt_id',
        'quantity',
        'price',
        'total_price'
    ];

    public function receipt()
    {
        return $this->belongsTo(Receipts::class);
    }
}
