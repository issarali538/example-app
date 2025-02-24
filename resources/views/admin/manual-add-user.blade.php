@extends('admin.layout.nav-aside')

@section('title')
    Add User
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add User</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            @session('save_status')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        {{ session('save_status') }}
                    </div>
                @endsession
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add User</h3>
                            </div>
                            <div class="card-body">
                                <form id="add-user-form" action="{{ route('addUser') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="fullname">Full Name</label>
                                            <input type="text" name="fullname" class="form-control" id="fullname"
                                                placeholder="Enter Full Name">
                                                @error('fullname')
                                                    <span class="text-warning">{{$message}}</span>
                                                @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" class="form-control" id="email"
                                                placeholder="Enter Email">
                                                @error('email')
                                                    <span class="text-warning">{{$message}}</span>
                                                @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="username">Userrnme</label>
                                            <input type="text" name="username" class="form-control" id="username"
                                                placeholder="Enter Username">
                                            @error('username')
                                                <span class="text-warning">{{$message}}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password">Password</label>
                                            <input type="text" name="password" class="form-control" id="password"
                                                placeholder="Enter Password">
                                            @error('password')
                                                <span class="text-warning">{{$message}}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <label for="picture">User image</label>
                                            <input type="file" name="picture" class="form-control form-control-file"
                                                id="picture">
                                            @error('picture')
                                                <span class="text-warning">{{$message}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right mt-2">
                                        <input type="submit" class="btn btn-primary" value="Save User" id='save-user' />
                                    </div>
                                </form>
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
    <script src="{{ asset('js/tag.js') }}"></script>
    <script>
        $(function() {
            // Summernote
            $('#post_desc').summernote({
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

            // code for category
            $.ajax({
                url: "{{ route('GetAllCategories') }}",
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $("#category").html('')
                    $("#category").html(response);
                }
            });
        });
    </script>
@endpush
