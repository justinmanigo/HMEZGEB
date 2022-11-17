<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PayrollPeriod;

class IncomeTaxPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference_id',
        'payroll_period_id',
        'total_paid',
        'cheque_number',
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

    public function payrollPeriod()
    {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id');
    }

}
