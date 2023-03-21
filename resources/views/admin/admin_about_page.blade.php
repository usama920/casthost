@extends('admin.layout.admin_master')
@section('about_page', 'active')
@section('page_title', 'About Page')
@section('content')


    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">About Page</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/admin') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/admin/pages/about') }}">About Page</a>
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
                                    <form class="form" action="{{ url('/admin/pages/about') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Profile Image</label>
                                                    <input type="file" class="form-control" name="profile_image">
                                                </div>
                                                @if ($page->profile_image != null)
                                                    <img src="{{ asset('project_assets/images/' . $page->profile_image) }}"
                                                        style="width: 100px;" class="mb-1">
                                                @endif
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Cover Image [Ideal Aspect
                                                        Ratio = 4:1]</label>
                                                    <input type="file" class="form-control" name="cover_image">
                                                </div>
                                                @if ($page->cover_image != null)
                                                    <img src="{{ asset('project_assets/images/' . $page->cover_image) }}"
                                                        style="width: 100px;" class="mb-1">
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Heading [Max. Length: 40]</label>
                                                    <input type="text" maxlength="40" class="form-control" required name="heading"
                                                        value="{{ $page->heading }}" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Text</label>
                                                    <textarea name="text" id="editor1" rows="10" class="form-control">{{$page->text}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <input type="submit"
                                                    class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                                    value="Save">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

<script>
    CKEDITOR.replace('editor1');
</script>

@endsection