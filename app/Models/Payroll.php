<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\AccountingPeriods;


class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_period_id',
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
        'total_pension_7',
        'total_pension_11',
        'net_pay',
    ];

    public function payrollPeriod()
    {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
