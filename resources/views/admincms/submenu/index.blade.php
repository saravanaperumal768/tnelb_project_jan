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
                                        <li class="breadcrumb-item"><a href="#">Content Management System for TNELB</a></li>
                                    </ol>
                                </nav>

                            </div>
                        </div>

                    </header>
                </div>
            </div>




            <div class="row layout-top-spacing dashboard">
                <nav class="breadcrumb-style-five breadcrumbs_top  mb-2" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg><span class="inner-text">Dashboard </span></a></li>
                        <li class="breadcrumb-item"><a href="#">Homepage</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Portal Sub Menu Management Console</li>
                    </ol>
                </nav>

                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="text-dark card-title">Portal Sub Menu Management Console </h4>
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

                                            <!-- Edit Submenu Modal -->
                                            <div class="modal fade inputForm-modal " id="inputFormModaledit" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form class="mt-0" id="submenuFormedit" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" id="menu_id">
                                                            <div class="modal-header" id="inputFormModalLabel">
                                                                <h5 class="modal-title">Edit Sub Menu</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <!-- Menu Names -->
                                                                    <div class="col-md-6">
                                                                        <label>Sub Menu Name (English) </label>
                                                                        <input type="text" class="form-control mb-3" name="menu_name_en">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Sub Menu Name (Tamil)</label>
                                                                        <input type="text" class="form-control mb-3" name="menu_name_ta">
                                                                    </div>
                                                                </div>

                                                                <div class="row">

                                                                    <input type="hidden" name="updated_by" value="{{Auth::user()->name}}">
                                                                    <!-- Page Type -->
                                                                    <div class="col-md-6">
                                                                        <label>Page Type</label>
                                                                        <select name="page_type" id="page_type_edit" class="form-select mb-3">
                                                                            <option value="">--- Please select page type ---</option>
                                                                            <option value="Static Page">Content Page</option>
                                                                            <option value="url">URL</option>
                                                                            <option value="pdf">PDF</option>
                                                                            <option value="submenu">Submenu</option>
                                                                        </select>
                                                                    </div>

                                                                    <!-- Parent Menu -->
                                                                    <div class="col-md-6">
                                                                        <label>Parent Menu</label>
                                                                        <select name="parent_code" class="form-select mb-3" id="parent_code">
                                                                            <option value="">--- Please select Parent Menu ---</option>
                                                                            @foreach ($menus as $menu)
                                                                            <option value="{{ $menu->id }}">{{ $menu->menu_name_en }}</option>
                                                                            @endforeach
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

                                                                <!-- Static Page Inputs -->
                                                                <div class="row static-page-inputs d-none">
                                                                    <div class="col-md-6">
                                                                        <label>Page URL (English) <span>*</span> </label>
                                                                        <input type="text" class="form-control mb-3" name="page_url">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Page URL (Tamil) <span>*</span> </label>
                                                                        <input type="text" class="form-control mb-3" name="page_url_ta">
                                                                    </div>
                                                                </div>

                                                                <!-- PDF Inputs -->
                                                                <div class="row pdf-inputs d-none">
                                                                    <div class="col-md-6">
                                                                        <label>Upload PDF (English) <span>*</span> </label>
                                                                        <input type="file" class="form-control mb-2" name="pdf_en">
                                                                        <a href="#" id="submenu_pdf_link_en" target="_blank" class="text-primary d-none">
                                                                            <i class="fa fa-file-pdf-o"></i> View English PDF
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Upload PDF (Tamil) <span>*</span> </label>
                                                                        <input type="file" class="form-control mb-2" name="pdf_ta">
                                                                        <a href="#" id="submenu_pdf_link_ta" target="_blank" class="text-primary d-none">
                                                                            <i class="fa fa-file-pdf-o"></i> View Tamil PDF
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <!-- URL Input -->
                                                                <div class="row url-inputs d-none">
                                                                    <div class="col-md-12">
                                                                        <label>External URL <span>*</span> </label>
                                                                        <input type="text" class="form-control mb-3" name="external_url">
                                                                    </div>
                                                                </div>

                                                                <!-- Order & Status -->
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Order ID</label>
                                                                        <input type="text" class="form-control mb-3" name="order_id">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Status</label>
                                                                        <select name="status" class="form-select mb-3">
                                                                            <option value="1">Published</option>
                                                                            <option value="0">Draft</option>
                                                                            <option value="2">Disabled</option>
                                                                        </select>
                                                                    </div>
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

                                        <!-- Modal -->
                                        <div class="modal fade inputForm-modal reset-on-open" id="inputFormModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">

                                                    <div class="modal-header" id="inputFormModalLabel">
                                                        <h5 class="modal-title">Add New Sub Menu </b></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                                            </svg></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="mt-0" id="submenuFormadd" enctype="multipart/form-data">

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Sub Menu Name (English) <span>*</span> </label>
                                                                        <input type="text" class="form-control" name="menu_name_en" id="static_menu_name_en">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Sub Menu Name (Tamil) <span>*</span> </label>
                                                                        <input type="text" class="form-control" name="menu_name_ta" id="static_menu_name_ta">
                                                                    </div>
                                                                </div>

                                                                <input type="hidden" name="updated_by" value="{{Auth::user()->name}}">
                                                                <!-- Menu Type -->
                                                                <div class="form-group pb-2 pt-2 col-md-6">
                                                                    <label>Menu Type <span>*</span> </label>
                                                                    <select name="page_type" id="page_type_submenu" class="form-select">
                                                                        <option value="">--- Please select page type ---</option>
                                                                        <option value="Static Page">Content Page</option>
                                                                        <option value="url">URL</option>
                                                                        <option value="pdf">PDF</option>
                                                                        <option value="submenu">Submenu</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 pt-3">
                                                                    <label>Add To Footer Quick Links?</label><br>
                                                                    <div class="form-check form-check-primary form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="form-check-default-checked" name="footer_quicklinks" value="1">
                                                                        <label class="form-check-label" for="form-check-default-checked">Yes</label>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <!-- Main Menu -->
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label>Main Menu <span>*</span> </label>
                                                                    <select name="parent_code" id="parent_code" class="form-select">
                                                                        <option value="">--- Please select Main Menu ---</option>
                                                                        @foreach($menus as $menu)
                                                                        <option value="{{ $menu->id }}">{{ $menu->menu_name_en }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                @php
                                                                $nextOrderId = $submenus->max('order_id') + 1;
                                                                @endphp

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Order Number To Display</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control" name="order_id" aria-label="order_id" value="{{ $nextOrderId }}">
                                                                            <input type="hidden" class="form-control" name="updated_by">
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                            </div>



                                                            <div class="url-inputs d-none">
                                                                <div class="col-md-12 pt-2">
                                                                    <div class="form-group">
                                                                        <label>External URL <span>*</span> </label>
                                                                        <input type="url" class="form-control" name="external_url">
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <!-- Static Page Inputs -->
                                                            <div class="static-page-inputs">
                                                                <div class="row pt-2">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Sub Menu Page URL (English) <span>*</span> </label>
                                                                            <input type="text" class="form-control" name="page_url">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Sub Menu Page URL (Tamil) <span>*</span> </label>
                                                                            <input type="text" class="form-control" name="page_url_ta">
                                                                            <input type="hidden" name="status" value="1">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <!-- PDF Inputs -->
                                                            <div class="pdf-inputs d-none">


                                                                <div class="col-md-12 pt-2">
                                                                    <div class="form-group">
                                                                        <label>Upload PDF (English) <span>*</span> </label>
                                                                        <input type="file" class="form-control" name="pdf_en" accept=".pdf">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 pt-2">
                                                                    <div class="form-group">
                                                                        <label>Upload PDF (Tamil) <span>*</span> </label>
                                                                        <input type="file" class="form-control" name="pdf_ta" accept=".pdf">
                                                                    </div>
                                                                </div>


                                                            </div>

                                                            <div class="row pt-2">

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Status <span>*</span> </label>
                                                                        <select name="status_pdf" class="form-select">
                                                                            <option value="1">Published</option>
                                                                            <option value="0">Draft</option>
                                                                            <option value="2">Disabled</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <!-- Footer Buttons -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-danger mt-2 mb-2" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary mt-2 mb-2">Add</button>
                                                            </div>
                                                        </form>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">

                                        <div class="float-right">
                                            <button type="button" class="btn btn-info mb-2 me-4 float-end" data-bs-toggle="modal" data-bs-target="#inputFormModal">
                                                <i class="fa fa-plus"></i>&nbsp; Add New Sub Menu
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
                                                    <th class="text-center">Sub Menu Name (EN)</th>
                                                    <th class="text-center">Sub Menu Name (TAM)</th>
                                                    <th class="text-center">Parent/Main Menu</th>

                                                    <th class="text-center">Sub Menu Order No</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sortable-submenu">
                                                @foreach ($submenus as $menu)
                                                <tr data-id="{{ $menu->id }}">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <!-- <td>{{ $menu->updated_at->format('Y-m-d') }}</td> -->
                                                    <td>{{ $menu->menu_name_en }}</td>
                                                    <td>{{ $menu->menu_name_ta }}</td>
                                                    <td>{{ $menu->parentMenu->menu_name_en ?? '—' }}</td>

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
                                                            <li> <a href="javascript:void(0);" class="editsubMenu"
                                                                    data-id="{{ $menu->id }}"
                                                                    data-menu_name_en="{{ $menu->menu_name_en }}"
                                                                    data-menu_name_ta="{{ $menu->menu_name_ta }}"


                                                                    data-order_id="{{ $menu->order_id }}"
                                                                    data-page_type="{{ $menu->page_type }}"
                                                                    data-parent_code="{{ $menu->parent_code }}"
                                                                    data-status="{{ $menu->status }}"
                                                                    data-page_url="{{ optional($menu->submenuPage)->page_url }}"
                                                                    data-page_url_ta="{{ optional($menu->submenuPage)->page_url_ta }}"
                                                                    data-pdf_en="{{ $menu->submenuPage?->pdf_en ? asset($menu->submenuPage->pdf_en) : '' }}"
                                                                    data-pdf_ta="{{ $menu->submenuPage?->pdf_ta ? asset($menu->submenuPage->pdf_ta) : '' }}"
                                                                    data-external_url="{{ optional($menu->submenuPage)->external_url }}"
                                                                    data-footer_quicklinks_id="{{ optional($menu->submenuPage)->footer_quicklinks_id }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#inputFormModaledit"
                                                                    title="Edit">
                                                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1" data-bs-toggle="modal" data-bs-target="#inputFormModaledit">
                                                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                        </svg> -->

                                                                    <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                                                </a>
                                                            </li>
                                                            @if ($menu->page_type == 'Static Page')
                                                            <li class="static-page-link">
                                                                <a href="{{ route('admin.submenuscontent', ['id' => $menu->id]) }}" title="Edit">
                                                                    <i class="fa fa-file-text-o"></i>
                                                                </a>
                                                            </li>
                                                            @endif

                                                            <!-- @if ($menu->status == '1')
                                                                {{-- Show Deactivate Icon --}}
                                                                <li>
                                                                    <a href="javascript:void(0);" class="toggleStatussubmenu bs-tooltip"
                                                                        data-id="{{ $menu->id }}" data-status="0"
                                                                        title="Deactivate">
                                                                        <svg class="feather feather-trash p-1 br-8 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                @else
                                                                {{-- Show Activate Icon --}}
                                                                <li>
                                                                    <a href="javascript:void(0);" class="toggleStatussubmenu bs-tooltip"
                                                                        data-id="{{ $menu->id }}" data-status="1"
                                                                        title="Activate">
                                                                        <svg class="feather feather-check-circle p-1 br-8 mb-1" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M9 11l3 3L22 4"></path>
                                                                            <circle cx="12" cy="12" r="10"></circle>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                @endif -->
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

                            @foreach ($submenus as $menu)
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





    @include('admincms.include.footer');