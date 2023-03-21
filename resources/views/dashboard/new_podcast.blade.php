@extends('dashboard.layout.admin_master')
@section('new_podcast', 'active')
@section('page_title', 'New Podcast')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

@php
    $remaining_mbs = get_remaining_memory(Auth::user()->id);
    if($remaining_mbs > 2048) {
        $limit = 2048;
    } else {
        $limit = $remaining_mbs;
    }
@endphp

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">New Podcast</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="{{url('/users/podcast/new')}}">New Podcast</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card">

                        <div class="card-body">
                            @if($limit >= 10)
                            <form class="form form-horizontal" method="POST" action="{{url('/users/podcast/save')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label" for="first-name">Title</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="title" placeholder="Title" required>
                                                @error('title')
                                                <span style="color: red; font-weight: 500; font-size:13px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="form-label" for="basicSelect">Category</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="form-select" id="basicSelect" name="category_id" required>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $cat)
                                                    <option value="{{$cat->id}}">{{$cat->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label" for="email-id">Cover Image<br>[Min: 500 X 700]</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="cover_image" required id="main_image">
                                                @error('cover_image')
                                                <span style="color: red; font-weight: 500; font-size:13px">{{$message}}</span>
                                                @enderror
                                                <span id="main_image_error" style="color: red; font-weight: 500; font-size:13px"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label" for="email-id">Video/Audio<br>[Max. Size: {{$limit == 2048 ? "2GB" : $limit."MB"}}]</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="podcast" required id="podcast">
                                                @error('podcast')
                                                <span style="color: red; font-weight: 500; font-size:13px">{{$message}}</span>
                                                @enderror
                                                <span id="main_pdcast_error" style="color: red; font-weight: 500; font-size:13px"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label" for="email-id">Premier Date & Time<br>[UTC Standard]</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" class="form-control" value="{{$date_now}}" name="premiere_datetime" required>
                                                @error('premiere_datetime')
                                                <span style="color: red; font-weight: 500; font-size:13px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label" for="email-id">Description</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <textarea type="text" class="form-control" name="description" placeholder="Description" minlength="50" required rows="10" maxlength="500"></textarea>
                                                @error('description')
                                                <span style="color: red; font-weight: 500; font-size:13px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="button" value="Save" id="reference_submit_button" name="reference_submit_button" class="btn btn-primary" onclick="formSubmission()">Save</button>
                                        <input type="submit" id="submit_button" value="Save" class="d-none">
                                    </div>
                                </div>
                            </form>
                            @else
                            <h3 class="content-header-title mb-0 text-center" style="color: red;">You have already utilized memory alloted to you.</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script>
    let files_uploaded = 0;
    let files_selected = 0;
    let form_can_be_submitted = false;

    function formSubmission() {
        $("#submit_button").click();
        return;
    }

    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.registerPlugin(FilePondPluginFileValidateSize);
    const resources_files = document.querySelector('input[id="podcast"]');

    const pond1 = FilePond.create(resources_files, {
        acceptedFileTypes: ['video/x-matroska', 'video/mp4', 'audio/mpeg', 'video/mpeg'],
        fileValidateTypeDetectType: (source, type) =>
            new Promise((resolve, reject) => {
                resolve(type);
            }),
        maxFileSize: '{{$limit}}MB'
    });

    pond1.on('addfilestart', (error, file) => {
        files_uploaded = files_uploaded + 1;
        $("button[id='reference_submit_button']").prop('disabled', true);
    });


    pond1.on('processfileabort', (error, file) => {
        files_uploaded = files_uploaded - 1;
        $("button[id='reference_submit_button']").prop('disabled', false);
    });


    pond1.on('processfile', (error, file) => {
        files_uploaded = files_uploaded - 1;
        if (files_uploaded == 0) {
            $("button[id='reference_submit_button']").prop('disabled', false);
        }
    });

    pond1.setOptions({
        allowMultiple: false,
        server: {
            url: '/',
            process: {
                url: 'users/podcast/new/upload/',
                method: 'POST',
                withCredentials: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                onload: null,
                onerror: null,
                ondata: (formData) => {
                    return formData;
                },
            },
            revert: (uniqueFileId, load, error) => {
                $.ajax({
                    url: '/users/podcast/new/revert/' + uniqueFileId,
                    success: function(response) {},
                    error: function() {}
                });

                load();
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });


    const profile_image = document.getElementById('main_image');

    profile_image.addEventListener('change', (event) => {
        Upload(profile_image, "main_image", 2, "#main_image_error", 500, 700);
    });

    function Upload(reference, input, size, error, minHeight, minWidth) {
        var fileUpload = document.getElementById(input);
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof(fileUpload.files) != "undefined") {
                const target = reference;
                if (target.files && target.files[0]) {
                    const maxAllowedSize = size * 1024 * 1024;
                    if (target.files[0].size > maxAllowedSize) {
                        jQuery(error).html('File size should be less than 1mb');
                        target.value = ''
                        return false;
                    } else if (target.files[0].size < maxAllowedSize) {
                        jQuery(error).html('');
                        var reader = new FileReader();
                        reader.readAsDataURL(fileUpload.files[0]);
                        reader.onload = function(e) {
                            var image = new Image();
                            image.src = e.target.result;
                            image.onload = function() {
                                var height = this.height;
                                var width = this.width;
                                if (height > minHeight && width > minWidth) {
                                    jQuery(error).html('');
                                    return;
                                } else if ((height < minHeight || width < minWidth)) {
                                    jQuery(error).html('Uploaded image has invalid Height and Width.');
                                    fileUpload.value = '';
                                    return;
                                }
                            };
                        }
                    }
                }
            } else if (typeof(fileUpload.files) == "undefined") {
                jQuery(error).html("This browser does not support HTML5.");
                fileUpload.value = '';
                return;
            }
        } else if (!regex.test(fileUpload.value.toLowerCase())) {
            jQuery(error).html("Please select a valid file.");
            fileUpload.value = '';
            return;
        }
    }
</script>

@endsection