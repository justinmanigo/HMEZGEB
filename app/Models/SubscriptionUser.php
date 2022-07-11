<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'accounting_system_id',
        'user_id',
        'role',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
