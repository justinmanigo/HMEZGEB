<?php

namespace App\Http\Requests\Subscription;

use App\Http\Requests\Api\FormRequest;

class AddAccountingSystemAccessRequest extends FormRequest
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
            'accounting_systems' => ['required', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'accounting_systems.required' => 'Please select at least one accounting system.',
            'accounting_systems.array' => 'Please select at least one accounting system.',
        ];
    }
}
