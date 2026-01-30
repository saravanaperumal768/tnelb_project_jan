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

    tbody td {
        background-color: #ffffff;
    }

    tbody tr:nth-child(even) td {
        background-color: #f1f1f1;
    }

    tbody tr:hover td {
        background-color: #e9ecef;
    }

    .table:not(.dataTable).table-bordered thead tr th{
        border-radius: unset;
    }

    .badgeWH{
        color: #fff;
        background-color: #10298f;
    }
</style>

<div id="content" class="main-content">
    <div class="container">

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
    
                <div class="row layout-top-spacing dashboard">
    
                <h4 class="dashboard_title">Competency Certificate</h4>
                    @foreach($secretary as $form)
      
                @if($form->category_id == '2')
                
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-card-five {{ $formColors[$form->color_code] ?? 'bg-default' }} color_forms">
                            <div class="widget-content">
                                <div class="account-box">
                                    <div class="info-box">
                                        <div class="row">
                                            <div class="col-lg-3 col-3">
                                                <div class="icon">
                                                    <span><i class="fa fa-file-text"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-9">
                                                <div class="balance-info">
                                                    <h6>{{ $form->form_name }}</h6>
                                                    <h5>License {{ $form->color_code }}</h5>
                                                </div>
                                            </div>
                                            <div class="card-bottom-section">
                                                <div class="layout-top-spacing" style="text-align: end">
                                                    <a href="{{ route('admin.view_secratary', ['form_id' => $form->id]) }}" class="" data-form="{{ $form->id }}">
                                                        <h4>on hold <span class="badge badge-warning">0</span></h4>
                                                    </a>
                                                   <a href="{{ route('admin.view_rejected', ['form_id' => $form->id]) }}" class="" data-form="{{ $form->id }}">
                                                        <h4>Rejected <span class="badge badge-danger">{{ $form->rejected_count }}</span></h4>
                                                    </a>   
                                                </div>
                                               <div class="layout-top-spacing" style="text-align: end">
                                                        <!-- Completed Count -->
                                                      <a href="{{ route('admin.secratary_completed', ['form_id' => $form->id]) }}" class="" data-form="{{ $form->id }}">
                                                          <h4>Completed <span class="badge badge-success">{{ $form->completed_count }}</span></h4>
                                                      </a>
        
                                                      <!-- Pending Count -->
                                                      <a href="{{ route('admin.view_secratary', ['form_id' => $form->id]) }}" class="" data-form="{{ $form->id }}">
                                                          <h4>Pending <span class="badge badge-warning">{{ $form->pending_count }}</span></h4>
                                                      </a>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    @endif
                @endforeach
                 
                     <!-- ------------------------------------- -->
                    <h4 class="dashboard_title">Contractor Licenses</h4>
    
                    <!-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-card-five bg-thickgreen color_forms">
                            <div class="widget-content">
                                <div class="account-box">
    
                                    <div class="info-box">
                                        <div class="row">
                                            <div class="col-lg-3 col-3">
                                                <div class="icon">
                                                    <span>
                                                    <i class="fa fa-file-text"></i>
                                                    </span>
                                                </div>
                                            </div>
    
                                            <div class="col-lg-9 col-9">
                                                <div class="balance-info">
                                                    <h6>Form EA</h6>
                                                    <h5>License A</h5>
                                                    
                                                     <a href="{{ route('admin.view_sec_forma_completed') }}"><h4> Completed <span class="badge badge-success">{{ $secForma_counts->completed_count }}</span></h4></a>
                                                     <a href="{{ route('admin.view_sec_forma_pending', 'A')  }}" class=""> <h4> Pending <span class="badge badge-warning">{{ $secForma_counts->pending_count }}</span></h4></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                     <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
                        <!-- color_forms -->
                        <div class="widget widget-card-five bg-thickgreen color_forms" >
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
                                            <h4 onclick="window.location.href='{{ route('admin.view_sec_forma_completed') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $secForma_counts->completed_count }}</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.view_sec_forma_pending', 'A')  }}'" style="cursor: pointer">
                                                Pending <span class="badge badge-warning">{{ $secForma_counts->pending_count }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ------------------------------------------------------------ -->
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
                                            <h4 onclick="window.location.href='{{ route('admin.view_sec_formsa_completed') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $secFormsa_counts->completed_count }}</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.view_sec_formsa_pending') }}'" style="cursor: pointer">
                                                Pending <span class="badge badge-warning">{{ $secFormsa_counts->pending_count }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- --------------------------------------------- -->
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
                                            <h4 onclick="window.location.href='{{ route('admin.view_sec_formsb_completed') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $secFormsb_counts->completed_count }}</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.view_sec_formsb_pending') }}'" style="cursor: pointer">
                                                Pending <span class="badge badge-warning">{{ $secFormsb_counts->pending_count }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                     <!-- --------------------------------------------- -->
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
                                            <h4 onclick="window.location.href='{{ route('admin.view_sec_formb_completed') }}'" style="cursor: pointer"> Completed <span class="badge badge-success">{{ $secFormb_counts->completed_count }}</span></h4>
                                            <h4 onclick="window.location.href='{{ route('admin.view_sec_formb_pending') }}'" style="cursor: pointer">
                                                Pending <span class="badge badge-warning">{{ $secFormb_counts->pending_count }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row layout-top-spacing">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary">
                                <h5 class="mb-0 text-white">Dashboard For Pendancy Report</h5>
                            </div>
                            <div class="card-body">
                                <div class="simple-tab">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Received</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">In Progress</button>
                                        </li>
                                    </ul>
    
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                            <table id="zero-config" class="table dt-table-hover table-striped">
                                            <thead class="text-center">
                                                <th>S.No</th>
                                                <th>Application Type</th>
                                                <th>Application ID</th>
                                                <th>Date of Application</th>
                                                <th>Total No.of.day Pending</th>
                                                <th>Pending With</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i=1;
                                                @endphp
                                                @foreach ($recieved_apps as $row)
                                                <tr>
                                                <td>{{ $i }}</td>
                                                @php
                                                    $badge_class = "badge-secondary"; 
                                                    if ($row->form_name == 'S') {
                                                        $badge_class = "badge-warning";
                                                    }elseif ($row->form_name == 'EA') {
                                                        $badge_class = "badge-success";
                                                    }elseif ($row->form_name == 'W') {
                                                        $badge_class = "badge-danger";
                                                    }elseif ($row->form_name == 'WH') {
                                                        $badge_class = "badge-warning";
                                                    }
                                                @endphp
                                                <td><span class="badge {{ $badge_class }}">FORM {{ $row->form_name }}</span></td>
                                                <td><a href="{{ route('admin.applicants_detail', ['applicant_id' => $row->application_id]) }}">{{ $row->application_id }}</a></td>
                                                <td>{{ format_date_other($row->submitted_at) }}</td>
                                                <td>{{ calculateDaysDifference($row->submitted_at) }} Days</td>
                                                <td>    @if ($row->processed_by == null)
                                                          {{ 'Supervisor' }}
                                                        @elseif ($row->processed_by == "S")
                                                            {{ 'Accountant' }}
                                                        @elseif ($row->processed_by == "A")
                                                            {{ 'Secretary' }}
                                                        @elseif ($row->processed_by == "SE")
                                                            {{ 'President' }}
                                                        @endif
                                                </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                @endforeach
                                            </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                            <table class="table dt-table-hover zero-config table-striped" style="width:100%">
                                                <thead class="text-center">
                                                    <th>S.No</th>
                                                    <th>Application ID</th>
                                                    <th>Application Type</th>
                                                    <th>Date of Apps</th>
                                                    <th>Received from</th>
                                                    <th>Received Date of Apps</th>
                                                    <th>No.of.day Pending</th>
                                                    <th>Total No.of.day</th>
                                                    <th>Pending With</th>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $i=1;
                                                    @endphp
                                                    @foreach ($inprogress as $row)
                                                    <tr>
                                                    <td>{{ $i }}</td>
                                                    @php
                                                        if ($row->form_name == 'S') {
                                                            $badge_class = "badge-warning";
                                                        }elseif ($row->form_name == 'EA') {
                                                            $badge_class = "badge-success";
                                                        }elseif ($row->form_name == 'W') {
                                                            $badge_class = "badge-danger";
                                                        }elseif ($row->form_name == 'WH') {
                                                            $badge_class = "badge-warning";
                                                        }
                                                    @endphp
                                                    <td><a href="{{ route('admin.applicants_detail', ['applicant_id' => $row->application_id]) }}"> {{ $row->application_id }} </a></td>
                                                    <td><span class="badge {{ $badge_class }}"> FORM {{ $row->form_name }} </span></td>
                                                    <td>{{ format_date_other($row->submitted_at) }}</td>

                                                    <td>    @if ($row->processed_by == "S")
                                                        {{ 'Supervisor' }}
                                                      @elseif ($row->processed_by == "A")
                                                          {{ 'Accountant' }}
                                                      @elseif ($row->processed_by == "SE")
                                                          {{ 'Secretary' }}
                                                      @elseif ($row->processed_by == "PR")
                                                          {{ 'President' }}
                                                      @endif
                                                    </td>

                                                    <td>{{ format_date_other($row->updated_at) }}</td>
                                                    <td>{{ calculateDaysDifference($row->updated_at) }} Days</td>
                                                    <td>{{ calculateDaysDifference($row->submitted_at) }} Days</td>
                                                    <td>    @if ($row->processed_by == null)
                                                        {{ 'Supervisor' }}
                                                      @elseif ($row->processed_by == "S")
                                                          {{ 'Accountant' }}
                                                      @elseif ($row->processed_by == "A")
                                                          {{ 'Secretary' }}
                                                      @elseif ($row->processed_by == "SE")
                                                          {{ 'President' }}
                                                      @endif
                                                    </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
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
                {{-- <div class="row layout-top-spacing">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 text-white">Application Logs Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-center align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th rowspan="2">Form Types</th>
                                                <th colspan="3">Supervisor</th>
                                                <th colspan="3">Accountant</th>
                                                <th colspan="3">Secretary</th>
                                            </tr>
                                            <tr>
                                                <th>Pending</th>
                                                <th>In Progress</th>
                                                <th>Completed</th>
                                                <th>Pending</th>
                                                <th>In Progress</th>
                                                <th>Completed</th>
                                                <th>Pending</th>
                                                <th>In Progress</th>
                                                <th>Completed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Sample Row -->
                                            <tr>
                                                <td>Form A</td>
                                                <td>10</td>
                                                <td>5</td>
                                                <td>12</td>
                                                <td>8</td>
                                                <td>3</td>
                                                <td>14</td>
                                                <td>7</td>
                                                <td>4</td>
                                                <td>16</td>
                                            </tr>
                                            <!-- Add more rows dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    @include('admin.include.footer');
</div>
