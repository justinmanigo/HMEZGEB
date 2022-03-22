<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
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
        return $this->show();
        // return view('inventory.inventory');
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
        
        $imageName = time().'.'.$request->picture->extension();  
        $request->picture->storeAs('inventories', $imageName);
        
        $inventory = new Inventory();
        $inventory->item_code =  $request->item_code;
        $inventory->item_name =  $request->item_name;
        $inventory->sale_price =  $request->sale_price;
        $inventory->purchase_price =  $request->purchase_price;
        $inventory->quantity =  $request->quantity;

        // $inventory->purchase_quantity =  $request->purchase_quantity;
        // $inventory->sold_quantity =  $request->sold_quantity;
        $inventory->default_income_account = $request->default_income_account;
        $inventory->default_expense_account = $request->default_expense_account;
        $inventory->inventory_type = $request->inventory_type;
        $inventory->picture = $imageName;
        $inventory->description = $request->description;
        $inventory->is_enabled =  'Yes';
        $inventory->save();
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        
          //get all inventories from database then display on inventory
          $inventories = Inventory::all();
          //sort the inventories
        //   $inventory = $inventory->sortByDesc('created_at');
          return view('inventory.inventory',compact('inventories'));
    }
    public function fifo()
    {

    }
    public function lifo()
    {
    
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
        //
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
        //
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
}
