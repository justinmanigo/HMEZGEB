<?php

namespace App\Http\Requests\Settings\Defaults;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;

class UpdateBillDefaultsRequest extends FormRequest
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
            'bill_cash_on_hand' => $this->bill_cash_on_hand ? DecodeTagifyField::run($this->bill_cash_on_hand)->value : null,
            'bill_items_for_sale' => $this->bill_items_for_sale ? DecodeTagifyField::run($this->bill_items_for_sale)->value : null,
            'bill_freight_charge_expense' => $this->bill_freight_charge_expense ? DecodeTagifyField::run($this->bill_freight_charge_expense)->value : null,
            'bill_vat_receivable' => $this->bill_vat_receivable ? DecodeTagifyField::run($this->bill_vat_receivable)->value : null,
            'bill_account_payable' => $this->bill_account_payable ? DecodeTagifyField::run($this->bill_account_payable)->value : null,
            'bill_withholding' => $this->bill_withholding ? DecodeTagifyField::run($this->bill_withholding)->value : null,
        ]);
    }
}
