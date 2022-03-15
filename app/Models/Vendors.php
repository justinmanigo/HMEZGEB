<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;

    
    public function bills()
    {
        return $this->hasMany(Bills::class, 'vendor_id','id');
    }
    public function billPayments()
    {
        return $this->hasMany(BillPayments::class, 'vendor_id','id');
    }
    public function vatPayments()
    {
        return $this->hasMany(VATPayments::class, 'vendor_id','id');
    }
    public function withholdingPayments()
    {
        return $this->hasMany(WithholdingPayments::class, 'vendor_id','id');
    }
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrders::class, 'vendor_id','id');
    }
}
