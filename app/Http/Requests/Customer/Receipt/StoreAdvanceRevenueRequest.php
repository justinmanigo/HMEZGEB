<?php

namespace App\Http\Requests\Customer\Receipt;

use App\Http\Requests\Api\FormRequest;
use App\Models\AccountingSystem;

class StoreAdvanceRevenueRequest extends FormRequest
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
            'customer' => ['required'],
            'date' => ['required', 'date'],
            // 'account' => ['required'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
            'amount_received' => ['required', 'numeric', 'min:1'],
            'reason' => ['sometimes'],
        ];
    }

    protected function prepareForValidation()
    {
        $accounting_system = AccountingSystem::find(session('accounting_system_id'));

        $this->merge([
            'advance_receipt_cash_on_hand' => $accounting_system->advance_receipt_cash_on_hand,
            'advance_receipt_advance_payment' => $accounting_system->advance_receipt_advance_payment,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator){
            if(!$this->get('advance_receipt_cash_on_hand')) {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Cash on Hand. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if(!$this->get('advance_receipt_advance_payment')) {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Advance Payment. Please make sure that everything is set at `Settings > Defaults`');
            }
        });
    }
}
