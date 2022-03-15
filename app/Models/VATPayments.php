<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VATPayments extends Model
{
    use HasFactory;

    public function vendor()
    {
        return $this->belongsTo(Vendors::class, 'vendor_id');
    }
    
    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'payment_reference_id');
    }
}
