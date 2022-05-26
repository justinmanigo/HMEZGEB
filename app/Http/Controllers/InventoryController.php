<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Settings\Taxes\Tax;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all inventories from database then display on inventory
        $inventories = Inventory::all();
        $inventoryValue = 0;

        // Compute for each inventory value and total value.
        $inventoryValue=0.00;
        foreach($inventories as $inventory)
        {
            if($inventory->inventory_type != 'non_inventory_item')
            {
                $inventory->inventoryValue = $inventory->quantity * $inventory->purchase_price;
                $inventoryValue += $inventory->inventoryValue;
            }           
        }

        $taxes = Tax::get();            

        return view('inventory.inventory', [
            'inventories' => $inventories,
            'taxes' => $taxes,
            'inventoryValue' => $inventoryValue,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->picture) {
            $imageName = time().'.'.$request->picture->extension();  
            $request->picture->storeAs('public/inventories', $imageName);
        }

        Inventory::create([
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'quantity' => $request->inventory_type == 'inventory_item' 
                ? 0 
                : null,
            'critical_quantity' => $request->inventory_type == 'inventory_item' 
                ? 0 
                : null,
            'tax_id' => isset($request->tax_id) ? $request->tax_id : null,
            // 'default_income_account' => $request->default_income_account,
            // 'default_expense_account' => $request->default_expense_account,
            'inventory_type' => $request->inventory_type,
            'picture' => isset($imageName) ? $imageName : null,
            'description' => $request->description,
            'notify_critical_quantity' => isset($request->notify_critical_quantity) 
                ? $request->notify_critical_quantity 
                : 'No',
        ]);
    
        return back()->with('success', 'Inventory Item Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    public function fifo()
    {

    }
    public function lifo()
    {
              //sort the inventories
        //   $inventory = $inventory->sortByDesc('created_at');
    }
    public function average()
    {

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        $taxes = Tax::get();
        return view('inventory.forms.edit', compact('inventory'), compact('taxes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        $inventory->update([
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'quantity' => $request->quantity,
            'tax_id' => isset($request->tax_id) ? $request->tax_id : null,
            // 'default_income_account' => $request->default_income_account,
            // 'default_expense_account' => $request->default_expense_account,
            'inventory_type' => $request->inventory_type,
            'picture' => isset($imageName) ? $imageName : null,
            'description' => $request->description,
        ]);

        return redirect('/inventory')->with('success', 'Successfully updated item.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    /*=================================*/

    public function ajaxSearchInventory($query)
    {   
        $inventory = Inventory::select('id as value', 'item_name as name', 'sale_price',  'quantity')
            ->where('item_name', 'LIKE', '%' . $query . '%')->get();
        return $inventory;
    }
}
