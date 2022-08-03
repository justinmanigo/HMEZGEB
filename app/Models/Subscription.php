<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referral_id',
        'account_limit',
        'account_type',
        'date_from',
        'date_to',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referral_user_id', 'user_id');
    }

    public function accountingSystems()
    {
        return $this->hasMany(AccountingSystem::class);
    }

    public function subscriptionUsers()
    {
        return $this->hasMany(SubscriptionUser::class);
    }
}
