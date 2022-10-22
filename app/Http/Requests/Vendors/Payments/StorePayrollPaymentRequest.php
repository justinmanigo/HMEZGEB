<?php

namespace App\Http\Requests\Vendors\Payments;

use App\Actions\DecodeTagifyField;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use Illuminate\Foundation\Http\FormRequest;

class StorePayrollPaymentRequest extends FormRequest
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
            'payroll_period' => ['required'],
            'date' => ['required', 'date'],
            'cheque_number' => ['sometimes'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
        ];
    }

    protected function prepareForValidation()
    {
        // Query 2101 - Salary Payable
        $salary_payable = ChartOfAccounts::where('chart_of_account_no', '2101')
            ->where('accounting_system_id', session('accounting_system_id'))->first();

        $this->merge([
            'cash_account' => DecodeTagifyField::run($this->cash_account),
            'payroll_period' => DecodeTagifyField::run($this->payroll_period),
            'salary_payable' => $salary_payable,
        ]);
    }
}
