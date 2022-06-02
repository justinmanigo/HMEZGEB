<?php

namespace App\Models\Settings\Taxes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id', 
        'id', 
        'name', 
        'percentage',
    ];

    // TODO: Integrate TAX relationships to tables of other modules.
}
