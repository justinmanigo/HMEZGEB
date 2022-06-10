<?php

namespace App\Models\Settings\PayrollRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimePayrollRules extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'working_days',
        'working_hours',
        'day_rate',
        'night_rate',
        'holiday_weekend_rate',
    ];
    
}
