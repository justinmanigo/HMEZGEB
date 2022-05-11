<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingSystemUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'user_id',
        'role',
    ];

    public function accountingSystem()
    {
        return $this->belongsTo(AccountingSystem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
