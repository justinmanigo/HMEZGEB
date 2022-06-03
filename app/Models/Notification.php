<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'source',
        'resolved',
        'time_resolved',
        'link',
        'type',
        'title',
        'message',
    ];
}
