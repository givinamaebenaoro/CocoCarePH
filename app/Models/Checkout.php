<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'checkouts';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'address1',
        'address2',
        'post_code',
    ];
}
