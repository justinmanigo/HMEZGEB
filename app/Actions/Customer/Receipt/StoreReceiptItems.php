<?php

namespace App\Actions\Customer\Receipt;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class StoreReceiptItems
{
    use AsAction;

    public function handle($raw_items, $receipt_reference_id)
    {
        foreach($raw_items as $item) {
            $items[] = [
                'receipt_reference_id' => $receipt_reference_id,
                'inventory_id' => $item->value,
                'quantity' => $item->quantity,
                'price' => $item->sale_price,
                'total_price' => $item->quantity * $item->sale_price,
            ];
        }

        return DB::table('receipt_items')->insert($items);
    }
}
