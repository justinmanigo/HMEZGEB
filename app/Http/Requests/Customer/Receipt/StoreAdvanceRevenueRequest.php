<?php

namespace App\Http\Requests\Customer\Receipt;

use App\Http\Requests\Api\FormRequest;

class StoreAdvanceRevenueRequest extends FormRequest
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
            // 'account' => ['required'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
            'amount_received' => ['required', 'numeric', 'min:1'],
            'reason' => ['sometimes'],
        ];
    }
}
