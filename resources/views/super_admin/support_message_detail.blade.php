@extends('super_admin.layout.admin_master')
@section('page_title', 'Message Detail')
@section("support-read-messages", 'active')
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Support Message Detail</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/superAdmin/dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="{{url('/superAdmin/support/messages/detail/'.$message->id)}}">Support Message Detail</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="multiple-column-form">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="form" action="{{url('/superAdmin/support/message/reply')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$message->id}}">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Message Detail</label>
                                                <p>{{$message->message}}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Reply To User [Max:
                                                    2000]</label>
                                                <textarea class="form-control" name="reply" maxlength="1990" placeholder="Response" required rows="5"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" value="Reply">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if(count($previous_messages) > 0)
                        <div class="card">
                            <div class="card-body">
                                @foreach ($previous_messages as $message)
                                @if($message->reply_from == "superAdmin")
                                <p style="font-weight: bold;">Your Reply</p>
                                @else
                                <p style="font-weight: bold;">Admin Response</p>
                                @endif
                                <p style="font-weight: bold;">{{$message->created_at}}</p>
                                <p>{{$message->reply}}</p>
                                <hr>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection