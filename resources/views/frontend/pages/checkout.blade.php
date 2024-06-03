@extends('frontend.layouts.master')

@section('title','Checkout')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

<!-- Start Checkout -->
<section class="shop checkout section">
    <div class="container">
        <form class="form" method="POST" action="{{ route('cart.order') }}">
            @csrf
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <h2>Complete Your Purchase</h2>
                        <a href="{{ route('frontend.pages.shipping-address') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User">
                            <i class="fas fa-plus"></i> Add Shipping Address
                        </a>
                        <p>Just a few more steps to complete your purchase securely!</p>
                        @if($shippingAddresses->isNotEmpty())
                        <div class="form-group">
                            <label for="shipping_address" style=" font-weight:bold">Select Shipping Address  *</label>
                            <div class="shipping-address-buttons">
                                @foreach($shippingAddresses as $address)
                                    <div class="shipping-address-button">
                                        <input type="radio" name="shipping_address_id" id="shipping_address_{{ $address->id }}" value="{{ $address->id }}" required>
                                        <label for="shipping_address_{{ $address->id }}">
                                            <div class="address-header">
                                                <span class="recipient-name">{{ $address->recipient_name }}</span>
                                                <span class="address-category">{{ $address->address_category }}</span>
                                            </div>
                                            <div class="address-details">
                                                {{ $address->street_building }}, {{ $address->city }}, {{ $address->region }}, {{ $address->country }}
                                            </div>
                                        </label>
                                        <a href="{{ route('frontend.pages.edit-shipping-address', $address->id) }}" class="btn btn-primary btn-sm float-left mr-1 edit-button" data-toggle="tooltip" title="edit" data-placement="bottom">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p>No shipping addresses found. <a href="{{ route('frontend.pages.shipping-address') }}">Add a shipping address</a></p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>CART TOTAL</h2>
                            <div class="content">
                                <ul>
                                    <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">Cart Subtotal<span>₱{{ number_format(Helper::totalCartPrice(), 2) }}</span></li>
                                    <li class="shipping">
                                        Shipping Cost
                                        @if(count(Helper::shipping()) > 0 && Helper::cartCount() > 0)
                                            <select name="shipping" class="nice-select" required>
                                                <option value="">Select your address</option>
                                                @foreach(Helper::shipping() as $shipping)
                                                    <option value="{{ $shipping->id }}" class="shippingOption" data-price="{{ $shipping->price }}">{{ $shipping->type }}: ₱{{ $shipping->price }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <span>Free</span>
                                        @endif
                                    </li>
                                    @if(session('coupon'))
                                        <li class="coupon_price" data-price="{{ session('coupon')['value'] }}">You Save<span>₱{{ number_format(session('coupon')['value'], 2) }}</span></li>
                                    @endif
                                    @php
                                        $total_amount = Helper::totalCartPrice();
                                        if(session('coupon')){
                                            $total_amount = $total_amount - session('coupon')['value'];
                                        }
                                    @endphp
                                    <li class="last" id="order_total_price">Total<span>₱{{ number_format($total_amount, 2) }}</span></li>
                                </ul>
                            </div>
                        </div>
                        <!--/ End Order Widget -->
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>Payment Methods</h2>
                            <div class="content">
                                <div class="checkbox">
                                    {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                    <div class="form-group">
                                        <input name="payment_method" type="radio" value="cod" required> <label> Cash On Delivery</label><br>
                                        <!-- <input name="payment_method" type="radio" value="paypal"> <label> PayPal</label><br> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ End Order Widget -->
                        <!-- Payment Method Widget -->
                        <div class="single-widget payement">
                        </div>
                        <!--/ End Payment Method Widget -->
                        <!-- Button Widget -->
                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <button type="submit" class="btn">Proceed to Checkout</button>
                                </div>
                            </div>
                        </div>
                        <!--/ End Button Widget -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!--/ End Checkout -->



@endsection
@push('styles')
	<style>
        /* Container styles */
        .shop.checkout.section {
            padding: 20px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Checkout form styles */
        .checkout-form h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            position: relative;
        }

        .checkout-form h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 100px;
            height: 2px;
            background-color: #5cb85c;
        }

        .checkout-form .btn {
            padding: 10px 10px;
            background-color: #4c9100;
            color: white;
            font-size: 14px;
            padding: 5px 10px;
        }

        .checkout-form p {
            margin-top: -10px;
            font-size: 14px;
            color: #777;
        }

        /* Address button styles */
        .shipping-address-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .shipping-address-button {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #fbfbfb;
            border: 1px solid rgb(8, 79, 66);
            box-shadow: 5px 5px rgb(234, 247, 225);
            padding: 10px;
            border-radius: 5px;
            width: 100%;
        }
        .shipping-address-button:focus-within,.address-details,
        .shipping-address-button input:checked + label,
        .shipping-address-button input:checked + label + a {
            background-color: #2e4b01;
            padding: 10px;
            color:#fff;
            /* border: 1px solid rgb(8, 79, 66); */
            /* box-shadow: 5px 5px rgb(234, 247, 225); */
        }

        .shipping-address-button input {
            display: none;
        }

        .shipping-address-button label {
            flex-grow: 1;
            margin: 0;
            cursor: pointer;
            font-size: 14px;
        }
        .address-details{
            background-color: #ffffff;
            font-weight: 500;
            color:#2e4b01;
            margin-top: 5px;
        }
        .shipping-address-button a {
            height: 30px;
            width: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background-color: #01412a;
            font-weight: bold;
            font-size: 12px;
            text-decoration: none;
        }

        .shipping-address-button a:hover {
            background-color: #0056b3;
        }

        /* Order details styles */
        .order-details {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #e6e6e6;
            border-radius: 5px;
        }

        .order-details .single-widget {
            margin-bottom: 20px;
        }

        .order-details .single-widget h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .order-details .content ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .order-details .content ul li {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            padding: 5px 0;
        }

        .order-details .content ul li span {
            font-weight: bold;
        }

        /* Payment methods styles */
        .single-widget .content .form-group {
            margin: 0;
        }

        .single-widget .content .form-group label {
            font-size: 14px;
            margin: 0;
        }

        .single-widget .content .form-group input {
            margin-right: 10px;
        }
        /* .shop.checkout .form .form-group input {
            /* width: 100%; */
            /* height: 45px; */
            /* line-height: 50px;
            padding: 0 20px;
            border-radius: 3px;
            border-radius: 0px;
            color: #333 !important;
            border: none;
            background: #F6F7FB;} */

        /* Button styles */
        .get-button .btn {
            background-color: #1e541e;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .get-button .btn:hover {
            background-color: #025902;
        }

	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
		function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			// alert(checkbox);
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;
				// alert(coupon);
				$('#order_total_price span').text('₱'+(subtotal + cost-coupon).toFixed(2));
				$('#order_total_price span').text('₱'+(subtotal + cost-coupon).toFixed(2));
			});

		});

	</script>

<script>
    $(document).ready(function() {
        $('input[name="payment_method"]').change(function() {
            if ($(this).val() === 'cardpay') {
                $('#creditCardDetails').show();
            } else {
                $('#creditCardDetails').hide();
            }
        });
    });
</script>

@endpush
