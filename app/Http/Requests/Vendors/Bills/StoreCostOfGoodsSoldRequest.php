<?php

namespace App\Http\Requests\Vendors\Bills;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Models\AccountingSystem;
use App\Actions\Vendors\Payments\Withholding\CheckIfWithholdingPeriodPaid;

class StoreCostOfGoodsSoldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Details
            'cash_account' => ['required'],
            'date' => ['required'],
            'reference_number' => ['sometimes'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
            // Transaction
            'price_amount' => ['required', 'numeric', 'min:0'],
            'tax' => ['sometimes'],
            'tax_amount' => ['sometimes', 'min:0'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'sub_total' => ['required', 'numeric', 'min:0'],
            'grand_total' => ['required', 'numeric', 'min:0'],
            // Payment
            'total_amount_received' => ['required', 'numeric', 'min:0'],
            'withholding_check' => ['sometimes'],
            'withholding_amount' => ['sometimes', 'numeric', 'min:0'],
        ];
    }



    protected function prepareForValidation()
    {
        $accounting_system = AccountingSystem::find(session('accounting_system_id'));

        // Query 5110 - Cost of Goods Sold [Temporary]
        $cost_of_goods_sold = ChartOfAccounts::where('chart_of_account_no', '5100')
            ->where('accounting_system_id', session('accounting_system_id'))
            ->first();

        $this->merge([
            'cash_account' => DecodeTagifyField::run($this->cash_account),
            'tax' => DecodeTagifyField::run($this->tax),

            // Merge COA defaults to request
            'bill_cash_on_hand' => $accounting_system->bill_cash_on_hand,
            'bill_items_for_sale' => $accounting_system->bill_items_for_sale,
            'bill_freight_charge_expense' => $accounting_system->bill_freight_charge_expense,
            'bill_vat_receivable' => $accounting_system->bill_vat_receivable,
            'bill_account_payable' => $accounting_system->bill_account_payable,
            'bill_withholding' => $accounting_system->bill_withholding,

            // Temporarily query COGS account from COA
            'bill_cost_of_goods_sold' => $cost_of_goods_sold,

            // Temporarily borrow sales discount from receipts
            'receipt_sales_discount' => $accounting_system->receipt_sales_discount,

        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check if either of the COA defaults is blank.
            // if($this->get('bill_cash_on_hand') == null)
            // {
            //     $validator->errors()->add('vendor', 'You haven\'t set the default COA for Cash on Hand. Please make sure that everything is set at `Settings > Defaults`');
            // }
            if($this->get('bill_items_for_sale') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Items for Sale. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('bill_freight_charge_expense') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Freight Charge Expense. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('bill_vat_receivable') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for VAT Receivable. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('bill_account_payable') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Account Payable. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('bill_withholding') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Withholding. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('receipt_sales_discount') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Sales Discount. Please make sure that everything is set at `Settings > Defaults` [Receipts]');
            }

            if($this->get('discount_amount') > $this->get('price_amount')) {
                $validator->errors()->add('discount_amount', 'Please enter a valid discount amount. It should not be more than the price amount.');
            }

            // Check in case of withholding more than price_amount
            if($this->get('withholding_check') != null && $this->get('withholding_amount') > $this->get('price_amount')) {
                $validator->errors()->add('withholding', 'Please enter a valid withholding amount. It should not be more than the price amount.');
            }
            // Check in case of withholding more than total_amount_received
            if($this->get('withholding_check') != null && $this->get('withholding_amount') > $this->get('total_amount_received')) {
                $validator->errors()->add('withholding', 'Please enter a valid withholding amount. It should not be more than the total amount received.');
            }

            // Check if withholding period of $request->date is already paid
            if(CheckIfWithholdingPeriodPaid::run($this->get('date'))) {
                $validator->errors()->add('date', 'The withholding payment for the date\'s period has already been made.');
            }
        });
    }

}
