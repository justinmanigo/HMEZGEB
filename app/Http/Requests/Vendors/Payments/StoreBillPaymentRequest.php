<?php

namespace App\Http\Requests\Vendors\Payments;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;
use App\Models\AccountingSystem;

class StoreBillPaymentRequest extends FormRequest
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
            'vendor' => ['required'],
            'date' => ['required'],
            'bill' => ['required'],
            'amount_paid' => ['required', 'numeric', 'min:1'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
        ];
    }

    protected function prepareForValidation()
    {
        $accounting_system = AccountingSystem::find(session('accounting_system_id'));

        $this->merge([
            'bill_cash_on_hand' => $accounting_system->bill_cash_on_hand,
            'bill_account_payable' => $accounting_system->bill_account_payable,

            'vendor' => DecodeTagifyField::run($this->vendor),
            'bill' => DecodeTagifyField::run($this->bill),
            'amount_paid' => floatval($this->amount_paid),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator)
        {
            if($this->amount_paid > $this->bill->balance) {
                $validator->errors()->add('amount_paid', 'Amount paid cannot be greater than the amount to pay.');
            }
            if(!$this->get('bill_cash_on_hand')) {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Cash on Hand. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if(!$this->get('bill_account_payable')) {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Account Payable. Please make sure that everything is set at `Settings > Defaults`');
            }
        });
    }
}
