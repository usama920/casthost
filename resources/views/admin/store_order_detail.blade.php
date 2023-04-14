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
                                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/admin/store/orders') }}">Store Orders</a>
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
                                    @if($order->status != 3)
                                    <form class="form form-horizontal" method="POST"
                                        action="{{ url('/admin/store/order/detail/save') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="form-label" for="basicSelect">Change Status</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-select" id="basicSelect" name="status"
                                                        required>
                                                        @if($order->status == 1)
                                                        <option value="1">Pending</option>
                                                        <option value="2">On It's Way</option>
                                                        <option value="3">Delivered</option>
                                                        @elseif($order->status == 2)
                                                        <option value="2">On It's Way</option>
                                                        <option value="3">Delivered</option>
                                                        @elseif($order->status == 3)
                                                        <option value="3">Delivered</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9">
                                                    <input type="submit" value="Save" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </form>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-12 order-md-1">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Name</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                value="{{ $order->first_name . ' ' . $order->last_name }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Email</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                value="{{ $order->subscriber->email }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Phone</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                value="{{ $order->phone }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Street
                                                                Address</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                value="{{ $order->street_address }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">City</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                value="{{ $order->city }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">State</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                value="{{ $order->state }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Country</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                value="{{ $order->country }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Postal
                                                                Code</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                value="{{ $order->zip }}" readonly>
                                                        </div>
                                                    </div>
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
                                                                    <th>Quantity</th>
                                                                    <th>Size</th>
                                                                    <th>Color</th>
                                                                    <th>Price($)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (count($order->order_items) > 0)
                                                                    @foreach ($order->order_items as $key => $item)
                                                                        @if ($item->user_id == Auth::user()->id)
                                                                            <tr>
                                                                                <td>{{ ++$key }}</td>
                                                                                <td>{{ $item->product_name }}</td>
                                                                                <td>{{ $item->quantity }}</td>
                                                                                <td>{{ $item->size }}</td>
                                                                                <td>{{ $item->color }}</td>
                                                                                <td>{{ $item->price }}</td>
                                                                            </tr>
                                                                        @endif
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
                    </div>
                </section>
            </div>
        </div>

    </div>


@endsection
