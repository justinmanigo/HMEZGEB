<?php

namespace App\Http\Requests\HumanResource;

use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use Illuminate\Foundation\Http\FormRequest;

class StorePayrollRequest extends FormRequest
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

    public function prepareForValidation()
    {
        // Query for the account
        
        $salary_expense = ChartOfAccounts::where('chart_of_account_no', '6101')
            ->where('accounting_system_id', session('accounting_system_id'))->first();

        $salary_payable = ChartOfAccounts::where('chart_of_account_no', '2101')
            ->where('accounting_system_id', session('accounting_system_id'))->first();

        $income_tax_payable = ChartOfAccounts::where('chart_of_account_no', '2102')
            ->where('accounting_system_id', session('accounting_system_id'))->first();

        $pension_fund_payable = ChartOfAccounts::where('chart_of_account_no', '2103')
            ->where('accounting_system_id', session('accounting_system_id'))->first();
        
        $employees_advance = ChartOfAccounts::where('chart_of_account_no', '1120')
            ->where('accounting_system_id', session('accounting_system_id'))->first();

        $other_income = ChartOfAccounts::where('chart_of_account_no', '4103')
            ->where('accounting_system_id', session('accounting_system_id'))->first();

        $this->merge([
            'employee' => isset($employee) ? $employee : [],
            'salary_expense' => $salary_expense->id,
            'salary_payable' => $salary_payable->id,
            'income_tax_payable' => $income_tax_payable->id,
            'pension_fund_payable' => $pension_fund_payable->id,
            'employees_advance' => $employees_advance->id,
            'other_income' => $other_income->id,
        ]);
    }
}