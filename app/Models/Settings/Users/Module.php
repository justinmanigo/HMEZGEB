<?php

namespace App\Models\Settings\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function subModules()
    {
        return $this->hasMany(SubModule::class);
    }
}
