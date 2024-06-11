<?php

namespace App\Http\Controllers;
use Auth;
use Helper;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use App\ShippingAddress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function addToCart(Request $request) {
        // Validate request
        $request->validate([
            'slug' => 'required',
            'size' => 'required'
        ]);

        // Fetch the product using slug
        $product = Product::where('slug', $request->slug)->first();

        // Check if product exists
        if (empty($product)) {
            request()->session()->flash('error', 'Invalid Product');
            return back();
        }

        // Check if product is already in cart
        $already_cart = Cart::where('user_id', auth()->user()->id)
                            ->where('order_id', null)
                            ->where('product_id', $product->id)
                            ->where('size', $request->size)
                            ->first();

        // Remove product from cart if it is sold out or has 0 quantity
        if ($already_cart && ($product->stock <= 0)) {
            $already_cart->delete();
            request()->session()->flash('error', 'Product removed from cart due to insufficient stock');
            return back();
        }

        // If the product is already in the cart and has sufficient stock
        if ($already_cart) {
            $already_cart->quantity += 1;
            $already_cart->amount += $product->price;

            // Check stock availability
            if ($product->stock < $already_cart->quantity || $product->stock <= 0) {
                $already_cart->quantity -= 1;
                $already_cart->amount -= $product->price;
                return back()->with('error', 'Stock not sufficient!');
            }

            $already_cart->save();
        } else {
            // Create new cart entry
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = 1;
            $cart->size = $request->size;
            $cart->amount = $cart->price * $cart->quantity;

            // Check stock availability
            if ($product->stock < $cart->quantity || $product->stock <= 0) {
                return back()->with('error', 'Stock not sufficient!');
            }

            $cart->save();
            $wishlist = Wishlist::where('user_id', auth()->user()->id)
                                ->where('cart_id', null)
                                ->update(['cart_id' => $cart->id]);
        }

        request()->session()->flash('success', 'Product has been added to cart');
        return back();
    }


    public function singleAddToCart(Request $request) {
        // Validate request
        $request->validate([
            'slug' => 'required',
            'quant' => 'required',
            'size' => 'required'
        ]);

        // Fetch the product using slug
        $product = Product::where('slug', $request->slug)->first();

        // Check stock availability
        if ($product->stock < $request->quant[1]) {
            return back()->with('error', 'Out of stock, You can add other products.');
        }

        // Check if product is valid and quantity is at least 1
        if ($request->quant[1] < 1 || empty($product)) {
            request()->session()->flash('error', 'Invalid Product');
            return back();
        }

        // Check if product already in cart
        $already_cart = Cart::where('user_id', auth()->user()->id)
                            ->where('order_id', null)
                            ->where('product_id', $product->id)
                            ->where('size', $request->size)
                            ->first();

        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            $already_cart->amount = ($product->price * $request->quant[1]) + $already_cart->amount;

            // Check stock availability
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) {
                return back()->with('error', 'Stock not sufficient!');
            }

            $already_cart->save();
        } else {
            // Create new cart entry
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = $request->quant[1];
            $cart->size = $request->size;
            $cart->amount = ($product->price * $request->quant[1]);

            // Check stock availability
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) {
                return back()->with('error', 'Stock not sufficient!');
            }

            $cart->save();
        }

        request()->session()->flash('success', 'Product has been added to cart.');
        return back();
    }


    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success','Cart removed successfully');
            return back();
        }
        request()->session()->flash('error','Error please try again');
        return back();
    }

    public function cartUpdate(Request $request){
        $cart = Cart::find($request->id);

    if ($cart) {
        $quantity = $request->quantity;

        if ($quantity > 0) {
            if ($cart->product->stock < $quantity) {
                return response()->json(['status' => false, 'message' => 'Out of stock']);
            }

            $cart->quantity = min($quantity, $cart->product->stock);

            $after_price = $cart->product->price - ($cart->product->price * $cart->product->discount / 100);
            $cart->amount = $after_price * $quantity;
            $cart->save();

            $total_price = Helper::totalCartPrice();
            $cart_single_price = $cart->amount;

            return response()->json([
                'status' => true,
                'total_price' => number_format($total_price, 2),
                'cart_single_price' => number_format($cart_single_price, 2),
                'order_subtotal' => number_format($total_price, 2)
            ]);
        }
    }

    return response()->json(['status' => false, 'message' => 'Invalid quantity']);
        // // dd($request->all());
        // if($request->quant){
        //     $error = array();
        //     $success = '';
        //     // return $request->quant;
        //     foreach ($request->quant as $k=>$quant) {
        //         // return $k;
        //         $id = $request->qty_id[$k];
        //         // return $id;
        //         $cart = Cart::find($id);
        //         // return $cart;
        //         if($quant > 0 && $cart) {
        //             // return $quant;

        //             if($cart->product->stock < $quant){
        //                 request()->session()->flash('error','Out of stock');
        //                 return back();
        //             }
        //             $cart->quantity = ($cart->product->stock > $quant) ? $quant  : $cart->product->stock;
        //             // return $cart;

        //             if ($cart->product->stock <=0) continue;
        //             $after_price=($cart->product->price-($cart->product->price*$cart->product->discount)/100);
        //             $cart->amount = $after_price * $quant;
        //             // return $cart->price;
        //             $cart->save();
        //             $success = 'Cart updated successfully!';
        //         }else{
        //             $error[] = 'Cart Invalid!';
        //         }
        //     }
        //     return back()->with($error)->with('success', $success);
        // }else{
        //     return back()->with('Cart Invalid!');
        // }
    }


    public function checkout(Request $request) {
        $user = Auth::user();

        // Ensure to check the correct relationship or field that indicates if the user has a shipping address
        if ($user->shippingAddresses()->exists()) {
            $shippingAddresses = $user->shippingAddresses;
            return view('frontend.pages.checkout', compact('shippingAddresses', 'vatAmount'));
        } else {
            return redirect()->route('frontend.pages.shipping-address');
        }
    }







    public function completeTask(Request $request)
    {
        $user = Auth::user();
        $tasksCompleted = $request->input('task');
        // Update the user's task completion status
        foreach ($tasksCompleted as $task) {
            $user->{$task . '_completed'} = true;
        }
        $user->save();
        // Redirect or return response
    }
    // public function addToCart(Request $request){
    //     // return $request->all();
    //     if(Auth::check()){
    //         $qty=$request->quantity;
    //         $this->product=$this->product->find($request->pro_id);
    //         if($this->product->stock < $qty){
    //             return response(['status'=>false,'msg'=>'Out of stock','data'=>null]);
    //         }
    //         if(!$this->product){
    //             return response(['status'=>false,'msg'=>'Product not found','data'=>null]);
    //         }
    //         // $session_id=session('cart')['session_id'];
    //         // if(empty($session_id)){
    //         //     $session_id=Str::random(30);
    //         //     // dd($session_id);
    //         //     session()->put('session_id',$session_id);
    //         // }
    //         $current_item=array(
    //             'user_id'=>auth()->user()->id,
    //             'id'=>$this->product->id,
    //             // 'session_id'=>$session_id,
    //             'title'=>$this->product->title,
    //             'summary'=>$this->product->summary,
    //             'link'=>route('product-detail',$this->product->slug),
    //             'price'=>$this->product->price,
    //             'photo'=>$this->product->photo,
    //         );

    //         $price=$this->product->price;
    //         if($this->product->discount){
    //             $price=($price-($price*$this->product->discount)/100);
    //         }
    //         $current_item['price']=$price;

    //         $cart=session('cart') ? session('cart') : null;

    //         if($cart){
    //             // if anyone alreay order products
    //             $index=null;
    //             foreach($cart as $key=>$value){
    //                 if($value['id']==$this->product->id){
    //                     $index=$key;
    //                 break;
    //                 }
    //             }
    //             if($index!==null){
    //                 $cart[$index]['quantity']=$qty;
    //                 $cart[$index]['amount']=ceil($qty*$price);
    //                 if($cart[$index]['quantity']<=0){
    //                     unset($cart[$index]);
    //                 }
    //             }
    //             else{
    //                 $current_item['quantity']=$qty;
    //                 $current_item['amount']=ceil($qty*$price);
    //                 $cart[]=$current_item;
    //             }
    //         }
    //         else{
    //             $current_item['quantity']=$qty;
    //             $current_item['amount']=ceil($qty*$price);
    //             $cart[]=$current_item;
    //         }

    //         session()->put('cart',$cart);
    //         return response(['status'=>true,'msg'=>'Cart successfully updated','data'=>$cart]);
    //     }
    //     else{
    //         return response(['status'=>false,'msg'=>'You need to login first','data'=>null]);
    //     }
    // }

    // public function removeCart(Request $request){
    //     $index=$request->index;
    //     // return $index;
    //     $cart=session('cart');
    //     unset($cart[$index]);
    //     session()->put('cart',$cart);
    //     return redirect()->back()->with('success','Successfully remove item');
    // }
    // public function checkout(Request $request){
    //     // $cart=session('cart');
    //     // $cart_index=\Str::random(10);
    //     // $sub_total=0;
    //     // foreach($cart as $cart_item){
    //     //     $sub_total+=$cart_item['amount'];
    //     //     $data=array(
    //     //         'cart_id'=>$cart_index,
    //     //         'user_id'=>$request->user()->id,
    //     //         'product_id'=>$cart_item['id'],
    //     //         'quantity'=>$cart_item['quantity'],
    //     //         'amount'=>$cart_item['amount'],
    //     //         'status'=>'new',
    //     //         'price'=>$cart_item['price'],
    //     //     );

    //     //     $cart=new Cart();
    //     //     $cart->fill($data);
    //     //     $cart->save();
    //     // }
    //     return view('frontend.pages.checkout');
    // }
}
