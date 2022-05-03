<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubModule extends Model
{
    use HasFactory;

    protected $timestamps = false;

    public function module()
    {
        $this->belongsTo(Module::class);
    }

    public function permissions()
    {
        $this->hasMany(Permission::class);
    }
}
