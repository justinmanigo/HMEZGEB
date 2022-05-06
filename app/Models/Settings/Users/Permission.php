<?php

namespace App\Models\Settings\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Permission extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'sub_module_id',
        'access_level',
    ];

    public function subModule()
    {
        $this->belongsTo(SubModule::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
