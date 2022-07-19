<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\PayrollRules\OvertimePayrollRules;

class Overtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'employee_id',
        'date',
        'from',
        'to',
        'price',
        'description'
    ];

    public function calculateHourRate($employee_id)
    {
        $employee = Employee::find($employee_id);
        $overtime_payroll_rules = OvertimePayrollRules::where('accounting_system_id', $this->accounting_system_id)->first();
        $hourRate = $employee->basic_salary / $overtime_payroll_rules->working_days/$overtime_payroll_rules->working_hours;
        return $hourRate;
    }

    public function dayRate($amount)
    {
        $overtime_payroll_rules = OvertimePayrollRules::where('accounting_system_id', $this->accounting_system_id)->first();
        return $overtime_payroll_rules->day_rate*$amount;
    }

    public function nightRate($amount)
    {
        $overtime_payroll_rules = OvertimePayrollRules::where('accounting_system_id', $this->accounting_system_id)->first();
        return $overtime_payroll_rules->night_rate*$amount;
    }

    public function holidayWeekendRate($amount)
    {
        $overtime_payroll_rules = OvertimePayrollRules::where('accounting_system_id', $this->accounting_system_id)->first();
        return $overtime_payroll_rules->holiday_weekend_rate*$amount;
    }
}
