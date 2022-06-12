<?php

namespace App\Http\Requests\Settings\Defaults;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;

class UpdatePaymentDefaultsRequest extends FormRequest
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
            'payment_cash_on_hand' => $this->payment_cash_on_hand ? DecodeTagifyField::run($this->payment_cash_on_hand)->value : null,
            'payment_vat_receivable' => $this->payment_vat_receivable ? DecodeTagifyField::run($this->payment_vat_receivable)->value : null,
            'payment_account_payable' => $this->payment_account_payable ? DecodeTagifyField::run($this->payment_account_payable)->value : null,
            'payment_withholding' => $this->payment_withholding ? DecodeTagifyField::run($this->payment_withholding)->value : null,
            'payment_salary_payable' => $this->payment_salary_payable ? DecodeTagifyField::run($this->payment_salary_payable)->value : null,
            'payment_commission_payment' => $this->payment_commission_payment ? DecodeTagifyField::run($this->payment_commission_payment)->value : null,
        ]);
    }
}
