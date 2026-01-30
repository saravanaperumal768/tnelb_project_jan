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
                                    <h4>Applicant Id : <span> {{ $applicant->application_id }}</span> Applicant Name : <span style="color:#098501;">{{ $applicant->applicant_name }} </span> D.O.B : <span style="color:#098501;">{{ $applicant->d_o_b }} ({{ $applicant->age }} years old) </span> Applied For : <span style="color:#098501;"> {{ $applicant->form_name }} | License {{ $applicant->license_name }} </span> </h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="tabsSimple" class="col-xl-6 col-6 layout-spacing">
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
                                        <div class="row mt-3 pad-left-10">
                                            <div class="col-lg-6">
                                                <p><strong> Payment Status</strong></p>
                                            </div>

                                            <div class="col-lg-6">
                                                <p class="badge badge-success">{{ strtoupper($applicant->payment_status) }}</p>
                                            </div>

                                            <div class="col-lg-6">
                                                <p><strong> Transaction Id</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>{{ $applicant->transaction_id }}</p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p><strong> Amount</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>{{ $applicant->amount }}.00</p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p><strong>Payment mode:</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <P>UPI</P>
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
                        <!-- <div class="modal-footer mt-2">
                            <button class="btn btn-light-dark _effect--ripple waves-effect waves-light  " style="margin-right: 20px;" data-bs-dismiss="modal">Discard</button>
                            <button type="button" class="btn btn-primary _effect--ripple waves-effect waves-light">Save</button>
                        </div> -->
                    </div>

                </div>
                <div id="tabsSimple" class="col-xl-6 col-6 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Remarks</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2 ">

                                <!-- <label for="Notes " class="text-md-right" style="float: right;"> Notes</label> -->
                            </div>

                            <div class="col-lg-8 col-md-offset-2">
                                <textarea class="form-control" name="remarks" id="remarks" rows="4" cols="50"></textarea>
                            </div>


                        </div>

                        <div class="modal-footer mt-2" style="justify-content: center">
                            <button class="btn btn-success " style="margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#declarationModal">Forward To Secretary</button>
                            {{-- <button class="btn btn-warning " style="margin-right: 20px;" data-bs-dismiss="modal">On Hold</button> --}}
                            {{-- <button type="button" class="btn btn-danger">Reject</button> --}}
                        </div>
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
                                                    Forwarded to {{ $row->name }} <br>
                                                    Remarks: {{ $row->remarks }}
                                                @endif
                                            </p>
                                            <?php// var_dump($row);die; ?>

                                            @if ($row->query_status == "P")
                                                <p class="text-danger">Note: Query raised by {{ $row->processed_by }} (
                                                    @php
                                                    $queries = $row->queries;
                                                
                                                    // If it's a string, decode it
                                                    if (is_string($queries)) {
                                                        $queries = json_decode($queries, true);
                                                    }
                                                @endphp
                                                
                                                @if(!empty($queries) && is_array($queries))
                                                    {{ implode(', ', $queries) }}
                                                @endif
                                                )</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="item-timeline">
                                        <?php //var_dump($user_entry->created_at);die; ?>
                                        <p class="t-time">{{ format_date_other($user_entry->created_at) }}</p>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalElement = document.getElementById('declarationModal');
        var checkbox = document.getElementById('confirmVerification');
        var forwardButton = document.getElementById('confirmForward');
        
        // Ensure button is enabled only when checkbox is checked
        checkbox.addEventListener('change', function() {
            forwardButton.disabled = !this.checked;
        });
        
    });

</script>
<script>
    $(document).ready(function () {
    var confirmVerification = $('#confirmVerification'); // Modal checkbox
    var forwardButton = $('#confirmForward');

    // Enable forward button only when modal checkbox is checked
    confirmVerification.change(function () {
        forwardButton.prop('disabled', !this.checked);
    });

    forwardButton.click(function () {
        var applicationId   = @json($applicant->application_id);
        var processedBy     = @json(Auth::user()->name);
        var role_id         = @json(Auth::user()->roles_id);
        var forwardedTo     = @json($nextForwardUser->roles_id);
        var role            = @json($nextForwardUser->name);
        var remarks         = $("#remarks").val().trim();
        var checkboxStatus  = "Yes";



        $.ajax({
            url: '{{ route('admin.forwardApplication',["role" => "__ROLE__"]) }}'.replace('__ROLE__', role),
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                application_id: applicationId,
                processed_by: processedBy,
                forwarded_to: forwardedTo,
                role_id: role_id,
                remarks: remarks || "No remarks provided",
                checkboxes: checkboxStatus // Only "Yes" or "No"
            },
            success: function (response) {

                if (response.status == "success") {
                    // Cleanup Bootstrap modal instance on hide
                    $('#declarationModal').modal('hide');

                    $('#successModal .modal-body').html(`<p>${response.message}</p>`);
                    $('#successModal').modal('show');
    
                    $('#successModal').on('hidden.bs.modal', function () {
                        window.location.href = '/admin/dashboard'
                    });
                }

            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : "An unexpected error occurred.";
                $('#errorModal .modal-body').html(`<p>${errorMessage}</p>`);
                $('#errorModal').modal('show');
            }
        });
    });

});
</script>