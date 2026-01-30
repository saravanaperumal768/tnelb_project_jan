@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')

<style>
    table th{
        color: #070707 !important;
        background-color: #ccae00 !important;
    }

    .seperator-header h4{
        background: #ffcc00;
        color: #070707;
    }

    /* Table Header Styling */
    /* table th {
        background-color: #ffcc00 !important;
        color: #222 !important;
        text-align: center;
        font-weight: bold;
        padding: 12px;
    } */

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


</style>

<div id="content" class="main-content">
    <!-- <div class="seperator-header layout-top-spacing text-center">
        <h4 class="">Completed Applications For FORM S (Licence C)</h4>
    </div> -->
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">

            <!--  BEGIN BREADCRUMBS  -->
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Analytics">
                    <header class="header navbar navbar-expand-sm">
                        <a href="{{ route('admin.secretary_table')}}" class="btn-toggle sidebarCollapse" data-placement="bottom">
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

            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="statbox widget box box-shadow">
                            {{-- <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-xl-8 col-md-8 col-sm-8 col-8"> 
                                    <h5 class="text-center p-2" style="color: #427ee1">List of Completed Applications of FORM S (Licence C)</h5>
                                    <h4 class="">Pending Applications For {{ $workflows->first()->form_name ?? 'N/A' }} (License {{ $workflows->first()->license_name ?? 'N/A' }} )</h4>
                                </div>
                            </div> --}}
                            <div class="seperator-header layout-top-spacing">
                                <h4 class="">Completed Applications of {{ $workflows->first()->form_name ?? 'N/A' }} (License {{ $workflows->first()->license_name ?? 'N/A' }} )</h4>
                            </div>
                            <div class="widget-content widget-content-area br-8">
                                <div class="d-flex justify-content-end m-2">
                                    <a href="{{route ('admin.dashboard')}}">
                                        <button class="btn btn-primary _effect--ripple waves-effect waves-light">Back</button>
                                    </a>
                                </div>

                            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application Id</th>
                                        <th>Applicant's Name</th>
                                        <th>Payment Status</th>
                                        <th>Applied On</th>
                                        <th>Status</th>
                                        <th>License ID</th>
                                        <th>Issued at</th>
                                        <th>View License</th>
                                        <!-- <th class="no-content">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workflows as $key => $application)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            <a href="{{ route('admin.view_application_details', ['applicant_id' => $application->application_id]) }}">
                                                {{ $application->application_id }}
                                            </a>
                                        </td>
                                        <td>{{ $application->applicant_name }}</td>
                                        {{-- <td>{{ $application->form_name }}</td>
                                        <td>{{ $application->license_name }}</td> --}}
                                        <td>
                                            Success
                                        </td>
                                        <td>{{ $application->created_at }}</td>
                                        <td>
                                            @if($application->status == 'F')
                                            <span class="badge badge-warning mb-2 me-4">Forwarded</span>
                                            @elseif($application->status == 'A')
                                            <span class="badge badge-success mb-2 me-4">Approved</span>
                                            @else
                                                {{ $application->status }}
                                            @endif
                                        </td>
                                        <td>
                                           {{ $application->licence_number }} 
                                        </td> 
                                        <td>
                                           {{ format_date($application->licence_issued_at) }} 
                                        </td>

                                        <td>

                                            @if($application->status == 'F')
                                            {{ '-' }}
                                            @else
                                                <a class="badge badge-primary mb-2 me-4" href="{{ route('admin.generate.pdf', ['application_id' => $application->application_id]) }}" target="_blank">
                                                    <i class="fa fa-eye"></i> View
                                                </a>

                                                <a href="{{ route('admin.generateLicensePDF', ['application_id' => $application->application_id]) }}" target="_blank"

                                                ata-bs-toggle="tooltip" data-bs-placement="top" title="Download Licence PDF"> 
                                                <span class="badge badge-info" style="font-size: 15px;">
                                                    <i class="fa fa-download"></i>
                                                </span>
                                                </a>
                                            @endif
                                        </td>
                                       
                                        <!-- <td>
                                            <a href="{{ route('admin.applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </a>
                                            <button class="btn btn-danger">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </td> -->
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

@include('admin.include.footer');