<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PensionPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference_id',
        'accounting_period_id',
        'chart_of_account_id',
        'cheque_number',
        'amount_received',
        'amount_words',
    ];

    public function payment_reference()
    {
        return $this->belongsTo(PaymentReference::class);
    }

    public function accounting_period()
    {
        return $this->belongsTo(AccountingPeriod::class);
    }

    public function chart_of_account()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
}
