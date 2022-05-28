<?php

namespace App\Http\Requests\Customer\Receipt;

use App\Http\Requests\Api\FormRequest;

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

    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            $c = 0;
            // dd($this->get('is_paid'));
            $is_paid = $this->get('is_paid');
            $receipt_reference_id = $this->get('receipt_reference_id');
            $amount_paid = $this->get('amount_paid');
            for($i = 0; $i < count($receipt_reference_id); $i++)
            {
                // See if the iterated receipt's checkmark is checked.
                if(!in_array($receipt_reference_id[$i], $is_paid)) continue;

                // If it is checked, is the amount paid less than 0?
                if(in_array($receipt_reference_id[$i], $is_paid) && $amount_paid[$i] <= 0) {
                    $validator->errors()->add("amount_paid.{$i}", 'Amount paid must be greater than 0.');
                    continue;
                }

                $c++;
            }

            if($c == 0)
            {
                $validator->errors()->add('total_received', 'Please select at least one item and place an amount to be paid.');
            }
        });
    }
}
