@extends('dashboard.layout.admin_master')
@section('page_title', 'Subscription Payout')
@section('subscription_payout', 'active')
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Subscription Payout</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/users/dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{url('/users/subscription/payout')}}">Subscription Payout</a>
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
                                        @if($user->stripe_connect_id == null || $user->completed_stripe_onboarding == 0)
                                        <a href="{{url('/users/store/stripe/create')}}" class="dt-button create-new btn btn-primary"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-50 font-small-4">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>Connect Stripe</span></a>
                                        @else
                                        You have succesffully linked to stripe connect.<br>
                                        Some mights might be dispalyed after 24 hours.
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
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-center">Price($)</th>
                                            <th class="text-center">Payout($)</th>
                                            <th class="text-center">Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($items) > 0)
                                        @foreach ($items as $key => $item)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td class="text-center">{{$item->price}}</td>
                                            <td class="text-center">{{$item->payout}}</td>
                                            <td class="text-center">{{$item->created_at}}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4" class="text-center">
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