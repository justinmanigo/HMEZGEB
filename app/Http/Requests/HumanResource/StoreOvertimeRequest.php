<?php

namespace App\Http\Requests\HumanResource;

use App\Http\requests\Api\FormRequest;
use App\Actions\DecodeTagifyField;
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
