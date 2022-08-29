<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Settings\Taxes\Tax;
use Illuminate\Http\Request;
use App\Imports\ImportInventory;
use App\Exports\ExportInventory;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $inventories = Inventory::where('accounting_system_id', $accounting_system_id)->get();
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

        $taxes = Tax::where('accounting_system_id', $accounting_system_id)->get();            

        return view('inventory.index', [
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
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        if($request->picture) {
            $imageName = time().'.'.$request->picture->extension();  
            $request->picture->storeAs('public/inventories', $imageName);
        }

        Inventory::create([
            'accounting_system_id' => $accounting_system_id,
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'quantity' => $request->inventory_type == 'inventory_item' 
                ? 0 
                : null,
            'critical_quantity' => $request->inventory_type == 'inventory_item' 
                ? $request->critical_quantity 
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
    public function show(Inventory $inventory)
    {
        $inventory->tax;

        return view('inventory.show', [
            'inventory' => $inventory,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $taxes = Tax::where('accounting_system_id', $accounting_system_id)->get();
        return view('inventory.edit', compact('inventory'), compact('taxes'));
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
            'quantity' => $request->inventory_type == 'inventory_item' 
                ? 0 
                : null,
            'critical_quantity' => $request->inventory_type == 'inventory_item' 
                ? $request->critical_quantity 
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
        try
        {
            $inventory->delete();
            return redirect('/inventory')->with('success', 'Successfully deleted item.');
        }
        catch(\Exception $e)
        {
            return redirect('/inventory')->with('error', 'Error deleting inventory. Make sure no transactions are linked to this item.');
        }
    }

    // Import Export
    public function import(Request $request)
    {
        if (!$request->file('file'))
        {
            return back()->with('error', 'Please select a file');
        }
        try {
            Excel::import(new ImportInventory, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $message = $failures[0]->errors();
            return back()->with('error', $message[0].' Please check the file format');
        }    
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing inventory records.' . $e->getMessage());
        }  
        return redirect()->back()->with('success', 'Successfully imported inventory records.');
    }

    public function export(Request $request) 
    {
        if($request->file_type=="csv")
        return Excel::download(new ExportInventory, 'inventory_'.date('Y_m_d').'.csv');
        else
        $inventories = Inventory::all();
        $pdf = \PDF::loadView('inventory.pdf', compact('inventories'));
        return $pdf->download('inventory'.date('Y_m_d').'.pdf');
    }

    /*=================================*/

    public function ajaxSearchInventory($query)
    {   
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $inventory = Inventory::select(
                'inventories.id as value', 
                'inventories.item_name as name', 
                'inventories.sale_price',  
                'inventories.quantity', 
                'inventories.inventory_type',
                'inventories.tax_id',
                'taxes.name as tax_name',
                'taxes.percentage as tax_percentage',
            )
            ->leftJoin('taxes', 'inventories.tax_id', '=', 'taxes.id')
            ->where('inventories.accounting_system_id', $accounting_system_id)
            ->where('inventories.item_name', 'LIKE', '%' . $query . '%')->get();
        return $inventory;
    }
}
