@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')



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

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
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
                                                <!-- <span class="g-dot-success"></span> -->
                                                <!--  <h4> Completed <span class="badge badge-success">20+</span></h4>
                                                <h4> Pending <span class="badge badge-warning">15+</span></h4> -->
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <div class="card-bottom-section" style="float: right;">
                                    {{-- <a href="{{ route('view_applications') }}">View More</a> --}}
                                    <div style="text-align: end;">
                                        <h4 onclick="window.location.href='{{ route('supervisor_view') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $completed }}+</span></h4>
                                        <h4 onclick="window.location.href='{{ route('get_applications') }}'" style="cursor: pointer"> Pending <span class="badge badge-warning">{{ $pendings }}+</span></h4>
                                        <h4 onclick="window.location.href='{{ route('get_applications') }}'" style="cursor: pointer"> On hold <span class="badge badge-warning">+</span></h4>
                                        <h4 onclick="window.location.href='{{ route('get_applications') }}'" style="cursor: pointer"> Rejected <span class="badge badge-warning">+</span></h4>
                                    </div>
                                </div>

                                <!-- <div class="card-bottom-section">

                                    <a href="{{ route('secretary_table')}}" class="">View Pendings</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ---------------------------------- -->


                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing" style="display:none;">
                    <div class="widget-four">
                        <div class="widget-heading">
                            <h5 class="">Visitors by Browser</h5>
                        </div>
                        <div class="widget-content">
                            <div class="vistorsBrowser">
                                <div class="browser-list">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chrome">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <circle cx="12" cy="12" r="4"></circle>
                                            <line x1="21.17" y1="8" x2="12" y2="8"></line>
                                            <line x1="3.95" y1="6.06" x2="8.54" y2="14"></line>
                                            <line x1="10.88" y1="21.94" x2="15.46" y2="14"></line>
                                        </svg>
                                    </div>
                                    <div class="w-browser-details">
                                        <div class="w-browser-info">
                                            <h6>Chrome</h6>
                                            <p class="browser-count">65%</p>
                                        </div>
                                        <div class="w-browser-stats">
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 65%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="browser-list">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-compass">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                                        </svg>
                                    </div>
                                    <div class="w-browser-details">

                                        <div class="w-browser-info">
                                            <h6>Safari</h6>
                                            <p class="browser-count">25%</p>
                                        </div>

                                        <div class="w-browser-stats">
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 35%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="browser-list">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="2" y1="12" x2="22" y2="12"></line>
                                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                        </svg>
                                    </div>
                                    <div class="w-browser-details">

                                        <div class="w-browser-info">
                                            <h6>Others</h6>
                                            <p class="browser-count">15%</p>
                                        </div>

                                        <div class="w-browser-stats">
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>



                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing" style="display: none;">
                    <div class="widget widget-table-one">
                        <div class="widget-heading">
                            <h5 class="">Total Forms Pending</h5>
                            <div class="task-action">
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>

                                    <!-- <div class="dropdown-menu left" aria-labelledby="pendingTask" style="will-change: transform;">
                                                <a class="dropdown-item" href="javascript:void(0);">View Report</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Edit Report</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a>
                                            </div> -->
                                </div>
                            </div>
                        </div>

                        <div class="widget-content">
                            <div class="transactions-list">
                                <div class="t-item">
                                    <div class="t-company-name">
                                        <div class="t-icon">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="t-name">
                                            <h4>Approved By Secretary</h4>
                                            <p class="meta-date">Today</p>
                                        </div>

                                    </div>
                                    <div class="t-rate rate-dec">
                                        <p><span>Waiting</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="transactions-list t-info">
                                <div class="t-item">
                                    <div class="t-company-name">
                                        <div class="t-icon">
                                            <div class="avatar">
                                                <span class="avatar-title">S</span>
                                            </div>
                                        </div>
                                        <div class="t-name">
                                            <h4>Approved By Supervisor 1</h4>
                                            <p class="meta-date">01-02-2025</p>
                                        </div>
                                    </div>
                                    <div class="t-rate rate-inc">
                                        <p><span>Approved It</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="transactions-list">
                                <div class="t-item">
                                    <div class="t-company-name">
                                        <div class="t-icon">
                                            <div class="avatar">
                                                <span class="avatar-title">WH</span>
                                            </div>
                                        </div>
                                        <div class="t-name">
                                            <h4>Approved By Supervisor 2</h4>
                                            <p class="meta-date">31-01-2025</p>
                                        </div>

                                    </div>
                                    <div class="t-rate rate-inc">
                                        <p><span>Pending</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="transactions-list t-secondary">
                                <div class="t-item">
                                    <div class="t-company-name">
                                        <div class="t-icon">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="t-name">
                                            <h4>Approved By Supervisor 3</h4>
                                            <p class="meta-date">30-01-2025</p>
                                        </div>

                                    </div>
                                    <div class="t-rate rate-dec">
                                        <p><span>Approved</span></p>
                                    </div>
                                </div>
                            </div>






                        </div>
                    </div>
                </div>

                <!-- -------------------------------------------------------- -->
                {{-- <div class="row layout-top-spacing">

                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
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
                                    @foreach($applications as $key => $application)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            <a href="{{ route('applicants_detail', ['applicant_id' => $application->application_id]) }}">
                                                {{ $application->application_id }}
                                            </a>
                                        </td>
                                        <td>{{ $application->applicant_name }}</td>
                                        <td>{{ $application->formname_appliedfor }}</td>
                                        <td>{{ $application->license_name }}</td>
                                        <td>{{$application->created_at}}</td>
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

                </div> --}}
            </div>

        </div>

    </div>
</div>

@include('admin.include.footer')
