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
            'accounting_system_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'country' => 'required|string|max:255',
            'mobile_number' => 'required|max:255',
            'telephone_one' => 'required|max:255',
            'email' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'label' => 'required|max:255',
            'tin_number' => 'max:255|unique:customers',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'accounting_system_id.required' => 'The accounting system id field is required.',
            'accounting_system_id.integer' => 'The accounting system id must be an integer.',
            'accounting_system_id.unique' => 'The accounting system id must be unique.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'address.required' => 'The address field is required.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'city.required' => 'The city field is required.',
            'city.max' => 'The city may not be greater than 255 characters.',
            'country.required' => 'The country field is required.',
            'country.string' => 'The country must be a string.',
            'country.max' => 'The country may not be greater than 255 characters.',
            'mobile_number.required' => 'The mobile number field is required.',
            'mobile_number.max' => 'The mobile number may not be greater than 255 characters.',
            'telephone_one.required' => 'The telephone one field is required.',
            'telephone_one.max' => 'The telephone one may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'contact_person.required' => 'The contact person field is required.',
            'contact_person.string' => 'The contact person must be a string.',
            'contact_person.max' => 'The contact person may not be greater than 255 characters.',
            'label.required' => 'The label field is required.',
            'label.max' => 'The label may not be greater than 255 characters.',
            'tin_number.max' => 'The tin number may not be greater than 255 characters.',
            'tin_number.unique' => 'The tin number must be unique.',
        ];
    }
}
