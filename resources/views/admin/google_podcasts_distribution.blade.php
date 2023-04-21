@extends('admin.layout.admin_master')
@section('podcasts_distribution', 'active')
@section('page_title', 'Google Podcasts Distribution')
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
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/admin/podcasts/distribution') }}">Distribution Platforms</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/admin/podcasts/distribution/google_podcasts') }}">Google
                                            Podcasts</a>
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
                                    {{-- <h4 class="card-title mb-75">
                                        Google's podcast discovery and listening app; also shows podcasts directly in Google search.
                                    </h4> --}}
                                    <p>
                                        Through Google's podcast discovery and listening app your podcasts can be viewed
                                        directly in Google search. <br>
                                        Make sure to have atleast one podcast published. <br>
                                        Submit your podcast to Google Podcasts <br>
                                        <a target="blank" href="https://podcastsmanager.google.com/add-feed"
                                            class="btn btn-primary my-1">Submit to Google</a><br>
                                        You will be asked to fill in a variety of podcast information as well as RSS Feed
                                        which you can copy from the field below.<br>
                                    </p>
                                    <p>Your Podcast Feed:</p>
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-6 col-12 pe-sm-0">
                                            <div class="mb-1">
                                                <input type="text" readonly class="form-control"
                                                    id="copy-to-clipboard-input"
                                                    value="{{ url('/rss/' . auth()->user()->username) }}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <button class="btn btn-outline-primary" id="btn-copy">Copy!</button>
                                        </div>
                                    </div>
                                    <p>It may take few weeks for Google to review your podcast. You will receive a confirmation email once it's approved.
                                        <br>
                                        Once you’ve received your URL, copy + paste it here to access it in the future.
                                    </p>
                                    <p>Your podcast URL in Google Podcasts</p>

                                    <form action="{{url('/users/podcasts/distribution/google_podcasts/save')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-6 col-12 pe-sm-0">
                                                <div class="mb-1">
                                                    <input type="link" class="form-control"
                                                        name="url" required
                                                        @if(isset($google_podcasts->url))
                                                        value="{{$google_podcasts->url}}"
                                                        @endif
                                                        />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-12">
                                                <button type="submit" class="btn btn-outline-success">Save URL!</button>
                                                @if(isset($google_podcasts->url))
                                                <a href="{{$google_podcasts->url}}" target="blank" class="btn btn-primary">View</a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>

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

    <script src="{{ asset('admin_assets/js/scripts/extensions/ext-component-clipboard.js') }}"></script>

@endsection
