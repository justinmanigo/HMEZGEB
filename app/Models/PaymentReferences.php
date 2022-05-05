<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\JournalEntries;

class PaymentReferences extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'cheque_number',
        'remark',
        'attachment',
        // 'customer_id',
    ];

    public function billPayment()
    {
        return $this->hasOne(BillPayments::class, 'payment_reference_id','id');
    }
    public function vatPayment()
    {
        return $this->hasOne(VatPayment::class, 'payment_reference_id','id');
    }
    public function withholdingPayment()
    {
        return $this->hasOne(WithholdingPayments::class, 'payment_reference_id','id');
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
