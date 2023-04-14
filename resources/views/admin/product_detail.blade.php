@extends('admin.layout.admin_master')
@section('page_title', 'Product Detail')
@section('store_products', 'active')
@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Product Detail</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a
                                            href="{{ url('/admin/store/product/detail/' . $product->id) }}">Podcast
                                            Detail</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">

                            <div class="card-body">
                                <form class="form form-horizontal" method="POST"
                                    action="{{ url('/admin/store/product/update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <div class="row">
                                        <div class="col-sm-8 order-md-1">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Title</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="title"
                                                                placeholder="Title" value="{{ $product->title }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Price</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="number" span="0.1" min="1" maxlength="8" class="form-control" name="price"
                                                                placeholder="Price" value="{{ $product->price }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Main
                                                                Image</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="file" class="form-control" name="main_image">
                                                            <img src="{{ asset('storage/store/' . $product->id . '/' . $product->main_image) }}"
                                                                style="width: 100px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="first-name">Other
                                                                Images</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="file" class="form-control" name="other_image[]"
                                                                multiple>
                                                            @if(count($product->ProductOtherImages) > 0)
                                                            <div class="row">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Image</th>
                                                                                <th class="text-center">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($product->ProductOtherImages as $key => $image)
                                                                            <tr>
                                                                                <td>{{ ++$key }}</td>
                                                                                <td>{{ $image->image }}</td>
                                                                                <td>
                                                                                    <a target="blank" href="{{url('/storage/store/'.$product->id.'/'.$image->image)}}">View</a>&nbsp;|
                                                                                    <a href="{{url('/admin/store/product/other_image/delete/'.$image->id)}}">Delete</a>
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="form-label" for="basicSelect">Category</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <select class="form-select" id="basicSelect" name="category_id"
                                                                required>
                                                                <option value="">Select Category</option>
                                                                @foreach ($categories as $cat)
                                                                    <option <?php if ($product->category_id == $cat->id) {
                                                                        echo 'selected';
                                                                    } ?> value="{{ $cat->id }}">
                                                                        {{ $cat->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="form-label" for="basicSelect">Color</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <div class="demo-inline-spacing">
                                                                @foreach ($colors as $color)
                                                                    @php
                                                                        $checked = '';
                                                                        if (in_array($color->id, $productColorsArray)) {
                                                                            $checked = 'checked';
                                                                        }
                                                                    @endphp
                                                                    <div class="form-check form-check-inline mt-0">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="color[]" {{ $checked }}
                                                                            id="colorCheckbox{{ $color->id }}"
                                                                            value="{{ $color->id }}" />
                                                                        <label class="form-check-label"
                                                                            for="colorCheckbox{{ $color->id }}">{{ $color->title.$color->id }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="form-label" for="basicSelect">Size</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <div class="demo-inline-spacing">
                                                                @foreach ($sizes as $size)
                                                                    @php
                                                                        $checked = '';
                                                                        if (in_array($size->id, $productSizesArray)) {
                                                                            $checked = 'checked';
                                                                        }
                                                                    @endphp
                                                                    <div class="form-check form-check-inline mt-0">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="size[]"
                                                                            id="sizeCheckbox{{ $size->id }}"
                                                                            {{ $checked }}
                                                                            value="{{ $size->id }}" />
                                                                        <label class="form-check-label"
                                                                            for="sizeCheckbox{{ $size->id }}">{{ $size->title }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="email-id">Short
                                                                Description</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <textarea type="text" class="form-control" name="short_description" placeholder="Short Description" required
                                                                rows="2" minlength="20" maxlength="100">{{ $product->short_description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-3">
                                                            <label class="col-form-label" for="email-id">Long
                                                                Description</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <textarea type="text" class="form-control" name="long_description" placeholder="Long Description" rows="10"
                                                                required minlength="100" maxlength="1000">{{ $product->long_description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 offset-sm-3">
                                                    <button type="button" value="Save" id="reference_submit_button"
                                                        name="reference_submit_button" class="btn btn-primary"
                                                        onclick="formSubmission()">Save</button>
                                                    <input type="submit" id="submit_button" value="Save"
                                                        class="d-none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function formSubmission() {
            $("#submit_button").click();
            return;
        }
    </script>

@endsection
