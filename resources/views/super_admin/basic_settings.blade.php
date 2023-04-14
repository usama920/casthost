@extends('super_admin.layout.admin_master')
@section('page_title', 'Basic Settings')
@section('basic-settings', 'active')
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Basic Settings</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/superAdmin')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{url('/superAdmin/basic-settings')}}">Settings</a>
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
                                <form class="form" action="{{url('/superAdmin/basic-settings')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$settings->id}}">
                                    <div class="row">

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="company-column">Site Logo</label>
                                                <input type="file" class="form-control" name="site_logo">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="company-column">Admin Logo</label>
                                                <input type="file" class="form-control" name="admin_logo">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Site Title</label>
                                                <input type="text" class="form-control" name="site_title" required value="{{$settings->site_title}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{$settings->phone}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Email</label>
                                                <input type="email" class="form-control" name="email" value="{{$settings->email}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Twitter Handle</label>
                                                <input type="text" class="form-control" name="twitter" value="{{$settings->twitter}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Facebook Handle</label>
                                                <input type="text" class="form-control" name="facebook" value="{{$settings->facebook}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Instagram Handle</label>
                                                <input type="text" class="form-control" name="instagram" value="{{$settings->instagram}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Store Commission (%)</label>
                                                <input type="number" step="0.1"  min="0.1" max="100" required class="form-control" name="store_commission" value="{{$settings->store_commission}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Subscription Commission (%)</label>
                                                <input type="number" step="0.1" min="0.1" max="100" required class="form-control" name="subscription_commission" value="{{$settings->subscription_commission}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Stripe Transaction Fee</label>
                                                <input type="number" step="0.1" min="0.1" required class="form-control" name="stripe_transaction_fee" value="{{$settings->stripe_transaction_fee}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Stripe Transaction Commission (%)</label>
                                                <input type="number" step="0.1" min="0.1" max="100" required class="form-control" name="stripe_transaction_commission" value="{{$settings->stripe_transaction_commission}}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" value="Save">
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