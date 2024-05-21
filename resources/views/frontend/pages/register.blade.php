@extends('frontend.layouts.master')

@section('title','Register')

@section('main-content')
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Create Account</h2>

                        <!-- Form -->
                        <form class="form" method="post" action="{{route('register.submit')}}">
                            <div class="col-12 social-login-buttons">
                                <a href="{{route('login.redirect','facebook')}}" class="btn btn-facebook"><i class="ti-facebook"></i></a>
                                <a href="{{ route('login.redirect', 'google') }}" class="btn btn-google"><i class="ti-google"></i></a>
                            </div>
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Your Name<span>*</span></label>
                                        <input type="text" name="name" placeholder="" required="required" value="{{old('name')}}">
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Your Email<span>*</span></label>
                                        <input type="text" name="email" placeholder="" required="required" value="{{old('email')}}">
                                        @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Your Password<span>*</span></label>
                                        <input type="password" name="password" placeholder="" required="required" value="{{old('password')}}">
                                        @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Confirm Password<span>*</span></label>
                                        <input type="password" name="password_confirmation" placeholder="" required="required" value="{{old('password_confirmation')}}">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">Register</button>
                                        <a href="{{route('login.form')}}" class="btn btn-google">Back to Login</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Login -->
@endsection

@push('styles')
<style>
.social-login-buttons {
    display: flex;
    justify-content: space-between; /* Ensure buttons are spaced out */
    margin-bottom: 20px; /* Adjust as needed for spacing between buttons and input */
    margin-left: 5px;
}

.social-login-buttons .btn {
    flex: 1; /* Make buttons take equal width */
    text-align: center; /* Center text inside the buttons */
    border-radius: 25px; /* Adjust for rounded corners */
}

.social-login-buttons .btn:last-child {
    margin-right: 10%; /* Remove margin from the last button */
}

.social-login-buttons .btn-facebook {
    margin-right: 10px; /* Space to the right of the Facebook button */
}
.social-login-buttons .btn-google {
    margin-left: 10px; /* Space to the left of the Google button */
}
    .btn {
        margin-right: 10px; /* Space between the social buttons */
    }

    .btn:last-child {
        margin-right: 0; /* Remove right margin from the last button */
    }

    .shop.login .form .btn{
        margin-right:0;
    }
    .btn-facebook{
        background:#39579A;
    }
    .btn-facebook:hover{
        background:#073088 !important;
    }
    .btn-github{
        background:#444444;
        color:white;
    }
    .btn-github:hover{
        background:black !important;
    }
    .btn-google{
        background:#ea4335;
        color:rgb(255, 255, 255);
    }
    .btn-google:hover{
        background:rgb(243, 26, 26) !important;
    }
</style>
@endpush
