<?php

namespace App\Models\ChartOfAccounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccountCategory extends Model
{
    use HasFactory;
    

    public function account()
    {
        return $this->belongsTo(ChartOfAccounts::class);
    }
}
