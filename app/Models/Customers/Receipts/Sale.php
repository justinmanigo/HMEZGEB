<?php

namespace App\Models\Customers\Receipts;

use App\Models\ReceiptReferences;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_reference_id',
        'reference_number',
        'price',
        'amount_received',
        'tax',
        'withholding',
        'sub_total',
        'grand_total',
        'terms_and_condition',
        'remark',
        'attachment',
    ];

    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'receipt_reference_id');
    }
}
