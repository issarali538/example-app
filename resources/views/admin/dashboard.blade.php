@extends('admin.layout.nav-aside')

@section('title')
    Dashboard
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @session('loginSuccessfully')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        {{ session('loginSuccessfully') }}
                    </div>
                @endsession
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v2</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i
                                    class="bi bi-file-earmark-break-fill"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Posts</span>
                                <span class="info-box-number">
                                    {{ $summary['total_post'] }}
                                    {{-- <small>%</small> --}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="bi bi-chat-dots-fill"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Comments</span>
                                <span class="info-box-number">
                                    {{ $summary['total_comments'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="bi bi-eye-fill"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Views</span>
                                <span class="info-box-number">
                                    {{ $summary['total_views'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Subscriber</span>
                                <span class="info-box-number">
                                    {{ $summary['total_subscribers'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Subscriber Acitvity with your posts</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-center">
                                            <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                                        </p>
                                        <div class="chart">
                                            <canvas id="posts-activity" height="180" style="height: 180px;"></canvas>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <p class="text-center">
                                            <strong>Goal Completion</strong>
                                        </p>
                                        <div class="progress-group">
                                            Add Products to Cart
                                            <span class="float-right"><b>160</b>/200</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-primary" style="width: 80%"></div>
                                            </div>
                                        </div>

                                        <div class="progress-group">
                                            Complete Purchase
                                            <span class="float-right"><b>310</b>/400</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-danger" style="width: 75%"></div>
                                            </div>
                                        </div>

                                        <div class="progress-group">
                                            <span class="progress-text">Visit Premium Page</span>
                                            <span class="float-right"><b>480</b>/800</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success" style="width: 60%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            Send Inquiries
                                            <span class="float-right"><b>250</b>/500</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ALL THE USERS(authors) OF THE PANEL  --}}
                @if (Auth::user()->role == 1)
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Users</h3>
                                    <div class="card-tools">
                                        <a href="{{ route('manualAddUser') }}"
                                            class="btn btn-sm btn-secondary float-right">Add User</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="dataTable-ajax">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Picture</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                @endif
        </section>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // code populating
            function load() {
                $('#dataTable-ajax').DataTable({
                    ajax: {
                        url: '{{ route('getAllUsers') }}',
                    },
                    "columns": [{
                            data: "fullname"
                        },
                        {
                            data: "username"
                        },
                        {
                            data: "picture"
                        },
                        {
                            data: "role"
                        },
                    ]
                });
            }
            load();
        });
    </script>
@endpush
