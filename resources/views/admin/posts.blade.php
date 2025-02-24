@extends('admin.layout.nav-aside')

@section('title')
    Posts
@endsection

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Posts</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"> <a href="{{ route('AddPost') }}"
                                    class="btn btn-sm btn-warning">Add Post</a> </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @session('post_status')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        {{ session('post_status') }}
                    </div>
                @endsession
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" id="post_table_wrapper">
                                <table id="posts" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Author Image</th>
                                            <th>Author</th>
                                            <th>Post Title</th>
                                            <th>Cataegory</th>
                                            <th>Thumbnail</th>
                                            <th>Views</th>
                                            <th>Comments</th>
                                            <th colspan="3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($posts as $post)
                                            <tr>
                                                <td>{{ $post->id }}</td>
                                                <td>
                                                        <img src="{{ asset('storage/' . $post->user->picture) }}"
                                                            width="50px" height="50px" alt="">
                                                </td>
                                                <td>{{ $post->user->username }}</td>
                                                <td>{{ Str::substr($post->title, 0, 20) }}...</td>
                                                <td>{{ $post->category_id != 'null' ? $post->category->category_name : 'Post' }}
                                                </td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $post->picture) }}" width="50px"
                                                        height="50px" alt="">
                                                </td>
                                                <td>{{ $post->total_views }}</td>
                                                <td>{{ $post->total_comments }}</td>
                                                <td>
                                                    <a class="text-white" href="{{ route('ViewPost', $post->id) }}"><i
                                                            class="bi bi-eye-fill"></i></a>
                                                </td>
                                                <td>
                                                    @can('update', $post->user_id)
                                                        <a class="text-white" href={{ route('EditPost', $post->id) }}"><i
                                                                class="bi bi-pen-fill"></i></a>
                                                    @else
                                                        <span class="badge badge-danger">no-allowed</span>
                                                    @endcan
                                                </td>
                                                <td>
                                                    @can('delete', $post->user_id)
                                                        <a class="text-white" href="{{ route('DeletePost', $post->id) }}"><i
                                                                class="bi bi-trash-fill"></i></a>
                                                    @else
                                                        <span class="badge badge-danger">no-allowed</span>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $("#posts").DataTable();
        });
    </script>
@endpush
