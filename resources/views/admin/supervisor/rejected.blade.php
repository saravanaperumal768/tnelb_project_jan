@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')

<style>
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
    background-color: #004185 !important;
    color: #ffffff !important;
    text-align: center;
    font-weight: bold;
    padding: 12px;
}
   
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
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

            <div class="row layout-top-spacing">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="seperator-header">
                            <h4 class="">{{ $page_title??'Completed' }} Applications For {{ $workflows->first()->form_name ?? 'N/A' }} (License {{ $workflows->first()->license_name ?? 'N/A' }} )</h4>
                        </div>
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
                                            <th>Applied On</th>
                                            <th>Status</th>
                                            <th>Rejected Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($workflows as $key => $application)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
    
                                            <td>
                                                <a href="{{ route('admin.view_application_details', ['applicant_id' => $application->application_id]) }}">
                                                {{ $application->application_id }}</a>
                                                
                                            </td>
                                            <td>{{ $application->applicant_name }}</td>
                                            {{-- <td>Success</td> --}}
                                            <td>{{ format_date_other($application->created_at) }}</td>
                                            <td>
                                                <span class="badge badge-danger">Rejected</span>
                                            </td>
                                            <td>  
                                                {{ format_date_other($application->updated_at) }}
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
@include('admin.include.footer')