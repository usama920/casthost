@section('page_title')
    {{ $user->name }} Home
@endsection
@section('navbar_home', 'active')
@include('front.user_layout.header')

<link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet" />

@php
    $paidSubscriptionAllowed = paidSubscriptionAllowed($user->id);
    $purchasedSubscription = purchasedSubscription($user->id);
@endphp
<section class="page-header page-header-modern page-header-background p-100 header-background-image"
    style="background-image: url({{ asset('project_assets/images/' . $page->image) }});">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-normal text-12 m-0 pb-2">{{ $user->name }}</h1><br>
                @if (is_subscriber())
                    @if (is_user_subscriber($user->id))
                        <a href="{{ url('/unsubscribe/' . $user->id) }}"
                            class="btn btn-outline btn-danger mb-2">Unsubscribe</a>
                    @else
                        <a href="{{ url('/subscribe/' . $user->id) }}"
                            class="btn btn-outline btn-success mb-2">Subscribe</a>
                    @endif
                @else
                    <button class="btn btn-outline btn-success mb-2" data-bs-toggle="modal"
                        data-bs-target="#formModal">Subscribe</button>
                @endif
            </div>
        </div>
    </div>
</section>
<div class="container p-0 pt-2">
    <div class="p-0 mt-4 row" style="min-height: 400px;">
        @if (count($podcasts) > 0)
            @foreach ($podcasts as $podcast)
                @php
                    if ($podcast->paid == 1 && !$paidSubscriptionAllowed) {
                        continue;
                    }
                @endphp
                <div class="col-sm-8 col-md-6 col-lg-4 p-3">
                    <article class="our-blog-item">
                        @if ($podcast->paid == 1 && !$purchasedSubscription)
                            @if (is_subscriber())
                                <div class="video-js vjs-matrix vjs-paused vjs-controls-enabled vjs-workinghover vjs-v8 vjs-user-active my-video11-dimensions"
                                    data-bs-toggle="modal" data-bs-target="#paidFormModal">
                                    <img src="{{ url('storage/podcast/' . $podcast->id . '/images/' . $podcast->cover_image) }}"
                                        class="vjs-poster vjs-tech">
                                </div>
                            @else
                                <div class="video-js vjs-matrix vjs-paused vjs-controls-enabled vjs-workinghover vjs-v8 vjs-user-active my-video11-dimensions"
                                    data-bs-toggle="modal" data-bs-target="#formModal">
                                    <img src="{{ url('storage/podcast/' . $podcast->id . '/images/' . $podcast->cover_image) }}"
                                        class="vjs-poster vjs-tech">
                                </div>
                            @endif
                        @else
                            <video id="my-video{{ $podcast->id }}" onclick="check({{ $podcast->id }})"
                                class="video-js vjs-matrix" controls preload="auto"
                                poster="{{ url('storage/podcast/' . $podcast->id . '/images/' . $podcast->cover_image) }}"
                                data-setup="{}">
                                <source src="{{ url('storage/podcast/' . $podcast->id . '/' . $podcast->podcast) }}"
                                    type="video/mp4" />
                            </video>
                        @endif
                        <div class="post-infos">
                            @if ($podcast->paid == 1 && !$purchasedSubscription)
                                @if (is_subscriber())
                                    <div class="download_container" data-bs-toggle="modal"
                                        data-bs-target="#paidFormModal">
                                        <div class="bg-color-quaternary text-center h-100 text-white">
                                            <i class="bi bi-lock-fill download_icon"></i>
                                        </div>
                                    </div>
                                @else
                                    <div class="download_container" data-bs-toggle="modal" data-bs-target="#formModal">
                                        <div class="bg-color-quaternary text-center h-100 text-white">
                                            <i class="bi bi-lock-fill download_icon"></i>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <a href="{{ url('/podcast/download/' . $podcast->id) }}">
                                    <div class="download_container">
                                        <div class="bg-color-quaternary text-center h-100 text-white">
                                            <i class="bi bi-download download_icon"></i>
                                        </div>
                                    </div>
                                </a>
                            @endif
                            @php
                                $day = date('d', strtotime($podcast->premiere_datetime));
                                $month = date('M', strtotime($podcast->premiere_datetime));
                                $year = date('Y', strtotime($podcast->premiere_datetime));
                            @endphp
                            <span class="post-date">
                                {{ $day }} <span
                                    style="text-transform: uppercase;">{{ $month }}</span>
                                {{ $year }}
                            </span>
                            <h1 class="font-weight-normal mb-0">
                                <a href="{{ url('/podcast/' . $podcast->slug) }}"
                                    class="text-decoration-none">{{ $podcast->title }}</a>
                            </h1>
                            <h4 class="mb-1">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ url('/' . $podcast->user->username . '/category/' . $podcast->category_id) }}"
                                            class="text-decoration-none" style="color: darkcyan;">
                                            <i class="bi bi-bookmarks font-normal">&nbsp;
                                                <span
                                                    style="text-decoration:underline;">{{ $podcast->category->title }}</span>
                                            </i>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-decoration-none" style="color: darkcyan;">
                                            <i class="bi bi-eye-fill font-normal">&nbsp;
                                                <span
                                                    style="text-decoration:underline;">{{ count($podcast->views) }}</span>
                                            </i>
                                        </span>
                                        <span class="text-decoration-none mx-2" style="color: darkcyan;">
                                            <i class="bi bi-box-arrow-down font-normal">&nbsp;
                                                <span
                                                    style="text-decoration:underline;">{{ count($podcast->downloads) }}</span>
                                            </i>
                                        </span>
                                    </div>
                                </div>
                            </h4>
                            <h4 class="mb-1">
                            </h4>
                            <p id="show_less_section{{ $podcast->id }}">
                                @if (strlen($podcast->description) > 140)
                                    @php
                                        echo substr($podcast->description, 0, 140) . '...';
                                    @endphp
                                    <button id="toggle" onclick="toggle({{ $podcast->id }}, 'more')"
                                        class="show_button">Read
                                        More</button>
                                @else
                                    {{ $podcast->description }}
                                @endif
                            </p>
                            <p id="show_more_section{{ $podcast->id }}" style="display: none;">
                                {{ $podcast->description }}
                                <button id="toggle" onclick="toggle({{ $podcast->id }}, 'less')"
                                    class="show_button">Read
                                    Less</button>
                            </p>
                        </div>
                    </article>
                </div>
            @endforeach
        @else
            <h4 class="text-center">No Podcasts added by {{ $user->name }} yet.</h4>
        @endif

    </div>
    <div class="row">
        {{ $podcasts->links('front.pagination') }}
    </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="formModalLabel">Subscribe and get updates regarding podcasts of
                    {{ $user->name }}.</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="subscription_form" class="mb-2">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                    <div class="form-group row align-items-center">
                        <label class="col-sm-3 text-start text-sm-end mb-0">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="name" id="email" class="form-control"
                                placeholder="Type your email..." required />
                        </div>
                    </div>
                    <div class="form-group row align-items-center d-none" id="code_section">
                        <label class="col-sm-3 text-start text-sm-end mb-0">Code</label>
                        <div class="col-sm-9">
                            <input type="text" name="code" class="form-control"
                                placeholder="6 letter code..." />
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
                    <input type="submit" class="btn btn-primary" id="modal_submit" value="Verify Email" />
                    <button type="button" class="btn btn-primary d-none" onclick="verifyCode()"
                        id="verify_code_button">Verify Code</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($paidSubscriptionAllowed)
    <div class="modal fade" id="paidFormModal" tabindex="-1" role="dialog" aria-labelledby="paidformModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="paidformModalLabel">Paid Subscription Required</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <form id="subscription_form" class="mb-2">
                    <div class="modal-body">
                        <p>After paying subscription fee of <strong>{{ $user->SubscriptionInfo->price }}$</strong>. You
                            will get access of all content uploaded by {{ $user->name }}.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Maybe Later</button>
                        <a href="{{url('/subscribe/paid/'.$user->id)}}" class="btn btn-primary">Pay Now</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<style>
    .vjs-matrix {
        width: 100% !important;
        height: auto !important;
        min-height: 200px !important;
    }

    .vjs-poster img {
        object-fit: fill !important;
    }

    video {
        object-fit: fill !important;
    }
</style>

<script src="https://vjs.zencdn.net/8.0.4/video.min.js"></script>
<script>
    let user_email = "{{ $user->email }}";
    let username = "{{ $user->username }}";
    $("#subscription_form").on("submit", function(e) {
        e.preventDefault();
        let email = $('#email').val();
        console.log(email);
        $('#form_error').html('');
        if (email == null || email == "" || user_email == email) {
            $('#form_error').html('Please provide valid Email!');
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
                if (response.status == 'success') {
                    $('#modal_submit').addClass('d-none');
                    $('#code_section').removeClass('d-none');
                    $('#verify_code_button').removeClass('d-none');
                    $('#email').prop("readonly", true);;
                } else {
                    $('#form_error').html(response.message);
                }
            },
        });
    });

    function verifyCode() {
        let email = $('#email').val();
        let user_id = $('#user_id').val();
        let code = $('input[name="code"]').val();
        $('#form_error').html('');
        if (code == null || code == "") {
            $('#form_error').html('Please enter code!');
            return;
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/subscriber/verify/code",
            data: {
                email,
                code,
                user_id
            },
            success: function(response) {
                console.log(response);
                if (response.status == 'success') {
                    window.location.href = "/" + username;
                } else {
                    $('#form_error').html(response.message);
                }
            },
        });
    }
    let player = videojs('my-video');

    function check(id) {
        let video = document.getElementById('my-video' + id + '_html5_api');
        let duration = video.duration;
        // return;
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/podcast/view",
            data: {
                id,
                duration
            },
            success: function(response) {
                console.log(response);
            },
        });
    }
    $(document).ready(function() {});

    function toggle(id, type) {
        if (type == "less") {
            $("#show_less_section" + id).css("display", "block");
            $("#show_more_section" + id).css("display", "none");
        }
        if (type == "more") {
            $("#show_more_section" + id).css("display", "block");
            $("#show_less_section" + id).css("display", "none");
        }
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
    integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async>
</script>

@include('front.layout.footer')
