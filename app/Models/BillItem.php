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
}
