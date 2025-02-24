@extends('admin.layout.nav-aside')
@section('title')
    Post Categories
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"> <a href="javascript:void(0)" data-toggle="modal"
                                    data-target="#add-category-modal" class="btn btn-sm btn-warning">Add Category</a> </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="alert alert-success alert-dismissible fade d-none" role="alert" id="success_msg">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                    {{ session('post_status') }}
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" id="post_table_wrapper">
                                <table id="categories" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Category</th>
                                            <th>Total of Posts</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- add category modal  --}}
        <div class="modal fade" id="add-category-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" name="category" class="form-control" id="category"
                                placeholder="Enter Category">
                        </div>
                        <span class="text-danger" id="category_error"></span>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id='addCategory'>Add Category</button>
                    </div>
                </div>

            </div>
        </div>

        {{-- edit category modal  --}}
        <div class="modal fade" id="edit-category-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" name="category" class="form-control" id="category"
                                placeholder="Enter Category">
                        </div>
                        <span class="text-danger" id="category_error"></span>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id='editCategory'>Edit Category</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        <script>
            $(document).ready(function() {
                // datatable 
                $("#categories").DataTable();
                // Toast init 
                let Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                // when the page load completed 
                function load() {
                    $.ajax({
                        url: "{{ route('GetCategories') }}",
                        type: "GET",
                        success: function($data) {
                            $("#categories tbody").html('');
                            $("#categories tbody").html($data);
                        }
                    });
                }
                load();
                //code for add category via jquer ajax
                $(document).on('click', '#addCategory', function() {
                    let category = $('#category').val();
                    if (category.trim() != '') {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Content-Type': 'application/json'
                            },
                            url: "{{ route('AddCategory') }}",
                            type: "POST",
                            data: JSON.stringify({
                                category: category
                            }),
                            success: function(reponse) {
                                if (reponse.success == true) {
                                    $('#category').val('');
                                    $('#add-category-modal').modal('hide');
                                    load();
                                    Toast.fire({
                                        icon: 'success',
                                        title: reponse.message
                                    });
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: reponse.message
                                    });
                                }
                            }
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: "Internal Server error"
                        });
                    }
                });

                // update category model show
                let id = 0;
                $(document).on('click', '#editBtn', function() {
                    id = $(this).data('category')
                    let modal_ = $('#edit-category-modal');
                    let category = modal_.find('input#category');
                    $.ajax({
                        url: `{{ route('editCategory', ':id') }}`.replace(':id', id),
                        type: "GET",
                        success: function(category_name) {
                            if (category_name) {
                                $(category).val(category_name);
                                $(modal_).find('#addCategory').text('');
                                $(modal_).find('#addCategory').text('Update Category');
                                modal_.modal('show');
                            }
                        }
                    });
                });

                // store update ajax  
                $(document).on('click', "#editCategory", function() {
                    let modal_ = $('#edit-category-modal');
                    let category = $(modal_).find('input#category').val();
                    if (category != '') {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Content-Type': 'application/json'
                            },
                            url: `{{ route('storeCategory', ':id') }}`.replace(':id', id),
                            type: "POST",
                            data: JSON.stringify({
                                category: category
                            }),
                            success: function(reponse) {
                                if (reponse.success == true) {
                                    $(modal_).find('input#category').val();
                                    $(modal_).modal('hide');
                                    load();
                                    Toast.fire({
                                        icon: 'success',
                                        title: reponse.message
                                    });
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: reponse.message
                                    });
                                }
                            }
                        });
                    }
                });

                // delete category code 
                $(document).on('click', '#delBtn', function() {
                    Swal.fire({
                        title: "Do you want to Delete the Category?",
                        showCancelButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let id = $(this).data('category');
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content'),
                                },
                                url: `{{ route('deletCategory', ':id') }}`.replace(':id', id),
                                type: "POST",
                                success: function(reponse) {
                                    if (reponse.success == true) {
                                        load();
                                        load();
                                        Toast.fire({
                                            icon: 'success',
                                            title: reponse.message
                                        });
                                    } else {
                                        Toast.fire({
                                            icon: 'error',
                                            title: reponse.message
                                        });
                                    }
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
