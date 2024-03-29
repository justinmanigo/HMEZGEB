<?php

namespace App\Http\Requests\HumanResource;

use App\Http\Requests\Api\FormRequest;
use App\Actions\DecodeTagifyField;
use App\Actions\Hr\IsAccountingPeriodLocked;
use App\Models\Loan;
use App\Models\AccountingSystem;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use Illuminate\Support\Facades\Log;
class StoreLoanRequest extends FormRequest
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
            'cash_account' => ['required'],
            'employee' => ['required','array'],
            'employee.*' => ['required'],
            'loan' => ['required', 'array'],
            'loan.*' => ['required','numeric', 'min:1'],
            'paid_in' => ['required', 'array'],
            'paid_in.*' => ['required'],
        ];
    }
    protected function prepareForValidation()
    {       
       
        for($i = 0; $i < count($this->employee); $i++) {   
            if($this->employee[$i] != null) {
                $employee[] = DecodeTagifyField::run($this->employee[$i]);
            }
        }

        // Query for the account
        $employees_advance = ChartOfAccounts::where('chart_of_account_no', '1120')
            ->where('accounting_system_id', session('accounting_system_id'))->first();

        $this->merge([
            'employee' => isset($employee) ? $employee : [],
            'cash_account' => DecodeTagifyField::run($this->cash_account),
            'employees_advance' => $employees_advance->id,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Disable create if payroll is generated for current accounting period.
            if(IsAccountingPeriodLocked::run($this->date)) {
                $validator->errors()->add('date', 'Payroll already created! Unable to generate new addition in current accounting period.');
            }
        });
    }

    // Custom error messages
    public function messages()
    {  
        return [
            'employee.required' => 'The employee field is required.',
            'employee.*.required' => 'The employee field is required.',
            'employee.array' => 'The employee field must be an array.',
            'loan.required' => 'The loan field is required.',
            'loan.array' => 'The loan field must be an array.',
            'loan.*.required' => 'The loan field is required.',
            'loan.*.numeric' => 'The loan field must be numeric.',
            'loan.*.min' => 'The loan field must be at least 1.',
            'paid_in.required' => 'The paid in field is required.',
            'paid_in.array' => 'The paid in field must be an array.',
            'paid_in.*.required' => 'The paid in field is required.',
        ];
        
    }
}
