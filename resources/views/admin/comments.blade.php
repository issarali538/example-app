@extends('admin.layout.nav-aside')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title')
    Comments
@endsection

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Comments</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Comments</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @session('comment_status')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        {{ session('comment_status') }}
                    </div>
                @endsession
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="comments_table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Post Title</th>
                                            <th>Subscriber</th>
                                            <th>Comment</th>
                                            <th>Status</th>
                                            <th>Approve</th>
                                            <th>Add On</th>
                                            <th colspan="2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd($comments->post)}} --}}
                                        @foreach ($comments as $comment)
                                            @if ($comment->post)
                                                <tr>
                                                    <td> {{ $comment->id }} </td>
                                                    {{-- <td>@php var_dump ($comment->post->title); @endphp</td> --}}
                                                    <td>{{ Str::substr($comment->post->title, 0, 10) }}...</td>
                                                    <td>{{ $comment->subscriber->username }}</td>
                                                    <td>{{ $comment->comment }}</td>
                                                    <td>
                                                        @if ($comment->comment_status != 1)
                                                            <span
                                                                class="badge badge-warning comment_status_{{ $comment->id }}">Pending</span>
                                                        @else
                                                            <span
                                                                class="badge badge-success comment_status_{{ $comment->id }}">Approved</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" name = "comment_status"
                                                                data-comment={{ $comment->id }}
                                                                class="custom-control-input"
                                                                {{ $comment->comment_status == 1 ? 'checked' : '' }}
                                                                id="comment_status{{ $comment->id }}">
                                                            <label class="custom-control-label"
                                                                for="comment_status{{ $comment->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ date_format($comment->created_at, 'Y/m/d') }}</td>
                                                    <td>
                                                        <button id="delCommentBtn" data-comment="{{ $comment->id }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
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
    </div>

    @push('js')
        <script>
            $(function() {
                // code for change the status 
                let approve_comment = $("input[name='comment_status']");
                $(approve_comment).on('change', function() {
                    let id = $(this).attr("data-comment");
                    let status = $(this).is(":checked") ? 1 : 0;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                        },
                        url: `{{ route('approveComment', ':id') }}`.replace(':id', id),
                        type: "POST",
                        data: JSON.stringify({
                            comment_status: status
                        }),
                        success: function(response) {
                            if (response.success == true) {
                                // badge code 
                                let badge = $(`.badge.comment_status_${id}`)
                                if (response.request_status == true) {
                                    $(badge).removeClass('badge-success');
                                    $(badge).addClass('badge-warning');
                                    $(badge).html('Pending');
                                } else {
                                    $(badge).removeClass('badge-warning');
                                    $(badge).addClass('badge-success');
                                    $(badge).html('Approved');
                                }
                                // toasts code 
                                Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                }).fire({
                                    icon: "success",
                                    title: "Status changed successfully"
                                });
                            }
                        }
                    });
                });

                // code for deleting comment
                let delCommentBtn = $('button#delCommentBtn');
                $(delCommentBtn).on('click', function() {
                    let id = $(this).data('comment');
                    if (id != undefined) {
                        $.ajax({
                            url: `{{ route('deleteComment', ':id') }}`.replace(':id', id),
                            type: "GET",
                            success: function(response) {
                                if (response.success == true) {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
