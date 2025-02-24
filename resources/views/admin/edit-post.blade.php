@extends('admin.layout.nav-aside')

@section('title')
    Edit Post
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
                                <h3 class="card-title">Edit Post</h3>
                            </div>
                            <form action="{{ route('UpdatePost', $post_data['id']) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title">Post Title</label>
                                                <input type="text" value="{{ $post_data['title'] }}" name="post_title"
                                                    class="form-control" id="post_title" placeholder="Enter email">
                                            </div>
                                            @error('post_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Change Picture</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="post_pic" class="custom-file-input"
                                                            id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                @error('post_pic')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                            <label for="tags">Post Tags</label>
                                            <input type="text" class="form-control post-tag" name="tags" id="tags"
                                                value=@foreach ($post_data['tags'] as $tag)
                                                 {{ $tag }} @endforeach
                                                data-role="tagsinput" class="form-control" />
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="desc" id="summernote" name="descp">
                                                {{ Str::of($post_data['desc'])->toHtmlString() }}
                                            </textarea>
                                        </div>
                                        @error('desc')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Update Post</button>
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
