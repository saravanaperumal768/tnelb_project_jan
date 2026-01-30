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
                <div id="tabsSimple" class="col-xl-7 col-md-12 col-sm-12 col-12 layout-spacing">
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
                                            {{-- <div class="row">
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

                                            </div> --}}

                                            <h6 class="mt-2 mb-2 fw-bold">Educational Qualifications</h6>
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

                                            <h6 class="mt-2 mb-2 fw-bold">Work Experience</h6>
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
                                                @if ($applicant->form_name == 'S')
                                                <h6 class="mt-3 mb-2 fw-semibold text-primary border-bottom pb-1">
                                                    Electrical Assistant Qualification Certificate
                                                </h6>

                                                <div class="row">
                                                    <div class="col-lg-6 col-6">
                                                        <p class="mb-1"><strong>License Number / Date :</strong></p>
                                                    </div>

                                                    <div class="col-lg-6 col-6">
                                                        @php
                                                            if (empty($applicant->previously_number) || empty($applicant->previously_date)) {
                                                                $value = 'No';
                                                            } else {
                                                                $value = 'Yes, ' .($applicant->previously_number ?: '') . ' , ' .
                                                                         (!empty($applicant->previously_date) ? format_date($applicant->previously_date) : '');
                                                            }

                                                        @endphp

                                                        <p class="mb-1">
                                                            @if($value === 'No')
                                                                {{ $value }}
                                                            @else
                                                                {!! $value !!}
                                                                
                                                                     @if ($applicant->adminlverify == null)
                                                                            <span class="badge badge-primary admin_verify" data-license_number="{{ $applicant->previously_number }}" data-license_date="{{ $applicant->previously_date }}" data-type="License" style="cursor: pointer;">Verify</span>                       
                                                                        @elseif($applicant->adminlverify == 1)
                                                                            <span class="text-success ms-2">(Valid License.)</span>
                                                                        @elseif($applicant->adminlverify == 2)
                                                                            <span class="text-danger ms-2">(Invalid License.)</span>
                                                                        @endif                
                                                               
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif


                                            <h6 class="mt-3 mb-2 fw-semibold text-primary border-bottom pb-1">
                                                @if (in_array($applicant->form_name,['S','W']))
                                                    Wireman C.C /
                                                @endif 
                                                Wireman Helper C.C issued by this Board?
                                            </h6>

                                            <div class="row">
                                                <div class="col-lg-6 col-6">
                                                    <p class="mb-1"><strong>Wireman License Number / Date:</strong></p>
                                                </div>

                                                <div class="col-lg-6 col-6">
                                                    @php
                                                        if (empty($applicant->certificate_no) || empty($applicant->certificate_date)) {
                                                            $cert_no = 'No';
                                                        } else {
                                                            $cert_no = 'Yes, ' . $applicant->certificate_no . ' , ' . format_date($applicant->certificate_date);
                                                        }
                                                    @endphp
                                                
                                                    <p class="mb-1">
                                                        @if($cert_no === 'No')
                                                            {{ $cert_no }}
                                                        @else
                                                            {!! $cert_no !!}

                                                            @php
                                                                //var_dump($applicant);die;
                                                            @endphp
                                                            @if ($applicant->admincverify == null)
                                                                <span class="badge badge-primary admin_verify" data-license_number="{{ $applicant->certificate_no }}" data-license_date="{{ $applicant->certificate_date }}" data-type="certificate" style="cursor: pointer;">Verify</span>                       
                                                            @elseif($applicant->admincverify == 1)
                                                                <span class="text-success ms-2">(Valid License.)</span>
                                                            @elseif($applicant->admincverify == 2)
                                                                <span class="text-danger ms-2">(Invalid License.)</span>
                                                            @endif
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- ----------------------------------------------- -->
                                            <hr>
                                            @php
                                                $decryptedaadhar = Crypt::decryptString($applicant->aadhaar);
                                                $decryptedpan    = Crypt::decryptString($applicant->pancard);
                                                $masked          = strlen($decryptedaadhar) === 12 ? str_repeat('X', 8) . substr($decryptedaadhar, -4) : 'Invalid Aadhaar';
                                                $maskedPan       = strlen($decryptedpan) === 10 ? str_repeat('X', 6) . substr($decryptedpan, -4) : 'Invalid PAN';

                                            @endphp

                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold mb-0">Aadhaar:</h6>
                                                    <p class="mb-0">
                                                        {{ $masked }}
                                                        (<a href="{{ route('document.show', ['type' => 'aadhaar', 'filename' => $applicant->aadhaar_doc]) }}" target="_blank" class="text-primary">
                                                            <i class="fa fa-file-pdf-o text-danger"></i>
                                                        </a>)
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold mb-0">PAN:</h6>
                                                    <p class="mb-0">
                                                        {{ $maskedPan }}
                                                        (<a href="{{ route('document.show', ['type' => 'pan', 'filename' => $applicant->pan_doc]) }}" target="_blank" class="text-primary">
                                                            <i class="fa fa-file-pdf-o text-danger"></i>
                                                        </a>)
                                                    </p>
                                                </div>
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
                                        <div class="row text-center fw-bold border-bottom pb-2 mb-3 mt-3">
                                            <div class="col-lg-6 text-primary">
                                                Payment Details
                                            </div>
                                            <div class="col-lg-6 text-primary">
                                                Transaction Details
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-6">
                                                <div class="row mt-3">
                                                    <div class="col-lg-6">
                                                        <p><strong>Application Type</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ $applicant->appl_type == 'R'?'Renewal Application':'New Application' }}</p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p><strong>Application Fees</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ $applicant->amount }}.00</p>
                                                    </div>
                                                    @if (!empty($applicant->late_fees))
                                                        <div class="col-lg-6">
                                                            <p><strong>Late Fees({{ $applicant->late_months }} Months)</strong></p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p>Rs.{{ $applicant->late_fees }}.00</p>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-6">
                                                        <p><strong> Date of application</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ format_date($applicant->transaction_date) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
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
                                                        <p>{{ format_date($applicant->transaction_date) }}</p>
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

                    <div class="col-xl-5 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow mb-2">
                            <div class="row align-items-center">

                                <div class="col-lg-12">
                                    {{-- <div class="form-check form-switch">
                                        <label class="form-check-label fw-bold text-end" for="flexSwitchCheckDefault">If you have any queries</label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="Queryswitch">
                                    </div> --}}
                                    <div class="switch-wrapper d-flex justify-content-between align-items-center">
                                        <label class="switch-label mb-0 fw-bold text-end" for="Queryswitch">If you have any queries</label>
                                        <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                            <div class="input-checkbox">
                                                <span class="switch-chk-label label-left">Yes</span>
                                                <input class="switch-input" type="checkbox" id="Queryswitch" role="switch">
                                                <span class="switch-chk-label label-right">No</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-shadow" id="queryOptions" style="display: none;">
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                       <div class="form-group">
                                         
                                            {{-- <label class="fw-bold">Select Query Type:</label> --}}
                                            <select class="form-control" id="queryType" name="queryType[]" multiple>
                                                <option value="general">General Query</option>
                                                <option value="technical">Technical Query</option>
                                                <option value="other">Other</option>
                                            </select>

                                            <span id="query_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="statbox widget box box-shadow">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <div class="widget-header">
                                        <h4>Remarks</h4>
                                        </div>
                                    </div>
                                </div>
                        
                            <div class="row">
                                <div class="col-lg-12 col-md-offset-2">
                                    <textarea class="form-control placement-top" id="remarks" name="remarks" rows="4" cols="50" maxlength="250"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer mt-2" style="justify-content: center;">

                                @php
                                $role = Auth::user()->name; // Current role name
                                $workflow = [
                                    'Supervisor' => $applicant->status == 'RE'? 'Secretary' : 'Accountant',
                                    'Supervisor2' => $applicant->status == 'RE'? 'Secretary' : 'Accountant',
                                    'Accountant' => 'Secretary',
                                    'Secretary'  => 'President',
                                    'President'  => null, // last step
                                ];

                                @endphp

                                @if ($role == 'Supervisor' || $role == 'Supervisor2')
                                    {{-- Forward to Accountant --}}
                                    <button class="btn btn-success" id="forwardbtn" {{ $isVerified == 'Yes'? '' : 'disabled' }} >
                                        Forward to {{ $workflow[$role] }}
                                    </button>
                                    <button class="btn btn-warning">On Hold</button>

                                @elseif ($role == 'Accountant')
                                    {{-- Forward to Secretary --}}
                                    <button class="btn btn-success" id="forwardbtn" data-bs-toggle="modal" data-bs-target="#declarationModal">
                                        Forward to {{ $workflow[$role] }}
                                    </button>
                                    <button class="btn btn-warning">On Hold</button>

                                @elseif ($role == 'Secretary')

                                    @if ($applicant->form_name !== 'S')
                                        <button class="btn btn-success" id="confirmApprovalBtn">
                                            Submit / Approve
                                        </button>
                                    @else
                                        <button class="btn btn-success" id="confirmForwardPres">
                                            Forward to {{ $workflow[$role] }}
                                        </button>
                                    @endif

                                    <button id="confirmReturnBtn" class="btn btn-warning">
                                        Return to Supervisor
                                    </button>
                                    <button class="btn btn-danger reject_application" data-bs-toggle="modal" data-bs-target="#rejectionModal">Reject</button>

                                @elseif ($role == 'President')
                                    <button class="btn btn-success" id="confirmApprovalBtn">
                                        Submit / Approve
                                    </button>
                                    <button id="confirmReturnBtn" class="btn btn-warning">
                                        Return to Supervisor
                                    </button>
                                    <!-- <button id="returntoSecretary" class="btn btn-warning">
                                        Return to Secretary
                                    </button> -->
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectionModal">Reject</button>
                                @endif

                            </div>
                    </div>
                    <!-- ----------------------------- -->
                        <div id="timelineMinimal" class="col-lg-12 layout-spacing mt-4">
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
                                                                Approved by {{ $row->processed_by }}
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

<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approvalModalLabel">Approval Declaration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="confirmApproval">
                    <label class="form-check-label" for="confirmApproval">
                        I confirm that this application has been reviewed and approved.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmApprovalBtn" disabled>Approve Application</button>
            </div>
        </div>
    </div>
</div>



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
            <div class="modal-body">
                <p class="returnMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="finalsuccessModal" tabindex="-1" aria-labelledby="finalsuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="finalsuccessModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p id="message"></p>
                <p><strong>License Number:</strong> <span id="licenseNumber"></span></p>
                <a class="badge badge-primary" href="{{ route('admin.generate.pdf', ['application_id' => $applicant->application_id]) }}" style="color: #fff;" target="_blank">
                    <i class="fa fa-eye"></i> View
                </a>
                {{-- <p><strong>License Expiry:</strong> <span id="licenseExpiry"></span></p> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
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


<div class="modal fade" id="forwardmodal" tabindex="-1" aria-labelledby="declarationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declarationModalLabel">Declaration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="confirmPresident">
                    <label class="form-check-label" for="confirmApproval">
                        I confirm that have been verified by me as a secretary.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmForwardPres" disabled>Forward to President</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successModalForward" tabindex="-1" aria-hidden="true">
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


<!-- Confirmation Modal -->
<div class="modal fade" id="returnConfirmModal" tabindex="-1" aria-labelledby="returnConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-dark">
          <h5 class="modal-title" id="returnConfirmModalLabel">Are you sure?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          You want to return this!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="confirmReturnBtn" class="btn btn-primary">Yes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Confirmation Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectionModalLabel">Are sure want to Reject..!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <svg> ... </svg>
                </button>
            </div>
            <form id="reject_application">
                <div class="modal-body">
                    <!-- Radio 1 + Dropdown -->
                    <div class="form-check form-check-primary">
                        <input class="form-check-input reason-option" type="radio" name="radio-reason" id="radio-select" value="select" checked>
                        <label class="form-check-label" for="radio-select">
                            Reason
                        </label>
                
                        <!-- Dropdown -->
                        <select class="form-select mt-2 reason-select" name="rejection_reason">
                            <option value="">-- Select Reason --</option>
                            <option value="Incomplete application">Incomplete application</option>
                            <option value="Invalid information">Invalid information</option>
                            <option value="Eligibility criteria not met">Eligibility criteria not met</option>
                            <option value="Supporting documents not clear">Supporting documents not clear</option>
                            <option value="Duplicate application">Duplicate application</option>
                            <option value="Submission deadline missed">Submission deadline missed</option>
                            <option value="Policy violation">Policy violation</option>
                            <option value="Fraudulent / Misleading information">Fraudulent / Misleading information</option>
                        </select>
                        <div class="invalid-feedback reason-select-error"></div>
                    </div>
                
                    <!-- Radio 2 + Textarea -->
                    <div class="form-check form-check-primary mt-3">
                        <input class="form-check-input reason-option" type="radio" name="radio-reason" id="radio-other" value="other">
                        <label class="form-check-label" for="radio-other">
                            Other reason
                        </label>
                    </div>
                    <div class="form-group mb-4 reason-textarea" style="display:none;">
                        <textarea class="form-control other_reason" name="other_reason" rows="3" placeholder="Enter other reason"></textarea>
                        <div class="invalid-feedback reason-textarea-error"></div>
                    </div>
                    <input type="hidden" name="action_by" id="action_by" value="{{ $staff->name }}">
                    <input type="hidden" name="login_id" id="login_id" value="{{ $staff->id }}">
                    <input type="hidden" name="application_id" id="application_id" value="{{ $applicant->application_id }}">
                    <input type="hidden" name="appl_status" id="appl_status" value="RJ">
                </div>
                <div class="modal-footer">
                    <button class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

@php
    // var_dump($nextForwardUser);die;
@endphp


@include('admin.include.footer')

<script>

    var switch_status = document.getElementById('Queryswitch');
    var queryDropdown = document.getElementById('queryType');

    function toggleQueryOptions() {
        if (switch_status.checked) {
            document.getElementById('queryOptions').style.display = 'block';
        } else {
            document.getElementById('queryOptions').style.display = 'none';
            
            // Clear all selections (works for multi-select)
            for (let i = 0; i < queryDropdown.options.length; i++) {
                queryDropdown.options[i].selected = false;
            }

            // If using jQuery plugins like Select2 / Bootstrap-select, refresh UI too
            if ($(queryDropdown).hasClass("select2-hidden-accessible")) {
                $(queryDropdown).val(null).trigger("change"); // Select2 reset
            }
        }
    }

    // Run on load
    toggleQueryOptions();

    // Run on change
    switch_status.addEventListener('change', toggleQueryOptions);

    // var switch_status = document.getElementById('Queryswitch');
    // var queryDropdown = document.getElementById('queryType');

    // if (switch_status.checked) {
    //     document.getElementById('queryOptions').style.display = 'block';
    // } else {
    //     document.getElementById('queryOptions').style.display = 'none';
    //     queryDropdown.selectedIndex = 0; // reset dropdown
    // }



    // var switch_status = document.getElementById('Queryswitch');
    // var queryDropdown = $('#queryType');

    // if (switch_status.checked) {
    //     $('#queryOptions').show();
    // } else {
    //     $('#queryOptions').hide();
    //     queryDropdown.val([]).trigger('change'); // clear all selected options
    // }

    // document.getElementById('Queryswitch').addEventListener('change', function() {
    //     document.getElementById('queryOptions').style.display = this.checked ? 'block' : 'none';
    // });


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
        

        


        approveButton.click(function () {
            var applicationId = @json($applicant->application_id);
            var processedBy = @json(Auth::user()->name);
            var remarks = $("#remarks").val().trim();


            Swal.fire({
                title: "Declaration",
                // html: `
                //     <div class="form-check text-start">
                //         <label class="form-check-label" for="confirmVerification">
                //             I confirm that this application has been reviewed and approved.
                //         </label>
                //     </div>
                // `,
                text: 'Confirm to this application has been reviewed and approved.',
                showCancelButton: true,
                confirmButtonText: "Approved",
                cancelButtonText: "Cancel",
                focusConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.approveApplication') }}',
                        type: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        data: {
                            application_id: applicationId,
                            processed_by: processedBy,
                            remarks: remarks || "No remarks provided",
                        },
                        success: function (response) {

                            if (response.status == "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    html: `
                                        <p>${response.message}</p>
                                        <p><b>License Number:</b> ${response.license_number}</p>
                                    `,
                                    confirmButtonText: "OK",
                                    allowOutsideClick: false
                                }).then(() => {
                                    window.location.href = "{{ url('admin/dashboard') }}";
                                });
                            }
                            // $('#licenseExpiry').text(response.license_expiry);
                        },
                        error: function (xhr) {
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : "An unexpected error occurred.";
                            $('#errorMessage').text(errorMessage);
                            $('#errorModal').modal('show');
                        }
                    });
                }
            });

        });


        confirmForwardPres.click(function () {
            var applicationId   = @json($applicant->application_id);
            var role_id         = @json(Auth::user()->roles_id);
            var forwardedTo     = @json($nextForwardUser->roles_id);
            var processedBy     = @json(Auth::user()->name);
            var role            = @json($nextForwardUser->name);
            var remarks         = $("#remarks").val().trim();
            var queryswitch     = $("#Queryswitch").prop("checked");
            var checkboxStatus  = "Yes";

            var queryType = null;
            var query_status = "No";

            
            if (queryswitch) {
                queryType = $("#queryType").val() || null;
                query_status = 'Yes';
            }

            Swal.fire({
                title: "Declaration",
                // html: `
                //     <div class="form-check text-start">
                //         <label class="form-check-label" for="confirmVerification">
                //             I confirm that have been verified by me as a secretary.
                //         </label>
                //     </div>
                // `,
                text:'I confirm that have been verified by me as a secretary.',
                showCancelButton: true,
                confirmButtonText: "Forward to President",
                cancelButtonText: "Cancel",
                focusConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    
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
                            checkboxes: checkboxStatus, // Only "Yes" or "No"
                            queryswitch: query_status, // Only "Yes" or "No"
                            "queryType[]": queryType 
                        },
                        success: function (response) {

                            if (response.status == "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: response.message,
                                    confirmButtonText: "OK",
                                    allowOutsideClick: false
                                }).then(() => {
                                    window.location.href = "{{ url('admin/dashboard') }}";
                                });
                            }

                        },
                        error: function (xhr) {
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.error
                                ? xhr.responseJSON.error
                                : "An unexpected error occurred.";
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: errorMessage
                            });
                        }
                    });
                }
            });
    
        });




        forwardbtn.click(function() {
            Swal.fire({
                title: "Declaration",
                text: 'I confirm that all documents have been verified by me as a supervisor.',
                showCancelButton: true,
                confirmButtonText: "Forward to {{ $applicant->status == 'RE' ? 'Secretary' : 'Accountant' }}",
                cancelButtonText: "Cancel",
                focusConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    // your existing ajax code

                    var queryType = [];

                    var applicationId = @json($applicant->application_id);
                    var processedBy = @json(Auth::user()->name);
                    var role_id = @json(Auth::user()->roles_id);
                    var forwardedTo = @json($nextForwardUser->roles_id);

                    // console.log(forwardedTo);
                    // return false;

                    var role = @json($nextForwardUser->name);
                    var remarks = $("#remarks").val().trim();

                    var checkboxStatus = "Yes";
                    let queryswitch = $("#Queryswitch").prop("checked");
                    queryType = $("#queryType").val();
                    let errorBox = $("#query_error");

                    errorBox.text(""); // clear previous error

                    if (queryswitch && queryType.length === 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Please select at least one query type."
                        });
                        return;
                    }

                    $.ajax({
                        url: '{{ route('admin.forwardApplication',["role" => "__ROLE__"]) }}'.replace('__ROLE__', role),
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        data: {
                            application_id: applicationId,
                            processed_by: processedBy,
                            forwarded_to: forwardedTo,
                            role_id: role_id,
                            remarks: remarks || "No remarks provided",
                            checkboxes: checkboxStatus,
                            queryswitch: queryswitch ? "Yes" : "No",
                            "queryType[]": queryType
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: response.message,
                                    confirmButtonText: "OK",
                                    allowOutsideClick: false
                                }).then(() => {
                                    window.location.href = "{{ url('admin/dashboard') }}";
                                });
                            }
                        },
                        error: function (xhr) {
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.error
                                ? xhr.responseJSON.error
                                : "An unexpected error occurred.";
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: errorMessage
                            });
                        }
                    });
                }
            });
        });
        // confirmForward.click(function() {

        //     var queryType = [];

        //     var applicationId = @json($applicant-> application_id);
        //     var processedBy = @json(Auth::user()->name);
        //     var role_id = @json(Auth::user()->roles_id);
        //     var forwardedTo = @json($nextForwardUser->roles_id);
        //     var role = @json($nextForwardUser->name);
        //     var remarks = $("#remarks").val().trim();

        //     var checkboxStatus = "Yes";
            
        //     let queryswitch = $("#Queryswitch").prop("checked");
        //     queryType = $("#queryType").val();
        //     let errorBox = $("#query_error");
            
        //     errorBox.text(""); // clear previous error

        //     if (queryswitch && queryType.length === 0) {
        //         errorBox.text("Please select at least one query type.");
        //         $('#declarationModal').modal('hide');

        //         setTimeout(function () {
        //             let errorTop = errorBox.offset().top - 100;
        //             let currentScroll = $(window).scrollTop();

        //             $('html, body').animate({ scrollTop: errorTop }, 500);
        //         }, 300);

        //         return;
        //     }

        //     $.ajax({
        //         url: '{{ route('admin.forwardApplication',["role" => "__ROLE__"]) }}'.replace('__ROLE__', role),
        //         type: 'POST',
        //         // contentType: 'application/json',
        //         headers: {
        //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        //         },
        //         data: {
        //             application_id: applicationId,
        //             processed_by: processedBy,
        //             forwarded_to: forwardedTo,
        //             role_id: role_id,
        //             remarks: remarks || "No remarks provided",
        //             checkboxes: checkboxStatus, // Only "Yes" or "No"
        //             queryswitch: queryswitch ? "Yes" : "No", // Only "Yes" or "No"
        //             "queryType[]": queryType
        //         },
        //         success: function(response) {

        //             // if (response.status == "success") {
        //             //     // Cleanup Bootstrap modal instance on hide
        //             //     $('#declarationModal').modal('hide');

        //             //     $('#successModal .modal-body').html(`<p>${response.message}</p>`);
        //             //     $('#successModal').modal('show');

        //             //     $('#successModal').on('hidden.bs.modal', function() {
        //             //         window.location.href = '/admin/dashboard'
        //             //     });
        //             // }

        //             if (response.status == "success") {
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Success',
        //                     text: response.message,
        //                     confirmButtonText: 'OK',
        //                     confirmButtonColor: '#3085d6',
        //                     allowOutsideClick: false
        //                 }).then((result) => {
        //                     if (result.isConfirmed) {
        //                         window.location.href = '/admin/dashboard';
        //                     }
        //                 });
        //             }

        //         },
        //         error: function(xhr) {
        //             let errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : "An unexpected error occurred.";
        //             $('#errorModal .modal-body').html(`<p>${errorMessage}</p>`);
        //             $('#errorModal').modal('show');
        //         }
        //     });
        // });

        //
        // var returnButton = document.querySelector('#returntoSuper');

        // if (returnButton) {
        //     returnButton.addEventListener('click', function () {
        //         // Show Bootstrap confirmation modal
        //         $('#returnConfirmModal').modal('show');
        //     });
        // }

        // Handle confirm button inside modal
        $('#confirmReturnBtn').on('click', function () {

            var queryType = [];
            
            var applicationId   = @json($applicant->application_id);
            var returnBy        = @json(Auth::user()->name);
            var forwardedTo     = @json($returnForwardUser->roles_id ?? 0);
            var remarks         = $("#remarks").val().trim();
            // var queryswitch     = $("#Queryswitch").prop("checked");


            var checkboxStatus = "Yes";
            
            let queryswitch = $("#Queryswitch").prop("checked");
            queryType = $("#queryType").val();
            let errorBox = $("#query_error");


            Swal.fire({
                title: "Return",
                html: 'You want to return this application!',
                showCancelButton: true,
                confirmButtonText: "Forward to {{ $applicant->status == 'RE' ? 'Secretary' : 'Supervisor' }}",
                cancelButtonText: "Cancel",
                focusConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.returntoSupervisor') }}',
                        type: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        data: {
                            application_id  : applicationId,
                            return_by       : returnBy,
                            forwarded_to    : forwardedTo,
                            remarks         : remarks || "No remarks provided",
                            checkboxes      : checkboxStatus,
                            queryswitch     : queryswitch ? "Yes" : "No",
                            "queryType[]": queryType 
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: response.message,
                                    confirmButtonText: "OK",
                                    allowOutsideClick: false
                                }).then(() => {
                                    window.location.href = "{{ url('admin/dashboard') }}";
                                });
                            }
                        },
                        error: function (xhr) {
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : "An unexpected error occurred.";
                            $('#errorMessage').text(errorMessage);
                            $('#errorModal').modal('show');
                        }
                    });
                }
            });

        });


        $(document).on("click", ".admin_verify", function () {
            let btn = $(this); 
            // 🔹 Select only from the correct section
            let licenseNumber = $(this).data("license_number");
            let licenseDate = $(this).data("license_date");

            let type = $(this).data("type");

            let application_id = @json($applicant->application_id);
            
            let url = "{{ route('admin.verifylicense') }}";
            
            // console.log(licenseNumber, licenseDate, url);
            // return false;
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    license_number : licenseNumber,
                    date : licenseDate,
                    type : type,
                    application_id : application_id,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    btn.hide(); // hide the button

                    if (response.exists) {
                        btn.after('<span class="text-success ms-2">(Valid License.)</span>'); // ✅ tick mark
                    } else {
                        btn.after('<span class="text-danger ms-2">(Invalid License.)</span>'); // ❌ cross mark
                    }

                },
                error: function () {
                    btn.hide(); // also hide on error
                    btn.after('<span class="text-danger ms-2">🚫 Something went wrong!.</span>'); // error icon
                },
            });
        });

    });




    $(".reason-option").on("change", function() {
    if ($(this).val() === "select") {
      $(".reason-select").show();
      $(".reason-textarea").hide();
      $("textarea[name='other_reason']").val("");

      $(".reason-textarea-error").text("");
      $("textarea[name='other_reason']").removeClass("is-invalid");

    } else if ($(this).val() === "other") {
      $(".reason-textarea").show();
            $(".reason-select").hide().val(""); // reset select

            // reset errors
            $(".reason-select-error").text("");
            $(".reason-select").removeClass("is-invalid");
          }
        });

    // Initialize on page load
  $(".reason-option:checked").trigger("change");


     // Hide validation error on change/typing
  $(document).on("change", ".reason-select", function() {
    if ($(this).val() !== "") {
      $(this).removeClass("is-invalid");
      $(this).siblings(".reason-select-error").text("");
    }
  });

  $(document).on("input", "textarea[name='other_reason']", function() {
    if ($(this).val().trim() !== "") {
      $(this).removeClass("is-invalid");
      $(this).siblings(".reason-textarea-error").text("");
    }
  });
  

  $("#reject_application").on("submit", function(e) {
    e.preventDefault();

    
    const rejectAppUrl = "{{ route('admin.rejectApplication') }}";
    const APP_URL = "{{ config('app.url') }}";

        // clear old errors
    $(".form-select, textarea").removeClass("is-invalid");
    $(".invalid-feedback").text("");
    $("#successMsg").addClass("d-none");

    let selectedOption = $("input[name='radio-reason']:checked").val();
    let valid = true;
    let formData = {
      action_by: $("#action_by").val(),
      login_id: $("#login_id").val(),
      application_id: $("#application_id").val(),
      appl_status: $("#appl_status").val(),
            _token: "{{ csrf_token() }}" // important for Laravel
          };

          if (selectedOption === "select") {
            let reason = $(".reason-select").val();
            if (reason === "") {
              $(".reason-select").addClass("is-invalid");
              $(".reason-select").siblings(".reason-select-error").text("Please select a reason.");
              valid = false;
            } else {
              formData.reason = reason;
            }
          } else if (selectedOption === "other") {
            let other = $("textarea[name='other_reason']").val().trim();
            if (other === "") {
              $("textarea[name='other_reason']").addClass("is-invalid");
              $("textarea[name='other_reason']").siblings(".reason-textarea-error").text("Please enter the other reason.");
              valid = false;
            } else {
              formData.reason = other;
            }
          }

          if (!valid) return;

        // AJAX request
          $.ajax({
            url: rejectAppUrl,
            type: "POST",
            data: formData,
            success: function(response) {
              if (response.success === true) {
                $("#rejectionModal").modal("hide");
                Swal.fire({
                  icon: 'success',
                  title: 'Rejected successfully',
                  showConfirmButton: false,
                  timer: 2000
                }).then(() => {
                        window.location.href = APP_URL +"/admin/dashboard"; // redirect URL
                      });
              }else{
                $("#rejectionModal").modal("hide");
                Swal.fire('Something went wrong', '', 'error');
              }
            },
            error: function(xhr) {
              Swal.fire('Server error occurred', '', 'error').then(() => {
                $("#rejectionModal").modal("hide");
                    //window.location.href = "/admin/dashboard"; // redirect path
                  });
            }
          });
      });
</script>