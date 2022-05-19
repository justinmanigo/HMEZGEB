<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAdvancedReferralRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email'],
            'account_type' => ['required'],
            'number_of_accounts' => ['required', 'numeric', 'min:1', 'max:10'],
            'trial_date_start' => ['required','after_or_equal:today'],
            'trial_date_end' => ['required', 'after:trial_date_start'],
        ];
    }
}
