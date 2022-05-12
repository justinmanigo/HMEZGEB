<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tin_number',
        'address',
        'city',
        'country',
        'mobile_number',
        'telephone_one',
        'website',
        'email',
        'contact_person',
        'label',
        'image',
        'is_active',
    ];

    public function PaymentReferences()
    {
        return $this->hasOne(PaymentReferences::class, 'vendor_id','id');
    }
}
