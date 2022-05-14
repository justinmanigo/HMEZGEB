<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_limit',
        'referral_user_id',
        'referral_code',
        'referral_type',
        'trial_from',
        'trial_to',
        'status',   // temporarily added just in case its needed. 
                    // was disabled in migrations
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
}
