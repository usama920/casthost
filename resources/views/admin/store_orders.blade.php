@extends('admin.layout.admin_master')
@section('page_title', 'Store Orders')
@section('store_orders', 'active')
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Store Orders</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{url('/admin/store/orders')}}">Store Orders</a>
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
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($orders) > 0)
                                        @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$order->first_name}} {{$order->last_name}}</td>
                                            <td>{{$order->subscriber->email}}</td>
                                            <td class="text-center">
                                                @if($order->status == 1)
                                                Pending
                                                @elseif($order->status == 2)
                                                On Its Way
                                                @elseif($order->status == 3)
                                                Delivered
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{url('/admin/store/order/detail/'.$order->id)}}">
                                                    <span class="badge rounded-pill badge-light-success"><i data-feather='eye'></i>&nbsp;Detail</span>
                                                </a>
                                            </td>
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