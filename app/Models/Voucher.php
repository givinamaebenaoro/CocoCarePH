<?php

namespace App\Models;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable=['title','slug','summary','photo','status','added_by'];

    public function parent_info(){
        return $this->hasOne('App\Models\Voucher','id','parent_id');
    }
    public static function getAllVoucher(){
        return  Voucher::orderBy('id','DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id){
        return Voucher::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }

    public function child_cat(){
        return $this->hasMany('App\Models\Voucher','parent_id','id')->where('status','active');
    }
    public static function getAllParentWithChild(){
        return Voucher::with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title','ASC')->get();
    }
    public function products(){
        return $this->hasMany('App\Models\Product','cat_id','id')->where('status','active');
    }
    public function sub_products(){
        return $this->hasMany('App\Models\Product','child_cat_id','id')->where('status','active');
    }
    public static function getProductByCat($slug){
        // dd($slug);
        return Voucher::with('products')->where('slug',$slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    public static function getProductBySubCat($slug){
        // return $slug;
        return Voucher::with('sub_products')->where('slug',$slug)->first();
    }
    public static function countActiveVoucher(){
        $data=Voucher::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
