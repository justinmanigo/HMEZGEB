<?php

namespace App\Http\Requests\Vendors\Payments;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Actions\Vendors\Payments\GetAllWithholdingPeriods;

class StoreWithholdingPaymentRequest extends FormRequest
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
            'cash_account' => ['required'],
            'date' => ['required', 'date'],
            'cheque_number' => ['sometimes'],
            'accounting_period_ids' => ['required', 'array'],
            'accounting_period_ids.*' => ['sometimes', 'numeric'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
        ];
    }

    protected function prepareForValidation()
    {
        // Query 2105 - Withholding Tax Payable
        $withholding_tax_payable = ChartOfAccounts::where('chart_of_account_no', '2105')
            ->where('accounting_system_id', session('accounting_system_id'))->first();

        $this->merge([
            'cash_account' => DecodeTagifyField::run($this->cash_account),
            'withholding_tax_payable' => $withholding_tax_payable,
            'withholding_periods' => GetAllWithholdingPeriods::run(),
        ]);
    }

    public function messages()
    {
        return [
            'accounting_period_ids.required' => 'Select at least one accounting period to process.',
        ];
    }
}
