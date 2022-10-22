<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendors;
use App\Models\PayrollPeriod;
use App\Models\PaymentReferences;

class PayrollPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference_id',
        'payroll_period_id',
        'total_paid',
        'cheque_number',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendors::class, 'vendor_id');
    }

    public function payrollPeriod()
    {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id');
    }
    
    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'payment_reference_id');
    }
}
