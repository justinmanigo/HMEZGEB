<?php

namespace App\Http\Requests\Customer\Receipt;

use App\Http\Requests\Api\FormRequest;

class StoreProformaRequest extends FormRequest
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
            // 'withholding' => ['required', 'numeric'],
            // 'taxable' => ['required', 'numeric'],
            'terms_and_condition' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
            // 'commission_agent' => ['sometimes'],
            // 'revenue_type' => ['required'],
            // 'payment_type' => ['required'],
            'grand_total' => ['required', 'numeric', 'min:0'],
            // 'total_amount_received' => ['required', 'numeric', 'min:0'],
        ];
    }
}
