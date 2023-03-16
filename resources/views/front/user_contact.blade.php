@section('page_title')
{{$user->name}} Contact
@endsection
@section('navbar_contact', 'active')
@include('front.user_layout.header')

    <section class="page-header page-header-modern page-header-background p-100 mb-0 header-background-image" style="background-image: url({{asset('project_assets/images/'.$page->image)}});">
        <div class="container">
            <div class="row py-3">
                <div class="col-md-12 align-self-center p-static order-2 text-center">
                    <h1 class="font-weight-normal text-12 m-0 pb-2">{{$page->heading}}</h1>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container">
            <div class="row justify-content-center pt-4 mt-4 pb-4 mb-4">
                <div class="col-lg-12 pb-3">
                    <p>{!!$page->text!!}</p>

                    <form class="form" action="{{url('/contact/user')}}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="row">
                            <div class="form-group text-start col">
                                <input type="text" placeholder="Your Name" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group text-start col">
                                <input type="email" placeholder="Your E-mail" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group text-start col">
                                <input type="text" placeholder="Subject" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control" name="subject" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group text-start col">
                                <textarea maxlength="2000" placeholder="Message" data-msg-required="Please enter your message." rows="10" class="form-control" name="message" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group text-center col">
                                <input type="submit" value="Send Message" class="btn btn-quaternary  btn-lg text-uppercase font-weight-semibold" data-loading-text="Loading...">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')