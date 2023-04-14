@extends('dashboard.layout.admin_master')
@section('page_title', 'All Products')
@section('store_products', 'active')
@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">All Products</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/users/dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/users/store/all_products') }}">All
                                            Products</a>
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
                                                <th>Title</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($products) > 0)
                                                @foreach ($products as $key => $product)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $product->title }}</td>
                                                        <td class="text-center"><img src="{{ asset('storage/store/' . $product->id . '/' . $product->main_image) }}"
                                                                style="width: 100px;"></td>
                                                        <td class="text-center">{{ $product->category->title }}</td>
                                                        <td class="text-center">
                                                            @if ($product->status == 1)
                                                                <a
                                                                    href="{{ url('/users/store/product/inactive/' . $product->id) }}"><span
                                                                        class="badge rounded-pill badge-light-primary">Active</span></a>
                                                            @else
                                                                <a
                                                                    href="{{ url('/users/store/product/active/' . $product->id) }}"><span
                                                                        class="badge rounded-pill badge-light-secondary">Inactive</span></a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a
                                                                href="{{ url('/users/store/product/detail/' . $product->id) }}">
                                                                <span class="badge rounded-pill badge-light-warning"><i
                                                                        data-feather="eye" class="me-50"></i>Detail</span>
                                                            </a>
                                                            <a
                                                                href="{{ url('/users/store/product/delete/' . $product->id) }}">
                                                                <span class="badge rounded-pill badge-light-danger"><i
                                                                        data-feather="trash"
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
