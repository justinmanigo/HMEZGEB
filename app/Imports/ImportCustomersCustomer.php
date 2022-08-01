<?php

namespace App\Imports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportCustomersCustomer implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customers([
            //
            'accounting_system_id' => $row['accounting_system_id'],
            'name' => $row['name'],
            'tin_number' => $row['tin_number'],
            'address' => $row['address'],
            'city' => $row['city'],
            'country' => $row['country'],
            'mobile_number' => $row['mobile_number'],
            'telephone_one' => $row['telephone_one'],
            'telephone_two' => $row['telephone_two'],
            'website' => $row['website'],
            'email' => $row['email'],
            'contact_person' => $row['contact_person'],
            'label' => $row['label'],
            'fax' => $row['fax'],
        ]);
    }

    public function rules(): array
    {
        return [
            'accounting_system_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'mobile_number' => 'required',
            'telephone_one' => 'required',
            'email' => 'required',
            'contact_person' => 'required',
            'label' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'accounting_system_id.required' => 'The accounting system id field is required.',
            'name.required' => 'The name field is required.',
            'address.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'country.required' => 'The country field is required.',
            'mobile_number.required' => 'The mobile number field is required.',
            'telephone_one.required' => 'The telephone one field is required.',
            'email.required' => 'The email field is required.',
            'contact_person.required' => 'The contact person field is required.',
            'label.required' => 'The label field is required.',
        ];
    }
}
