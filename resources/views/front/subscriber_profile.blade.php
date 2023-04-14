@section('page_title')
    Profile
@endsection
@section('navbar_cart', 'active')
@include('front.user_layout.header')

<section class="page-header page-header-modern header-background-image" style="padding-top: 70px; padding-bottom: 30px;">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-normal text-12 m-0 pb-2">Profile</h1>
            </div>
        </div>


    </div>

</section>

    <div class="container pt-5 pb-2 ">
        
        <div class="row pt-2">
            <div class="col-lg-3 mt-4 mt-lg-0">

                @include('front.subscriber_sidebar')
                

            </div>
            <div class="col-lg-9"  >
            <h3 class="mb-5" style="text-align: center; font-weight:500; text-transform:capitalize;">Here you can change your basic info.</h3>
                <form role="form" class="needs-validation" action="{{url('/student/profile/update')}}" method="POST">
                    @csrf
                    
                    <div class="form-group row">
                        <label
                            class="col-lg-2 col-form-label form-control-label line-height-9 pt-2 text-2">Address</label>
                        <div class="col-lg-10">
                            <input class="form-control text-3 h-auto py-2" type="text" name="street" value="" maxlength="100"
                                placeholder="Street">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-lg-9">

                        </div>
                        <div class="form-group col-lg-3">
                            <input type="submit" value="Save" class="btn btn-primary btn-modern float-end"
                                data-loading-text="Loading...">
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>

<div class="container p-0 pt-2 px-2">
    
</div>

@include('front.layout.footer')
