<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\HasReferralCode;

class Referral extends Model
{
    use HasFactory, HasReferralCode;

    protected $fillable = [
        'user_id',
        'type',
        'trial_duration',
        'trial_duration_type',
        'name',
        'email',
        'commission',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
