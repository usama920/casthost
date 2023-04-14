@extends('dashboard.layout.admin_master')
@section('store_add_product', 'active')
@section('page_title', 'Add Product')
@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">New Product</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/users/dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ url('/users/store/add_product') }}">New
                                            Podcast</a>
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
                                    action="{{ url('/users/store/add_product') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label" for="first-name">Title</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="title"
                                                        placeholder="Title" required>
                                                    @error('title')
                                                        <span
                                                            style="color: red; font-weight: 500; font-size:13px">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label" for="first-name">Price($)</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="number" span="0.1" min="1" maxlength="8" class="form-control" name="price"
                                                        placeholder="Price" required>
                                                    @error('price')
                                                        <span
                                                            style="color: red; font-weight: 500; font-size:13px">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label" for="email-id">Main Image<br>[Min: 500 X
                                                        700]</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control" name="main_image" required
                                                        id="main_image">
                                                    @error('main_image')
                                                        <span
                                                            style="color: red; font-weight: 500; font-size:13px">{{ $message }}</span>
                                                    @enderror
                                                    <span id="main_image_error"
                                                        style="color: red; font-weight: 500; font-size:13px"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label" for="email-id">Other Images<br>[Min: 500 X
                                                        700]</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control" name="other_image[]" multiple
                                                        id="other_image">
                                                    @error('other_image')
                                                        <span
                                                            style="color: red; font-weight: 500; font-size:13px">{{ $message }}</span>
                                                    @enderror
                                                    <span id="other_image_error"
                                                        style="color: red; font-weight: 500; font-size:13px"></span>
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
                                                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
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
                                                            <div class="form-check form-check-inline mt-0">
                                                                <input class="form-check-input" type="checkbox" name="color[]"
                                                                    id="colorCheckbox{{ $color->id }}"
                                                                    value="{{ $color->id }}" />
                                                                <label class="form-check-label"
                                                                    for="colorCheckbox{{ $color->id }}">{{ $color->title }}</label>
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
                                                            <div class="form-check form-check-inline mt-0">
                                                                <input class="form-check-input" type="checkbox" name="size[]"
                                                                    id="sizeCheckbox{{ $size->id }}"
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
                                                    <label class="col-form-label" for="email-id">Short Description [Min.
                                                        Length: 20 & Max. Length: 100]</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea type="text" class="form-control" name="short_description" placeholder="Short Description" minlength="20"
                                                        required rows="2" maxlength="100"></textarea>
                                                    @error('short_description')
                                                        <span
                                                            style="color: red; font-weight: 500; font-size:13px">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label" for="email-id">Long Description [Min.
                                                        Length: 100 & Max. Length: 1000]</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea type="text" class="form-control" name="long_description" placeholder="Long Description"
                                                        minlength="100" required rows="10" maxlength="1000"></textarea>
                                                    @error('long_description')
                                                        <span
                                                            style="color: red; font-weight: 500; font-size:13px">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="button" value="Save" id="reference_submit_button"
                                                name="reference_submit_button" class="btn btn-primary"
                                                onclick="formSubmission()">Save</button>
                                            <input type="submit" id="submit_button" value="Save" class="d-none">
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



        const main_image = document.getElementById('main_image');
        const other_image = document.getElementById('other_image');

        main_image.addEventListener('change', (event) => {
            Upload(main_image, "main_image", 2, "#main_image_error", 500, 700);
        });
        other_image.addEventListener('change', (event) => {
            Upload(other_image, "other_image", 2, "#other_image_error", 500, 700);
        });

        function Upload(reference, input, size, error, minHeight, minWidth) {
            var fileUpload = document.getElementById(input);
            var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg)$");
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof(fileUpload.files) != "undefined") {
                    const target = reference;
                    if (target.files && target.files[0]) {
                        const maxAllowedSize = size * 1024 * 1024;
                        if (target.files[0].size > maxAllowedSize) {
                            jQuery(error).html('File size should be less than 1mb');
                            target.value = ''
                            return false;
                        } else if (target.files[0].size < maxAllowedSize) {
                            jQuery(error).html('');
                            var reader = new FileReader();
                            reader.readAsDataURL(fileUpload.files[0]);
                            reader.onload = function(e) {
                                var image = new Image();
                                image.src = e.target.result;
                                image.onload = function() {
                                    var height = this.height;
                                    var width = this.width;
                                    if (height > minHeight && width > minWidth) {
                                        jQuery(error).html('');
                                        return;
                                    } else if ((height < minHeight || width < minWidth)) {
                                        jQuery(error).html('Uploaded image has invalid Height and Width.');
                                        fileUpload.value = '';
                                        return;
                                    }
                                };
                            }
                        }
                    }
                } else if (typeof(fileUpload.files) == "undefined") {
                    jQuery(error).html("This browser does not support HTML5.");
                    fileUpload.value = '';
                    return;
                }
            } else if (!regex.test(fileUpload.value.toLowerCase())) {
                jQuery(error).html("Please select a valid file.");
                fileUpload.value = '';
                return;
            }
        }
    </script>

@endsection
