<?php

namespace App\Models\Vendors\Bills;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentReferences;

class CostOfGoodsSold extends Model
{
    use HasFactory;

    protected $table = 'cost_of_goods_sold';

    protected $fillable = [
        'payment_reference_id',
        'reference_number',
        'price',
        'amount_received',
        'tax',
        'withholding',
        'discount',
        'sub_total',
        'grand_total',
        'terms_and_condition',
        'remark',
        'attachment',
    ];

    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'payment_reference_id');
    }
}
