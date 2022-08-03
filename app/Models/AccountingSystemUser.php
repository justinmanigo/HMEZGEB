<?php

namespace App\Models;

use App\Models\Settings\Users\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingSystemUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'subscription_user_id',
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

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
