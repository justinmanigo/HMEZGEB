<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference_id',
        'order_number',
        'due_date',
        'sub_total',
        'tax',
        'grand_total',
    ];

    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'payment_reference_id');
    }

    
}
