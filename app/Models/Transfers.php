<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfers extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'accounting_system_id',
        'from_account_id',
        'to_account_id',
        'amount',
        'reason',
        'status',
        'journal_entry_id',
        'transaction_id',
    ];

    public function fromAccount()
    {
        return $this->belongsTo(BankAccounts::class, 'from_account_id');
    }

    public function toAccount()
    {
        return $this->belongsTo(BankAccounts::class, 'to_account_id');
    }
}
