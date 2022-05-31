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
        'from_account_id',
        'to_account_id',
        'amount',
        'reason',
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
