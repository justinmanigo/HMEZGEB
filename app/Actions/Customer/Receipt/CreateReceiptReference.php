<?php

namespace App\Actions\Customer\Receipt;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\ReceiptReferences;

class CreateReceiptReference
{
    use AsAction;

    public function handle($customer_id, $date, $type, $status)
    {
        return ReceiptReferences::create([
            'customer_id' => $customer_id,
            'date' => $date,
            'type' => $type,
            'status' => $status,
        ]);
    }
}
