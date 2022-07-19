<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\AccountingPeriods;


class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'employee_id',
        'accounting_system_id',
        'status',
        'paid_by',
        'total_salary',
        'total_addition',
        'total_deduction',
        'total_overtime',
        'total_loan',
        'total_tax',
        'total_pension',
    ];

    public function period()
    {
        return $this->belongsTo(AccountingPeriods::class, 'period_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
