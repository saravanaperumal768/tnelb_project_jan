@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')

<style>
    img.slider-image.text-center.img-thumbnail1 {
        max-width: 100px;
        border: 3px solid #bdbab8;
        padding: 2px;
    }

    .carousel-indicators li {
        display: none;
    }



    .widget {
        position: relative;
        padding: 6px;
        border-radius: 6px;
        border: none;
        background: #fff;
        border: 1px solid #e0e6ed;
        box-shadow: 0 0 40px 0 rgba(94, 92, 154, 0.06);
    }

    button.gnext.gbtn {
        display: none !important;
    }

    button.gprev.gbtn {
        display: none !important;
    }

    .gslide-media img {
        min-height: 370px !important;
        min-width: 1585px !important;

        max-height: 370px !important;
        max-width: 1585px !important;
    }

    div#editMediaLibraryModal {
        z-index: 1111111111;
    }

    /* .modal-content .modal-header .btn-close {
        background: #fff;
    } */
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
                        <li class="breadcrumb-item active" aria-current="page">Homepage Slider Management</li>
                    </ol>
                </nav>
                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header textblack">
                            <div class="row ">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="text-dark">Homepage Sliders / Banner Management Console </h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header" style="background:#fff; ">
                            <div class="row mt-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" style="display: none;">
                                    <h4 style="color:#000!important;">Homepage Sliders / Banner Management Console </h4>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12 pt-10">
                                    <button type="button" class="btn btn-info mb-2 me-4 float-right" data-bs-toggle="modal" data-bs-target="#additems">
                                        <i class="fa fa-plus"></i>&nbsp; Add Slider/ Banner
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Add Slider Modal -->
                        <div class="modal fade inputForm-modal" id="additems" tabindex="-1" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add New Slider</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="insertslider" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <!-- Column 1 -->


                                                <!-- Column 1 -->
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label><b>Slider Caption [English]<span> *</span></b></label>
                                                        <input type="text" class="form-control" name="slider_caption" placeholder="Slider Caption English">
                                                        <small class="text-danger" id="sliderCaptionError"></small>
                                                    </div>
                                                </div>

                                                <!-- Column 2 -->
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label><b>Slider Caption [Tamil] <span> *</span></b></label>
                                                        <input type="text" class="form-control" name="slider_caption_ta" placeholder="Slider Caption Tamil">
                                                        <small class="text-danger" id="sliderCaptionTaError"></small>
                                                    </div>
                                                </div>

                                                <!-- Full width for image -->
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label><b>Slider Image <span>*</span></b></label>
                                                        <br>
                                                        <!-- Custom Button to Open Media Modal -->
                                                        <button type="button" class="btn btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="#mediaLibraryModal">
                                                            Choose from Library
                                                        </button>

                                                        <!-- Hidden input to store selected image path -->
                                                        <input type="hidden" name="slider_image" id="sliderImagePath">

                                                        <!-- Preview of selected image -->
                                                        <div id="sliderImagePreview" class="mt-2"></div>

                                                        <small class="text-danger" id="sliderImageError"></small>
                                                        <small class="text-danger">(File Formats: jpg, png, Max: 250KB)</small><br>
                                                        <small class="text-danger">(Height 1585px X 370px)</small>
                                                    </div>
                                                </div>


                                                <!-- Column 1 -->
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label><b>Slider Status <span> *</span></b></label>
                                                        <select class="form-select" name="slider_status">
                                                            <option value="1">Published</option>
                                                            <option value="0">Draft</option>
                                                            <option value="2">Disabled</option>
                                                        </select>
                                                        <small class="text-danger" id="sliderStatusError"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="updated_by" value="{{ Auth::user()->name }}" readonly>


                                            <!-- Buttons full width -->
                                            <div class="form-group mt-2 text-right">

                                                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ---------------add media----------------- -->
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
                                        <button type="button" class="btn btn-primary" id="selectImageBtn">Add Selected</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Slider Table -->
                        <div class="">
                            <div class="table-responsive">
                                <table class="table table-bordered portaladmin">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="5%">S.No</th>

                                            <!-- <th class="text-center" width="25%"> Name</th> -->

                                            <th class="text-center">Slider Caption [ENG]</th>
                                            <th class="text-center">Slider Caption [Tamil]</th>
                                            <th class="text-center">Slider Image</th>
                                            <th class="text-center" width="5%">Date of Posted</th>
                                            <th class="text-center" width="5%">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sliderTableBody">
                                        @forelse($sliders as $index => $slider)
                                        <tr id="slider-row-{{ $slider->id }}" class="">
                                            <td class="text-center index">{{ $index + 1 }}</td>

                                            <!-- <td class="text-center slider-name">{{ $slider->slider_name }}</td> -->

                                            <td class="text-center slider-caption table_tdcontrol">{{ $slider->slider_caption }}</td>
                                            <td class="text-center slider-caption table_tdcontrol">
                                                @if($slider->slider_caption_ta == '')
                                                <p>-----</p>
                                                @else
                                                {{ $slider->slider_caption_ta }}
                                            </td>
                                            @endif

                                            <td class="text-center">
                                                @if($slider->media)
                                                <a href="{{ asset($slider->media->filepath_img_pdf) }}" class="defaultGlightbox glightbox-content">
                                                    <img src="{{ asset($slider->media->filepath_img_pdf) }}" alt="{{ $slider->media->alt_text_en ?? 'Slider Image' }}" class="img-fluid" style="max-height:100px" />
                                                    <p class="text-info mt-1">Click to View</p>
                                                </a>
                                                @else
                                                <p class="text-danger">Media not found</p>
                                                @endif
                                            </td>

                                            <td class="text-center index">{{ $slider->updated_at->format('d-m-Y') }}</td>
                                            <td class="text-center slider-caption">
                                                <span class="badge 
                                                {{ $slider->slider_status == '1' ? 'badge-success' : 
                                                ($slider->slider_status == '0' ? 'badge-dark' : 
                                                ($slider->slider_status == '2' ? 'badge-danger' : '')) }}">
                                                    @if ($slider->slider_status == '1') Published
                                                    @elseif ($slider->slider_status == '0') Draft
                                                    @elseif ($slider->slider_status == '2') Disabled
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-btns">
                                                    <i class="fa fa-pencil text-primary me-2 cursor-pointer"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $slider->id }}"
                                                        title="Edit"></i>
                                                </div>
                                            </td>
                                        </tr>





                                        <!-- Edit Slider Modal -->
                                        <div class="modal fade" id="editModal{{ $slider->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Slider</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                                            </svg></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="sliderupdate-form" data-id="{{ $slider->id }}" data-url="{{ url('/admin/homesliderupdate') }}" enctype="multipart/form-data">

                                                            @csrf
                                                            @method('PUT')

                                                            <div class="row">

                                                                <div class="col-md-6 mb-3" style="display: none;">
                                                                    <label><b>Slider Name [English]</b></label>
                                                                    <input type="text" class="form-control" name="slider_name" value="{{ $slider->slider_name }}">
                                                                </div>

                                                                <div class="col-md-6 mb-3" style="display: none;">
                                                                    <label><b>Slider Name [Tamil]</b></label>
                                                                    <input type="text" class="form-control" name="slider_name_ta" value="{{ $slider->slider_name_ta }}">
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label><b>Slider Caption [English] </b></label>
                                                                    <input type="text" class="form-control" name="slider_caption" value="{{ $slider->slider_caption }}">
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label><b>Slider Caption [Tamil] </b></label>
                                                                    <input type="text" class="form-control" name="slider_caption_ta" value="{{ $slider->slider_caption_ta }}">
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label><b>Slider Image </b></label>
                                                                    <br>
                                                                    <!-- <input type="file" class="form-control" name="slider_image" accept="image/*"> -->

                                                                    <!-- Button to open media library modal -->
                                                                    <button type="button" class="btn btn-outline-secondary mb-2 edit-open-media" data-slider-id="{{ $slider->id }}">
                                                                        Choose from Library
                                                                    </button>
                                                                    <br>

                                                                    <!-- Hidden input to store selected image ID -->
                                                                    <input type="hidden" name="slider_image" id="editSliderImagePath{{ $slider->id }}" value="{{ $slider->slider_image }}">

                                                                    <!-- Preview of selected image -->


                                                                    <small class="text-danger">(File Formats: jpg, png, Max: 250KB)</small><br>
                                                                    <small class="text-info">Present Image</small><br>
                                                                    <div id="editSliderImagePreview{{ $slider->id }}" class="mt-2">
                                                                        @if($slider->media)
                                                                        <img src="{{ asset($slider->media->filepath_img_pdf) }}" alt="{{ $slider->media->alt_text_en ?? 'Slider Image' }}" class="img-fluid" width="200px">
                                                                        @endif
                                                                    </div>

                                                                </div>


                                                                <div class="col-md-6 mb-3">
                                                                    <label><b>Slider Status </b></label>
                                                                    <select class="form-select" name="slider_status">
                                                                        <option value="1" {{ $slider->slider_status == 1 ? 'selected' : '' }}>Published</option>
                                                                        <option value="0" {{ $slider->slider_status == 0 ? 'selected' : '' }}>Draft</option>
                                                                        <option value="2" {{ $slider->slider_status == 2 ? 'selected' : '' }}>Disabled</option>
                                                                    </select>
                                                                </div>

                                                                <input type="hidden" name="slider_id" value="{{ $slider->id }}">


                                                                <div class="col-12 d-flex justify-content-end mt-3">

                                                                    <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary me-2">Update</button>
                                                                </div>

                                                            </div>
                                                        </form>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- -----------edit media modal ------------ -->
                                        <div class="modal fade" id="editMediaLibraryModal" tabindex="-1" aria-labelledby="editMediaLibraryLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Select Image from Library</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row" id="editMediaImageList">
                                                            @foreach ($media as $image)
                                                            <div class="col-md-2 mb-3">
                                                                <div class="card">
                                                                    <img src="{{ asset($image->filepath_img_pdf) }}" class="card-img-top media-image" data-id="{{ $image->id }}" data-path="{{ asset($image->filepath_img_pdf) }}">
                                                                    <div class="card-body text-center">
                                                                        <input type="radio" name="editMediaSelect" value="{{ $image->id }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-primary" id="editSelectImageBtn">Add Selected</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $slider->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $slider->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete Slider: {{ $slider->slider_name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>If you delete the slider, it will be gone forever. Are you sure you want to proceed?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-light-dark" data-bs-dismiss="modal">
                                                            <i class="flaticon-cancel-12"></i> Discard
                                                        </button>
                                                        <button class="btn btn-danger" id="deleteSliderBtn{{ $slider->id }}" data-id="{{ $slider->id }}">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No sliders found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- In your Blade view -->
                <div class="col-lg-4" style="display: none;">
                    <div class="row layout-top-spacing">
                        <div id="custom_carousel" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header" style="background:#fff; ">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4 style="color: #000!important;">Present Carousel</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area style-custom-1">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 p-0">
                                                <div id="style1" class="carousel slide style-custom-1" data-bs-ride="carousel">
                                                    <ol class="carousel-indicators">
                                                        @foreach ($sliders as $index => $slider)
                                                        <li data-bs-target="#style1" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                                                        @endforeach
                                                    </ol>

                                                    <div class="carousel-inner">
                                                        @foreach ($sliders as $index => $slider)
                                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                            <img class="d-block w-100 slide-image" src="{{ asset('portaladmin/slider/' . $slider->slider_image) }}" alt="Slide">
                                                            <div class="carousel-caption">
                                                                <h3>{{ $slider->slider_caption }}</h3>
                                                                <!-- <button class="btn btn-primary">Know More</button> -->
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                    <a class="carousel-control-prev" href="#style1" role="button" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#style1" role="button" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </a>
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

@include('admincms.include.footer');