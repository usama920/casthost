@extends('dashboard.layout.admin_master')
@section('all_podcasts', 'active')
@section('page_title', 'All Podcasts')
@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">All Podcasts</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/users/podcasts') }}">All Podcasts</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (auth()->user()->stripe_connect_id == null || auth()->user()->completed_stripe_onboarding == 0)
                <div class="content-body">
                    <section id="basic-horizontal-layouts">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header border-bottom p-1">
                                        <div class="dt-action-buttons">
                                            <div class="dt-buttons d-inline-flex">
                                                <a href="{{ url('/users/store/stripe/create') }}"
                                                    class="dt-button create-new btn btn-primary"><span><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-plus me-50 font-small-4">
                                                            <line x1="12" y1="5" x2="12"
                                                                y2="19"></line>
                                                            <line x1="5" y1="12" x2="19"
                                                                y2="12"></line>
                                                        </svg>Connect Stripe</span></a>
                                            </div>
                                            Your Paid Podcasts will not be available for subscribers until you connect to
                                            your stripe account.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @endif
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <a class="dt-button create-new btn btn-success" href="{{url('/users/podcasts/export')}}"><span>Export</span></a>
                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th class="text-center">Views</th>
                                                <th class="text-center">Downloads</th>
                                                <th class="text-center">Premiere Date</th>
                                                <th class="text-center">Type</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($podcasts) > 0)
                                                @foreach ($podcasts as $key => $podcast)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $podcast->title }}</td>
                                                        <td class="text-center">{{ count($podcast->views) }}</td>
                                                        <td class="text-center">{{ count($podcast->downloads) }}</td>
                                                        <td class="text-center">{{ $podcast->premiere_datetime }}</td>
                                                        <td class="text-center">
                                                            @if ($podcast->paid == 1)
                                                            Paid
                                                            @else
                                                            Un-Paid
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($podcast->admin_status == 1)
                                                                @if ($podcast->status == 1)
                                                                    <a
                                                                        href="{{ url('/users/podcast/inactive/' . $podcast->id) }}"><span
                                                                            class="badge rounded-pill badge-light-primary">Active</span></a>
                                                                @elseif ($podcast->status == 0)
                                                                    <a
                                                                        href="{{ url('/users/podcast/active/' . $podcast->id) }}"><span
                                                                            class="badge rounded-pill badge-light-secondary">Inactive</span></a>
                                                                @endif
                                                            @else
                                                                <span
                                                                    class="badge rounded-pill badge-light-danger">Banned</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ url('/users/podcast/detail/' . $podcast->id) }}">
                                                                <span class="badge rounded-pill badge-light-warning"><i
                                                                        data-feather="eye" class="me-50"></i>Detail</span>
                                                            </a>
                                                            <a href="{{ url('/users/podcast/delete/' . $podcast->id) }}">
                                                                <span class="badge rounded-pill badge-light-danger"><i
                                                                        data-feather="archive"
                                                                        class="me-50"></i>Delete</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        No Data Found.
                                                    </td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection
