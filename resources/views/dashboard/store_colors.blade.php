@extends('dashboard.layout.admin_master')
@section('page_title', 'Store Colors')
@section('store_colors', 'active')
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Store Colors</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/users')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{url('/users/store/colors')}}">Store Colors</a>
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
                                                </svg>Add New Color</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($colors) > 0)
                                        @foreach ($colors as $key => $color)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td id="title{{$color->id}}">{{$color->title}}</td>
                                            <td class="text-center">
                                                @if($color->status == 1)
                                                <a href="{{url('/users/store/color/inactive/'.$color->id)}}"><span class="badge rounded-pill badge-light-primary">Active</span></a>
                                                @elseif ($color->status == 0)
                                                <a href="{{url('/users/store/color/active/'.$color->id)}}"><span class="badge rounded-pill badge-light-secondary">Inactive</span></a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" id="{{$color->id}}" onclick="EditColor(this.id)">
                                                    <span class="badge rounded-pill badge-light-warning"><i data-feather="edit" class="me-50"></i>Edit</span>
                                                </button>
                                                <a href="{{url('/users/store/color/delete/'.$color->id)}}">
                                                    <span class="badge rounded-pill badge-light-danger"><i data-feather='archive'></i>&nbsp;Delete</span>
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
                        <form class="add-new-record modal-content pt-0" method="POST" action="{{url('/users/store/color/add')}}">
                            @csrf
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">New color</h5>
                            </div>
                            <div class="modal-body flex-grow-1">
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Title</label>
                                    <input type="text" class="form-control dt-full-name" name="title" required placeholder="Title">
                                    @error('title')
                                    <span style="color: red; font-weight: 500; font-size:13px">{{$message}}</span>
                                    @enderror
                                </div>
                                <input type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light" value="Save">
                                <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

            </section>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add-new-record modal-content pt-0" method="POST" action="{{url('/users/store/color/edit')}}">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="color_id" />
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-fullname">Title</label>
                            <input type="text" class="form-control dt-full-name" id="color_title" name="title" required placeholder="Title" />
                            @error('title')
                            <span style="color: red; font-weight: 500; font-size:13px">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Save" />
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


<script>
    function EditColor(id) {
        let title = $('#title' + id).html();
        $("input[id='color_title']").val(title);
        $("input[id='color_id']").val(id);
    }
</script>
@endsection