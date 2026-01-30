@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')
<style>
    .tab-content {
        padding: 0px 20px;
    }
    .table td{
        text-align:left;
    }
    table th{
        font-weight:800!important;    
    }
    .officers_section{
        background: #4361ee;
        padding:5px;
    }

      .officers_section h6{
        color:#fff;
        font-size:18px;
        font-weight:600;
    }
    .text-info{
        color:#3b3f5c!important;
        font-size:15px;
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
                                    <h4>Applicant Id : <span> {{ $applicant->application_id }}</span> Applicant Name : <span style="color:#098501;">{{ $applicant->applicant_name }}</span> Applied For : <span style="color:#098501;"> {{ $applicant->form_name }} | License {{ $applicant->license_name }}</span> </h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="tabsSimple" class="col-xl-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    {{-- <h3 class="application_id_css">Application Id :<span style="color:#098501;"> {{ $applicant->application_id }}</span> </h3> --}}
                                    <h4>View Applicant's Details</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <div class="simple-tab">
                                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Applicant's Details</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Staff and Bank Details</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other-tab-panel" type="button" role="tab" aria-controls="other-tab-panel" aria-selected="false">Other Details</button>
                                    </li>

                                     <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="equipment-tab" data-bs-toggle="tab" data-bs-target="#equipment-tab-panel" type="button" role="tab" aria-controls="equipment-tab-panel" aria-selected="false">Equipment / Instruments List</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="payment-tab" data-bs-toggle="tab"
                                            data-bs-target="#payment-tab-panel" type="button" role="tab"
                                            aria-controls="payment-tab-panel" aria-selected="false">
                                            Payment Details
                                        </button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Checklist Details</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                        <div class="row mt-3 ">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-3">


                                                            <p class="text-info"><strong>1. Name of the applicant:</strong></p>

                                                            <p class="text-info"><strong>2. Business address:</strong></p>

                                                        </div>
                                                        <div class="col-lg-8">


                                                            <p>{{ $applicant->applicant_name }}</p>

                                                            <p>{{ $applicant->business_address }}</p>


                                                        </div>

                                                    </div>


                                                </div>

                                            </div>





                                            <p class="mt-4 mb-2 fw-bold text-info">3. Ownership Type - Proprietor / Partners / Directors Details</p>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Ownership <br>Type</th>
                                                            <th>Name </th>
                                                              <th>Father/s
                                                                Husband/s
                                                                Name</th>
                                                            <th>Age</th>
                                                            <th>Address </th>
                                                            <th>Qualifications</th>
                                                             

                                                            <th>Present business of
                                                                the applicant</th>
                                                            <th>Competency
                                                                Certificate and
                                                                Validity </th>
                                                            <th>Presently
                                                                Employed
                                                                and Address </th>
                                                            <th>If holding a
                                                                competency
                                                                certificate -<br>
                                                                Contractor
                                                                Details </th>
                                                            <!-- <th>Documents</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                
                                                            $sortedProprietors = collect($proprietordetailsform_A)
                                                                ->sortBy(function($item) {
                                                                    return match($item->ownership_type) {
                                                                        'pr' => 1, 
                                                                        'pt' => 2, 
                                                                        'dr' => 3, 
                                                                        default => 4,
                                                                    };
                                                                });
                                                        @endphp
                                                        @forelse ($sortedProprietors as $proprietor)
                                                        <tr>
                                                            <td>
                                                                <!-- {{$proprietor->id}} -->
                                                                @if($proprietor->ownership_type == 'pr' )
                                                              Proprietor  
                                                                @elseif($proprietor->ownership_type == 'pt')
                                                                Partner
                                                                @else
                                                                Director
                                                                @endif

                                                            </td>
                                                            <td>{{ $proprietor->proprietor_name }} </td>
                                                            <td> {{ $proprietor->fathers_name }}</td>
                                                            <td>{{ $proprietor->age }} </td>
                                                            <td>{{ $proprietor->proprietor_address }} </td>
                                                             <td> {{ $proprietor->qualification }}</td>
                                                           
                                                            <td> {{ $proprietor->present_business }}</td>

                                                           <td>
                                                            {{ $proprietor->competency_certificate_number }}

                                                            {{ $proprietor->competency_certificate_validity 
                                                                ? \Carbon\Carbon::parse($proprietor->competency_certificate_validity)->format('d-m-Y') 
                                                                : ''  
                                                            }}

                                                            @if(!empty($proprietor->competency_certificate_number))
                                                               <!--  @if(isset($proprietor->proprietor_cc_verify) && $proprietor->proprietor_cc_verify == '1')
                                                                    <p class="text-success">Valid License</p>
                                                                @elseif(isset($proprietor->proprietor_cc_verify) && $proprietor->proprietor_cc_verify == '0')
                                                                    <p class="text-danger">Invalid License</p>
                                                                @endif -->

                                                                <button type="button" 
                                                                    class="btn btn-primary verify-license" 
                                                                    data-id="{{ $proprietor->id }}"
                                                                    data-license="{{ $proprietor->competency_certificate_number }}"
                                                                    data-date="{{ $proprietor->competency_certificate_validity ? \Carbon\Carbon::parse($proprietor->competency_certificate_validity)->format('d-m-Y') : '' }}">
                                                                    Verify
                                                                </button>
                                                            @endif 

                                                            <div id="verify-result-{{ $proprietor->id }}"></div>
                                                        </td>


                                                            <td>

                                                                {{ $proprietor->presently_employed_name }}<br> {{ $proprietor->presently_employed_address }}

                                                            </td>

                                                            
                                                          <td>
                                                            {{ $proprietor->previous_experience_lnumber }}
                                                            {{ $proprietor->previous_experience_lnumber_validity 
                                                                ? \Carbon\Carbon::parse($proprietor->previous_experience_lnumber_validity)->format('d-m-Y') 
                                                                : '' 
                                                            }}

                                                          

                                                            @if(!empty($proprietor->previous_experience_lnumber))
                                                          <!--     @switch($proprietor->proprietor_contractor_verify ?? null)
                                                                @case('1')
                                                                    <p class="text-success">Valid License</p>
                                                                    @break
                                                                @case('0')
                                                                    <p class="text-danger">Invalid License</p>
                                                                    @break
                                                            @endswitch -->
                                                                <button class="btn btn-sm btn-primary verify-btn_EA"
                                                                    data-license="{{ $proprietor->previous_experience_lnumber }}"
                                                                    data-date="{{ $proprietor->previous_experience_lnumber_validity 
                                                                        ? \Carbon\Carbon::parse($proprietor->previous_experience_lnumber_validity)->format('d-m-Y') 
                                                                        : '' 
                                                                    }}">
                                                                    Verify
                                                                </button>
                                                            @endif

                                                            <div class="verify-result_EA mt-1"></div>
                                                        </td>


                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">No Proprietor Details details available.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row mt-2">
                                                        <div class="col-lg-8">


                                                            <p class=" text-info"><strong>4. Name of the manager or agent in case of a limited company.:</strong></p>



                                                        </div>
                                                        <div class="col-lg-4">


                                                            <p>{{ strtoupper($applicant->manager_name_radio) }}
                                                                @if($applicant->manager_name_radio === 'yes')
                                                                - {{$applicant->manager_name}} 
                                                                @endif
                                                            </p>
                                                        </div>


                                                    </div>
                                            
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row mt-2">
                                                        <div class="col-lg-8">
                                                            <p class=" text-info"><strong>5. Whether any application for Contractor/s licence was made previously? If so, details thereof:</strong></p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <p>{{ strtoupper($applicant->previous_contractor_license) }}
                                                                @if($applicant->previous_contractor_license === 'yes')
                                                                 - {{$applicant->previous_application_number}}, 
                                                                    {{ \Carbon\Carbon::parse($applicant->previous_application_validity)->format('d-m-Y') }}

                                                                                     <div class="row">
                                                               


                                                           <div class="col-lg-12 col-12 d-flex align-items-center">
                                                            <div class="verify-result_EA "></div>  <!-- Result on left -->
                                                            <button class="btn btn-sm btn-primary verify-btn_EA"
                                                                data-license="{{ $applicant->previous_application_number }}"
                                                                data-date="{{ $applicant->previous_application_validity }}">
                                                                Verify
                                                            </button>
                                                        </div>



                                                             </div>
                                                                @endif
                                                                </p>
                                                            
                                            
                                                             
                                                              
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-lg-8 col-8">
                                                    <p class="text-info"><strong>6. Aadhaar</strong></p>

                                                    <p class="text-info"><strong>7. Pan Card</strong></p>

                                                     <p class="text-info"><strong>8. GST</strong></p>
                                                </div>
                                               @php
                                                    use Illuminate\Support\Str;
                                                    use Illuminate\Support\Facades\Crypt;

                                                 

                                                    // Aadhaar
                                                    $decryptedaadhar = Crypt::decryptString($applicant->aadhaar);

                                                  // Aadhaar doc
                                                    $decryptedaadhar_doc = Crypt::decryptString($documents->aadhaar_doc);

                                                    // PAN doc
                                                    $decryptedpancard_doc = Crypt::decryptString($documents->pancard_doc);

                                                    // GST doc
                                                    $decryptedgst_doc = Crypt::decryptString($documents->gst_doc);

                                                    // PAN
                                                    $decryptedpan =  Crypt::decryptString($applicant->pancard);

                                                    // GST
                                                    $decryptedgst =  Crypt::decryptString($applicant->gst_number);

                                                    // Masking
                                                    $masked = strlen($decryptedaadhar) === 12
                                                        ? str_repeat('X', 8) . substr($decryptedaadhar, -4)
                                                        : 'Invalid Aadhaar';

                                                    $maskedPan = strlen($decryptedpan) === 10
                                                        ? str_repeat('X', 6) . substr($decryptedpan, -4)
                                                        : 'Invalid PAN';

                                                    $maskedgst = strlen($decryptedgst) === 15
                                                        ? str_repeat('X', 6) . substr($decryptedgst, -4)
                                                        : 'Invalid GST';
                                                    @endphp
 
                                                <div class="col-lg-4 col-4 aadhaar_doc_file">
                                                    <div class="row">
                                                          <div class="col-lg-6 col-6">
                                                             <p>  {{ $masked }}</p>
                                                          </div>

                                                           <div class="col-lg-6 col-6">
                                                             <a href="{{ asset($decryptedaadhar_doc) }}" target="_blank"><i class="fa fa-file-pdf-o text-red"></i> View </a>
                                                          </div>
                                                    </div>

                                                    <div class="row">
                                                          <div class="col-lg-6 col-6">
                                                             <p> {{ $maskedPan }}</p>
                                                          </div>

                                                           <div class="col-lg-6 col-6">
                                                             <a href="{{ asset($decryptedpancard_doc) }}" target="_blank"><i class="fa fa-file-pdf-o text-red"></i> View </a>
                                                          </div>
                                                    </div>

                                                    <div class="row">
                                                          <div class="col-lg-6 col-6">
                                                             <p> {{ $maskedgst }}</p>
                                                          </div>

                                                           <div class="col-lg-6 col-6">
                                                             <a href="{{asset($decryptedgst_doc) }}" target="_blank"><i class="fa fa-file-pdf-o text-red"></i> View </a>
                                                          </div>
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
                                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                        <p class="mt-4 mb-2 fw-bold text-info">9. Staff Details</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Staff Name</th>
                                                        
                                                        <th>Staff <br> Qualification</th>
                                                         <th>Staff Category</th>
                                                        <th>Competency Certificate Number <br>
                                                            Competency Certificate Validity
                                                        </th>

                                                        <th>History of Staff
                                                        </th>
                                                                                                                
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($staffdetails as $staff)
                                                    <tr>
                                                         <td>{{ $staff->staff_name }}</td>
                                                        <td>{{ $staff->staff_qualification }}</td>
                                                        <td>{{ $staff->staff_category }}</td>
                                                        <td>{{ $staff->cc_number }},{{ \Carbon\Carbon::parse($staff->cc_validity)->format('d-m-Y') }} 
                                                            
                                                            <button class="btn btn-primary verify-btn_staff"
                                                                data-license="{{ $staff->cc_number }}"
                                                                data-date="{{ \Carbon\Carbon::parse($staff->cc_validity)->format('d-m-Y') }}">
                                                                Verify 
                                                            </button>
                                                              <span class="verify-result_staff"></span>
                                                        </td>
                                                     
                                                    
                                                    <td>
                                                        <button class="btn btn-info history-btn_staff"
                                                            data-license="{{ $staff->cc_number }}"
                                                            data-date="{{ \Carbon\Carbon::parse($staff->cc_validity)->format('d-m-Y') }}"
                                                            data-application_id="{{ $staff->application_id }}"
                                                            data-bs-toggle="modal" data-bs-target="#showlicense"
                                                            >
                                                            
                                                            View History
                                                        </button>
                                                        <div class="history-result_staff mt-2"></div>
                                                    </td>

                   
                                                
<!-- 
<button class="btn btn-info history-btn_staff" data-license="{{ $staff->cc_number }}"
                                                            data-date="{{ \Carbon\Carbon::parse($staff->cc_validity)->format('d-m-Y') }}" data-application_id="{{ $staff->application_id }}">Check History</button>
                                                                <span class="history-result_staff"></span>       
                                                    @php
                                                        $history = DB::table('tnelb_applicant_formA_staffdetails as s')
                                                            ->leftJoin('tnelb_ea_applications as a', 's.application_id', '=', 'a.application_id')
                                                            ->where('s.cc_number', $staff->cc_number)
                                                            ->where('s.cc_validity', $staff->cc_validity)
                                                            ->where('a.application_status', 'A')
                                                            ->get();

                                                        $today = \Carbon\Carbon::today();
                                                    @endphp

                                                    @if($history->count() > 0)
                                                        <div class="staff-history mt-2">
                                                            
                                                           <ul>
                                                                @foreach($history as $h)
                                                                    @php
                                                                        $today = \Carbon\Carbon::today();

                                                                        // Get original license
                                                                        $license = DB::table('tnelb_license')
                                                                            ->where('application_id', $h->application_id)
                                                                            ->first();

                                                                        // Get renewal license
                                                                        $renewal = DB::table('tnelb_renewal_license')
                                                                            ->where('application_id', $h->application_id)
                                                                            ->first();

                                                                        $finalLicense = null;

                                                                        if ($license && $renewal) {
                                                                            // Pick the one with the latest expiry
                                                                            $licenseDate = \Carbon\Carbon::parse($license->expires_at);
                                                                            $renewalDate = \Carbon\Carbon::parse($renewal->expires_at);

                                                                            $finalLicense = $licenseDate->gt($renewalDate) ? $license : $renewal;
                                                                        } elseif ($license) {
                                                                            $finalLicense = $license;
                                                                        } elseif ($renewal) {
                                                                            $finalLicense = $renewal;
                                                                        }

                                                                        $active = false;
                                                                        if ($finalLicense && \Carbon\Carbon::parse($finalLicense->expires_at)->gt($today)) {
                                                                            $active = true;
                                                                        }
                                                                    @endphp

                                                                    @if($finalLicense)
                                                                        <li>
                                                                            License Number: {{ $finalLicense->license_number }} <br>
                                                                            Expiry: {{ \Carbon\Carbon::parse($finalLicense->expires_at)->format('d-m-Y') }} <br>

                                                                            @if($active)
                                                                                <span class="badge bg-success">Active License</span>
                                                                            @else
                                                                                <span class="badge bg-danger">Expired License</span>
                                                                            @endif
                                                                        </li>
                                                                    @else
                                                                        <li>
                                                                            <span class="text-muted">No license record found</span>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>                   
                                                        </div>
                                                    @else
                                                        <span class="text-muted">No history found</span>
                                                    @endif -->
                                                    
                                                        


                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">No Staffs available.</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                <!-- ---------------------------License History--------------- -->

               <div class="modal fade inputForm-modal" id="showlicense" tabindex="-1" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">License History</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <!-- <th>S.No</th> -->
                                            <th>License Number</th>
                                            <th>Issued on</th>
                                            <th>Expires on</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class=""><td colspan="5" class="text-muted text-center">No data available</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                         <!-- ---------------------------License End--------------- -->

                                        <div class="row mt-3">
                                           
                                            <div class="row ">
                                                <div class="col-lg-12">
                                                    <p class="text-info"><strong>10. Bank and Address</strong></p>
                                                </div>
                                            </div>
                                        
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p><strong>Bank Name</strong></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <p>{{ $banksolvency->bank_address ?? '' }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p><strong>Validity</strong></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <p>{{ format_date($banksolvency->bank_validity) ?? ''}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p><strong>Amount</strong></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <P>{{ $banksolvency->bank_amount ?? '' }}</P>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-6">
                                                <p><strong> Payment Time</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>{{ $applicant->created_at }}</p>
                                        </div> --}}



                                    </div>
                                </div>


                                <div class="tab-pane fade" id="other-tab-panel" role="tabpanel" aria-labelledby="other-tab" tabindex="0">

                                    <div class="row mt-3">


                                        <div class="col-lg-10">
                                            <p><strong>12.(i) Whether the applicant or his employee has been convicted of any criminal offence and has been convicted by the 6T or any other authority for any offence committed by him or her in the past or in the present or future by the court of law (if yes, give full details)</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->criminal_offence) }} 
                                                 @if($applicant->criminal_offence === 'yes')
                                                                - {{$applicant->criminal_offence_details}} 
                                                                @endif
                                            </p>
                                        </div>

                                       


                                           <div class="col-lg-10">
                                            <p><strong>13.(i)  Are the approval letters (as per the sample form) attached from the employees who have obtained the qualification certificate for the post (Note: Self-certificate holders should attach their approval letter)</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->approval_letters) }} 
                                                
                                            </p>
                                        </div>

                                       


                                        <div class="col-lg-10">
                                            <p><strong>Is the original of the qualification certificate book of the foreman/supervisors attached?</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->qualification_certificate) }}</p>
                                        </div>


                                        <div class="col-lg-10">
                                            <p><strong>13. (i).Is the invoice for the purchase of testing equipment attached?</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->purchase_enclose) }}</p>
                                        </div>


                                        <div class="col-lg-10">
                                            <p><strong>(ii). Are the test reports of the test equipment (original) attached ?</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->test_reports_enclose) }}</p>
                                        </div>


                                        <div class="col-lg-10">
                                            <p><strong>14. (i). The name to be given to the Electrical Contractor in all reports relating to the Electrical Contractor License on behalf of the Electrical Contractor. If someone else has been authorized to sign, the name(s) of the person(s) authorized. License (If the reference is to an individual, only his signature will be accepted) </strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->authorized_sign) }}</p>
                                        </div>

                                        <div class="col-lg-12">

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name of Signatory</th>
                                                        <th>Age of Signatory</th>
                                                        <th>Qualification of Signatory</th>
                                                                                                                
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            @php
                                            $authorizedPersons = json_decode($applicant->name_of_authorised_to_sign, true);
                                            
                                            $authorizedage = json_decode($applicant->age_of_authorised_to_sign, true);

                                            $authorizedqualify = json_decode($applicant->qualification_of_authorised_to_sign, true);
                                            @endphp
                                             @if(!empty($authorizedPersons))
                                                 @foreach($authorizedPersons as $index => $person)
                                                    <tr>
                                                       
                                                        <td>{{ strtoupper($person) }}</td>
                                                        <td>{{$authorizedage[$index] ?? '' }}</td>
                                                        
                                                         <td>{{ strtoupper($authorizedqualify[$index] ?? '') }}</td>
                                                     
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan="3">No authorized persons</td>
                                            </tr>
                                            @endif
                                                </tbody>
                                            </table>
                                        </div>
                                           

                                        </div>

                                           <div class="col-lg-10">
                                            <p><strong>(ii). Have the specimen signatures of the three persons who have been granted approval been placed on a white sheet of paper and attached?</strong></p>

                                            
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->three_specimen_sign) }}</p>
                                        </div>

                                         <div class="col-lg-10">
                                            <p><strong>(iii). If the person is a single person, is his specimen signature attached on three white sheets of paper?</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->single_specimen_sign) }}</p>
                                        </div>

                                    </div>


                                     

                                       
                                    
                                </div>

                                <!-- ----------------equipment-tab--------------------- -->
                                 <div class="tab-pane fade" id="equipment-tab-panel" role="tabpanel" aria-labelledby="equipment-tab" tabindex="0">

                                    <div class="row mt-3">


                            <div class="col-md-1 col-2 text-left">
                                <label for="Name">15.</label>
                            </div>


                            <div class="col-md-6 col-10">
                                 <p>(i)  A 500 volt insulation tester (Meker) <span class="text-danger">*</span></p>
                                    <p>(ii) A tang type ammeter <span class="text-danger">*</span></p>
                                    <p>(iii) An earth resistance tester<span class="text-danger">*</span></p>
                                    <p>(iv)  An electrical test tool (live line tester) <span class="text-danger">*</span></p>
                                    
                            </div>


                            <div class="col-md-4 col-12 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chk-proprietor" value="1"  @if(isset($equipmentlist->equip_check) && $equipmentlist->equip_check == 1) checked @endif>
                                        <label class="form-check-label" for="chk-proprietor">
                                            Hand operated 
                                        </label>
                                    </div>
                            
                            </div>

                               <div class="col-lg-7">
                                            <p><strong> 16. The original invoice for the purchase of the equipment must be sent.</strong></p>
                                        </div>
                                        <div class="col-lg-1">
                                           
                                           <p>{{ $equipmentlist->invoice == "yes" ? 'Yes' : 'No'}}</p>
                                            <!-- <p>Yes</p> -->
                                        </div>
                                         <!-- @if($equipmentlist->tested_documents == "yes")
                                            <div class="col-lg-2">
                                                
                                                <p>Specimen Signature Name: <br><b>{{$equipmentlist->tested_report_id}}</b></p>
                                                                                        
                                            </div>

                                            <div class="col-lg-2">
                                                <p>Validity Date : <br> <b> {{
                                                    \Carbon\Carbon::parse($equipmentlist->validity_date_eq1)->format('d-m-Y') }}</b></p>
                                                                                        
                                            </div>
                                        @endif -->
                                        <!-- -------------------- -->
                                          <div class="col-lg-7">
                                            <p><strong> 17. The above equipment should be tested at the Chennai Electrical Equipment Standards Laboratory (affiliated with the Office of the Chief Electrical Inspector of Government) or the Electrical Equipment Testing Laboratory of the Electricity Board and a test report should be obtained and sent to this Board in original. The test report should be within three months from the date of application.</strong></p>
                                        </div>
                                        <div class="col-lg-1">
                                             <p>{{ $equipmentlist->lab_auth == "yes" ? 'Yes' : 'No'}}</p>
                                        </div>

                                        <!-- @if($equipmentlist->original_invoice_instr == "yes")
                                            <div class="col-lg-2">
                                                
                                                <p>Contractor's Name: <br><b>{{$equipmentlist->invoice_report_id}}</b></p>
                                                                                        
                                            </div>

                                            <div class="col-lg-2">
                                                <p>Validity Date : <br> <b> {{
                                                    \Carbon\Carbon::parse($equipmentlist->validity_date_eq2)->format('d-m-Y') }}</b></p>
                                                                                        
                                            </div>
                                        @endif -->

                                        <!-- --------------18--------------------------- -->
                                        <div class="col-lg-7">
                                            <p><strong>18.The test report and receipt of the manufacturer should be in the same name and address as the name and address in which the license is to be issued (as indicated in 1 and 2 of Form 'B'). If there is any difference, they will not be accepted. The applicant should have a branch office in Tamil Nadu and contact the branch office address.16/</strong></p>
                                        </div>
                                        <div class="col-lg-1">
                                             <p>{{ $equipmentlist->instrument3_yes == "yes" ? 'Yes' : 'No'}}</p>
                                        </div>

                                        @if($equipmentlist->instrument3_yes == "yes")
                                            <div class="col-lg-2">
                                                
                                                <p>Branch Office Details : <br><b>{{$equipmentlist->instrument3_id}}</b></p>
                                                                                        
                                            </div>

                                            <!-- <div class="col-lg-2">
                                                <p>Validity Date : <br> <b> {{
                                                    \Carbon\Carbon::parse($equipmentlist->validity_date_eq3)->format('d-m-Y') }}</b></p>
                                                                                        
                                            </div> -->
                                        @endif
                                        <!-- ------------------------------------------------------ -->

                                       
                                    </div>
                                </div>
                                <!-- -------------------------------- -->

                                 <div class="tab-pane fade" id="payment-tab-panel" role="tabpanel" aria-labelledby="payment-tab" tabindex="0">
                                    <div class="row mt-3">

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
                                                        <p><strong> Transaction Id</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ $applicant->transaction_id }}</p>
                                                    </div>
                                                   
                                                    <div class="col-lg-6">
                                                        <p><strong>Payment mode:</strong></p>
                                                    </div>

                                                     <div class="col-lg-6">
                                                        <p>UPI</p>
                                                        <!-- <p>{{ $applicant->payment_mode }}</p> -->
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
                                                    
                                                   
                                                    <div class="col-lg-6">
                                                        <p><strong> Payment Time</strong></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>{{ format_date_other($applicant->created_at) }}</p>
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


        </div>

        <!-- -------------------------------------------- -->
         <div class="row ">
             <div class="statbox widget officers_section mb-2">
                <div class="col-lg-12 col-12 text-center">
                    <h6>Officers Handling Functions </h6>
                </div> 
                                            </div>   
            
            
         </div>
        <div class="row">
            <div id="tabsSimple" class="col-xl-6 col-12 layout-spacing">
                
                <div class="row align-items-center">
                    
                    <div class="col-lg-12">
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
                    </div>
                </div>
                <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <h4>Remarks</h4>
                            <textarea class="form-control" name="remarks" id="remarks" rows="4" cols="50"></textarea>
                        </div>
                         <div class="modal-footer mt-2" style="justify-content: center;">

                                @php
                                $role = Auth::user()->name; // Current role name
                                $workflow = [
                                    'Supervisor' => $applicant->application_status == 'RE'? 'Secretary' : 'Accountant',
                                    'Supervisor2' => $applicant->application_status == 'RE'? 'Secretary' : 'Accountant',
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

                                   
                                        <button class="btn btn-success" id="confirmForwardPres">
                                            Forward to {{ $workflow[$role] }}
                                        </button>
                          

                                    <button id="confirmReturnBtn" class="btn btn-warning">
                                        Return to Supervisor
                                    </button>
                                    <button class="btn btn-danger">Reject</button>

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
                                    <button class="btn btn-danger">Reject</button>
                                @endif

                            </div>
                        <!-- <div class="modal-footer mt-2" style="justify-content: center;">
                            <button class="btn btn-success" id="forwardbtn" style="margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#declarationModal" disabled>Forward To {{ $applicant->application_status == 'RE' ? 'Secretary': 'Accountant'}}</button>
                            <button class="btn btn-warning " style="margin-right: 20px;" data-bs-dismiss="modal">On Hold</button>
                            {{-- <button type="button" class="btn btn-danger">Reject</button> --}}
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
         <!-- ------------------------------------ -->
         <div id="timelineMinimal" class="col-lg-6 layout-spacing">
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
                                        @php
                                            // Normalize name if it's "auditor" (any case)
                                            $displayName = $row->name;
                                            if ($displayName && strcasecmp($displayName, 'auditor') === 0) {
                                                $displayName = 'accountant';
                                            }
                                        @endphp

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
                                                Forwarded to {{ $displayName }} <br>
                                                Remarks: {{ $row->remarks }}
                                            @endif
                                        </p>

                                        @if ($row->processed_by !== 'Accountant')
                                            @if ($row->query_status == "P")
                                                <p class="text-danger">Note: Query raised by {{ $row->processed_by }} (
                                                    @php
                                                        $queries = $row->queries;

                                                        if (is_string($queries)) {
                                                            $queries = json_decode($queries, true);
                                                        }
                                                    @endphp

                                                    @if(!empty($queries) && is_array($queries))
                                                        {{ implode(', ', $queries) }}
                                                    @endif
                                                    )
                                                </p>
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
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="declarationModal" tabindex="-1" aria-labelledby="declarationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declarationModalLabel">Approval Declaration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="confirmApproval">
                    <label class="form-check-label" for="confirmApproval">
                        I confirm that all documents have been verified by me as a supervisor.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmForward">Forward to Accountant</button>
            </div>
        </div>
    </div>
</div>
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
<!-- <div class="modal fade" id="forwardmodal" tabindex="-1" aria-labelledby="declarationModalLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-success" id="confirmForward" disabled>Forward to President</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Application has been successfully approved!</p>
                <p><strong>License Number:</strong> <span id="licenseNumber"></span></p>
                {{-- <p><strong>License Expiry:</strong> <span id="licenseExpiry"></span></p> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p id="errorMessage">Something went wrong. Please try again.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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


    // $('#remarks').maxlength({
    //     placement: "top"
    // });
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
            // alert('111');
            var applicationId = @json($applicant->application_id);
            var processedBy = @json(Auth::user()->name);
            var remarks = $("#remarks").val().trim();


            Swal.fire({
                title: "Declaration",
                html: `
                    <div class="form-check text-start">
                        <label class="form-check-label" for="confirmVerification">
                            I confirm that this application has been reviewed and approved.
                        </label>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: "Approved",
                cancelButtonText: "Cancel",
                focusConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                  
                    $.ajax({
                        url: '{{ route('admin.approveApplicationFormsb') }}',
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
                            // if (response.status == "success") {
                            //     // Cleanup Bootstrap modal instance on hide
                            //     $('#approvalModal').modal('hide');
                            //     $('#message').text(response.message);
                            //     $('#licenseNumber').text(response.license_number);

                            //     $('#finalsuccessModal').modal('show');
                
                            //     $('#finalsuccessModal').on('hidden.bs.modal', function () {
                            //         window.location.href = '/admin/dashboard';
                            //     });
                            // }

                            if (response.status == "success") {
                                Swal.fire({
                                    
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
                html: `
                    <div class="form-check text-start">
                        <label class="form-check-label" for="confirmVerification">
                            I confirm that have been verified by me as a secretary.
                        </label>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: "Forward to President",
                cancelButtonText: "Cancel",
                focusConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: '{{ route('admin.forwardApplicationformsb',["role" => "__ROLE__"]) }}'.replace('__ROLE__', role),
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

                            // if (response.status == "success") {

                            //     $('#forwardmodal').modal('hide');

                            //     $('#successModalForward').modal('show');

                            //     $('#successModalForward .modal-body').html(`<p>${response.message}</p>`);

                            //     $('#successModalForward').on('hidden.bs.modal', function () {
                            //         window.location.href = '/admin/dashboard';
                            //     });
                            // }

                            if (response.status == "success") {
                                Swal.fire({
                                    
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

//  $('#confirmReturnBtn').on('click', function () {

//             // alert('111');
//             var applicationId   = @json($applicant->application_id);
//             var returnBy        = @json(Auth::user()->name);
           
//             var forwardedTo     = @json($returnForwardUser->roles_id ?? 0);
//             //    alert(forwardedTo);
//             //    exit;
//             var remarks         = $("#remarks").val().trim();
//             // var queryswitch     = $("#Queryswitch").prop("checked");



//             // var checkboxStatus  = "Yes";

//             // var queryType       = $("#queryType").val();

//             // if (queryswitch == true) {
//             //     if (!queryType || queryType.length === 0) {
//             //         $("#queryToast").toast("show");
//             //         return false;
//             //     }
//             // } else {
//             //     checkboxStatus  = "No";
//             //     queryType       = null;
//             // }

//             var checkboxStatus = "Yes";
            
//             let queryswitch = $("#Queryswitch").prop("checked");
//             queryType = $("#queryType").val();
//             let errorBox = $("#query_error");

//             Swal.fire({
//                 title: "Return",
//                 html: 'You want to return this!',
//                 
//                 showCancelButton: true,
//                 confirmButtonText: "Forward to {{ $applicant->application_status == 'RE' ? 'Secretary' : 'Supervisor' }}",
//                 cancelButtonText: "Cancel",
//                 focusConfirm: false,
//             }).then((result) => {
//                 if (result.isConfirmed) {
//                     $.ajax({
//                         url: '{{ route('admin.returntoSupervisorformsb') }}',
//                         type: 'POST',
//                         headers: {
//                             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
//                         },
//                         data: {
//                             application_id  : applicationId,
//                             return_by       : returnBy,
//                             forwarded_to    : forwardedTo,
//                             remarks         : remarks || "No remarks provided",
//                             checkboxes      : checkboxStatus,
//                             queryswitch     : queryswitch,
//                             "queryType[]": queryType 
//                         },
//                         success: function (response) {
//                             // if (response.status == "success") {
//                             //     $('#returnConfirmModal').modal('hide');
//                             //     $('#declarationModal').modal('hide');

//                             //     // Success message (can keep Swal or replace with Bootstrap alert/toast)
//                             //     $('#returnMessage').text(response.message);
//                             //     $('#successModal').modal('show');

//                             //     setTimeout(function(){
//                             //         window.location.href = '/admin/dashboard';
//                             //     }, 2000);
//                             // }
//                             if (response.status == "success") {
//                                 Swal.fire({
//                                     
//                                     title: "Success",
//                                     text: response.message,
//                                     confirmButtonText: "OK",
//                                     allowOutsideClick: false
//                                 }).then(() => {
//                                     window.location.href = "{{ url('admin/dashboard') }}";
//                                 });
//                             }
//                         },
//                         error: function (xhr) {
//                             let errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : "An unexpected error occurred.";
//                             $('#errorMessage').text(errorMessage);
//                             $('#errorModal').modal('show');
//                         }
//                     });
//                 }
//             });

//         });


 $('#confirmReturnBtn').on('click', function () {

            
            var applicationId   = @json($applicant->application_id);
            var returnBy        = @json(Auth::user()->name);
            var forwardedTo     = @json($returnForwardUser->roles_id ?? 0);

            // alert(forwardedTo);
            var remarks         = $("#remarks").val().trim();
            // var queryswitch     = $("#Queryswitch").prop("checked");



            // var checkboxStatus  = "Yes";

            // var queryType       = $("#queryType").val();

            // if (queryswitch == true) {
            //     if (!queryType || queryType.length === 0) {
            //         $("#queryToast").toast("show");
            //         return false;
            //     }
            // } else {
            //     checkboxStatus  = "No";
            //     queryType       = null;
            // }

            var checkboxStatus = "Yes";
            
            let queryswitch = $("#Queryswitch").prop("checked");
            queryType = $("#queryType").val();
            let errorBox = $("#query_error");

            Swal.fire({
              title: "Return",
    html: 'You want to return this application!',
    
    showCancelButton: true,
     confirmButtonText: "Return to @if($role == 'Secretary' || $role == 'President') Supervisor @elseif($role == 'Accountant') Supervisor @elseif($role == 'Supervisor' || $role == 'Supervisor2') Secretary @endif",
    cancelButtonText: "Cancel",
    focusConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.returntoSupervisorformsb') }}',
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
                            queryswitch     : queryswitch,
                            "queryType[]": queryType 
                        },
                        success: function (response) {
                            // if (response.status == "success") {
                            //     $('#returnConfirmModal').modal('hide');
                            //     $('#declarationModal').modal('hide');

                            //     // Success message (can keep Swal or replace with Bootstrap alert/toast)
                            //     $('#returnMessage').text(response.message);
                            //     $('#successModal').modal('show');

                            //     setTimeout(function(){
                            //         window.location.href = '/admin/dashboard';
                            //     }, 2000);
                            // }
                            if (response.status == "success") {
                                Swal.fire({
                                    
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
 forwardbtn.click(function() {
 
            Swal.fire({
                title: "Declaration",
                html: `
                    <div class="form-check ">
                        <label class="form-check-label" for="confirmVerification " style="color:red; text-center;font-size:18px">
                            I confirm that all documents have been verified by me as a supervisor.
                        </label>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: "Forward to {{ $applicant->application_status == 'RE' ? 'Secretary' : 'Accountant' }}",
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
                    var role = @json($nextForwardUser->name);
                    var remarks = $("#remarks").val().trim();
                   var application_status = @json($applicant->application_status);
// alert(application_status);

// alert(forwardedTo);


                    // alert(application_status);

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
                        url: '{{ route('admin.forwardApplicationformsb',["role" => "__ROLE__"]) }}'.replace('__ROLE__', role),
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
                            application_status : application_status,
                            queryswitch: queryswitch ? "Yes" : "No",
                            "queryType[]": queryType
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    
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


    confirmForward.click(function() {

    var applicationId = @json($applicant->application_id);
    var processedBy   = @json(Auth::user()->name);
    var role_id       = @json(Auth::user()->roles_id);
    var forwardedTo   = @json($nextForwardUser->roles_id);
    var role          = @json($nextForwardUser->name);
    var remarks       = $("#remarks").val().trim();
    var queryswitch   = $("#Queryswitch").prop("checked");
    var checkboxStatus = "No";
    var queryType = null;

    if (queryswitch === true) {
        queryType = $("#queryType").val();
        if (!queryType || queryType.length === 0) {
            $('#declarationModal').modal('hide');
            $("#queryToast").toast("show"); // Show Bootstrap Toast
            return false;
        }
        checkboxStatus = "Yes";
    }

    //  alert(
    //      "id: " + applicationId +
    //     "Role: " + role +
    //     "\nRemarks: " + remarks +
    //     "\nCheckbox Status: " + checkboxStatus +
    //     "\nQuery Type: " + (queryType ?? "None")
    // );

            $.ajax({
                url: '{{ route('admin.forwardApplicationformsb',["role" => "__ROLE__"]) }}'.replace('__ROLE__', role),
                type: 'POST',
                // contentType: 'application/json',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
               
               data: {
            application_id: applicationId,
            processed_by: processedBy,
            role_id: role_id,
            forwarded_to: forwardedTo,
            remarks: remarks,
            checkboxes: checkboxStatus,
             queryswitch: queryswitch,
            queryType: queryType
                },
                success: function(response) {

                    if (response.status == "success") {
                        // Cleanup Bootstrap modal instance on hide
                        $('#declarationModal').modal('hide');

                        $('#successModal .modal-body').html(`<p>${response.message}</p>`);
                        $('#successModal').modal('show');

                        $('#successModal').on('hidden.bs.modal', function() {
                            window.location.href =  BASE_URL + '/admin/dashboard'
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


<script>
    $(document).on("click", ".verify-license", function () {
    let license = $(this).data("license");
    let date = $(this).data("date");
    let proprietorId = $(this).data("id");

    $.ajax({
        url: "{{ route('admin.verify.license.formAccc_admin') }}", 
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            license_number: license,
            date: date
        },
        success: function (response) {
            if (response.exists) {
                $("#verify-result-" + proprietorId)
                    .html('<p class="text-success">Valid License</p>');
            } else {
                $("#verify-result-" + proprietorId)
                    .html('<p class="text-danger">Invalid License</p>');
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errMsg = errors.date ? errors.date[0] : "Validation failed";
                $("#verify-result-" + proprietorId)
                    .html('<p class="text-danger">' + errMsg + '</p>');
            }
        }
    });
});


$(document).on('click', '.verify-btn_EA', function () {
    let btn = $(this);
    let license = btn.data('license');
    let date = btn.data('date');
    let resultDiv = btn.siblings('.verify-result_EA');

    resultDiv.html('<p class="text-info">Checking...</p>');

    $.ajax({
    url: "{{ route('admin.verifylicenseformAea_admin') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            license_number: license,
            date: date
        },
        success: function (response) {
            if (response.exists) {
                resultDiv.html('<p class="text-success">Valid License</p>');
            } else {
                resultDiv.html('<p class="text-danger">Invalid License</p>');
            }
        },
        error: function () {
            resultDiv.html('<p class="text-danger">Error checking license</p>');
        }
    });
});



$(document).on('click', '.verify-btn_staff', function () {
    let btn = $(this);
    let license = btn.data('license');
    let date = btn.data('date');
    let resultDiv = btn.siblings('.verify-result_staff');

    resultDiv.html('<p class="text-info">Checking...</p>');

    $.ajax({
        url: "{{ route('admin.verifyLicenseFormAccc_adminstaff') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            license_number: license,
            date: date
        },
        success: function (response) {
            if (response.exists) {
                resultDiv.html('<p class="text-success">Valid License</p>');
            } else {
                resultDiv.html('<p class="text-danger">Invalid License</p>');
            }
        },
        error: function () {
            resultDiv.html('<p class="text-danger">Error checking license</p>');
        }
    });
});


// --------------------------------------------------------------------
$(document).on('click', '.history-btn_staff', function () {
    let btn = $(this);
    let license = btn.data('license');
    let date = btn.data('date');
    let application_id = btn.data('application_id');

    // Set modal title dynamically
    $("#showlicense .modal-title").text(`License History of ${license}`);

    // Clear any old data first
    $("#showlicense table tbody").html(`
        <tr>
            <td colspan="5" class="text-info">Fetching license history...</td>
        </tr>
    `);

    // Show modal immediately
    $("#showlicense").modal('show');

    // Fetch data via AJAX
    $.ajax({
        url: "{{ route('admin.history_resultstaff') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            license_number: license,
            date: date,
            application_id: application_id
        },
        success: function (response) {
            if (response.exists && response.html) {
                $("#showlicense table tbody").html(response.html);
            } else {
                $("#showlicense table tbody").html(`
                    <tr>
                        <td colspan="5" class="text-danger">❌ No license history found.</td>
                    </tr>
                `);
            }
        },
        error: function () {
            $("#showlicense table tbody").html(`
                <tr>
                    <td colspan="5" class="text-danger">⚠️ Error fetching license history.</td>
                </tr>
            `);
        }
    });
});







</script>
