<?php

namespace App\Http\Requests\Control;

use Illuminate\Foundation\Http\FormRequest;

class ActivateSubscriptionRequest extends FormRequest
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
            'expiration_date' => ['required', 'date', 'after:today'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->subscription->date != null && $this->expiration_date < $this->subscription->date_to) {
                $validator->errors()->add('expiration_date', 'The expiration date must be set after the subscription end date.');
            }
        });
    }
}
