@extends('dashboard.layout.admin_master')
@section('dashborad', 'active')
@section('page_title', 'Dashboard')
@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Dashboard</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/users/dashboard') }}">Dashboard</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{$last_day_views}}</h2>
                                <p class="card-text">Views <strong>(Last Day)</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{$last_seven_day_views}}</h2>
                                <p class="card-text">Views <strong>(Last 7 Days)</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{$last_thirty_day_views}}</h2>
                                <p class="card-text">Views <strong>(Last 30 Days)</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{$total_views}}</h2>
                                <p class="card-text">Views <strong>(Total Views)</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-warning p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="download" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{$last_day_downloads}}</h2>
                                <p class="card-text">Downloads <strong>(Last Day)</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-warning p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="download" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{$last_seven_day_downloads}}</h2>
                                <p class="card-text">Downloads <strong>(Last 7 Days)</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-warning p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="download" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{$last_thirty_day_downloads}}</h2>
                                <p class="card-text">Downloads <strong>(Last 30 Days)</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-warning p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="download" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{$total_downloads}}</h2>
                                <p class="card-text">Downloads <strong>(Total Views)</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-primary p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather='video' class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{count($podcasts)}}</h2>
                                <p class="card-text"><strong>Total Podcasts</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-success p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather='user-plus' class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{$total_subscribers}}</h2>
                                <p class="card-text"><strong>Subscribers</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
