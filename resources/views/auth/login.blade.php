@extends('admin.layout.noauth')
@section('css')
    <link rel="apple-touch-icon" href="{{ asset('admin/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/vendors-rtl.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/pages/authentication.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/custom-rtl.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style-rtl.css') }}">
    <!-- END: Custom CSS-->
@endsection


@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-11 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <img src="{{ asset('admin/images/pages/login.png') }}" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Login</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">Welcome back, please login to your account.</p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                <form action="{{ route('login') }}" method="post">
                                                    @csrf

                                                            <div class="form-group has-feedback">
                                                                <x-input-label for="email" :value="__('Email')" />
                                                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                            </div>

                                                    {{-- <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" id="user-password" placeholder="Password" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="user-password">Password</label>
                                                    </fieldset> --}}
                                                                      <!-- Password -->
                                                    <div class="form-group has-feedback">
                                                        <x-input-label for="password" :value="__('Password')" />

                                                        <x-text-input id="password" class="form-control"
                                                                        type="password"
                                                                        name="password"
                                                                        required autocomplete="current-password" />

                                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                    </div>
                                                    <div class="form-group d-flex justify-content-between align-items-center">
                                                        <div class="text-left">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    {{-- <input type="checkbox"> --}}
                                                                    {{-- <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i> --}}
                                                                        </span>
                                                                    </span>
                                                                    {{-- <span class="">Remember me</span> --}}
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <x-primary-button class="btn btn-primary w-100  btn-inline m-3">
                                                            {{ __('Log in') }}
                                                        </x-primary-button>
                                                    </div>
                                                    {{-- <a href="auth-register.html" class="btn btn-outline-primary float-left btn-inline">Register</a> --}}

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->


@endsection

@section('script')

    <!-- BEGIN: Vendor JS-->
        <script src="{{ asset('admin/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
        <script src="{{ asset('admin/js/core/app-menu.js') }}"></script>
        <script src="{{ asset('admin/js/core/app.js') }}"></script>
        <script src="{{ asset('admin/js/scripts/components.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

@endsection

