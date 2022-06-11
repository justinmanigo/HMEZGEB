<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_id',
        'receipt_cash_transaction_id',
    ];

    public function deposit()
    {
        return $this->belongsTo(Deposits::class);
    }

    public function receiptReference()
    {
        return $this->belongsTo(ReceiptReferences::class);
    }
}
