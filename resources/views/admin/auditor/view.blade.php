@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')


<style>
     .seperator-header h4 {
        background: #ffcc00;
        color: #333;
        padding: 10px 15px;
        /* font-size: 20px; */
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 5px;
        text-align: center;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Table Header Styling */
    thead th {
        background-color: #004185 !important;
        color: #ffffff !important;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }

    /* Table Row Styling */
    table tbody tr {
        transition: background 0.3s ease-in-out;
    }

    table tbody tr:hover {
        background: rgba(255, 204, 0, 0.1);
    }

    /* Button Enhancements */
    .btn-primary, .btn-danger {
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 5px;
    }

    .btn-primary:hover {
        background: #ffb300;
        border-color: #ffb300;
    }

    .btn-danger:hover {
        background: #d9534f;
        border-color: #d9534f;
    }

    /* Adjustments for "Back" Button */
    .col-lg-12.mt-2.mb-2.d-flex.justify-content-end a button {
        font-size: 16px;
        padding: 8px 15px;
        font-weight: bold;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    }

    .nav.nav-pills li.nav-item button.nav-link {
        color: #fff;
    }

    .nav.nav-pills li.nav-item button.nav-link.active {
        background-color: #fff;
        color: #004185;
    }
    .nav.nav-pills li.nav-item button.nav-link svg {
        color: #fff;
    }

    .nav.nav-pills {
        background: #3071d6;
    }
    </style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">

            <!--  BEGIN BREADCRUMBS  -->
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Analytics">
                    <header class="header navbar navbar-expand-sm">
                        <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
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

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="seperator-header layout-top-spacing">
                        <h4 class="">Pending Applications </h4>
                    </div>
                    <div class="widget-content widget-content-area br-8">
                        <div class="simple-pill" style="padding: 5px 15px;">

                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-icon-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home-icon" type="button" role="tab"
                                        aria-controls="pills-home-icon" aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                        </svg>
                                        New Applications
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-icon-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile-icon" type="button" role="tab"
                                        aria-controls="pills-profile-icon" aria-selected="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        Renewal Applications
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel"
                                    aria-labelledby="pills-home-icon-tab" tabindex="0">
                                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Application Id</th>
                                                <th>Applicant's Name</th>
                                                <th>License of</th>
                                                <th>Payment Status</th>
                                                <th>Applied On</th>
                                                <th class="no-content">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($new_applications as $key => $application)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
            
                                                    <td>
                                                        <a
                                                            href="{{ route('admin.applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                            {{ $application->application_id }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $application->applicant_name }}</td>
                                                    <td>{{ $application->license_name }}</td>
                                                    <td>Success</td>
                                                    <td>{{ format_date_other($application->created_at) }}</td>
                                                    <td>
                                                        <a
                                                            href="{{ route('admin.applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-placement="bottom" title="Forward Application">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel"
                                    aria-labelledby="pills-profile-icon-tab" tabindex="0">
                                    <table class="zero-config table dt-table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Application Id</th>
            
                                                <th>Applicant's Name</th>
                                                {{-- <th>Form Name</th> --}}
                                                <th>License of</th>
                                                <th>Payment Status</th>
                                                <th>Applied On</th>
                                                <th class="no-content">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($renewal_applications as $key => $application)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
            
                                                    <td>
                                                        <a
                                                            href="{{ route('admin.applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                            {{ $application->application_id }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $application->applicant_name }}</td>
                                                    {{-- <td>{{ $application->form_name }}</td> --}}
                                                    <td>{{ $application->license_name }}</td>
                                                    <td>Success</td>
                                                    <td>{{ format_date_other($application->created_at) }}</td>
                                                    <td>
                                                        <a
                                                            href="{{ route('admin.applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-placement="bottom" title="Forward Application">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end m-2">
                            <a href="{{route ('admin.dashboard')}}">
                                <button class="btn btn-primary _effect--ripple waves-effect waves-light">Back</button>
                            </a>
                        </div>
                        {{-- <table id="zero-config" class="table dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Application Id</th>
                                    <th>Applicant's Name</th>
                                    <th>Payment Status</th>
                                    
                                   
                                    <th>Applied On</th>
                                    <th class="no-content">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workflows as $key => $workflow)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <a href="{{ route('admin.applicants_detail', ['applicant_id' => $workflow->application_id]) }}">
                                            {{ $workflow->application_id }}
                                        </a>
                                    </td>
                                    <td>{{ $workflow->applicant_name }}</td>
                                
                                    <td>Success </td>
                                    <td>{{$workflow->created_at}}</td>
                                    <td>
                                    <a href="{{ route('admin.applicants_detail', ['applicant_id' => $workflow->application_id]) }}">
                                        <button type="button" class="btn btn-primary" data-bs-placement="bottom" title="Forward Application">
                                            <i class="fa fa-forward"></i>
                                        </button>
                                    </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    </div>
                </div>

            </div>

        </div>
    </div>

    @include('admin.include.footer');