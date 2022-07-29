<?php

namespace App\Exports;

use App\Models\Vendors;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportVendorsVendor implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $vendors = Vendors::all();
        $vendors->prepend(['id','accounting_system_id', 'name', 'tin_number', 'address', 'city', 'country', 'mobile_number', 'telephone_one', 'mobile_number', 'fax', 'website', 'email', 'contact_person', 'label', 'image', 'is_active','created_at','updated_at']);
        return $vendors;
    }
}
