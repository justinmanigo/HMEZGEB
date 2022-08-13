<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportInventory implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Inventory([
            'accounting_system_id' => $row['accounting_system_id'],
            'item_code' => $row['item_code'],
            'item_name' => $row['item_name'],
            'sale_price' => $row['sale_price'],
            'purchase_price' => $row['purchase_price'],
            'quantity' => $row['quantity'],
            'critical_quantity' => $row['critical_quantity'],
            'tax_id' => $row['tax_id'],
            'inventory_type' => $row['inventory_type'],
            'description' => $row['description'],
            'notify_critical_quantity' => $row['notify_critical_quantity'],
        ]);
    }

    public function rules(): array
    {
        return [
            'item_code' => 'required|unique:inventories,item_code',
            'item_name' => 'required',
            'sale_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'critical_quantity' => 'required|numeric',
            'tax_id' => 'nullable',
            'inventory_type' => 'in:inventory_item,non_inventory_item',
            'description' => 'nullable',
            'notify_critical_quantity' => 'nullable|in:"Yes","No"',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'item_code.required' => 'Item Code is required.',
            'item_code.unique' => 'Item Code already exists.',
            'item_name.required' => 'Item Name is required.',
            'sale_price.required' => 'Sale Price is required.',
            'sale_price.numeric' => 'Sale Price must be numeric.',
            'purchase_price.required' => 'Purchase Price is required.',
            'purchase_price.numeric' => 'Purchase Price must be numeric.',
            'quantity.required' => 'Quantity is required.',
            'quantity.numeric' => 'Quantity must be numeric.',
            'critical_quantity.required' => 'Critical Quantity is required.',
            'critical_quantity.numeric' => 'Critical Quantity must be numeric.',
            'tax_id.nullable' => 'Tax ID is required.',
            'inventory_type.in' => 'Inventory Type must be either inventory_item or non_inventory_item.',
            'description.nullable' => 'Description is required.',
            'notify_critical_quantity.in' => 'Notify Critical Quantity must be either Yes or No.',
        ];
    }
    
}
