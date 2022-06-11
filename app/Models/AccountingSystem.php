<?php

namespace App\Models;

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
        'receipt_default_cash_on_hand',
        'receipt_default_vat_payable',
        'receipt_default_sales',
        'receipt_default_account_receivable',
        'receipt_default_sales_discount',
        'receipt_default_withholding',

        'advance_receipt_default_cash_on_hand',
        'advance_receipt_default_advance_payment',

        'credit_receipt_default_cash_on_hand',
        'credit_receipt_default_account_receivable',

        'bill_default_cash_on_hand',
        'bill_default_items_for_sale',
        'bill_default_freight_charge_expense',
        'bill_default_vat_receivable',
        'bill_default_account_payable',
        'bill_default_withholding',

    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function accountingSystemUsers()
    {
        return $this->hasMany(AccountingSystemUser::class);
    }
}
