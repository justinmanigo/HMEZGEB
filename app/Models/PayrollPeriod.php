<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\AccountingPeriods;

class PayrollPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'accounting_system_id'
    ];
    
    public function period()
    {
        return $this->belongsTo(AccountingPeriods::class, 'period_id');
    }

    public function payroll()
    {
        return $this->hasOne(Payroll::class, 'payroll_period_id','id');
    }


}
