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
    
    // basic salary
    public function basicSalary()
    {
        return $this->hasOne(BasicSalary::class, 'payroll_id');
    }

    // addition
    public function additions()
    {
        return $this->hasMany(Addition::class, 'payroll_id');
    }

    // deduction
    public function deductions()
    {
        return $this->hasMany(Deduction::class, 'payroll_id');
    }

    // overtime
    public function overtimes()
    {
        return $this->hasMany(Overtime::class, 'payroll_id');
    }

    // loan
    public function loans()
    {
        return $this->hasMany(Loan::class, 'payroll_id');
    }

    // tax
    public function taxpayroll()
    {
        return $this->hasOne(TaxPayroll::class, 'payroll_id');
    }

    // pension
    public function pension()
    {
        return $this->hasOne(Pension::class, 'payroll_id');
    }
    
}
