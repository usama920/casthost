@section('page_title')
    Subscribed Users
@endsection
@section('navbar_profile', 'active')
@include('front.user_layout.header')
@section('subscriber-profile-users', 'text-dark active')

<section class="page-header page-header-modern header-background-image" style="padding-top: 70px; padding-bottom: 30px;">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-normal text-12 m-0 pb-2">Subscribed Users</h1>
            </div>
        </div>
    </div>
</section>

<div class="container pt-5 pb-2">
    <div class="row pt-2">
        <div class="col-lg-3 mt-4 mt-lg-0">
            @include('front.subscriber_sidebar')
        </div>
        @if (isset($users_subscribed) && count($users_subscribed) > 0)
            <div class="col-lg-9">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="">
                            <tr>
                                <th colspan="1">
                                    #
                                </th>
                                <th colspan="1">
                                    Name
                                </th>
                                <th colspan="1">
                                    Username
                                </th>
                                <th colspan="1">
                                    Type
                                </th>
                                <th colspan="1">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users_subscribed as $key => $user)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{$user->user->name}}
                                    </td>
                                    <td>
                                        <a href="{{url('/'.$user->user->username)}}" class="btn btn-sm btn-outline btn-success">Profile</a>
                                    </td>
                                    <td>
                                        @if($user->paid == 1)
                                        Paid
                                        @else
                                        Normal
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline btn-danger" data-bs-toggle="modal" onclick="unsubscribeUser({{$user->user_id}}, {{$user->paid}})" data-bs-target="#formModal">Un-Subscribe</button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="col-lg-9">
                <h4 class="text-center mt-3" style="color: black; z-index:1; ">You haven't subscribed to any user.</h4>
            </div>
        @endif
    </div>

</div>


<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="formModalLabel">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p id="confirmationText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <a href="{{url('/unsubscribe/'.$user->user_id)}}" id="unsubscribeLink" class="btn btn-primary">Confirm</a>
            </div>
        </div>
    </div>
</div>

<script>
    function unsubscribeUser(id, type) {
        if(type != null || type == 1) {
            $('#confirmationText').html(`After unsubscribing, you won't be able to get access of premium content provided by this user and later on if you decided to subscribe again, you will again have to pay subscription fee. Are you sure you want to unsibscribe?`);
        } else {
            $('#confirmationText').html(`After unsubscribing, you won't be able to get updates regarding new podcasts by this user.  Are you sure you want to unsubscribe?`);
        }
        $('#unsubscribeLink').attr("href", "/unsubscribe/"+id);   
    }
</script>

@include('front.layout.footer')
