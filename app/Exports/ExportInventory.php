<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportInventory implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $inventory = Inventory::all();
        $inventory->prepend(['id','accounting_system_id','item_code','item_name','sale_price','purchase_price','quantity','critical_quantity','tax_id','default_income_account','default_expense_account','inventory_type','picture','description','is_enabled','notify_critical_quantity','created_at','updated_at']);
        return $inventory;

    }
}
