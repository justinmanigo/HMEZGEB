<?php

namespace App\Http\Requests\Settings\Defaults;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;

class UpdateCreditReceiptDefaultsRequest extends FormRequest
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
            //
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'accounting_system_id' => session('accounting_system_id'),
            'credit_receipt_cash_on_hand' => $this->credit_receipt_cash_on_hand ? DecodeTagifyField::run($this->credit_receipt_cash_on_hand)->value : null,
            'credit_receipt_account_receivable' => $this->credit_receipt_account_receivable ? DecodeTagifyField::run($this->credit_receipt_account_receivable)->value : null,
        ]);
    }
}
