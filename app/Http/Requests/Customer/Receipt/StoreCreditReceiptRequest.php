<?php

namespace App\Http\Requests\Customer\Receipt;

use App\Http\Requests\Api\FormRequest;
use App\Models\AccountingSystem;

class StoreCreditReceiptRequest extends FormRequest
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
            'receipt_reference_id' => ['required', 'array'],
            'receipt_reference_id.*' => ['required'],
            // 'date_due' => ['required', 'array'],
            // 'date_due.*' => ['required', 'date'],
            'amount_due' => ['required', 'array'],
            'amount_due.*' => ['required', 'numeric', 'min:1'],
            // 'description' => ['sometimes', 'array'],
            // 'description.*' => ['sometimes'],
            'discount' => ['sometimes', 'array'],
            'discount.*' => ['nullable', 'numeric'],
            'amount_paid' => ['sometimes', 'array'],
            'amount_paid.*' => ['nullable', 'numeric'],
            'is_paid' => ['required', 'array'],
            // 'account' => ['required'],
            // 'item' => ['required', 'array'],
            // 'item.*' => ['required'],
            // 'quantity' => ['required', 'array'],
            // 'quantity.*' => ['required', 'numeric', 'min:1'],
            // 'tax' => ['required', 'array'],
            // 'tax.*' => ['required'],
            'total_received' => ['required', 'numeric', 'min:1'],
            // 'discount' => ['required', 'numeric'],
            // 'withholding' => ['required', 'numeric'],
            // 'taxable' => ['required', 'numeric'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
            // 'discount_account' => ['sometimes'],
            // 'discount_account_id' => ['sometimes'],
            // 'revenue_type' => ['required'],
            // 'payment_type' => ['required'],
            // 'grand_total' => ['required', 'numeric', 'min:0'],
            // 'total_amount_received' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function prepareForValidation()
    {
        $accounting_system = AccountingSystem::find(session('accounting_system_id'));

        $this->merge([
            'credit_receipt_cash_on_hand' => $accounting_system->credit_receipt_cash_on_hand,
            'credit_receipt_account_receivable' => $accounting_system->credit_receipt_account_receivable,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            $c = 0;
            // dd($this->get('is_paid'));
            $is_paid = $this->get('is_paid');
            $receipt_reference_id = $this->get('receipt_reference_id');
            $amount_paid = $this->get('amount_paid');

            if(isset($receipt_reference_id))
            {
                for($i = 0; $i < count($receipt_reference_id); $i++)
                {
                    // See if the iterated receipt's checkmark is checked.
                    if(isset($is_paid) && !in_array($receipt_reference_id[$i], $is_paid)) continue;
    
                    // If it is checked, is the amount paid less than 0?
                    if(isset($is_paid) &&  in_array($receipt_reference_id[$i], $is_paid) && $amount_paid[$i] <= 0) {
                        $validator->errors()->add("amount_paid.{$i}", 'Amount paid must be greater than 0.');
                        continue;
                    }
    
                    $c++;
                }
    
                if($c == 0)
                {
                    $validator->errors()->add('total_received', 'Please select at least one item and place an amount to be paid.');
                }
            }

            if(!$this->get('credit_receipt_cash_on_hand')) {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Cash on Hand. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if(!$this->get('credit_receipt_account_receivable')) {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Account Receivable. Please make sure that everything is set at `Settings > Defaults`');
            }
        });
    }
}
