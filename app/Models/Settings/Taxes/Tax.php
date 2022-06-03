<?php

namespace App\Models\Settings\Taxes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id', 
        'id', 
        'name', 
        'percentage',
    ];

    public function inventoryItems()
    {
        return $this->hasMany(Inventory::class);
    }
}
