<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'employee_id',
        'date',
        'price',
        'paid_in',
        'description',
    ];
}
