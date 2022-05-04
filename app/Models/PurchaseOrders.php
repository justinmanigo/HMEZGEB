<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference_id',
        'due_date',
        'sub_total',
        'tax',
        'grand_total',
    ];

    
    public function bills()
    {
        return $this->hasOne(Bills::class, 'purchase_order_id','id');
    }
    
    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'payment_reference_id');
    }


    
}
