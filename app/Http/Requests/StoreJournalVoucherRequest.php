<?php

namespace App\Http\Requests;

use App\Http\requests\Api\FormRequest;
use App\Actions\DecodeTagifyField;

class StoreJournalVoucherRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'debit_accounts' => ['required', 'array'],
            'debit_accounts.*' => ['required'],
            'debit_description' => ['required', 'array'],
            'debit_description.*' => ['required'],
            'debit_amount' => ['required', 'array'],
            'debit_amount.*' => ['required', 'numeric', 'min:1'],
            'credit_accounts' => ['required', 'array'],
            'credit_accounts.*' => ['required'],
            'credit_description' => ['required', 'array'],
            'credit_description.*' => ['required'],
            'credit_amount' => ['required', 'array'],
            'credit_amount.*' => ['required', 'numeric', 'min:1'],
            'notes' => ['nullable'],
        ];
    }

    protected function prepareForValidation()
    {
        for($i = 0; $i < count($this->debit_accounts); $i++) {
            if($this->debit_accounts[$i] != null) {
                $debit_accounts[] = DecodeTagifyField::run($this->debit_accounts[$i]);
            }
        }

        for($i = 0; $i < count($this->credit_accounts); $i++) {
            if($this->credit_accounts[$i] != null) {
                $credit_accounts[] = DecodeTagifyField::run($this->credit_accounts[$i]);
            }
        }

        $this->merge([
            'debit_accounts' => isset($debit_accounts) ? $debit_accounts : null,
            'credit_accounts' => isset($credit_accounts) ? $credit_accounts : null,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator){
            $total_debit_amount = 0;
            $total_credit_amount = 0;

            if(isset($this->debit_amount) && isset($this->credit_amount))
            {
                foreach($this->debit_amount as $debit_amount) {
                    $total_debit_amount += $debit_amount;
                }
    
                foreach($this->credit_amount as $credit_amount) {
                    $total_credit_amount += $credit_amount;
                }
    
                if($total_debit_amount != $total_credit_amount) {
                    $validator->errors()->add('total', 'Total Debit Amount must be equal to Total Credit Amount');
                }
            }
        });
    }
}
