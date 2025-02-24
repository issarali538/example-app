@extends('admin.layout.nav-aside')

@section('title')
    Edit User
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Post</h1>
                    </div>
                    {{-- <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="" class="btn btn-sm btn-warning">Add User</a>
                            </li>
                        </ol>
                    </div> --}}
                </div>
            </div>
        </section>

        <section class="content">
            @session('user_status')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        {{ session('user_status') }}
                    </div>
                @endsession
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit User</h3>
                            </div>
                            <form action="{{ route('saveUpdateUser', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="fullname">Full Name</label>
                                            <input type="text" value="{{$user->fullname}}" name="fullname" class="form-control" id="fullname"
                                                placeholder="Enter Full Name">
                                                @error('fullname')
                                                    <span class="text-warning">{{$message}}</span>
                                                @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email">Email</label>
                                            <input type="text" value="{{$user->email}}" name="email" class="form-control" id="email"
                                                placeholder="Enter Email">
                                                @error('email')
                                                    <span class="text-warning">{{$message}}</span>
                                                @endif
                                        </div>
                                        <div class="col-md-12">
                                            <label for="username">Userrnme</label>
                                            <input type="text" value="{{$user->username}}" name="username" class="form-control" id="username"
                                                placeholder="Enter Username">
                                            @error('username')
                                                <span class="text-warning">{{$message}}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="my-2">
                                                <img width="100px" height="100px" src="{{asset("storage/".$user->picture)}}" alt="{{$user->name."-picture"}}">
                                            </div>
                                            <label for="picture">User image</label>
                                            <input type="file" name="picture" class="form-control form-control-file"
                                                id="picture">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/tag-bootstrap.js') }}"></script>
    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote({
                placeholder: 'Write Details Article...',
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear', 'italic']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            $('#tags').tagsinput({
                tagClass: 'post-tag'
            });

            // code for category
            $.ajax({
                url : "{{route('GetAllCategories')}}",
                type : "GET", 
                success: function(response){
                    console.log(response);
                    $("#category").html('')
                    $("#category").html(response);
                }
            });

        });
    </script>
@endpush
