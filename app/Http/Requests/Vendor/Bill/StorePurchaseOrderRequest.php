<?php

namespace App\Http\Requests\Vendor\Bill;

use App\Actions\DecodeTagifyField;
use App\Http\Requests\Api\FormRequest;
use App\Models\Inventory;

class StorePurchaseOrderRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'due_date' => ['sometimes', 'date'],
            'item' => ['required', 'array'],
            'item.*' => ['required'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric', 'min:1'],
            // 'tax' => ['required', 'array'],
            // 'tax.*' => ['required'],
            'sub_total' => ['required', 'numeric', 'min:0'],
            'grand_total' => ['required', 'numeric', 'min:0'],
            // 'discount' => ['required', 'numeric'],
            // 'withholding' => ['required', 'numeric'],
            // 'taxable' => ['required', 'numeric'],
            'remark' => ['sometimes'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,png,jpeg,doc,docx,xls,xlsx,txt,csv'],
        ];
    }

    protected function prepareForValidation()
    {        
        for($i = 0; $i < count($this->item); $i++) {
            if($this->item[$i] != null) {
                $item[] = DecodeTagifyField::run($this->item[$i]);
            }
        }

        $this->merge([
            'vendor' => DecodeTagifyField::run($this->vendor),
            'item' => isset($item) ? $item : [],
        ]);
    }
}
