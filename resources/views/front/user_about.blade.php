@section('page_title')
{{$user->name}} About
@endsection
@section('navbar_about', 'active')
@include('front.user_layout.header')
    <section
        class="page-header page-header-modern page-header-background page-header-background-sm mb-0 p-100 header-background-image"
        style="background-image: url({{ asset('project_assets/images/' . $page->cover_image) }});">
        <div class="container">
            <div class="row py-3">
                <div class="col-md-12 align-self-center p-static order-2 text-center">
                    <h1 class="font-weight-normal text-12 m-0 pb-3">{{ $page->heading }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row mt-4 pt-4 mb-4 pb-4" style="min-height: 400px;">
                <div class="col-sm-4">
                    <div class="owl-carousel owl-theme nav-center custom-carousel-dots-style custom-carousel-dots-style-inside mt-1"
                        data-plugin-options="{'items': 1, 'responsive': {'479': {'items': 1}, '979': {'items': 1}, '1199': {'items': 1}}, 'margin': 10, 'loop': false, 'dots': true, 'nav': false, 'autoplay': true, 'autoplayTimeout': 5000}">
                        <div>
                            <img src="{{ asset('project_assets/images/' . $page->profile_image) }}" alt=""
                                class="img-fluid" />
                        </div>
                    </div>

                    <h2 class="font-weight-bold mb-2 custom-font-size-1">{{ $user->name }}</h2>

                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <ul class="list list-icons list-icons-style-2 text-color-primary">
                                <li><a href="{{ url('/' . $user->username . '/contact') }}"><i
                                            class="far fa-envelope"></i>Contact Me</a></li>
                                @if ($user->facebook != null)
                                    <li><a target="_blank" href="{{ $user->facebook }}"><i
                                                class="fab fa-facebook-f"></i>Facebook</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list list-icons list-icons-style-2 text-color-primary">
                                @if ($user->twitter != null)
                                    <li><a target="_blank" href="{{ $user->twitter }}"><i
                                                class="fab fa-twitter"></i>Twitter</a></li>
                                @endif
                                @if ($user->instagram != null)
                                    <li><a target="_blank" href="{{ $user->instagram }}"><i
                                                class="fab fa-instagram"></i>Instagram</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <p>{!! $page->text !!}</p>
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')
