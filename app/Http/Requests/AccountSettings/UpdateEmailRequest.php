<?php

namespace App\Http\Requests\AccountSettings;

use App\Http\Requests\Api\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateEmailRequest extends FormRequest
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
            'email' => ['required', Rule::unique('users')->ignore(Auth::user()->id), 'max:255', 'email'],
            'confirm_email' => ['required', 'same:email'],
            'confirm_password' => ['required', 'password'],
        ];
    }
}
