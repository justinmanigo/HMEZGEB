<?php

namespace App\Http\Requests\Settings\Defaults;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;

class UpdateAdvanceReceiptDefaultsRequest extends FormRequest
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
            'advance_receipt_cash_on_hand' => $this->advance_receipt_cash_on_hand ? DecodeTagifyField::run($this->advance_receipt_cash_on_hand)->value : null,
            'advance_receipt_advance_payment' => $this->advance_receipt_advance_payment ? DecodeTagifyField::run($this->advance_receipt_advance_payment)->value : null,
        ]);
    }
}
