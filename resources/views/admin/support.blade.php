@extends('admin.layout.admin_master')
@section('page_title', 'Support Requests')
@section('support', 'active')
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">All Support Requests</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{url('/admin/support')}}">Support Requests</a>
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
                            <div class="card-header border-bottom p-1">
                                <div class="dt-action-buttons text-end">
                                    <div class="dt-buttons d-inline-flex">
                                        <button class="dt-button create-new btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#modals-slide-in"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-50 font-small-4">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>Add New Request</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($supportMessages) > 0)
                                        @foreach ($supportMessages as $support)
                                        <tr>
                                            <td>{{$support->subject}}</td>
                                            <td>{{$support->created_at}}</td>
                                            <td class="text-center">
                                                <a href="{{url('/admin/support/detail/'.$support->id)}}">
                                                    <span class="badge rounded-pill badge-light-warning"><i data-feather="eye" class="me-50"></i>Detail</span>
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

                <div class="modal modal-slide-in fade" id="modals-slide-in" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog sidebar-sm">
                        <form class="add-new-record modal-content pt-0" method="POST" action="{{url('/admin/support/add')}}">
                            @csrf
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">New Request</h5>
                            </div>
                            <div class="modal-body flex-grow-1">
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Subject</label>
                                    <input type="text" class="form-control dt-full-name" name="subject" required placeholder="Subject">
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Message</label>
                                    <textarea type="text" class="form-control dt-full-name" name="message" required placeholder="Detail of support required..." rows="5" minlength="10"></textarea>
                                </div>
                                <div id="error" class="error"></div>
                                <input type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" value="Save">
                                <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>


@endsection