@section('page_title')
    Store
@endsection
@section('navbar_store', 'active')
@include('front.user_layout.header')


<link rel="stylesheet" href="{{ asset('front_assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('front_assets/vendor/owl.carousel/assets/owl.theme.default.min.css') }}">

<link rel="stylesheet" href="{{ asset('front_assets/css/theme-shop.css') }}">


<section class="page-header page-header-modern page-header-background p-100 header-background-image"
    style="background-image: url({{ asset('project_assets/images/' . $page->image) }});">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-normal text-12 m-0 pb-2">{{ $page->heading }}</h1>
            </div>
        </div>
    </div>
</section>
<div class="container p-0 pt-2">
    <div class="row">
        <div class="col-lg-3 order-2 order-lg-1">
            <aside class="sidebar">
                <form action="page-search-results.html" method="get">
                    <div class="input-group mb-3 pb-1">
                        <input class="form-control text-1" placeholder="Search..." name="s" id="s"
                            type="text">
                        <button type="submit" class="btn btn-dark text-1 p-2"><i
                                class="fas fa-search m-2"></i></button>
                    </div>
                </form>
                <h5 class="font-weight-semi-bold pt-3">Categories</h5>
                <ul class="nav nav-list flex-column">
                    @foreach ($categories as $category)
                        <li class="nav-item"><a class="nav-link"
                                href="{{ url('/' . $user->username . '/store/' . $category->id) }}">{{ $category->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </aside>
        </div>
        <div class="col-lg-9 order-1 order-lg-2">
            <div class="row">
                <div class="col-lg-6">

                    <div class="thumb-gallery-wrapper">
                        <div
                            class="thumb-gallery-detail owl-carousel owl-theme manual nav-inside nav-style-1 nav-dark mb-3">
                            <div>
                                <img alt="" class="img-fluid"
                                    src="{{ asset('storage/store/' . $product->id . '/' . $product->main_image) }}"
                                    data-zoom-image="{{ asset('storage/store/' . $product->id . '/' . $product->main_image) }}">
                            </div>
                            @foreach ($product->ProductOtherImages as $otherImage)
                                <div>
                                    <img alt="" class="img-fluid"
                                        src="{{ asset('storage/store/' . $product->id . '/' . $otherImage->image) }}"
                                        data-zoom-image="{{ asset('storage/store/' . $product->id . '/' . $otherImage->image) }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="thumb-gallery-thumbs owl-carousel owl-theme manual thumb-gallery-thumbs">
                            <div class="cur-pointer">
                                <img alt="" class="img-fluid"
                                    src="{{ asset('storage/store/' . $product->id . '/' . $product->main_image) }}">
                            </div>
                            @foreach ($product->ProductOtherImages as $otherImage)
                                <div class="cur-pointer">
                                    <img alt="" class="img-fluid"
                                        src="{{ asset('storage/store/' . $product->id . '/' . $otherImage->image) }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="summary entry-summary position-relative">
                        <h1 class="mb-0 font-weight-bold text-7">{{ $product->title }}</h1>
                        <div class="divider divider-small">
                            <hr class="bg-color-grey-scale-4">
                        </div>
                        <p class="price mb-3">
                            <span class="sale text-color-dark">${{ $product->price }}</span>
                        </p>
                        <p class="text-3-5 mb-3">{{ $product->short_description }}</p>
                        <ul class="list list-unstyled text-2">
                            <li class="mb-0">AVAILABILITY: <strong class="text-color-dark">AVAILABLE</strong></li>
                        </ul>
                        <form id="addToCart" class="cart shop">
                            <table class="table table-borderless" style="max-width: 300px;">
                                <tbody>
                                    @if (count($product_sizes) > 0)
                                        <tr>
                                            <td class="align-middle text-2 px-0 py-2">SIZE:</td>
                                            <td class="px-0 py-2">
                                                <div class="custom-select-1">
                                                    <select name="size"
                                                        class="form-control form-select text-1 h-auto py-2">
                                                        <option value="">PLEASE CHOOSE</option>
                                                        @foreach ($product_sizes as $size)
                                                            <option value="{{ $size->title }}">{{ $size->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @if (count($product_colors) > 0)
                                        <tr>
                                            <td class="align-middle text-2 px-0 py-2">COLOR:</td>
                                            <td class="px-0 py-2">
                                                <div class="custom-select-1">
                                                    <select name="color"
                                                        class="form-control form-select text-1 h-auto py-2">
                                                        <option value="">PLEASE CHOOSE</option>
                                                        @foreach ($product_colors as $color)
                                                            <option value="{{ $color->title }}">{{ $color->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <hr>
                            <div class="quantity quantity-lg">
                                <input type="button"
                                    class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                    value="-">
                                <input type="text" class="input-text qty text" title="Qty" value="1"
                                    name="quantity" min="1" step="1">
                                <input type="button"
                                    class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                    value="+">
                            </div>
                            @if (is_subscriber())
                            <button type="submit"
                                class="btn btn-dark btn-modern text-uppercase bg-color-hover-primary border-color-hover-primary">Add
                                to cart</button>
                            @else
                            <a href="{{url($user->username.'/login')}}"
                                class="btn btn-dark btn-modern text-uppercase bg-color-hover-primary border-color-hover-primary">Add
                                to cart</a>
                            @endif
                            <div id="cart_error" class="error"></div>
                            <hr>
                        </form>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div id="description"
                        class="tabs tabs-simple tabs-simple-full-width-line tabs-product tabs-dark mb-2">
                        <ul class="nav nav-tabs justify-content-start">
                            <li class="nav-item"><a
                                    class="nav-link active font-weight-bold text-3 text-uppercase py-2 px-3"
                                    href="#productDescription" data-bs-toggle="tab">Description</a></li>
                        </ul>
                        <div class="tab-content p-0">
                            <div class="tab-pane px-0 py-3 active" id="productDescription">
                                <p>{{ $product->long_description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('front_assets/vendor/plugins/js/plugins.min.js') }}"></script>
<script src="{{ asset('front_assets/vendor/elevatezoom/jquery.elevatezoom.min.js') }}"></script>
<script src="{{ asset('front_assets/js/theme.js') }}"></script>
<script src="{{ asset('front_assets/js/views/view.shop.js') }}"></script>
<script src="{{ asset('front_assets/js/examples/examples.gallery.js') }}"></script>

<script>
    const product_id = "{{ $product->id }}";
    const size_requirement = "{{ $size_requirement }}";
    const color_requirement = "{{ $color_requirement }}";
    $('#addToCart').submit(function(e) {
        e.preventDefault();
        color = null;
        size = null;

        if (size_requirement == 1) {
            size = $("select[name='size']").val();
            if (size == "" || size == null) {
                $('#cart_error').html('Please choose size.');
                return;
            }
        }

        if (color_requirement == 1) {
            color = $("select[name='color']").val();
            if (color == "" || color == null) {
                $('#cart_error').html('Please choose color.');
                return;
            }
        }
        $('#cart_error').html('');
        const quantity = $("input[name='quantity']").val();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/store/update_cart",
            data: {
                product_id,
                quantity,
                size,
                color
            },
            success: function(response) {
                if(response.status == 'success') {
                    toastr.success(response.message);
                }
            },
        });


        return;
    });
</script>

@include('front.layout.footer')
