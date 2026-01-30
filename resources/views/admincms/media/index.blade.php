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
                                        <li class="breadcrumb-item"><a href="#">Content Management System for TNELB</a></li>

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
                        <li class="breadcrumb-item active" aria-current="page">Portaladmin Media Management</li>
                    </ol>
                </nav>
                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header textblack">
                            <div class="row ">
                                <div class="col-xl-6 col-md-6 col-sm-6 col-12">
                                    <h4 class="text-dark">Portaladmin Media Management Console </h4>
                                </div>

                                <div class="col-md-6 text-end">
                                    <button type="button" class="btn btn-info mb-2 me-4" data-bs-toggle="modal" data-bs-target="#addmediaitems">
                                        <i class="fa fa-plus"></i>&nbsp; Add New Media Image / PDF
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="  ">




                    <!-- Modal -->
                    <div class="modal fade inputForm-modal" id="addmediaitems" tabindex="-1" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ADD New Media Image / PDF</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg></button>
                                </div>
                                <div class="modal-body">
                                    <form id="insertmedia" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-8 offset-md-2">
                                                <div class="form-group mb-3">
                                                    <label><b>File Type <span> *</span></b></label>
                                                    <select class="form-select" name="type" id="fileTypeSelect">
                                                        <option value="image">Image</option>
                                                        <option value="pdf">PDF</option>
                                                    </select>
                                                    <small class="text-danger" id="sliderStatusError"></small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label><b>Title [English]<span> *</span></b></label>
                                                    <input type="text" class="form-control" name="title_en">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label><b>Title [Tamil] <span> *</span></b></label>
                                                    <input type="text" class="form-control" name="title_ta">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label><b>Alt Text [English]<span> *</span></b></label>
                                                    <input type="text" class="form-control" name="alt_text_en">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label><b>Alt Text [Tamil] <span> *</span></b></label>
                                                    <input type="text" class="form-control" name="alt_text_ta">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label><b> Image / PDF File <span> *</span></b></label>
                                                    <input type="file" class="form-control" name="filepath_img_pdf" id="fileInput">

                                                </div>
                                            </div>

                                            <div class="col-md-6" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <label><b> Status <span> *</span></b></label>
                                                    <select class="form-select" name="slider_status">
                                                        <option value="1">Published</option>
                                                        <option value="0">Draft</option>
                                                        <option value="2">Disabled</option>
                                                    </select>
                                                    <small class="text-danger" id="sliderStatusError"></small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-2 text-right">
                                            <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mt-2">


                    <div class="row mt-2" id="gallery-row">
                        @foreach($media as $imagegallery)
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-6 mb-4">
                            @if($imagegallery->type == 'image')
                            <a class="card style-6 open-edit-media-modal"
                                href="#"
                                data-id="{{ $imagegallery->id }}"
                                data-title-en="{{ $imagegallery->title_en }}"
                                data-title-ta="{{ $imagegallery->title_ta }}"
                                data-alt-en="{{ $imagegallery->alt_text_en }}"
                                data-alt-ta="{{ $imagegallery->alt_text_ta }}"
                                data-type="{{ $imagegallery->type }}"
                                data-path="{{ asset($imagegallery->filepath_img_pdf) }}">
                                
                           
                            <img src="{{ asset($imagegallery->filepath_img_pdf) }}" alt="{{ $imagegallery->alt_text_en }}" class="slider-image text-center img-thumbnail1" />

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-8 text-left mb-4">
                                        <b>{{ $imagegallery->title_en ?? 'Untitled' }}</b>


                                    </div>


                                    <div class="col-4 text-left ">
                                        <button class="btn btn-danger delete-media" data-id="{{ $imagegallery->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>


                                </div>
                            </div>


                            </a>

                            @else

                            <div class="card style-6">
                                <a class="card style-6 open-edit-media-modal" href="#"
                                    data-id="{{ $imagegallery->id }}"
                                    data-title-en="{{ $imagegallery->title_en }}"
                                    data-title-ta="{{ $imagegallery->title_ta }}"
                                    data-alt-en="{{ $imagegallery->alt_text_en }}"
                                    data-alt-ta="{{ $imagegallery->alt_text_ta }}"
                                    data-type="{{ $imagegallery->type }}"
                                    data-path="{{ asset($imagegallery->filepath_img_pdf) }}">

                                    <img src="{{ asset('assets/portaladmin/pdf-icon.png') }}" alt="{{ $imagegallery->alt_text_en }}" class="slider-image text-center img-thumbnail1" />
                                </a>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-8 text-left mb-4">
                                            <b>{{ $imagegallery->title_en ?? 'Untitled' }}</b>


                                        </div>


                                        <div class="col-4 text-left ">
                                            <button class="btn btn-danger delete-media" data-id="{{ $imagegallery->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>


                                    </div>
                                </div>


                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>


                </div>





            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade inputForm-modal" id="inputFormModaleditgallery" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header" id="inputFormModalLabel">
                        <h5 class="modal-title">Edit Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg></button>
                    </div>
                    <div class="modal-body">
                        <form id="editmediaForm" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group mb-3">
                                        <label><b>File Type <span> *</span></b></label>
                                        <select class="form-select" name="type" id="fileTypeSelect">
                                            <option value="image">Image</option>
                                            <option value="pdf">PDF</option>
                                        </select>
                                        <small class="text-danger" id="sliderStatusError"></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label><b>Title [English]<span> *</span></b></label>
                                        <input type="text" class="form-control" name="title_en">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label><b>Title [Tamil] <span> *</span></b></label>
                                        <input type="text" class="form-control" name="title_ta">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label><b>Alt Text [English]<span> *</span></b></label>
                                        <input type="text" class="form-control" name="alt_text_en">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label><b>Alt Text [Tamil] <span> *</span></b></label>
                                        <input type="text" class="form-control" name="alt_text_ta">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label><b> Image / PDF File <span> *</span></b></label>
                                        <input type="file" class="form-control" name="filepath_img_pdf" id="fileInput">

                                    </div>
                                </div>

                                <input type="hidden" name="id" id="editImageId">



                                <div class="form-group mb-3" id="currentImageWrapper" style="display: none;">

                                    <label><b>Current Image</b></label><br>
                                    <img id="editImagePreview" src="" alt="Current" style="max-height: 100px;" class="img-thumbnail">

                                    <a href="" id="editPdfLink" target="_blank" class="btn btn-sm btn-outline-primary mt-2" style="display: none;">
                                        View PDF
                                    </a>
                                </div>




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