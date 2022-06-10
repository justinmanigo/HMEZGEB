<?php

namespace App\Http\Requests\Customer\Deposit;

use App\Http\requests\Api\FormRequest;
use App\Actions\DecodeTagifyField;

class StoreDepositRequest extends FormRequest
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
            'deposit_ticket_date' => ['required', 'date'],
            'bank_account' => ['required'],
            'is_deposited' => ['required', 'array'],
            'remark' => ['nullable'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'bank_account' => DecodeTagifyField::run($this->bank_account),
        ]);
    }

    // Custom error messages
    public function messages()
    {
        return [
            'deposit_ticket_date.required' => 'The deposit ticket date is required.',
            'deposit_ticket_date.date' => 'The deposit ticket date must be a valid date.',
            'bank_account.required' => 'The bank account is required.',
            'is_deposited.required' => 'Select at least one fully paid receipt to deposit.',
            'is_deposited.array' => 'The is deposited must be an array.',
        ];
    }
}
