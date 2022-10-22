<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\AccountingPeriods;
use App\Models\Settings\ChartOfAccounts\JournalEntries;
use App\Models\PayrollPayments;

class PayrollPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'accounting_system_id',
        'journal_entry_id',
    ];
    
    public function period()
    {
        return $this->belongsTo(AccountingPeriods::class, 'period_id');
    }

    public function payroll()
    {
        return $this->hasOne(Payroll::class, 'payroll_period_id','id');
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'payroll_period_id','id');
    }

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntries::class, 'journal_entry_id');
    }

    public function payrollPayment()
    {
        return $this->hasOne(PayrollPayments::class, 'payroll_period_id','id');
    }
}
