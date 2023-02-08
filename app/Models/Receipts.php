<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipts extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_reference_id',
        'proforma_id',
        'receipt_number',
        'due_date',
        'sub_total',
        'discount',
        'tax',
        'grand_total',
        'withholding',
        'remark',
        'attachment',
        'payment_method',
        'total_amount_received',
        'employee_id', // commission agent
    ];
    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'receipt_reference_id');
    }
    public function proforma()
    {
        return $this->belongsTo(Proformas::class, 'proforma_id');
    }
}
