@extends('admin.layout.admin_master')
@section('page_title', 'User Detail')
@section('users', 'active')
@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="app-user-view-account">
                    <div class="row">
                        <!-- User Sidebar -->
                        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                            <!-- User Card -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="user-avatar-section">
                                        <div class="d-flex align-items-center flex-column">
                                            @if ($user->image != null)
                                                <img class="img-fluid rounded mt-3 mb-2"
                                                    src="{{ asset('project_assets/images/' . $user->image) }}"
                                                    height="110" width="110" alt="User avatar" />
                                            @endif
                                            <div class="user-info text-center">
                                                <h4>{{ $user->name }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-around my-2 pt-75">
                                        <div class="d-flex align-items-start me-2">
                                            <span class="badge bg-light-primary p-75 rounded">
                                                <i data-feather='eye' class="font-medium-2"></i>
                                            </span>
                                            <div class="ms-75">
                                                <h4 class="mb-0">{{$total_views}}</h4>
                                                <small>Views</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <span class="badge bg-light-primary p-75 rounded">
                                                <i data-feather='download' class="font-medium-2"></i>
                                            </span>
                                            <div class="ms-75">
                                                <h4 class="mb-0">{{$total_downloads}}</h4>
                                                <small>Downloads</small>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                                    <div class="info-container">
                                        <ul class="list-unstyled">
                                            <li class="mb-75 ellipsis_text">
                                                <span class="fw-bolder me-25">Email:</span>
                                                <span>{{ $user->email }}</span>
                                            </li>
                                            <li class="mb-75 ellipsis_text">
                                                <span class="fw-bolder me-25">Podcasts:</span>
                                                <span>{{ $user->podcasts_count }}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Status:</span>
                                                @if ($user->status == 1)
                                                    <a href="{{ url('/admin/user/inactive/' . $user->id) }}"> <span
                                                            class="badge bg-light-success">Active</span></a>
                                                @else
                                                    <a href="{{ url('/admin/user/active/' . $user->id) }}"> <span
                                                            class="badge bg-light-danger">Inactive</span>
                                                    </a>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /User Card -->
                        </div>
                        <!--/ User Sidebar -->

                        <!-- User Content -->
                        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

                            <div class="card">
                                <h4 class="card-header" style="justify-content: flex-start;">User's Podcasts List
                                    <span>
                                        <a class="dt-button create-new btn btn-success mx-1 my-1" href="{{url('/admin/user_podcasts/export/'.$user->id)}}"><span>Export</span></a>
                                    </span>
                                </h4>

                                <div class="table-responsive">
                                    <table class="table datatable-project">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->podcasts as $key => $podcast)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $podcast->title }}</td>
                                                    <td>{{ $podcast->category->title }}</td>
                                                    <td class="text-center">
                                                        @if ($podcast->admin_status == 1)
                                                            <a href="{{ url('/admin/user/podcast/inactive/' . $podcast->id) }}"><span
                                                                    class="badge rounded-pill badge-light-primary">Active</span></a>
                                                        @elseif ($podcast->admin_status == 0)
                                                            <a href="{{ url('/admin/user/podcast/active/' . $podcast->id) }}"><span
                                                                    class="badge rounded-pill badge-light-secondary">Inactive</span></a>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ url('/admin/user/podcast/detail/' . $podcast->id) }}">
                                                            <span class="badge rounded-pill badge-light-warning"><i
                                                                    data-feather="eye" class="me-50"></i>Detail</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /Project table -->


                        </div>
                        <!--/ User Content -->
                    </div>
                </section>

            </div>
        </div>
    </div>


@endsection
