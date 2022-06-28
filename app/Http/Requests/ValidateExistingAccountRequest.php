<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ValidateExistingAccountRequest extends FormRequest
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
            'email' => ['required'],
            'password' => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = User::where('email', $this->input('email'))->first();
            if (!$user) {
                $validator->errors()->add('password', 'Email is not registered.');
            } else {
                if (!Hash::check($this->input('password'), $user->password)) {
                    $validator->errors()->add('password', 'Password is incorrect.');
                }
            }
        });
    }
}
