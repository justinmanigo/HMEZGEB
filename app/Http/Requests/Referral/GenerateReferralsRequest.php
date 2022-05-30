<?php

namespace App\Http\Requests\Referral;

use App\Http\Requests\Api\FormRequest;
use Illuminate\Support\Facades\Auth;

class GenerateReferralsRequest extends FormRequest
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
            'number_of_codes' => ['required', 'numeric', 'min:1'],
            'referral_type' => ['required'],
            'account_type' => ['sometimes'],
            'number_of_accounts' => ['sometimes', 'min:1'],
            'trial_duration' => ['sometimes', 'min:1'],
            'trial_duration_type' => ['sometimes'],
        ];
    }
}
