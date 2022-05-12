<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\JournalEntries;

class PaymentReferences extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'type',
        'date',
        'attachment',
        'remark',
        'status',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendors::class, 'vendor_id','id');
    }

    // public function employee()
    // {
    //     return $this->belongsTo(Employees::class, 'employee_id','id');
    // }

    public function purchaseOrders()
    {
        return $this->hasOne(PurchaseOrders::class, 'payment_reference_id','id');
    }

    public function bills()
    {
        return $this->hasOne(Bills::class, 'payment_reference_id','id');
    }

    public function billPayment()
    {
        return $this->hasOne(BillPayments::class, 'payment_reference_id','id');
    }

    public function vatPayment()
    {
        return $this->hasOne(VATPayments::class, 'payment_reference_id','id');
    }

    public function withholdingPayment()
    {
        return $this->hasOne(WithholdingPayments::class, 'payment_reference_id','id');
    }

    public function incomeTaxPayment()
    {
        return $this->hasOne(IncomeTaxPayments::class, 'payment_reference_id','id');
    }

    public function pensionPayment()
    {
        return $this->hasOne(PensionPayments::class, 'payment_reference_id','id');
    }

    public function payrollPayment()
    {
        return $this->hasOne(PayrollPayments::class, 'payment_reference_id','id');
    }

    public function journalEntry()
    {
        return $this->hasOne(JournalEntries::class, 'model_reference_id','id');
    }



    
}
