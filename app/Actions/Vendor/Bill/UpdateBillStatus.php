<?php

namespace App\Actions\Vendor\Bill;

use App\Models\PaymentReferences;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateBillStatus
{
    use AsAction;

    public function handle($id, $status)
    {
        return PaymentReferences::where('id', $id)
            ->update([
                'status' => $status,
            ]);
    }
}
