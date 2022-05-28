<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Inventory;

class UpdateInventoryItemQuantity
{
    use AsAction;

    public function handle($items, $quantities, $action)
    {
        for($i = 0; $i < count($items); $i++)
        {
            $inv = Inventory::where('id', $items[$i]->value);

            if($action == 'increase') {
                $inv->increment('quantity', $quantities[$i]);
            } else {
                $inv->decrement('quantity', $quantities[$i]);
            }
        }
    }
}
