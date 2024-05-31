@extends('frontend.layouts.master')

@section('title', 'FAQs')

@section('main-content') 

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">FAQs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-lg-12 col-12">
                <div class="section-title">
                    <h1>CococarePH Frequently Asked Question</h1>
                </div>
            </div>
    </div>
                <div class="section-title">
                    <h2>What payment methods do you accept?</h2>
                    <p>We only accepts Cash On Delivery (COD).</p> 
                </div>
                <div class="section-title">
                    <h2>How are coconuts shipped, and what is the shipping cost?</h2>
                    <p>Coconut product we produce are carefully packaged to ensure freshness and are shipped via our partner shipping carrier. Shipping costs vary depending on your location and the quantity ordered. You can calculate the shipping cost at checkout before completing your purchase.</p>
                </div>
                <div class="section-title">
                    <h2>Can I return or exchange my order?</h2>
                    <p>We want you to be completely satisfied with your purchase. If for any reason you're not happy with your order, please contact us within 30 days of receiving it to arrange a return or exchange.</p>
                </div>
                <div class="section-title">
                    <h2>Can I track my order?</h2>
                    <p>Yes, you will receive a tracking number via user dashboard once your order has been processed and shipped. You can use this tracking number to monitor the status of your delivery.</p>                                 
                </div>
                <div class="section-title">
                    <h2>How long will it take to receive my order?</h2>
                    <p>Delivery times vary depending on your location and the shipping method chosen at checkout. Typically, orders are delivered within 3-5 business days.</p>                                 
                </div>

    <!-- Start Shop Services Area  -->
		<section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free Shipping</h4>
                        <p>Orders over ₱100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Easy Return</h4>
                        <p>Within 30 days</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Secure Payment</h4>
                        <p>100% Secure Payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Price</h4>
                        <p>Guaranteed Price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services -->

@endsection