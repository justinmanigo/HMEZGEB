<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'month_from',
        'day_from',
        'month_to',
        'day_to',
        'month_from_leap',
        'day_from_leap',
        'month_to_leap',
        'day_to_leap',
        'month_from_ethiopian',
        'day_from_ethiopian',
        'month_to_ethiopian',
        'day_to_ethiopian',
        'month_from_leap_ethiopian',
        'day_from_leap_ethiopian',
        'month_to_leap_ethiopian',
        'day_to_leap_ethiopian',
        'accounting_system_user_id',
    ];
}
