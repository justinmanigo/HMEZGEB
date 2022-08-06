<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Payroll;

class BasicSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'employee_id',
        'payroll_id',
        'price',
        'status',
    ];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
