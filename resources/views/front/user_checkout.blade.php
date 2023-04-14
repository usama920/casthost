@section('page_title')
    Checkout
@endsection
@section('navbar_cart', 'active')
@include('front.user_layout.header')

<link rel="stylesheet" href="{{ asset('front_assets/css/theme-shop.css') }}">

<section class="page-header page-header-modern header-background-image" style="padding-top: 70px; padding-bottom: 30px;">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-normal text-12 m-0 pb-2">Checkout</h1>
            </div>
        </div>
    </div>
</section>
<div class="container p-0 pt-2 px-2">
    <form role="form" class="needs-validation" method="post" action="{{url('/'.$user->username.'/checkout/done')}}">
        @csrf
        <div class="row">
            <div class="col-lg-7 mb-4 mb-lg-0">

                <h2 class="text-color-dark font-weight-bold text-5-5 mb-3">Shipping Details</h2>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">First Name <span class="text-color-danger">*</span></label>
                        <input type="text" class="form-control h-auto py-2" name="first_name" value=""
                            required />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Last Name <span class="text-color-danger">*</span></label>
                        <input type="text" class="form-control h-auto py-2" name="last_name" value=""
                            required />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class="form-label">Country/Region <span class="text-color-danger">*</span></label>
                        <input type="text" class="form-control h-auto py-2" name="country" value="" required />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class="form-label">Street Address <span class="text-color-danger">*</span></label>
                        <input type="text" class="form-control h-auto py-2" name="street_address" value=""
                            placeholder="House number and street name" required />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class="form-label">Town/City <span class="text-color-danger">*</span></label>
                        <input type="text" class="form-control h-auto py-2" name="city" value="" required />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class="form-label">State <span class="text-color-danger">*</span></label>
                        <input type="text" class="form-control h-auto py-2" name="state" value="" required />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class="form-label">ZIP <span class="text-color-danger">*</span></label>
                        <input type="text" class="form-control h-auto py-2" name="zip" value="" required />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class="form-label">Phone <span class="text-color-danger">*</span></label>
                        <input type="number" class="form-control h-auto py-2" name="phone" value="" required />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class="form-label">Order Notes</label>
                        <textarea class="form-control h-auto py-2" name="notes" rows="5"
                            placeholder="Notes about you order e.g. special notes for delivery"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 position-relative">
                <div class="card border-width-3 border-radius-0 border-color-hover-dark" data-plugin-sticky
                    data-plugin-options="{'minWidth': 991, 'containerSelector': '.row', 'padding': {'top': 85}}">
                    <div class="card-body">
                        <h4 class="font-weight-bold text-uppercase text-4 mb-3">Your Order</h4>
                        <table class="shop_table cart-totals mb-3">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="border-top-0">
                                        <strong class="text-color-dark">Product</strong>
                                    </td>
                                </tr>
                                @foreach ($cart_items as $item)
                                    <tr>
                                        <td>
                                            <strong
                                                class="d-block text-color-dark line-height-1 font-weight-semibold">{{ $item->product->title }}
                                                <span class="product-qty">x{{ $item->quantity }}</span></strong>
                                            <span class="text-1">{{ $item->color }} {{ $item->size }}</span>
                                        </td>
                                        <td class="text-end align-top">
                                            <span
                                                class="amount font-weight-medium text-color-grey">${{ $item->product->price * $item->quantity }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="cart-subtotal">
                                    <td class="border-top-0">
                                        <strong class="text-color-dark">Subtotal</strong>
                                    </td>
                                    <td class="border-top-0 text-end">
                                        <strong><span
                                                class="amount font-weight-medium">${{ $total_price }}</span></strong>
                                    </td>
                                </tr>
                                <tr class="total">
                                    <td>
                                        <strong class="text-color-dark text-3-5">Total</strong>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-color-dark"><span
                                                class="amount text-color-dark text-5">${{ $total_price }}</span></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="card-body">
                            <div id="card-element">
                            </div>
                            <div id="card-errors" role="alert"></div>
                        </div>
                        <button type="submit" id="card-button"
                            class="btn btn-dark btn-modern w-100 text-uppercase bg-color-hover-primary border-color-hover-primary border-radius-0 text-3 py-3">Place
                            Order <i class="fas fa-arrow-right ms-2"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('front_assets/vendor/plugins/js/plugins.min.js') }}"></script>
<script src="{{ asset('front_assets/js/views/view.shop.js') }}"></script>

@include('front.layout.footer')
