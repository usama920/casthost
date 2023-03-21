@extends('admin.layout.admin_master')
@section("read-messages", 'active')
@section('page_title', 'Read Messages')
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Read Messages</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{url('/admin/messages/read')}}">Read Messages</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th class="text-center">Subject</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($messages) > 0)
                                        @foreach ($messages as $message)
                                        <tr>
                                            <td>{{$message->name}}</td>
                                            <td>{{$message->email}}</td>
                                            <td class="text-center">{{$message->subject}}</td>
                                            <td class="text-center">
                                                <a href="{{url('/users/message/detail/'.$message->id)}}">
                                                    <span class="badge rounded-pill badge-light-warning"><i data-feather="eye" class="me-50"></i>Detail</span>
                                                </a>
                                                <a href="{{url('/users/message/delete/'.$message->id)}}">
                                                    <span class="badge rounded-pill badge-light-danger"><i data-feather="archive" class="me-50"></i>Delete</span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                No Data Found.
                                            </td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection