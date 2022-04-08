<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;
        
    protected $fillable = [
        'date',
        'due_date',
        'vendor_id',
        'bill_number',
        'order_number',
        'sub_total',
        'tax',
        'grand_total',
        'cash_from',
        'attachment',
        'note',
        'total_amount_received'
    ];

        public function vendor()
        {
            return $this->belongsTo(Vendors::class, 'vendor_id');
        }
}
