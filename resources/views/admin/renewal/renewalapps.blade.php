@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')

<style>
     thead th {
        background-color: #004185 !important;
        color: #ffffff !important;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }

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
        background: #238b45!important;
        border-color: #238b45!important;
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

                             

                            </div>
                        </div>

                    </header>
                </div>
            </div>
            <!--  END BREADCRUMBS  -->

            <!-- -------------------------------------------------------- -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="statbox widget box box-shadow">
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
                                        <th>Form / License</th>
                                        <th>Payment Status</th>
                                        <th>Applied On</th>
                                        <th class="no-content">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($application_details as $key => $application)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            <a href="{{ route('admin.applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                {{ $application->application_id }}
                                            </a>
                                        </td>
                                        <td>{{ $application->applicant_name }}</td>
                                        <td>
                                            @switch($application->form_name)
                                                @case($application->form_name == 'S')
                                                    <span class="badge badge-warning">Form {{ $application->form_name }} / License {{ $application->license_name }}</span>
                                                    @break
                                                @case($application->form_name == 'W')
                                                    <span>Form {{ $application->form_name }} / License {{ $application->license_name }}</span>
                                                    @break
                                                @default
                                            @endswitch
                                        </td>
                                        <td>
                                            @if ($application->payment_status == 'payment')
                                                <span class="badge badge-success">success</span>
                                            @else
                                            <span class="badge badge-danger">failes</span>
                                            @endif
                                        </td>
                                        <td>{{ $application->created_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.applicants_detail', ['applicant_id' => $application->application_id]) }}">
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

@include('admin.include.footer');