<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_id',
        'source',
        'status',
        'amount',
    ];
    
}
