<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;

class Transactions extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'accounting_system_id',
        'chart_of_account_id',
        'type',
        'description',
        'amount',
    ];
    
    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class);
    }
}
