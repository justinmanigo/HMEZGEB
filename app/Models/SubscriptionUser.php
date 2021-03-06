<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'user_id',
        'role',
        'is_accepted',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accountingSystemAccess()
    {
        return $this->hasMany(AccountingSystemUser::class);
    }
}
