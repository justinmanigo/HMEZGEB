<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimePayrollRules extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'working_days',
        'working_hours',
        'day_rate',
        'night_rate',
        'holiday_weekend_rate',
    ];
    
}
