@extends('admin.layout.admin_master')
@section('page_title', 'Podcast Detail')
@section('podcasts', 'active')
@section('content')

    <link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet" />
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Podcast Detail</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a
                                            href="{{ url('/admin/user/podcast/detail/' . $podcast->id) }}">Podcast Detail</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">

                            <div class="card-body">
                                <form class="form form-horizontal" method="POST"
                                    action="{{ url('/users/podcast/update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $podcast->id }}">
                                    <div class="row">

                                        <div class="col-sm-4 order-md-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <video id="my-video" class="video-js" controls preload="auto"
                                                        poster="{{ url('storage/podcast/' . $podcast->id . '/images/' . $podcast->cover_image) }}"
                                                        data-setup="{}">
                                                        <source
                                                            src="{{ url('storage/podcast/' . $podcast->id . '/' . $podcast->podcast) }}"
                                                            type="video/mp4" />
                                                        <source src="MY_VIDEO.webm" type="video/webm" />
                                                        <p class="vjs-no-js">
                                                            To view this video please enable JavaScript, and consider
                                                            upgrading to a
                                                            web browser that
                                                            <a href="https://videojs.com/html5-video-support/"
                                                                target="_blank">supports HTML5 video</a>
                                                        </p>
                                                    </video>
                                                </div>
                                                <div class="col-12">
                                                    <div class="card text-center mb-0">
                                                        <div class="card-body">
                                                            <div class="avatar bg-light-primary p-50 mb-1">
                                                                <div class="avatar-content">
                                                                    <i data-feather='eye'
                                                                        class="font-medium-5"></i>
                                                                </div>
                                                            </div>
                                                            <h2 class="fw-bolder">{{$last_day_views}}/{{$last_seven_day_views}}/{{$last_thirty_day_views}}/{{ $total_views }}</h2>
                                                            <p class="card-text"><strong>(1/7/30/Total) Days</strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="card text-center">
                                                        <div class="card-body">
                                                            <div class="avatar bg-light-primary p-50 mb-1">
                                                                <div class="avatar-content">
                                                                    <i data-feather='download'
                                                                        class="font-medium-5"></i>
                                                                </div>
                                                            </div>
                                                            <h2 class="fw-bolder">{{$last_day_downloads}}/{{$last_seven_day_downloads}}/{{$last_thirty_day_downloads}}/{{ $total_downloads }}</h2>
                                                            <p class="card-text"><strong>(1/7/30/Total) Days</strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8 order-md-1">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Title</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="title"
                                                                placeholder="Title" value="{{ $podcast->title }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="form-label" for="basicSelect">Category</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" readonly class="form-control"
                                                                value="{{ $podcast->category_id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="email-id">Premier Date &
                                                                Time</label>
                                                        </div>
                                                        <?php
                                                        $premiere_datetime = new DateTime($podcast->premiere_datetime);
                                                        ?>
                                                        <div class="col-sm-9">
                                                            <input type="datetime-local" class="form-control"
                                                                name="premiere_datetime" value="<?php echo $premiere_datetime->format('Y-m-d\TH:i:s'); ?>"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="email-id">Description</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <textarea type="text" class="form-control" name="description" placeholder="Description" maxlength="1000"
                                                                rows="10" readonly>{{ $podcast->description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <style>
        .vjs-matrix {
            width: 100% !important;
            height: auto !important;
            min-height: 150px !important;
        }

        .vjs-poster img {
            object-fit: fill !important;
        }

        video {
            object-fit: fill !important;
        }
    </style>

    <script src="https://vjs.zencdn.net/8.0.4/video.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        let player = videojs('my-video', {
            width: '311',
            height: '150'
        });
        player.addClass('vjs-matrix');

        function formSubmission() {
            $("#submit_button").click();
            return;
        }
    </script>

@endsection
