@extends('admin.layout.nav-aside')

@section('title')
    Users
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="{{ route('manualAddUser') }}"
                                    class="btn btn-sm btn-warning">Add User</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            @session('delete_status')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        {{ session('delete_status') }}
                    </div>
                @endsession
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Picture</th>
                                            <th>Role</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->fullname }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td><img width="50px" height="50px" src="{{ asset('storage/'.$user->picture) }}" alt=""></td>
                                                <td> <span class="badge badge-warning">Author</span> </td>
                                                <td>
                                                    <a href="{{route('editUser',$user->id)}}" class='btn btn-sm btn-primary' >
                                                        <i class='bi bi-pencil-fill'></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{route('deleteUser',$user->id)}}" class='btn btn-sm btn-primary'>
                                                        <i class='bi bi-trash-fill'></i>
                                                    </a>
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
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush
