@section('navbar_home', 'active')
@section('page_title', 'Home')
@include('front.layout.header')

<link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet" />


<section class="page-header page-header-modern page-header-background page-header-background-sm header-background-image"
    style="background-image: url({{ asset('project_assets/images/' . $page->image) }});">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-normal text-12 m-0 pb-2">Our Podcasts</h1>
            </div>
        </div>
    </div>
</section>
<div class="container p-0 pt-2">
    <div class="p-0 mt-4 row" style="min-height: 400px;">
        @if (count($podcasts) > 0)
            @foreach ($podcasts as $podcast)
                <div class="col-sm-8 col-md-6 col-lg-4 p-3">
                    <article class="our-blog-item">
                        @if ($podcast->paid == 1)
                        <a href="{{ url('/' . $podcast->user->username) }}">
                            <div
                                class="video-js vjs-matrix vjs-paused vjs-controls-enabled vjs-workinghover vjs-v8 vjs-user-active my-video11-dimensions">
                                <img src="{{ url('storage/podcast/' . $podcast->id . '/images/' . $podcast->cover_image) }}"
                                    class="vjs-poster vjs-tech">
                            </div>
                        </a>
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
                            @if ($podcast->paid == 1)
                                <a href="{{ url('/' . $podcast->user->username) }}">
                                    <div class="download_container">
                                        <div class="bg-color-quaternary text-center h-100 text-white">
                                            <i class="bi bi-lock-fill download_icon"></i>
                                        </div>
                                    </div>
                                </a>
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
                                {{ $day }} <span style="text-transform: uppercase;">{{ $month }}</span>
                                {{ $year }}
                            </span>
                            <h1 class="font-weight-normal mb-0">
                                {{ $podcast->title }}
                            </h1>
                            <h4 class="mb-1">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ url('/podcast/category/' . $podcast->category_id) }}"
                                            class="text-decoration-none" style="color: darkcyan;">
                                            <i class="bi bi-bookmarks font-normal">&nbsp;
                                                <span
                                                    style="text-decoration:underline;">{{ $podcast->category->title }}</span>
                                            </i>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ url('/' . $podcast->user->username) }}"
                                            class="text-decoration-none" style="color: darkcyan;">
                                            <i class="bi bi-person-circle font-normal">&nbsp;
                                                <span
                                                    style="text-decoration:underline;">{{ $podcast->user->name }}</span>
                                            </i>
                                        </a>
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
            <h4 class="text-center">No Podcasts added yet.</h4>
        @endif

    </div>
    <div class="row">
        {{ $podcasts->links('front.pagination') }}
    </div>
</div>


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
    let player = videojs('my-video');

    function check(id) {
        console.log(id);
        let video = document.getElementById('my-video' + id + '_html5_api');
        let duration = video.duration;

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

@include('front.layout.footer')
