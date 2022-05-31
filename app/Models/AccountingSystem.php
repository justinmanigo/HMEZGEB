<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'calendar_type',
        'accounting_year',
        'name',
        'address',
        'po_box',
        'postal_code',
        'city',
        'mobile_number',
        'telephone_1',
        'telephone_2',
        'fax',
        'website',
        'vat_number',
        'tin_number',
        'contact_person',
        'contact_person_position',
        'contact_person_mobile_number',
        'business_type',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function accountingSystemUsers()
    {
        return $this->hasMany(AccountingSystemUser::class);
    }
}
