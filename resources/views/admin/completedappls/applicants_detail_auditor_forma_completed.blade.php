@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Analytics">
                    <header class="header navbar navbar-expand-sm">
                        <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </a>
                        <div class="d-flex breadcrumb-content">
                            <div class="page-header">
                                <div class="page-title"></div>
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

            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="statbox widget ">
                        <div class="widget-header applicant_details">
                            <div class="row">
                                 <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Applicant Id : <span> {{ $applicant->application_id }}</span> Applicant Name : <span style="color:#098501;">{{ $applicant->applicant_name }}</span> Applied For : FORM <span style="color:#098501;"> {{ $applicant->form_name }}</span> License <span style="color:#098501;"> {{ $applicant->license_name }}</span> </h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="tabsSimple" class="col-xl-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        {{-- <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Edit/View Applicant's Details</h4>
                                </div>
                            </div>
                        </div> --}}
                        <div class="widget-content widget-content-area">
                            <div class="simple-tab">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Payment Status</button>
                                    </li>

                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                        <div class="row mt-3 m-1">

                                            <div class="col-lg-6">
                                                <div class="row ">
                                                    <h6 class="fw-bold text-primary">Payment Details</h6>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-lg-6">
                                                        <p><strong> Payment Status</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p class="badge text-success">{{ strtoupper($applicant->payment_status) ?? 'NA' }}</p>
                                                    </div>

                                                   

                                                    <div class="col-lg-6">
                                                        <p><strong>Appication Fees</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        @if($applicant->application_fee > 0)
                                                        <p>{{ $applicant->application_fee }}.00</p>
                                                        @else
                                                        <p>{{ $applicant->amount }}.00</p>
                                                        @endif
                                                    </div>

                                                    @if ($applicant->late_fee > 0)

                                                    <div class="col-lg-6">
                                                        <p><strong>Late fees</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ $applicant->late_fee }}.00</p>
                                                    </div>
                                                    @endif


                                                    <div class="col-lg-6">
                                                        <p><strong>Amount Paid</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ $applicant->amount }}.00</p>
                                                    </div>


                                                 
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row ">
                                                    <h6 class="fw-bold text-primary">Transaction Instruments</h6>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-lg-6">
                                                        <p><strong> Payment Status</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p class="badge text-success">{{ strtoupper($applicant->payment_status) ?? 'NA' }}</p>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <p><strong> Transaction Id</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ $applicant->transaction_id }}</p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p><strong>Amount</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ $applicant->amount }}.00</p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p><strong>Payment mode:</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>UPI</p>
                                                        {{-- <P>{{ $applicant->payment_mode }}</P> --}}
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p><strong> Payment Time</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ format_date_other($applicant->created_at) }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- <div class="modal-footer mt-2">
                            <button class="btn btn-light-dark _effect--ripple waves-effect waves-light  " style="margin-right: 20px;" data-bs-dismiss="modal">Discard</button>
                            <button type="button" class="btn btn-primary _effect--ripple waves-effect waves-light">Save</button>
                        </div> -->
                    </div>

                </div>
                

                <!-- ------------------------------- -->

            </div>

            <!-- -------------------------------------------- -->
            <div class="row ">
                <!-- ----------------------------- -->
                <div id="timelineMinimal " class="col-lg-12 layout-spacing mt-2">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Workflow</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area pb-1">
                            <div class="mt-container mx-auto">
                                <div class="timeline-line">
                                    @foreach ($workflows as $row)
                                    <?php //var_dump($row);die; ?>
                                    <div class="item-timeline">
                                        <p class="t-time">{{ format_date_other($row->created_at) }}</p>
                                        
                                        <div class="t-dot 
                                            {{ $row->appl_status == 'RE' ? 't-dot-danger' : ($row->appl_status == 'A' ? 't-dot-success' : 't-dot-info') }}">
                                        </div>
                                       <div class="t-text">
                                        @if ($row->appl_status == 'RE')
                                            <p>Returned by {{ $row->processed_by }}</p>
                                        @elseif ($row->appl_status == 'A')
                                            <p>Approved by {{ $row->processed_by }}</p>
                                        @else
                                            <p>Processed by {{ $row->processed_by }}</p>
                                        @endif

                                        <p class="t-meta-time">
                                            @if (!$row->name)
                                                Approved by {{ $row->processed_by }}
                                            @else
                                                @php
                                                    $displayName = str_ireplace('auditor', 'accountant', $row->name);
                                                @endphp
                                                Forwarded to {{ $displayName }} <br>
                                                Remarks: {{ $row->remarks }}
                                            @endif
                                        </p>

                                        @if ($row->query_status == "P")
                                            <p class="text-danger">
                                                Note: Query raised by {{ $row->processed_by }} (
                                                @php
                                                    $queries = $row->queries;

                                                    if (is_string($queries)) {
                                                        $queries = json_decode($queries, true);
                                                    }
                                                @endphp
                                                {{ implode(', ', $queries) }}
                                                )
                                            </p>
                                        @endif
                                    </div>

                                    </div>
                                    @endforeach
                                    <div class="item-timeline">
                                        <?php //var_dump($user_entry->created_at);die; ?>
                                        <p class="t-time">{{ format_date_other($user_entry->dt_submit) }}</p>
                                        <div class="t-dot t-dot-warning"></div>
                                        <div class="t-text">
                                            <p>Received from applicant</p>
                                            <p class="t-meta-time">Form: {{ $user_entry->form_name }}, License: {{ $user_entry->license_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="declarationModal" tabindex="-1" aria-labelledby="declarationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declarationModalLabel">Declaration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="confirmVerification">
                    <label class="form-check-label" for="confirmVerification">
                        I acknowledge that the payment has been successfully processed and verified under my audit.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmForward" disabled>Forward to Secretary</button>
            </div>
        </div>
    </div>
</div>
<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('admin.include.footer')
