@include('admin.include.top')
@include('admin.include.header')
@include('admin.include.navbar')
<style>
    .tab-content {
        padding: 0px 20px;
    }
      .tab-content {
        padding: 0px 20px;
    }
    .table td{
        text-align:left;
    }
    table th{
        font-weight:800!important;    
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
                                    <h4>Applicant Id : <span> {{ $applicant->application_id }}</span> Applicant Name : <span style="color:#098501;">{{ $applicant->applicant_name }} Applied For : <span style="color:#098501;"> {{ $applicant->form_name }}  | License {{ $applicant->license_name }}</span> </h4>
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
                                                        <div class="col-lg-4">


                                                            <p>{{ $applicant->applicant_name }}</p>

                                                            <p>{{ $applicant->business_address }}</p>


                                                        </div>

                                                    </div>


                                                </div>




                                            </div>





                                            <p class="mt-4 mb-2 fw-bold text-info">3. Proprietor Details</p>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
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
                                                        @forelse ($proprietordetailsform_A as $proprietor)
                                                        <tr>
                                                            <td>{{ $proprietor->proprietor_name }} </td>
                                                            <td> {{ $proprietor->fathers_name }}</td>
                                                            <td>{{ $proprietor->age }} </td>
                                                            <td>{{ $proprietor->proprietor_address }} </td>
                                                             <td> {{ $proprietor->qualification }}</td>
                                                           
                                                            <td> {{ $proprietor->present_business }}</td>

                                                            <td>


                                                                {{ $proprietor->competency_certificate_number }}

                                                                {{ $proprietor->competency_certificate_validity ? \Carbon\Carbon::parse($proprietor->competency_certificate_validity)->format('d-m-Y') : ''  }}

                                                                @if(isset($proprietor->proprietor_cc_verify) && $proprietor->proprietor_cc_verify== '1')
                                                                <p class="text-success">Valid License </p>
                                                                @elseif(isset($proprietor->proprietor_cc_verify) && $proprietor->proprietor_cc_verify== '0')
                                                                  <p class="text-danger">Invalid License </p>
                                                                @endif 
                                                                
                                                                  <button type="button" 
                                                                        class="btn btn-primary verify-license" 
                                                                        data-id="{{ $proprietor->id }}"
                                                                        data-license="{{ $proprietor->competency_certificate_number }}"
                                                                        data-date="{{ $proprietor->competency_certificate_validity ? \Carbon\Carbon::parse($proprietor->competency_certificate_validity)->format('d-m-Y') : '' }}">
                                                                    Verify
                                                                </button>

                                                                 <div id="verify-result-{{ $proprietor->id }}"></div>
                                                            </td>

                                                            <td>

                                                                {{ $proprietor->presently_employed_name }}<br> {{ $proprietor->presently_employed_address }}

                                                            </td>

                                                            
                                                            <td>

                                                                {{ $proprietor->previous_experience_lnumber }} {{  $proprietor->previous_experience_lnumber_validity ? \Carbon\Carbon::parse($proprietor->previous_experience_lnumber_validity)->format('d-m-Y') : '' }}

                                                             @switch($proprietor->proprietor_contractor_verify ?? null)
                                                                        @case('1')
                                                                            <p class="text-success">Valid License</p>
                                                                            @break
                                                                        @case('0')
                                                                            <p class="text-danger">Invalid License</p>
                                                                            @break
                                                                    @endswitch

                                                                     <button class="btn btn-sm btn-primary verify-btn_EA"
                                                                data-license="{{ $proprietor->previous_experience_lnumber }}"
                                                                data-date="{{ $proprietor->previous_experience_lnumber_validity }}">
                                                                Verify
                                                            </button>

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


                                                            <p class=" text-info"><strong>4. Name and Designation of authorised signatory (if any, in the case of a limited company):</strong></p>



                                                        </div>
                                                        <div class="col-lg-4">


                                                            <p>{{ strtoupper($applicant->authorised_name_designation) }}
                                                                @if($applicant->authorised_name_designation === 'yes')
                                                                - {{$applicant->authorised_name}} , {{$applicant->authorised_designation}}
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
                                                                </p>
                                                            
                                                             <div class="row">
                                                                 @if($applicant->previous_contractor_license === 'yes')
                                                                <div class="col-lg-6 col-6" >
                                                                <p>
                                                                    - {{$applicant->previous_application_number}}, 
                                                                    {{$applicant->previous_application_validity}}
                                                                </p>
                                                                </div>


                                                           <div class="col-lg-6 col-6 d-flex align-items-center">
                                                            <div class="verify-result_EA "></div>  <!-- Result on left -->
                                                            <button class="btn btn-sm btn-primary verify-btn_EA"
                                                                data-license="{{ $applicant->previous_application_number }}"
                                                                data-date="{{ $applicant->previous_application_validity }}">
                                                                Verify
                                                            </button>
                                                        </div>

                                                                 @endif

                                                             </div>
                                                             
                                                              
                                                                
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
                                                             <a href="{{ asset($decryptedaadhar_doc) }}"><i class="fa fa-file-pdf-o text-red"></i> View </a>
                                                          </div>
                                                    </div>

                                                    <div class="row">
                                                          <div class="col-lg-6 col-6">
                                                             <p> {{ $maskedPan }}</p>
                                                          </div>

                                                           <div class="col-lg-6 col-6">
                                                             <a href="{{ asset($decryptedpancard_doc) }}"><i class="fa fa-file-pdf-o text-red"></i> View </a>
                                                          </div>
                                                    </div>

                                                    <div class="row">
                                                          <div class="col-lg-6 col-6">
                                                             <p> {{ $maskedgst }}</p>
                                                          </div>

                                                           <div class="col-lg-6 col-6">
                                                             <a href="{{asset($decryptedgst_doc) }}"><i class="fa fa-file-pdf-o text-red"></i> View </a>
                                                          </div>
                                                    </div>
                                                   

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                     

                                        <div class="row mt-3">
                                            <div id="specific-class" class="col-lg-12">
                                                <div class="form-check">
                                                    <input type="checkbox" id="signature_form" name="signature_form" class="form-check-input" checked>
                                                    <label class="form-check-label" for="signature_form">Applicant Signature in Application Form</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="sign_attached" name="sign_attached" class="form-check-input" checked>
                                                    <label class="form-check-label" for="sign_attached">Applicant Sign attached by Officer</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="edu_certificate" name="edu_certificate" class="form-check-input" checked>
                                                    <label class="form-check-label" for="edu_certificate">Educational Qualification Certificate</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="dob_proof" name="dob_proof" class="form-check-input" checked>
                                                    <label class="form-check-label" for="dob_proof">Proof of D.O.B</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="photograph" name="photograph" class="form-check-input" checked>
                                                    <label class="form-check-label" for="photograph">Photograph</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="specimen_signature" name="specimen_signature" class="form-check-input" checked>
                                                    <label class="form-check-label" for="specimen_signature">Specimen Signature</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="fees_details" name="fees_details" class="form-check-input" checked>
                                                    <label class="form-check-label" for="fees_details">Fees Details</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="age_details" name="age_details" class="form-check-input" checked>
                                                    <label class="form-check-label" for="age_details">Age 18</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="experience_details" name="experience_details" class="form-check-input" checked>
                                                    <label class="form-check-label" for="experience_details">Two Years Experience after Degree/Diploma</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="all_doc_verification" name="all_doc_verification" class="form-check-input" checked>
                                                    <label class="form-check-label" for="all_doc_verification">All Documents Filled by Applicant</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="safety_certificate" name="safety_certificate" class="form-check-input" checked>
                                                    <label class="form-check-label" for="safety_certificate">Safety Certificate/ List of Equipment</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="contract_copy" name="contract_copy" class="form-check-input" checked>
                                                    <label class="form-check-label" for="contract_copy">Contract Copy of HT Works</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="ht_experience_cert" name="ht_experience_cert" class="form-check-input" checked>
                                                    <label class="form-check-label" for="ht_experience_cert">HT Experience Certificate in Specimen Format/ Transformer Details</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="experience_in_tamilnadu" name="experience_in_tamilnadu" class="form-check-input" checked>
                                                    <label class="form-check-label" for="experience_in_tamilnadu">Experience in TamilNadu</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="intimation_letter" name="intimation_letter" class="form-check-input" checked>
                                                    <label class="form-check-label" for="intimation_letter">Intimation Letter</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="complete_experience_details" name="complete_experience_details" class="form-check-input" checked>
                                                    <label class="form-check-label" for="complete_experience_details">Complete Experience Details</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" id="required_qualification_certificate" name="required_qualification_certificate" class="form-check-input" checked>
                                                    <label class="form-check-label" for="required_qualification_certificate">Required Qualification Certificate</label>
                                                </div>
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
                                                        <th>Competency Certificate <br> Number</th>
                                                        <th>Competency Certificate <br> Validity</th>
                                                        <th>License Status</th>
                                                        <th>Admin Check</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($staffdetails as $staff)
                                                    <tr>
                                                         <td>{{ $staff->staff_name }}</td>
                                                        <td>{{ $staff->staff_qualification }}</td>
                                                        <td>{{ $staff->staff_category }}</td>
                                                        <td>{{ $staff->cc_number }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($staff->cc_validity)->format('d-m-Y') }}</td>

                                                     <td>
                                                            @switch($staff->staff_cc_verify ?? null)
                                                                @case('1')
                                                                    <p class="text-success">Valid License</p>
                                                                    @break
                                                                @case('0')
                                                                    <p class="text-danger">Invalid License</p>
                                                                    @break
                                                                @default
                                                                    <p class="text-muted">Not Verified</p>
                                                            @endswitch
                                                        </td>

                                                        <td>
                                                            <button class="btn btn-primary verify-btn_staff"
                                                                data-license="{{ $staff->cc_number }}"
                                                                data-date="{{ \Carbon\Carbon::parse($staff->cc_validity)->format('d-m-Y') }}">
                                                                Verify License
                                                            </button>
                                                            <span class="verify-result_staff"></span>
                                                        </td>


                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">No Staffs available.</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mt-3">
                                           
                                             <div class="row ">
                                                <div class="col-lg-12">
                                                    <p class="text-info"><strong>10. Bank and Address</strong></p>
                                                </div>
                                            </div>
                                              <div class="col-lg-6">
                                                <p><strong>Bank Name</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>{{ $applicant->bank_address }}</p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p><strong>Validity</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>{{ format_date($applicant->bank_validity) }}</p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p><strong>Amount:</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <P>{{ $applicant->bank_amount }}</P>
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
                                            <p><strong>11. Has the applicant or any of his/her staff referred to under item 6, been
                                                    at any time convicted in any court of law or punished by any other
                                                    authority for criminal offences</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->criminal_offence) }}</p>
                                        </div>




                                        <div class="col-lg-10">
                                            <p><strong>12.(i) Whether consent letter, of the competency certificate holder are enclosed. (including for self)</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->consent_letter_enclose) }}</p>
                                        </div>


                                        <div class="col-lg-10">
                                            <p><strong>(ii) Whether original booklet of competency certificate holders are enclosed? (including for self)</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->cc_holders_enclosed) }}</p>
                                        </div>


                                        <div class="col-lg-10">
                                            <p><strong>13. (i). Whether purchase bill for all the instruments are enclosed in Original.</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->purchase_bill_enclose) }}</p>
                                        </div>


                                        <div class="col-lg-10">
                                            <p><strong>(ii). Whether the test reports for instruments and deeds for possess of the instruments are enclosed in original?</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->test_reports_enclose) }}</p>
                                        </div>


                                        <div class="col-lg-10">
                                            <p><strong>14. (i). Whether specimen signature of the Proprietor or of the authorised
                                                    signatory (in case of limited company in triplicate is enclosed)</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->specimen_signature_enclose) }}</p>
                                        </div>


                                        <div class="col-lg-10">
                                            <p><strong>(ii). The name of the person(s) whom the applicant has authorized to sign, if any, on his/their
                                                    behalf in case of Proprietor or Partnership concern</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            @php
                                            $authorizedPersons = json_decode($applicant->name_of_authorised_to_sign, true);
                                            @endphp

                                            @if(!empty($authorizedPersons))

                                            @foreach($authorizedPersons as $person)
                                            <p>{{ strtoupper($person) }}</p>
                                            @endforeach

                                            @else
                                            <p>No authorized persons.</p>
                                            @endif
                                        </div>

                                        <div class="col-lg-10">
                                            <p><strong>(iii). Whether the applicant enclosed the specimen signature of the above
                                                    person/ persons in triplicate in a separate sheet of paper</strong></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p>{{ strtoupper($applicant->separate_sheet) }}</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="payment-tab-panel" role="tabpanel" aria-labelledby="payment-tab" tabindex="0">
                                    <div class="row mt-3">
                                        <div class="row mt-3">
                                            <div class="col-lg-6">
                                                <p><strong> Payment Status</strong></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p class="badge badge-success">{{ strtoupper($applicant->payment_status) ?? 'NA' }}</p>
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
                        <!-- <div class="modal-footer mt-2">
                            <button class="btn btn-light-dark _effect--ripple waves-effect waves-light  " style="margin-right: 20px;" data-bs-dismiss="modal">Discard</button>
                            <button type="button" class="btn btn-primary _effect--ripple waves-effect waves-light">Save</button>
                        </div> -->
                    </div>

                </div>
                </div>
                

                <div class="row">

                <div id="tabsSimple" class="col-xl-6 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow mb-2">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                @if (isset($queries->query_status) && $queries->query_status === 'P')
                                    @php $checked = 'checked'; @endphp
                                @else
                                    @php $checked = ''; @endphp
                                @endif

                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">If you have any queries</label>
                                    <input class="form-check-input" type="checkbox" role="switch" id="Queryswitch" {{ $checked }}>
                                </div>
                            </div>
                        </div>
                        <div class="statbox widget box box-shadow" id="queryOptions" style="display: none;">
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                    @php
                                        // Ensure $selectedQueries is always an array
                                        $selectedQueries = [];

                                        if (!empty($queries) && isset($queries->query_type)) {
                                            $selectedQueries = json_decode($queries->query_type, true);
                                        }
                                    @endphp
                                        {{-- <label class="fw-bold">Select Query Type:</label> --}}
                                        <select class="form-control" id="queryType" name="queryType[]" multiple>
                                            <option value="general" {{ in_array('general', $selectedQueries) ? 'selected' : '' }}>General Query</option>
                                            <option value="technical" {{ in_array('technical', $selectedQueries) ? 'selected' : '' }}>Technical Query</option>
                                            <option value="other" {{ in_array('other', $selectedQueries) ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Remarks</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-8 col-md-offset-2">
                                <textarea class="form-control" name="remarks" id="remarks" rows="4" cols="50"></textarea>
                            </div>

                        </div>

                        <div class="modal-footer mt-2">
                            @if (isset($nextForwardUser))
                                <button class="btn btn-success " style="margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#forwardmodal">Forward to President</button>
                            @else
                                <button class="btn btn-success " style="margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#declarationModal">Submit / Approve</button>
                            @endif
                            <button id="returntoSuper" class="btn btn-warning " style="margin-right: 20px;">Return to Supervisor</button>
                            <button type="button" class="btn btn-danger">Reject</button>
                        </div>
                    </div>

                    <!-- ------------------------------------ -->
                    <!-- ------------------------------------ -->
                    
                 
                </div>

                <div class="col-md-6">
                    <div id="timelineMinimal" class="col-lg-12 layout-spacing mt-2">
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
                                            <div class="t-dot {{ $row->appl_status == 'RE' ? 't-dot-danger' : 't-dot-info' }}"></div>
                                            <div class="t-text">
                                                <p>{{ $row->appl_status == 'RE' ? 'Return By': 'Processed by:'}} {{ $row->processed_by }}</p>
                                                <p class="t-meta-time">
                                                    @if (!$row->name)
                                                    Approved By: {{ $row->processed_by }}
                                                    @else()
                                                    Forwarded to: {{ $row->name }} → Remarks: {{ $row->remarks }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="item-timeline">
                                            <p class="t-time">{{ \Carbon\Carbon::parse($user_entry->created_at)->format('d-m-Y H:i:s') }}</p>
                                            <div class="t-dot {{ $user_entry->id ? 't-dot-info' : 't-dot-warning' }}"></div>
                                            <div class="t-text">
                                                <p>Applicant Submitted the Application</p>
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

                

            <!-- -------------------------------------------- -->
            <!-- <div class="row">
              
            </div> -->

        </div>
    </div>
</div>
<!-- Modal -->

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
                <button type="button" class="btn btn-success" id="confirmForward">Forward to President</button>
            </div>
        </div>
    </div>
</div>

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
    
    document.getElementById('Queryswitch').addEventListener('change', function () {
        document.getElementById('queryOptions').style.display = this.checked ? 'block' : 'none';
    });
    
    
    // $('#remarks').maxlength({
    //     placement:"top"
    // });
    $(document).ready(function () {
        var checkAllBox         = $('#check_all');
        var resetAllBox         = $('#reset_all');
        var forwardbtn          = $("#forwardbtn");
        var confirmForward      = $("#confirmForward");
        var confirmVerification = $('#confirmVerification');
        // var individualCheckboxes = $('.form-check-input:not(#check_all):not(#reset_all)');
        var individualCheckboxes = $('#specific-class .form-check-input:not(#check_all, #reset_all)');
    
        

        // forwardbtn.prop('disabled', $('.form-check-input:not(#check_all):checked').length === 0);
    
        // Initially disable Reset All
        resetAllBox.prop('disabled', true);
    
        checkAllBox.change(function () {
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
        resetAllBox.change(function () {
            if ($(this).prop('checked')) {
                individualCheckboxes.prop('checked', false);
                checkAllBox.prop('checked', false);  // Uncheck Check All
                checkAllBox.prop('disabled', false); // Enable Check All
                resetAllBox.prop('disabled', true);  // Disable Reset All after use
                forwardbtn.prop('disabled',true); 
            }
        });
    
        // If any individual checkbox is manually unchecked, uncheck "Check All"
        individualCheckboxes.change(function () {
            if ($('.form-check-input:not(#check_all):not(#reset_all):checked').length === individualCheckboxes.length) {
                checkAllBox.prop('checked', true);
            } else {
                checkAllBox.prop('checked', false);
            }
        });
    
    
        confirmForward.click(function () { 


            console.log('sfsf');
    
            var queryType = [];
    
            var applicationId   = @json($applicant->application_id);
            var processedBy     = @json(Auth::user()->name);
            var role_id         = @json(Auth::user()->roles_id);
            var forwardedTo     = @json($nextForwardUser->roles_id);
            var role            = @json($nextForwardUser->name);
            var remarks         = $("#remarks").val().trim();
            var queryswitch     = $("#Queryswitch").prop("checked");
            var checkboxStatus  = "Yes";

            
            queryType           = $("#queryType").val();
            
            if (queryswitch == true) {
                if (!queryType || queryType.length === 0) {  // Ensure queryType is not empty
                    $('#declarationModal').modal('hide');
                    $("#queryToast").toast("show"); // Show Bootstrap Toast using jQuery
                    return false;
                }
            }else{
                var checkboxStatus  = "No";
                queryType           = null; 
            }
            
    
            $.ajax({
                url: '{{ route('admin.forwardApplicationforma',["role" => "__ROLE__"]) }}'.replace('__ROLE__', role),
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
                    queryswitch: queryswitch, // Only "Yes" or "No"
                    "queryType[]": queryType 
                },
                success: function (response) {
    
                    if (response.status == "success") {
                        // Cleanup Bootstrap modal instance on hide
                        $('#declarationModal').modal('hide');
    
                        $('#successModal .modal-body').html(`<p>${response.message}</p>`);
                        $('#successModal').modal('show');
        
                        $('#successModal').on('hidden.bs.modal', function () {
                            window.location.href = BASE_URL +'/admin/dashboard'
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



</script>