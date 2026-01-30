@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')

<style>
    h4{
        font-weight: 700;
    }
     thead th {
        background-color: #004185 !important;
        color: #ffffff !important;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }
   
    .form-select{
        border: 1px solid #004185;
    }
    .form-control{
        border: 1px solid #004185;
    }

    .dataTables_processing .card{
        border: 1px solid #004185 !important;
        color: #004185 !important;
        background-color: transparent;
        box-shadow: none;
    }

    .nav.nav-tabs li.nav-item button.nav-link.active{
        background: unset !important;
        color: #0058ff !important;
    }
    .nav.nav-tabs li.nav-item button.nav-link{
        color: #716f7b !important
    }

    .nav-tabs {
        border-bottom: 1px solid #191e3a17;
    }

    .modal-header {
        background:#004185
    }
    .modal-header .modal-title {
        color: #ffffff;
    }
    .modal-content .modal-header {
        border-bottom: unset !important
    }
    /* .modal-content .modal-body{
        background: aliceblue;
    } */

    .personal-card{
        padding: 8px 8px;
        background: #fff;
        border-radius: 10px;
        border: 2px solid #000000a6;
    }
    .photo-card{
        background: #fff;
        border-radius: 10px;
        border: 2px solid #c3bbbb;
    }
    table th[scope="row"] {
        background-color: #004185;
        color: #fff;
    }

    .personal-card img{
        width: 200px;
        height: 200px;
    }

    .personal-card h6{
       padding: 10px;
    }

    .extra-data table > tbody > tr > strong {

    }

    .other-details{
        display: flex;
        margin: 5px 50px;
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
                                <div class="page-title"></div>
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

            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing col-md-12">
                    <div class="statbox widget box box-shadow">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4 class="text-center">MIS Report search</h4>
                            </div>
                        </div>
                        <hr>
                        <form id="filter_report" class="row g-3 needs-validation" novalidate>
                            <div class="col-md-3">
                                <label for="validationCustom01" class="form-label">Form Type</label>
                                <select class="form-select" id="form_type" name="form_name">
                                    <option selected disabled value="">Choose...</option>
                                    <option value="S">FORM S</option>
                                    <option value="A">FORM A</option>
                                    <option value="W">FORM W</option>
                                    <option value="WH">FORM WH</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom01" class="form-label">License Type</label>
                                <select class="form-select" id="license_type" name="license_type">
                                    <option selected disabled value="">Choose...</option>
                                    <option value="C">C</option>
                                    <option value="EA">EA</option>
                                    <option value="B">B</option>
                                    <option value="WH">WH</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom02" class="form-label">Received From and To</label>
                                <input id="rangeFromTo" name="rangeFromTo" type="text" class="form-control flatpickr flatpickr-input" placeholder="Select Date.." readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom01" class="form-label">Status</label>
                                <select class="form-select" id="apps_status">
                                    <option selected disabled value="">Choose...</option>
                                    <option value="P">Pendings</option>
                                    <option value="F">In Progress</option>
                                    <option value="RE">Returned</option>
                                    <option value="A">Completed</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-danger text-center" id="filterBtn"><i class="fa fa-filter"></i>  Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="" style="display: block">
                <div class="card">
                    <div class="card-body">
                        <table id="applicationTable" class="table dt-table-hover">
                            <thead class="text-center">
                                <th>S.No</th>
                                <th>Application ID</th>
                                <th>Application Type</th>
                                <th>License Name</th>
                                <th>Date of Apps</th>
                                <th>Status</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Application ID | <span>85986568</span style="color: #24429d;"></h5>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-primary print-button">
                        <i class="fa fa-print"></i>
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs" id="userTab" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">
                        Personal Details
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="application-tab" data-bs-toggle="tab" data-bs-target="#application" type="button" role="tab" aria-controls="application" aria-selected="false">
                        Payment Details
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">
                        Required Mandatory
                    </button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="userTabContent">
                    <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                      <div class="row">
                        <div class="col-lg-12">
                            <div class="personal-card layout-top-spacing">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Applicant Name</th>
                                            <td>Arunachalam</td>
                                            <td rowspan="4"><img src="{{ asset('assets/admin/images/logo/logo.png') }}" alt="user-photo"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Father's Name</th>
                                            <td>Arunachalam</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address</th>
                                            <td>Arunachalam</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">D.O.B & Age</th>
                                            <td>01-01-1980 / 45</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="personal-card layout-top-spacing">
                                <h6 class="" style="color:#098501;font-weight: 700;"> <i class="fa fa-graduation-cap"></i> Educational Qualification</h6>
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                      <tr>
                                        <th>Degree</th>
                                        <th>Institution</th>
                                        <th>Year of Passing</th>
                                        <th>Percentage</th>
                                        <th>Documents</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>PG</td>
                                        <td>NIITM</td>
                                        <td>2020</td>
                                        <td>75%</td>
                                        <td><!-- You can place document links/buttons here --></td>
                                      </tr>
                                      <tr>
                                        <td>UG</td>
                                        <td>SKC</td>
                                        <td>2018</td>
                                        <td>80%</td>
                                        <td><!-- You can place document links/buttons here --></td>
                                      </tr>
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="personal-card layout-top-spacing">
                                <h6 class="" style="color:#098501;font-weight: 700;"> <i class="fa fa-briefcase"></i> Work Experience</h6>
                                  <table class="table table-bordered">
                                      <thead class="table-light">
                                      <tr>
                                          <th>Company Name</th>
                                          <th>Designation</th>
                                          <th>Years of Experience</th>
                                        <th>Documents</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>NIC</td>
                                            <td>Developer</td>
                                            <td>2 years</td>
                                            <td><!-- Optional: Add a link or button here --></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="personal-card layout-top-spacing extra-data">
                                <div class="layout-top-spacing">
                                    <h6 class="" style="color:#098501;font-weight: 700;"> <i class="fa fa-certificate"></i> Electrical Assistant Qualification Certificate</h6>
                                    <div class="other-details">
                                        <p>License Number :</p><p>112233</p>
                                    </div>
                                    <div class="other-details">
                                        <p>Date :</p><p>2025-04-01</p>                                       
                                    </div>
                                </div>
                                <div class="layout-top-spacing">
                                    <h6 class="" style="color:#098501; font-weight: 700;"> <i class="fa fa-clipboard"></i> Wireman.C.C/Wireman Helper.C.C issued by this Board?</h6>
                                    
                                    <div class="other-details">
                                        <p>Wireman License Number:</p><p>112233</p>
                                    </div>
                                    <div class="other-details">
                                        <p>Date:</p><p>2025-04-01</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="application" role="tabpanel" aria-labelledby="application-tab">
                      
                    </div>
                    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                      <ul>
                        <li><a href="#">Photo ID</a></li>
                        <li><a href="#">Proof of Address</a></li>
                      </ul>
                    </div>
                  </div>

                {{-- <p class="modal-text">Mauris mi tellus, pharetra vel mattis sed, tempus ultrices eros. Phasellus egestas sit amet velit sed luctus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse potenti. Vivamus ultrices sed urna ac pulvinar. Ut sit amet ullamcorper mi. </p> --}}
            </div>
            <div class="modal-footer justify-content-center">
                {{-- <button class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Close</button>
                <button type="button" class="btn btn-primary">Print</button> --}}
            </div>
        </div>
    </div>
</div>

@include('admin.include.footer');
<script>

    var f3 = flatpickr(document.getElementById('rangeFromTo'), {
        mode: "range"
    });

    $(document).ready(function () {

        var table = $('#applicationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.get_mic_report') }}",
                type: "POST",
                data: function(d) {
                    d._token = '{{ csrf_token() }}';
                    d.form_type = $('#form_type').val();
                    d.license_name = $('#license_type').val();
                    d.date_range = $('#rangeFromTo').val();
                    d.apps_status = $('#apps_status').val();
                }
            },
            dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>"+
                    "<'table-responsive'tr>"+
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                "oPaginate": { 
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            columns: [
                { 
                    data: null,
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: null,
                    name: 'application_id',
                    render: function(data, type, row) {
                        let badgeClass = 'primary'; // You can choose class based on some row condition
                        let label = row.application_id;

                        return `<a href="javascript:void(0);" class="get_mis_details" data-id="${row.application_id}">${label}</a>`;
                    }
                },
                {
                    data: null,
                    name: 'form_name',
                    render: function(data, type, row) {
                        let form_name = row.form_name;
                        let badgeClass = 'secondary';
                        let label = 'Unknown';

                        switch (form_name) {
                            case 'S':
                                badgeClass = 'warning';
                                label = 'S';
                                break;
                            case 'W':
                                badgeClass = 'danger';
                                label = 'W';
                                break;
                            case 'A':
                                badgeClass = 'success';
                                label = 'A';
                                break;
                        }

                        // return 'FORM ' + label;
                        return `<span class="badge bg-${badgeClass}">FORM ${label}</span>`;
                    }
                },
                {
                    data: null,
                    name: 'license_name',
                    render: function(data, type, row) {
                        return 'License ' + row.license_name;
                    }
                },
                { 
                    data: 'created_at', 
                },
                {
                    data: null,
                    name: 'status',
                    render: function(data, type, row) {
                        let status = row.status;
                        let badgeClass = 'secondary';
                        let label = 'Unknown';

                        switch (status) {
                            case 'P':
                                badgeClass = 'warning';
                                label = 'Pending';
                                break;
                            case 'F':
                                badgeClass = 'info';
                                label = 'In Progress';
                                break;
                            case 'A':
                                badgeClass = 'success';
                                label = 'Approved';
                                break;
                        }

                        return `<span class="badge bg-${badgeClass}">${label}</span>`;
                    }
                }
            ]
        });

        $('#filterBtn').click(function(e) {
            e.preventDefault();
            table.ajax.reload();
        });


        $(document).on('click', '.get_mis_details', function(e) {
            e.preventDefault();
            console.log('sdfdfs');
            $("#exampleModal").modal("show");

        });
 
        
    });
</script>
