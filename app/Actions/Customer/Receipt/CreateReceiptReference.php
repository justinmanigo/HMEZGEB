<?php

namespace App\Actions\Customer\Receipt;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\ReceiptReferences;

class CreateReceiptReference
{
    use AsAction;

    public function handle($customer_id, $date, $type, $status, $accounting_system_id)
    {
        return ReceiptReferences::create([
            'accounting_system_id' => $accounting_system_id,
            'customer_id' => $customer_id,
            'date' => $date,
            'type' => $type,
            'status' => $status,
        ]);
    }
}
