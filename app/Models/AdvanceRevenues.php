<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceRevenues extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_reference_id',
        'advance_revenue_number',
        'total_amount_received',
        'reason',
        'remark',
        'attachment',
    ];

    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class, 'receipt_reference_id');
    }
}
