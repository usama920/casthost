@extends('admin.layout.admin_master')
@section('page_title', 'Store Payout')
@section('store_payout', 'active')
@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Store Payout</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/admin/store/payout') }}">Store Payout</a>
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
                                <div class="card-header border-bottom p-1">
                                    <div class="dt-action-buttons">
                                        <div class="dt-buttons d-inline-flex">
                                            @if ($user->stripe_connect_id == null || $user->completed_stripe_onboarding == 0)
                                                <a href="{{ url('/admin/store/stripe/create') }}"
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
                                            @else
                                                You have succesffully linked to stripe connect.<br>
                                                Some payouts might be dispalyed after 24 hours.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="content-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="dollar-sign" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{ $total_payout }}</h2>
                                <p class="card-text">Total Payouts</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="dollar-sign" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{ $current_month_payout }}</h2>
                                <p class="card-text">Current Month Payout</strong></p>
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
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th class="text-center">Price($)</th>
                                                <th class="text-center">Payout($)</th>
                                                <th class="text-center">Date & Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($items) > 0)
                                                @foreach ($items as $key => $item)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $item->product_name }}</td>
                                                        <td class="text-center">{{ $item->price * $item->quantity }}</td>
                                                        <td class="text-center">{{ $item->user_payout }}</td>
                                                        <td class="text-center">{{ $item->created_at }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
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
