<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        'recipient_name',
        'phone_number',
        'country',
        'region',
        'city',
        'barangay',
        'street_building',
        'unit_floor',
        'additional_info',
        'address_category',
        'default_shipping',
        'default_billing',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
}
