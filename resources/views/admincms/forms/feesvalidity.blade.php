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
    .modal-title{
    color: #000;
   }

   h4,h5{
    color:#000;
   }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="middle-content p-0">
            <div class="page-meta">
                <h4>Fees & Validity Details</h4>
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Fees & Validity</li>
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
                                    {{-- <div class="widget-heading">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLicenceModal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                                    </div> --}}
                                    <div class="widget-content widget-content-area br-8">

                                       <div class="row mt-3">
    <div class="col-md-2 offset-md-2">
        <label><strong>Filter by Licence</strong></label>
    </div>

    <div class="col-md-4">
        <select class="form-select licenseFilter" data-table="invoice-list">
            <option value="">All Licences</option>
        </select>
    </div>
</div>

                                        <!-- zero-config -->
                                        <table id="invoice-list" class="table dt-table-hover table-records" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Cerificate Name / Form Name</th>
                                                    <th>Type of Fees</th>
                                                    <th>Amount</th>
                                                    <th>Start Date</th>
                                                    <th class="no-content">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($fees_details as $form)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $form->licence_name.' / '. $form->form_name}}</td>
                                                    <td>
                                                        @if(trim($form->fees_type) == 'N')
                                                            Fresh Fees
                                                        @elseif(trim($form->fees_type) == 'R')
                                                            Renewal Fees
                                                        @elseif(trim($form->fees_type) == 'L')
                                                            Late Fees
                                                        @endif
                                                    </td>
                                                    <td>{{ $form->fees}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($form->start_date)->format('d-m-Y') }}</td>
                                                    <td>
                                                        @if ($form->status == 'Active')
                                                            <span class="badge outline-badge-success mb-2 me-4">Active</span>
                                                        @else
                                                            <span class="badge outline-badge-danger mb-2 me-4">In Active</span>
                                                        @endif
                                                    </td>
                                                    {{-- <td>
                                                        <span class="badge bg-primary bs-tooltip editFeesBtn" data-bs-toggle="modal" data-bs-target="#addFormModal" style="cursor:pointer;" 
                                                        data-id="{{ $form->id }}"
                                                        data-cert_name ="{{ $form->cert_licence_id }}"
                                                        data-fees_type="{{ $form->fees_type }}"
                                                        data-fees="{{ $form->fees }}"
                                                        data-start_date="{{ $form->start_date }}"
                                                        title="Edit"
                                                        >
                                                        <i class="fa fa-edit"></i>
                                                        </span>
                                                    </td> --}}
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

                                    <div class="row mt-3">
    <div class="col-md-2 offset-md-2">
        <label><strong>Filter by Licence</strong></label>
    </div>

    <div class="col-md-4">
        <select class="form-select licenseFilter" data-table="validity-list">
            <option value="">All Licences</option>
        </select>
    </div>
</div>

                                    <!-- zero-config -->
                                    <table id="validity-list" class=" table dt-table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Cerificate Name</th>
                                                <th>Type</th>
                                                <th>Validity</th>
                                                <th>Start Date</th>
                                                <th class="no-content">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($validity_periods as $validity)
                                            @php
                                                // var_dump($validity);die;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $validity->licence_name.' / '. $validity->form_name}}</td>
                                                <td>
                                                    @if(trim($validity->form_type) == "N")
                                                     Fresh period
                                                    @elseif(trim($validity->form_type) == "R") 
                                                     Renewal period
                                                    @elseif(trim($validity->form_type) == "L") 
                                                     Late period
                                                    @elseif(trim($validity->form_type) == "A")
                                                     Enable Renewal - Validity Period
                                                    @endif
                                                </td>
                                                <td>{{ $validity->validity }}</td>
                                                <td>{{ \Carbon\Carbon::parse($validity->validity_start_date)->format('d-m-Y')??'-' }}</td>
                                                 <td>
                                                    @if ($validity->status == 'Active')
                                                        <span class="badge outline-badge-success mb-2 me-4">Active</span>
                                                    @else
                                                        <span class="badge outline-badge-danger mb-2 me-4">In Active</span>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <span class="badge bg-primary bs-tooltip editValidity" data-bs-toggle="modal" data-bs-target="#addDurationModal" style="cursor:pointer;" 
                                                    data-id="{{ $validity->id }}"
                                                    data-cert_id ="{{ $validity->licence_id }}"
                                                    data-form_type ="{{ $validity->form_type }}"
                                                    data-validity ="{{ $validity->validity }}"
                                                    data-start_date ="{{ $validity->vadity_start_date }}"
                                                    data-form_status ="{{ $validity->status }}"
                                                    title="Edit"
                                                    >
                                                    <i class="fa fa-edit"></i>
                                                    </span>
                                                </td> --}}
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
            </div>
            <form id="validity_form" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Certificate / Licence Name <span class="text-danger">*</span> </label>
                        <select class="form-select shadow-sm border-primary-subtle rounded-3" name="cert_id" id="cert_id">
                            <option value="">Please Choose the Certificate / Licence </option>
                            @foreach ($all_licences as $item)
                                <option value="{{ $item->id }}" data-form_name="{{ $item->form_name }}">{{ $item->licence_name.' ['.$item->form_name.']'  }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger d-none error-licence">Please fill the Category</small>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Validity Type <span class="text-danger">*</span></label>
                        <select class="form-select shadow-sm border-primary-subtle rounded-3" name="form_type" id="form_type">
                            <option value="" selected>-- Please select type of period --</option>
                            <option value="N">Fresh - Validity Period</option>
                            <option value="R">Renewal - Validity Period</option>
                            <option value="L">Late - Validity Period</option>
                            <option value="A">Enable Renewal - Validity Period</option>
                        </select>
                        <small class="text-danger d-none error-form_type">Please choose the type of period</small>
                    </div>
                </div>
                
                <hr style="border-top: 1px solid #4361ee;">
                
                <div class="row g-3">
                    <div class="col-md-12 custom-box" id="newFormDuration">
                        <div class="box-head text-primary mb-3"><i class="fa fa-clock-o"></i> Durations for New Form</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Fresh Form Validity<span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control fees_amount" name="fresh_form_duration" id="fresh_form_duration" min="0">
                                    <span class="input-group-text">months</span>
                                </div>
                                <small class="text-danger d-none error-validity">Please fill the Validity</small>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Start Date<span class="text-danger">*</span></label>
                                <input type="date" name="fresh_form_duration_on" id="fresh_form_duration_on" class="form-control">
                                <small class="text-danger d-none error-validity_from">Please choose the validity from date</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 custom-box" id="renewalDuration" style="display: none">
                        <div class="box-head text-primary mb-3"><i class="fa fa-clock-o"></i> Durations for Renewal</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Renewal Validity<span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="renewal_form_duration" id="renewal_form_duration"  min="0">
                                    <span class="input-group-text">months</span>
                                </div>
                                <small class="text-danger d-none error-renewal_validity">Please fill the Renewal Validity</small>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Start Date<span class="text-danger">*</span></label>
                                <input type="date" name="renewal_duration_on" id="renewal_duration_on" class="form-control">
                                <small class="text-danger d-none error-renewal_duration_on">Please Enter the Start Date</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 custom-box" id="LateDuration" style="display: none">
                        <div class="box-head text-primary mb-3"><i class="fa fa-clock-o"></i> Durations for Late</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Late Fees Validity<span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="renewal_late_fee_duration" id="renewal_late_fee_duration"  min="0">
                                    <span class="input-group-text">Months</span>
                                </div>
                                <small class="text-danger d-none error-latefee_validity">Please fill the Late Fees Validity</small>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Start Date<span class="text-danger">*</span></label>
                                <input type="date" name="renewal_late_fee_duration_on" id="renewal_late_fee_duration_on" class="form-control">
                                <small class="text-danger d-none error-latefee_fee_date">Please Enter the Start Date</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 custom-box" id="enableDuration" style="display: none">
                        <div class="box-head text-primary mb-3"><i class="fa fa-clock-o"></i> Renewal Enable Period</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Enable - Renewal Period<span class="text-danger">*</span></label><br>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="enableRenewal" id="enableRenewal"  min="0">
                                    <span class="input-group-text">Months</span>
                                </div>
                                <small class="text-danger d-none error-enableRenewal">Please fill the Renewal Enable Period</small>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Start Date<span class="text-danger">*</span></label>
                                <input type="date" name="enableRenewalStarts" id="enableRenewalStarts" class="form-control">
                                <small class="text-danger d-none error-enableRenewalStarts">Please Enter the Renewal Enable Start Date</small>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="form_id" id="edit_form_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal" onclick="$('#feesForm').trigger('reset');"><i class="flaticon-cancel-12"></i>Cancel</button>
                <button type="submit" class="btn btn-primary">Add</button>
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
            <form id="addFees" enctype="multipart/form-data">
                <input type="hidden" name="record_id" id="record_id">
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="cert_name" class="form-label text-primary fw-bold">
                                Certificate / Licence <span class="text-danger">*</span>
                            </label>
                            <select class="form-select shadow-sm border-primary-subtle rounded-3" name="cert_name" id="cert_name">
                                <option value="">Please Choose the Certificate / Licence</option>
                                @foreach ($all_licences as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->licence_name . ' [' . $item->form_name . ']' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-danger d-none error-cert_name">Please choose the Certificate / Licence</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label text-primary fw-bold">Type of Fees <span class="text-danger">*</span></label>
                        {{-- <input type="text" class="form-control" name="form_name" id="form_name" readonly style="color: #181616 !important;"> --}}
                        <select class="form-select shadow-sm border-primary-subtle rounded-3" name="fees_type" id="fees_type">
                            <option value="">Please Choose the Type </option>
                            <option value="N">Fresh Fees</option>
                            <option value="R">Renewal Fees</option>
                            <option value="L">Late Fees</option>
                        </select>
                        <small class="text-danger d-none error-fees_type">Please choose the Fees Type</small>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div id="freshForm" class="col-md-12 custom-box mb-3 shadow-sm border-primary-subtle rounded-3 animated fadeInDown">
                        <div class="box-head text-primary mb-3">₹ Fees Details</div>
                        <hr style="border-color: #000000;">
                        <div class="row g-3">
                            <div class="col-md-6 mb-2">
                                <label for="inputEmail4" class="form-label">Fees <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" name="fresh_fees" min="0" placeholder="0">
                                </div>
                                <small class="text-danger d-none error-fresh_fees">Please enter the Fresh Fees amount</small>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="inputEmail4" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="fresh_fees_on">
                                <small class="text-danger d-none error-fresh_fees_on">Please select the Fresh Fees start date</small>
                            </div>
                        </div>
                    </div>
                    <div id="renewalForm" class="col-md-12 custom-box mb-3 shadow-sm border-primary-subtle rounded-3 animated fadeInDown" style="display: none">
                        <div class="box-head text-primary mb-3">₹ Renewal Fees Details</div>
                        <div class="row g-3">
                           <div class="col-md-6 mb-2">
                                <label for="inputPassword4" class="form-label">Renewal Fees <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" name="renewal_fees" min="0" placeholder="0">
                                </div>
                                <small class="text-danger d-none error-renewal_fees">Please enter the Renewal Fees amount</small>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="inputEmail4" class="form-label">Start Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="renewal_fees_as_on">
                                <small class="text-danger d-none error-renewal_fees_as_on">Please select the Renewal Fees start date</small>
                            </div>
                        </div>
                    </div>
                    <div id="latefees" class="col-md-12 custom-box mb-3 shadow-sm border-primary-subtle rounded-3 animated fadeInDown">
                        <div class="box-head text-primary mb-3">Late Fees</div>
                        <div class="row g-3">
                             <div class="col-md-6 mb-2">
                                <label for="inputPassword4" class="form-label">Late Fees<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" name="late_fees" min="0" placeholder="0">
                                </div>
                                <small class="text-danger d-none error-late_fees">Please enter the Late Fees Amount</small>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="inputEmail4" class="form-label">Start Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="late_fees_on">
                                <small class="text-danger d-none error-late_fees_on">Please select the Late Fees start date</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn btn-light-dark" data-bs-dismiss="modal" onclick="$('#addFees').trigger('reset');"><i class="flaticon-cancel-12"></i>cancel</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>



@include('admincms.include.footer');

<script>
     $(document).ready(function () {
        
        const today = new Date();
        const tomorrow = new Date(today);
        // tomorrow.setDate(today.getDate() + 1);

        tomorrow.setDate(today.getDate());

        // Format as YYYY-MM-DD
        const tomorrowStr = tomorrow.toISOString().split('T')[0];

        $('form input[type="date"]').attr('min', tomorrowStr);

        $('form').each(function () {
            const $form = $(this);

            $form.find('input[name$="_on"]').on('change', function () {
                const baseName = $(this).attr('name').replace('_on', '');
                const newMinDate = $(this).val();

                $form.find(`input[name="${baseName}_till"]`).attr('min', newMinDate);
            });
        });


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
                $('#LateDuration').hide();
                $('#enableDuration').hide();
                $('#newFormDuration').show();
            }else if(selectedValue == "R") {
                $('#newFormDuration').hide();
                $('#LateDuration').hide();
                $('#enableDuration').hide();
                $('#renewalDuration').show();
            }else if(selectedValue == "L") {
                $('#newFormDuration').hide();
                $('#renewalDuration').hide();
                $('#enableDuration').hide();
                $('#LateDuration').show();
            }else if(selectedValue == 'A'){
                $('#newFormDuration').hide();
                $('#renewalDuration').hide();
                $('#LateDuration').hide();
                $('#enableDuration').show();
            }
        });


$('#latefees').hide();


function toggleFeesSections() {
    const type = $("#fees_type").val();

    // console.log("toggleFeesSections() called, type:", type); // debug

    if (type === "R") {
        $("#freshForm, #latefees").hide();
        $("#renewalForm").show();
    } else if (type === "L") {
        $("#freshForm, #renewalForm").hide();
        $("#latefees").show();
    } else {
        $("#renewalForm, #latefees").hide();
        $("#freshForm").show();
    }
}

$(document).on("change", "#fees_type", function () {
    toggleFeesSections();
});

toggleFeesSections(); 

// $("#fees_type").on("change", function () {
//     toggleFeesSections();
//     const selectedOption = $(this).find(":selected");
//     selectedValue = selectedOption.val();
//     if (selectedValue == 'R') {
//         $('#freshForm').hide();
//         $('#latefees').hide();
//         $('#renewalForm').show();

//     }else if(selectedValue == 'L') {
//         console.log('sfsdf');
        
//         $('#freshForm').hide();
//         $('#renewalForm').hide();
//         $('#latefees').show();
//     }else{
//         $('#renewalForm').hide();
//         $('#latefees').hide();
//         $('#freshForm').show();

//     }
// });


        // $(document).on("click", ".editFeesBtn", function () {
        //     const id = $(this).data("id");
        //     const cert_id = $(this).data("cert_name");
        //     const type = $(this).data("fees_type");
        //     const fees = $(this).data("fees");
        //     const start = $(this).data("start_date");

        //     $("#record_id").val(id);
        //     $("#cert_name").val(cert_id).trigger("change");
            
        //     $('#addFormModal').one('shown.bs.modal', function () {
        //         console.log("Setting type:", type);
        //         $("#fees_type").val(type).trigger("change");
        //     });

        //     if (type === "N") {
        //         $("input[name='fresh_fees']").val(fees);
        //         $("input[name='fresh_fees_on']").val(start);
        //     } else {
        //         $("input[name='renewal_fees']").val(fees);
        //         $("input[name='renewal_fees_as_on']").val(start);
        //     }

        //     $("input[name='form_status']").prop("checked", status == 1);

        //     $(".modal-title").text("Edit Fees Details");
        // });

        $(document).on("click", ".editFeesBtn", function () {
            const id      = $(this).data("id");
            const cert_id = $(this).data("cert_name");
            const type    = $.trim($(this).data("fees_type")); // ✅ trims spaces
            const fees    = $(this).data("fees");
            const start   = $(this).data("start_date");
            const status  = $(this).data("form_status");

            $("#record_id").val(id);
            $("#cert_name").val(cert_id).trigger("change");
            $("#fees_type").val(type).trigger("change"); // now fires properly

            const formattedStart = start ? start.split(" ")[0] : "";
            if (type === "N") {
                $("input[name='fresh_fees']").val(fees);
                $("input[name='fresh_fees_on']").val(formattedStart);
            } else if (type === "R") {
                $("input[name='renewal_fees']").val(fees);
                $("input[name='renewal_fees_as_on']").val(start);
            } else if (type === "L") {
                $("input[name='late_fees']").val(fees);
                $("input[name='late_fees_on']").val(formattedStart);
            }

            $("input[name='form_status']").prop("checked", status == 1);
            $(".modal-title").text("Edit Fees Details");
            // $(".submitbtn").text("Update");      

        });
    });



</script>

<script>
$(document).ready(function () {

    $('.licenseFilter').each(function () {

        let filter = $(this);
        let tableId = filter.data('table');
        let tableElement = $('#' + tableId);

        // ✅ Prevent DataTable reinitialisation
        let table;
        if ($.fn.DataTable.isDataTable(tableElement)) {
            table = tableElement.DataTable();
        } else {
            table = tableElement.DataTable({
                pageLength: 10
            });
        }

        // Column index of "Certificate Name / Form Name"
        let licenseColumn = table.column(1);
        let licenses = [];

        // Collect unique licence names
        licenseColumn.data().each(function (value) {
            let licenceName = value.split('/')[0].trim();
            if (!licenses.includes(licenceName)) {
                licenses.push(licenceName);
            }
        });

        // Populate dropdown
        licenses.sort().forEach(function (licence) {
            filter.append(`<option value="${licence}">${licence}</option>`);
        });

        // Filter on change
        filter.on('change', function () {
            let selected = $(this).val();

            if (selected) {
                licenseColumn.search(selected, true, false).draw();
            } else {
                licenseColumn.search('').draw();
            }
        });

    });

});
</script>








