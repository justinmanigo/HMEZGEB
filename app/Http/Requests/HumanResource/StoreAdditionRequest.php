<?php

namespace App\Http\Requests\HumanResource;

use App\Http\requests\Api\FormRequest;
use App\Actions\DecodeTagifyField;
use App\Models\Addition;
use App\Models\AccountingSystem;
use Illuminate\Support\Facades\Log;

class StoreAdditionRequest extends FormRequest
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
            'price' => ['required', 'array'],
            'price.*' => ['required', 'numeric', 'min:1'],
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
            'employee.required' => 'The employee field is required.',
            'employee.*.required' => 'The employee field is required.',
            'employee.array' => 'The employee field must be an array.',
            'price.required' => 'The price field is required.',
            'price.array' => 'The price field must be an array.',
            'price.*.required' => 'The price field is required.',
            'price.*.numeric' => 'The price field must be numeric.',
            'price.*.min' => 'The price field must be at least 1.',
        ];
        
    }
}
