@extends('frontend.layouts.master')
@section('title','Eco-Tracker')
@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Eco-Tracker</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Eco-Tracker -->
    <section class="shop checkout section">
        <div class="container">
            <form class="form" method="POST" action="{{ route('cart.order') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="checkout-form">
                            <div class="logo">
								<a href="index.html"><img src="{{asset('backend/img/slider2.png')}}" alt="#"></a>
							</div>
                            <h1>Complete Your Daily Task</h1>
                            <p>Just a few seconds to complete this!</p>
                            <!-- Form -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="checkbox-label">
                                    <input name="task" type="checkbox" value="task1" required>
                                    <label>Use water wisely in the morning: Take shorter showers and turn off the faucet while brushing your teeth.</label><br>
                                    <input name="task" type="checkbox" value="task2" required>
                                    <label> Use alternative transportation methods: Take public transportation, carpool, or bike to work or school.</label><br>
                                    <input name="task" type="checkbox" value="task3" required>
                                    <label> Use energy-efficient appliances and lights at work or school: Turn off electronics when not in use.</label><br>
                                    <input name="task" type="checkbox" value="task4" required>
                                    <label> Use reusable containers and utensils for meals: Opt for locally sourced or plant-based food options.</label><br>
                                    <input name="task" type="checkbox" value="task5" required>
                                    <label> Use breaks to participate in community clean-ups: Help keep public spaces litter-free.</label><br>
                                    <input name="task" type="checkbox" value="task6" required>
                                    <label> Use separate bins for recycling and composting at home: Reduce waste and promote recycling.</label><br>
                                    <input name="task" type="checkbox" value="task7" required>
                                    <label> Use your evening to educate yourself and others: Watch documentaries or read articles on environmental issues.</label><br>
                                    <input name="task" type="checkbox" value="task8" required>
                                    <label> Use energy-saving habits before bed: Turn off lights, unplug devices, and adjust the thermostat for efficiency.</label><br>
                                    <input name="task" type="checkbox" value="task9" required>
                                    <label> Use reusable shopping bags and avoid single-use plastics: Bring your own bags when shopping to reduce plastic waste.</label><br>
                                    <input name="task" type="checkbox" value="task10" required>
                                    <label> Use water-saving techniques in the garden: Install drip irrigation systems and collect rainwater for watering plants.</label><br>
                                </div>
                                </div>
                            </div>
                            <!--/ End Form -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--/ End Checkout -->

    <!-- Start Shop Services Area  -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shiping</h4>
                        <p>Orders over ₱100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Sucure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Piece</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services -->

@endsection
@push('styles')
<style>
    .checkbox-label {
        margin-bottom: 10px; /* Add spacing between checkboxes */
    }

    .checkbox-label input[type="checkbox"] {
        vertical-align: middle; /* Align checkboxes vertically */
    }

    .checkbox-label label {
        vertical-align: middle; /* Align labels vertically */
        margin-left: 5px; /* Add spacing between checkbox and label */
        display: inline;
    }
</style>
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
