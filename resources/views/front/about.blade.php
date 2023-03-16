@section('page_title', 'About')
@section('navbar_about', 'active')
@include('front.layout.header')

<section
    class="page-header page-header-modern page-header-background page-header-background-sm mb-0 header-background-image"
    style="background-image: url({{ asset('project_assets/images/' . $page->image) }});">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-normal text-12 m-0 pb-2">{{ $page->heading }}</h1>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row justify-content-center pt-4 mt-4 pb-4 mb-4" style="min-height: 400px;">
            <div class="row mt-3 mb-3">
                <div class="col-md-6" >
                    <div class="card border-0 bg-color-primary mb-1" style="background-color: #0088CC !important;">

                        <div class="card-body">
                            <h4 class="card-title mb-1 text-4 font-weight-bold text-light text-center">Our Mission</h4>
                            <p class="card-text text-light" style="line-height: 22px;">{{ $page->mission }}</p>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card border-0 bg-color-primary mb-1" style="background-color: #0088CC !important;">
                        <div class="card-body">
                            <h4 class="card-title mb-1 text-4 font-weight-bold text-light text-center">Our Vision</h4>
                            <p class="card-text text-light" style="line-height: 22px;">{{ $page->vision }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 pb-3">
                <p>{!! $page->text !!}</p>
            </div>
        </div>
    </div>
</section>

@include('front.layout.footer')
