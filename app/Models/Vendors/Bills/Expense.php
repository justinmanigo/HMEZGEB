<?php

namespace App\Models\Vendors\Bills;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentReferences;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Models\WithholdingPayments;
use App\Models\Vendors\Bills\ExpenseItem;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        // Auto-increment
        'payment_reference_id',

        // Foreign
        'withholding_payment_id',

        // Fields
        'reference_number',
        'total_amount_received',

        // Auto-generated Fields
        'sub_total',
        'discount',
        'tax',
        'grand_total',
        'withholding',
        'withholding_status',
        'payment_method',
    ];

    public function paymentReference()
    {
        return $this->belongsTo(PaymentReferences::class, 'payment_reference_id');
    }

    public function withholdingPayment()
    {
        return $this->belongsTo(WithholdingPayments::class, 'withholding_payment_id');
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'chart_of_account_id');
    }

    public function expenseItems()
    {
        return $this->hasMany(ExpenseItem::class, 'expense_id');
    }
}
