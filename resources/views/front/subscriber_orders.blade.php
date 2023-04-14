@section('page_title')
    Orders
@endsection
@section('navbar_profile', 'active')
@include('front.user_layout.header')
@section('subscriber-profile-orders', 'text-dark active')

<section class="page-header page-header-modern header-background-image" style="padding-top: 70px; padding-bottom: 30px;">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-normal text-12 m-0 pb-2">Orders</h1>
            </div>
        </div>


    </div>

</section>

<div class="container pt-5 pb-2">
    <div class="row pt-2">
        <div class="col-lg-3 mt-4 mt-lg-0">
            @include('front.subscriber_sidebar')
        </div>
        @if (isset($orders) && count($orders) > 0)
            <div class="col-lg-9">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="">
                            <tr>
                                <th colspan="1">
                                    #
                                </th>
                                <th colspan="1">
                                    Order By
                                </th>
                                <th colspan="1">
                                    Phone
                                </th>
                                <th colspan="1">
                                    Address
                                </th>
                                <th colspan="1">
                                    Price($)
                                </th>
                                <th colspan="1">
                                    Status
                                </th>
                                <th colspan="1">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $order->first_name . ' ' . $order->last_name }}
                                    </td>
                                    <td>
                                        {{ $order->phone }}
                                    </td>
                                    <td>
                                        {{ $order->street_address . ', ' . $order->city . ', ' . $order->state . ', ' . $order->country }}
                                    </td>
                                    <td>
                                        {{ $order->price }}
                                    </td>
                                    <td>
                                        @if($order->status == 2)
                                        On It's Way
                                        @elseif($order->status == 3)
                                        Delivered
                                        @else
                                        Pending
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <button class="btn btn-modern btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">
                                            Launch Large Modal
                                        </button> --}}
                                        <button class="badge badge-info badge-sm" data-bs-toggle="modal"
                                            onclick="ViewOrderDetail({{ $order->id }})"
                                            data-bs-target="#largeModal"><i
                                                class="bi bi-eye">&nbsp;&nbsp;Detail</i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="col-lg-9">

                <h4 class="text-center mt-3" style="color: black; z-index:1; ">No Orders were found.</h4>
                <div class="text-center">

                    <a href="{{ url($user->username . '/store') }}" class="btn btn-primary btn-px-5"
                        style="width: auto !important;">Store</a>
                </div>

            </div>
        @endif
    </div>

</div>

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Order Items</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal_body">
            </div>
            <div class="modal-footer" style="border-top: none;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script>
    function ViewOrderDetail(id) {
        $('#modal_body').html('<p>Loading...</p>');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            url: "/subscriber/order/detail",
            data: {
                id
            },
            success: function(response) {
                console.log(response);
                let html = "";
                if (response.status == 'success') {
                    html += `
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                    <thead class="">
                        <tr>
                            <th colspan="1">
                                #
                            </th>
                            <th colspan="1">
                                Product
                            </th>
                            <th colspan="1">
                                Quantity
                            </th>
                            <th colspan="1">
                                Color
                            </th>
                            <th colspan="1">
                                Size
                            </th>
                            <th colspan="1">
                                Price($)
                            </th>
                            <th colspan="1">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>`;
                        $.each(response.order_items, function(key, item) {
                            html += `<tr>
                                    <td>
                                        ${++key}
                                    </td>
                                    <td>
                                        ${item.product_name}
                                    </td>
                                    <td>
                                        ${item.quantity}
                                    </td>
                                    <td>
                                        ${item.color}
                                    </td>
                                    <td>
                                        ${item.size}
                                    </td>
                                    <td>
                                        ${item.price}
                                    </td>
                                    <td>`
                                    let status = "Pending";
                                    if(item.status == 2) {
                                        status = "On It's Way";
                                    } else if(item.status == 3) {
                                        status = "Delivered";
                                    }
                                    html += `${status}</td>
                                </tr>`;
                            });
                            html += '</tbody></table></div>';
                            $("#modal_body").html(html);
                }
            },
        });
    }
</script>
@include('front.layout.footer')
