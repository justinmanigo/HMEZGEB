<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\AccountingSystem;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $this->accounting_system_id = $this->request->session()->get('accounting_system_id');
        $this->accountingSystem = AccountingSystem::findOrFail($this->accounting_system_id);

        return view('settings.inventory.index', [
            'settings_inventory_type' => $this->accountingSystem->settings_inventory_type,
        ]);
    }

    public function store(Request $request)
    {
        $this->accounting_system_id = $this->request->session()->get('accounting_system_id');
        $this->accountingSystem = AccountingSystem::findOrFail($this->accounting_system_id);

        $this->accountingSystem->update([
            'settings_inventory_type' => $request->settings_inventory_type,
        ]);

        return redirect()->back()->with('success', 'Inventory settings updated successfully.');
    }
}