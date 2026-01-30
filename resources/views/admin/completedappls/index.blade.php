@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')
<style>
    .tab-content {
        padding: 0px 20px;
    }
</style>
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

                    </header>
                </div>
            </div>

            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="statbox widget ">
                        <div class="widget-header applicant_details">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Applicant Id : <span> {{ $applicant->application_id }}</span> Applicant Name : <span style="color:#098501;">{{ $applicant->applicant_name }} </span> 
                                        D.O.B : <span style="color:#098501;">{{ format_date($applicant->d_o_b) }} ({{ $applicant->age }} years old) </span> Applied For : <span style="color:#098501;"> FORM {{ $applicant->form_name }} | License {{ $applicant->license_name }}</span> </h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="tabsSimple" class="col-xl-7 col-6 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    {{-- <h3 class="application_id_css">Application Id :<span style="color:#098501;"> {{ $applicant->application_id }}</span> </h3> --}}
                                    <h4>Edit/View Applicant's Details</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <div class="simple-tab">
                                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Personal Details</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Payment Status</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Check List</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade " id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                        <div class="row mt-3 ">
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <p><strong>Applicant Id:</strong></p>

                                                            <p><strong>Applicant Name:</strong></p>

                                                            <p><strong>Father's Name:</strong></p>

                                                            <p><strong>Address:</strong></p>

                                                            <p><strong>D.O.B & Age:</strong></p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p>{{ $applicant->application_id }}</p>

                                                            <p>{{ $applicant->applicant_name }}</p>

                                                            <p>{{ $applicant->fathers_name }}</p>

                                                            <p>{{ $applicant->applicants_address }}</p>

                                                            <p>{{ $applicant->d_o_b }} ({{ $applicant->age }} years old)</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    @if(isset($uploadedPhoto) && !empty($uploadedPhoto->upload_path))
                                                    <img src="{{ url($uploadedPhoto->upload_path) }}"
                                                        alt="Applicant Photo"
                                                        class="img-fluid rounded" width="150" style="border:1px solid;">
                                                    @else
                                                    <p>No photo available</p>
                                                    @endif
                                                </div>

                                            </div>

                                            <h6 class="mt-2 mb-2 fw-bold text-info">Educational Qualifications</h6>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Degree</th>
                                                            <th>Institution</th>
                                                            <th>Year of Passing</th>
                                                            <th>Percentage</th>
                                                            <th>Documents</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($educationalQualifications as $education)
                                                        <tr>
                                                            <td style="max-width: 10%;">{{ $education->educational_level }}</td>
                                                            <td style="width: 20%;">{{ $education->institute_name }}</td>
                                                            <td style="width: 20%;">{{ $education->year_of_passing }}</td>
                                                            <td style="width: 20%;">{{ $education->percentage }}%</td>
                                                            <td style="text-align:center;">
                                                                @php
                                                                // Find the document where education_serial matches
                                                                $document = DB::table('tnelb_applicants_edu')
                                                                ->where('application_id', $applicant->application_id)
                                                                ->first();
                                                                @endphp

                                                                @if($document && !empty($document->upload_document))
                                                                @php
                                                                // Get file extension
                                                                $fileExtension = pathinfo($document->upload_document ?? 'unknown.pdf', PATHINFO_EXTENSION);
                                                                @endphp

                                                                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                <!-- Show Image -->
                                                                <img src="data:image/{{ $fileExtension }};base64,{{ base64_encode($document->upload_document) }}"
                                                                    alt="Education Document" width="100">
                                                                @elseif($fileExtension === 'pdf')
                                                                <!-- Provide a PDF Download Link -->
                                                                <a href="{{ url($document->upload_document) }}" target="_blank">
                                                                    <i class="fa fa-file-pdf-o" style="font-size:28px;color:red"></i>

                                                                </a>
                                                                @else
                                                                No Documents Uploaded
                                                                @endif
                                                                @else
                                                                No Documents Uploaded
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No educational details available.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            <h6 class="mt-2 mb-2 fw-bold text-info">Work Experience</h6>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Company Name</th>
                                                            <th>Designation</th>
                                                            <th>Years of Experience</th>
                                                            <th>Documents</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($workExperience as $experience)
                                                        <tr>
                                                            <td>{{ $experience->company_name }}</td>
                                                            <td>{{ $experience->designation }}</td>
                                                            <td>{{ $experience->experience }} years</td>
                                                            <td style="text-align:center;">

                                                                @if($experience->upload_document)
                                                                <!-- Show Image -->
                                                                <a href="{{ url($experience->upload_document) }}" target="_blank">
                                                                    <i class="fa fa-file-pdf-o" style="font-size:28px;color:red"></i>
                                                                </a>
                                                                @else
                                                                No Documents Uploaded
                                                                @endif
                                                               
                                                            </td>

                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center">No work experience available.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>

                                                <h6 class="mt-2 mb-2 fw-bold text-info">Electrical Assistant Qualification Certificate</h6>

                                            <div class="row">
                                                <div class="col-lg-6 col-6">
                                                    <p><strong>License Number:</strong></p>
                                                    <p><strong>Date:</strong></p>
                                                </div>

                                                <div class="col-lg-6 col-6">
                                                    @php
                                                        if (empty($applicant->previously_number) || empty($applicant->previously_date)){
                                                            $value = 'No';
                                                        }else{
                                                            $value = 'Yes, '. ($applicant->previously_number ?: '') . ' , ' . (!empty($applicant->previously_date) ? format_date($applicant->previously_date) : '' . '<a href="">view</a>');
                                                        }
                                                        
                                                    @endphp
                                                        
                                                        <p>
                                                            {{ $value }}
                                                        </p>

                                                    {{-- <p>{{ format_date($applicant->previously_date) }}</p> --}}
                                                </div>

                                            </div>

                                            <!-- ----------------------------------------------- -->
                                            <hr>
                                            <h6 class="mt-2 mb-2 fw-bold text-info">Wireman.C.C/Wireman Helper.C.C issued by this Board?</h6>

                                            <div class="row">
                                                <div class="col-lg-6 col-6">
                                                    <p><strong>Wireman License Number:</strong></p>

                                                    {{-- <p><strong>Date:</strong></p> --}}


                                                </div>
                                                <div class="col-lg-6 col-6">
                                                    @php
                                                    if (empty($applicant->certificate_no) || empty($applicant->certificate_date)){
                                                        $cert_no = 'No';
                                                    }else{
                                                        $cert_no = 'Yes, '.($applicant->certificate_no ?: '') . ' , ' . (!empty($applicant->certificate_date) ? format_date($applicant->certificate_date) : '' . '<a href="">view</a>');
                                                    }
                                                    
                                                @endphp

                                                    <p>{{ $cert_no }}</p>
                                                    {{-- <p>{{ $applicant->previously_date }}</p> --}}


                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-lg-6 col-6">
                                                    <p><strong>Aadhaar:</strong></p>

                                                    <p><strong>PAN:</strong></p>
                                                </div>
                                                @php
                                                    $decryptedaadhar = Crypt::decryptString($applicant->aadhaar);
                                                    $decryptedpan = Crypt::decryptString($applicant->pancard);
                                                     $cleanAadhaar = preg_replace('/\D/', '', $decryptedaadhar);

                                                    // Always mask Aadhaar if length >= 4
                                                    if (strlen($cleanAadhaar) >= 4) {
                                                        $masked = str_repeat('X', max(0, strlen($cleanAadhaar) - 4)) . substr($cleanAadhaar, -4);
                                                    } else {
                                                        $masked = 'Invalid Aadhaar';
                                                    }
                                                    $maskedPan = strlen($decryptedpan) === 10 ? str_repeat('X', 6) . substr($decryptedpan, -4) : 'Invalid PAN';
                                                @endphp 
                                                <div class="col-lg-6 col-6">
                                                    <p>{{ $masked }}</p>

                                                    <p>{{ $maskedPan }}</p>
                                                </div>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                        <div class="row mt-3" style="display:none;">
                                            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                                <div class="form-check">
                                                    <input type="checkbox" id="check_all" name="check_all" class="form-check-input">
                                                    <label class="form-check-label" for="check_all">Check All</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                                <div class="form-check">
                                                    <input type="checkbox" id="reset_all" name="reset_all" class="form-check-input">
                                                    <label class="form-check-label" for="reset_all">Reset All</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div id="specific-class" class="col-lg-12">
                                                <div class="form-check">
                                                    <input type="checkbox" checked id="signature_form" name="signature_form" class="form-check-input">
                                                    <label class="form-check-label" for="signature_form">Applicant Signature in Application Form</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="sign_attached" name="sign_attached" class="form-check-input">
                                                    <label class="form-check-label" for="sign_attached">Applicant Sign attached by Officer</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="edu_certificate" name="edu_certificate" class="form-check-input">
                                                    <label class="form-check-label" for="edu_certificate">Educational Qualification Certificate</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="dob_proof" name="dob_proof" class="form-check-input">
                                                    <label class="form-check-label" for="dob_proof">Proof of D.O.B</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="photograph" name="photograph" class="form-check-input">
                                                    <label class="form-check-label" for="photograph">Photograph</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="specimen_signature" name="specimen_signature" class="form-check-input">
                                                    <label class="form-check-label" for="specimen_signature">Specimen Signature</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="fees_details" name="fees_details" class="form-check-input">
                                                    <label class="form-check-label" for="fees_details">Fees Details</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="age_details" name="age_details" class="form-check-input">
                                                    <label class="form-check-label" for="age_details">Age 18</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="experience_details" name="experience_details" class="form-check-input">
                                                    <label class="form-check-label" for="experience_details">Two Years Experience after Degree/Diploma</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="all_doc_verification" name="all_doc_verification" class="form-check-input">
                                                    <label class="form-check-label" for="all_doc_verification">All Documents Filled by Applicant</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="safety_certificate" name="safety_certificate" class="form-check-input">
                                                    <label class="form-check-label" for="safety_certificate">Safety Certificate/ List of Equipment</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="contract_copy" name="contract_copy" class="form-check-input">
                                                    <label class="form-check-label" for="contract_copy">Contract Copy of HT Works</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="ht_experience_cert" name="ht_experience_cert" class="form-check-input">
                                                    <label class="form-check-label" for="ht_experience_cert">HT Experience Certificate in Specimen Format/ Transformer Details</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="experience_in_tamilnadu" name="experience_in_tamilnadu" class="form-check-input">
                                                    <label class="form-check-label" for="experience_in_tamilnadu">Experience in TamilNadu</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="intimation_letter" name="intimation_letter" class="form-check-input">
                                                    <label class="form-check-label" for="intimation_letter">Intimation Letter</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="complete_experience_details" name="complete_experience_details" class="form-check-input">
                                                    <label class="form-check-label" for="complete_experience_details">Complete Experience Details</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" checked id="required_qualification_certificate" name="required_qualification_certificate" class="form-check-input">
                                                    <label class="form-check-label" for="required_qualification_certificate">Required Qualification Certificate</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                        <div class="row mt-3">
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
                                                <p><strong>Amount</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>{{ $applicant->amount }}.00</p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p><strong>Payment mode:</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <P>{{ $applicant->payment_mode??'UPI' }}</P>
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

                <div class="col-xl-5 col-6 layout-spacing">
                   
           

                    <!-- ----------------------------- -->
                    <div id="timelineMinimal" class="col-lg-12 layout-spacing ">
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
                                        <?php
                                        //   var_dump($workflows);die;
                                        ?>
                                        @foreach ($workflows as $row)
                                        <div class="item-timeline">
                                            <p class="t-time">{{ \Carbon\Carbon::parse($user_entry->created_at)->format('d-m-Y H:i:s') }}</p>
                                            
                                            <div class="t-dot 
                                                {{ $row->appl_status == 'RE' ? 't-dot-danger' : ($row->appl_status == 'A' ? 't-dot-success' : 't-dot-info') }}">
                                            </div>
                                            <div class="t-text">
                                                @if ($row->appl_status == 'RE')
                                                    <p>Returned by: {{ $row->processed_by }}</p>
                                                @elseif ($row->appl_status == 'A')
                                                    <p>Approved by: {{ $row->processed_by }}</p>
                                                @else
                                                    <p>Processed by: {{ $row->processed_by }}</p>
                                                @endif
                                        
                                                <p class="t-meta-time">
                                                    @if (!$row->name)
                                                        Approved by: {{ $row->processed_by }}
                                                    @else
                                                        Forwarded to: {{ $row->name }} → Remarks: {{ $row->remarks }}
                                                    @endif
                                                </p>
                                                @if ($row->query_status == "P")
                                                    <p class="text-danger">Note: Query raised by {{ $row->processed_by }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="item-timeline">
                                            <p class="t-time">{{ \Carbon\Carbon::parse($user_entry->created_at)->format('d-m-Y H:i:s') }}</p>
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

            <!-- -------------------------------------------- -->
            <!-- <div class="row">
                
            </div> -->

        </div>
    </div>
</div>
<!-- Confirmation Modal -->
<!-- Alert message for user -->
<div id="alertMessage" class="alert alert-danger" style="display: none;">
    ⚠️ Please make sure all checkboxes are checked before confirming!
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
                        I confirm that all documents have been verified by me as a supervisor.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmForward">Forward to {{ $applicant->status == 'RE' ? 'Secretary': 'Accountant'}}</button>
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

<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
    <div id="queryToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                You have raised a query, so you must select at least one query type.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


@include('admin.include.footer')

<script>
    var switch_status = document.getElementById('Queryswitch');

    if (switch_status.checked) {
        document.getElementById('queryOptions').style.display = 'block';
    } else {
        document.getElementById('queryOptions').style.display = 'none';
    }

    document.getElementById('Queryswitch').addEventListener('change', function() {
        document.getElementById('queryOptions').style.display = this.checked ? 'block' : 'none';
    });


    $('#remarks').maxlength({
        placement: "top"
    });
    $(document).ready(function() {
        var checkAllBox = $('#check_all');
        var resetAllBox = $('#reset_all');
        var forwardbtn = $("#forwardbtn");
        var confirmForward = $("#confirmForward");
        var confirmVerification = $('#confirmVerification');
        // var individualCheckboxes = $('.form-check-input:not(#check_all):not(#reset_all)');
        var individualCheckboxes = $('#specific-class .form-check-input:not(#check_all, #reset_all)');


        // forwardbtn.prop('disabled', $('.form-check-input:not(#check_all):checked').length === 0);

        // Initially disable Reset All
        resetAllBox.prop('disabled', true);

        checkAllBox.change(function() {
            if ($(this).prop('checked')) {
                individualCheckboxes.prop('checked', true);
                resetAllBox.prop('disabled', false).prop('checked', false); // Enable Reset All
                forwardbtn.prop('disabled', false);
            } else {
                individualCheckboxes.prop('checked', false);
                resetAllBox.prop('disabled', true).prop('checked', false); // Disable Reset All
                forwardbtn.prop('disabled', true);
            }
        });

        // "Reset All" functionality
        resetAllBox.change(function() {
            if ($(this).prop('checked')) {
                individualCheckboxes.prop('checked', false);
                checkAllBox.prop('checked', false); // Uncheck Check All
                checkAllBox.prop('disabled', false); // Enable Check All
                resetAllBox.prop('disabled', true); // Disable Reset All after use
                forwardbtn.prop('disabled', true);
            }
        });

        // If any individual checkbox is manually unchecked, uncheck "Check All"
        individualCheckboxes.change(function() {
            if ($('.form-check-input:not(#check_all):not(#reset_all):checked').length === individualCheckboxes.length) {
                checkAllBox.prop('checked', true);
            } else {
                checkAllBox.prop('checked', false);
            }
        });


        confirmForward.click(function() {

            var queryType = [];

            var applicationId = @json($applicant-> application_id);
            var processedBy = @json(Auth::user()->name);
            var role_id = @json(Auth::user()->roles_id);
            var forwardedTo = @json($nextForwardUser->roles_id);
            var role = @json($nextForwardUser->name);
            var remarks = $("#remarks").val().trim();
            
            
            // var queryswitch = $("#Queryswitch").prop("checked");
            var checkboxStatus = "Yes";
            
            let queryswitch = $("#Queryswitch").prop("checked");
            queryType = $("#queryType").val();
            let errorBox = $("#query_error");
            
            errorBox.text(""); // clear previous error

            if (queryswitch && queryType.length === 0) {
                errorBox.text("Please select at least one query type.");
                $('#declarationModal').modal('hide');

                setTimeout(function () {
                    let errorTop = errorBox.offset().top - 100;
                    let currentScroll = $(window).scrollTop();

                    // If current scroll is already below error → scroll up
                    // If current scroll is above error → scroll down
                    $('html, body').animate({ scrollTop: errorTop }, 500);
                }, 300);



                return;
            }

            // console.log(queryswitch);
            // console.log(queryType);
            // return false;

            $.ajax({
                url: '{{ route('admin.forwardApplication',["role" => "__ROLE__"]) }}'.replace('__ROLE__', role),
                type: 'POST',
                // contentType: 'application/json',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                data: {
                    application_id: applicationId,
                    processed_by: processedBy,
                    forwarded_to: forwardedTo,
                    role_id: role_id,
                    remarks: remarks || "No remarks provided",
                    checkboxes: checkboxStatus, // Only "Yes" or "No"
                    queryswitch: queryswitch ? "Yes" : "No", // Only "Yes" or "No"
                    "queryType[]": queryType
                },
                success: function(response) {

                    if (response.status == "success") {
                        // Cleanup Bootstrap modal instance on hide
                        $('#declarationModal').modal('hide');

                        $('#successModal .modal-body').html(`<p>${response.message}</p>`);
                        $('#successModal').modal('show');

                        $('#successModal').on('hidden.bs.modal', function() {
                            window.location.href = BASE_URL +'/admin/get_applications'
                        });
                    }

                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : "An unexpected error occurred.";
                    $('#errorModal .modal-body').html(`<p>${errorMessage}</p>`);
                    $('#errorModal').modal('show');
                }
            });
        });
    });
</script>