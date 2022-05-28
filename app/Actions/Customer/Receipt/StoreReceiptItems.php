<?php

namespace App\Actions\Customer\Receipt;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class StoreReceiptItems
{
    use AsAction;

    public function handle($raw_items, $quantity, $receipt_reference_id)
    {
        for($i = 0; $i < count($raw_items); $i++)
        {
            $items[] = [
                'receipt_reference_id' => $receipt_reference_id,
                'inventory_id' => $raw_items[$i]->value,
                'quantity' => $quantity[$i],
                'price' => $raw_items[$i]->sale_price,
                'total_price' => $quantity[$i] * $raw_items[$i]->sale_price,
            ];
        }

        return DB::table('receipt_items')->insert($items);
    }
}
