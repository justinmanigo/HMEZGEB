<?php

namespace App\Http\Requests\Settings\Defaults;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;

class UpdateReceiptDefaultsRequest extends FormRequest
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
            'receipt_cash_on_hand' => $this->receipt_cash_on_hand ? DecodeTagifyField::run($this->receipt_cash_on_hand)->value : null,
            'receipt_vat_payable' => $this->receipt_vat_payable ? DecodeTagifyField::run($this->receipt_vat_payable)->value : null,
            'receipt_sales' => $this->receipt_sales ? DecodeTagifyField::run($this->receipt_sales)->value : null,
            'receipt_account_receivable' => $this->receipt_account_receivable ? DecodeTagifyField::run($this->receipt_account_receivable)->value : null,
            'receipt_sales_discount' => $this->receipt_sales_discount ? DecodeTagifyField::run($this->receipt_sales_discount)->value : null,
            'receipt_withholding' => $this->receipt_withholding ? DecodeTagifyField::run($this->receipt_withholding)->value : null,
            // 'receipt_vat_payable' => DecodeTagifyField::run($this->receipt_vat_payable),
            // 'receipt_sales' => DecodeTagifyField::run($this->receipt_sales),
            // 'receipt_account_receivable' => DecodeTagifyField::run($this->receipt_account_receivable),
            // 'receipt_sales_discount' => DecodeTagifyField::run($this->receipt_sales_discount),
            // 'receipt_withholding' => DecodeTagifyField::run($this->receipt_withholding),
        ]);
    }
}
