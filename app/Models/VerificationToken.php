<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VerificationToken extends Model
{
    // Specify the table if it's not the plural form of the model name
    protected $table = 'verification_tokens';

    // Define fillable properties
    protected $fillable = ['token', 'expires_at', 'verified'];

    // Optionally define date properties for automatic casting
    protected $dates = ['expires_at'];

    // Optionally define default attribute values
    protected $attributes = [
        'verified' => false,
    ];
}
