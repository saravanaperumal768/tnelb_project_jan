@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')

<style>
    /* table th{
        color: #070707 !important;
        background-color: #ccae00 !important;
    }

    .seperator-header h4{
        background: #9c8503;
    } */


     /* Improved heading style */
    .seperator-header h4 {
        background: #ffcc00;
        color: #333;
        padding: 10px 15px;
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 5px;
        text-align: center;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Table Header Styling */
    table th {
        background-color: #ffcc00 !important;
        color: #222 !important;
        text-align: center;
        font-weight: bold;
        padding: 12px;
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
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">

            <!--  BEGIN BREADCRUMBS  -->
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Analytics">
                    <header class="header navbar navbar-expand-sm">
                        <a href="{{ route('secretary_table')}}" class="btn-toggle sidebarCollapse" data-placement="bottom">
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

                             

                            </div>
                        </div>

                    </header>
                </div>
            </div>
            <!--  END BREADCRUMBS  -->

            <div class="row layout-top-spacing">
                <!-- -------------------------------------------------------- -->
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 mt-2 mb-2 d-flex justify-content-end">
                        <a href="{{route('dashboard')}}">
                            <button class="btn btn-primary _effect--ripple waves-effect waves-light">Back</button>
                        </a>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="seperator-header layout-top-spacing">
                            <h4 class="">Pending Applications For FORM S (Licence C)</h4>
                        </div>
                        <div class="statbox widget box box-shadow">
                                {{-- <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12"> 
                                        <h5 class="text-center p-2" style="color: #427ee1">List of New Applications of FORM S (Licence C)</h5>
                                    </div>
                                </div> --}}
                            <div class="widget-content widget-content-area br-8">

                                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Application Id</th>
                                            <th>Applicant's Name</th>
                                            <th>Form Name</th>
                                            <th>License of</th>
                                            <th>Applied On</th>
                                            <th class="no-content">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($workflows as $key => $application)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
    
                                            <td>
                                                <a href="{{ route('applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                    {{ $application->application_id }}
                                                </a>
                                            </td>
                                            <td>{{ $application->applicant_name }}</td>
                                            <td>{{ $application->form_name }}</td>
                                            <td>{{ $application->license_name }}</td>
                                            <td>{{ $application->created_at }}</td>
                                            <td>
                                                <a href="{{ route('applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>
                                                <button class="btn btn-danger">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
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

@include('include.footer');