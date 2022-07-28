<?php

namespace App\Exports;

use App\Models\Settings\Taxes\Tax;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportSettingTax implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tax = Tax::all();
        $tax->prepend(['accounting_system_id', 'id', 'name', 'percentage', 'created_at', 'updated_at']);
        return $tax;
    }
}
