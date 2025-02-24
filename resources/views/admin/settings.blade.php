@extends('admin.layout.nav-aside')

@section('title')
    Setting
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $setting[0]->panel_name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @session('settings_update')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        {{ session('settings_update') }}
                    </div>
                @endsession
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('saveSettings')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card-body box-profile">
                                                <div class="card card-primary card-outline">
                                                    <div class="text-center">
                                                        <img class="profile-user-img img-fluid img-circle"
                                                            src="{{ asset('storage/' . $setting[0]->logo) }}"
                                                            alt="logo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="panel_name">Panel Name</label>
                                                        <input type="text" value="{{$setting[0]->panel_name}}" name="panel_name" class="form-control"
                                                            id="panel_name" placeholder="Panel Name">
                                                            <span class="text-warning">
                                                                @error('panel_name')
                                                                    {{$message}}
                                                                @enderror
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="logo">Panel Logo</label>
                                                        <input type="file" name="logo" class="form-control"
                                                            id="logo">
                                                    </div>
                                                    <div class="text-right mt-2">
                                                        <input class="btn btn-primary" type="submit" value="Save updates">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
