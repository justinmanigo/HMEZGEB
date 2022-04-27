<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'first_name',
        'father_name',
        'grandfather_name',
        'date_of_birth',
        'mobile_number',
        'telephone',
        'email',
        'tin_number',
        'type',
        'basic_salary',
        'date_started_working',
        'date_ended_working',
        'emergency_contact_person',
        'emergency_contact_number'
    ];
    use HasFactory;
}
