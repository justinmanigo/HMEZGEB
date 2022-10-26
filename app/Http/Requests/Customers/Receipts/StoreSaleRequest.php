<?php

namespace App\Http\Requests\Customers\Receipts;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;
use App\Models\AccountingSystem;

class StoreSaleRequest extends FormRequest
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

        $this->merge([
            'cash_account' => DecodeTagifyField::run($this->cash_account),
            'tax' => DecodeTagifyField::run($this->tax),

            // Merge COA defaults to request
            'receipt_vat_payable' => $accounting_system->receipt_vat_payable,
            'receipt_sales' => $accounting_system->receipt_sales,
            'receipt_account_receivable' => $accounting_system->receipt_account_receivable,
            'receipt_sales_discount' => $accounting_system->receipt_sales_discount,
            'receipt_withholding' => $accounting_system->receipt_withholding,

            'as_business_type' => $accounting_system->business_type,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator){
            // Check if either of the COA defaults is blank.
            // if($this->get('receipt_cash_on_hand') == null)
            // {
            //     $validator->errors()->add('customer', 'You haven\'t set the default COA for Cash on Hand. Please make sure that everything is set at `Settings > Defaults`');
            // }
            if($this->get('receipt_vat_payable') == null)
            {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for VAT Payable. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('receipt_sales') == null)
            {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Sales. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('receipt_account_receivable') == null)
            {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Account Receivable. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('receipt_sales_discount') == null)
            {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Sales Discount. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('receipt_withholding') == null)
            {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Withholding. Please make sure that everything is set at `Settings > Defaults`');
            }

            // if($this->get('as_business_type') == 'PLC' && $this->get('withholding_check') == null) {
            //     $validator->errors()->add('total_amount_received', 'Withholding is required for a Private Limited Company. Kindly check to proceed.');
            // }

            // Check if total amount received is more than or equal to withholding
            // if($this->get('withholding_check') != null && $this->get('total_amount_received') < $this->get('withholding')) {
            //     $validator->errors()->add('total_amount_received', 'You have enabled withholding for this receipt. Please pay at least the withholding amount to proceed.');
            // }

            if($this->get('discount_amount') > $this->get('price_amount')) {
                $validator->errors()->add('discount_amount', 'Please enter a valid discount amount. It should not be more than the price amount.');
            }

            // Check in case of withholding more than price_amount
            if($this->get('withholding_check') != null && $this->get('withholding_amount') > $this->get('price_amount')) {
                $validator->errors()->add('withholding', 'Please enter a valid withholding amount. It should not be more than the price amount.');
            }
            if($this->get('withholding_check') != null && $this->get('discount_amount') + $this->get('withholding') > $this->get('price_amount')) {
                $validator->errors()->add('withholding', 'Total of Withholding and Discount should not be more than the price amount.');
            }
            // Check in case of withholding more than total_amount_received
            if($this->get('withholding_check') != null && $this->get('withholding_amount') > $this->get('total_amount_received')) {
                $validator->errors()->add('withholding', 'Please enter a valid withholding amount. It should not be more than the total amount received.');
            }
        });
    }
}
