<?php

namespace App\Actions\Customer\Receipt;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\ReceiptReferences;

class UpdateReceiptStatus
{
    use AsAction;

    public function handle($id, $status)
    {
        return ReceiptReferences::where('id', $id)
            ->update([
                'status' => $status,
            ]);
    }
}
