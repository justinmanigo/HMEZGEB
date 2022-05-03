<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $timestamps = false;

    public function subModules()
    {
        $this->hasMany(SubModule::class);
    }
}
