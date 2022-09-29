<?php

namespace App\Http\Requests\HumanResource;

use App\Http\Requests\Api\FormRequest;
use App\Actions\DecodeTagifyField;
use App\Actions\Hr\IsAccountingPeriodLocked;
use App\Models\Overtime;
use App\Models\AccountingSystem;
use Illuminate\Support\Facades\Log;

class StoreOvertimeRequest extends FormRequest
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
            'employee' => ['required','array'],
            'employee.*' => ['required'],
            'from' => ['required'],
            'from.*' => ['required'],
            'to' => ['required'],
            'to.*' => ['required'],
        ];
    }
    protected function prepareForValidation()
    {       
       
        for($i = 0; $i < count($this->employee); $i++) {   
            if($this->employee[$i] != null) {
                $employee[] = DecodeTagifyField::run($this->employee[$i]);
            }
        }

        $this->merge([
            'employee' => isset($employee) ? $employee : [],
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
            'date.required' => 'The date is required.',
            'date.date' => 'The date is invalid.',
            'employee.required' => 'The employee is required.',
            'employee.array' => 'The employee is invalid.',
            'employee.*.required' => 'The employee is required.',
            'from.required' => 'The time from is required.',
            'from.*.required' => 'The time from is required.',
            'to.required' => 'The time to is required.',
            'to.*.required' => 'The time to is required.',

        ];   
    }
}
