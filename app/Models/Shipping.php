<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Shipping extends Model
{
    protected $fillable=['type','base_price','weight','price_per_kg','status'];

    public static function calculateShippingCost($region, $weight)
    {
        $shipping = self::where('region', $region)->first();
        if ($shipping) {
            return $shipping->base_price + ($shipping->price_per_kg * $weight);
        }
        return 0;
    }
}
