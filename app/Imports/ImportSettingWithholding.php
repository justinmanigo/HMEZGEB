<?php

namespace App\Imports;

use App\Models\Settings\Withholding\Withholding;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ImportSettingWithholding implements ToModel, WithHeadingRow, WithValidation
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

    public function rules(): array
    {
        return [
            'accounting_system_id' => 'required|integer|exists:accounting_systems,id',
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|between:0,100',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'accounting_system_id.required' => 'The accounting system id field is required.',
            'accounting_system_id.integer' => 'The accounting system id must be an integer.',
            'accounting_system_id.exists' => 'The selected accounting system id is invalid.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must not be numerical.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'percentage.required' => 'The percentage field is required.',
            'percentage.numeric' => 'The percentage must be a number.',
            'percentage.between' => 'The percentage must be between 0 and 100.',
        ];
    }
}
