<?php

namespace App\Http\Requests\Control;

use App\Actions\DecodeTagifyField;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddExistingUserAsSuperAdmin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->control_panel_role != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user' => ['required'],
            'control_panel_role' => ['required'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user' => DecodeTagifyField::run($this->user),
        ]);
    }
}
