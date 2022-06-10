<?php

namespace App\Models\Settings\Withholding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withholding extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id', 
        'id', 
        'name', 
        'percentage',
    ];

    // TODO: Integrate Withholding relationships to tables of other modules.
}
