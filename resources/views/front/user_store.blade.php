@section('page_title')
    Store
@endsection
@section('navbar_store', 'active')
@include('front.user_layout.header')


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
                <form action="{{url('/'.$user->username.'/store/search')}}" method="get">
                    <div class="input-group mb-3 pb-1">
                        <input class="form-control text-1" placeholder="Search Product by Name..." name="s"
                            id="s" type="text" required>
                        <button type="submit" class="btn btn-dark text-1 p-2"><i
                                class="fas fa-search m-2"></i></button>
                    </div>
                </form>
                <h5 class="font-weight-semi-bold pt-3">Categories</h5>
                <ul class="nav nav-list flex-column">
                    @foreach ($categories as $category)
                        <li class="nav-item"><a class="nav-link"
                                href="{{ url('/' . $user->username . '/store/category/' . $category->id) }}">{{ $category->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </aside>
        </div>
        <div class="col-lg-9 order-1 order-lg-2">
            <div class="masonry-loader masonry-loader-showing">
                <div class="row products product-thumb-info-list" data-plugin-masonry
                    data-plugin-options="{'layoutMode': 'fitRows'}">
                    @foreach ($products as $product)
                        <div class="col-sm-6 col-lg-4">
                            <div class="product mb-0">
                                <div class="product-thumb-info border-0 mb-3">
                                    <a href="{{ url('/' . $user->username . '/store/' . $product->id) }}">
                                        <div class="product-thumb-info-image">
                                            <img style="height: 270px;" class="img-fluid"
                                                src="{{ asset('storage/store/' . $product->id . '/' . $product->main_image) }}">
                                        </div>
                                    </a>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ url('/' . $user->username . '/store/category/' . $product->category->id) }}"
                                            class="d-block text-uppercase text-decoration-none text-color-default text-color-hover-primary line-height-1 text-0 mb-1">{{ $product->category->title }}</a>
                                        <h3
                                            class="text-3-5 font-weight-medium font-alternative text-transform-none line-height-3 mb-0">
                                            <a href="{{ url('/' . $user->username . '/store/' . $product->id) }}"
                                                class="text-color-dark text-color-hover-primary">{{ $product->title }}</a>
                                        </h3>
                                    </div>
                                </div>
                                <div title="Rated 5 out of 5">
                                    <input type="text" class="d-none" value="5" title=""
                                        data-plugin-star-rating
                                        data-plugin-options="{'displayOnly': true, 'color': 'default', 'size':'xs'}">
                                </div>
                                <p class="price text-5 mb-3">
                                    <span
                                        class="sale text-color-dark font-weight-semi-bold">${{ $product->price }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="row">
                {{ $products->links('front.pagination') }}
            </div>
        </div>
    </div>
</div>

@include('front.layout.footer')
