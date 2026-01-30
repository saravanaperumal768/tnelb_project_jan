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
                <div class="col-xl-12 col-md-12 col-sm-12 col-12 layout-spacing">
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
                <div id="tabsSimple" class="col-xl-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    {{-- <h3 class="application_id_css">Application Id :<span style="color:#098501;"> {{ $applicant->application_id }}</span> </h3> --}}
                                    <h4>Edit / View Applicant's Details</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <div class="simple-tab">
                                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Personal Details</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Payment Status</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Check List</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                        <div class="row mt-3 ">
                                            <div class="row">
                                                <!-- Left Side: Applicant Details -->
                                                <div class="col-md-8">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="fw-bold text-end" style="width: 30%;">Applicant Id:</td>
                                                                    <td>{{ $applicant->application_id }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold text-end">Applicant Name:</td>
                                                                    <td>{{ $applicant->applicant_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold text-end">Father's Name:</td>
                                                                    <td>{{ $applicant->fathers_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold text-end align-top">Address:</td>
                                                                    <td style="white-space: normal; word-break: break-word;">
                                                                        {{ $applicant->applicants_address }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold text-end">D.O.B & Age:</td>
                                                                    <td>{{ $applicant->d_o_b }} ({{ $applicant->age }} years old)</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- Right Side: Applicant Photo -->
                                                <div class="col-md-4 text-center">
                                                    @if(isset($uploadedPhoto) && !empty($uploadedPhoto->upload_path))
                                                        <img src="{{ url($uploadedPhoto->upload_path) }}"
                                                             alt="Applicant Photo"
                                                             class="img-fluid rounded border"
                                                             style="width: 150px; height: 200px; object-fit: cover;">
                                                    @else
                                                        <p class="text-muted">No photo available</p>
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
                                            </div>
                                            <?php //var_dump($applicant->form_name == 'S');die; ?>
                                            @if ($applicant->form_name == 'S')
                                                <h6 class="mt-2 mb-2 fw-bold text-info">Electrical Assistant Qualification Certificate</h6>

                                                <div class="row">
                                                    <div class="col-lg-4 col-6">
                                                        <p><strong>License Number / Date :</strong></p>
                                                        {{-- <p><strong>Date:</strong></p> --}}
                                                    </div>

                                                    <div class="col-lg-8 col-6">
                                                        @php
                                                            if (empty($applicant->previously_number) || empty($applicant->previously_date)){
                                                                $value = 'No';
                                                            }else{
                                                                $value = 'Yes, '.($applicant->previously_number ?: '') . ' , ' . (!empty($applicant->previously_date) ? format_date($applicant->previously_date) : '' . '<a href="">view</a>');
                                                            }
                                                            
                                                        @endphp
                                                            
                                                            <p class="mb-1">
                                                                @if($value === 'No')
                                                                    {{ $value }}
                                                                @else
                                                                    {!! $value !!}
                                                                    
                                                                        @if ($applicant->adminlverify == null)
                                                                            <!-- <span class="badge badge-primary admin_verify" data-license_number="{{ $applicant->previously_number }}" data-license_date="{{ $applicant->previously_date }}" data-type="License" style="cursor: pointer;">Verify</span>                        -->
                                                                        @elseif($applicant->adminlverify == 1)
                                                                            <span class="text-success ms-2">(License Verified.)</span>
                                                                        @elseif($applicant->adminLverify == 2)
                                                                            <span class="text-danger ms-2">(License not Verified.)</span>
                                                                        @endif
                                                                   
                                                                @endif
                                                            </p>

                                                        {{-- <p>{{ format_date($applicant->previously_date) }}</p> --}}
                                                    </div>

                                                </div>                                                                            
                                            @endif


                                            <h6 class="mt-2 mb-2 fw-bold text-info">
                                            @if (in_array($applicant->form_name,['S','W']))
                                                Wireman.C.C /
                                            @endif 
                                            Wireman Helper.C.C issued by this Board?</h6>

                                            <div class="row">
                                                <div class="col-lg-4 col-6">
                                                    <p><strong>License Number / Date:</strong></p>
                                                </div>
                                                <div class="col-lg-8 col-6">
                                                    @php
                                                        // var_dump($staff->name);die;

                                                        if (empty($applicant->certificate_no) || empty($applicant->certificate_date)) {
                                                            $cert_no = 'No';
                                                        } else {
                                                            $cert_no = 'Yes, ' . $applicant->certificate_no . ' , ' . format_date($applicant->certificate_date);
                                                        }
                                                    @endphp
                                                    <p>
                                                        @if($cert_no === 'No')
                                                            {{ $cert_no }}
                                                        @else
                                                            {!! $cert_no !!}
                                                            @php
                                                               // var_dump($applicant->admincverify);die;
                                                            @endphp
                                                            @if ($applicant->admincverify == null)
                                                                <!-- <span class="badge badge-primary admin_verify" data-license_number="{{ $applicant->certificate_no }}" data-license_date="{{ $applicant->certificate_date }}" data-type="certificate" style="cursor: pointer;">Verify</span>                        -->
                                                            @elseif($applicant->admincverify == 1)
                                                                <span class="text-success ms-2">(License verified.)</span>
                                                            @elseif($applicant->admincverify == 2)
                                                                <span class="text-danger ms-2">(License not verified.)</span>
                                                            @endif
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- ----------------------------------------------- -->
                                            <hr>

                                                @php
                                                    $decryptedaadhar    = Crypt::decryptString($applicant->aadhaar);
                                                    $decryptedpan       = Crypt::decryptString($applicant->pancard);
                                                    $masked     = strlen($decryptedaadhar) === 12 ? str_repeat('X', 8) . substr($decryptedaadhar, -4) : 'Invalid Aadhaar';
                                                    $maskedPan  = strlen($decryptedpan) === 10 ? str_repeat('X', 6) . substr($decryptedpan, -4) : 'Invalid PAN';
                                                @endphp 
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold mb-0">Aadhaar:</h6>
                                                        <p class="mb-0">
                                                            {{ $masked }}
                                                            (
                                                            @if(!empty($applicant->aadhaar_doc))
                                                                <a href="{{ route('document.show', ['type' => 'aadhaar', 'filename' => $applicant->aadhaar_doc]) }}" 
                                                                   target="_blank" class="text-primary">
                                                                    <i class="fa fa-file-pdf-o text-danger"></i>
                                                                </a>
                                                            @else
                                                                <span class="text-muted">No documents</span>
                                                            @endif
                                                            )
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold mb-0">PAN:</h6>
                                                        <p class="mb-0">
                                                            {{ $maskedPan }}
                                                            (
                                                            @if(!empty($applicant->pan_doc))
                                                                <a href="{{ route('document.show', ['type' => 'pan', 'filename' => $applicant->pan_doc]) }}" 
                                                                   target="_blank" class="text-primary">
                                                                    <i class="fa fa-file-pdf-o text-danger"></i>
                                                                </a>
                                                            @else
                                                                <span class="text-muted">No documents</span>
                                                            @endif
                                                            )
                                                        </p>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                        <?php //var_dump($workflows->first()->is_verified);die; ?>
                                        @php
                                            $workflow = $workflows?->first();
                                            $isVerified = $workflow?->is_verified == 'Yes';
                                        @endphp

                                        <div class="row mt-3">
                                            <div class="row mt-3">
                                                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                                    <div class="form-check">
                                                        <input type="checkbox" id="check_all" name="check_all" class="form-check-input" @if($isVerified) checked disabled @endif>
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
                                            <div id="specific-class" class="col-lg-12">
                                                @php
                                                    $checkboxes = [
                                                        'signature_form' => 'Applicant Signature in Application Form',
                                                        'sign_attached' => 'Applicant Sign attached by Officer',
                                                        'edu_certificate' => 'Educational Qualification Certificate',
                                                        'dob_proof' => 'Proof of D.O.B',
                                                        'photograph' => 'Photograph',
                                                        'specimen_signature' => 'Specimen Signature',
                                                        'fees_details' => 'Fees Details',
                                                        'age_details' => 'Age 18',
                                                        'experience_details' => 'Two Years Experience after Degree/Diploma',
                                                        'all_doc_verification' => 'All Documents Filled by Applicant',
                                                        'safety_certificate' => 'Safety Certificate/ List of Equipment',
                                                        'contract_copy' => 'Contract Copy of HT Works',
                                                        'ht_experience_cert' => 'HT Experience Certificate in Specimen Format/ Transformer Details',
                                                        'experience_in_tamilnadu' => 'Experience in TamilNadu',
                                                        'intimation_letter' => 'Intimation Letter',
                                                        'complete_experience_details' => 'Complete Experience Details',
                                                        'required_qualification_certificate' => 'Required Qualification Certificate',
                                                    ];
                                                @endphp

                                                @foreach($checkboxes as $id => $label)
                                                    <div class="form-check">
                                                        <input type="checkbox" 
                                                            id="{{ $id }}" 
                                                            name="{{ $id }}" 
                                                            class="form-check-input"
                                                            @if($isVerified) checked disabled @endif>
                                                        <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>

                                    </div>
                                    <?php //var_dump($workflows);die; ?>
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

                    <div id="timelineMinimal" class="col-lg-12 col-md-12 layout-spacing mt-4">
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
                                                {{ in_array($row->appl_status, ['RE', 'RJ']) ? 't-dot-danger' : ($row->appl_status == 'A' ? 't-dot-success' : 't-dot-info') }}">
                                            </div>
                                            <div class="t-text">
                                                @if ($row->appl_status == 'RE')
                                                    <p>Returned by {{ $row->processed_by }}</p>
                                                @elseif ($row->appl_status == 'A')
                                                    <p>Approved by {{ $row->processed_by }}</p>
                                                @elseif ($row->appl_status == 'RJ')
                                                    <p class="text-danger">Rejected by {{ $row->processed_by }}</p>
                                                @else
                                                    <p>Processed by {{ $row->processed_by }}</p>
                                                @endif
                                        
                                                <p class="t-meta-time">
                                                    @if ($row->appl_status == 'RJ')
                                                        Reason: {{ $row->reject_reason }}
                                                    @else
                                                        @if (!$row->name)
                                                            Approved by {{ $row->processed_by }} <br>
                                                            Remarks: {{ $row->remarks }}
                                                        @else
                                                            Forwarded to {{ $row->name }} <br>
                                                            Remarks: {{ $row->remarks }}
                                                        @endif
                                                    @endif
                                                    
                                                </p>
                                                @if ($row->processed_by !== 'Accountant')
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
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="item-timeline">
                                            <p class="t-time">{{ format_date_other($user_entry->created_at) }}</p>
                                            <div class="t-dot t-dot-warning"></div>
                                            <div class="t-text">
                                                <p>Received from Applicant</p>
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

        </div>
    </div>
</div>

@include('admin.include.footer')

<script>

    $(document).ready(function() {

        var checkAllBox = $('#check_all');
        var resetAllBox = $('#reset_all');
        var forwardbtn = $("#forwardbtn");
        var confirmForward = $("#confirmForward");
        var confirmVerification = $('#confirmVerification');
        // var individualCheckboxes = $('.form-check-input:not(#check_all):not(#reset_all)');
        var individualCheckboxes = $('#specific-class .form-check-input:not(#check_all, #reset_all)');

        //forwardbtn
        var approveButton = $('#confirmApprovalBtn');
        var confirmApproval = $('#confirmApproval'); 
        confirmApproval.change(function () {
            approveButton.prop('disabled', !this.checked);
        });


        var checkPresident = $('#confirmPresident');

        confirmForwardPres = $("#confirmForwardPres");

        checkPresident.change(function () {
            confirmForwardPres.prop('disabled', !this.checked);
        });



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

    });
</script>