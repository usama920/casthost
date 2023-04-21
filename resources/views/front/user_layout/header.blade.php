<!DOCTYPE html>
@php
    $settings = settings();
@endphp
<html class="photography-demo-2">
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>@yield('page_title') - {{$settings->site_title}}</title>

    <meta name="keywords" content="WebSite Template" />
    <meta name="description" content="Porto - Multipurpose Website Template">
    <meta name="author" content="okler.net">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('front_assets/img/favicon.ico')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{asset('front_assets/img/apple-touch-icon.png')}}">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

    <!-- Web Fonts  -->
    <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CPT+Sans:400,700&display=swap" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/vendor/animate/animate.compat.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/vendor/simple-line-icons/css/simple-line-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/vendor/owl.carousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/vendor/magnific-popup/magnific-popup.min.css')}}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/theme-elements.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/theme-blog.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/theme-shop.css')}}">

    <!-- Revolution Slider CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/vendor/rs-plugin/css/settings.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/vendor/rs-plugin/css/layers.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/vendor/rs-plugin/css/navigation.css')}}">

    <!-- Demo CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/css/demos/demo-photography-2.css')}}">

    <!-- Skin CSS -->
    <link id="skinCSS" rel="stylesheet" href="{{asset('front_assets/css/skins/skin-photography.css')}}">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/css/custom.css')}}">

    <!-- Head Libs -->
    <script src="{{asset('front_assets/vendor/modernizr/modernizr.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</head>

<body class="loading-overlay-showing" data-loading-overlay data-plugin-options="{'hideDelay': 500}">
    <div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <div class="body">
        <header id="header" class="header-full-width transparent-header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyStartAt': 78, 'stickySetTop': '0'}">
            <div class="header-body">
                <div class="header-container container">
                    <div class="header-row">
                        <div class="header-column">
                            <div class="header-row">
                                <div class="header-logo">
                                    <a href="{{url('/')}}">
                                        <img alt="Porto" width="150" height="39" style="image-rendering: auto;" src="{{asset('project_assets/images/'.$settings->site_logo)}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="header-column justify-content-end">
                            <div class="header-row">
                                <div class="header-nav">
                                    <div class="header-nav-main header-nav-main-photography-effect-1 header-nav-main-sub-effect-1">
                                        <nav class="collapse">
                                            <ul class="nav nav-pills" id="mainNav">
                                                <li class="dropdown-primary">
                                                    <a class="nav-link @yield('navbar_home')" href="{{url('/'.$user->username)}}">
                                                        Home
                                                    </a>
                                                </li>
                                                <li class="dropdown-primary">
                                                    <a class="nav-link @yield('navbar_store')" href="{{url('/'.$user->username.'/store')}}">
                                                        Store
                                                    </a>
                                                </li>
                                                @if (is_subscriber())
                                                <li class="dropdown-primary">
                                                    <a class="nav-link @yield('navbar_cart')" href="{{url('/'.$user->username.'/cart')}}">
                                                        Cart
                                                    </a>
                                                </li>
                                                @endif
                                                <li class="dropdown-primary">
                                                    <a class="nav-link @yield('navbar_about')" href="{{url('/'.$user->username.'/about')}}">
                                                        About
                                                    </a>
                                                </li>
                                                <li class="dropdown-primary">
                                                    <a class="nav-link @yield('navbar_contact')" href="{{url('/'.$user->username.'/contact')}}">
                                                        Contact
                                                    </a>
                                                </li>
                                                @if (any_logged_in())
                                                    @if(logged_in())
                                                        <li>
                                                            <a class="dropdown-item @yield('navbar_login')"
                                                                href="{{ url('/users/Dashboard') }}">
                                                                Dashboard
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a class="dropdown-item @yield('navbar_login')"
                                                                href="{{ url('/admin/dashboard') }}">
                                                                Dashboard
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if (is_subscriber())
                                                    <li>
                                                        <a class="dropdown-item @yield('navbar_profile')"
                                                            href="{{url('/'.$user->username.'/subscriber/profile')}}">
                                                            Profile
                                                        </a>
                                                    </li>
                                                @endif
                                                @if(any_logged_in())
                                                <li>
                                                        <a class="dropdown-item @yield('navbar_login')"
                                                            href="{{ url('/logout') }}">
                                                            Logout
                                                        </a>
                                                    </li>
                                                @elseif (is_subscriber())
                                                    <li>
                                                        <a class="dropdown-item @yield('navbar_login')"
                                                            href="{{ url('/subscriber/logout') }}">
                                                            Logout
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a class="dropdown-item @yield('navbar_login')"
                                                            href="{{ url($user->username.'/login') }}">
                                                            Login
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                    <ul class="header-social-icons social-icons d-none d-sm-block">
                                        @if($user->facebook != null)
                                        <li class="social-icons-facebook"><a href="{{$user->facebook}}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                        @endif
                                        @if($user->instagram != null)
                                        <li class="social-icons-instagram"><a href="{{$user->instagram}}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                        @endif
                                        @if($user->twitter != null)
                                        <li class="social-icons-twitter"><a href="{{$user->twitter}}" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                        @endif
                                        <li class="social-icons-twitter"><a target="blank" href="{{url('/rss/'.$user->username)}}"
                                                                target="_blank" title="Twitter"><i class="bi bi-rss"></i></a></li>
                                    </ul>
                                    <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div role="main" class="main full-height initial-height" id="main">