<?php

namespace App\Http\Controllers;

use PDF;
use Helper;
use App\User;
use Notification;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\ShippingAddress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\StatusNotification;
use Carbon\Carbon;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('backend.order.index')->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'payment_method' => 'required|in:cod,paypal,cardpay',
        ]);

        $cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first();

        if (empty($cart)) {
            request()->session()->flash('error', 'Cart is Empty!');
            return back();
        }

        // Retrieve the shipping address details
        $shippingAddress = ShippingAddress::find($request->shipping_address_id);

        if (!$shippingAddress) {
            request()->session()->flash('error', 'Invalid shipping address!');
            return back();
        }

        // Retrieve the shipping details
        $shipping = Shipping::find($request->shipping);

        if (!$shipping) {
            request()->session()->flash('error', 'Invalid shipping method!');
            return back();
        }

        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = auth()->user()->id;
        $order_data['shipping_id'] = $shipping->id; // Store the shipping ID
        $order_data['recipient_name'] = $shippingAddress->recipient_name;
        $order_data['phone_number'] = $shippingAddress->phone_number;
        $order_data['country'] = $shippingAddress->country;
        $order_data['region'] = $shippingAddress->region;
        $order_data['city'] = $shippingAddress->city;
        $order_data['barangay'] = $shippingAddress->barangay;
        $order_data['street_building'] = $shippingAddress->street_building;
        $order_data['unit_floor'] = $shippingAddress->unit_floor;
        $order_data['additional_info'] = $shippingAddress->additional_info;
        $order_data['address_category'] = $shippingAddress->address_category;
        $order_data['default_shipping'] = $shippingAddress->default_shipping;
        $order_data['default_billing'] = $shippingAddress->default_billing;

        $shippingPrice = $shipping->price; // Retrieve the shipping price
        $order_data['sub_total'] = Helper::totalCartPrice();
        $order_data['quantity'] = Helper::cartCount();
        $order_data['total_amount'] = $order_data['sub_total'] + $shippingPrice - (session('coupon')['value'] ?? 0);

        if (session('coupon')) {
            $order_data['coupon'] = session('coupon')['value'];
        }

        if ($request->payment_method == 'paypal' || $request->payment_method == 'cardpay') {
            $order_data['payment_status'] = 'paid';
        } else {
            $order_data['payment_status'] = 'unpaid';
        }

        $order = new Order();
        $order->fill($order_data);
        $status = $order->save();

        if ($status) {
            // Associate the order with the cart items
            Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

            // Send notification to admin
            $users = User::where('role', 'admin')->first();
            $details = [
                'title' => 'New Order Received',
                'actionURL' => route('order.show', $order->id),
                'fas' => 'fa-file-alt'
            ];
            Notification::send($users, new StatusNotification($details));

            // Clear session data
            session()->forget('cart');
            session()->forget('coupon');

            request()->session()->flash('success', 'Your product order has been placed. Thank you for shopping with us.');

            if ($request->payment_method == 'paypal') {
                return redirect()->route('payment')->with(['id' => $order->id]);
            } else {
                return redirect()->route('home');
            }
        } else {
            request()->session()->flash('error', 'There was an issue processing your order. Please try again.');
            return back();
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('backend.order.edit')->with('order',$order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order=Order::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,process,delivered,cancel'
        ]);
        $data=$request->all();
        // return $request->status;
        if($request->status=='delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }
        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order=Order::find($id);
        if($order){
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->route('order.index');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack(){
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request){
        // return $request->all();
        $order=Order::where('user_id',auth()->user()->id)->where('order_number',$request->order_number)->first();
        if($order){
            if($order->status=="new"){
            request()->session()->flash('success','Your order has been placed.');
            return redirect()->route('home');

            }
            elseif($order->status=="process"){
                request()->session()->flash('success','Your order is currently processing.');
                return redirect()->route('home');

            }
            elseif($order->status=="delivered"){
                request()->session()->flash('success','Your order has been delivered. Thank you for shopping with us.');
                return redirect()->route('home');

            }
            else{
                request()->session()->flash('error','Sorry, your order has been canceled.');
                return redirect()->route('home');

            }
        }
        else{
            request()->session()->flash('error','Invalid order number. Please try again!');
            return back();
        }
    }


    // PDF generate
    public function pdf(Request $request)
{
    $order = Order::getAllOrder($request->id);
    
    // Get the order creation date
    $orderCreationDate = Carbon::parse($order->created_at)->format('D / m-d-Y');
    
    // Get today's date
    $currentDate = Carbon::now()->format('D / m-d-Y');

    $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
    
    $pdf = PDF::loadview('backend.order.pdf', compact('order', 'orderCreationDate', 'currentDate'));
    return $pdf->download($file_name);
}
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
    
}
// $cart=Cart::get();
        // // return $cart;
        // $cart_index='ORD-'.strtoupper(uniqid());
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }

        // $total_prod=0;
        // if(session('cart')){
        //         foreach(session('cart') as $cart_items){
        //             $total_prod+=$cart_items['quantity'];
        //         }
        // }

          // return $order_data['total_amount'];
        // $order_data['status']="new";
        // if(request('payment_method')=='paypal'){
        //     $order_data['payment_method']='paypal';
        //     $order_data['payment_status']='paid';
        // }
        // else{
        //     $order_data['payment_method']='cod';
        //     $order_data['payment_status']='Unpaid';
        // }
