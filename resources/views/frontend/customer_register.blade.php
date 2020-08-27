@extends('layouts.frontend_app')

@section('frontend_content')
    <!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Account</h2>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><span>Register</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- checkout-area start -->
    <div class="account-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                    <div class="account-form form-style">
                        <form action="{{ url('customer/register/post') }}" method = "post">
                        @csrf
                            <p>Name</p>
                            <input type="text" name = "name">
                            <p>User Name or Email Address *</p>
                            <input type="text" name = "email">
                            <p>Password *</p>
                            <input type="Password" name = "password">
                            <p>Confirm Password *</p>
                            <input type="Password" name = "confirm_password">
                            <button>Register</button>
                            <div class="text-center">
                                <a href="{{ route('login') }}">Or Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- checkout-area end -->
@endsection
