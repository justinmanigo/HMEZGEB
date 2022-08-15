<?php

namespace App\Http\Requests\Settings\AccountingPeriods;

use App\Http\Requests\Api\FormRequest;

class UpdateAccountingPeriodsRequest extends FormRequest
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
            'date_from' => ['required', 'array'],
            'date_to' => ['required', 'array'],
            'date_from.*' => ['required', 'date'],
            'date_to.*' => ['required', 'date'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            for($i = 0; $i < 12; $i++) {
                // If current `date_from` is earlier than last `date_to`, as long as its not the first period, then show error.
                if($i > 0 && $this->input('date_from')[$i] < $this->input('date_to')[$i-1]) {
                    $validator->errors()->add("date_from.{$i}", '`Date From` must be set later than the previous `Date To`.');
                }
                // If current `date_from` is later than current `date_to`, then show error.
                if($this->input('date_from')[$i] > $this->input('date_to')[$i]) {
                    $validator->errors()->add("date_from.{$i}", '`Date From` must be before `Date To`.');
                }
                // If current `date_to` is earlier than the current `date_from`, then show error.
                if($this->input('date_to')[$i] < $this->input('date_from')[$i]) {
                    $validator->errors()->add("date_to.{$i}", '`Date To` must be set after `Date From`');
                }
                // If current `date_to` is later than next `date_from`, as long as its not the last period, then show error.
                if($i < 11 && $this->input('date_to')[$i] > $this->input('date_from')[$i+1]) {
                    $validator->errors()->add("date_to.{$i}", '`Date To` must be set before the next `Date From`');
                }
                // If current `date_from` is earlier than the first `date_from`, then show error.
                if($this->input('date_from')[$i] < $this->input('date_from')[0]) {
                    $validator->errors()->add("date_from.{$i}", 'The period must start on or after the start of accounting year.');
                }
                // If current `date_to` is later than the last `date_to`, then show error.
                if($i == 11 && $this->input('date_to')[$i] > $this->input('date_to')[11]) {
                    $validator->errors()->add("date_to.{$i}", 'The period must end on or before the accounting year.');
                }
            }
        });
    }
}
