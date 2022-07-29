<?php

namespace App\Imports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportCustomersCustomer implements ToModel, WithHeadingRow
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
            'website' => $row['website'],
            'email' => $row['email'],
            'contact_person' => $row['contact_person'],
            'label' => $row['label'],
        ]);
    }
}
