@extends('layouts.admin.master')

@section('content')

<div class="py-4">
    
    <div class="row">
      <div class="col-12 col-xl-8">
          <div class="card card-body border-0 shadow mb-4">
              <h2 class="h5 mb-4">Add Book Details</h2>
              <form id="formProductEdit">
                  <div class="row">
                      <div class="col-md-6 mb-3">
                          <div>
                              <label for="first_name">Name</label>
                              <input class="form-control" value="{{ $product->name }}" name="name" id="first_name" type="text" placeholder="Enter book name" required>
                          </div>
                      </div>
                      <div class="col-md-6 mb-3">
                          <div>
                              <label for="last_name">Author Name</label>
                              <input class="form-control" value="{{ $product->author }}" name="author" id="last_name" type="text" placeholder="Enter author name" required>
                          </div>
                      </div>
											<div class="col-md-6 mb-3">
                          <div>
                              <label for="last_name">Publisher Name</label>
                              <input class="form-control" value="{{ $product->publisher }}"  name="publisher" id="last_name" type="text" placeholder="Enter publisher name" required>
                          </div>
                      </div>
											<div class="col-md-6 mb-3">
											    <label for="gender">Status</label>
                          <select class="form-select mb-0" value="{{ $product->status }}" name="status" id="gender" aria-label="Gender select example">
                              <option value="1" selected>Active</option>
                              <option value="0">Inactive</option>
                              
                          </select>
                    </div>
                  </div>
                  <div class="row align-items-center">
                      <div class="col-md-6 mb-3">
                          <label for="birthday">Release Date</label>
                          <div class="input-group">
                              <span class="input-group-text">
                                  <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                              </span>
                              <input data-datepicker="" value="{{ $product->release }}" name="release" class="form-control" id="birthday" type="text" placeholder="dd/mm/yyyy" required>                                               
                            </div>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="gender">Binding</label>
                          <select name="binding" value="{{ $product->binding }}" class="form-select mb-0" id="gender" aria-label="Gender select example">
                              <option value="paperback" selected>PaperBack</option>
                              <option value="hardcover">HardCover</option>
                              <option value="hardback">HardBack</option>
                          </select>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6 mb-3">
											    <label for="gender">Language</label>
                          <select name="language" value="{{ $product->language }}" class="form-select mb-0" id="gender" aria-label="Gender select example">
                              <option value="english" selected>English</option>
                              <option value="tamil">Tamil</option>
                              <option value="hindi">Hindi</option>
                          </select>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="birthday">Price</label>
                          <div class="input-group">
                              <span class="input-group-text">
                                  <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                              </span>
                              <input name="price" value="{{ $product->price }}" class="form-control" id="birthday" type="text" placeholder="Enter price" required>                                               
                            </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                        @if($product->image == '') 
                        <img width="300" height="300" id="product_img" src="{{URL::asset('images/')}}" alt="">
                        <input type='file' name="image" id="image" />
                        @else 
                        <img width="300" height="300" id="product_img" src="{{URL::asset($product->image)}}" alt="">
                        <input type='file' name="image" id="image" />
                        @endif
                        <!-- <img id="product_image" class="mt-2" src="" alt="product image" height="120" width="140" /> -->
                        
                    </div>
                  </div>
                  <div class="mt-3">
                      <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                      <button id="editBtn" class="btn btn-gray-800 mt-2 animate-up-2" >Edit</button>
                  </div>
              </form>
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
        // var productImg = 
        // $("#product_img").attr('src', image);

        $("#image").change(function(e) {
            console.log(e.target.files);
            const imageFiles = event.target.files;
            /**
             * Count the number of files selected.
             */
            const imageFilesLength = imageFiles.length;
            /**
             * If at least one image is selected, then proceed to display the preview.
             */
            if (imageFilesLength > 0) {
                /**
                 * Get the image path.
                 */
                const imageSrc = URL.createObjectURL(imageFiles[0]);
                /**
                 * Select the image preview element.
                 */
                const imagePreviewElement = document.querySelector("#product_img");
                /**
                 * Assign the path to the image preview element.
                 */
                imagePreviewElement.src = imageSrc;
                /**
                 * Show the element by changing the display value to "block".
                 */
                //imagePreviewElement.style.display = "block";
            }
        })
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
        var table = $('#tableProduct')
        table.DataTable({
            pageLength: 15,
            processing: false,
            serverSide: true,
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
                // 'copy', 'excel', 'pdf'
            ],
            ajax: "{{ route('products.index') }}",
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
                    data: 'authors',
                    name: 'authors'
                },
                {
                    data: 'publisher',
                    name: 'publisher'
                },
                {
                    data: 'status',
                    name: 'status'
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
        $('#editBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save');
            var formData = new FormData(document.getElementById("formProductEdit"));
            $.ajax({
                data: formData,
                url: "{{ route('products.store') }}",
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (data) {
                    //$('#formProduct').trigger("reset");
                    swal_success(data.success);

                },
                error: function (data) {
                    swal_error();
                }
            });

        });
        
    });

</script>
@endsection

