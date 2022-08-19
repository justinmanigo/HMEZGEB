<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BillItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'inventory_id',
        'payment_reference_id',
        'quantity',
        'price',
        'total_price',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'payment_reference_id', 'id');
    }
}
