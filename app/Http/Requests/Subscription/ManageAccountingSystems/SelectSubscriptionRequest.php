<?php

namespace App\Http\Requests\Subscription\ManageAccountingSystems;

use App\Models\Subscription;
use Illuminate\Foundation\Http\FormRequest;

class SelectSubscriptionRequest extends FormRequest
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
            'subscription_id' => ['required', 'exists:subscriptions,id'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $subscription = Subscription::find($this->input('subscription_id'));
            if($subscription->accountingSystems->count() == $subscription->account_limit) {
                $validator->errors()->add('subscription_id', 'You have reached the maximum number of accounting systems for this subscription.');
            }
        });
    }
}
