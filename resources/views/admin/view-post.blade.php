@extends('admin.layout.nav-aside')

@section('title')
    View Post
@endsection

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>View Post</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">View Post</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content admin-view-post-page">
            <div class="container-fluid">
                @session('reply_status')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        {{ session('reply_status') }}
                    </div>
                @endsession
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- post details  --}}
                                        <div class="card card-widget widget-user">

                                            <div class="widget-user-header text-white custom-post-thumbnail"
                                                style="background: url({{ asset('storage/' . $post_data['picture']) }}) no-repeat center center;">
                                                <h3 class="widget-user-username text-right">{{ $post_data->title }}</h3>
                                                <h5 class="widget-user-desc text-right">{{ $post_data->user->username }}</h5>
                                            </div>
                                            <div class="widget-user-image">
                                                @if ($post_data->user->user_picture != 'profile')
                                                    <img class="img-circle"
                                                        src="{{ asset('storage/' . $post_data->user->picture) }}"
                                                        alt="User Avatar">
                                                @else
                                                    <img class="img-circle" src="{{ asset('images/pofile-avatar.jpeg') }}"
                                                        alt="User Avatar">
                                                @endif
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-sm-4 border-right">
                                                        <div class="description-block">
                                                            <h5 class="description-header">{{ $post_data->total_comments }}
                                                            </h5>
                                                            <span class="description-text">COMMENTS</span>
                                                        </div>

                                                    </div>

                                                    <div class="col-sm-4 border-right">
                                                        <div class="description-block">
                                                            <h5 class="description-header">{{ $post_data->total_views }}</h5>
                                                            <span class="description-text">VIEWS</span>
                                                        </div>

                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="description-block">
                                                            <h5 class="description-header">Role</h5>
                                                            <span
                                                                class="description-text">{{ $post_data->user->role == 0 ? 'Author' : 'Admin' }}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h4>Description</h4>
                                                                <div class="mb-3">
                                                                    {{ Str::of($post_data->desc)->toHtmlString() }}
                                                                </div>
                                                                <div>
                                                                    <h5 class="fw-bolder">Keywords:</h5>
                                                                    @foreach (json_decode($post_data->tags) as $tag)
                                                                        #{{ $tag }}
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card card-default">
                                                            <div class="card-header">
                                                                <h3 class="card-title">
                                                                    <i class="bi bi-chat-dots-fill"></i>
                                                                    Comments
                                                                </h3>
                                                            </div>
                                                            <div class="card-body">
                                                                @foreach ($post_data->comments as $comment)
                                                                    <div class="callout callout-danger"
                                                                        id="comment_{{ $comment->id }}"
                                                                        data-post="post_{{ $post_data->id }}">
                                                                        <h5>{{ $comment->subscriber->username }}</h5>
                                                                        <p>{{ $comment->comment }}</p>
                                                                        <p class="text-right">
                                                                            <button id="replyBtn"
                                                                                data-comment="{{ $comment->id }}"
                                                                                class="btn btn-sm btn-warning">Reply</button>
                                                                        </p>
                                                                        <form
                                                                            action="{{ route('commentReply')}}"
                                                                            id="reply_form_{{ $comment->id }}"
                                                                            method="POST" class="d-none">
                                                                            @csrf
                                                                            <div class="row">
                                                                                <div class="col-10">
                                                                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                                                    <input type="text" required 
                                                                                        class="form-control form-control-sm"
                                                                                        name="reply"
                                                                                        id="reply_{{ $comment->id }}"
                                                                                        placeholder="Reply...">
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <input type="submit" class="btn btn-sm btn-primary" value="Send">
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    @if (!empty($comment->replies))
                                                                        @foreach ($comment->replies as $reply)
                                                                        <div class="callout callout-white ml-4">
                                                                            <p>{{$reply->reply_text}}</p>
                                                                        </div>
                                                                        @endforeach
                                                                    @endif
                                                                    {{-- replies loop  --}}
                                                                         {{-- @if ($reply->id == $post_data["replies"][0]->reply_id)  --}}
                                                                            {{-- reply of reply  --}}
                                                                            {{-- @foreach ($post_data["replies"] as $item)
                                                                            <div class="callout callout-success ml-5">
                                                                                <h5>reply of reply</h5>
                                                                                <p>{{$reply->reply_text}}</p>
                                                                            </div>
                                                                            @endforeach 
                                                                        {{-- @endif --}}
                                                                @endforeach
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
                </div>
            </div>
        </section>

    </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $("#posts").DataTable();
        });

        // to send reply form  
        $('button#replyBtn').on('click', function() {
            let comment_id = $(this).data('comment');
            let comment = $("body").find(`form#reply_form_${comment_id}`);
            $(comment).removeClass('d-none');
        });
    </script>
@endpush
