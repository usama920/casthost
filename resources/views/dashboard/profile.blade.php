@extends('dashboard.layout.admin_master')
@section('profile', 'active')
@section('page_title', 'Profile')
@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Profile</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/users/profile') }}">Profile</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form" action="{{ url('/users/profile') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Name</label>
                                                    <input type="text" class="form-control" required name="name"
                                                        value="{{ $user->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="email-id-column">Email</label>
                                                    <input type="email" readonly class="form-control"
                                                        value="{{ $user->email }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="email-id-column">Subscription Price</label>
                                                    <input type="number" max="1000" min="5" step="0.1" class="form-control"
                                                        value="{{ $user->SubscriptionInfo->price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Facebook Link</label>
                                                    <input type="text" class="form-control" name="facebook"
                                                        value="{{ $user->facebook }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Twitter</label>
                                                    <input type="text" class="form-control" name="twitter"
                                                        value="{{ $user->twitter }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Instagram</label>
                                                    <input type="text" class="form-control" name="instagram"
                                                        value="{{ $user->instagram }}">
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <input type="submit"
                                                    class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                                    value="Save">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card">
                                <h4 class="card-header">Change Password</h4>
                                <div class="card-body">
                                    <form method="POST" action="{{url('/users/change/password')}}">
                                        @csrf
                                        <div class="alert alert-warning mb-2" role="alert">
                                            <div class="alert-body fw-normal">Minimum 6 characters long.</div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-2 col-md-6 form-password-toggle">
                                                <label class="form-label" for="newPassword">Old Password</label>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input class="form-control" type="password" id="newPassword"
                                                        name="old_password"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                    <span class="input-group-text cursor-pointer">
                                                        <i data-feather="eye"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="mb-2 col-md-6 form-password-toggle">
                                                <label class="form-label" for="confirmPassword">New Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input class="form-control" type="password" name="new_password"
                                                        id="confirmPassword"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            data-feather="eye"></i></span>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary me-2">Change
                                                    Password</button>
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

@endsection
