@extends('frontend.layouts.master')
@section('title','Add To Cart')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="">Cart</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
	<!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Shopping Summery -->
                    <table class="table shopping-summery">
                        <thead>
                            <tr class="main-hading">
                                <th>PRODUCT</th>
                                <th>NAME</th>
                                <th>SIZE</th>
                                <th class="text-center">UNIT PRICE</th>
                                <th class="text-center">QUANTITY</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                            </tr>
                        </thead>
                        <tbody id="cart_item_list">
                            @if(Helper::getAllProductFromCart())
                                @foreach(Helper::getAllProductFromCart() as $key => $cart)
                                    <tr data-id="{{ $cart->id }}">
                                        @php
                                        $photo = explode(',', $cart->product['photo']);
                                        @endphp
                                        <td class="image" data-title="No"><img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"></td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name"><a href="{{ route('product-detail', $cart->product['slug']) }}" target="_blank">{{ $cart->product['title'] }}</a></p>
                                            <p class="product-des">{!! $cart['summary'] !!}</p>
                                        </td>
                                        <td class="size" data-title="Size">{{ $cart->size }}</td>
                                        <td class="price" data-title="Price"><span>₱{{ number_format($cart['price'], 2) }}</span></td>
                                        <td class="qty" data-title="Qty">
                                            <!-- Input Order -->
                                            <div class="input-group">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[{{ $key }}]">
                                                        <i class="ti-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="quant[{{ $key }}]" class="input-number" data-min="1" data-max="100" value="{{ $cart->quantity }}">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{ $key }}]">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!--/ End Input Order -->
                                        </td>
                                        <td class="total-amount cart_single_price" data-title="Total"><span class="money">₱{{ $cart['amount'] }}</span></td>
                                        <td class="action" data-title="Remove"><a href="{{ route('cart-delete', $cart->id) }}"><i class="ti-trash remove-icon"></i></a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center">
                                        There are no any carts available. <a href="{{ route('product-grids') }}" style="color:blue;">Continue shopping</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!--/ End Shopping Summery -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-5 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="{{ route('coupon-store') }}" method="POST">
                                            @csrf
                                            <input name="code" placeholder="Enter Valid Coupon">
                                            <button class="btn">Apply Coupon</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-7 col-12">
                                <div class="right">
                                    <ul>
                                        <li class="order_subtotal" id="order_subtotal">Cart Subtotal<span>₱{{ number_format(Helper::totalCartPrice(), 2) }}</span></li>

                                        {{-- <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">Cart Subtotal<span>₱{{ number_format(Helper::totalCartPrice(), 2) }}</span></li> --}}
                                        @if(session()->has('coupon'))
                                            <li class="coupon_price" data-price="{{ Session::get('coupon')['value'] }}">You Save<span>₱{{ number_format(Session::get('coupon')['value'], 2) }}</span></li>
                                        @endif
                                        @php
                                            $total_amount = Helper::totalCartPrice();
                                            if(session()->has('coupon')){
                                                $total_amount = $total_amount - Session::get('coupon')['value'];
                                            }
                                        @endphp
                                        @if(session()->has('coupon'))
                                            <li class="last" id="order_total_price">You Pay<span>₱{{ number_format($total_amount, 2) }}</span></li>
                                        @else
                                            <li class="last" id="order_total_price">You Pay<span>₱{{ number_format($total_amount, 2) }}</span></li>
                                        @endif
                                    </ul>
                                    <div class="button5">
                                        <a href="{{ route('checkout') }}" class="btn">Checkout</a>
                                        <a href="{{ route('product-grids') }}" class="btn">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
	<!--/ End Shopping Cart -->


@endsection
@push('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;
				// alert(coupon);
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});

	</script>
<script>
    $(document).ready(function() {
    $('.btn-number').off('click').on('click', function(e) {
        e.preventDefault();

        var fieldName = $(this).attr('data-field');
        var type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());

        if (!isNaN(currentVal)) {
            if (type === 'minus') {
                if (currentVal > input.attr('data-min')) {
                    input.val(currentVal).change();
                }
            } else if (type === 'plus') {
                if (currentVal < input.attr('data-max')) {
                    input.val(currentVal).change();
                }
            }
        } else {
            input.val(0);
        }
    });

    $('.input-number').off('focusin').on('focusin', function() {
        $(this).data('oldValue', $(this).val());
    });

    $('.input-number').off('change').on('change', function() {
        var minValue = parseInt($(this).attr('data-min'));
        var maxValue = parseInt($(this).attr('data-max'));
        var valueCurrent = parseInt($(this).val());

        var id = $(this).closest('tr').data('id');

        if (valueCurrent >= minValue && valueCurrent <= maxValue) {
            $.ajax({
                url: '{{ route("cart.update") }}',
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    quantity: valueCurrent
                },
                success: function(response) {
                    if (response.status) {
                        $('#order_total_price span').text('₱' + response.total_price);
                        $('#order_subtotal span').text('₱' + response.order_subtotal);
                        $('tr[data-id="' + id + '"] .cart_single_price .money').text('₱' + response.cart_single_price);
                    } else {
                        alert(response.message);
                    }
                }
            });
        } else {
            $(this).val($(this).data('oldValue'));
        }
    });

    $(".input-number").off('keydown').on('keydown', function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});

</script>

@push('styles')
	<style>
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#F7941D !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}
	</style>
@endpush


@endpush
