@extends('admin.layout.admin_master')
@section('page_title', 'All Users')
@section('users', 'active')
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">All Users</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{url('/admin/users')}}">Users</a>
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
                                                </svg>Add New User</span></button>
                                        <a class="dt-button create-new btn btn-success mx-1" href="{{url('/admin/users/export')}}"><span>Export</span></a>
                                    </div>
                                </div>
                            </div>
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <form method="GET" action="{{url('/admin/users/search')}}">
                                    @csrf
                                    <div class="row" style="width: 100%">
                                        <div class="col-md-3 col-sm-6">
                                            <input type="text" class="form-control my-1 mx-1" required placeholder="Search Users by Name/Email" name="title" aria-controls="DataTables_Table_0">
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <input type="submit" value="Search" class="btn btn-primary my-1">
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Memory Stats</th>
                                            <th class="text-center">Podcasts</th>
                                            <th class="text-center">Subscribers</th>
                                            <th class="text-center">Views</th>
                                            <th class="text-center">Downloads</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($users) > 0)
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td style="min-width: 215px;">
                                                {{get_memory_usage($user->id, "user")}} / {{$user->memory_limit}} GB
                                                <button type="button" class="badge rounded-pill badge-light-secondary"
                                                                data-bs-toggle="modal" data-bs-target="#addNewCard" onclick="editMemoryLimit({{$user->id}}, {{$user->memory_limit}}, {{get_memory_usage_bytes($user->id, 'user')}})">
                                                                Edit
                                                            </button>
                                            </td>
                                            <td class="text-center">{{$user->podcasts_count}}</td>
                                            <td class="text-center">{{$user->subscribers_count}}</td>
                                            <td class="text-center">{{$user->total_views}}</td>
                                            <td class="text-center">{{$user->total_downloads}}</td>
                                            <td class="text-center">
                                                @if($user->status == 1)
                                                <a href="{{url('/admin/user/inactive/'.$user->id)}}"><span class="badge rounded-pill badge-light-primary">Active</span></a>
                                                @elseif ($user->status == 0)
                                                <a href="{{url('/admin/user/active/'.$user->id)}}"><span class="badge rounded-pill badge-light-secondary">Inactive</span></a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{url('/admin/user/detail/'.$user->id)}}">
                                                    <span class="badge rounded-pill badge-light-warning"><i data-feather="eye" class="me-50"></i>Detail</span>
                                                </a>
                                                <a href="{{url('/admin/user/delete/'.$user->id)}}">
                                                    <span class="badge rounded-pill badge-light-danger"><i data-feather="trash" class="me-50"></i>Delete</span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7" class="text-center">
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
                        <form class="add-new-record modal-content pt-0" method="POST" id="addUserForm" action="{{url('/admin/user/add')}}">
                            @csrf
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">New User</h5>
                            </div>
                            <div class="modal-body flex-grow-1">
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                    <input type="text" class="form-control dt-full-name" name="name" required placeholder="Name">
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Username</label>
                                    <input type="text" class="form-control dt-full-name" name="username" required placeholder="Username" id="username" />
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Email</label>
                                    <input type="email" class="form-control dt-full-name" name="email" required placeholder="Email" id="email">
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Password</label>
                                    <input type="password" class="form-control dt-full-name" name="password" required placeholder="Password" minlength="6">
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Memory Limit (GB)</label>
                                    <input type="number" class="form-control dt-full-name" name="memory_limit" required placeholder="Memory Limit" min="1" max="{{$admin_memory_limit}}">
                                </div>
                                @if($admin_memory_limit > 0)
                                <div id="error" class="error"></div>
                                <input type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" value="Save">
                                <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
                                @else
                                <div id="error" class="error">You don't have any spare memory to allot any user.</div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <h1 class="text-center mb-1" id="addNewCardTitle">Edit Memory Limit</h1>
                    <!-- form -->
                    <form method="POST" action="{{url('/admin/user/edit/memory')}}" class="row gy-1 gx-2 mt-75">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="col-12">
                            <label class="form-label" for="newMemoryLimit">New Memory Limit</label>
                            <div class="input-group input-group-merge">
                                <input id="newMemoryLimit" name="newMemoryLimit"
                                    class="form-control add-credit-card-mask" type="text"
                                    placeholder="" required />
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-1 mt-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<script>

function editMemoryLimit(id, memory_limit, memory_used) {
            $('input[name="id"]').val(id);
            let minimum_limit = 1;
            if(parseInt(memory_used) > 1073741824) {
                minimum_limit = ceil(memory_used/1073741824);
            }
            $('input[name="newMemoryLimit"]').attr("placeholder", `Minimum ${minimum_limit}`);
            $('input[name="newMemoryLimit"]').attr("min", minimum_limit);
        }

$("#addUserForm").on("submit", function (e) {
    e.preventDefault();
    let email = $("input[id='email']").val();
    let username = $("input[id='username']").val();
    $("#error").html("");

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        method: "POST",
        url: "/admin/user/add/verify/email",
        data: {
            email,
            username
        },

        success: function (response) {
            if (response.status == "success") {
                $('#addUserForm').submit();
            } else {
                $("#error").html(response.message);
            }
            return;
        },
    });
});

</script>

@endsection