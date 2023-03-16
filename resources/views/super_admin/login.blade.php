<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
@php
$settings = settings();
@endphp
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Login - Super Admin</title>
    <link rel="apple-touch-icon" href="{{asset('admin_assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('admin_assets/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/vendors/css/vendors.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{asset('admin_assets/css/core/menu/menu-types/horizontal-menu.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('admin_assets/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/css/pages/authentication.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/css/style.css')}}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover"
    data-menu="horizontal-menu" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        <!-- Login basic -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="{{url('/')}}" class="brand-logo">
                                    <img src="{{asset('project_images/images/'.$settings->site_logo)}}"
                                        style="width: 150px;" alt="">
                                </a>

                                <h4 class="card-title mb-1">Adventure starts here 👋</h4>
                                <p class="card-text mb-2">Make your app management easy and fun!</p>

                                <form class="auth-register-form mt-2" action="{{url('/superAdmin/login')}}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-1">
                                        <label for="register-email" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="register-email" name="username"
                                            placeholder="Username" />
                                    </div>

                                    <div class="mb-1">
                                        <label for="register-password" class="form-label">Password</label>

                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge"
                                                id="register-password" name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="register-password" tabindex="3" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100" tabindex="5">Sign in</button>
                                </form>
                            </div>
                        </div>
                        <!-- /Login basic -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('admin_assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('admin_assets/vendors/js/ui/jquery.sticky.js')}}"></script>
    <script src="{{asset('admin_assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('admin_assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('admin_assets/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('admin_assets/js/scripts/pages/auth-login.js')}}"></script>
    <!-- END: Page JS-->

    <script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
    </script>
</body>
<!-- END: Body-->

</html>