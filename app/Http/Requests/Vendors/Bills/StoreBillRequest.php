<?php

namespace App\Http\Requests\Vendors\Bills;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Models\AccountingSystem;
use App\Actions\Vendors\Payments\Withholding\CheckIfWithholdingPeriodPaid;


class StoreBillRequest extends FormRequest
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
            'cash_account' => ['required'],
            'date' => ['required', 'date'],
            'due_date' => ['sometimes', 'date'],
            // 'purchase_order' => ['sometimes'],
            // 'account' => ['required'],
            'item' => ['required', 'array'],
            'item.*' => ['required'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric', 'min:1'],
            // 'tax' => ['required', 'array'],
            // 'tax.*' => ['required'],
            'sub_total' => ['required', 'numeric', 'min:0'],
            // 'discount' => ['required', 'numeric'],
            'withholding' => ['sometimes', 'numeric', 'min:0'],
            'withholding_check' => ['sometimes'],
            // 'taxable' => ['required', 'numeric'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
        ];
    }

    protected function prepareForValidation()
    {
        // dd($this->all());

        for($i = 0; $i < count($this->item); $i++) {
            if($this->item[$i] != null) {
                $item[] = DecodeTagifyField::run($this->item[$i]);
            }
        }

        $accounting_system = AccountingSystem::find(session('accounting_system_id'));

        $this->merge([
            'vendor' => DecodeTagifyField::run($this->vendor),
            'purchase_order' => $this->purchase_order != null ? DecodeTagifyField::run($this->purchase_order) : null,
            'cash_account' => DecodeTagifyField::run($this->cash_account),
            'item' => isset($item) ? $item : [],

            // Merge COA defaults to request
            'bill_cash_on_hand' => $accounting_system->bill_cash_on_hand,
            'bill_items_for_sale' => $accounting_system->bill_items_for_sale,
            'bill_freight_charge_expense' => $accounting_system->bill_freight_charge_expense,
            'bill_vat_receivable' => $accounting_system->bill_vat_receivable,
            'bill_account_payable' => $accounting_system->bill_account_payable,
            'bill_withholding' => $accounting_system->bill_withholding,
        ]);

        // dd($this->all());
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check if either of the COA defaults is blank.
            if($this->get('bill_cash_on_hand') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Cash on Hand. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('bill_items_for_sale') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Items for Sale. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('bill_freight_charge_expense') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Freight Charge Expense. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('bill_vat_receivable') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for VAT Receivable. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('bill_account_payable') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Account Payable. Please make sure that everything is set at `Settings > Defaults`');
            }
            else if($this->get('bill_withholding') == null)
            {
                $validator->errors()->add('vendor', 'You haven\'t set the default COA for Withholding. Please make sure that everything is set at `Settings > Defaults`');
            }

            // Check in case of withholding more than sub_total
            if($this->get('withholding_check') != null && $this->get('withholding') > $this->get('sub_total')) {
                $validator->errors()->add('withholding', 'Please enter a valid withholding amount. It should not be more than the sub total.');
            }
            // Check in case of withholding more than total_amount_received
            if($this->get('withholding_check') != null && $this->get('withholding') > $this->get('total_amount_received')) {
                $validator->errors()->add('withholding', 'Please enter a valid withholding amount. It should not be more than the total amount received.');
            }

            // Check if withholding period of $request->date is already paid
            if(CheckIfWithholdingPeriodPaid::run($this->get('date'))) {
                $validator->errors()->add('date', 'The withholding payment for the date\'s period has already been made.');
            }

        });
    }
}
