@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 btn-reveal-trigger">
                    <div class="card-header position-relative min-vh-25 mb-8">
                        <div class="cover-image">
                            <div class="bg-holder rounded-3 rounded-bottom-0" style="background-image:url(@if(Auth::user()->bpicture == null)../../assets/img/generic/5.jpg @else storage/{{Auth::user()->bpicture}}@endif);">

                            </div>
                            <!--/.bg-holder-->
                            <form action="/profile/bpicture" method="post" enctype="multipart/form-data">
                                @csrf
                                @method("put")
                                <input name="picture" id="upload-cover-image" class="d-none" onchange="form.submit()" id="profile-image" type="file" />
                                <label class="cover-image-file-input" for="upload-cover-image"><span class="fas fa-camera me-2"></span><span>Change cover photo</span></label>
                            </form>

                        </div>
                        <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                            <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img src="@if(Auth::user()->picture == null)../../assets/img/team/avatar.png @else storage/{{Auth::user()->picture}}@endif" width="200" alt="" data-dz-thumbnail="data-dz-thumbnail" />
                                <form action="/profile/picture" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method("put")
                                    <input name="picture" class="d-none" onchange="form.submit()" id="profile-image" type="file" />
                                    <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image"><span class="bg-holder overlay overlay-0"></span><span class="z-index-1 text-white text-center fs--1"><span class="fas fa-camera"></span><span class="d-block">Update</span></span></label>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-8 pe-lg-2">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Profile Settings</h5>
                    </div>
                    <div class="card-body bg-light">
                        <form class="row g-3" method="post" action="{{url('/profile/modifyInfo')}}">
                            @csrf
                            @method('put')
                            <div class="col-lg-6">
                                <label class="form-label" for="first-name">First Name</label>
                                <input required name="first_name" class="form-control" id="first-name" type="text" value="{{Auth::user()->name}}" />
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="last-name">Last Name</label>
                                <input required name="last_name" class="form-control" id="last-name" type="text" value="{{Auth::user()->last_name}}" />
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="email1">Email</label>
                                <input required name="email" class="form-control" id="email1" type="email" value="{{Auth::user()->email}}" />
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">Update </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 ps-lg-2">
                <div class="sticky-sidebar">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Change Password</h5>
                        </div>
                        <div class="card-body bg-light">
                            <form action="/changePassword" method="post">
                                @csrf
                                @method('put')
                                <div class="mb-3">
                                    <label class="form-label" for="old-password">Old Password</label>
                                    <input class="form-control @error('old_password') is-invalid @enderror" name="old_password" id="old-password" type="password" />
                                    @error('old_password')<label class="invalid-feedback"> {{$message}}  </label>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="new-password">New Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" name="password" id="new-password" type="password" />
                                    @error('password')<label class="invalid-feedback"> {{$message}}  </label>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="confirm-password">Confirm Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" name="password_confirmation" id="confirm-password" type="password" />

                                </div>
                                <button class="btn btn-primary d-block w-100" type="submit">Update Password </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function changePicture(picture){
            console.log(picture)
            {{--let formData = new FormData();--}}
            {{--formData.append('picture', JSON.stringify(picture));--}}
            {{--fetch('{{url("profile/picture")}}/', {--}}
            {{--    method: 'PUT',--}}
            {{--    credentials: "same-origin",--}}
            {{--    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}--}}
            {{--    body:formData--}}
            {{--}).then(function(response){--}}
            {{--    console.log(response)--}}
            {{--})--}}
            {{--    .then(function(json){--}}
            {{--        location.reload()--}}

            {{--    })--}}
            {{--    .catch(function(error){--}}
            {{--        console.log(error)--}}
            {{--    });--}}
        }

    </script>
@endsection



