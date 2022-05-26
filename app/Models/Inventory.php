<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
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

}
