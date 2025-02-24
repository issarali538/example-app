@extends('admin.layout.nav-aside')

@section('title')
    Add Post
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Post</h1>
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Post</h3>
                            </div>
                            <form action="{{ route('SaveNewPost') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="post_title">Post Title</label>
                                                <input type="text" name="post_title" class="form-control" id="post_title"
                                                    placeholder="Post Title">
                                            </div>
                                            @error('post_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="post_pic">Post Picture</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="post_pic" class="custom-file-input"
                                                            id="exampleInputFile">
                                                        <label class="custom-file-label" for="post_pic">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('post_pic')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select class="form-control" name="category" id="category">
                                                   
                                                  </select>
                                            </div>
                                            @error('category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="exampleInputFile">Post Tags (Press enter when add tag)</label>
                                            <input class="form-control" name="tags" type="text" id="tag-input1">
                                        </div>
                                        @error('tags')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="post_desc">Description Details</label>
                                                <div>
                                                <textarea name="post_desc" id="post_desc">
                                                    
                                                </textarea>
                                                </div>
                                            </div>
                                            @error("post_desc")
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Save Post</button>
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
