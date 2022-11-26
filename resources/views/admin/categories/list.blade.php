@extends('layouts.admin.master')

@section('content')

<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories List</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Categories</h1>
            <p class="mb-0">List of categories in the system</p>
        </div>
        <div>
            <a id="createNewCategory" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                Create category
            </a>
        </div>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableCategory" class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">#</th>
                        <th class="border-0">Name</th>
                        <th class="border-0">Description</th>
                        <th class="border-0">Is Active</th>
                        <th class="border-0 rounded-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Item -->
                    <tr>
                        <td><a href="#" class="text-primary fw-bold">1</a> </td>
                        <td class="fw-bold d-flex align-items-center">
                            Direct
                        </td>
                        <td>
                            Direct
                        </td>
                        <td>
                            gfjh
                        </td>
                        <td>
                            vhjh
                        </td>
                    </tr>
                    <!-- End of Item -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal-->
<div class="modal fade" id="modal-category" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCategory" name="formCategory">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name"><br>
                        <label for="email" class="font-weight-bold">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea><br>
                        <label for="password" class="font-weight-bold">Status</label>
                        <select class="form-select" aria-label="Default select example">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <br>
                        <input type="hidden" name="category_id" id="category_id" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src = "http://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('document').ready(function () {
        // success alert
        function swal_success($msg) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: $msg,
                showConfirmButton: false,
                timer: 1000
            })
        }
        // error alert
        function swal_error() {
            Swal.fire({
                position: 'centered',
                icon: 'error',
                title: 'Something goes wrong !',
                showConfirmButton: true,
            })
        }
        // table serverside
        var table = $('#tableCategory')
        table.dataTable({
            pageLength: 15,
            processing: false,
            serverSide: true,
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
                // 'copy', 'excel', 'pdf'
            ],
            ajax: "{{ route('categories.index') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'is_active',
                    name: 'is_active'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        
        // csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // initialize btn add
        $('#createNewCategory').click(function () {
            $('#saveBtn').val("create user");
            $('#category_id').val('');
            $('#formCategory').trigger("reset");
            $(".modal-title").text("Add Category");
            $('#modal-category').modal('show');
        });
        // initialize btn edit
        $('body').on('click', '.editCategory', function () {
            var category_id = $(this).data('id');
            $(".modal-title").text("Edit User");
            $.get("{{route('categories.index')}}" + '/' + category_id + '/edit', function (data) {
                $('#saveBtn').val("edit-category");
                $('#modal-category').modal('show');
                $('#category_id').val(data.id);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#status').val(data.is_active);
            })
        });
        // initialize btn save
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data: $('#formCategory').serialize(),
                url: "{{ route('categories.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#formCategory').trigger("reset");
                    $('#modal-category').modal('hide');
                    swal_success(data.success);
                    table.fnDraw();

                },
                error: function (data) {
                    swal_error();
                    $('#saveBtn').html('Save Changes');
                }
            });

        });
        // initialize btn delete
        $('body').on('click', '.deleteCategory', function () {
            var category_id = $(this).data("id");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{route('categories.store')}}" + '/' + category_id,
                        success: function (data) {
                            swal_success(data.success);
                            table.fnDraw();
                        },
                        error: function (data) {
                            swal_error();
                        }
                    });
                }
            })
        });

        // statusing


    });

</script>
@endsection

