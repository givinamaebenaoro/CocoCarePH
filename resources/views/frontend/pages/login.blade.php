@extends('frontend.layouts.master')

@section('title', 'Login')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Login</a></li>
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
                        <h2>Login</h2>
                        <!-- Form -->
                        <form class="form" method="post" action="{{ route('login.submit') }}">
                            <div class="col-12 social-login-buttons">
                                <a href="{{ route('facebook.login') }}" class="btn btn-facebook"><i
                                        class="ti-facebook"></i></a>
                                <a href="{{ route('google.login') }}" class="btn btn-google"><i
                                        class="ti-google"></i></a>
                            </div>
                            @csrf
                            <div class="col-12">
                                <div class="registerform-group">
                                    <input type="text" name="email" placeholder=" " required="required"
                                        value="{{ old('email') }}">
                                    <label>Email<span>*</span></label>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="registerform-group">
                                    <input type="password" name="password" placeholder=" " required="required"
                                        value="{{ old('password') }}">
                                    <label>Password<span>*</span></label>
                                    <i class="fas fa-eye toggle-password"></i>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group login-btn">
                                    <button class="btn btn-facebook" type="submit">Login</button>
                                </div>
                                <div class="form-options">
                                    <div class="checkbox">
                                        <label class="checkbox-inline" for="2">
                                            <input name="news" id="2" type="checkbox">Remember me
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="lost-pass" href="{{ route('password.reset') }}">
                                            Lost your password?
                                        </a>
                                    @endif
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
@push('script')
    <script>
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
    @push('styles')
        <style>
            .form-options {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 1em;
            }

            .checkbox-inline {
                font-weight: bold;
            }

            .lost-pass {
                color: #004500;
                /* Adjust color as needed */
                text-decoration: none;
                font-style: italic;
                margin-left: auto;
                /* Pushes the link to the far right */
            }

            .lost-pass:hover {
                text-decoration: underline;
            }

            .register-section {
                width: 100%;
                max-width: 500px;
                padding: 20px;
                background: white;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            .registerform-group {
                position: relative;
                margin-top: 1em;
                text-align: center;
            }

            .registerform-group input {
                width: 95%;
                height: 50px;
                padding: 0 20px;
                border: 1px solid #626762;
                border-radius: 25px;
                background: rgb(255, 255, 255);

            }

            .registerform-group label {
                position: absolute;
                top: 50%;
                left: 35px;
                transform: translateY(-50%);
                transition: 0.2s;
                background: rgb(255, 255, 255);
                padding: 0 0.2em;
            }

            .registerform-group input:focus+label,
            .registerform-group input:not(:placeholder-shown)+label {
                top: -1px;
                left: 50px;
                font-size: 0.8em;
                color: #098c07;
            }

            .registerform-group .toggle-password {
                position: absolute;
                right: 45px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
            }

            .text-danger {
                color: red;
                font-size: 0.8em;
            }

            .login-btn {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 1em;
            }

            .login-btn .btn {
                margin-top: 15px;
                width: 50%;
                height: 50px;
                background-color: #004500;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                text-align: center;
                line-height: 50px;
                /* Ensure vertical centering of text */
            }

            .login-btn .btn-google {
                background-color: #dd4b39;
            }

            .social-login-buttons {
                display: flex;
                justify-content: space-between;
                /* Ensure buttons are spaced out */
                margin-bottom: 20px;
                /* Adjust as needed for spacing between buttons and input */
                margin-left: 5px;
            }

            .social-login-buttons .btn {
                flex: 1;
                /* Make buttons take equal width */
                text-align: center;
                /* Center text inside the buttons */
                border-radius: 25px;
                /* Adjust for rounded corners */
            }

            .social-login-buttons .btn:last-child {
                margin-right: 10%;
                /* Remove margin from the last button */
            }

            .social-login-buttons .btn-facebook {
                margin-right: 10px;
                /* Space to the right of the Facebook button */
            }

            .social-login-buttons .btn-google {
                margin-left: 10px;
                /* Space to the left of the Google button */
            }

            .login-btn {
                display: flex;
                justify-content: center;
                /* Center the buttons */
                gap: 10px;
                /* Space between the buttons */
            }

            .login-btn .btn {
                flex: 1;
                /* Make both buttons take equal width */
                max-width: 100%;
                /* Optional: Set a maximum width for the buttons */
                text-align: center;
                /* Center text inside the buttons */
                padding: 10px;
                /* Adjust padding for better appearance */
                border-radius: 20px;
                /* Adjust for rounded corners */
            }

            .form-group input[type="text"] {
                width: 100%;
                padding: 10px;
                /* Ensure padding matches the buttons for consistent height */
                box-sizing: border-box;
                /* Include padding and border in the element's total width and height */
                border-radius: 20px;
                /* Match the input's border-radius with buttons */
            }

            .btn {
                margin-right: 10px;
                /* Space between the social buttons */
            }

            .btn:last-child {
                margin-right: 0;
                /* Remove right margin from the last button */
            }

            .shop.login .form .btn {
                margin-right: 0;
            }

            .btn-facebook {
                background: #39579A;
            }

            .btn-facebook:hover {
                background: #073088 !important;
            }

            .btn-github {
                background: #444444;
                color: white;
            }

            .btn-github:hover {
                background: black !important;
            }

            .btn-google {
                background: #ea4335;
                color: rgb(255, 255, 255);
            }

            .btn-google:hover {
                background: rgb(243, 26, 26) !important;
            }
        </style>
    @endpush
