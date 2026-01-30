@include('include.header')

<style>
    td {
        font-size: 15px;
    }

    .active_license table th {
        padding: 14 px !important;
    }

    .custom-fieldset {
        border: 1px solid #ccc;
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .custom-legend {
        font-weight: bold;
        font-size: 1rem;
        padding: 0 10px;
        color: #333;
        display: inline-block;
    }

    /* basic positioning */
    .legend {
        list-style: none;
        padding: 0;
        margin: 0 0 1rem 0;
        display: flex;
        justify-content: flex-end;
        gap: 20px;
        flex-wrap: wrap;
        /* wrap on smaller screens */
    }

    .legend li {
        display: flex;
        align-items: center;
        /* align box + text vertically */
        font-size: 14px;
    }

    /* color box */
    .legend span {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 1px solid #ccc;
        margin-right: 6px;
        /* spacing between box and text */
        border-radius: 2px;
        /* optional, softer look */
    }

    .pagination .page-link {
    cursor: pointer;
}
.pagination .active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}


    /* your colors */
    /* .legend .superawesome { background-color: #ff00ff; }
    .legend .awesome      { background-color: #00ffff; }
    .legend .kindaawesome { background-color: #0000ff; }
    .legend .notawesome   { background-color: #000000; } */
</style>
<section class="dashboard-panel">
    <div class="layout-login">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                {{-- <aside class="sidebar-login">
                    <nav>
                        <ul>
                            <li><a href="#" class="active">Dashboard</a></li>

                            <li class="has-submenu">
                                <a href="#">Competency Certificates</a>
                                <ul class="submenu">
                                    <li><a href="{{ route('apply-form-s') }}"> <i class="fa fa-arrow-circle-o-right"></i> Apply for License C [Form S]</a></li>
                <li><a href="{{ route('apply-form-w') }}"> <i class="fa fa-arrow-circle-o-right"></i> Apply For License B [Form W]</a></li>
                <li><a href="{{ route('apply-form-wh') }}"> <i class="fa fa-arrow-circle-o-right"></i> Apply For License WH [Form WH]</a></li>
                </ul>
                </li>

                <li class="has-submenu">
                    <a href="#">Contractor License</a>
                    <ul class="submenu">
                        <li><a href="{{ route('apply-form-a') }}"> <i class="fa fa-arrow-circle-o-right"></i> Apply For License EA [Form A]</a></li>

                    </ul>
                </li>


                </ul>
                </nav>
                </aside> --}}

                @include('include.sidebar')

                <main class="main-content-login">
                    <!-- Tasks and Projects Section -->
                    <section class="tasks-projects-login">


                        <!-- Projects -->
                        <div class="projects-section-login active_license">
                            <h5 class="mb-2"><strong>Active / Present License Details</strong></h5>
                            <div class="project-list-login mt-2">

                                <div class="project-card-login" data-status="en-cours">
                                    @if (!$present_license && !$present_license_ea)
                                    <div class="row">
                                        <div class="col-12">
                                            <p>No Active Licenses</p>
                                        </div>
                                    </div>
                                    @endif

                                    <table class="table table-bordered " width="100%">
                                        <thead class="text-center">
                                            <tr>
                                                <th>License Name</th>
                                                <th>Category</th>
                                                <th>License Number</th>
                                                <th>Issued On</th>
                                                <th>Validity Upto</th>
                                                <th>Status</th>
                                                <th>Reason</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            use Carbon\Carbon;

                                            // Merge both collections
                                            $allLicenses = collect($present_license)->merge($present_license_ea);

                                            $today = Carbon::today();
                                            $licenses = ['C', 'B', 'W', 'WH'];
                                            @endphp

                                            @forelse($allLicenses as $workflow)
                                            @php
                                            $category = in_array($workflow->license_name, $licenses)
                                            ? 'Competency Certificate'
                                            : 'Contractor License';

                                            $issuedDate = $workflow->issued_at ? Carbon::parse($workflow->issued_at)->format('d-m-Y') : 'N/A';
                                            $expiryDate = $workflow->expires_at ? Carbon::parse($workflow->expires_at)->format('d-m-Y') : 'N/A';
                                            $expiry = $workflow->renewal_expires_at ?: $workflow->expires_at;


                                            $isExpired = Carbon::parse($expiry)->lte($today);



                                            $applicant_id = $workflow->application_id;

                                            // Get related records
                                            $banksolvency = \App\Models\Tnelb_banksolvency_a::where('application_id', $applicant_id)
                                            ->where('status', '1')
                                            ->first();

                                            $equipmentlist = \App\Models\Equipment_storetmp_A::where('application_id', $applicant_id)->first();

                                            $staffRecords = DB::table('tnelb_applicant_cl_staffdetails')
                                            ->where('application_id', $applicant_id)
                                            ->where('staff_category','QC')
                                            ->orderBy('id')
                                            ->get();

                                            $expiredStaffDates = [];
                                            if ($staffRecords->count() > 0) {
                                            foreach ($staffRecords as $staff) {
                                            if (!empty($staff->cc_validity)) {
                                            $ccValidity = \Carbon\Carbon::parse($staff->cc_validity);

                                            $CCNumber = $staff->cc_number;
                                            if ($ccValidity->lt($today)) {
                                            $expiredStaffDates[] =[
                                            'number' => $staff->cc_number ?? 'N/A',
                                            'date' => $ccValidity->format('d-m-Y')];
                                            }
                                            }
                                            }
                                            }


                                            // Prepare date comparisons
                                            $bankValidity = !empty($banksolvency?->bank_validity) ? Carbon::parse($banksolvency->bank_validity) : null;


                                            $staffValidity = !empty($staffRecord?->cc_validity) ? Carbon::parse($staffRecord->cc_validity) : null;
                                            @endphp

                                            <tr class="text-center">
                                                <td style="width: 18%;">

                                                @php
                                             $licence_name_present = DB::table('mst_licences')
               
                                            ->where('cert_licence_code', $workflow->license_name)
                                             ->first();
                                                @endphp
                                            {{$licence_name_present->licence_name }} <br>
                                                   [Form {{ $workflow->license_name ?? 'N/A' }}]
                                                    <!-- {{ $applicant_id }} -->
                                                </td>
                                                <td>{{ $category }}</td>
                                                <td>{{ $workflow->license_number }}</td>
                                                <td>{{ $issuedDate }}</td>
                                                <td>{{ $expiryDate }}</td>

                                                <td>
                                                    @php
                                                    $hasBankExpired = $bankValidity && $bankValidity->lt($today);
                                                    $hasStaffExpired = !empty($expiredStaffDates);
                                                    @endphp

                                                    @if($isExpired)
                                                    <span class="badge text-danger text-white">License Expired</span>
                                                    @else
                                                    @if($hasBankExpired || $hasStaffExpired)

                                                    <span class="badge text-danger text-white" style="line-height: 20px;"> License Expired</span>
                                                    @else
                                                    <span class="badge text-success text-white">License Active</span>
                                                    @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($workflow->license_name == 'EA' || $workflow->license_name == 'ESA' || $workflow->license_name == 'ESB' || $workflow->license_name == 'EB' )
                                                    @php
                                                    $hasBankExpired = $bankValidity && $bankValidity->lt($today);
                                                    $hasStaffExpired = !empty($expiredStaffDates);
                                                    @endphp
                                                    @if($isExpired)
                                                    <span class="text-danger" style="font-weight:600; font-size:13px; ">
                                                        License Expired: {{ Carbon::parse($workflow->expires_at)->format('d-m-Y') }}
                                                    </span>
                                                    @else

                                                    @if ($hasBankExpired || $hasStaffExpired)
                                                    <span class="text-danger " style="font-weight:600; font-size:13px; ">
                                                        @if($hasBankExpired)
                                                        Bank Solvency Date Expired on {{ $bankValidity->format('d-m-Y') }}<br>
                                                        @endif

                                                        @if($hasStaffExpired)

                                                        @foreach($expiredStaffDates as $expired)
                                                        QC Staff CC Number: {{ $expired['number'] }} , Date Expired on {{ $expired['date'] }}<br>
                                                        @endforeach
                                                        @endif
                                                    </span>
                                                    @else
                                                    -
                                                    @endif
                                                    @endif
                                                    @else
                                                    -
                                                    @endif

                                                </td>

                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No License Found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>

                        <!-- Tasks -->
                        @if (isset($paginatedData) && $paginatedData->isNotEmpty())

                        <div class="mobile_formview d-block d-sm-none">
                            <h5 class="mb-2"><strong>Status of Applications ( Competency Certificate )</strong></h5>

                            @foreach ($workflows_present as $index => $workflow)
                            <div class="card mb-3 p-3 shadow-sm border rounded">
                                <h6 class="mb-2">
                                    <strong>Application {{ $index + 1 }}</strong>
                                </h6>

                                <p><strong>Form Type:</strong> Form {{ strtoupper($workflow->form_name ?? 'NA') }}</p>
                                <p><strong>Application ID:</strong> {{ $workflow->application_id ?? 'NA' }}</p>
                                <p><strong>Applied On:</strong>
                                    {{ isset($workflow->created_at) ? \Carbon\Carbon::parse($workflow->created_at)->format('d/m/Y') : 'NA' }}
                                </p>

                                <!-- Application Status -->
                                <p><strong>Application Status:</strong>
                                    @if ($workflow->payment_status == 'draft')
                                    @php
                                    $view_page = isset($workflow->appl_type) && $workflow->appl_type == 'R'
                                    ? 'renew_formcc'
                                    : 'edit_application';
                                    @endphp
                                    <a href="{{ route($view_page, ['application_id' => $workflow->application_id]) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-pencil"></i> Draft
                                    </a>
                                    @else
                                    @if ($workflow->appl_type == 'R')
                                    @if ($workflow->status == 'P')
                                    <span class="badge badge-warning">Renewal Form Submitted</span>
                                    @elseif($workflow->status == 'F')
                                    <span class="badge badge-danger">In Progress</span>
                                    @else
                                    <span class="badge badge-success">Completed</span>
                                    @endif
                                    @else
                                    @if ($workflow->status == 'P')
                                    <span class="badge badge-primary">Submitted</span>
                                    @elseif($workflow->status == 'F')
                                    <span class="badge badge-danger">In Progress</span>
                                    @else
                                    <span class="badge badge-success">Completed</span>
                                    @endif
                                    @endif
                                    @endif
                                </p>

                                <!-- Payment Status -->
                                <p><strong>Payment Status:</strong>
                                    @if ($workflow->payment_status == 'payment')
                                    <span class="text-success"><strong>Success</strong></span>
                                    @else
                                    <span class="text-warning">Pending</span>
                                    @endif
                                </p>

                                <!-- Payment Receipt -->
                                <p><strong>Payment Receipt:</strong>
                                    @if ($workflow->payment_status == 'payment')
                                    <a href="{{ route('paymentreceipt.pdf', ['loginId' => $workflow->application_id]) }}" target="_blank">
                                        <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i>
                                    </a>
                                    @else
                                    <span class="text-warning">Pending</span>
                                    @endif
                                </p>

                                <!-- Application Download -->
                                <p><strong>Application Download:</strong>
                                    @if ($workflow->payment_status == 'draft')
                                    <span>-</span>
                                    @else
                                    <a href="{{ route('generate.tamil.pdf', ['login_id' => $workflow->application_id]) }}" target="_blank">
                                        <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> <span style="font-size: small;">தமிழ்</span>
                                    </a>
                                    &nbsp;<br>
                                    <a href="{{ route('generate.pdf', ['login_id' => $workflow->application_id]) }}" target="_blank">
                                        <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> <span style="font-size: small;">English</span>
                                    </a>
                                    @endif
                                </p>

                                <!-- License Status -->
                                <p><strong>License Status:</strong>
                                    <?php //var_dump($workflow->appl_type); 
                                    ?>
                                    @if (!empty($workflow->license_number) && $workflow->status == 'A')
                                    <a href="{{ route('admin.generate.pdf', ['application_id' => $workflow->application_id]) }}" target="_blank">
                                        <span class="badge badge-info" style="font-size: 15px;">{{ $workflow->license_number }}</span>
                                    </a>
                                    @php
                                    $license_details = DB::table('tnelb_application_tbl')
                                    ->where('license_number', $workflow->license_number)
                                    ->first();

                                    $renewed = DB::table('tnelb_renewal_license')
                                    ->where('license_number', $workflow->license_number)
                                    ->first();




                                    @endphp
                                    <br>
                                    @if (isset($renewed) && !empty($renewed))

                                    @elseif (isset($license_details->application_id) && !empty($license_details->application_id))
                                    <strong>Renewal Application</strong><br>
                                    ID: <span class="text-success">{{ $license_details->application_id }}</span>
                                    @endif
                                    @else
                                    @if($workflow->appl_type == 'R')
                                    @php
                                    $renewed1 = DB::table('tnelb_renewal_license')
                                    ->where('application_id', $workflow->application_id)
                                    ->first();
                                    $workflow->renewed_license_number = $renewed1->license_number ?? 'NA';
                                    @endphp
                                    @else
                                    <span class="text-primary">NA</span>
                                    @endif
                                    @endif
                                </p>
                            </div>
                            @endforeach

                        </div>

                        <!-- ----------------- -->
                        <div class="tasks-section-login d-none d-sm-block">
                            <fieldset class="custom-fieldset">
                                <legend class="custom-legend">
                                    <h5 class="mb-2">
                                        <strong>Status of Applications ( Competency Certificate )</strong>
                                    </h5>
                                </legend>
                                <ul class="legend justify-content-end mb-2">
                                    <li><span class="bg-info"></span> Draft</li>
                                    <li><span class="bg-primary"></span> Submitted</li>
                                    
                                    <li><span class="bg-warning"></span> In Progress</li>
                                    <li><span class="bg-success"></span> Completed</li>
                                    <li><span class="bg-danger"></span> Rejected</li>
                                    
                                </ul>
                                <div id="applicationsTable">
                                    @include('user_login.pagination-list')
                                </div>

                                <div id="tablePagination" class="mt-3"></div>
                            </fieldset>
                        </div>
                        @endif

                        <!-- ---------------------------------------------------------- -->
                        @if (isset($workflows_cl) && $workflows_cl->isNotEmpty())
                        <div class="mobile_formview d-block d-sm-none">
                            <h5 class="mb-2"><strong>Status of Applications ( Contractor License )</strong></h5>

                            @if (isset($workflows_cl) && $workflows_cl->isNotEmpty())
                            @foreach ($workflows_cl as $index => $workflow)
                            <div class="card mb-3 p-3 border rounded shadow-sm">
                                <h6 class="mb-2"><strong>Application {{ $index + 1 }}</strong></h6>

                                <p><strong>Form Type:</strong> Form {{ strtoupper($workflow->form_name ?? 'N/A') }}</p>
                                <p><strong>Application ID:</strong> {{ $workflow->application_id ?? 'N/A' }}</p>
                                <p><strong>Applied On:</strong> {{ isset($workflow->created_at) ? \Carbon\Carbon::parse($workflow->created_at)->format('d/m/Y') : 'N/A' }}</p>

                                <!-- Application Status -->
                                <p><strong>Application Status:</strong>
                                    @if ($workflow->payment_status == 'draft')
                                    @if (strtoupper(trim($workflow->appl_type)) === 'N')
                                    <a href="{{ route('apply-form-sa_draft', ['application_id' => $workflow->application_id]) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i> Draft
                                        </button>
                                    </a>
                                    @else
                                    <a href="{{ route('apply-form-a_renewal_draft', ['application_id' => $workflow->application_id]) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i> Draft
                                        </button>
                                    </a>
                                    @endif
                                    @else
                                    @if ($workflow->appl_type == 'R')
                                    @if ($workflow->application_status == 'P')
                                    <span class="badge bg-warning">Renewal Form Submitted</span>
                                    @elseif($workflow->application_status == 'F')
                                    <span class="badge bg-danger">In Progress</span>
                                    @else
                                    <span class="badge bg-success">Completed</span>
                                    @endif
                                    @else
                                    @if ($workflow->application_status == 'P')
                                    <span class="badge bg-primary">Submitted</span>
                                    @elseif($workflow->application_status == 'F')
                                    <span class="badge bg-danger">In Progress</span>
                                    @else
                                    <span class="badge bg-success">Completed</span>
                                    @endif
                                    @endif
                                    @endif
                                </p>

                                <!-- Payment Status -->
                                <p><strong>Payment Status:</strong>
                                    @if ($workflow->payment_status == 'paid')
                                    <p class="text-success"><strong>Success</strong></p>
                                    @else
                                    <span class="text-primary">Pending</span>
                                    @endif
                                </p>

                                <!-- Payment Receipt -->
                                <p><strong>Payment Receipt:</strong>
                                    @if ($workflow->payment_status == 'paid')
                                    <a href="{{ route('paymentreceipt.pdf', ['loginId' => $workflow->application_id]) }}"
                                        target="_blank" title="Download Payment Receipt PDF">
                                        <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i>
                                    </a>
                                    @else
                                    <span class="text-primary">Pending</span>
                                    @endif
                                </p>

                                <!-- Application Download -->
                                <p><strong>Application Download:</strong>
                                    @if ($workflow->payment_status == 'draft')
                                    <span>-</span>
                                    @else
                                    @if(($workflow->form_name == 'A'))
                                    <a href="{{ route('generatea.pdf', ['login_id' => $workflow->application_id]) }}" target="_blank">
                                        <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i>
                                        <span style="font-size: x-small;">English</span>
                                    </a>
                                    @else
                                    <a href="{{ route('generatesa.pdf', ['login_id' => $workflow->application_id]) }}" target="_blank">
                                        <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i>
                                        <span style="font-size: x-small;">English</span>
                                    </a>

                                    @endif
                                    @endif
                                </p>

                                <!-- License Number -->
                                <p><strong>License Number:</strong>
                                    @if (!empty($workflow->license_number) && $workflow->application_status == 'A')
                                    <a href="{{ route('admin.generate.pdf', ['application_id' => $workflow->application_id]) }}" target="_blank">
                                        <span class="badge bg-info" style="font-size: 15px;">
                                            {{ $workflow->license_number }}
                                        </span>
                                    </a>

                                    @php
                                    $license_details = DB::table('tnelb_application_tbl')
                                    ->where('license_number', $workflow->license_number)
                                    ->first();

                                    $new_license_details = DB::table('tnelb_ea_applications')
                                    ->where('license_number', $workflow->license_number)
                                    ->first();

                                    $renewed = DB::table('tnelb_renewal_license')
                                    ->where('license_number', $workflow->license_number)
                                    ->first();
                                    @endphp

                                    <br>
                                    @if (isset($renewed) && !empty($renewed))
                                    {{-- Renewed License Exists --}}
                                    @elseif (isset($license_details->application_id) && !empty($license_details->application_id))
                                    <strong>Renewal Application:</strong>
                                    <span class="text-success">{{ $license_details->application_id }}</span>
                                    @endif
                                    @else
                                    <span class="text-primary">NA</span>
                                    @endif

                                    @if (empty($license_details))
                                    @if (isset($workflow->license_number) && \Carbon\Carbon::parse($workflow->expires_at)->lt(\Carbon\Carbon::now()))
                                    <br>
                                    <a href="{{ route('renew-form_ea', ['application_id' => $workflow->application_id]) }}" class="text-primary">
                                        (Apply for renewal)
                                    </a>
                                    @endif
                                    @endif
                                </p>
                            </div>
                            @endforeach
                            @else
                            <p class="text-danger">No records found</p>
                            @endif

                        </div>


                        <div class="tasks-section-login d-none d-sm-block">
                            <fieldset class="custom-fieldset">
                                <legend class="custom-legend">
                                    <h5 class="mb-2"><strong>Status of Applications ( Contractor Licence )</strong></h5>
                                </legend>
                                <ul class="legend justify-content-end mb-2">
                                    <li><span class="bg-info"></span> Draft</li>
                                    <li><span class="bg-primary"></span> Submitted</li>
                                    
                                    <li><span class="bg-warning"></span> In Progress</li>
                                    <li><span class="bg-success"></span> Completed</li>
                                    <li><span class="bg-danger"></span> Rejected</li>
                                    
                                </ul>
                                <table class="table-login" >
                                     <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Form Type</th>
                                            <th>Application ID</th>
                                            <th>Applied On</th>
                                            <th>Application<br> Status</th>
                                            <th>Payment <br> Status</th>
                                            <th>Payment <br> Receipt</th>
                                            <th>Application<br> Download</th>
                                            <th>Licence Number</th>
                                            <th>Licence<br> Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($workflows_cl) && $workflows_cl->isNotEmpty())
                                        @foreach ($workflows_cl as $index => $workflow)
                                        <?php //var_dump($workflow);die;
                                        ?>
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                             <td style="width: 18%;">
                                              @php
                                             $licence_name_present = DB::table('mst_licences')
               
                                            ->where('form_code', $workflow->form_name)
                                             ->first();
                                                @endphp    
                                                {{ $licence_name_present->licence_name }} <br>
                                            [Form {{ strtoupper($workflow->form_name ?? 'NA') }}]
                                            </td>
                                            <td>{{ $workflow->application_id ?? 'N/A' }}</td>
                                            <td>{{ isset($workflow->dt_submit) ? \Carbon\Carbon::parse($workflow->dt_submit)->format('d/m/Y') : 'N/A' }}
                                            </td>

                                            <!-- Application Status -->
                                            <td>
                                                @if ($workflow->payment_status == 'draft')


                                                @if (strtoupper(trim($workflow->appl_type)) === 'N')

                                                @if($workflow->form_name == 'A')
                                                <a href="{{ route('apply-form-a_draft', ['application_id' => $workflow->application_id]) }}">
                                                    <button class="btn btn-info">
                                                        <i class="fa fa-pencil"></i> Draft
                                                    </button>
                                                </a>
                                                @elseif($workflow->form_name == 'B')
                                                <a href="{{ route('apply-form-b_draft', ['application_id' => $workflow->application_id]) }}">
                                                    <button class="btn btn-info">
                                                        <i class="fa fa-pencil"></i> Draft
                                                    </button>
                                                </a>
                                                @elseif($workflow->form_name == 'SB')
                                                <a href="{{ route('apply-form-sb_draft', ['application_id' => $workflow->application_id]) }}">
                                                    <button class="btn btn-info">
                                                        <i class="fa fa-pencil"></i> Draft
                                                    </button>
                                                </a>
                                                @else
                                                <a href="{{ route('apply-form-sa_draft', ['application_id' => $workflow->application_id]) }}">
                                                    <button class="btn btn-info">
                                                        <i class="fa fa-pencil"></i> Draft
                                                    </button>
                                                </a>

                                                @endif
                                                @else
                                                @if($workflow->form_name == 'A')
                                                <a href="{{ route('renew-form_ea', ['application_id' => $workflow->application_id]) }}">
                                                    <button class="btn btn-info">
                                                        <i class="fa fa-pencil"></i> Draft
                                                    </button>
                                                </a>
                                                @elseif($workflow->form_name == 'B')
                                                <a href="{{ route('renew-form_eb', ['application_id' => $workflow->application_id]) }}">
                                                    <button class="btn btn-info">
                                                        <i class="fa fa-pencil"></i> Draft
                                                    </button>
                                                </a>
                                                @elseif($workflow->form_name == 'SB')
                                                <a href="{{ route('apply-form-sb_renewal_draft', ['application_id' => $workflow->application_id]) }}">
                                                    <button class="btn btn-info">
                                                        <i class="fa fa-pencil"></i> Draft
                                                    </button>
                                                </a>
                                                @else
                                                <a href="{{ route('apply-form-sa_renewal_draft', ['application_id' => $workflow->application_id]) }}">
                                                    <button class="btn btn-info">
                                                        <i class="fa fa-pencil"></i> Draft
                                                    </button>
                                                </a>

                                                @endif

                                                @endif

                                                @else
                                                @if ($workflow->appl_type == 'R')
                                                @if ($workflow->application_status == 'P')
                                                <span class="btn btn-sm btn-primary">Renewal Form
                                                    Submitted</span>
                                                @elseif($workflow->application_status == 'F')
                                                <span class="btn btn-warning">In Progress</span>
                                                @else
                                                <span class="btn btn-sm btn-success">Completed</span>
                                                @endif
                                                @else
                                                @if ($workflow->application_status == 'P')
                                                <span class="btn btn-sm btn-primary">Submitted</span>
                                                @elseif($workflow->application_status == 'F')
                                                <span class="btn btn-warning">In Progress</span>
                                                @else
                                                <span class="btn btn-sm btn-success">Completed</span>
                                                @endif
                                                @endif
                                                @endif
                                            </td>

                                            <!-- Payment Status -->
                                            <td>
                                                @if ($workflow->payment_status == 'paid')
                                                <p class="text-success"><strong>Success</strong></p>
                                                @else
                                                <p class="text-danger">Pending</p>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($workflow->payment_status == 'paid')
                                                <a href="{{ route('paymentreceipt.pdf', ['loginId' => $workflow->application_id]) }}"
                                                    target="_blank" rel="noopener noreferrer"
                                                    title="Download Payment Receipt PDF"
                                                    style="font-weight:500;">
                                                    <i class="fa fa-file-pdf-o"
                                                        style="font-size:20px;color:red"></i>
                                                </a>
                                                @else
                                                <p class="text-danger">Pending</p>
                                                @endif
                                            </td>

                                            <!-- Application Download -->
                                            <td>
                                                @if ($workflow->payment_status == 'draft')
                                                <p>-</p>
                                                @else
                                                @if(($workflow->form_name == 'A'))
                                                <a href="{{ route('generatea.pdf', ['login_id' => $workflow->application_id]) }}"
                                                    target="_blank" style="font-weight:500;">
                                                    <i class="fa fa-file-pdf-o"
                                                        style="font-size:20px;color:red"></i>
                                                    <span style="font-size: x-small;">English</span>
                                                </a>
                                                @elseif(($workflow->form_name == 'SB'))
                                                <a href="{{ route('generatesb.pdf', ['login_id' => $workflow->application_id]) }}"
                                                    target="_blank" style="font-weight:500;">
                                                    <i class="fa fa-file-pdf-o"
                                                        style="font-size:20px;color:red"></i>
                                                    <span style="font-size: x-small;">English</span>
                                                </a>
                                                @elseif(($workflow->form_name == 'B'))
                                                <a href="{{ route('generateb.pdf', ['login_id' => $workflow->application_id]) }}"
                                                    target="_blank" style="font-weight:500;">
                                                    <i class="fa fa-file-pdf-o"
                                                        style="font-size:20px;color:red"></i>
                                                    <span style="font-size: x-small;">English</span>
                                                </a>
                                                @else
                                                <a href="{{ route('generatesa.pdf', ['login_id' => $workflow->application_id]) }}"
                                                    target="_blank" style="font-weight:500;">
                                                    <i class="fa fa-file-pdf-o"
                                                        style="font-size:20px;color:red"></i>
                                                    <span style="font-size: x-small;">English</span>
                                                </a>

                                                @endif
                                                @endif
                                            </td>

                                            <!-- License Number -->

                                            <td>
                                                @if (!empty($workflow->license_number) && $workflow->application_status == 'A')
                                                <a href="{{ route('admin.generateFormcontractor_download.pdf', ['application_id' => $workflow->application_id]) }}" target="_blank">
                                                    <span class="badge badge-info" style="font-size: 15px;">{{ $workflow->license_number }}</span>
                                                </a>
                                                <br>

                                                @if (!empty($workflow->renewals))
                                                <span class="text-muted" style="font-size: 12px;">
                                                    Renewed {{ count($workflow->renewals) }} times
                                                </span>
                                                <br>
                                                @endif


                                                @if (!empty($workflow->renewal_application_id))
                                                <strong>Renewal Application</strong><br>
                                                ID :
                                                <a href="{{ route('generate.pdf', ['login_id' => $workflow->renewal_application_id]) }}"
                                                    target="_blank"
                                                    class="text-success">
                                                    {{ $workflow->renewal_application_id }}
                                                </a>
                                                @else
                                                @if ($workflow->is_under_validity_period)
                                             @if(($workflow->form_name == 'SA'))
                                                        <a href="{{ route('renew-form_esa', ['application_id' => $workflow->application_id]) }}" class="text-primary">
                                                            (Apply for renewal)
                                                        </a>
                                                 @elseif($workflow->form_name == 'SB')
                                                     <a href="{{ route('renew-form_esb', ['application_id' => $workflow->application_id]) }}" class="text-primary">
                                                            (Apply for renewal)
                                                        </a>

                                                   @elseif($workflow->form_name == 'B')
                                                     <a href="{{ route('renew-form_eb', ['application_id' => $workflow->application_id]) }}" class="text-primary">
                                                            (Apply for renewal)
                                                        </a>
                                                    @else

                                                         <a href="{{ route('renew-form_ea', ['application_id' => $workflow->application_id]) }}" class="text-primary">
                                                            (Apply for renewal)
                                                        </a>

                                                    @endif
                                                @endif
                                                @endif
                                                @elseif (!empty($workflow->renewal_application_id))

                                                <strong>Renewal Application</strong><br>
                                                ID :
                                                <span class="text-success">{{ $workflow->renewal_application_id }}</span>
                                                @else
                                                <p class="text-primary">NA</p>
                                                @endif
                                            </td>

                                            <!-- ---------------License download-------- -->
                                             <td>

                                                @if ( $workflow->application_status == 'A')
                                                
                                                <span> <a href="{{ route('admin.generateFormcontractor_download.pdf', ['application_id' => $workflow->application_id]) }}" target="_blank">
                                                        <i class="fa fa-file-pdf-o"
                                                        style="font-size:20px;color:red"></i>
                                                    <span style="font-size: x-small;">English</span> | <a href="{{ route('admin.generateFormcontractor_download_tamil.pdf', ['application_id' => $workflow->application_id]) }}" target="_blank">
                                                         <i class="fa fa-file-pdf-o"
                                                        style="font-size:20px;color:red"></i>
                                                    <span style="font-size: x-small;">தமிழ்</span>
                                                </a>
                                                <br>

                                              


                                               
                                               
                                                @else
                                                <p class="text-primary">NA</p>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="9" class="text-center text-danger">No records found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <div class="table-pagination pt-20"></div>


                        </div>
                        </fieldset>
                        @endif
                    </section>
                </main>
            </div>
        </div>
    </div>
</section>



<footer class="main-footer">
    @include('include.footer')
    @if(session('already_applied'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'warning',
                title: 'You already applied this application!',
                // text: 'Redirecting to dashboard...',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
    @endif
    <script>
        // document.addEventListener("DOMContentLoaded", function () {
        //     const filterSelect = document.getElementById("filter-status-login");

        //     if (!filterSelect) {
        //         console.error("Element #filter-status-login not found in DOM.");
        //         return;
        //     }

        //     filterSelect.addEventListener("change", function(e) {
        //         const filter = e.target.value;

        //         // Filter projects
        //         document.querySelectorAll(".project-card-login").forEach(card => {
        //             if (filter === "all" || card.dataset.status === filter) {
        //                 card.style.display = "block";
        //             } else {
        //                 card.style.display = "none";
        //             }
        //         });

        //         // Filter tasks
        //         document.querySelectorAll(".table-login tbody tr").forEach(row => {
        //             if (filter === "all" || row.dataset.status === filter) {
        //                 row.style.display = "";
        //             } else {
        //                 row.style.display = "none";
        //             }
        //         });
        //     });
        // });
    </script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tables = document.querySelectorAll(".table-login");
    const rowsPerPage = 10;

    tables.forEach((table, tableIndex) => {
        const rows = table.querySelectorAll("tbody tr");
        const paginationContainer = table.nextElementSibling; // .table-pagination div
        let currentPage = 1;

        function displayRows(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? "" : "none";
            });
        }

        function createPagination() {
            const pageCount = Math.ceil(rows.length / rowsPerPage);
            paginationContainer.innerHTML = "";

            if (pageCount <= 1) return;

            let html = `<nav><ul class="pagination justify-content-center">`;
            for (let i = 1; i <= pageCount; i++) {
                html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a href="#" class="page-link" data-page="${i}">${i}</a>
                         </li>`;
            }
            html += `</ul></nav>`;
            paginationContainer.innerHTML = html;

            paginationContainer.querySelectorAll(".page-link").forEach(btn => {
                btn.addEventListener("click", function (e) {
                    e.preventDefault();
                    currentPage = Number(this.dataset.page);
                    displayRows(currentPage);
                    createPagination();
                });
            });
        }

        displayRows(currentPage);
        createPagination();
    });
});
</script>


    <script>
        $(document).ready(function() {
            $(document).on('click', '.clicktopayment', function() {
                console.log('sdfdsf');
            });
        });
    </script>

    <script>
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();

        var url = $(this).attr('href');

        console.log(url);
        return false;

        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                $("#applicationsTable").html(data);
            }
        });
    });
</script>