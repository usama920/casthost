
@extends('super_admin.layout.admin_master')
@section('page_title', 'About Page')
@section('about_page', 'active')
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
                                        <a href="{{ url('/superAdmin') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/superAdmin/pages/about') }}">About Page</a>
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
                                    <form class="form" action="{{ url('/superAdmin/pages/about') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Cover Image [Ideal Aspect
                                                        Ratio = 4:1]</label>
                                                    <input type="file" class="form-control" name="image">
                                                </div>
                                                @if ($page->image != null)
                                                    <img src="{{ asset('project_assets/images/' . $page->image) }}"
                                                        style="width: 100px;" class="mb-1">
                                                @endif
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Heading</label>
                                                    <input type="text" class="form-control" required name="heading"
                                                        value="{{ $page->heading }}" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Mission</label>
                                                    <textarea name="mission" required rows="4" class="form-control">{{$page->mission}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Vision</label>
                                                    <textarea name="vision" required rows="4" class="form-control">{{$page->vision}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="company-column">Text</label>
                                                    <textarea id="editor1" name="text" rows="10" class="form-control" required>{{$page->text}}</textarea>
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
