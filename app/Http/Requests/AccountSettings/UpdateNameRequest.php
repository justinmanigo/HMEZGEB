<?php

namespace App\Http\Requests\AccountSettings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNameRequest extends FormRequest
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
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if($this->firstName == 'New' && $this->lastName == 'User') {
                $validator->errors()->add('firstName', 'You cannot have a first name of `New` and a last name of `User`.');
            }
        });
    }
}
