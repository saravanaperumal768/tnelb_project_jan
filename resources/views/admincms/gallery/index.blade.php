@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">
<style>
    .dashboard h4 {
        font-weight: 800;
        color: #000 !important;
    }

    .widget.box .widget-header {
        background: rgb(255, 255, 255);
        padding: 0px 8px 0px;

    }

    .box-shadow .widget-header h4 {

        color: #000 !important;
    }

    .info-box-2 {
        background: #ffffff;
        padding: 50px 40px;
        text-align: center;
        position: relative;
        border-radius: 25px;
        /* margin: 30px; */
        margin-top: 10px;
        transition: 0.3s;
        min-width: 100%;

    }

    .table:not(.dataTable) tbody tr td svg {
        width: 30px;
        height: 31px;
        vertical-align: text-top;
        color: #4361ee;
        stroke-width: 1.5;
    }

    table th {
        text-align: center;
    }

    table>tbody>tr>td {
        border: 1px solid #00000021 !important;
    }

    .layout-spacing {
        padding-bottom: 6px;
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">
            <!--  BEGIN BREADCRUMBS  -->
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Analytics">
                    <header class="header navbar navbar-expand-sm">
                        <a href="#" class="btn-toggle sidebarCollapse" data-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </a>
                        <div class="d-flex breadcrumb-content">
                            <div class="page-header">

                                <div class="page-title">
                                </div>

                                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"></a></li>

                                    </ol>
                                </nav>

                            </div>
                        </div>

                    </header>
                </div>
            </div>
            <!--  END BREADCRUMBS  -->



            <div class="row layout-top-spacing dashboard">
                    <nav class="breadcrumb-style-five breadcrumbs_top  mb-2" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg><span class="inner-text">Dashboard </span></a></li>
                        <li class="breadcrumb-item"><a href="#">Homepage</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Homepage Gallery Management Console</li>
                    </ol>
                </nav>
                     <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                                    <h4 class="text-dark card-title">Homepage Gallery Management Console </h4>
                                </div>
                                   <div class="col-md-3 text-end">
                            <button type="button" class="btn btn-info mb-2 me-4" data-bs-toggle="modal" data-bs-target="#inputFormModal_category">
                                <i class="fa fa-plus"></i>&nbsp; Add Gallery Category 
                            </button>
                        </div>
                         <div class="col-md-3 text-end">
                            <button type="button" class="btn btn-info mb-2 me-4" data-bs-toggle="modal" data-bs-target="#inputFormModal">
                                <i class="fa fa-plus"></i>&nbsp; Add New Image
                            </button>
                        </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="  ">
                  

                <!-- ---------------category gallery--------------------------- -->
                    <div class="modal fade inputForm-modal" id="inputFormModal_category" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">

                                <div class="modal-header" id="inputFormModal_category">
                                    <h5 class="modal-title">Add New Gallery Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg></button>
                                </div>

                                <div class="modal-body">
                                    <form class="mt-0" id="addcategory_name" enctype="multipart/form-data">
                                     <div class="form-group">
                                            <label>Gallery Category</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="catname" id="catname" placeholder="Category Name">
                                            </div>
                                            <small id="catnameError" class="text-danger"></small>

                                        </div>


                                       

                                       

                                        <!-- <button type="submit" class="btn btn-primary">Upload</button> -->



                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect">Add</button>

                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- -------------------------------- -->

                    <!-- Modal -->
                    <div class="modal fade inputForm-modal" id="inputFormModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-centered" role="document">
                            <div class="modal-content">

                                <div class="modal-header" id="inputFormModalLabel">
                                    <h5 class="modal-title">Add New Gallery Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg></button>
                                </div>

                                <div class="modal-body">
                                    <form class="mt-0" id="addimage" enctype="multipart/form-data">
                                           <div class="form-group">
                                            <label> Image Category</label>
                                            <div class="input-group mb-3">
                                                 <select class="form-select" name="category_id" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->catname }}</option>
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label> Image Title</label>
                                            <div class="input-group mb-3">
                                                
                                                <input type="text" class="form-control" name="imagetitle" placeholder="Image Title">
                                                
                                            </div>
                                        </div>

                                        <input type="hidden" name="updatedby" value="{{ Auth::user()->username }}">

                                        <div class="form-group">
                                            <label>Upload Image</label>
                                            <div class="input-group mb-3">
                                             
                                                <!-- Custom Button to Open Media Modal -->
                                                        <button type="button" class="btn btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="#mediaLibraryModal">
                                                            Choose from Library
                                                        </button>
                                                        

                                                        <!-- Hidden input to store selected image path -->
                                                        <input type="hidden" name="gallery_image" id="galleryImagePath">

                                                        <div id="galleryImagePreview" class="mt-2"></div>

                                                        <small class="text-danger" id="galleryImageError"></small>
                                                      
                                                        <p class="text-danger">(File Formats: jpg, png, Max: 250KB)</p>
                                                        <!-- <p class="text-danger">(Height 1585px X 370px)</p> -->
                                            </div>
                                        </div>

                                        <!-- <button type="submit" class="btn btn-primary">Upload</button> -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Add</button>
                                </div>


                                </div>
                               
                                </form>
                            </div>
                        </div>
                    </div>



                     <div class="modal fade" id="mediaLibraryModal" tabindex="-1" aria-labelledby="mediaLibraryLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Media Library</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row" id="mediaImageList">
                                            <!-- Loop your media images here -->
                                            @foreach ($media as $image)
                                            <div class="col-md-2 mb-3">
                                                <div class="card">
                                                    <img src="{{ asset( $image->filepath_img_pdf) }}" class="card-img-top media-image" data-id="{{ $image->id }}" data-path="{{ asset($image->filepath_img_pdf) }}">
                                                    <div class="card-body text-center">
                                                        <input type="radio" name="mediaSelect" value="{{$image->id }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="selectImageBtngallery">Add Selected</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="row mt-2">


                    <div class="row " id="gallery-row">
                        @foreach($gallery as $categoryId => $images)
                        @php
                            $catName = $images->first()->category->catname ?? 'Uncategorized';
                        @endphp

                        <div class="widget box-shadow mb-2">
                            <h5 class="text-center">{{ $catName }}</h5>
                        </div>

      <div class="row mt-2" id="category-row-{{ $categoryId }}">
            @foreach($images as $imagegallery)
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
                    <a class="card" href="#">
                        @if($imagegallery->media && $imagegallery->media->filepath_img_pdf)
                            <img src="{{ asset($imagegallery->media->filepath_img_pdf) }}"
                                 alt="{{ $imagegallery->imagetitle }}"
                                 class="slider-image text-center img-thumbnail1" />
                        @else
                            <p>No Photos</p>
                        @endif
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12 text-center mb-4">
                                    <b>{{ $imagegallery->imagetitle ?? 'Untitled' }}</b>
                                </div>
                                <div class="col-6 text-center">
                                    <button class="btn btn-info edit-gallery-btn"
                                        data-id="{{ $imagegallery->id }}"
                                        data-image="{{ $imagegallery->media ? asset($imagegallery->media->filepath_img_pdf) : '' }}"
                                        data-title="{{ $imagegallery->imagetitle }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#inputFormModaleditgallery">
                                        Edit
                                    </button>
                                </div>
                                <div class="col-6 text-center">
                                    <button class="btn btn-danger delete-gallery"
                                        data-id="{{ $imagegallery->id }}">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach
                    </div>


                </div>





            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade inputForm-modal" id="inputFormModaleditgallery" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header" id="inputFormModalLabel">
                        <h5 class="modal-title">Edit Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg></button>
                    </div>
                    <div class="modal-body">
                        <form id="editGalleryForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="editImageId">

                            <div class="form-group mb-3 text-center">
                                <img id="editImagePreview" src="" alt="Preview" class="img-fluid mb-3" style="max-height: 200px;">
                            </div>

                            <div class="form-group mb-3">
                                <label for="editImageInput">Choose Image</label>
                                <input type="file" class="form-control" name="image" id="editImageInput">
                            </div>

                            <div class="form-group mb-3">
                                <label for="editImageTitle">Image Title</label>
                                <input type="text" class="form-control" name="imagetitle" id="editImageTitle" placeholder="Enter image title">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>







        @include('admincms.include.footer');
<script>
$(function () {
    $('#addcategory_name').on('submit', function (e) {
        e.preventDefault();

        // clear previous errors
        $('#catname_error').text('');

        $.ajax({
            url: "{{ route('admin.gallerycat.catnameinsert') }}",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
          success: function (response) {
                if (response.success) {
                    $('#addcategory_name')[0].reset();
                    $('#inputFormModal_category').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            },

         error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                if (errors.catname) {
                    $('#catnameError').text(errors.catname);
                }
            }
        }
        });
    });
});


  $('#selectImageBtn').on('click', function () {
        // Get selected radio button (image ID)
        var selectedImage = $('input[name="mediaSelect"]:checked');

        if (selectedImage.length > 0) {
            // Get path from selected image
            var imagePath = selectedImage.closest('.card').find('.media-image').data('path');

            // Set hidden input with path
            $('#galleryImagePath').val(imagePath);

            // Show preview in Add Modal
            $('#galleryImagePreview').html('<img src="' + imagePath + '" class="img-fluid rounded" style="max-height:150px;">');

            // Close Media Library modal
            $('#mediaLibraryModal').modal('hide');
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No Image Selected',
                text: 'Please select an image before adding.',
                confirmButtonText: 'OK'
            });
        }
    });


    
$('#selectImageBtngallery').on('click', function () {
    // alert('111');
    var selectedRadio = $('input[name="mediaSelect"]:checked');

    if (selectedRadio.length > 0) {
        var imageId = selectedRadio.val();
        var imagePath = selectedRadio.closest('.card').find('img').data('path');

        // Store only the ID in the hidden input
        $('#galleryImagePath').val(imageId);

        // Show preview using full image path
        $('#galleryImagePreview').html('<img src="' + imagePath + '" class="img-fluid rounded" style="max-height:250px;">');

        // Close media modal
        $('#mediaLibraryModal').modal('hide');

        // Reopen add modal after media modal is closed
        $('#mediaLibraryModal').on('hidden.bs.modal', function () {
            $('#inputFormModal').modal('show');
            $(this).off('hidden.bs.modal'); // Remove listener to avoid duplicate openings
        });

    } else {
        alert("Please select an image.");
    }


   
});

 $('#addimage').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    $.ajax({
        url: "{{ route('admin.galleryinsertimage') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
      success: function (response) {
    if (response.success) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: response.message,
            showConfirmButton: false,
            timer: 1500
        });

        $('#addimage')[0].reset();
        $('#galleryImagePreview').html('');
        $('#inputFormModal').modal('hide');

        let imgPath = response.data.media 
                      ? "{{ asset('') }}" + response.data.media.filepath_img_pdf 
                      : '';

        let newCard = `
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
            <a class="card" href="#">
                ${imgPath 
                    ? `<img src="${imgPath}" alt="${response.data.imagetitle}" class="slider-image text-center img-thumbnail1" />` 
                    : `<p>No Photos</p>`}
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-center mb-3">
                            <b>${response.data.imagetitle ?? 'Untitled'}</b>
                        </div>
                        <div class="col-6 text-center">
                            <button class="btn btn-info edit-gallery-btn"
                                data-id="${response.data.id}"
                                data-image="${imgPath}"
                                data-title="${response.data.imagetitle}"
                                data-bs-toggle="modal"
                                data-bs-target="#inputFormModaleditgallery">
                                Edit
                            </button>
                        </div>
                        <div class="col-6 text-center">
                            <button class="btn btn-danger delete-gallery" data-id="${response.data.id}">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </a>
        </div>`;

        // ✅ Append inside the correct category row
        let targetRow = "#category-row-" + response.data.category_id;
        $(targetRow).prepend(newCard);
    }
},


        error: function (xhr) {
            let errors = xhr.responseJSON.errors;
            if (errors.gallery_image) {
                $('#galleryImageError').text(errors.gallery_image[0]);
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please check the inputs and try again.'
            });
        }
    });
});


</script>
