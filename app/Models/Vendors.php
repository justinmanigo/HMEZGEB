<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'name',
        'tin_number',
        'address',
        'city',
        'country',
        'mobile_number',
        'telephone_one',
        'telephone_two',
        'website',
        'email',
        'contact_person',
        'label',
        'image',
        'is_active',
        'fax',
    ];

    public function PaymentReferences()
    {
        return $this->hasOne(PaymentReferences::class, 'vendor_id','id');
    }
}
