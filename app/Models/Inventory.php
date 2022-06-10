<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\Taxes\Tax;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'item_code',
        'item_name',
        'sale_price',
        'purchase_price',
        'quantity',
        'critical_quantity',
        'tax_id',
        // 'default_income_account',
        // 'default_expense_account',
        'inventory_type',
        'picture',
        'description',
        'is_enabled',
        'notify_critical_quantity',
        'inventoryValue',
        'totalInventory',
    ];
  
    public function receiptItems()
    {
        return $this->hasMany(ReceiptItems::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

}
