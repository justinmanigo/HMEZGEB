<?php

namespace App\Exports;

use App\Models\Settings\Withholding\Withholding;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportSettingWithholding implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $withholdings = Withholding::all();
        $withholdings->prepend(['accounting_system_id', 'id', 'name', 'percentage','created_at', 'updated_at']);
        return $withholdings;
    }
}
