@include('include.header')

<style>
    td {
        font-size: 15px;
    }
</style>
<section class="dashboard-panel">
    <div class="layout-login">
        <div class="container">
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

                <div class="sidebar sidebar-login">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard</a>
                      </li>
                
                      <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center collapsed" data-toggle="collapse" href="#competencyMenu" role="button" aria-expanded="false" aria-controls="competencyMenu">
                          Competency Certificates
                          <i class="fas fa-chevron-down caret-icon"></i>
                        </a>
                        <div class="collapse" id="competencyMenu">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link" href="{{ route('apply-form-s') }}">Apply for License C [Form S]</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ route('apply-form-w') }}">Apply For License B [Form W]</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ route('apply-form-wh') }}">Apply For License WH [Form WH]</a>
                            </li>
                          </ul>
                        </div>
                      </li>
                
                      <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center collapsed" data-toggle="collapse" href="#contractorMenu" role="button" aria-expanded="false" aria-controls="contractorMenu">
                          Contractor License
                          <i class="fas fa-chevron-down caret-icon"></i>
                        </a>
                        <div class="collapse" id="contractorMenu">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link" href="{{ route('apply-form-a') }}">Apply For License EA [Form A]</a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <li class="nav-item">
                        <a href="{{ previous_licenses }}" class="nav-link d-flex justify-content-between align-items-center">
                            Previous Year (or) Old License Details  
                        </a>
                      </li>
                    </ul>
                </div>



                <main class="main-content-login">
                    @if(Auth::check())
                    <header class="header-login">
                        <h2 class="text-capitalize">Welcome Mr/Ms. {{ Auth::user()->name }}</h2>
                        <!-- <pre>
                        {{ print_r(Auth::user()->toArray(), true) }}
                        </pre> -->
                    </header>

                    @endif

                    <!-- Tasks and Projects Section -->
                    <section class="tasks-projects-login">


                        <!-- Projects -->
                        <div class="projects-section-login">
                            <h5 class="mb-2"><strong>Present License Details</strong></h5>
                            <div class="project-list-login mt-2">

                                <div class="project-card-login" data-status="en-cours">
                                    @php
                                    $allWorkflows = isset($workflows_present, $workflows_cl_present)
                                    ? array_merge($workflows_present->toArray(), $workflows_cl_present->toArray())
                                    : [];
                                    @endphp

                                    @forelse($allWorkflows as $workflow)
                                    <div class="row" style="border: none;">
                                        <div class="col-6 col-lg-4">
                                            <p><strong>License: {{ $workflow->license_name ?? 'N/A' }}</strong></p>
                                        </div>
                                        <div class="col-6 col-lg-4">
                                            <p><strong>Issued On:</strong> {{ $workflow->issued_at ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6 col-lg-4">
                                            <p><strong>Validity <span class="text-danger">: &nbsp;{{ $workflow->validity ?? 'N/A' }}</span></strong></p>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="row">
                                        <div class="col-12">
                                            <p>No License Found</p>
                                        </div>
                                    </div>
                                    @endforelse



                                </div>

                            </div>
                        </div>

                        <!-- Tasks -->
                        <div class="tasks-section-login">
                            <h5 class="mb-2"><strong>Status of Competency Certificate</strong></h5>
                            <table class="table-login">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Form Type</th>
                                        <th>Application ID</th>
                                        <th>Applied On</th>
                                        <th>Application Status</th>
                                        <th>Payment Status</th>
                                        <th>Payment Receipt</th>
                                        <th>Application Download</th>
                                        <th>License Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($workflows_present) && $workflows_present->isNotEmpty())
                                    @foreach($workflows_present as $index => $workflow)
                                    <?php //var_dump($workflow->expires_at);die; ?>
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>Form {{ strtoupper($workflow->form_name ?? 'N/A') }}</td>
                                        <td>{{ $workflow->application_id ?? 'N/A' }}</td>
                                        <td>{{ isset($workflow->created_at) ? \Carbon\Carbon::parse($workflow->created_at)->format('d/m/Y') : 'N/A' }}</td>

                                        <!-- Application Status -->
                                        <td>
                                            @if($workflow->payment_status == 'draft')
                                            <a href="{{ route('apply-form', ['form_name' => $workflow->form_name, 'application_id' => $workflow->application_id]) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i> Draft
                                                </button>
                                            </a>
                                            @else
                                            @if($workflow->status == 'P')
                                            <span class="btn btn-success">
                                                <i class="fa fa-check"></i> Submitted
                                            </span>
                                            @elseif($workflow->status == 'F')
                                            <span class="btn btn-danger">Rejected</span>
                                            @else
                                            <span class="btn btn-info">License Issued</span>
                                            @endif
                                            @endif
                                        </td>

                                        <!-- Payment Status -->
                                        <td>
                                            @if($workflow->payment_status == 'payment')
                                            <p class="text-success">Success</p>
                                            @else
                                            <p class="text-warning">Pending</p>
                                            @endif
                                        </td>

                                        <td>
                                            @if($workflow->payment_status == 'payment')
                                            <a href="{{ route('paymentreceipt.pdf', ['loginId' => $workflow->application_id]) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                title="Download Payment Receipt PDF"
                                                style="font-weight:500;">
                                                <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> Download
                                            </a>

                                            @else
                                            <p class="text-warning">Pending</p>
                                            @endif
                                        </td>

                                        <!-- Application Download -->
                                        <td>
                                            @if($workflow->payment_status == 'draft')
                                            <p>-</p>
                                            @else
                                            <a href="{{ route('generate.tamil.pdf', ['login_id' => $workflow->application_id]) }}"
                                                target="_blank" style="border-right:1px solid #000;font-weight:500;">
                                                <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> தமிழ்
                                            </a>

                                            <a href="{{ route('generate.pdf', ['login_id' => $workflow->application_id]) }}"
                                                target="_blank" style="font-weight:500;">&nbsp;
                                                <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> English
                                            </a>
                                            @endif
                                        </td>

                                        <!-- License Number -->
                                        <td>

                                            @if (isset($workflow->license_number) && \Carbon\Carbon::parse($workflow->expires_at)->lt(\Carbon\Carbon::now()))
                                                <a href="{{route('renew-form-s', ['appl_id' => $workflow->application_id])}}" class="btn btn-danger btn-sm">
                                                    License Expired Renew
                                                </a>
                                            @else
                                                @if(!empty($workflow->license_number) && $workflow->status == 'A')
                                                <p>License Issued <br>
                                                    <span class="badge badge-info" style="font-size: 15px;">
                                                        {{ $workflow->license_number }}
                                                    </span>
                                                </p>
                                                @elseif(empty($workflow->license_number) && $workflow->status == 'F')
                                                <p class="badge badge-danger" style="font-size:14px;">Rejected</p>
                                                @else
                                                <p class="text-danger">Pending</p>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="8" class="text-center text-danger">No records found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>

                        <!-- ---------------------------------------------------------- -->
                        <div class="tasks-section-login">
                            <h5 class="mb-2"><strong>Status of Contractor License</strong></h5>
                            <table class="table-login">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Form Type</th>
                                        <th>Application ID</th>
                                        <th>Applied On</th>
                                        <th>Application Status</th>
                                        <th>Payment Status</th>
                                        <th>Payment Receipt</th>
                                        <th>Application Download</th>
                                        <th>License Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($workflows_cl) && $workflows_cl->isNotEmpty())
                                    @foreach($workflows_cl as $index => $workflow)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>Form {{ strtoupper($workflow->form_name ?? 'N/A') }}</td>
                                        <td>{{ $workflow->application_id ?? 'N/A' }}</td>
                                        <td>{{ isset($workflow->created_at) ? \Carbon\Carbon::parse($workflow->created_at)->format('d/m/Y') : 'N/A' }}</td>

                                        <!-- Application Status -->
                                        <td>
                                            @if($workflow->payment_status == 'draft')
                                            <a href="{{ route('apply-form', ['form_name' => $workflow->form_name, 'application_id' => $workflow->application_id]) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i> Draft
                                                </button>
                                            </a>
                                            @else
                                            @if($workflow->application_status == 'P')
                                            <span class="btn btn-success">
                                                <i class="fa fa-check"></i> Submitted
                                            </span>
                                            @else
                                            <span class="btn btn-info">License Issued</span>
                                            @endif
                                            @endif
                                        </td>

                                        <!-- Payment Status -->
                                        <td>
                                            @if($workflow->payment_status == 'paid')
                                            <p class="text-success">Success</p>
                                            @else
                                            <p class="text-warning">Pending</p>
                                            @endif
                                        </td>

                                        <td>
                                            @if($workflow->payment_status == 'paid')
                                            <a href="{{ route('paymentreceipt.pdf', ['loginId' => $workflow->application_id]) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                title="Download Payment Receipt PDF"
                                                style="font-weight:500;">
                                                <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> Download
                                            </a>

                                            @else
                                            <p class="text-warning">Pending</p>
                                            @endif
                                        </td>

                                        <!-- Application Download -->
                                        <td>
                                            @if($workflow->payment_status == 'draft')
                                            <p>-</p>
                                            @else
                                            <a href="{{ route('generatea.pdf', ['login_id' => $workflow->application_id]) }}"
                                                target="_blank" style="font-weight:500;">
                                                <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> English
                                            </a>
                                            @endif
                                        </td>

                                        <!-- License Number -->
                                        <td>
                                            @if(!empty($workflow->license_number))
                                            <p>License Issued <br>
                                                <span class="badge badge-info" style="font-size: 15px;">
                                                    {{ $workflow->license_number }}
                                                </span>
                                            </p>
                                            @else
                                            <p class="text-danger">Pending</p>
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

                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
</section>



<footer class="main-footer">
    @include('include.footer')

    <script>
        document.getElementById("filter-status-login").addEventListener("change", function(e) {
            const filter = e.target.value;

            // Filter projects
            document.querySelectorAll(".project-card-login").forEach(card => {
                if (filter === "all" || card.dataset.status === filter) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });

            // Filter tasks
            document.querySelectorAll(".table-login tbody tr").forEach(row => {
                if (filter === "all" || row.dataset.status === filter) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.clicktopayment', function () {
                console.log('sdfdsf');
            });
        });

    </script>