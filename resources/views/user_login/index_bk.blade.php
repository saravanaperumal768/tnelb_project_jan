@include('include.user_header')

<style>
    td {
        font-size: 15px;
    }
</style>



<main class="main-content-login">
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
                                <p><strong>Validity <span class="text-danger">:
                                            &nbsp;{{ $workflow->validity ?? 'N/A' }}</span></strong></p>
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
                    @if (isset($workflows_present) && $workflows_present->isNotEmpty())
                        @foreach ($workflows_present as $index => $workflow)
                            <?php //var_dump($workflow->expires_at);die;
                            ?>
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>Form {{ strtoupper($workflow->form_name ?? 'N/A') }}</td>
                                <td>{{ $workflow->application_id ?? 'N/A' }}</td>
                                <td>{{ isset($workflow->created_at) ? \Carbon\Carbon::parse($workflow->created_at)->format('d/m/Y') : 'N/A' }}
                                </td>

                                <!-- Application Status -->
                                <td>
                                    @if ($workflow->payment_status == 'draft')
                                        <a
                                            href="{{ route('apply-form', ['form_name' => $workflow->form_name, 'application_id' => $workflow->application_id]) }}">
                                            <button class="btn btn-primary">
                                                <i class="fa fa-pencil"></i> Draft
                                            </button>
                                        </a>
                                    @else
                                        @if ($workflow->status == 'P')
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
                                    @if ($workflow->payment_status == 'payment')
                                        <p class="text-success">Success</p>
                                    @else
                                        <p class="text-warning">Pending</p>
                                    @endif
                                </td>

                                <td>
                                    @if ($workflow->payment_status == 'payment')
                                        <a href="{{ route('paymentreceipt.pdf', ['loginId' => $workflow->application_id]) }}"
                                            target="_blank" rel="noopener noreferrer"
                                            title="Download Payment Receipt PDF" style="font-weight:500;">
                                            <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> Download
                                        </a>
                                    @else
                                        <p class="text-warning">Pending</p>
                                    @endif
                                </td>

                                <!-- Application Download -->
                                <td>
                                    @if ($workflow->payment_status == 'draft')
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
                                        <a href="{{ route('renew-form-s', ['appl_id' => $workflow->application_id]) }}"
                                            class="btn btn-danger btn-sm">
                                            License Expired Renew
                                        </a>
                                    @else
                                        @if (!empty($workflow->license_number) && $workflow->status == 'A')
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
                    @if (isset($workflows_cl) && $workflows_cl->isNotEmpty())
                        @foreach ($workflows_cl as $index => $workflow)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>Form {{ strtoupper($workflow->form_name ?? 'N/A') }}</td>
                                <td>{{ $workflow->application_id ?? 'N/A' }}</td>
                                <td>{{ isset($workflow->created_at) ? \Carbon\Carbon::parse($workflow->created_at)->format('d/m/Y') : 'N/A' }}
                                </td>

                                <!-- Application Status -->
                                <td>
                                    @if ($workflow->payment_status == 'draft')
                                        <a
                                            href="{{ route('apply-form', ['form_name' => $workflow->form_name, 'application_id' => $workflow->application_id]) }}">
                                            <button class="btn btn-primary">
                                                <i class="fa fa-pencil"></i> Draft
                                            </button>
                                        </a>
                                    @else
                                        @if ($workflow->application_status == 'P')
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
                                    @if ($workflow->payment_status == 'paid')
                                        <p class="text-success">Success</p>
                                    @else
                                        <p class="text-warning">Pending</p>
                                    @endif
                                </td>

                                <td>
                                    @if ($workflow->payment_status == 'paid')
                                        <a href="{{ route('paymentreceipt.pdf', ['loginId' => $workflow->application_id]) }}"
                                            target="_blank" rel="noopener noreferrer"
                                            title="Download Payment Receipt PDF" style="font-weight:500;">
                                            <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> Download
                                        </a>
                                    @else
                                        <p class="text-warning">Pending</p>
                                    @endif
                                </td>

                                <!-- Application Download -->
                                <td>
                                    @if ($workflow->payment_status == 'draft')
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
                                    @if (!empty($workflow->license_number))
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
{{-- </div> --}}
</div>
</section>

@include('include.user_footer')
