<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
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
        'telephone_two',
        'fax',
        'website',
        'email',
        'contact_person',
        'image',
        'label',
        'is_active'
    ];

    public function receiptReference()
    {
        return $this->hasOne(ReceiptReferences::class, 'customer_id','id');
        
    }
}
