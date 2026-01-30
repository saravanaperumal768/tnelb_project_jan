@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')
<style>
    .layout-spacing table tr th{
       background-color: #333938;
    text-align: center;
    color: #fff;
    }
    .badge-secondary {
    background-color: #524f4f;
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
                <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
                    <h5 class="">Competancy Certificate</h5>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
                    <div class="widget widget-card-five bg-yellow color_forms">
                        <div class="widget-content">
                            <div class="account-box">
                                <div class="info-box">
                                    <div class="row">
                                        <div class="col-lg-3 col-3">
                                            <div class="icon bg-H">
                                                <span>
                                                    <i class="fa fa-file-text"></i>
                                                    <!-- <img src="{{url ('assets/images/icon/doc-icon.png') }}" alt="money-bag"> -->
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-9">
                                            <div class="balance-info">
                                                <h6>Form S</h6>
                                                <p class="text-white">License C</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-bottom-section">
                                    {{-- <a href="{{ route('view_applications') }}">View More</a> --}}
                                    <div style="text-align: start;">
                                        <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> On hold <span class="badge badge-dark">0</span></h4>
                                        <h4 onclick="window.location.href='{{ route('admin.get_rejected') }}'" style="cursor: pointer"> Rejected <span class="badge badge-danger">{{ $rejected_appls }}</span></h4>
                                    </div>
                                    <div style="text-align: end;">
                                        <h4 onclick="window.location.href='{{ route('admin.get_completed') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $completed }}</span></h4>
                                        <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> Pending <span class="badge badge-warning">{{ $pendings }}</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row layout-top-spacing">
                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
                        <h5 class="">Contractor Licence</h5>
                    </div>


                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
                        <div class="widget widget-card-five bg-thickgreen color_forms">
                            <div class="widget-content">
                                <div class="account-box">
                                    <div class="info-box">
                                        <div class="row">
                                            <div class="col-lg-3 col-3">
                                                <div class="icon bg-H">
                                                    <span>
                                                        <i class="fa fa-file-text"></i>
                                                        <!-- <img src="{{url ('assets/images/icon/doc-icon.png') }}" alt="money-bag"> -->
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-9">
                                                <div class="balance-info">
                                                    <h6>Form A</h6>
                                                    <p class="text-white">License EA</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-bottom-section">
                                        <div style="text-align: start;">
                                            <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> On hold <span class="badge badge-dark">0</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> Rejected <span class="badge badge-danger">0</span></h4>
                                        </div>
                                        <div style="text-align: end;">
                                            <h4 onclick="window.location.href='{{ route('admin.completed_forma') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $form_a_completed }}</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.view_form', 'A') }}'" style="cursor: pointer">
                                                Pending <span class="badge badge-warning">{{ $form_a_pending }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- -------------------------------------------------------------------- -->

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
                        <!-- color_forms -->
                        <div class="widget widget-card-five color_forms" style="background-color: #332ec7;">
                            <div class="widget-content">
                                <div class="account-box">
                                    <div class="info-box">
                                        <div class="row">
                                            <div class="col-lg-3 col-3">
                                                <div class="icon bg-H">
                                                    <span>
                                                        <i class="fa fa-file-text"></i>
                                                        <!-- <img src="{{url ('assets/images/icon/doc-icon.png') }}" alt="money-bag"> -->
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-9">
                                                <div class="balance-info">
                                                    <h6>Form SA</h6>
                                                    <p class="text-white">License ESA</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-bottom-section">
                                        <div style="text-align: start;">
                                            <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> On hold <span class="badge badge-dark">0</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> Rejected <span class="badge badge-danger">0</span></h4>
                                        </div>
                                        <div style="text-align: end;">
                                            <h4 onclick="window.location.href='{{ route('admin.completed_formsa') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $formsa_completed }}</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.view_formsa') }}'" style="cursor: pointer">
                                                Pending <span class="badge badge-warning">{{ $formsa_pending }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- ------------------------------------------------------------------------------------ -->

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
                        <!-- color_forms -->
                        <div class="widget widget-card-five color_forms" style="background-color: #423a3a;">
                            <div class="widget-content">
                                <div class="account-box">
                                    <div class="info-box">
                                        <div class="row">
                                            <div class="col-lg-3 col-3">
                                                <div class="icon bg-H">
                                                    <span>
                                                        <i class="fa fa-file-text"></i>
                                                        <!-- <img src="{{url ('assets/images/icon/doc-icon.png') }}" alt="money-bag"> -->
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-9">
                                                <div class="balance-info">
                                                    <h6>Form SB</h6>
                                                    <p class="text-white">License ESB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-bottom-section">
                                        <div style="text-align: start;">
                                            <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> On hold <span class="badge badge-dark">0</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> Rejected <span class="badge badge-danger">0</span></h4>
                                        </div>
                                        <div style="text-align: end;">
                                            <h4 onclick="window.location.href='{{ route('admin.completed_formsb') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $formsb_completed }}</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.view_formsb') }}'" style="cursor: pointer">
                                                Pending <span class="badge badge-warning">{{ $formsb_pending }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- ---------------------------------EB---------------------------- -->

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
                        <!-- color_forms -->
                        <div class="widget widget-card-five color_forms" style="background-color: #4a4848;">
                            <div class="widget-content">
                                <div class="account-box">
                                    <div class="info-box">
                                        <div class="row">
                                            <div class="col-lg-3 col-3">
                                                <div class="icon bg-H">
                                                    <span>
                                                        <i class="fa fa-file-text"></i>
                                                        <!-- <img src="{{url ('assets/images/icon/doc-icon.png') }}" alt="money-bag"> -->
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-9">
                                                <div class="balance-info">
                                                    <h6>Form B</h6>
                                                    <p class="text-white">License EB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-bottom-section">
                                        <div style="text-align: start;">
                                            <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> On hold <span class="badge badge-dark">0</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.get_applications') }}'" style="cursor: pointer"> Rejected <span class="badge badge-danger">0</span></h4>
                                        </div>
                                        <div style="text-align: end;">
                                            <h4 onclick="window.location.href='{{ route('admin.completed_formb') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $formb_completed }}</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.view_formb') }}'" style="cursor: pointer">
                                                Pending <span class="badge badge-warning">{{ $formb_pending }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>





                </div>
                <!-- -----------pending----------------- -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="seperator-header layout-top-spacing">
                            <!-- Form {{ $cc_forms->first()->form_name}} / License {{ $cc_forms->first()->license_name }} [{{ $cc_forms->first()->licence_name }}] -->
                            <h4 class="" style="background-color: #920000;">Pending Applications For Competency Certificate </h4>

                        </div>
                        <div class="statbox widget box box-shadow">
                        
                            <div class="widget-content widget-content-area br-8">
                              

                                <table id="zero-config" class="table dt-table-hover" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Form Type</th>
                                            <th>Application Id</th>
                                             
                                            <th>Applicant's Name</th>
                                            
                                            
                                            
                                            
                                            <th>Applied On</th>
                                            <th class="no-content">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($cc_forms as $key => $application)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td class="" > {{ $application->licence_name }} 
                                                <br>
                                                <span class="badge badge-warning"> [{{ $application->form_name}} / License {{ $application->license_name }}]</span>
                                               
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                    {{ $application->application_id }}
                                                </a>
                                            </td>
                                            <td>{{ $application->applicant_name }}</td>
                                            
                                       
                                            
                                            
                                            <td>{{ \Carbon\Carbon::parse($application->created_at)->format('d-m-Y h:i A') }}</td>
                                            <td>
                                                <a href="{{ route('admin.applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                    <button class="btn btn-primary">
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
                </div>


                <!-- ---------contractor License----------- -->
                 <div class="row">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="seperator-header layout-top-spacing">
                            <!-- Form {{ $cc_forms->first()->form_name}} / License {{ $cc_forms->first()->license_name }} [{{ $cc_forms->first()->licence_name }}] -->
                            <h4 class="" style="background-color: #920000;">Pending Applications For Contractor Certificate </h4>

                        </div>
                        <div class="statbox widget box box-shadow">
                        
                            <div class="widget-content widget-content-area br-8">
                              

                                <table id="zero-config" class="table dt-table-hover" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Form Type</th>
                                            <th>Application Id</th>
                                             
                                            <th>Applicant's Name</th>

                                            
                                            
                                            
                                            
                                            <th>Applied On</th>
                                            <th class="no-content">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($cl_forms as $key => $application)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td class="" > {{ $application->licence_name }} 
                                                <br>
                                               @php
                                                    $badgeClass = match ($application->license_name) {
                                                        'EA'  => 'badge-success',
                                                        'ESA' => 'badge-primary',
                                                        'ESB' => 'badge-secondary',
                                                        'EB' => 'badge-secondary',
                                                        default => 'badge-light text-dark',
                                                    };
                                                @endphp

                                                <span class="badge {{ $badgeClass }}">
                                                    [{{ $application->form_name }} / License {{ $application->license_name }}]
                                                </span>

                                               
                                            </td>

                                            <td>
                                                @if($application->license_name === 'EA')
                                                <a href="{{ route('admin.applicants_detail_forma', ['applicant_id' => $application->application_id]) }}">
                                                    {{ $application->application_id }}
                                                </a>
                                                @elseif($application->license_name === 'ESA')
                                                  <a href="{{ route('admin.applicants_detail_formsa', ['applicant_id' => $application->application_id]) }}">
                                                    {{ $application->application_id }}
                                                </a>
                                                @elseif($application->license_name === 'EB')
                                                 <a href="{{ route('admin.applicants_detail_formb', ['applicant_id' => $application->application_id]) }}">
                                                    {{ $application->application_id }}
                                                </a>
                                                @else
                                                <a href="{{ route('admin.applicants_detail_formsb', ['applicant_id' => $application->application_id]) }}">
                                                    {{ $application->application_id }}
                                                </a>
                                                @endif

                                            </td>
                                            <td>{{ $application->applicant_name }}</td>
                                            {{-- <td>{{ $application->form_name }}</td> --}}
                                            
                                            
                                            <td>{{ \Carbon\Carbon::parse($application->dt_submit)->format('d-m-Y h:i A') }}</td>
                                            <td>

                                             @if($application->license_name === 'EA')
                                                <a href="{{ route('admin.applicants_detail_forma', ['applicant_id' => $application->application_id]) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>
                                                @elseif($application->license_name === 'ESA')
                                                  <a href="{{ route('admin.applicants_detail_formsa', ['applicant_id' => $application->application_id]) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>
                                                @elseif($application->license_name === 'EB')
                                                 <a href="{{ route('admin.applicants_detail_formb', ['applicant_id' => $application->application_id]) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>
                                                @else
                                                <a href="{{ route('admin.applicants_detail_formsb', ['applicant_id' => $application->application_id]) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>
                                                @endif
                                               

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

@include('admin.include.footer');