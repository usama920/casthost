@section('page_title')
    Cart
@endsection
@section('navbar_cart', 'active')
@include('front.user_layout.header')


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
    <div class="row pb-4 mb-5">
        <div class="col-lg-8 mb-5 mb-lg-0">
            <form method="post" action="" class="shop">
                <div class="table-responsive">
                    <table class="shop_table cart">
                        <thead>
                            <tr class="text-color-dark">
                                <th class="product-thumbnail" width="15%">
                                    &nbsp;
                                </th>
                                <th class="product-name text-uppercase" width="20%">
                                    Product
                                </th>
                                <th class="product-name text-uppercase" width="15%">
                                    Size
                                </th>
                                <th class="product-name text-uppercase" width="15%">
                                    Color
                                </th>
                                <th class="product-name text-uppercase" width="15%">
                                    Price
                                </th>
                                <th class="product-quantity text-uppercase" width="20%">
                                    Quantity
                                </th>
                                <th class="product-subtotal text-uppercase text-end" width="20%">
                                    Subtotal
                                </th>
                            </tr>
                        </thead>
                        <tbody id="cart_table_items">
                            @if(count($cart_items) > 0)
                            @foreach ($cart_items as $item)
                                <tr class="cart_table_item">
                                    <td class="product-thumbnail">
                                        <div class="product-thumbnail-wrapper">
                                            <span onclick="removeProduct({{ $item->id }})"
                                                class="product-thumbnail-remove" title="Remove Product">
                                                <i class="fas fa-times"></i>
                                            </span>
                                            <a href="shop-product-sidebar-right.html" class="product-thumbnail-image"
                                                title="Photo Camera">
                                                <img width="90" height="90" alt="" class="img-fluid"
                                                    src="{{ asset('storage/store/' . $item->product_id . '/' . $item->product->main_image) }}">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a href="shop-product-sidebar-right.html"
                                            class=" font-weight-semi-bold text-color-dark text-color-hover-primary ">{{ substr($item->product->title, 0, 15) }}</a>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a
                                            class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none">{{ $item->size }}</a>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a
                                            class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none">{{ $item->color }}</a>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a
                                            class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none">${{ $item->product->price }}</a>
                                    </td>
                                    <td class="product-quantity">
                                        <div class="quantity float-none m-0">
                                            <input type="button"
                                                class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                value="-"
                                                onclick="changeQuantity({{ $item->id }}, 'decrease')">
                                            <input type="text" class="input-text qty text" title="Qty"
                                                value="{{ $item->quantity }}" name="quantity{{$item->id}}" min="1"
                                                step="1">
                                            <input type="button"
                                                class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                value="+"
                                                onclick="changeQuantity({{ $item->id }}, 'increase')">
                                        </div>
                                    </td>
                                    <td class="product-subtotal text-end">
                                        <span
                                            class="amount text-color-dark font-weight-bold text-4">${{ $item->product->price * $item->quantity }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr class="cart_table_item">
                                <td colspan="7" class="text-center strong">No items exist in cart.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <div class="col-lg-4 position-relative">
            <div class="card border-width-3 border-radius-0 border-color-hover-dark" data-plugin-sticky
                data-plugin-options="{'minWidth': 991, 'containerSelector': '.row', 'padding': {'top': 85}}">
                <div class="card-body">
                    <h4 class="font-weight-bold text-uppercase text-4 mb-3">Cart Totals</h4>
                    <table class="shop_table cart-totals mb-4">
                        <tbody>
                            <tr class="cart-subtotal">
                                <td class="border-top-0">
                                    <strong class="text-color-dark">Subtotal</strong>
                                </td>
                                <td class="border-top-0 text-end">
                                    <strong><span class="amount font-weight-medium">$ <span id="total_price">{{$total_price}}</span></span></strong>
                                </td>
                            </tr>
                            <tr class="total">
                                <td>
                                    <strong class="text-color-dark text-3-5">Total</strong>
                                </td>
                                <td class="text-end">
                                    <strong class="text-color-dark"><span
                                            class="amount text-color-dark text-5">$<span id="total_price_shipping">{{$total_price}}</span></span></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{url('/'.$user->username.'/checkout')}}"
                        class="btn btn-dark btn-modern w-100 text-uppercase bg-color-hover-primary border-color-hover-primary border-radius-0 text-3 py-3">Proceed
                        to Checkout <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('front_assets/vendor/plugins/js/plugins.min.js') }}"></script>
<script src="{{ asset('front_assets/js/views/view.shop.js') }}"></script>

<script>
    function changeQuantity(id, type) {
        let quantity = parseInt($("input[name='quantity"+id+"']").val());
        console.log(quantity);
        if (type == "decrease" && quantity <= 1) {
            return;
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/store/update_cart/quantity",
            data: {
                id,
                type
            },
            success: function(response) {
                if (response.status == 'success') {
                    html = "";
                    $.each(response.cart_items, function(key, item) {
                        html += `<tr class="cart_table_item">
                                    <td class="product-thumbnail">
                                        <div class="product-thumbnail-wrapper">
                                            <span onclick="removeProduct(${item.id})"
                                                class="product-thumbnail-remove" title="Remove Product">
                                                <i class="fas fa-times"></i>
                                            </span>
                                            <a href="shop-product-sidebar-right.html" class="product-thumbnail-image"
                                                title="Photo Camera">
                                                <img width="90" height="90" alt="" class="img-fluid"
                                                    src="/storage/store/${item.product_id}/${item.product.main_image}">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a href="shop-product-sidebar-right.html"
                                            class=" font-weight-semi-bold text-color-dark text-color-hover-primary ">${item.product.title}</a>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a
                                            class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none">${item.size}</a>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a
                                            class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none">${item.color}</a>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a
                                            class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none">${item.product.price}</a>
                                    </td>
                                    <td class="product-quantity">
                                        <div class="quantity float-none m-0">
                                            <input type="button"
                                                class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                value="-"
                                                onclick="changeQuantity(${item.id}, 'decrease')">
                                            <input type="text" class="input-text qty text" title="Qty"
                                                value="${item.quantity}" name="quantity${item.id}" min="1"
                                                step="1">
                                            <input type="button"
                                                class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                value="+"
                                                onclick="changeQuantity(${item.id}, 'increase')">
                                        </div>
                                    </td>
                                    <td class="product-subtotal text-end">
                                        <span
                                            class="amount text-color-dark font-weight-bold text-4">$${ item.product.price * item.quantity }</span>
                                    </td>
                                </tr>`;
                    });
                    $('#cart_table_items').html(html);
                    $('#total_price').html(response.total_price);
                    $('#total_price_shipping').html(response.total_price);
                }
            },
        });
    }

    function removeProduct(id) {
        console.log(id);
        if (id == null || id == '') {
            return;
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/store/update_cart/remove",
            data: {
                id
            },
            success: function(response) {
                if (response.status == 'success') {
                    html = "";
                    $.each(response.cart_items, function(key, item) {
                        html += `<tr class="cart_table_item">
                                    <td class="product-thumbnail">
                                        <div class="product-thumbnail-wrapper">
                                            <span onclick="removeProduct(${item.id})"
                                                class="product-thumbnail-remove" title="Remove Product">
                                                <i class="fas fa-times"></i>
                                            </span>
                                            <a href="shop-product-sidebar-right.html" class="product-thumbnail-image"
                                                title="Photo Camera">
                                                <img width="90" height="90" alt="" class="img-fluid"
                                                    src="/storage/store/${item.product_id}/${item.product.main_image}">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a href="shop-product-sidebar-right.html"
                                            class=" font-weight-semi-bold text-color-dark text-color-hover-primary ">${item.product.title}</a>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a
                                            class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none">${item.size}</a>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a
                                            class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none">${item.color}</a>
                                    </td>
                                    <td class="product-name ellipsis_text">
                                        <a
                                            class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none">${item.product.price}</a>
                                    </td>
                                    <td class="product-quantity">
                                        <div class="quantity float-none m-0">
                                            <input type="button"
                                                class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                value="-"
                                                onclick="changeQuantity(${item.id}, 'decrease')">
                                            <input type="text" class="input-text qty text" title="Qty"
                                                value="${item.quantity}" name="quantity${item.id}" min="1"
                                                step="1">
                                            <input type="button"
                                                class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                value="+"
                                                onclick="changeQuantity(${item.id}, 'increase')">
                                        </div>
                                    </td>
                                    <td class="product-subtotal text-end">
                                        <span
                                            class="amount text-color-dark font-weight-bold text-4">$${ item.product.price * item.quantity }</span>
                                    </td>
                                </tr>`;
                    });
                    $('#cart_table_items').html(html);
                    $('#total_price').html(response.total_price);
                    $('#total_price_shipping').html(response.total_price);
                }
            },
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
    integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async>
</script>

@include('front.layout.footer')
