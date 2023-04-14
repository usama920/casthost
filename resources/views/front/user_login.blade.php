@section('page_title', 'Login or Subscribe')
@section('navbar_login', 'active')
@include('front.user_layout.header')
<section class="page-header page-header-modern page-header-background page-header-background-sm" style="background-image: url({{asset('project_assets/images/'.$page->image)}});">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-normal text-12 m-0 pb-2">Login/Subscribe</h1>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row mt-4 pt-4 mb-4 pb-4">
        <div class="col-lg-6 pt-3 mb-4">
            <h2 class="mb-4 custom-font-size-1" style="font-weight: 500; text-align:center;">{{$page->login_heading}}</h2>
            <p>{{$page->login_text}}</p>
            @if(any_logged_in())
            <p><strong>You have already logged in. </strong> <span><a class="btn-link-effect-1 font-weight-bold text-decoration-none" href="{{url('/logout')}}">Logout?</a></span></p>
            @else
            <form class="form" action="{{url('/login')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col">
                        <input type="text" placeholder="Your Username" value="" data-msg-required="Please enter your username." data-msg-email="Please enter a valid username." maxlength="100" class="form-control" name="username" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <input type="password" placeholder="Your Password" value="" data-msg-required="Minimum 6 Characters." maxlength="100" minlength="6" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <span class="btn btn-link-effect-1 bg-transparent text-primary bg-color-before-primary border-0 p-0 me-3" data-bs-toggle="modal" data-bs-target="#formModal">Forgot Password?</span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col text-center">
                        <input type="submit" value="Login" class="btn btn-quaternary  btn-lg text-uppercase font-weight-semibold btn-x-60" data-loading-text="Loading...">
                    </div>
                </div>
            </form>
            @endif

        </div>
        <div class="col-lg-6 pt-3 mb-4">
            <h2 class="mb-4 custom-font-size-1" style="font-weight: 500; text-align:center;">{{$page->subscriber_heading}}</h2>
            <p>{{$page->subscriber_text}}</p>

            @if(is_subscriber())
            <p><strong>You have already logged in as subscriber.</strong> <span><a class="btn-link-effect-1 font-weight-bold text-decoration-none" href="{{url('/subscriber/logout')}}">Logout?</a></span></p>
            @else
            <form class="form" id="subscription_form">
                @csrf
                <div class="row">
                    <div class="form-group col">
                        <input type="email" placeholder="Your E-mail" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email_subscriber" id="email_subscriber" required>
                    </div>
                </div>
                <div class="row d-none" id="code_section_subscriber">
                    <div class="form-group col">
                        <input type="text" name="code_subscriber" id="code_subscriber" maxlength="6" class="form-control" placeholder="6 letter code..."/>
                    </div>
                </div>

                <div class="form-group row align-items-center mb-0">
                    <label class="col-sm-3 text-start text-sm-end m-0"></label>
                    <div class="col-sm-9">
                        <div id="form_error_subscriber" class="error"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col text-center">
                        <input type="submit" value="Verify Email" id="modal_submit_subscriber" class="btn btn-quaternary btn-x-60  btn-lg text-uppercase font-weight-semibold my-1" data-loading-text="Loading...">
                        <button type="button" class="btn btn-quaternary btn-x-60  btn-lg text-uppercase font-weight-semibold my-1 d-none" style="border-radius: 25px !important; font-size: 12px; padding: 11px 21px;" onclick="verifyCodeSubscriber()" id="verify_code_button_subscriber">Verify Code</button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="formModalLabel">Forgot Password?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="forgot_password_form" class="mb-2">
            <div class="modal-body">
                    <div class="form-group row align-items-center">
                        <label class="col-sm-3 text-start text-sm-end mb-0">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="name" id="email" class="form-control" placeholder="Type your email..."
                                required />
                        </div>
                    </div>
                    <div class="form-group row align-items-center d-none" id="code_section">
                        <label class="col-sm-3 text-start text-sm-end mb-0">Code</label>
                        <div class="col-sm-9">
                            <input type="text" name="code" id="code" class="form-control" placeholder="6 letter code..."/>
                        </div>
                    </div>
                    <div class="form-group row align-items-center d-none" id="new_password">
                        <label class="col-sm-3 text-start text-sm-end mb-0">New Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" id="password" class="form-control" placeholder="New Password..."/>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-0">
                        <label class="col-sm-3 text-start text-sm-end m-0"></label>
                        <div class="col-sm-9">
                            <div id="success_message"></div>
                            <div id="form_error" class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" id="modal_submit" value="Send Code" />
                    <button type="button" class="btn btn-primary d-none" id="verify_code_button" onclick="verifyCode()">Verify Code</button>
                    <button type="button" class="btn btn-primary d-none" id="save_button" onclick="savePassword()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#forgot_password_form").on("submit", function (e) {
        e.preventDefault();
        let email = $('#email').val();
        $('#form_error').html('');
        if(email == null || email == "") {
            $('#form_error').html('Please provide valid Email!');
            return;
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/forgotpassword/code",
            data: {
                email
            },
            success: function(response) {
                console.log(response);
                if(response.status == 'success') {
                    $('#modal_submit').addClass('d-none');
                    $('#code_section').removeClass('d-none');
                    $('#verify_code_button').removeClass('d-none');
                    $('#email').prop("readonly", true);
                } else{
                    $('#form_error').html(response.message);
                }
            },
        });
    });

    function verifyCode() {
        let email = $('#email').val();
        let code = $('input[name="code"]').val();
        $('#form_error').html('');
        if(code == null || code == "") {
            $('#form_error').html('Please enter code!');
            return;
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/forgotpassword/verify/code",
            data: {
                email,
                code
            },
            success: function(response) {
                console.log(response);
                if(response.status == 'success') {
                    $('#modal_submit').addClass('d-none');
                    $('#verify_code_button').addClass('d-none');
                    $('#save_button').removeClass('d-none');
                    $('#new_password').removeClass('d-none');
                    $('#code').prop("readonly", true);
                } else{
                    $('#form_error').html(response.message);
                }
            },
        });
    }

    function savePassword() {
        let email = $('#email').val();
        let code = $('input[name="code"]').val();
        let password = $('#password').val();
        console.log(password);
        $('#form_error').html('');
        if(password == null || password == "" || password.length < 6) {
            $('#form_error').html('Please enter strong password!');
            return;
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/forgotpassword/save",
            data: {
                email,
                code,
                password
            },
            success: function(response) {
                console.log(response);
                if(response.status == 'success') {
                    window.location.href = "/login";
                } else{
                    $('#form_error').html(response.message);
                }
            },
        });
    }

    $("#subscription_form").on("submit", function (e) {
        e.preventDefault();
        let email = $('#email_subscriber').val();
        console.log(email);
        $('#form_error_subscriber').html('');
        if(email == null || email == "") {
            $('#form_error_subscriber').html('Please provide valid Email!');
            return;
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/subscriber/verify/email",
            data: {
                email
            },
            success: function(response) {
                console.log(response);
                if(response.status == 'success') {
                    $('#modal_submit_subscriber').addClass('d-none');
                    $('#code_section_subscriber').removeClass('d-none');
                    $('#verify_code_button_subscriber').removeClass('d-none');
                    $('#email_subscriber').prop("readonly", true);;
                } else{
                    $('#form_error_subscriber').html(response.message);
                }
            },
        });
    });
    function verifyCodeSubscriber() {
        let email = $('#email_subscriber').val();
        let code = $('input[name="code_subscriber"]').val();
        $('#form_error_subscriber').html('');
        if(code == null || code == "") {
            $('#form_error_subscriber').html('Please enter code!');
            return;
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/subscriber/verify",
            data: {
                email,
                code
            },
            success: function(response) {
                console.log(response);
                if(response.status == 'success') {
                    window.location.href = "/login";
                } else{
                    $('#form_error_subscriber').html(response.message);
                }
            },
        });
    }
</script>
@include('front.layout.footer')