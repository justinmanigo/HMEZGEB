<?php

namespace App\Http\Requests\Customer\Receipt;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;
use App\Models\AccountingSystem;
use App\Models\Inventory;

class StoreReceiptRequest extends FormRequest
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
            'customer' => ['required'],
            'date' => ['required', 'date'],
            'proforma' => ['sometimes'],
            'due_date' => ['sometimes'],
            // 'account' => ['required'],
            'item' => ['required', 'array'],
            'item.*' => ['required'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric', 'min:1'],
            // 'tax' => ['required', 'array'],
            // 'tax.*' => ['required'],
            'sub_total' => ['required', 'numeric', 'min:0'],
            // 'discount' => ['required', 'numeric'],
            'withholding' => ['sometimes', 'numeric', 'min:0'],
            'withholding_check' => ['sometimes'],
            // 'taxable' => ['required', 'numeric'],
            'tax_total' => ['required', 'numeric', 'min:0'],
            'grand_total' => ['required', 'numeric', 'min:0'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
            // 'commission_agent' => ['sometimes'],
            // 'revenue_type' => ['required'],
            // 'payment_type' => ['required'],
            'grand_total' => ['required', 'numeric', 'min:0'],
            'total_amount_received' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function prepareForValidation()
    {        
        for($i = 0; $i < count($this->item); $i++) {
            if($this->item[$i] != null) {
                $item[] = DecodeTagifyField::run($this->item[$i]);
                if($this->tax[$i] != null) {
                    $tax[] = DecodeTagifyField::run($this->tax[$i]);
                }
                else {
                    $tax[] = null;
                }
            }
        }

        $accounting_system = AccountingSystem::find(session('accounting_system_id'));

        $this->merge([
            'customer' => DecodeTagifyField::run($this->customer),
            'item' => isset($item) ? $item : [],
            'proforma' => $this->proforma != null ? DecodeTagifyField::run($this->proforma) : null,
            'tax' => isset($tax) ? $tax : [],

            // Merge COA defaults to request
            'receipt_cash_on_hand' => $accounting_system->receipt_cash_on_hand,
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
            $input_items = $this->get('item');
            $input_quantities = $this->get('quantity');

            for($i = 0; $i < count($input_items); $i++)
            {
                $inventory_item = Inventory::find($input_items[$i]->value);
                
                if($inventory_item->inventory_type == 'inventory_item' && $input_quantities[$i] > $inventory_item->quantity)
                {
                    $validator->errors()->add("quantity.{$i}", "The remaining stocks of item {$input_items[$i]->name} is not enough. Remaining stocks: {$inventory_item->quantity}");
                }
            }

            // Check if either of the COA defaults is blank.
            if($this->get('receipt_cash_on_hand') == null)
            {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Cash on Hand. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('receipt_vat_payable') == null)
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

            // Check in case of withholding more than sub_total
            if($this->get('withholding_check') != null && $this->get('withholding') > $this->get('sub_total')) {
                $validator->errors()->add('withholding', 'Please enter a valid withholding amount. It should not be more than the sub total.');
            }
            // Check in case of withholding more than total_amount_received
            if($this->get('withholding_check') != null && $this->get('withholding') > $this->get('total_amount_received')) {
                $validator->errors()->add('withholding', 'Please enter a valid withholding amount. It should not be more than the total amount received.');
            }
        });
    }
}
