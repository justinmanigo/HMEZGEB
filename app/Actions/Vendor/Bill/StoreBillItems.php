<?php

namespace App\Actions\Vendor\Bill;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class StoreBillItems
{
    use AsAction;

    public function handle($raw_items, $quantity, $payment_reference_id)
    {
        for($i = 0; $i < count($raw_items); $i++)
        {
            $items[] = [
                'payment_reference_id' => $payment_reference_id,
                'inventory_id' => $raw_items[$i]->value,
                'quantity' => $quantity[$i],
                'price' => $raw_items[$i]->sale_price,
                'total_price' => $quantity[$i] * $raw_items[$i]->sale_price,
            ];
        }

        return DB::table('bill_items')->insert($items);
    }
}
