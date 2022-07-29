<?php

namespace App\Exports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCustomersCustomer implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $customers = Customers::all();
        $customers->prepend(['id','accounting_system_id', 'name', 'tin_number', 'address', 'city', 'country', 'mobile_number', 'telephone_one', 'mobile_number', 'fax', 'website', 'email', 'contact_person', 'label', 'image', 'is_active','created_at','updated_at']);
        return $customers;

    }
}
