@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')

<style>
    .table>tbody>tr>td {
        font-size: 14px;
        border: none;
        padding: 5px 4px;


    }

    .table>thead>tr>th {
        padding: 5px 5px;
    }

    .form-control {
        border-radius: 0px !important;
        border: 1px solid #b2aeae;
    }

    .form-group span {
        color: #000;
    }

    .card .card-body {
    padding: 10px 20px;
    overflow: auto;
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
                        <li class="breadcrumb-item active" aria-current="page">Portal Form/License Management Console</li>
                    </ol>
                </nav>

                <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget  box-shadow ">
                        <div class="widget-header">
                            <div class="row mt-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="text-dark card-title">Portal Form/License Management Console </h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade inputForm-modal " id="inputFormModaladdforms" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">

                            <div class="modal-header" id="inputFormModalLabel">
                                <h5 class="modal-title">Add New Form/License</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>

                            

                            <div class="modal-body">
                                <form class="mt-0" id="newFormMaster">
                                    <!-- Page Type Selection -->



                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inputEmail4" class="form-label">Form Name<span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="form_name" id="form_name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>License Name <span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="license_name" id="license_name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-group">
                                                <label>---------------------Fees And Date------------------- </label>

                                            </div>
                                        </div>
                                        <div class="col-md-4 offset-md-3">
                                            <div class="form-group">
                                                <label for="inputEmail4" class="form-label">Fees For Fresh Form<span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="fresh_amount" id="fresh_amount">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Applicable As on<span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="date" class="form-control" name="freshamount_starts" id="freshamount_starts">


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="display: none;">
                                            <div class="form-group">
                                                <label>End At </label>
                                                <div class="input-group mb-3">

                                                    <input type="date" class="form-control" name="freshamount_ends" id="freshamount_ends">


                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">


                                        <div class="col-md-4 offset-md-3">
                                            <div class="form-group">
                                                <label>Fees For Renewal Form <span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="renewal_amount" id="renewal_amount">


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Applicable As on<span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="date" class="form-control" name="renewalamount_starts" id="renewalamount_starts">


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="display: none;">
                                            <div class="form-group">
                                                <label>Ends At </label>
                                                <div class="input-group mb-3">

                                                    <input type="date" class="form-control" name="renewalamount_ends" id="renewalamount_ends">


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">


                                        <div class="col-md-4 offset-md-3">
                                            <div class="form-group">
                                                <label>Late Fees Amount <span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="latefee_amount" id="latefee">


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Applicable As on<span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="date" class="form-control" name="latefee_starts" id="latefee_starts">


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="display: none;">
                                            <div class="form-group">
                                                <label>Ends At </label>
                                                <div class="input-group mb-3">

                                                    <input type="date" class="form-control" name="latefee_ends" id="latefee_ends">


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-group">
                                                <label>---------------------Duration------------------- </label>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Renewal Duration For Fresh Form [In Days] <span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="duration_freshfee" id="duration_freshfee">


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Renewal Duration For Renewal Form [In Days] <span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="duration_renewalfee" id="duration_renewalfee">


                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Duration For Late Fee [In Days] <span>*</span></label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="duration_latefee" id="duration_latefee">


                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Status <span>*</span></label>
                                                <select name="status" class="form-select">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>

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

                <div class="modal fade inputForm-modal" id="inputFormModaleditforms" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" id="inputFormModalLabel">
                                <h5 class="modal-title">Edit Form Details</h5>
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
                                <form id="editformstbls" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="form_id">


                                    <div class="row">
                                        <div class="form-group pb-2 col-md-6">
                                            <label>Form Name </label>
                                            <input type="text" class="form-control" name="form_name">
                                        </div>
                                        <div class="form-group pb-2 col-md-6">
                                            <label>License Name </label>
                                            <input type="text" class="form-control" name="license_name">
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-md-12 text-center">
                                            <div class="form-group">
                                                <label>---------------------License Period------------------- </label>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Period For Fresh License </label>
                                                <div class="input-group mb-3">
                                                    <div class="row">
                                                        <div class="col-lg-8 col-12">
                                                            <input type="number" min="1" max="10" class="form-control" name="fresh_period" id="fresh_period">


                                                        </div>

                                                        <div class="col-lg-4 col-12 d-flex align-items-center">
                                                            <span class="ms-2">Years</span>
                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Period For Renewal License </label>
                                                <div class="input-group mb-3">

                                                    <div class="row">
                                                        <div class="col-lg-8 col-12">
                                                            <input type="number" min="1" max="10" class="form-control" name="renewal_period" id="renewal_period">


                                                        </div>

                                                        <div class="col-lg-4 col-12 d-flex align-items-center">
                                                            <span class="ms-2">Years</span>
                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>






                                    </div>

                                    

                                    <div class="row">
                                        <div class="form-group pb-2 col-md-4">
                                            <label>Fees of Fresh License </label>
                                            <input type="text" class="form-control" name="fresh_amount">
                                        </div>

                                        <div class="form-group pb-2 col-md-4">
                                            <label>Start Date </label>
                                            <input type="date" class="form-control" name="freshamount_starts" id="freshamount_starts">
                                        </div>

                                        <div class="form-group pb-2 col-md-4">
                                            <label>End Date </label>
                                            <input type="date" class="form-control" name="freshamount_ends" id="freshamount_ends">
                                        </div>

                                        <!-- --------------Renewal----------------- -->
                                        <div class="form-group pb-2 col-md-4">
                                            <label>Fees of Renewal License</label>
                                            <input type="text" class="form-control" name="renewal_amount">
                                        </div>
                                        <div class="form-group pb-2 col-md-4">
                                            <label>Start Date </label>
                                            <input type="date" class="form-control" name="renewalamount_starts" id="renewalamount_starts">
                                        </div>

                                        <div class="form-group pb-2 col-md-4">
                                            <label>End Date </label>
                                            <input type="date" class="form-control" name="renewalamount_ends" id="renewalamount_ends">
                                        </div>
                                        <!-- --------------Late Fee----------------- -->
                                        <div class="form-group pb-2 col-md-4">
                                            <label>Late Fee</label>
                                            <input type="text" class="form-control" name="latefee_amount">
                                        </div>
                                        <div class="form-group pb-2 col-md-4">
                                            <label>Start Date </label>
                                            <input type="date" class="form-control" name="latefee_starts" id="latefee_starts">
                                        </div>

                                        <div class="form-group pb-2 col-md-4">
                                            <label>End Date </label>
                                            <input type="date" class="form-control" name="latefee_ends" id="latefee_ends">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-group">
                                                <label>---------------------Duration------------------- </label>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Duration For Fresh Fees </label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="duration_freshfee" id="duration_freshfee">


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Duration For Renewal Fees </label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="duration_renewalfee" id="duration_renewalfee">


                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Duration For Late Fees </label>
                                                <div class="input-group mb-3">

                                                    <input type="text" class="form-control" name="duration_latefee" id="duration_latefee">


                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row pt-1">

                                        <div class="form-group pb-2 col-md-6">
                                            <label>Status <span>*</span></label>
                                            <select name="status" class="form-select" id="statusSelectEdit">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>

                                            </select>
                                        </div>
                                        <!-- <div class="col-md-12 pt-2">
                                            <div class="form-group">
                                                <label>Instructions <span>*</span></label>
                                                <div class="">

                                                    <textarea class="form-control rich-editor" name="instructions" rows="6"></textarea>


                                                </div>
                                            </div>
                                        </div> -->
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

                <div class="card">
                    <div class="card-header">

                        <div class="float-right">
                            <button type="button" class="btn btn-info mb-2 me-4 float-end" data-bs-toggle="modal" data-bs-target="#inputFormModaladdforms">
                                <i class="fa fa-plus"></i>&nbsp; Add New Form/License
                            </button>
                        </div>
                    </div>


                    <div class="card-body">
                        <select id="customColumnFilter" class="form-select form-select-sm" style="display: none;">
                            <option value="">All</option>
                        </select>
                        <div class="table-responsive">
                            <table id="style-3" class="table style-3 dt-table-hover portaladmin">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.No</th>
                                        <!-- <th class="text-center">Date of Posted</th> -->
                                        <th class="text-center">Form <br> Name</th>
                                        <th class="text-center">License <br> Name</th>
                                        <th>Fresh License <br> Period </th>
                                        <th>Renewal License <br> Period </th>

                                        <th class="text-center">Fresh License <br> Fee In Rs (&#8377;) </th>
                                        <th>Fresh License <br>As on</th>
                                        <th class="text-center">Renewal License<br> Fee In Rs (&#8377;)</th>
                                        <th>Renewal License <br>As on</th>

                                        <th class="text-center">Late Fee <br> In Rs (&#8377;) </th>
                                        <th> Late Fee <br>As on</th>
                                        <th class="text-center">Renewal Duration <br> For Fresh Form <br>[In Days]</th>
                                        <th class="text-center">Renewal Duration <br> For Renewal Form <br>[In Days] </th>
                                        <th class="text-center">Duration For <br>Late Fee <br>[In Days] </th>

                                        <!-- <th class="text-center">Instructions</th> -->
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <!-- id="sortable-menu" -->
                                <tbody id="formtable">
                                    @foreach ($forms as $form)
                                    <tr data-id="{{ $form->id }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>

                                        <td>

                                            {{ $form->form_name }}

                                        </td>

                                        <td>
                                            {{$form->license_name}}


                                        </td>
                                        <td>
                                            {{$form->fresh_period}} Years
                                        </td>

                                        <td>
                                            {{$form->renewal_period}} Years
                                        </td>


                                        <td>{{ $form->fresh_amount }}</td>

                                        <td>
                                            {{ $form->freshamount_starts ? $form->freshamount_starts->format('d-m-Y') : '' }}

                                        </td>

                                        <td>{{ $form->renewal_amount }}</td>

                                        <td>

                                            {{$form->renewalamount_starts ? $form->renewalamount_starts->format('d-m-Y') : '' }}

                                        </td>
                                        <td>{{ $form->latefee_amount }}</td>


                                        <td>
                                            {{ $form->latefee_starts ? $form->latefee_starts->format('d-m-Y') : '' }}

                                        </td>

                                        <td>
                                            @if($form->duration_freshfee)
                                            {{ $form->duration_freshfee }}
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td>

                                            @if($form->duration_renewalfee)
                                            {{ $form->duration_renewalfee }}
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td>


                                            @if($form->duration_latefee)
                                            {{ $form->duration_latefee }}
                                            @else
                                            --
                                            @endif

                                        </td>

                                        <!-- <td class="table_tdcontrol">{{ $form->instructions }}</td> -->

                                        <!-- <td class="table_tdcontrol">
                                        
                                    </td> -->

                                        <td>
                                            <span class="badge 
                                        {{ $form->status == '1' ? 'badge-success' : 
                                        ($form->status == '0' ? 'badge-dark' : 
                                        ($form->status == '2' ? 'badge-danger' : '')) }}">
                                                @if ($form->status == '1')
                                                Active
                                                @elseif ($form->status == '0')
                                                Inactive

                                                @endif
                                            </span>
                                        </td>

                                        <td>
                                            <ul class="table-controls">
                                                <li>

                                                    <a href="javascript:void(0);" class="editformdata"
                                                        data-id="{{ $form->id }}"
                                                        data-form_name="{{ $form->form_name }}"
                                                        data-license_name="{{ $form->license_name }}"
                                                        data-fresh_amount="{{ $form->fresh_amount }}"
                                                        data-renewal_amount="{{ $form->renewal_amount }}"
                                                        data-instructions="{{ $form->instructions }}"
                                                        data-freshamount_starts="{{ $form->freshamount_starts }}"
                                                        data-freshamount_ends="{{ $form->freshamount_ends }}"
                                                        data-renewalamount_starts="{{ $form->renewalamount_starts }}"
                                                        data-renewalamount_ends="{{ $form->renewalamount_ends }}"
                                                        data-latefee_amount="{{ $form->latefee_amount }}"
                                                        data-latefee_starts="{{ $form->latefee_starts }}"
                                                        data-latefee_ends="{{ $form->latefee_ends }}"
                                                        data-duration_freshfee="{{ $form->duration_freshfee }}"
                                                        data-duration_renewalfee="{{ $form->duration_renewalfee }}"
                                                        data-duration_latefee="{{ $form->duration_latefee }}"

                                                        data-fresh_period="{{ $form->fresh_period }}"
                                                        data-renewal_period="{{ $form->renewal_period }}"





                                                        data-status="{{ $form->status }}"

                                                        data-bs-toggle="modal" data-bs-target="#inputFormModaleditforms">

                                                        <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                                    </a>



                                                </li>

                                                <li>
                                                    <a href="{{ route('admin.form_instructions', $form->id) }}">
                                                        <i class="fa fa-book" title="Instructions"></i> <span>
                                                            <!-- <button class="btn btn-sm btn-dark">
                                                        Click to Edit
                                                        </button> -->

                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.form_history', $form->old_id ?? $form->id) }}">
                                                        <i class="fa fa-history" title="License History"></i>


                                                    </a>
                                                </li>


                                            </ul>


                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- ----------------------------------------------------------------------------------------- -->
                    <div class="card-body">
                        
                        <h5 class="text-dark card-title">Fresh Fees </h5>
                        <select id="customColumnFilter" class="form-select form-select-sm" style="display: none;">
                            <option value="">All</option>
                        </select>
                        <div class="table-responsive">
                            <table id="style-3" class="table style-3 dt-table-hover portaladmin">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.No</th>
                                        <th class="text-center">Form Name</th>
                                        <th class="text-center">License Name</th>
                                        <th>License Period <br>(in Years)</th>
                                        <th>Fees Amount</th>
                                        <th>Start Date</th>
                                        <!-- <th>End Date</th> -->
                                        <th>Instructions</th>


                                        <!-- <th class="text-center">Instructions</th> -->
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <!-- id="sortable-menu" -->
                                <tbody id="formtable">
                                    @foreach ($forms as $form)
                                    <tr data-id="{{ $form->id }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>

                                        <td>

                                            {{ $form->form_name }}

                                        </td>

                                        <td>
                                            {{$form->license_name}}


                                        </td>

                                        <td>
                                            {{$form->fresh_period}} 
                                        </td>




                                        <td>{{ $form->fresh_amount }}</td>

                                        <td>
                                            {{ $form->freshamount_starts ? $form->freshamount_starts->format('d-m-Y') : '' }}

                                        </td>


                                        <td>

                                            <a href="{{ route('admin.form_instructions', $form->id) }}">
                                                <i class="fa fa-book" title="Instructions"></i> <span>
                                                    <!-- <button class="btn btn-sm btn-dark">
                                                        Click to Edit
                                                        </button> -->

                                            </a>

                                        </td>




                                        <td>
                                            <span class="badge 
                                        {{ $form->status == '1' ? 'badge-success' : 
                                        ($form->status == '0' ? 'badge-dark' : 
                                        ($form->status == '2' ? 'badge-danger' : '')) }}">
                                                @if ($form->status == '1')
                                                Active
                                                @elseif ($form->status == '0')
                                                Inactive

                                                @endif
                                            </span>
                                        </td>

                                        <td>
                                            <ul class="table-controls">
                                                <li>

                                                    <a href="javascript:void(0);" class="editformdata"
                                                        data-id="{{ $form->id }}"
                                                        data-form_name="{{ $form->form_name }}"
                                                        data-license_name="{{ $form->license_name }}"
                                                        data-fresh_amount="{{ $form->fresh_amount }}"
                                                        data-renewal_amount="{{ $form->renewal_amount }}"
                                                        data-instructions="{{ $form->instructions }}"
                                                        data-freshamount_starts="{{ $form->freshamount_starts }}"
                                                        data-freshamount_ends="{{ $form->freshamount_ends }}"
                                                        data-renewalamount_starts="{{ $form->renewalamount_starts }}"
                                                        data-renewalamount_ends="{{ $form->renewalamount_ends }}"
                                                        data-latefee_amount="{{ $form->latefee_amount }}"
                                                        data-latefee_starts="{{ $form->latefee_starts }}"
                                                        data-latefee_ends="{{ $form->latefee_ends }}"
                                                        data-duration_freshfee="{{ $form->duration_freshfee }}"
                                                        data-duration_renewalfee="{{ $form->duration_renewalfee }}"
                                                        data-duration_latefee="{{ $form->duration_latefee }}"

                                                        data-fresh_period="{{ $form->fresh_period }}"
                                                        data-renewal_period="{{ $form->renewal_period }}"





                                                        data-status="{{ $form->status }}"

                                                        data-bs-toggle="modal" data-bs-target="#inputFormModaleditforms">

                                                        <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                                    </a>



                                                </li>


                                                <li>
                                                    <a href="{{ route('admin.form_history', $form->old_id ?? $form->id) }}">
                                                        <i class="fa fa-history" title="License History"></i>


                                                    </a>
                                                </li>


                                            </ul>


                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- -------------renewal fees----------------- -->
                    <div class="card-body">
                        <h5 class="text-dark card-title">Renewal Fees </h5>
                        <select id="customColumnFilter" class="form-select form-select-sm" style="display: none;">
                            <option value="">All</option>
                        </select>
                        <div class="table-responsive">
                            <table id="style-3" class="table style-3 dt-table-hover portaladmin">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.No</th>
                                        <th class="text-center">Form Name</th>
                                        <th class="text-center">License Name</th>
                                        <th>License Period <br> (in Years)</th>
                                        <th>Fees Amount</th>
                                        <th>Start Date</th>
                                        <!-- <th>End Date</th> -->
                                        <th>Instructions</th>


                                        <!-- <th class="text-center">Instructions</th> -->
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <!-- id="sortable-menu" -->
                                <tbody id="formtable">
                                    @foreach ($forms as $form)
                                    <tr data-id="{{ $form->id }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>

                                        <td>

                                            {{ $form->form_name }}

                                        </td>

                                        <td>
                                            {{$form->license_name}}


                                        </td>

                                        <td>
                                            {{$form->renewal_period}} 
                                        </td>




                                        <td>{{ $form->renewal_amount }}</td>

                                        <td>
                                            {{ $form->renewalamount_starts ? $form->renewalamount_starts->format('d-m-Y') : '' }}

                                        </td>


                                        <td>

                                            <a href="{{ route('admin.form_instructions', $form->id) }}">
                                                <i class="fa fa-book" title="Instructions"></i> <span>
                                                    <!-- <button class="btn btn-sm btn-dark">
                                                        Click to Edit
                                                        </button> -->

                                            </a>

                                        </td>




                                        <td>
                                            <span class="badge 
                                        {{ $form->status == '1' ? 'badge-success' : 
                                        ($form->status == '0' ? 'badge-dark' : 
                                        ($form->status == '2' ? 'badge-danger' : '')) }}">
                                                @if ($form->status == '1')
                                                Active
                                                @elseif ($form->status == '0')
                                                Inactive

                                                @endif
                                            </span>
                                        </td>

                                        <td>
                                            <ul class="table-controls">
                                                <li>

                                                    <a href="javascript:void(0);" class="editformdata"
                                                        data-id="{{ $form->id }}"
                                                        data-form_name="{{ $form->form_name }}"
                                                        data-license_name="{{ $form->license_name }}"
                                                        data-fresh_amount="{{ $form->fresh_amount }}"
                                                        data-renewal_amount="{{ $form->renewal_amount }}"
                                                        data-instructions="{{ $form->instructions }}"
                                                        data-freshamount_starts="{{ $form->freshamount_starts }}"
                                                        data-freshamount_ends="{{ $form->freshamount_ends }}"
                                                        data-renewalamount_starts="{{ $form->renewalamount_starts }}"
                                                        data-renewalamount_ends="{{ $form->renewalamount_ends }}"
                                                        data-latefee_amount="{{ $form->latefee_amount }}"
                                                        data-latefee_starts="{{ $form->latefee_starts }}"
                                                        data-latefee_ends="{{ $form->latefee_ends }}"
                                                        data-duration_freshfee="{{ $form->duration_freshfee }}"
                                                        data-duration_renewalfee="{{ $form->duration_renewalfee }}"
                                                        data-duration_latefee="{{ $form->duration_latefee }}"

                                                        data-fresh_period="{{ $form->fresh_period }}"
                                                        data-renewal_period="{{ $form->renewal_period }}"





                                                        data-status="{{ $form->status }}"

                                                        data-bs-toggle="modal" data-bs-target="#inputFormModaleditforms">

                                                        <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                                    </a>



                                                </li>


                                                <li>
                                                    <a href="{{ route('admin.form_history', $form->old_id ?? $form->id) }}">
                                                        <i class="fa fa-history" title="License History"></i>


                                                    </a>
                                                </li>


                                            </ul>


                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- ----------------------------------------------------- -->
                     <!-- ---------------late fees------------------------ -->
                </div>



            </div>



        </div>


    </div>
</div>

@include('admincms.include.footer');