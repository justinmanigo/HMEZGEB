<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Inventory;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class UpdateInventoryItemQuantity
{
    use AsAction;

    public function handle($items, $quantities, $action)
    {
        for($i = 0; $i < count($items); $i++)
        {
            $inv = Inventory::where('id', $items[$i]->value)->first();
            // checks for records of unresolved notifs
            $notif = Notification::where('reference_id', $inv->id)->where('source', 'inventory')->where('resolved',0)->get();
          
            if($action == 'increase') 
            {
                $inv->increment('quantity', $quantities[$i]);  

                    // update all warning notifications
                    if($inv->quantity >= $inv->critical_quantity && $notif->count() > 0)  {
                        $notif_check = Notification::where('reference_id', $inv->id)->where('source', 'inventory')->where('resolved',0)->get(); 
                    }                 
                    // update all danger notifications
                    else if($inv->quantity > 0 && $notif->count() > 0) {
                        $notif_check = Notification::where('reference_id', $inv->id)->where('source', 'inventory')->where('type','danger')->where('resolved',0)->get(); 
                        
                        // check if there is a created warning notification before reaching danger level 0
                        $warning_check = Notification::where('reference_id', $inv->id)->where('source', 'inventory')->where('type','warning')->where('resolved',0)->get(); 
                        if($warning_check->count() == 0) {
                            // create notification if doesnt reach warning level
                            Notification::create([
                                'reference_id' => $inv->id,
                                'source' => 'inventory',
                                'message' => 'Inventory item '.$inv->item_name.' is less than or equal to '.$inv->critical_quantity.'. Please reorder.',
                                'title' => 'Inventory Critical Level',
                                'type' => 'warning',
                                'link' => 'vendors/bills',            
                        ]);                        }
                    }
                    
                    if(isset($notif_check)) {
                        foreach($notif_check as $n)
                        {
                            $n->resolved = 1;
                            $n->time_resolved = now();
                            $n->save();
                        }
                    }
                }
            else if($action == 'decrease')         
                $inv->decrement('quantity', $quantities[$i]);            
        }
    }
}
