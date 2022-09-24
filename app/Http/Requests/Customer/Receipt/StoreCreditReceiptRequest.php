<?php

namespace App\Http\Requests\Customer\Receipt;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;
use App\Models\AccountingSystem;

class StoreCreditReceiptRequest extends FormRequest
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
            'receipt' => ['required'],
            'amount_paid' => ['required', 'numeric', 'min:1'],
            // 'receipt_reference_id' => ['required', 'array'],
            // 'receipt_reference_id.*' => ['required'],
            // 'date_due' => ['required', 'array'],
            // 'date_due.*' => ['required', 'date'],
            // 'amount_due' => ['required', 'array'],
            // 'amount_due.*' => ['required', 'numeric', 'min:1'],
            // 'description' => ['sometimes', 'array'],
            // 'description.*' => ['sometimes'],
            // 'discount' => ['sometimes', 'array'],
            // 'discount.*' => ['nullable', 'numeric'],
            // 'amount_paid' => ['sometimes', 'array'],
            // 'amount_paid.*' => ['nullable', 'numeric'],
            // 'is_paid' => ['required', 'array'],
            // 'account' => ['required'],
            // 'item' => ['required', 'array'],
            // 'item.*' => ['required'],
            // 'quantity' => ['required', 'array'],
            // 'quantity.*' => ['required', 'numeric', 'min:1'],
            // 'tax' => ['required', 'array'],
            // 'tax.*' => ['required'],
            // 'total_received' => ['required', 'numeric', 'min:1'],
            // 'discount' => ['required', 'numeric'],
            // 'withholding' => ['required', 'numeric'],
            // 'taxable' => ['required', 'numeric'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
            // 'discount_account' => ['sometimes'],
            // 'discount_account_id' => ['sometimes'],
            // 'revenue_type' => ['required'],
            // 'payment_type' => ['required'],
            // 'grand_total' => ['required', 'numeric', 'min:0'],
            // 'total_amount_received' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function prepareForValidation()
    {
        $accounting_system = AccountingSystem::find(session('accounting_system_id'));

        $this->merge([
            'credit_receipt_cash_on_hand' => $accounting_system->credit_receipt_cash_on_hand,
            'credit_receipt_account_receivable' => $accounting_system->credit_receipt_account_receivable,
        ]);

        $this->merge([
            'customer' => DecodeTagifyField::run($this->customer),
            'receipt' => DecodeTagifyField::run($this->receipt),
            'amount_paid' => floatval($this->amount_paid),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            if($this->amount_paid > $this->receipt->amount_to_pay) {
                $validator->errors()->add('amount_paid', 'Amount paid cannot be greater than the amount to pay.');
            }
            if(!$this->get('credit_receipt_cash_on_hand')) {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Cash on Hand. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if(!$this->get('credit_receipt_account_receivable')) {
                $validator->errors()->add('customer', 'You haven\'t set the default COA for Account Receivable. Please make sure that everything is set at `Settings > Defaults`');
            }
        });
    }
}
