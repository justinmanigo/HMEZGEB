<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;

class StoreBeginningBalanceRequest extends FormRequest
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
            'debit_coa_id' => ['required', 'array'],
            'credit_coa_id' => ['required', 'array'],
            'debit_amount' => ['required', 'array'],
            'debit_amount.*' => ['required'],
            'credit_amount' => ['required', 'array'],
            'credit_amount.*' => ['required'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $sum_debits = 0; 
            $sum_credits = 0;

            foreach($this->get('debit_amount') as $amount) {
                $sum_debits += intval($amount);
            }

            foreach($this->get('credit_amount') as $amount) {
                $sum_credits += intval($amount);
            }

            if($sum_debits != $sum_credits) {
                $validator->errors()->add("sum", 'The sum of debits and credits must match.');
            }
        });
    }
}
