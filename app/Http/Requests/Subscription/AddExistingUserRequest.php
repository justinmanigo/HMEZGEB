<?php

namespace App\Http\Requests\Subscription;

use App\Actions\DecodeTagifyField;
use App\Models\SubscriptionUser;
use App\Http\Requests\Api\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddExistingUserRequest extends FormRequest
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
            'subscription_id' => ['required', 'numeric'],
            'user' => ['required'],
            'role' => ['required'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user' => DecodeTagifyField::run($this->user),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->user->value == Auth::user()->id) {
                $validator->errors()->add('user', 'You cannot add yourself as a user.');
            }
            else if(SubscriptionUser::where('subscription_id', $this->subscription_id)->where('user_id', $this->user->value)->exists()) {
                $validator->errors()->add('user', 'This user is already a user of this subscription.');
            }
        });
    }
}
