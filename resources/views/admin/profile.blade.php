@extends('admin.layout.nav-aside')

@section('title')
    Profile
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @session('updated')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        {{ session('updated') }}
                    </div>
                @endsession
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-primary card-outline">
                                            <div class="card-body box-profile">
                                                <div class="text-center">
                                                    @if ($user_data['picture'] == 'profile')
                                                        <img id="profile_img" class="profile-user-img img-fluid img-circle"
                                                            data-index="0" src="{{ asset('images/pofile-avatar.jpeg') }}"
                                                            alt="User profile picture">
                                                    @else
                                                        <img class="profile-user-img img-fluid img-circle" id="profile_img"
                                                            data-index="0" src="{{ asset('storage/'.$user_data['picture']) }}"
                                                            alt="User profile picture">
                                                    @endif
                                                </div>
                                                <h3 class="profile-username text-center">{{ Auth::user()->username }}</h3>
                                                <p class="text-muted text-center">
                                                    {{ $user_data['role'] == '0' ? 'Author' : 'Admin' }}</p>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item pl-2 pr-2">
                                                        <b>Total Post</b> <span
                                                            class="float-right">{{ $user_data['posts_count'] }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card">
                                            <div class="card-header p-2">
                                                <ul class="nav nav-tabs" id="setting_tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="custom-tabs-one-home-tab"
                                                            data-toggle="pill" href="#basic-info" role="tab"
                                                            aria-controls="custom-tabs-one-home" aria-selected="true">Basic
                                                            Information</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-one-profile-tab"
                                                            data-toggle="pill" href="#change-passsword" role="tab"
                                                            aria-controls="custom-tabs-one-profile"
                                                            aria-selected="false">Change Password</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-one-profile-tab"
                                                            data-toggle="pill" href="#change_picture" role="tab"
                                                            aria-controls="custom-tabs-one-profile"
                                                            aria-selected="false">Change Picture</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="setting_tabs">
                                                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel"
                                                        aria-labelledby="custom-tabs-one-home-tab">
                                                        <form action="{{ route('UpdateProfile', $user_data['user_id']) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Username</label>
                                                                        <input type="text"
                                                                            value="{{ $user_data['username'] }}"
                                                                            name="username" class="form-control"
                                                                            id="username" placeholder="Enter Username">
                                                                    </div>
                                                                    @error('username')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="email">Email address</label>
                                                                        <input type="email"
                                                                            value="{{ $user_data['email'] }}" name="email"
                                                                            class="form-control" id="email"
                                                                            placeholder="Enter email">
                                                                    </div>
                                                                    @error('email')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="first_name">First Name</label>
                                                                        <input type="text"
                                                                            value="{{ $user_data['first_name'] }}"
                                                                            name="first_name" class="form-control"
                                                                            id="first_name" placeholder="Enter email">
                                                                    </div>
                                                                    @error('first_name')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="last_name">Last Name</label>
                                                                        <input type="text"
                                                                            value="{{ $user_data['last_name'] }}"
                                                                            name="last_name" class="form-control"
                                                                            id="last_name" placeholder="Enter Last Name">
                                                                    </div>
                                                                    @error('last_name')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="submit" class="btn btn-primary"
                                                                        value="Save Update">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade" id="change-passsword" role="tabpanel"
                                                        aria-labelledby="custom-tabs-one-profile-tab">
                                                        <form
                                                            action="{{ route('ChangePassword', $user_data['user_id']) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="existing_password">Existing
                                                                            Password</label>
                                                                        <input type="password" name="existing_password"
                                                                            id="existing_password" class="form-control"
                                                                            placeholder="Enter Password">
                                                                    </div>
                                                                    @error('existing_password')
                                                                        <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">New
                                                                            Password</label>
                                                                        <input type="password" name="new_password"
                                                                            class="form-control" id="new_password"
                                                                            placeholder="Enter Password">
                                                                    </div>
                                                                    @error('new_password')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="confirmed_password">Confirmed 
                                                                            Password</label>
                                                                        <input type="password" name="confirmed_password"
                                                                            class="form-control" id="confirmed_password"
                                                                            placeholder="Enter Password">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="submit" class="btn btn-primary"
                                                                        value="Change Password">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade" id="change_picture" role="tabpanel"
                                                        aria-labelledby="custom-tabs-one-profile-tab">
                                                        <form action="{{ route('ChangePicture', $user_data['user_id']) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">New
                                                                            Picture</label>
                                                                        <input type="file" name="picture"
                                                                            class="form-control" id="picture"
                                                                            placeholder="Enter Password">
                                                                    </div>
                                                                    @error('picture')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12">
                                                                    <input class="btn btn-primary" type="submit"
                                                                        value="Change Picture">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    </div>
@endsection

@push('js')
    <script>
        var m, f, v;
        f = document.getElementById("picture");
        v = document.getElementById("profile_img");
        f.addEventListener("change", function(e) {
            m = new FileReader();
            m.onload = function(e) {
                v.src = e.target.result;
            };
            m.readAsDataURL(this.files[0]);
        });
    </script>
@endpush
