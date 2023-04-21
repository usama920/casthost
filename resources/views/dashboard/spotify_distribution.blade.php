@extends('dashboard.layout.admin_master')
@section('podcasts_distribution', 'active')
@section('page_title', 'Spotify Distribution')
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
                                        <a href="{{ url('/users/podcasts/distribution') }}">Distribution Platforms</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/users/podcasts/distribution/spotify') }}">Spotify</a>
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
                                    <p>
                                        Spotify now allows individual creators to gain access to Spotify for Podcasters.
                                        Through Spotify for Podcasters, you will be able to directly access your stats for
                                        your specific podcasts that are on Spotify, as well as upload new podcasts to
                                        Spotify. <br>
                                    <div class="mt-1"></div>
                                    1. Log into Spotify for Podcasters <br>
                                    This will be connected to a Spotify account, so please make sure you are logging in with
                                    the account you want to be associated with your podcast<br>
                                    <div class="mt-1"></div>
                                    2. Click on the “Add Your Podcast” link on the sidebar <br>
                                    <div class="mt-1"></div>
                                    3. Add the RSS feed for your podcast on Spotify<br>
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
                                    <div class="mt-1"></div>
                                    4. Verify that you own the podcast
                                    <br>Spotify will send a verification code to the email address in the RSS feed. <br>
                                    <div class="mt-1"></div>
                                    5. Type in the verification code<br>
                                    <div class="mt-1"></div>
                                    6. ID additional metadata associated with your podcast (country, language,
                                    categories)<br>
                                    <div class="mt-1"></div>
                                    7. Press Submit!<br>
                                    You will then have access to the Spotify analytics for this podcast<br>
                                    You will be able to gain access to multiple individual podcasts via this feature.
                                    Similarly, the rest of your podcast team can access the statistics for specific podcasts
                                    as well. As long as they have access to the email address in the RSS feed.
                                    <br>
                                    If you have further questions on this, please reach out to the Spotify support team at
                                    podcasters-support@spotify.com.
                                    Submit your podcast to Spotify <br>
                                    <a target="blank" href="https://podcasters.spotify.com/"
                                        class="btn btn-primary my-1">Submit to Spotify</a><br>
                                    
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin_assets/js/scripts/extensions/ext-component-clipboard.js') }}"></script>

@endsection
