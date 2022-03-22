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
        // 'purchase_quantity',
        // 'sold_quantity',
        'tax',
        'default_income_account',
        'default_expense_account',
        'inventory_type',
        'picture',
        'description',
        'is_enabled',
        'inventoryValue',
        'totalInventory',
    ];


}
