<?php

namespace App\Models;

use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        // Main Fields
        'subscription_id',
        'calendar_type',
        'accounting_year',
        'name',
        'address',
        'po_box',
        'postal_code',
        'city',
        'country',
        'mobile_number',
        'telephone_1',
        'telephone_2',
        'fax',
        'website',
        'vat_number',
        'tin_number',
        'contact_person',
        'contact_person_position',
        'contact_person_mobile_number',
        'business_type',

        // Settings Inventory Type
        'settings_inventory_type',

        // Settings Defaults
        'receipt_cash_on_hand',
        'receipt_vat_payable',
        'receipt_sales',
        'receipt_account_receivable',
        'receipt_sales_discount',
        'receipt_withholding',

        'advance_receipt_cash_on_hand',
        'advance_receipt_advance_payment',

        'credit_receipt_cash_on_hand',
        'credit_receipt_account_receivable',

        'bill_cash_on_hand',
        'bill_items_for_sale',
        'bill_freight_charge_expense',
        'bill_vat_receivable',
        'bill_account_payable',
        'bill_withholding',

        'payment_cash_on_hand',
        'payment_vat_receivable',
        'payment_account_payable',
        'payment_withholding',
        'payment_salary_payable',
        'payment_commission_payment',

    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function accountingSystemUsers()
    {
        return $this->hasMany(AccountingSystemUser::class);
    }

    /**
     * Relationships from defaults
     */
    public function receiptCashOnHand()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'receipt_cash_on_hand');
    }

    public function receiptVatPayable()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'receipt_vat_payable');
    }

    public function receiptSales()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'receipt_sales');
    }

    public function receiptAccountReceivable()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'receipt_account_receivable');
    }

    public function receiptSalesDiscount()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'receipt_sales_discount');
    }

    public function receiptWithholding()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'receipt_withholding');
    }

    public function advanceReceiptCashOnHand()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'advance_receipt_cash_on_hand');
    }

    public function advanceReceiptAdvancePayment()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'advance_receipt_advance_payment');
    }

    public function creditReceiptCashOnHand()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'credit_receipt_cash_on_hand');
    }

    public function creditReceiptAccountReceivable()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'credit_receipt_account_receivable');
    }

    public function billCashOnHand()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'bill_cash_on_hand');
    }

    public function billItemsForSale()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'bill_items_for_sale');
    }

    public function billFreightChargeExpense()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'bill_freight_charge_expense');
    }

    public function billVatReceivable()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'bill_vat_receivable');
    }

    public function billAccountPayable()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'bill_account_payable');
    }

    public function billWithholding()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'bill_withholding');
    }

    public function paymentCashOnHand()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'payment_cash_on_hand');
    }

    public function paymentVatReceivable()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'payment_vat_receivable');
    }

    public function paymentAccountPayable()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'payment_account_payable');
    }

    public function paymentWithholding()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'payment_withholding');
    }

    public function paymentSalaryPayable()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'payment_salary_payable');
    }

    public function paymentCommissionPayment()
    {
        return $this->hasOne(ChartOfAccounts::class, 'id', 'payment_commission_payment');
    }
}
