@extends('dashboard.layout.admin_master')
@section('podcasts_distribution', 'active')
@section('page_title', 'Podcasts Distribution')
@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Distribution Platforms</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ url('/users/podcasts/distribution') }}">Distribution Platforms</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-75">
                                        Submit your podcast to the most popular podcast apps.
                                    </h4>
                                    <div class="d-flex mt-2" onclick="redirect('google_podcasts')" style="cursor: pointer;">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('/project_assets/images/google-podcast.png') }}"
                                                alt="google" class="me-1" height="38" width="38" />
                                        </div>
                                        <div class="d-flex align-item-center justify-content-between flex-grow-1"
                                            style="align-items: center;">
                                            <p class="fw-bolder mb-0">Google Podcasts</p>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-2" onclick="redirect('spotify')" style="cursor: pointer;">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('/project_assets/images/spotify.png') }}"
                                                alt="google" class="me-1" height="38" width="38" />
                                        </div>
                                        <div class="d-flex align-item-center justify-content-between flex-grow-1"
                                            style="align-items: center;">
                                            <p class="fw-bolder mb-0">Spotify</p>
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


    <script>
        function redirect(value) {
            window.location.href = "distribution/" + value;
        }
    </script>
@endsection
