<?php

namespace App\Http\Requests\Customer\Receipt;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;
use App\Models\Inventory;

class StoreReceiptRequest extends FormRequest
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
            'proforma' => ['sometimes'],
            'due_date' => ['sometimes'],
            // 'account' => ['required'],
            'item' => ['required', 'array'],
            'item.*' => ['required'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric', 'min:1'],
            // 'tax' => ['required', 'array'],
            // 'tax.*' => ['required'],
            'sub_total' => ['required', 'numeric', 'min:0'],
            // 'discount' => ['required', 'numeric'],
            // 'withholding' => ['required', 'numeric'],
            // 'taxable' => ['required', 'numeric'],
            'grand_total' => ['required', 'numeric', 'min:0'],
            'remark' => ['sometimes'],
            'attachment' => ['sometimes', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
            // 'commission_agent' => ['sometimes'],
            // 'revenue_type' => ['required'],
            // 'payment_type' => ['required'],
            'grand_total' => ['required', 'numeric', 'min:0'],
            'total_amount_received' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function prepareForValidation()
    {        
        for($i = 0; $i < count($this->item); $i++) {
            if($this->item[$i] != null) {
                $item[] = DecodeTagifyField::run($this->item[$i]);
                if($this->tax[$i] != null) {
                    $tax[] = DecodeTagifyField::run($this->tax[$i]);
                }
                else {
                    $tax[] = null;
                }
            }
        }

        $this->merge([
            'customer' => DecodeTagifyField::run($this->customer),
            'item' => $item,
            'proforma' => $this->proforma != null ? DecodeTagifyField::run($this->proforma) : null,
            'tax' => $tax,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator){
            $input_items = $this->get('item');
            $input_quantities = $this->get('quantity');

            for($i = 0; $i < count($input_items); $i++)
            {
                $inventory_item = Inventory::find($input_items[$i]->value);
                
                if($inventory_item->inventory_type == 'inventory_item' && $input_quantities[$i] > $inventory_item->quantity)
                {
                    $validator->errors()->add("quantity.{$i}", "The remaining stocks of item {$input_items[$i]->name} is not enough. Remaining stocks: {$inventory_item->quantity}");
                }
            }
        });
    }
}
