<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id', 'product_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','recipient_name',
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
    'default_billing','payment_method',
    'payment_status',
    'shipping_id',
    'coupon'];

    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return Order::with('cart_info')->find($id);
    }
    public static function countActiveOrder(){
        $data=Order::count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public static function countNewReceivedOrder(){
        $data = Order::where('status', 'new')->count();
        return $data;
    }
    public static function countProcessingOrder(){
        $data = Order::where('status', 'process')->count();
        return $data;
    }
    public static function countDeliveredOrder(){
        $data = Order::where('status', 'delivered')->count();
        return $data;
    }
    public static function countCancelledOrder(){
        $data = Order::where('status', 'cancel')->count();
        return $data;
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

}
