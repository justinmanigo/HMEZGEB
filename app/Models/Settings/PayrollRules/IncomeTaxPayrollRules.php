<?php

namespace App\Models\Settings\PayrollRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeTaxPayrollRules extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'income',
        'rate',
        'deduction',
    ];
}
