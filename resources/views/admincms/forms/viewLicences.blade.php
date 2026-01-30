@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')
<style>
    .offcanvas-header .btn-close {
        background-color: rgb(253.4, 232.5, 232.5);
        font-size: 8px;
        padding: 8px;
        border-radius: 50rem;
        margin-right: 0;
    }
    
    .offcanvas-header {
        border-bottom: 1px solid #e8e8e8;
    }
    
    .icon-box {
        padding: 5px 5px;
        border: 1px solid #e1d9d9;
    }
    
    .custom-box{
        padding: 10px 10px;
        border: 1px solid #d3d3d3;
        border-radius: 11px;
        background: #fff;
        box-shadow: rgba(145, 158, 171, 0.2) 0px 0px 2px 0px, rgba(145, 158, 171, 0.12) 0px 12px 24px -4px;
    }
    
    .box-head{
        font-weight: 900;
    }


    .nav.nav-pills li.nav-item button.nav-link{
        color: #00601e !important;
    }

    hr {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>

<!-- View History Modal -->
<div class="modal fade" id="viewHistoryModal" tabindex="-1" role="dialog" aria-labelledby="viewHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewHistoryModalLabel">Form History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="formHistoryTable" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Form Name</th>
                                <th scope="col">Certificate Name</th>
                                <th scope="col">Fresh Form Fees</th>
                                <th scope="col">Fresh Form As On</th>
                                <th scope="col">Fresh Form Ends On</th>
                                <th scope="col">Renewal Fees</th>
                                <th scope="col">Renewal Fees As on </th>
                                <th scope="col">Renewal Fees Ends on </th>
                                <th scope="col">Renewal Late Fees </th>
                                <th scope="col">Renewal Late Fees As on </th>
                                <th scope="col">Renewal Late Fees Ends on</th>
                                <th class="text-center" scope="col">Status</th>
                                {{-- <th class="text-center" scope="col">Sales</th> --}}
                                <th scope="col">Created Date</th>
                                <th scope="col">Updated Date</th>
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
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="middle-content p-0">
            <div class="page-meta">
                <h4>Licences Management</h4>
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Licences Management</li>
                    </ol>
                </nav>
            </div>
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
                                <div class="page-title"></div>
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
            <div class="account-settings-container layout-top-spacing">
                <div class="account-content">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <ul class="nav nav-pills nav-fill" id="animateLine" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="animated-underline-home-tab" data-bs-toggle="tab" href="#animated-underline-home" role="tab" aria-controls="animated-underline-home" aria-selected="true"><i class="fa fa-rupee"></i> Fees Details</button>
                                </li>
                                {{-- <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="animated-underline-profile-tab" data-bs-toggle="tab" href="#animated-underline-profile" role="tab" aria-controls="animated-underline-profile" aria-selected="false" tabindex="-1"><i class="fa fa-rupee"></i> Renewal Fees Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="animated-underline-preferences-tab" data-bs-toggle="tab" href="#animated-underline-preferences" role="tab" aria-controls="animated-underline-preferences" aria-selected="false" tabindex="-1"><i class="fa fa-stop-circle"></i> Late Fees Details</button>
                                </li> --}}
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="animated-underline-contact-tab" data-bs-toggle="tab" href="#animated-underline-contact" role="tab" aria-controls="animated-underline-contact" aria-selected="false" tabindex="-1"><i class="fa fa-calendar"></i> Validity Periods</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content" id="animateLineContent-4">
                        <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-top-spacing layout-spacing">
                                    <div class="widget-content widget-content-area br-8">
                                        {{-- <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addFormModal"><i class="fa fa-plus"></i> Add</button> --}}
                                        <!-- zero-config -->
                                        <table id="invoice-list" class=" table dt-table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Cerificate Name / Form Name</th>
                                                    <th>Fresh Fees</th>
                                                    <th>Fresh Fees As on</th>
                                                    <th>Renewal Fees</th>
                                                    <th>Renewal Fees As on</th>
                                                    <th>Renewal Fees Ends on</th>
                                                    <th>Late Fees</th>
                                                    <th>Late Fees As on</th>
                                                    <th>Late Fees Ends on</th>
                                                    <th>Created Date</th>
                                                    <th>Updated Date</th>
                                                    <th>Status</th>
                                                    <th class="no-content">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($activeForms as $index => $form)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $form->licence_name.' / '. $form->form_name}}</td>
                                                    <td>{{ $form->fresh_fee_amount}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($form->fresh_fee_starts)->format('d-m-Y') }}</td>
                                                    <td>{{ $form->renewal_amount}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($form->renewalamount_starts)->format('d-m-Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($form->renewalamount_ends)->format('d-m-Y') }}</td>
                                                    <td>{{ $form->latefee_amount }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($form->latefee_starts)->format('d-m-Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($form->latefee_ends)->format('d-m-Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($form->created_at)->format('d-m-Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($form->updated_at)->format('d-m-Y') }}</td>
                                                    <td>
                                                        @if($form->status == 1)
                                                        <span class="badge bg-success">Active</span>
                                                        @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary bs-tooltip editFormBtn" data-bs-toggle="modal" data-bs-target="#editFormModal" style="cursor:pointer;" 
                                                        data-id="{{ $form->id }}"
                                                        data-form_name="{{ $form->form_name }}"
                                                        data-cert_name ="{{ $form->licence_id }}"
                                                        data-fresh_form_fees="{{ $form->fresh_fee_amount }}"
                                                        data-renewal_form_fees="{{ $form->renewal_amount }}"
                                                        data-renewal_late_fees="{{ $form->latefee_amount }}"
                                                        data-fresh_fees_on ="{{ $form->fresh_fee_starts }}"
                                                        data-fresh_fees_ends_on ="{{ $form->fresh_fee_ends }}"
                                                        data-renewal_fees_on ="{{ $form->renewalamount_starts }}"
                                                        data-renewal_fees_ends_on ="{{ $form->renewalamount_ends }}"
                                                        data-renewal_late_fees_on ="{{ $form->latefee_starts }}"
                                                        data-renewal_late_fees_ends_on ="{{ $form->latefee_ends }}"
                                                        {{-- data-fresh_form_duration ="{{ $form->duration_freshfee }}"
                                                        data-renewal_form_duration ="{{ $form->duration_renewalfee }}"
                                                        data-renewal_late_fees_duration ="{{ $form->duration_latefee }}"
                                                        data-fresh_form_duration_on ="{{ $form->fresh_fee_starts }}"
                                                        data-fresh_form_duration_ends_on ="{{ $form->duration_freshfee_ends }}"
                                                        data-renewal_form_duration_on ="{{ $form->duration_renewalfee_starts }}"
                                                        data-renewal_form_duration_ends_on ="{{ $form->duration_renewalfee_ends }}"
                                                        data-renewal_late_fees_duration_on ="{{ $form->duration_latefee_starts }}"
                                                        data-renewal_late_fees_duration_ends_on ="{{ $form->duration_latefee_ends }}" --}}
                                                        data-form_status ="{{ $form->status }}"
                                                        title="Edit"
                                                        >
                                                        <i class="fa fa-edit"></i>
                                                    </span>
                                                    <span class="badge badge-primary bs-tooltip openHistoryBtn" title="Previous History"
                                                    data-id="{{ $form->licence_id }}"
                                                    ><i class="fa fa-refresh"></i></span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="animated-underline-contact" role="tabpanel" aria-labelledby="animated-underline-contact-tab">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-top-spacing layout-spacing">
                                <div class="widget-content widget-content-area br-8">
                                    {{-- <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addFormModal"><i class="fa fa-plus"></i> Add</button> --}}
                                    <!-- zero-config -->
                                    <table id="validity-list" class=" table dt-table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Cerificate Name</th>
                                                <th>Fresh Form Validity</th>
                                                <th>Fresh Form Validity From</th>
                                                <th>Fresh Form Validity To</th>
                                                <th>Renewal Form Validity</th>
                                                <th>Renewal Form Validity From</th>
                                                <th>Renewal Form Validity To</th>
                                                <th>Late Fees Validity</th>
                                                <th>Late Fees Validity From</th>
                                                <th>Late Fees Validity To</th>
                                                <th>Created Date</th>
                                                <th>Updated Date</th>
                                                <th>Status</th>
                                                <th class="no-content">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($validity_periods as $index => $validity)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $validity->licence_name.' / '. $validity->form_name}}</td>
                                                <td>{{ $validity->duration_freshfee??'-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($validity->duration_freshfee_starts)->format('d-m-Y')??'-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($validity->duration_freshfee_ends)->format('d-m-Y')??'-' }}</td>
                                                <td>{{ $validity->duration_renewalfee??'-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($validity->duration_renewalfee_starts)->format('d-m-Y')??'-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($validity->duration_renewalfee_ends)->format('d-m-Y')??'-' }}</td>
                                                <td>{{ $validity->duration_latefee??'-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($validity->duration_latefee_starts)->format('d-m-Y')??'-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($validity->duration_latefee_ends)->format('d-m-Y')??'-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($validity->created_at)->format('d-m-Y')??'-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($validity->updated_at)->format('d-m-Y')??'-' }}</td>
                                                <td>
                                                    @if($validity->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                    @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bs-tooltip editValidity" data-bs-toggle="modal" data-bs-target="#addDurationModal" style="cursor:pointer;" 
                                                    data-id="{{ $validity->id }}"
                                                    data-cert_id ="{{ $validity->licence_id }}"
                                                    data-form_type ="{{ $validity->form_type }}"
                                                    data-fresh_form_duration ="{{ $validity->duration_freshfee }}"
                                                    data-renewal_form_duration ="{{ $validity->duration_renewalfee }}"
                                                    data-renewal_late_fees_duration ="{{ $validity->duration_latefee }}"
                                                    data-fresh_form_duration_on ="{{ $validity->fresh_fee_starts }}"
                                                    data-fresh_form_duration_ends_on ="{{ $validity->duration_freshfee_ends }}"
                                                    data-renewal_form_duration_on ="{{ $validity->duration_renewalfee_starts }}"
                                                    data-renewal_form_duration_ends_on ="{{ $validity->duration_renewalfee_ends }}"
                                                    data-renewal_late_fees_duration_on ="{{ $validity->duration_latefee_starts }}"
                                                    data-renewal_late_fees_duration_ends_on ="{{ $validity->duration_latefee_ends }}"
                                                    data-form_status ="{{ $validity->status }}"
                                                    title="Edit"
                                                    >
                                                    <i class="fa fa-edit"></i>
                                                    </span>
                                                    <span class="badge badge-primary bs-tooltip" id="openHistoryBtn" title="Previous History"
                                                    data-id="{{ $form->license_name }}"
                                                    ><i class="fa fa-refresh"></i></span>
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
            </div>
        </div>
    </div>


<!--Duration Modal -->
<div class="modal fade" id="addDurationModal" tabindex="-1" role="dialog" aria-labelledby="addDurationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDurationModalLabel"> Update Validity Periods</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </button>
                </button>
                {{-- <span><span class="text-danger">(Note:</span> Currently, late fees are applicable only during the last 3 months before the expiry date.)</span> --}}
            </div>
            <form id="validity_form" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Certificate / Licence Name <span class="text-danger">*</span> </label>
                        <select class="form-select" name="cert_id" id="cert_id">
                            <option value="">Please Choose the Certificate / Licence </option>
                            @foreach ($all_licences as $item)
                                <option value="{{ $item->id }}" data-form_name="{{ $item->form_name }}">{{ $item->licence_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger d-none error-licence">Please fill the Category</small>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Form Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="form_type" id="form_type">
                            <option value="N">New Form</option>
                            <option value="R">Renewal Form</option>
                        </select>
                    </div>
                </div>
                
                <hr style="border-top: 1px solid #4361ee;">
                
                <div class="row g-3 mb-3">
                    <div class="col-md-12 custom-box mb-3" id="newFormDuration">
                        <div class="box-head text-primary mb-3"><i class="fa fa-clock-o"></i> Durations for New Form</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="inputEmail4" class="form-label">Fresh Form Validity<span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control fees_amount" name="fresh_form_duration" id="fresh_form_duration" min="0">
                                    <span class="input-group-text">months</span>
                                </div>
                                <small class="text-danger d-none error-validity">Please fill the Validity</small>
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail4" class="form-label">Validity From<span class="text-danger">*</span></label>
                                <input type="date" name="fresh_form_duration_on" id="fresh_form_duration_on" class="form-control">
                                <small class="text-danger d-none error-validity_from">Please choose the validity from date</small>
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail4" class="form-label">Validity To<span class="text-danger">*</span></label>
                                <input type="date" name="fresh_form_duration_ends_on" id="fresh_form_duration_ends_on" class="form-control">
                                <small class="text-danger d-none error-validity_to">Please choose the validity to date</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 custom-box mb-3" id="renewalDuration" style="display: none">
                        <div class="box-head text-primary mb-3"><i class="fa fa-clock-o"></i> Durations Renewal</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="inputPassword4" class="form-label">Renewal Validity<span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="renewal_form_duration" id="renewal_form_duration"  min="0">
                                    <span class="input-group-text">months</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail4" class="form-label">Renewal Validity From<span class="text-danger">*</span></label>
                                <input type="date" name="renewal_duration_on" id="renewal_duration_on" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail4" class="form-label">Renewal Validity To<span class="text-danger">*</span></label>
                                <input type="date" name="renewal_duration_ends_on" id="renewal_duration_ends_on" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="inputPassword4" class="form-label">Late Fees Validity<span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="renewal_late_fee_duration" id="renewal_late_fee_duration"  min="0">
                                    <span class="input-group-text">Days</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail4" class="form-label">Late Fees Validity From<span class="text-danger">*</span></label>
                                <input type="date" name="renewal_late_fee_duration_on" id="renewal_late_fee_duration_on" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail4" class="form-label">Late Fees Validity To<span class="text-danger">*</span></label>
                                <input type="date" name="renewal_late_fee_duration_ends_on" id="renewal_late_fee_duration_ends_on" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row custom-box g-3">
                    <div class="box-head text-primary mb-3"><i class="fa fa-setting"></i> Status</div>
                    <div class="col-md-6">
                        <!-- Switch centered -->
                        <div class="d-inline-block text-center">
                            <div class="switch form-switch-custom switch-inline form-switch-success form-switch-custom dual-label-toggle">
                                <label class="switch-label switch-label-left" for="form-custom-switch-dual-label">In Active</label>
                                <div class="input-checkbox">
                                    <input class="switch-input" type="checkbox" role="switch" name="form_status" id="form_status" checked>
                                </div>
                                <label class="switch-label switch-label-right" for="form-custom-switch-dual-label">Active</label>
                            </div>
                            <small class="text-danger d-none error-form_status">Please choose the form status</small>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="form_id" id="edit_form_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal" onclick="$('#feesForm').trigger('reset');"><i class="flaticon-cancel-12"></i> Discard</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>     

<!-- Modal -->
<div class="modal fade" id="addFormModal" tabindex="-1" role="dialog" aria-labelledby="addFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFormModalLabel"> Update Fees Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </button>
                </button>
                {{-- <span><span class="text-danger">(Note:</span> Currently, late fees are applicable only during the last 3 months before the expiry date.)</span> --}}
            </div>
            <form id="feesForm" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Certificate / Licence Name <span class="text-danger">*</span> </label>
                        <select class="form-select" name="cert_name" id="cert_name">
                            <option value="">Please Choose the Certificate / Licence </option>
                            @foreach ($all_licences as $item)
                                <option value="{{ $item->id }}" data-form_name="{{ $item->form_name }}">{{ $item->licence_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Form Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="form_name" id="form_name" readonly style="color: #181616 !important;">
                        {{-- <select class="form-select" name="form_name">
                            <option value="">Please Choose the Form Name </option>
                        </select> --}}
                    </div>
                </div>

                <hr style="border-top: 1px solid #4361ee;">

                <div class="row g-3 mb-3">
                    <div class="col-md-12 custom-box mb-3">
                        <div class="box-head text-primary mb-3">₹ Fees Details</div>
                        <hr style="border-color: #000000;">
                        <div class="row g-3">
                            <div class="col-md-4 mb-2">
                                <label for="inputEmail4" class="form-label">Fees for Fresh Form <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" name="fresh_fees" min="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="inputEmail4" class="form-label">Fresh Form Fees As on<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="fresh_fees_on">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="inputEmail4" class="form-label">Fresh Form Fees <strong>Ends on</strong> <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="fresh_fees_ends_on">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="inputPassword4" class="form-label">Renewal Fees<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" name="renewal_fees" min="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="inputEmail4" class="form-label">Renewal Fees As on<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="renewal_fees_as_on">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="inputEmail4" class="form-label">Renewal Fees Ends on<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="renewal_fees_ends_on">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="inputPassword4" class="form-label">Late Fees for Renewal<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" name="latefee_for_renewal" min="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="inputEmail4" class="form-label">Late Fees As on<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="late_renewal_fees_on">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="inputEmail4" class="form-label">Late Fees Ends on<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="late_renewal_fees_ends_on">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6 custom-box mb-3">
                        <div class="box-head text-primary mb-3"><i class="fa fa-clock-o"></i> Durations</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Duration for Fresh Form <span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control fees_amount" name="fresh_form_duration" min="0">
                                    <span class="input-group-text">months</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Fresh Form Duration As on<span class="text-danger">*</span></label>
                                <input type="date" name="fresh_form_duration_on" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Duration for Renewal Form <span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="renewal_form_duration"  min="0">
                                    <span class="input-group-text">months</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Renewal Duration As on<span class="text-danger">*</span></label>
                                <input type="date" name="renewal_duration_on" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Duration of Renewal Late Fees<span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="renewal_late_fee_duration"  min="0">
                                    <span class="input-group-text">months</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Renewal Late Duration As on<span class="text-danger">*</span></label>
                                <input type="date" name="renewal_late_fee_duration_on" class="form-control">
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="row custom-box g-3">
                    <div class="box-head text-primary mb-3"><i class="fa fa-setting"></i> Status</div>
                    <div class="col-md-6">
                        <!-- Switch centered -->
                        <div class="d-inline-block text-center">
                            <div class="switch form-switch-custom switch-inline form-switch-success form-switch-custom dual-label-toggle">
                                <label class="switch-label switch-label-left" for="form-custom-switch-dual-label">In Active</label>
                                <div class="input-checkbox">
                                    <input class="switch-input" type="checkbox" role="switch" name="form_status" checked>
                                </div>
                                <label class="switch-label switch-label-right" for="form-custom-switch-dual-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal" onclick="$('#feesForm').trigger('reset');"><i class="flaticon-cancel-12"></i> Discard</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!--View Form Modal -->
<div class="modal fade" id="editFormModal" tabindex="-1" role="dialog" aria-labelledby="editFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Fees Details</h5>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <!-- Certificate & Form Name -->
                        <div class="col-md-6">
                            <label class="form-label">Certificate Name <span class="text-danger">*</span></label>
                            <select class="form-select" id="cert_name_edit" disabled>
                                <option value="">Please Choose Certificate / Licence </option>
                                @php
                                    // var_dump($all_licences);die;
                                @endphp
                                @foreach ($all_licences as $item)
                                    <option value="{{ $item->id }}" data-form_name="{{ $item->form_name }}">{{ $item->licence_name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="cert_name" id="cert_val">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Form Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="form_name" id="form_name_edit" readonly style="color: #181616 !important;">
                        </div>
                    </div>

                    <hr>

                    <!-- Fees Details -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-12 custom-box mb-3">
                            <div class="box-head text-primary mb-3">₹ Fees Details</div>
                            <hr style="border-color: #000000;">
                            <div class="row g-3">
                                <!-- Fresh Form Fees -->
                                <div class="col-md-4">
                                    <label>Fees for Fresh Form <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" name="fresh_fees" id="fresh_fees" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Fresh Fees As on <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="fresh_fees_on" id="fresh_fees_on">
                                </div>
                                 <div class="col-md-4 mb-2">
                                    <label for="inputEmail4" class="form-label">Fresh Form Fees <strong>Ends on</strong> <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="fresh_fees_ends_on" id="fresh_fees_ends_on">
                                </div>
                               
                                <!-- Renewal Form Fees -->
                                <div class="col-md-4">
                                    <label>Renewal Fees<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" name="renewal_fees" id="renewal_fees" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Renewal Fees As on <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="renewal_fees_on" id="renewal_fees_starts">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="inputEmail4" class="form-label">Renewal Fees Ends on<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="renewal_fees_ends_on" id="renewal_fees_ends_on">
                                </div>
                                

                                <!-- Late Fees -->
                                <div class="col-md-4">
                                    <label>Late Fees for Renewal<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" name="latefee_for_renewal" id="latefee_for_renewal" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Late Fees As on <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="late_renewal_fees_on" id="late_renewal_fees_starts">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="inputEmail4" class="form-label">Late Fees Ends on<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="late_renewal_fees_ends_on" id="late_renewal_fees_ends_on">
                                </div>
                            </div>
                        </div>

                        <!-- Durations -->
                        {{-- <div class="col-md-6 custom-box mb-3">
                            <div class="text-primary mb-3"><i class="fa fa-clock-o"></i> Durations</div>
                            <div class="row g-3">
                                <!-- Fresh Form Duration -->
                                <div class="col-md-6">
                                    <label>Duration for Fresh Form <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="fresh_form_duration" id="freshform_duration" min="0">
                                        <span class="input-group-text">months</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Fresh Duration As on</label>
                                    <input type="date" class="form-control" name="fresh_form_duration_on" id="freshform_duration_starts">
                                </div>

                                <!-- Renewal Form Duration -->
                                <div class="col-md-6">
                                    <label>Duration for Renewal Form <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="renewal_form_duration" id="renewal_form_duration" min="0">
                                        <span class="input-group-text">months</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Renewal Duration As on</label>
                                    <input type="date" class="form-control" name="renewal_duration_on" id="renewal_duration_starts">
                                </div>
                                

                                <!-- Renewal Late Fees Duration -->
                                <div class="col-md-6">
                                    <label class="form-label">Duration of Renewal Late Fee <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="renewal_late_fee_duration" id="renewal_late_fee_duration" min="0">
                                        <span class="input-group-text">days</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Late Fee Duration As on</label>
                                    <input type="date" class="form-control" name="renewal_late_fee_duration_on" id="renewal_late_fee_duration_starts">
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <hr>

                    <!-- Others -->
                    <div class="row g-3">
                        <div class="box-head text-primary mb-3">
                            Status
                        </div>
                        <div class="col-md-6">
                            {{-- <label> <span class="text-danger">*</span> :</label> --}}
                            <div class="d-inline-block text-center">
                                <div class="switch form-switch-custom switch-inline form-switch-success dual-label-toggle">
                                    <label class="switch-label switch-label-left">In Active</label>
                                    <div class="input-checkbox">
                                        <input class="switch-input" type="checkbox" role="switch" name="form_status" id="form_status" checked>
                                    </div>
                                    <label class="switch-label switch-label-right">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="form_id" id="form_id">
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admincms.include.footer');

<script>
     $(document).ready(function () {
        
         // Get today's date in YYYY-MM-DD format
        var today = new Date().toISOString().split('T')[0];

        // Set min date for all <input type="date"> fields across all forms
        $('form input[type="date"]').each(function () {
            $(this).attr('min', today);
        });

        // Handle any "start" and "end" pairs (like As on → Ends on)
        $('form').each(function () {
            var $form = $(this);

            // For every field ending with "_on", set corresponding "_till" field min date dynamically
            $form.find('input[name$="_on"]').on('change', function () {
                var baseName = $(this).attr('name').replace('_on', '');
                var newMinDate = $(this).val();

                $form.find('input[name="' + baseName + '_till"]').attr('min', newMinDate);
            });
        });

        // console.log('sdfasf1');

        // Dropdown form name autoselect (dependent)
        $("#cert_name").on("change", function () {
            const selectedOption = $(this).find(":selected"); // get the selected <option>
            const form_name = selectedOption.data("form_name");          // read its data-code attribute
            $("#form_name").val(form_name || "");                   // set or clear input value
        });




        $("#form_type").on("change", function () {
            const selectedOption = $(this).find(":selected");
            selectedValue = selectedOption.val();
            if (selectedValue == 'N') {
                $('#renewalDuration').hide();
                $('#newFormDuration').show();
            }else{
                $('#newFormDuration').hide();
                $('#renewalDuration').show();
            }
            
            
        });
    });
</script>