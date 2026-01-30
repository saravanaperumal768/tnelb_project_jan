@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

<style>
    .table:not(.dataTable) tbody tr td svg {
        width: 28px;
        height: 31px;
        vertical-align: text-top;
        color: #4361ee;
        stroke-width: 1.5;
    }

    table>tbody>tr>td {
        border: 1px solid #00000021 !important;

    }

    #sortable-menu i {
        /* color: red; */
        /* font-size: 26px; */
    }

    #sortable i {
        /* color: red; */

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
                        <li class="breadcrumb-item active" aria-current="page">Portal Main Menu Management Console</li>
                    </ol>
                </nav>

                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="text-dark card-title">Portal Main Menu Management Console </h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="statbox widget box box-shadow">

                    <div class="widget-content widget-content-area">

                        <div class='parent ex-1'>
                            <div class="row ">

                                <div class="col-sm-12 ">

                                    <div class="row">
                                        <div class="col-sm-12 ">

                                            <!-- Modal for Edit Menu -->
                                            <!-- Edit Modal -->
                                            <div class="modal fade inputForm-modal" id="inputFormModaledit" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" id="inputFormModalLabel">
                                                            <h5 class="modal-title">Edit Main Menu</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-x">
                                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form id="menuFormedit" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" id="menu_id">
                                                                <input type="hidden" name="updated_by" value="{{ Auth::user()->name }}">
                                                                <input type="hidden" name="original_order_id" id="original_order_id">
                                                                <div class="row">
                                                                    <div class="form-group pb-2 col-md-6">
                                                                        <label>Menu Name (English)</label>
                                                                        <input type="text" class="form-control" name="menu_name_en">
                                                                    </div>
                                                                    <div class="form-group pb-2 col-md-6">
                                                                        <label>Menu Name (Tamil)</label>
                                                                        <input type="text" class="form-control" name="menu_name_ta">
                                                                    </div>
                                                                </div>

                                                                <div class="row">

                                                                    <div class="form-group pb-2 col-md-6">
                                                                        <label>Menu Type</label>
                                                                        <select name="page_type" id="page_type_menuedit" class="form-select">
                                                                            <option value="">--- Please select page type ---</option>
                                                                            <option value="Static Page">Content Page</option>
                                                                            <option value="url">URL</option>
                                                                            <option value="pdf">PDF</option>
                                                                            <option value="submenu">Submenu</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label>Add To Footer Quick Links?</label><br>
                                                                        <div class="form-check form-check-primary form-check-inline">
                                                                            <input class="form-check-input" type="checkbox" id="form-check-default-checked" name="footer_quicklinks" value="1">
                                                                            <label class="form-check-label" for="form-check-default-checked">Yes</label>
                                                                        </div>
                                                                    </div>

                                                                </div>





                                                                <!-- Static Page Fields -->
                                                                <div id="staticFieldsEdit" style="display: none;">

                                                                    <div class="row">
                                                                        <div class="form-group pb-2 col-md-6">
                                                                            <label>Page URL (English) <span>*</span></label>
                                                                            <input type="text" class="form-control" name="page_url">
                                                                        </div>
                                                                        <div class="form-group pb-2 col-md-6">
                                                                            <label>Page URL (Tamil) <span>*</span></label>
                                                                            <input type="text" class="form-control" name="page_url_ta">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- PDF Upload Fields -->
                                                                <div id="pdfFieldsEdit" style="display: none;">
                                                                    <div class="form-group">
                                                                        <label>Upload PDF (English) <span>*</span></label>
                                                                        <input type="file" class="form-control" name="pdf_en" accept=".pdf">
                                                                        <br><a href="#" id="pdf_en_link" target="_blank"><i class="fa fa-file-pdf-o"></i> View English PDF</a>
                                                                    </div>
                                                                    <div class="form-group mt-2">
                                                                        <label>Upload PDF (Tamil) <span>*</span></label>
                                                                        <input type="file" class="form-control" name="pdf_ta" accept=".pdf">
                                                                        <br><a href="#" id="pdf_ta_link" target="_blank"><i class="fa fa-file-pdf-o"></i> View Tamil PDF</a>
                                                                    </div>
                                                                </div>

                                                                <!-- External URL Field (for "url" type) -->
                                                                <div id="urlFieldsEdit" style="display: none;">
                                                                    <div class="form-group pb-2">
                                                                        <label>External URL <span>*</span></label>
                                                                        <input type="url" class="form-control" name="external_url">
                                                                    </div>
                                                                </div>

                                                                <div class="row pt-1">
                                                                    <div class="form-group pb-2 col-md-6">
                                                                        <label>Menu Order Number</label>
                                                                        <input type="text" class="form-control" name="order_id" id="order_id_input">
                                                                    </div>
                                                                    <div class="form-group pb-2 col-md-6">
                                                                        <label>Status <span>*</span></label>
                                                                        <select name="status" class="form-select" id="statusSelectEdit">
                                                                            <option value="1">Published</option>
                                                                            <option value="0">Draft</option>
                                                                            <option value="2">Disabled</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light-danger mt-2 mb-2" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary mt-2 mb-2">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                            <!-- Modal -->
                                            <div class="modal fade inputForm-modal reset-on-open" id="inputFormModaladdmenu" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-header" id="inputFormModalLabel">
                                                            <h5 class="modal-title">Add New Main Menu</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form class="mt-0" id="menuForm">
                                                                <!-- Page Type Selection -->


                                                                <!-- ✅ Common Fields (Menu Names) -->
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Menu Name (English) <span>*</span></label>
                                                                            <div class="input-group mb-3">

                                                                                <input type="text" class="form-control" name="menu_name_en" aria-label="menu_name_en">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Menu Name (Tamil) <span>*</span></label>
                                                                            <div class="input-group mb-3">
                                                                                <input type="text" class="form-control" name="menu_name_ta" aria-label="menu_name_ta">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">

                                                                        <div class="form-group pb-2">
                                                                            <label>Menu Type <span>*</span></label>
                                                                            <select name="page_type" id="page_type_menu" class="form-select">
                                                                                <option value="">--- Please select page type ---</option>
                                                                                <option value="Static Page">Content Page</option>
                                                                                <option value="url">URL</option>
                                                                                <option value="pdf">PDF</option>
                                                                                <option value="submenu">Submenu</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label>Add To Footer Quick Links?</label><br>
                                                                        <div class="form-check form-check-primary form-check-inline">
                                                                            <input class="form-check-input" type="checkbox" id="form-check-default-checked" name="footer_quicklinks" value="1">
                                                                            <label class="form-check-label" for="form-check-default-checked">Yes</label>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <!-- Static Page Only Fields -->
                                                                <div id="staticFields" style="display: none;">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Page URL (English) <span>*</span></label>
                                                                                <input type="text" class="form-control" name="page_url">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Page URL (Tamil) <span>*</span></label>
                                                                                <input type="text" class="form-control" name="page_url_ta">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- PDF Upload Fields -->
                                                                <!-- PDF Upload Fields -->
                                                                <!-- PDF Upload Fields -->
                                                                <div id="pdfFields" class="row" style="display: none;">
                                                                    <!-- PDF English -->
                                                                    <div class="col-md-12 pt-2">
                                                                        <div class="form-group">
                                                                            <label>Select PDF (English) <span>*</span></label>
                                                                            <button type="button" class="btn btn-outline-secondary mb-2"
                                                                                onclick="openMediaLibraryPdf('pdf_en')">
                                                                                Choose from Library
                                                                            </button>
                                                                            <input type="hidden" class="form-control" name="pdf_en" id="pdf_en">
                                                                            <div id="preview_pdf_en" class="mt-2 text-success"></div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- PDF Tamil -->
                                                                    <div class="col-md-12 pt-2">
                                                                        <div class="form-group">
                                                                            <label>Select PDF (Tamil) <span>*</span></label>
                                                                            <button type="button" class="btn btn-outline-secondary mb-2"
                                                                                onclick="openMediaLibraryPdf('pdf_ta')">
                                                                                Choose from Library
                                                                            </button>
                                                                            <input type="hidden" class="form-control" name="pdf_ta" id="pdf_ta">
                                                                            <div id="preview_pdf_ta" class="mt-2 text-success"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <div id="urlFields" class="row" style="display: none;">
                                                                    <div class="col-md-12 pt-2">
                                                                        <div class="form-group">
                                                                            <label>External Link/URL <span>*</span></label>
                                                                            <input type="text" class="form-control" name="external_url">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <!-- Common Fields -->
                                                                <div class="row">
                                                                    @php
                                                                    $nextOrderId = $menus->max('order_id') + 1;
                                                                    @endphp
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Menu Order Number </label>
                                                                            <input type="text" class="form-control" name="order_id" value="{{ $nextOrderId }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Status <span>*</span></label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="1">Published</option>
                                                                                <option value="0">Draft</option>
                                                                                <option value="2">Disabled</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect">Add</button>
                                                                </div>
                                                            </form>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- --------------- -->
                                        </div>
                                    </div>
                                    <!-- ---------------add media----------------- -->
                                    <div class="modal fade" id="mediaLibraryModalpdfmenu" tabindex="-1" aria-labelledby="mediaLibraryLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Media Library</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row" id="mediaImageList">
                                                        @foreach ($media as $image)
                                                        <div class="col-md-2 mb-3">
                                                            <div class="card">
                                                                <a href="{{ asset($image->filepath_img_pdf) }}" target="_blank">
                                                                    <img src="{{ asset('assets/portaladmin/pdf-icon.png') }}"
                                                                        class="card-img-top media-image"
                                                                        data-id="{{ $image->id }}"
                                                                        data-path="{{ asset($image->filepath_img_pdf) }}">
                                                                </a>
                                                                <div class="text-center mt-1">
                                                                    <p class="small mb-1">{{ $image->title_en ?? $image->title_ta }}</p>
                                                                    <input type="radio" name="mediaSelect" value="{{ $image->id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary" id="selectImageBtnpdfmenu">Add Selected</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- ---------------------------- -->
                                    <div class="card">
                                        <div class="card-header">

                                            <div class="float-right">
                                                <button type="button" class="btn btn-info mb-2 me-4 float-end" data-bs-toggle="modal" data-bs-target="#inputFormModaladdmenu">
                                                    <i class="fa fa-plus"></i>&nbsp; Add New Main Menu
                                                </button>
                                            </div>
                                        </div>

                                        <div id="reorderAlert" class="alert alert-success d-none" role="alert">
                                            Menu reordered successfully!
                                        </div>
                                        <div class="card-body">
                                            <select id="customColumnFilter" class="form-select form-select-sm" style="display: none;">
                                                <option value="">All</option>
                                            </select>
                                            <table id="style-3" class="table style-3 dt-table-hover portaladmin">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">S.No</th>
                                                        <!-- <th class="text-center">Date of Posted</th> -->
                                                        <th class="text-center">Menu Name (ENGLISH)</th>
                                                        <th class="text-center">Menu Name (TAMIL)</th>
                                                        <th class="text-center">Page Type</th>
                                                        <th class="text-center">Page Type Content</th>
                                                        <th class="text-center">Menu Order No</th>



                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <!-- id="sortable-menu" -->
                                                <tbody id="sortable">
                                                    @foreach ($menus as $menu)
                                                    <tr data-id="{{ $menu->id }}">
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <!-- <td>{{ $menu->updated_at->format('d-m-Y') }}</td> -->
                                                        <td>

                                                            {{ $menu->menu_name_en }}

                                                        </td>

                                                        <td>
                                                            {{$menu->menu_name_ta}}

                                                        </td>



                                                        <td class="text-capitalize">{{ $menu->page_type }}</td>


                                                        <td class="external-url">
                                                            @if($menu->page_type == 'Static Page')
                                                            {{ $menu->menuPage?->page_url ?? '' }}

                                                            @elseif($menu->page_type == 'pdf')
                                                            @if($menu->menuPage?->pdf_en)
                                                            <a href="{{ asset($menu->menuPage->pdf_en) }}" target="_blank" class="me-2" title="English PDF">
                                                                <i class="fa fa-file-pdf-o text-danger"></i>
                                                            </a>
                                                            @endif
                                                            @if($menu->menuPage?->pdf_ta)
                                                            <a href="{{ asset($menu->menuPage->pdf_ta) }}" target="_blank" title="Tamil PDF">
                                                                <i class="fa fa-file-pdf-o text-success"></i>
                                                            </a>
                                                            @endif

                                                            @elseif($menu->page_type == 'url')
                                                            <a href="{{ $menu->menuPage?->external_url ?? '#' }}" target="_blank">External Link</a>

                                                            @elseif($menu->page_type == 'submenu')
                                                            —
                                                            @endif
                                                        </td>

                                                        <td>{{ $menu->order_id }}</td>
                                                        <td>
                                                            <span class="badge 
                                                                {{ $menu->status == '1' ? 'badge-success' : 
                                                                ($menu->status == '0' ? 'badge-dark' : 
                                                                ($menu->status == '2' ? 'badge-danger' : '')) }}">
                                                                @if ($menu->status == '1')
                                                                Published
                                                                @elseif ($menu->status == '0')
                                                                Draft
                                                                @elseif ($menu->status == '2')
                                                                Disabled
                                                                @endif
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <ul class="table-controls">
                                                                <li>

                                                                    <a href="javascript:void(0);" class="editMenu"
                                                                        data-id="{{ $menu->id }}"
                                                                        data-menu_name_en="{{ $menu->menu_name_en }}"
                                                                        data-menu_name_ta="{{ $menu->menu_name_ta }}"
                                                                        data-page_url="{{ optional($menu->menuPage)->page_url }}"
                                                                        data-page_url_ta="{{ optional($menu->menuPage)->page_url_ta }}"
                                                                        data-page_type="{{ $menu->page_type }}"
                                                                        data-order_id="{{ $menu->order_id }}"
                                                                        data-status="{{ $menu->status }}"
                                                                        data-pdf_en="{{ $menu->menuPage?->pdf_en ? asset($menu->menuPage->pdf_en) : '' }}"
                                                                        data-pdf_ta="{{ $menu->menuPage?->pdf_ta ? asset($menu->menuPage->pdf_ta) : '' }}"
                                                                        data-external_url="{{ optional($menu->menuPage)->external_url }}"
                                                                        data-footer_quicklinks_id="{{ optional($menu->menuPage)->footer_quicklinks_id }}"
                                                                        data-bs-toggle="modal" data-bs-target="#inputFormModaledit">

                                                                        <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                                                    </a>

                                                                </li>
                                                                @if ($menu->page_type == 'Static Page')
                                                                <li>
                                                                    <a href="{{ route('admin.menuscontent', ['id' => $menu->id]) }}" title="Edit">
                                                                        <i class="fa fa-file-text-o"></i>
                                                                    </a>


                                                                </li>
                                                                @endif

                                                            </ul>


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







                        <div class="col-xl-4  col-lg-12 col-md-12 col-sm-12 col-12 pt-1" style="display: none;">
                            <div class="lateralDropDownContainer">

                                @foreach ($menus as $menu)
                                <div class="dropDownItem">
                                    <button class="accordionMenu menu-btn"
                                        data-menu-name="{{ $menu->menu_name }}"
                                        data-menu-id="{{ $menu->id }}">
                                        <span class="material-icons">rule</span>
                                        <h4>{{ $menu->menu_name }}</h4>
                                    </button>

                                </div>
                                @endforeach


                                <!-- 
                        <div class="dropDownItem">
                            <button class="accordionMenu">
                                <span class="material-icons">api</span>
                                <h4>About</h4>
                            </button>
                            <div class="panel">
                                <a href="#">About</a>
                                <a href="#">Mission</a>
                                <a href="#">Vision</a>
                                <a href="#">Future Scenario</a>
                            </div>
                        </div>



                        <div class="dropDownItem">
                            <button class="accordionMenu">
                                <span class="material-icons">person</span>
                                <h4>Members</h4>
                            </button>
                        </div>

                        <div class="dropDownItem">
                            <button class="accordionMenu">
                                <span class="material-icons">rule</span>

                                <h4>Rules</h4>
                            </button>
                        </div>

                        <div class="dropDownItem">
                            <button class="accordionMenu">
                                <span class="material-icons">miscellaneous_services</span>


                                <h4>Services & Standards</h4>
                            </button>
                        </div>

                        <div class="dropDownItem">
                            <button class="accordionMenu">
                                <span class="material-icons">feedback</span>


                                <h4>Complaints</h4>
                            </button>
                        </div>

                        <div class="dropDownItem">
                            <button class="accordionMenu">
                                <span class="material-icons">perm_contact_calendar</span>



                                <h4>Contact</h4>
                            </button>
                        </div> -->
                                <!-- <div class="dropDownItem">
                            <button class="accordionMenu">
                                <span class="material-icons">nature_people</span>
                                <h4>Activity</h4>
                            </button>
                            <div class="panel">
                                <a href="#">Courses</a>
                                <a href="#">Events</a>
                            </div>
                        </div> -->

                            </div>





                        </div>

                        <!-- -------------------------------- -->




                    </div>

                </div>

            </div>
        </div>




        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const showFormBtn = document.getElementById('showSubmenuFormBtn');
                const formWrapper = document.getElementById('submenuFormWrapper');
                const cancelFormBtn = document.getElementById('cancelSubmenuFormBtn');

                // Form input fields
                const mainMenuInput = document.querySelector('input[name="main_menu"]');
                const belongsToInput = document.querySelector('input[name="belongs_to"]');

                showFormBtn.addEventListener('click', function() {
                    // Get data attributes from button
                    const menuName = this.getAttribute('data-menu-name') || '';
                    const menuId = this.getAttribute('data-menu-id') || '';

                    // Set the input values
                    mainMenuInput.value = menuName;
                    belongsToInput.value = menuId;

                    // Show form
                    formWrapper.style.display = 'block';
                    // showFormBtn.style.display = 'none';
                });

                cancelFormBtn.addEventListener('click', function() {
                    formWrapper.style.display = 'none';
                    showFormBtn.style.display = 'inline-block';

                    // Optionally clear form
                    mainMenuInput.value = '';
                    belongsToInput.value = '';
                });
            });
        </script>



        @include('admincms.include.footer');