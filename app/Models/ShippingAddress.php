<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model {
    protected $fillable = [
        'user_id', 'recipient_name', 'phone_number', 'region', 'country', 'city', 'barangay',
        'street_building', 'unit_floor', 'additional_info', 'address_category',
        'default_shipping', 'default_billing'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
