<?php

namespace App\Imports;

use App\Models\Settings\Withholding\Withholding;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSettingWithholding implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Withholding([
            'accounting_system_id' => $row['accounting_system_id'],
            'name' => $row['name'],
            'percentage' => $row['percentage'],
        ]);
    }
}
