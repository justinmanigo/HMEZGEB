<?php

namespace App\Http\Requests\AccountSettings;

use App\Http\Requests\Api\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUsernameRequest extends FormRequest
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
            'username' => ['required', Rule::unique('users')->ignore(Auth::user()->id), 'max:255'],
            'confirm_username' => ['required', 'same:username'],
            'confirm_password' => ['required', 'password'],
        ];
    }
}
