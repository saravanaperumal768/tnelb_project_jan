@include('include.header')
<style>
    hr {
        margin-top: 2px;
        margin-bottom: 5px;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, .1);
    }

    .form-group {
        margin-bottom: 0px;
    }

    .apply-card label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-size: 15px;
        font-weight: 500;
    }

    /* .apply-card-header a {
        color: #ff0505;
        font-weight: 700;
    }
    .apply-card-header a i {
    color: #ff0505;
} */

    .swal2-popup.swal2-modal.swal2-show {
        width: 100%;
    }

    .swal2-popup li {
        font-size: 15px;
        margin-bottom: 8px;
    }


    .swal2-popup li {
        font-size: 15px;
        margin-bottom: 8px;
    }

    .swal2-popup li ul {
        margin-left: 15px;
    }

    th {
        /* font-weight: 500; */
        font-size: 14px;
    }
</style>


<section class="">
    <div class="container">
        <ul id="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-home"> </span> Dashboard</a></li>
            <li><a href="#"><span class=" fa fa-info-circle"> </span> Form A - Renewal</a></li>

        </ul>
    </div>
</section>
<!-- <pre>
{{ Auth::user() }}
</pre>
exit; -->



<section class="tabs-section apply-card">
    <div class="container">
        <div class="apply-card-header" style="background-color: #70c6ef  !important;">
            <div class="row">
                <div class="col-6 col-lg-8">
                    <h5 class="card-title_apply text-black text-left"> <span style="font-weight: 600;">Renewal
                            Application for Electrical Contractor's Licence-Grade `A' </span></h5>
                    <h6 class="card-title_apply text-black text-left">(Read the Instructions overleaf before filling the
                        form)</h6>
                </div>

                <div class="col-6 col-lg-4 text-md-right">
                    <span style="color: #000;"> <i class="fa fa-file-pdf-o" style="color: red;"></i>&nbsp; Enclosures
                        Download 38 KB</span>
                    <br>
                    <a href="{{ url('assets/pdf/form_a_notes.pdf') }}" class="text-dark" target="_blank">English |
                        தமிழ்</a>

                </div>



            </div>
        </div>

        <form id="competency_form_a" enctype="multipart/form-data">

            @csrf
            <input type="hidden" class="form-control text-box single-line" id="login_id_store" name="login_id_store"
                value="{{ Auth::user()->login_id }}">
            <input type="hidden" class="form-control text-box single-line" id="form_name" name="form_name"
                value="EA">

            <input type="hidden" id="application_id" name="application_id"
                value="{{ $application->application_id ?? '' }}">
            <input type="hidden" class="form-control text-box single-line" id="license_name" name="license_name"
                value="A">
            <input type="hidden" class="form-control text-box single-line" id="license_number" name="license_number"
                value="{{ $license_details->license_number ?? '' }}">

            <input type="hidden" class="form-control text-box single-line" id="appl_type" name="appl_type" value="R">

            <input type="hidden" class="form-control text-box single-line" id="form_id" name="form_id"
                value="5">
            <input type="hidden" class="form-control text-box single-line" id="amount" name="amount"
                value="6000">

            <input type="hidden" name="record_id" id="record_id" value="{{ $application->application_id ?? '' }}">

            <input type="hidden" id="appl_type" name="appl_type" value="R">
            <div class="tabs" id="tabbedForm">
                <div class="row">
                    <div class="col-12 col-md-12 text-md-right">
                        <p style="color: #023466;font-weight:600;"> <span style="color: red;">*</span> Fileds are Mandatory </p>
                    </div>

                </div>

                <nav class="tab-nav"></nav>
                @php
                $application = $application ?? null;
                @endphp
                <div class="tab" data-name="Basic Details">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-12">
                                    <label for="Name">1. Name in which Electrical Contractor's licence is applied for <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-12 col-md-12">


                                    <input autocomplete="off" class="form-control text-box single-line" id="applicant_name" name="applicant_name" type="text" placeholder="Name in which Electrical Contractor's licence is applied for" maxlength="50" value="{{ old('applicant_name', $application->applicant_name ?? '') }}">
                                    <span class="error text-danger" id="applicant_name_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-12">
                                    <label for="Name">2. Business Address <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-12 col-md-12">
                                    <textarea id="business_address" rows="2" class="form-control" name="business_address" placeholder="Business Address"> {{ $application->business_address ?? '' }}</textarea>
                                    <span class="error text-danger" id="business_address_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (!empty($proprietors) && $proprietors->isNotEmpty())
                    <div class="mt-4 table-responsive" style="display: none;">
                        <h5 class="pb-2">Details of Proprietor or Partners or Directors</h5>
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Age</th>
                                    <th>Qualification</th>
                                    <th>Father/Husband's Name</th>
                                    <th>Present Business</th>
                                    <th>Competency Certificate</th>
                                    <th>Employment Details</th>
                                    <th>Experience Details</th>
                                    <th class="text-center" colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proprietors as $index => $prop)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $prop->proprietor_name }}</td>
                                    <td>{{ $prop->proprietor_address }}</td>
                                    <td>{{ $prop->age }}</td>
                                    <td>{{ $prop->qualification }}</td>
                                    <td>{{ $prop->fathers_name }}</td>
                                    <td>{{ $prop->present_business }}</td>
                                    <td>
                                        @if ($prop->competency_certificate_holding === 'yes')
                                        Number: {{ $prop->competency_certificate_number }}<br>
                                        Validity: {{ $prop->competency_certificate_validity }}
                                        @else
                                        No
                                        @endif
                                    </td>
                                    <td>
                                        @if ($prop->presently_employed === 'yes')
                                        {{ $prop->presently_employed_name }}<br>
                                        {{ $prop->presently_employed_address }}
                                        @else
                                        No
                                        @endif
                                    </td>
                                    <td>
                                        @if ($prop->previous_experience === 'yes')
                                        {{ $prop->previous_experience_name }}<br>
                                        {{ $prop->previous_experience_address }}<br>
                                        License No: {{ $prop->previous_experience_lnumber }}<br>
                                        License Validity: {{ $prop->previous_experience_lnumber_validity }}
                                        @else
                                        No
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" type="button"> <i class="fa fa-pencil"></i> </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button"> <i class="fa fa-trash-o"></i> </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <!-- <p class="text-muted mt-4">No proprietor/partner details found.</p> -->
                    @endif





                    <div class="row align-items-center head_label mt-2">
                        <div class="col-12 col-md-12 title_bar">
                            <label>3) Proprietor / Partners / Directors Details<span style="color: red;">*</span></label>

                        </div>

                    </div>



                    @php
                    $proprietors = $proprietors ?? collect();
                    @endphp
                    @php
                    $hasData = !empty($proprietors->proprietor_name) ||
                    !empty($proprietors->proprietor_address) ||
                    !empty($proprietors->age) ||
                    !empty($proprietors->qualification);
                    @endphp
                    @if($proprietors->isNotEmpty())
                    <!-- ----------draft------------- -->





                    @foreach($proprietors as $index => $proprietor)


                    @php
                    $draftproprietor = count($proprietors);
                    @endphp

                    <div class="border box-shadow-blue p-3 mt-3 proprietor-entry">

                        <div class="row">
                            <div class="col-md-8">
                                <h5>Proprietor/Partner Details Renewal {{ $index + 1 }}</h5>
                            </div>
                            @if($index > 0)
                            <div class="col-md-4 text-right">
                                <button type="button" class="btn btn-danger remove-proprietor-entry"><i class="fa fa-trash"></i> Remove</button>
                            </div>
                            @endif
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-12">
                                        <label for="Name">(i) Full name and house address of proprietor or partners or Directors <span style="color: red;">*</span><br><span class="text-label" style="color: #023466;">(If it is partnership concern, partnership deed should be enclosed)</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <!-- <textarea rows="3" class="form-control" name="proprietor_name"></textarea> -->
                                        <label>Proprietor Name <span class="text-red">*</span></label>
                                        <input type="text" class="form-control mb-2" maxlength="50" name="proprietor_name[]" placeholder="Name" value="{{ $proprietor->proprietor_name }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">

                                        <span class="error text-danger proprietor_name_error" id="proprietor_name_error"></span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label>Proprietor Address <span class="text-red">*</span></label>
                                        <textarea rows="3" class="form-control" name="proprietor_address[]" placeholder="Address">{{ $proprietor->proprietor_address}}</textarea>
                                        <span class="error text-danger" id="proprietor_address_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-12">
                                        <label for="Name">(ii) Age and qualification along with
                                            evidence <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label>Age <span class="text-red">*</span></label>
                                        <input type="number" class="form-control" id="age" name="age[]" maxlength="2" min="15" max="70" placeholder="Age" value="{{ $proprietor->age }}">
                                        <span class="error text-danger" id="age_error"></span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label>Qualification <span class="text-red">*</span></label>
                                        <input type="text" class="form-control" id="qualification" name="qualification[]" placeholder="Qualification" value="{{ $proprietor->qualification }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                        <!-- <input type="text"
                                        class="form-control" id="validity" name="validity"
                                        placeholder="Validity"
                                        onfocus="(this.type='date')"
                                        onblur="(this.type='text')"> -->
                                        <span class="error text-danger" id="qualification_error"></span>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="proprietor_id[]" value="{{ $proprietor->id }}">

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="Name">(iii) Father/Husband's name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="fathers_name[]" value="{{ $proprietor->fathers_name }}" placeholder="Father/Husband Name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                <span class="error text-danger" id="fathers_name_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="Name">(iv) Present business of the applicant <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="present_business[]" value="{{ $proprietor->present_business }}" placeholder="Present business">
                                <span class="error text-danger" id="present_business_error"></span>
                            </div>
                        </div>



                        <div class="row mt-3">

                            <div class="col-md-6">

                                <label>(v) Whether holding a competency certificate and if so, the number and validity of the competency certificate <span class="text-red">*</span></label><br>
                                @php
                                $showCompetencyFields = $proprietor->competency_certificate_holding == 'yes';
                                @endphp
                                <!-- Radio buttons -->
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="competency_certificate_holding[{{ $index }}]" value="yes"
                                        {{ $proprietor->competency_certificate_holding == 'yes' ? 'checked' : '' }}
                                        onclick="toggleCompetencyFieldsdraft(true, {{ $index }})">
                                    Yes
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="competency_certificate_holding[{{ $index }}]" value="no"
                                        {{ $proprietor->competency_certificate_holding == 'no' ? 'checked' : '' }}
                                        onclick="toggleCompetencyFieldsdraft(false, {{ $index }})">
                                    No
                                </div>
                                <span class="error text-danger" id="competency_certificate_holding_error"></span>
                                <!-- Conditional Fields -->
                                <div class="row">
                                    @php
                                    $isVerified = isset($proprietor->proprietor_cc_verify) && $proprietor->proprietor_cc_verify === '1';
                                    @endphp
                                    <div class="col-12 col-md-5 mt-1 competency-fields-{{ $index }}" style="{{ $showCompetencyFields ? '' : 'display: none;' }}">
                                        <label>Competency Certificate No <span style="color: red;">*</span></label>
                                        <input type="text"
                                            class="form-control mt-1 competency_number"
                                            name="competency_certificate_number[]"
                                            maxlength="15"
                                            placeholder="Certificate Number"
                                            value="{{ $proprietor->competency_certificate_number ?? '' }}"
                                            {{ $isVerified ? 'readonly' : '' }}>
                                        <span class="error text-danger competency_number_error"></span>
                                        <br>
                                      <div class="license-status">
                                        @if($isVerified)
                                            <span class="text-success text-center"><i class="fa fa-check"></i> Valid License</span>
                                        @else
                                            <span class="text-danger text-center"><i class="fa fa-close"></i> Invalid License</span>
                                        @endif
                                    </div>

                                    </div>

                                    <div class="col-12 col-md-5 mt-1 competency-fields-{{ $index }}" style="{{ $showCompetencyFields ? '' : 'display: none;' }}">
                                        <label>Validity <span style="color: red;">*</span></label>
                                        <input type="text"
                                            class="form-control competency_validity"
                                            name="competency_certificate_validity[]"
                                            placeholder="Validity"
                                            onfocus="(this.type='date')"
                                            value="{{ isset($proprietor->competency_certificate_validity) ? \Carbon\Carbon::parse($proprietor->competency_certificate_validity)->format('d-m-Y') : '' }}"
                                            {{ $isVerified ? 'readonly' : '' }}>
                                        <span class="error text-danger competency_validity_error"></span>
                                    </div>
                                    <div class="col-12 col-md-2 mt-3 competency-fields-{{ $index }}" style="{{ $showCompetencyFields ? '' : 'display: none;' }}">

                                        

                                        @if ($isVerified)
                                        <button type="button" class="btn btn-danger mt-3 clear-btn" onclick="clearCompetencyVerification(this)">Clear</button>
                                        @else
                                        <button type="button" class="btn btn-primary mt-3 verify-btn" onclick="verifyCompetencyCertificate(event, this)">Verify</button>
                                        @endif


                                        <input type="hidden" name="proprietor_cc_verify[]" class="proprietor_cc_verify" value="{{ $proprietor->proprietor_cc_verify ?? '' }}">

                                    </div>
                                    <!-- @if($proprietor->proprietor_cc_verify === '1')
                                    <span class="text-success small text-center"> <i class="fa fa-check"></i> Valid License</span>
                                    @endif -->
                                    <div class="col-12 mt-1">
                                        <div class="text-danger competency_verify_result"></div>

                                    </div>




                                </div>

                            </div>


                            <div class="col-md-6">
                                <label>(vi) Whether he is presently employed anywhere, If so the name and address of the employer, If not details of the Present business <span class="text-red">*</span></label>

                                @php
                                $showEMployerdetails = $proprietor->presently_employed == 'yes';
                                @endphp

                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="presently_employed[{{ $index }}]" value="yes" onclick="toggleEmploymentFieldsdraft(true, {{ $index }})" {{ $proprietor->presently_employed == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="employed_yes">Yes</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="presently_employed[{{ $index }}]" value="no" onclick="toggleEmploymentFieldsdraft(false, {{ $index }})" {{ $proprietor->presently_employed == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="employed_yes">No</label>
                                </div>

                                <span class="error text-danger presently_employed_error" id="presently_employed_error"></span>

                                <div class="row">

                                    <div class="col-12 col-md-5 mt-1 employment-fields-{{ $index }}" style="{{ $showEMployerdetails ? '' : 'display: none;' }}">
                                        <label>Name of the Employer <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="presently_employed_name" name="presently_employed_name[]" maxlength="50" placeholder="Name" value="{{ $proprietor->presently_employed_name }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                        <span class="error text-danger presently_employed_name_error"></span>

                                    </div>

                                    <div class="col-12 col-md-5 mt-1 employment-fields-{{ $index }}" style="{{ $showEMployerdetails ? '' : 'display: none;' }}">
                                        <label>Address of the Employer <span style="color: red;">*</span></label>
                                        <textarea class="form-control presently_employed_address" id="presently_employed_address" name="presently_employed_address[]" placeholder="Employer Address">{{ $proprietor->presently_employed_address }}</textarea>
                                    </div>



                                    <div class="col-12 mt-1">
                                        <div class="text-danger competency_verify_result"></div>
                                    </div>

                                </div>


                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>(vii) If holding a competency certificate, details of previous experience with period. If the applicant has worked under a contractor, licensed by this Licensing Board, the name, address, and licence No. of the contractor. <br>
                                    (Note: Details should be furnished for each partner/Director) <span class="text-red">*</span>
                                </label>
                                @php
                                $showpreviousexpdetails = $proprietor->previous_experience == 'yes';
                                @endphp
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input"
                                        name="previous_experience[{{ $index }}]"
                                        value="yes"
                                        onclick="toggleExperienceFieldsdraft(true, {{ $index }})"
                                        {{ $proprietor->previous_experience == 'yes' ? 'checked' : '' }}> Yes
                                </div>

                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input"
                                        name="previous_experience[{{ $index }}]"
                                        value="no"
                                        onclick="toggleExperienceFieldsdraft(false, {{ $index }})"
                                        {{ $proprietor->previous_experience == 'no' ? 'checked' : '' }}> No
                                </div>

                                <span class="error text-danger previous_experience_error" id="previous_experience_error"></span>

                                <div class="mt-2 experience-fields-{{ $index }}" style="{{ $showpreviousexpdetails ? '' : 'display: none;' }}">

                                    <div class=" row">
                                        @php
                                        $isVerified_contractor_license = isset($proprietor->proprietor_contractor_verify) && $proprietor->proprietor_contractor_verify === '1';
                                        @endphp
                                        <div class="col-12 col-md-5 mt-1">
                                            <label>Name of the Contractor <span class="text-red">*</span></label>
                                            <input class="form-control " type="text" id="previous_experience_name" name="previous_experience_name[]" placeholder="Name" value="{{ $proprietor->previous_experience_name }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">

                                            <span class="error text-danger previous_experience_name_error"></span>
                                        </div>
                                        <div class="col-12 col-md-5 mt-1">
                                            <label>Address of the Contractor <span class="text-red">*</span></label>
                                            <textarea class="form-control previous_experience_address" id="previous_experience_address" name="previous_experience_address[]" placeholder="Address">{{ $proprietor->previous_experience_address }}
                                            </textarea>

                                            <span class="error text-danger previous_experience_address_error"></span>
                                        </div>

                                        <div class="col-12 col-md-4 mt-1">
                                            <label>Previous Electrical Assistance License Number <span class="text-red">*</span></label>
                                            <input class="form-control ea_license_number" type="text" id="previous_experience_lnumber" maxlength="15" name="previous_experience_lnumber[]" placeholder="License Number"
                                                value="{{ $proprietor->previous_experience_lnumber }}" {{ $isVerified_contractor_license ? 'readonly' : '' }}>

                                            <span class="error text-danger previous_experience_lnumber_error"></span>
                                            <br>
                                                <div class="license-status">
                                                @if($isVerified_contractor_license)
                                                <span class="text-success  text-center"> <i class="fa fa-check"></i> Valid License</span>
                                            @else
                                            <span class="text-danger text-center"> <i class="fa fa-close"></i> Invalid License</span>
                                            @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mt-1">
                                            <label>Previous Electrical Assistance License Validity <span class="text-red">*</span></label>
                                            <input class="form-control ea_validity" type="text"

                                                id="previous_experience_lnumber_validity" name="previous_experience_lnumber_validity[]"
                                                value="{{ \Carbon\Carbon::parse($proprietor->previous_experience_lnumber_validity)->format('d-m-Y') }}"
                                                onfocus="(this.type='date')"
                                                placeholder="License Number Validity" {{ $isVerified_contractor_license ? 'readonly' : '' }}>

                                            <span class="error text-danger previous_experience_lnumber_validity_error"></span>
                                        </div>

                                        <div class="col-12 col-md-2 mt-4">
                                            @if ($isVerified_contractor_license)
                                            <!-- Show Clear if verified -->
                                            <button type="button" class="btn btn-danger mt-3 clear-btn" onclick="clearContractorLicenseVerification(this)">Clear</button>
                                            @else
                                            <!-- Show Verify if not verified -->
                                            <button type="button" class="btn btn-primary mt-3 verify-btn" onclick="verifyeaCertificate(event, this)">Verify</button><br>
                                            @endif
                                        </div>


                                        <input type="hidden" name="proprietor_contractor_verify[]" class="proprietor_contractor_verify" value="{{ $proprietor->proprietor_contractor_verify ?? '' }}">
                                        <!-- @if($proprietor->proprietor_contractor_verify === '1')

                                        <span class="text-success small text-center"> <i class="fa fa-check"></i> Valid License</span>
                                        @endif -->
                                        <div class="col-12 mt-1">
                                            <div class="text-danger competency_verifyea_result"></div>
                                        </div>
                                    </div>
                                </div>
                                @if($loop->last)
                                @if($draftCount < 4)
                                    <div class="col-md-12 ">
                                    <div class=" mt-4 ">
                                        <!-- <h3>Proprietor/Partner Details</h3> -->
                                        <div class="col-12 col-md-12 text-md-right" id="static-add-button-wrapper">
                                            <button id="add-more-proprietor-draft" class="btn btn-primary text-md-right"><i class="fa fa-plus"></i> Add Draft Proprietor /Partner</button>
                                        </div>
                                        <div id="proprietor-container"></div>
                                    </div>

                            </div>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach



                @else


                <div class=" border box-shadow-blue p-3 mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Proprietor/Partner Details fresh 1</h5>
                        </div>
                    </div>
                    <div class="row mt-3">


                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-12">
                                    <label for="Name">(i) Full name and house address of proprietor or partners or Directors <span style="color: red;">*</span><br><span class="text-label" style="color: #023466;">(If it is partnership concern, partnership deed should be enclosed)</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <!-- <textarea rows="3" class="form-control" name="proprietor_name"></textarea> -->
                                    <label>Proprietor Name <span class="text-red">*</span></label>
                                    <input type="text" class="form-control mb-2" maxlength="50" name="proprietor_name[]" placeholder="Name">

                                    <span class="error text-danger" id="proprietor_name_error"></span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Proprietor Address <span class="text-red">*</span></label>
                                    <textarea rows="3" class="form-control" name="proprietor_address[]" placeholder="Address"></textarea>
                                    <span class="error text-danger" id="proprietor_address_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-12">
                                    <label for="Name">(ii) Age and qualification along with
                                        evidence <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label>Age <span class="text-red">*</span></label>
                                    <input type="number" class="form-control" id="age" name="age[]" maxlength="2" min="15" max="70" placeholder="Age" value="">
                                    <span class="error text-danger" id="age_error"></span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Qualification <span class="text-red">*</span></label>
                                    <input type="text" class="form-control" id="qualification" name="qualification[]" placeholder="Qualification" value="">
                                    <!-- <input type="text"
                                        class="form-control" id="validity" name="validity"
                                        placeholder="Validity"
                                        onfocus="(this.type='date')"
                                        onblur="(this.type='text')"> -->
                                    <span class="error text-danger" id="qualification_error"></span>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ------------------------------------------ -->
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-12">
                                    <label for="Name">(iii) Father/Husband's name <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-12 col-md-12">
                                    <input type="text" class="form-control" id="fathers_name" maxlength="50" name="fathers_name[]" value="" placeholder="Father/Husband's name">
                                    <span class="error text-danger" id="fathers_name_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-12">
                                    <label for="Name">(iv) Present business of the applicant <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-12 col-md-12">
                                    <input type="text" class="form-control" id="present_business" name="present_business[]" value="" maxlength="50" placeholder="Present business of the applicant">
                                    <span class="error text-danger" id="present_business_error"></span>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- ---------------------- -->
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-12">
                                    <label for="competency_certificate_holding">(v) Whether holding a competency certificate and if so, the number and validity of the competency certificate</label>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="competency_yes" name="competency_certificate_holding[0]" value="yes" onclick="toggleCompetencyFields(true)">
                                        <label class="form-check-label" for="competency_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="competency_no" name="competency_certificate_holding[0]" value="no" onclick="toggleCompetencyFields(false)">
                                        <label class="form-check-label" for="competency_no">No</label>
                                    </div>
                                    <!-- <span class="text-danger competency_certificate_holding_error_radio" style="font-size: 0.875rem; display: none;"></span> -->
                                    <span class="text-danger competency_certificate_holding_error ms-3" style="font-size: 0.875rem;"></span>
                                </div>


                                <div class="col-12 col-md-5 mt-1  competency-fields" style="display: none;">
                                    <label>Competency Certificate No <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control mt-1 competency_number" name="competency_certificate_number[]" maxlength="15" placeholder="Certificate Number">
                                    <span class="error text-danger competency_number_error"></span>
                                </div>
                                <div class="col-12 col-md-5 mt-1 competency-fields" style="display: none;">
                                    <label> Validity <span style="color: red;">*</span></label>
                                    <input type="text"
                                        class="form-control competency_validity"
                                        name="competency_certificate_validity[]"
                                        placeholder="Validity"
                                        max="{{ date('Y-m-d') }}"
                                        onfocus="this.type='date'; setDateRestrictions(this);"
                                        onblur="this.type='text'">

                                    <span class="error text-danger competency_validity_error"></span>



                                </div>

                                <div class="col-12 col-md-2 mt-3  competency-fields" style="display: none;">
                                    <button type="button" class="btn btn-primary" onclick="verifyCompetencyCertificate(event, this)">Verify</button>
                                    <input type="hidden" name="proprietor_cc_verify[]" class="competency_status" value="0">


                                </div>

                                <div class="col-12 mt-1">
                                    <div class="text-danger competency_verify_result"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-12">
                                    <label for="Name">(vi) Whether he is presently employed
                                        anywhere, If so the name and
                                        address of the employer.<br>
                                        If not details of the Present
                                        business.
                                    </label>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="employed_yes" name="presently_employed[0]" value="yes" onclick="toggleEmploymentFields(true)">
                                        <label class="form-check-label" for="employed_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="employed_no" name="presently_employed[0]" value="no" onclick="toggleEmploymentFields(false)">
                                        <label class="form-check-label" for="employed_no">No</label>
                                    </div>
                                    <span class="error text-danger" id="presently_employed_error"></span>
                                </div>

                                <div class="col-12 col-md-6 mt-1 employment-fields" style="display: none;">
                                    <label>Name of the Employer <span class="text-red">*</span></label>
                                    <input type="text" class="form-control" id="presently_employed_name" name="presently_employed_name[]" maxlength="50" placeholder="Name">
                                    <span class="error text-danger presently_employed_name_error"></span>
                                </div>
                                <div class="col-12 col-md-6 mt-1  employment-fields" style="display: none;">
                                    <label>Address of the Employer <span class="text-red">*</span></label>
                                    <textarea class="form-control" id="presently_employed_address" name="presently_employed_address[]" placeholder="Address"></textarea>

                                    <span class="error text-danger presently_employed_address_error"></span>
                                </div>



                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-12">
                                    <label for="Name">(vii) If holding a competency certificate, details of previous experience with
                                        period. If the applicant has worked under a contractor, licensed by this
                                        Licensing Board, the name, address, and licence No. of the contractor.<br>
                                        <span style="color: #023466;">(Note: Details should be furnished for each partner/Director) </span>
                                    </label>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="previous_experience" name="previous_experience[0]" value="yes" onclick="toggleExperienceFields(true)">
                                        <label class="form-check-label" for="previous_experience">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="previous_experience" name="previous_experience[0]" value="no" onclick="toggleExperienceFields(false)">
                                        <label class="form-check-label" for="previous_experience">No</label>
                                    </div>


                                    <span class="error text-danger" id="previous_experience_error"></span>
                                </div>


                                <div class="col-12 col-md-12  experience-fields" style="display: none;">
                                    <div class="row">
                                        <div class="col-12 col-md-5 mt-1">
                                            <label>Name of the Contractor <span class="text-red">*</span></label>
                                            <input class="form-control" type="text" id="previous_experience_name" name="previous_experience_name[]" placeholder="Name">

                                            <span class="error text-danger previous_experience_name_error"></span>
                                        </div>
                                        <div class="col-12 col-md-5 mt-1">
                                            <label>Address of the Contractor <span class="text-red">*</span></label>
                                            <textarea class="form-control" id="previous_experience_address" name="previous_experience_address[]" placeholder="Address"></textarea>

                                            <span class="error text-danger previous_experience_address_error"></span>
                                        </div>

                                        <div class="col-12 col-md-5 mt-1">
                                            <label>Previous Electrical Assistance License Number <span class="text-red">*</span></label>
                                            <input class="form-control ea_license_number" type="text" id="previous_experience_lnumber" maxlength="15" name="previous_experience_lnumber[]" placeholder="License Number">

                                            <span class="error text-danger previous_experience_lnumber_error"></span>
                                        </div>

                                        <div class="col-12 col-md-5 mt-1">
                                            <label>Previous Electrical Assistance License Validity <span class="text-red">*</span></label>
                                            <input class="form-control ea_validity" type="text" max="{{ date('Y-m-d') }}"
                                                onfocus="(this.type='date')"
                                                id="previous_experience_lnumber_validity" name="previous_experience_lnumber_validity[]" placeholder="License Number Validity">

                                            <span class="error text-danger previous_experience_lnumber_validity_error"></span>
                                        </div>

                                        <div class="col-12 col-md-2 mt-5">
                                            <button type="button" class="btn btn-primary" onclick="verifyeaCertificate(event, this)">Verify</button>
                                            <input type="text" name="proprietor_contractor_verify[]" class="contactor_license_verify" value="0">

                                        </div>



                                        <div class="col-12 mt-1">
                                            <div class="text-danger competency_verifyea_result"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" mt-4 ">
                        <!-- <h3>Proprietor/Partner Details</h3> -->
                        <div class="col-12 col-md-12 text-md-right" id="static-add-button-wrapper">
                            <button id="add-more-proprietor" class="btn btn-primary text-md-right"><i class="fa fa-plus"></i> Add Proprietor /Partner</button>
                        </div>
                        <div id="proprietor-container"></div>
                    </div>
                </div>

                @endif

                @php
                $application = $application ?? null;
                @endphp

                <div class="row mt-4">
                    @php
                    $authorisedValue = old('authorised_name_designation', $application->authorised_name_designation ?? '');
                    $showAuthFields = $authorisedValue === 'yes';
                    @endphp

                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-12">
                                <label for="Name">
                                    4. Name and designation of authorised signatory if any in the case of limited company.
                                    <span style="color: red;">*</span>
                                </label>
                            </div>
                            @php
                            // Use old input > application value > default to 'no'
                            $authorisedValue = old('authorised_name_designation', $application->authorised_name_designation ?? 'no');
                            @endphp
                            <div class="col-12 col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="authorised_yes" name="authorised_name_designation" value="yes"
                                        onclick="toggleAuthorisedFields(true)" {{ $authorisedValue == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="authorised_yes">Yes</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="authorised_no" name="authorised_name_designation" value="no"
                                        onclick="toggleAuthorisedFields(false)" {{ $authorisedValue == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="authorised_no">No</label>
                                </div>
                                <span class="error text-danger" id="authorised_name_designation_error"></span>
                            </div>

                            <div class="col-12 col-md-12 authorised-fields" style="{{ $showAuthFields ? '' : 'display: none;' }}">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-6">
                                        <label>Name of authorised signatory <span class="text-red">*</span></label>
                                        <input class="form-control" type="text" maxlength="50" id="authorised_name" name="authorised_name"
                                            placeholder="Name"
                                            value="{{ old('authorised_name', $application->authorised_name ?? '') }}">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label>Designation of authorised signatory <span class="text-red">*</span></label>
                                        <input class="form-control" type="text" maxlength="50" id="authorised_designation" name="authorised_designation"
                                            placeholder="Designation"
                                            value="{{ old('authorised_designation', $application->authorised_designation ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-12">
                                <label for="Name">5. Whether any application for
                                    Contractor's licence was made
                                    previously? If so, details thereof. <span style="color: red;">*</span>
                                </label>
                            </div>

                            @php
                            $previous_contractor_license = old('previous_contractor_license', $application->previous_contractor_license ?? 'no');
                            @endphp
                            <div class="col-12 col-md-12">

                                <input style="display:none;" class="form-check-input" type="radio" id="previous_contractor_license" name="previous_contractor_license" value="yes" onclick="togglePreviousLicenseFields(true)">


                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="previous_contractor_license_yes" name="previous_contractor_license" value="yes"
                                        onclick="togglePreviousLicenseFields(true)" {{ $previous_contractor_license == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="previous_contractor_license_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="previous_contractor_license_no" name="previous_contractor_license" value="no"
                                        onclick="togglePreviousLicenseFields(false)" {{ $previous_contractor_license == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="previous_contractor_license_no">No</label>
                                </div>
                                <span class="error text-danger" id="previous_contractor_license_error"></span>
                            </div>


                            @php
                            $showPreviousFields = old('previous_contractor_license', $application->previous_contractor_license ?? '') === 'yes';
                            @endphp

                            <div class="col-12 col-md-12 previous-license-fields" style="{{ $showPreviousFields ? '' : 'display: none;' }}">
                                @php
                                use Carbon\Carbon;

                                $validityValue = '';

                                if (old('previous_application_validity')) {
                                $validityValue = old('previous_application_validity');
                                } elseif (!empty($application->previous_application_validity)) {
                                try {
                                $validityValue = Carbon::createFromFormat('d/m/Y', $application->previous_application_validity)->format('Y-m-d');
                                } catch (\Exception $e) {
                                try {
                                $validityValue = Carbon::parse($application->previous_application_validity)->format('Y-m-d');
                                } catch (\Exception $e) {
                                $validityValue = '';
                                }
                                }
                                }

                                   $isVerified = !empty($application) && $application->previous_contractor_license_verify === '1';
                                $isVerificationSet = !empty($application) && $application->previous_contractor_license_verify !== null;

                                @endphp


                                <div class="row">
                                    <!-- License Number -->
                                    <div class="col-6 col-md-5">
                                        <label>Previous License Number <span class="text-red">*</span></label>
                                        <input
                                            class="form-control previous_application_number"
                                            type="text"
                                            id="previous_application_number"
                                            name="previous_application_number"
                                            maxlength="15"
                                            placeholder="Previous License Number"
                                            value="{{ old('previous_application_number', $application->previous_application_number ?? '') }}"
                                            @if($isVerified) readonly @endif>

                                             <div class="license-status">
                                        @if($isVerificationSet)
                                                    @if($isVerified)
                                                        <span class="text-success text-center"><i class="fa fa-check"></i> Valid License</span>
                                                    @else
                                                        <span class="text-danger text-center"><i class="fa fa-close"></i> Invalid License</span>
                                                    @endif
                                                @endif
                                    </div>

                                    </div>

                                    <!-- License Validity -->
                                    <div class="col-6 col-md-5">
                                        <label>Previous License Validity <span class="text-red">*</span></label>
                                        <input
                                            class="form-control previous_application_validity"
                                            type="text"
                                            id="previous_application_validity"
                                            name="previous_application_validity"
                                            max="{{ date('Y-m-d') }}"
                                            onfocus="(this.type='date')"
                                            placeholder="Previous License Validity"
                                            value="{{ $validityValue ? Carbon::parse($validityValue)->format('d-m-Y') : '' }}"
                                            title="Select a date up to today"
                                            @if($isVerified) readonly @endif>
                                    </div>

                                    <!-- Verify / Clear Buttons -->
                                    <div class="col-12 col-md-2 mt-1">
                                        <br>
                                        <div id="licenseVerificationBtnWrapper">
                                            @if($isVerified)
                                            <button type="button" class="btn btn-danger" id="clearLicenseBtn" onclick="clearPreviousLicense()">Clear</button>
                                            @else
                                            <button type="button" class="btn btn-primary" id="verifyLicenseBtn" onclick="verifyeaCertificateprevoius(event, this)">Verify</button>
                                            @endif
                                              <input 
                                                type="hidden" 
                                                name="previous_contractor_license_verify" 
                                                class="previous_contractor_license_verify"
                                                value="{{ $application?->previous_contractor_license_verify ?? '' }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 mt-1">
                                    <div id="verifyea_result" class="text-danger"></div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>


            <div class="tab" data-name="Staff & Bank Details">

                <div class="row">

                    <div class="col-md-12">
                        <div class="row align-items-center head_label">
                            <div class="col-12 col-md-12 title_bar">
                                <label>6. Details of Staff appointed on full time basis: <span style="color: red;">*</span></label>

                            </div>

                        </div>


                        <div class="table-responsive">
                            <table class="table table-bordered" id="staff-table">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Name of the Person <span class="text-red">*</span></th>
                                        <th>Qualification <span class="text-red">*</span> </th>
                                        <th>Category <span class="text-red">*</span></th>
                                        <th colspan="2">Competency Certificate Number and Validity <span class="text-red">*</span></th>
                                        <th>Verify License </th>

                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>

                                @if(!$application)
                                <tbody id="staff-container">
                                    @php $staff_count = 4; @endphp
                                    @for ($i = 0; $i < $staff_count; $i++)
                                        <tr class="staff-fields">
                                        <td>{{ $i + 1 }} <span class="text-red"> * </span></td>
                                        <td>
                                            <input type="text" name="staff_name[]" maxlength="30"
                                                class="form-control"
                                                value="{{ old('staff_name.' . $i) }}"
                                                placeholder="Name of the Person"
                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                            <span class="error text-danger">{{ $errors->first('staff_name.' . $i) }}</span>
                                        </td>

                                        <td>
                                            <select class="form-control" name="staff_qualification[]">
                                                <option disabled selected>Qualification</option>
                                                @foreach (['PG', 'UG', 'Diploma', '+2', '10'] as $qual)
                                                <option value="{{ $qual }}" {{ old('staff_qualification.' . $i) == $qual ? 'selected' : '' }}>{{ $qual }}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger">{{ $errors->first('staff_qualification.' . $i) }}</span>
                                        </td>
                                        <td>
                                            @if ($i === 0)
                                            <input type="text" class="form-control" name="staff_category[]" value="QC" readonly>
                                            @else
                                            <select class="form-control" name="staff_category[]">
                                                <option disabled {{ old('staff_category.' . $i) ? '' : 'selected' }}>Select Category</option>
                                                @foreach (['QC', 'BC', 'B'] as $cat)
                                                <option value="{{ $cat }}" {{ old('staff_category.' . $i) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                            <span class="error text-danger">{{ $errors->first('staff_category.' . $i) }}</span>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control cc_number" name="cc_number[]" placeholder="Certificate No" maxlength="15" value="{{ old('cc_number.' . $i) }}">
                                            <span class="error text-danger">{{ $errors->first('cc_number.' . $i) }}</span>
                                            <div class="text-white competency_verify_result mt-1"></div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control cc_validity" name="cc_validity[]" placeholder="Validity" max="{{ date('Y-m-d') }}"
                                                onfocus="this.type='date'" onblur="this.type='text'" value="{{ old('cc_validity.' . $i) }}">
                                            <span class="error text-danger">{{ $errors->first('cc_validity.' . $i) }}</span>

                                        </td>
                                        <td>
                                            <button class="btn btn-primary" onclick="validatestaffcertificate(event, this)">Verify</button>

                                            <input type="hidden" name="staff_cc_verify[]" class="staff_cc_verify" value="0">

                                        </td>

                                        </tr>
                                        @endfor
                                </tbody>
                                @else
                                <tbody id="staff-container">
                                    @php
                                    $staff_count = max(4, count($staffs ?? []));
                                    @endphp

                                    @for ($i = 0; $i < $staff_count; $i++)
                                        @php $staff=$staffs[$i] ?? null; @endphp
                                        <tr class="staff-fields">
                                        <td>{{ $i + 1 }} <span class="text-red"> * </span></td>

                                        <td>
                                            <input type="text" name="staff_name[]" maxlength="30" class="form-control"
                                                value="{{ old('staff_name.' . $i, $staff->staff_name ?? '') }}"
                                                placeholder="Name of the Person"
                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                            <span class="error text-danger">{{ $errors->first('staff_name.' . $i) }}</span>
                                        </td>

                                        <td>
                                            <select class="form-control" name="staff_qualification[]">
                                                <option disabled {{ old('staff_qualification.' . $i, $staff->staff_qualification ?? '') == '' ? 'selected' : '' }}>Qualification draft </option>
                                                @foreach (['PG ', 'UG', 'DIPLOMA', '+2', '10'] as $qual)
                                                <option value="{{ $qual }}" {{ old('staff_qualification.' . $i, $staff->staff_qualification ?? '') == $qual ? 'selected' : '' }}>{{ $qual }}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger">{{ $errors->first('staff_qualification.' . $i) }}</span>
                                        </td>

                                        <td>
                                            @if ($i === 0)
                                            <input type="text" class="form-control" name="staff_category[]" value="QC" readonly>
                                            @else
                                            <select class="form-control" name="staff_category[]">
                                                <option disabled {{ old('staff_category.' . $i, $staff->staff_category ?? '') == '' ? 'selected' : '' }}>Select Category</option>
                                                @foreach (['QC ', 'BC', 'B'] as $cat)
                                                <option value="{{ $cat }}" {{ old('staff_category.' . $i, $staff->staff_category ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                            <span class="error text-danger">{{ $errors->first('staff_category.' . $i) }}</span>
                                        </td>

                                        <td>
                                            <input type="text"
                                                class="form-control cc_number"
                                                name="cc_number[]"
                                                placeholder="Certificate No"
                                                maxlength="15"
                                                value="{{ old('cc_number.' . $i, $staff->cc_number ?? '') }}"
                                                @if(isset($staff) && $staff->staff_cc_verify === '1') readonly @endif>
                                            <span class="error text-danger">{{ $errors->first('cc_number.' . $i) }}</span>
                                            <div class="competency_verify_result text-danger small mt-1"></div>
                                            <div class="license-status"> 
                                                @if(isset($staff) && $staff->staff_cc_verify === '1')
                                                <span class="text-success small"> <i class="fa fa-check"></i> Valid License</span>
                                                @else
                                                <span class="text-danger small"> Invalid License</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <input type="date"
                                                class="form-control cc_validity"
                                                name="cc_validity[]"
                                                max="{{ date('Y-m-d') }}"
                                                value="{{ old('cc_validity.' . $i, isset($staff->cc_validity) ? \Carbon\Carbon::parse($staff->cc_validity)->format('Y-m-d') : '') }}"
                                                @if(isset($staff) && $staff->staff_cc_verify === '1') readonly @endif>
                                            <span class="error text-danger">{{ $errors->first('cc_validity.' . $i) }}</span>
                                        </td>

                                        <td>
                                            <input type="hidden" name="staff_cc_verify[]" class="staff_cc_verify" value="{{ isset($staff) && $staff->staff_cc_verify === '1' ? '1' : '0' }}">

                                            @if(isset($staff) && $staff->staff_cc_verify === '1')
                                            <button type="button" class="btn btn-danger clearBtn">Clear</button>
                                            @else
                                            <button type="button" class="btn btn-primary verifyBtn" onclick="validatestaffcertificate(event, this)">Verify</button>
                                            @endif
                                        </td>


                                        <input type="hidden" name="staff_id[]" value="{{ $staff->id ?? '' }}">

                                        {{-- Required for update --}}

                                        </tr>
                                        @endfor

                                </tbody>



                                @endif

                            </table>
                            <p class="text-red">Note : All Rows are Mandatory and one QC Detail is Mandatory</p>
                            <!-- <div class="row">
                                    <div class="col-12 col-md-12">
                                      

                                    </div>

                                </div> -->
                        </div>



                    </div>

                </div>



                <hr class="mt-1">
                <div class="row">
                    <div class="col-md-12  ">
                        <div class="row align-items-center head_label">
                            <div class="col-12 col-md-12 title_bar">
                                <label>7. Bank Solvency Certificate Details <span style="color: red;">*</span> </label>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <label for="phone">(i) Name of the Bank and Address <span style="color: red;">*</span></label>
                                    </div>

                                    <div class="col-12 col-md-12">
                                        <textarea class="form-control" name="bank_address" placeholder="Name of the Bank and Address">{{ $application->bank_address ?? '' }}</textarea>
                                        <span class="error text-danger" id="bank_address_error"></span>
                                    </div>

                                </div>


                            </div>
                            <div class="col-md-4">



                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <label for="comments">(ii). Validity Period <span style="color: red;">*</span></label>
                                    </div>
  <!-- onfocus="setDateRestrictions(this)" -->
                                    <div class="col-12 col-md-12">
                                       <input type="date" 
                                    class="form-control" 
                                    name="bank_validity" 
                                    placeholder="Validity"
                                    value="{{ isset($application) && $application->bank_validity ? \Carbon\Carbon::parse($application->bank_validity)->format('Y-m-d') : '' }}">

                                        <span class="error text-danger" id="bank_validity_error"></span>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4">



                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <label for="comments">(iii). Amount Rs <span style="color: red;">*</span></label>
                                    </div>

                                    <div class="col-12 col-md-12">
                                        <input type="number" class="form-control" id="bank_amount" max="9999999"
                                            oninput="if(this.value.length > 7) this.value = this.value.slice(0, 7);" name="bank_amount" value="{{ $application->bank_amount ?? '' }}">
                                        <span class="error text-danger" id="bank_amount_error"></span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <hr class="mt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row align-items-center head_label">
                                    <div class="col-12 col-md-12 title_bar">
                                        <label> [ 8 to 11 ] Attachment Points</label>

                                    </div>

                                </div>


                                <div class="row align-items-center">
                                    <div class="col-12 col-md-8">
                                        <label for="Name">8. Has the applicant or any of his/her
                                            staff referred to under item 6, been at
                                            any time convicted in any court of law
                                            or punished by any other authority for
                                            criminal offences <span style="color: red;">*</span>
                                        </label>
                                    </div>
                                    @php
                                    $criminal_offence = strtolower(old('criminal_offence', $application->criminal_offence ?? 'no'));
                                    @endphp

                                    <div class="col-12 col-md-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="criminal_offence_yes" name="criminal_offence" value="yes" {{ $criminal_offence == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="criminal_offence_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="criminal_offence_no" name="criminal_offence" value="no" {{ $criminal_offence == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="criminal_offence_no">No</label>
                                        </div>
                                        <span class="error text-danger" id="criminal_offence_error"></span>
                                    </div>




                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-8">
                                        <label for="Name">9. (i) Whether consent letter, of the
                                            competency certificate holder are
                                            enclosed. (including for self) <span style="color: red;">*</span>
                                        </label>
                                    </div>

                                    @php
                                    $consent_letter_enclose = strtolower(old('consent_letter_enclose', $application->consent_letter_enclose ?? 'no'));
                                    @endphp
                                    <div class="col-12 col-md-4">
                                        <input style="display: none;" class="form-check-input" type="radio" id="consent_letter_enclose" name="consent_letter_enclose" value="yes">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="consent_letter_enclose" name="consent_letter_enclose" value="yes"
                                                {{ $consent_letter_enclose == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="consent_letter">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="consent_letter_enclose" name="consent_letter_enclose" value="no"
                                                {{ $consent_letter_enclose == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="consent_letter_enclose">No</label>
                                        </div>
                                        <span class="error text-danger" id="consent_letter_enclose_error"></span>
                                    </div>



                                </div>
                            </div>

                            <div class="col-md-12 mt-2">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-8">
                                        <label for="Name">(ii) Whether original booklet of
                                            competency certificate holders are
                                            enclosed? (including for self) <span style="color: red;">*</span>
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        @php
                                        $cc_holders_enclosed = strtolower(old('cc_holders_enclosed', $application->cc_holders_enclosed ?? 'no'));
                                        @endphp
                                        <input style="display: none;" class="form-check-input" type="radio" id="cc_holders_enclosed" name="cc_holders_enclosed" value="yes">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="cc_holders_enclosed" name="cc_holders_enclosed" value="yes" {{ $cc_holders_enclosed == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cc_enclosed">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="cc_holders_enclosed" name="cc_holders_enclosed" value="no" {{ $cc_holders_enclosed == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cc_enclosed">No</label>
                                        </div>
                                        <span class="error text-danger" id="cc_holders_enclosed_error"></span>
                                    </div>



                                </div>
                            </div>


                        </div>
                        <hr>
                        <!-- ------------------------------------------------------- -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-8">
                                        <label for="Name">10. (i)Whether purchase bill for all the
                                            instruments are enclosed in Original <span style="color: red;">*</span>
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        @php
                                        $purchase_bill_enclose = strtolower(old('purchase_bill_enclose', $application->purchase_bill_enclose ?? 'no'));
                                        @endphp
                                        <input style="display: none;" class="form-check-input" type="radio" id="purchase_bill_enclose" name="purchase_bill_enclose" value="yes">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="purchase_bill_enclose" name="purchase_bill_enclose" value="yes" {{ $purchase_bill_enclose == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="purchase_bill_enclose">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="purchase_bill_enclose" name="purchase_bill_enclose" value="no" {{ $purchase_bill_enclose == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="purchase_bill_enclose">No</label>
                                        </div>
                                        <span class="error text-danger" id="purchase_bill_enclose_error"></span>
                                    </div>



                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-8">
                                        <label for="Name">(ii) Whether the test reports for
                                            instruments and deeds for possess
                                            of the instruments are enclosed in
                                            original? <span style="color: red;">*</span>

                                        </label>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        @php
                                        $test_reports_enclose = strtolower(old('test_reports_enclose', $application->test_reports_enclose ?? 'no'));
                                        @endphp
                                        <input style="display: none;" class="form-check-input" type="radio" id="test_reports_enclose" name="test_reports_enclose" value="yes">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="test_reports_enclose" name="test_reports_enclose" value="yes" {{ $test_reports_enclose == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="test_reports">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="test_reports_enclose" name="test_reports_enclose" value="no" {{ $test_reports_enclose == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="test_reports">No</label>
                                        </div>
                                        <span class="error text-danger" id="test_reports_enclose_error"></span>
                                    </div>



                                </div>
                            </div>


                        </div>

                        <hr>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="row align-items-center border-right-12">
                                    <div class="col-12 col-md-8">
                                        <label for="Name">11. (i) Whether specimen signature of
                                            the Proprietor or of the authorised
                                            signatory (in case of limited
                                            company in triplicate is enclosed) <span style="color: red;">*</span>
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-4 ">
                                        @php
                                        $specimen_signature_enclose = strtolower(old('specimen_signature_enclose', $application->specimen_signature_enclose ?? 'no'));
                                        @endphp
                                        <input style="display: none;" class="form-check-input" type="radio" id="specimen_signature_enclose" name="specimen_signature_enclose" value="yes">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="specimen_signature_enclose" name="specimen_signature_enclose" value="yes" {{ $specimen_signature_enclose == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="specimen_signature">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="specimen_signature_enclose" name="specimen_signature_enclose" value="no" {{ $specimen_signature_enclose == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="specimen_signature">No</label>
                                        </div>

                                    </div>
                                    <span class="error text-danger" id="specimen_signature_enclose_error"></span>


                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row align-items-center border-right-12">
                                    <div class="col-12 col-md-8">
                                        <label for="Name">(ii) The name of the person/persons
                                            whom the applicant has
                                            authorised to sign if any, on his/their behalf in case of Proprietor or Partnership concern

                                        </label>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        @if(!$application)
                                        <div class="row">
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control authority-name" name="name_of_authorised_to_sign[]" placeholder="Name of Authority"
                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <button type="button" id="add-more-authority-name" class="btn btn-primary"><i class="fa fa-plus"></i> Add More</button>
                                            </div>
                                        </div>
                                        <div id="authority-name-container"></div>
                                        @else
                                        @php
                                        $authorisedNames = !empty($application->name_of_authorised_to_sign)
                                        ? json_decode($application->name_of_authorised_to_sign, true)
                                        : [];
                                        @endphp

                                        <div id="authority-names-wrapper">
                                            @if (count($authorisedNames) > 0)
                                            @foreach ($authorisedNames as $index => $name)
                                            <div class="row authority-name-row mt-2">
                                                <div class="col-12 col-md-7 authority-name-group">
                                                    <input type="text" class="form-control authority-name"
                                                        name="name_of_authorised_to_sign[]" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                                                        placeholder="Name of Authority"
                                                        value="{{ trim($name) !== 'null' ? trim($name) : '' }}">
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    @if ($index == 0)
                                                    <button type="button" id="add-more-authority-name" class="btn btn-primary">
                                                        <i class="fa fa-plus"></i> Add More
                                                    </button>
                                                    @else
                                                    <button type="button" class="btn btn-danger remove-authority-name">
                                                        <i class="fa fa-minus"></i> Remove
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <div class="row authority-name-row mt-2">
                                                <div class="col-12 col-md-7 authority-name-group">
                                                    <input type="text" class="form-control authority-name"
                                                        name="name_of_authorised_to_sign[]" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                                                        placeholder="Name of Authority">
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <button type="button" id="add-more-authority-name" class="btn btn-primary">
                                                        <i class="fa fa-plus"></i> Add More
                                                    </button>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        @endif
                                    </div>





                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-8">
                                        <label for="Name">(iii) Whether the applicant enclosed
                                            the specimen signature of the
                                            above person/ persons in triplicate
                                            in a separate sheet of paper<span style="color: red;">*</span>

                                        </label>
                                    </div>
                                    <div class="col-12 col-md-4 ">
                                        @php
                                        $separate_sheet = strtolower(old('separate_sheet', $application->separate_sheet ?? 'no'));
                                        @endphp
                                        <input style="display: none;" class="form-check-input" type="radio" id="separate_sheet" name="separate_sheet" value="yes">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="separate_sheet" name="separate_sheet" value="yes" {{ $separate_sheet == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="separate_sheet">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="separate_sheet" name="separate_sheet" value="no" {{ $separate_sheet == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="separate_sheet">No</label>
                                        </div>
                                        <span class="error text-danger" id="separate_sheet_error"></span>
                                    </div>



                                </div>
                            </div>


                        </div>
                        <hr>
                        <div class="row" style="display: none;">
                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">12. (i) Upload Photo
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">புகைப்படத்தைப் பதிவேற்றவும்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input autocomplete="off" class="form-control text-box single-line" id="upload_photo" name="upload_photo" type="file" value="" accept="image/*">
                                        <span class="file-limit"> File type: JPG,PNG (Max 50 KB) </span>
                                        <span class="error text-danger" id="upload_photo_error"></span>
                                    </div>
                                </div>
                            </div>




                        </div>

                        <hr>

                        <div class="row align-items-center head_label">
                            <div class="col-12 col-md-12 title_bar">
                                <label> 12) Upload Documents </label>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(i) Aadhaar Number <span style="color: red;">*</span>
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">ஆதார் எண்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        @php
                                        use Illuminate\Support\Facades\Crypt;

                                        try {
                                        $decryptedAadhaar = Crypt::decryptString($application->aadhaar);

                                        if (strlen($decryptedAadhaar) >= 4) {
                                        $maskedAadhaar = str_repeat('X', strlen($decryptedAadhaar) - 4) . substr($decryptedAadhaar, -4);
                                        } else {
                                        $maskedAadhaar = 'Invalid Aadhaar';
                                        }
                                        } catch (\Exception $e) {
                                        $maskedAadhaar = 'Invalid or corrupted Aadhaar';
                                        $decryptedAadhaar = '';
                                        }
                                        @endphp
                                        <input type="text" class="form-control text-box" maxlength="14" name="aadhaar" id="aadhaar" value="{{ $decryptedAadhaar ?? '' }}">

                                        <span class="error text-danger" id="aadhaar_error"></span>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12 col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5">
                                        <label for="aadhaar_doc">(ii) Upload Aadhaar Document</label>
                                        <br>
                                        <label for="aadhaar_doc" class="tamil">ஆதார் ஆவணத்தை பதிவேற்றவும்</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        @php


                                        $decryptedAadhaardoc = null;
                                        $maskedAadhaardoc = null;

                                        if (!empty($document->aadhaar_doc)) {
                                        try {
                                        $decryptedAadhaardoc = Crypt::decryptString($document->aadhaar_doc);
                                        $maskedAadhaardoc = str_repeat('X', strlen($decryptedAadhaardoc) - 4) . substr($decryptedAadhaardoc, -4);
                                        } catch (\Exception $e) {
                                        $maskedAadhaardoc = 'Invalid or corrupted Aadhaar';
                                        }
                                        }
                                        @endphp

                                        <div id="aadhaar-upload-wrapper">
                                            @if (!empty($decryptedAadhaardoc))
                                            <div class="row mt-2" id="aadhaar-existing-row">
                                                <div class="col-12 col-md-7">
                                                    <a href="{{ asset($decryptedAadhaardoc) }}" target="_blank">
                                                        <i class="fa fa-file-pdf-o fa-lg text-danger"></i> View
                                                    </a>
                                                    {{-- Hidden input with the same name for server fallback --}}
                                                    <input type="hidden" name="aadhaar_doc" id="aadhaar_doc" value="{{ $decryptedAadhaardoc }}">
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <button type="button" class="btn btn-danger" id="remove-aadhaar-doc">
                                                        <i class="fa fa-trash-o"></i> Remove
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- File input (initially hidden) --}}
                                            <div class="row mt-2" id="aadhaar-file-row" style="display: none;">
                                                <div class="col-12">
                                                    <input autocomplete="off" class="form-control" id="aadhaar_doc" name="aadhaar_doc" type="file" accept="application/pdf">
                                                    <span class="file-limit">File type: PDF (Max 250 KB)</span>
                                                </div>
                                            </div>
                                            @else
                                            {{-- No existing doc: show file input --}}
                                            <div class="row mt-2" id="aadhaar-file-row">
                                                <div class="col-12">
                                                    <input autocomplete="off" class="form-control" id="aadhaar_doc" name="aadhaar_doc" type="file" accept="application/pdf">
                                                    <span class="file-limit">File type: PDF (Max 250 KB)</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <span class="error text-danger aadhaar_doc_error" id="aadhaar_doc_error"></span>
                                    </div>
                                </div>
                            </div>




                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(iii) Pan Card Number <span style="color: red;">*</span>
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">பான் கார்டு எண்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        @php
                                        try {
                                        $decryptedpan = Crypt::decryptString($application->pancard);

                                        if (strlen($decryptedpan) >= 4) {
                                        $maskpan = str_repeat('X', strlen($decryptedpan) - 4) . substr($decryptedpan, -4);
                                        } else {
                                        $maskpan = 'Invalid Pancard';
                                        }
                                        } catch (\Exception $e) {
                                        $maskpan = 'Invalid or corrupted Pancard';
                                        $decryptedpan = '';
                                        }
                                        @endphp

                                        <input type="text" class="form-control text-box " name="pancard" maxlength="10" id="pancard" value="{{ $decryptedpan ?? '' }}">
                                        <span class="error text-danger" id="pancard_error"></span>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(iv) Upload Pan Card Document
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">பான் கார்டு ஆவணத்தைப் பதிவேற்றவும்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        @php
                                        $decryptedPandoc = null;
                                        $maskedPandoc = null;

                                        if (!empty($document->pancard_doc)) {
                                        try {
                                        $decryptedPandoc = Crypt::decryptString($document->pancard_doc);
                                        $maskedPandoc = str_repeat('X', strlen($decryptedPandoc) - 4) . substr($decryptedPandoc, -4);
                                        } catch (\Exception $e) {
                                        $maskedPandoc = 'Invalid or corrupted PAN';
                                        }
                                        }
                                        @endphp

                                        <div id="pan-upload-wrapper">
                                            @if (!empty($decryptedPandoc))
                                            <div class="row mt-2" id="pan-existing-row">
                                                <div class="col-12 col-md-7">
                                                    <a href="{{ asset($decryptedPandoc) }}" target="_blank">
                                                        <i class="fa fa-file-pdf-o fa-lg text-danger"></i> View
                                                    </a>
                                                    <input type="hidden" name="pancard_doc" value="{{ $decryptedPandoc }}" id="pancard_doc">
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <button type="button" class="btn btn-danger" id="remove-pan-doc">
                                                        <i class="fa fa-trash-o"></i> Remove
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="row mt-2" id="pan-file-row" style="display: none;">
                                                <div class="col-12">
                                                    <input autocomplete="off" class="form-control" id="pancard_doc" name="pancard_doc" type="file" accept="application/pdf">
                                                    <span class="file-limit">File type: PDF (Max 250 KB)</span>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row mt-2" id="pan-file-row">
                                                <div class="col-12">
                                                    <input autocomplete="off" class="form-control" id="pancard_doc" name="pancard_doc" type="file" accept="application/pdf">
                                                    <span class="file-limit">File type: PDF (Max 250 KB)</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <span class="error text-danger" id="pancard_doc_error"></span>
                                    </div>


                                </div>
                            </div>

                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(v) GST Number <span style="color: red;">*</span>
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">ஜிஎஸ்டி எண்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        @php
                                        $decryptedGST = null;
                                        $maskgst = null;

                                        if (!empty($application->gst_number)) {
                                        try {
                                        $decryptedGST = Crypt::decryptString($application->gst_number);

                                        } catch (\Exception $e) {

                                        }
                                        }
                                        @endphp

                                        <input type="text" class="form-control text-box" name="gst_number" maxlength="15" id="gst_number" value="{{ $decryptedGST ?? '' }}">
                                        <span class="error text-danger" id="gst_number_error"></span>
                                    </div>


                                </div>
                            </div>



                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(vi) Upload GST Document
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">ஜிஎஸ்டி ஆவணத்தைப் பதிவேற்றவும்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        @php
                                        $decryptedGSTDoc = null;
                                        $maskedGSTDoc = null;

                                        if (!empty($document->gst_doc)) {
                                        try {
                                        $decryptedGSTDoc = Crypt::decryptString($document->gst_doc);
                                        $maskedGSTDoc = str_repeat('X', strlen($decryptedGSTDoc) - 4) . substr($decryptedGSTDoc, -4);
                                        } catch (\Exception $e) {
                                        $maskedGSTDoc = 'Invalid or corrupted GST';
                                        }
                                        }
                                        @endphp

                                        <div id="gst-upload-wrapper">
                                            @if (!empty($decryptedGSTDoc))
                                            <div class="row mt-2" id="gst-existing-row">
                                                <div class="col-12 col-md-7">
                                                    <a href="{{ asset($decryptedGSTDoc) }}" target="_blank">
                                                        <i class="fa fa-file-pdf-o fa-lg text-danger"></i> View
                                                    </a>
                                                    <input type="hidden" name="gst_doc" id="gst_doc" value="{{ $decryptedGSTDoc }}">
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <button type="button" class="btn btn-danger" id="remove-gst-doc">
                                                        <i class="fa fa-trash-o"></i> Remove
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="row mt-2" id="gst-file-row" style="display: none;">
                                                <div class="col-12">
                                                    <input autocomplete="off" class="form-control" id="gst_doc" name="gst_doc" type="file" accept="application/pdf">
                                                    <span class="file-limit">File type: PDF (Max 250 KB)</span>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row mt-2" id="gst-file-row">
                                                <div class="col-12">
                                                    <input autocomplete="off" class="form-control" id="gst_doc" name="gst_doc" type="file" accept="application/pdf">
                                                    <span class="file-limit">File type: PDF (Max 250 KB)</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <span class="error text-danger" id="gst_doc_error"></span>
                                    </div>


                                </div>
                            </div>

                        </div>
                        <div class="row head_label">

                            <div class="col-12 col-md-12 title_bar">
                                <label> Declaration </label>

                            </div>

                            <label class="container mt-2">
                                <div class="declaration-container">
                                    <input type="checkbox" id="declarationCheckbox" name="declaration1" value="1">
                                    <span class="checkmark"></span>
                                    <div>
                                        I/We hereby declare that the particulars stated above are correct to the best of my/our knowledge and belief.
                                    </div>
                                </div>
                                <span class="error text-danger" id="declaration3_error"></span>
                                <!-- <p id="declaration1_error" class="error text-danger" style="display: none;">
                                ⚠ Please check the declaration box before proceeding.
                            </p> -->
                            </label>

                            <label class="container">
                                <div class="declaration-container">
                                    <input type="checkbox" id="declarationCheckbox1" name="declaration2" value="1">
                                    <span class="checkmark"></span>
                                    <div>
                                        I/We hereby declare that I/We have in my/our possession a latest copy of the Indian
                                        Electricity Rules, 1956 and that I/We fully understand the terms and conditions under which an Electrical
                                        Contractor's licence is granted, breach of which will render the licence liable for cancellation.
                                    </div>
                                </div>
                                <span class="error text-danger" id="declaration4_error"></span>
                                <!-- <p id="declaration2_error" class="error text-danger" style="display: none;">
                                ⚠ Please check the declaration box before proceeding.
                            </p> -->
                            </label>


                        </div>

                        <div class="row enclosures">
                            <div class="col-12 col-md-12 title_bar">
                                <label> Enclosures : </label>

                            </div>
                            <div class="col-12 col-md-12 ">

                                <ul>
                                    <li>1. Bank Demand Draft in favour of the Secretary, Electrical Licensing Board, Chennai.</li>
                                    <li>2. Consent letters obtained from employees (including self) in the prescribed form.</li>
                                    <li>3. Detailed experience certificate of the appointed Supervisor (original & attested copy).</li>
                                    <li>4. Original Competency Certificates of staff (including self).</li>
                                    <li>5. Test reports of instruments from Government Electrical Standards Laboratory or MRT Laboratory of TNEB.</li>
                                    <li>6. Specimen signature of the contractor and authorized person (in triplicate, on a separate sheet).</li>
                                    <li>7. Bank Solvency Certificate of Rs.50,000/- in Form ‘G’ (valid for a minimum of three years).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <nav class="tab-pag"></nav>
    </div>

    </form>


    </div>
</section>










<footer class="main-footer">
    @include('include.footer')

    <script>
        // Function to show the draft saved popup
        function showDraftPopup() {
            document.getElementById('draftPopup').style.display = 'flex';
        }

        // Function to close the popup
        function closeDraftPopup() {
            document.getElementById('draftPopup').style.display = 'none';
        }

        // Attach event listener to the "Save As Draft" button
        document.querySelector('.btn-primary').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission
            showDraftPopup(); // Show the popup
        });
    </script>

    <script>
        const hasApplication = {{isset($application) ? 'true' : 'false'}};
    </script>

    <script>
        var tabs = function(id) {
            this.el = document.getElementById(id);

            this.tab = {
                el: '.tab',
                list: null
            };

            this.nav = {
                el: '.tab-nav',
                list: null
            };

            this.pag = {
                el: '.tab-pag',
                list: null
            };

            this.count = null;
            this.selected = 0;

            this.init = function() {
                // Create tabs
                this.tab.list = this.createTabList();
                this.count = this.tab.list.length;

                // Create nav
                this.nav.list = this.createNavList();
                this.renderNavList();

                // Create pag
                this.pag.list = this.createPagList();
                this.renderPagList();

                // Load saved data
                this.loadDraft();

                // Set selected tab
                this.setSelected(this.selected);
            };

            this.createTabList = function() {
                var list = [];
                this.el.querySelectorAll(this.tab.el).forEach(function(el, i) {
                    list[i] = el;
                });
                return list;
            };

            this.createNavList = function() {
                var list = [];
                this.tab.list.forEach(function(el, i) {
                    var listitem = document.createElement('a');
                    listitem.className = 'nav-item';
                    listitem.innerHTML = el.getAttribute('data-name');
                    listitem.onclick = function() {
                        this.setSelected(i);
                        return false;
                    }.bind(this);
                    list[i] = listitem;
                }.bind(this));
                return list;
            };

            this.createPagList = function() {
                var list = [];

                list.prev = document.createElement('a');
                list.prev.className = 'pag-item btn btn-primary text-white';
                list.prev.innerHTML = 'Prev';
                list.prev.onclick = function() {
                    this.setSelected(this.selected - 1);
                    return false;
                }.bind(this);

                list.next = document.createElement('a');
                list.next.className = 'pag-item pag-item-next btn btn-primary text-white';
                list.next.innerHTML = 'Next';
                list.next.onclick = function() {
                    this.setSelected(this.selected + 1);
                    return false;
                }.bind(this);

                list.saveDraft_draft = document.createElement('button');
                list.saveDraft_draft.className = 'pag-item btn btn-info text-white save-draft';
                list.saveDraft_draft.innerHTML = 'Save as Draft';

                // Save as Draft button
                list.saveDraft = document.createElement('button');
                list.saveDraft.className = 'pag-item btn btn-info text-white save-draft';
                list.saveDraft.innerHTML = 'Save as Draft';

                list.saveDraft.type = 'submit';
                // list.saveDraft.onclick = this.saveDraft.bind(this);

                list.submit = document.createElement('button');
                list.submit.className = 'pag-item btn btn-success text-white submit-final';
                list.submit.type = 'submit';
                list.submit.innerHTML = 'Save & Proceed Payment';

                return list;
            };

            this.renderNavList = function() {
                var nav = document.querySelector(this.nav.el);
                this.nav.list.forEach(function(el) {
                    nav.appendChild(el);
                });
            };

            this.renderPagList = function() {
                var pag = document.querySelector(this.pag.el);
                pag.appendChild(this.pag.list.prev);
                pag.appendChild(this.pag.list.saveDraft_draft);
                pag.appendChild(this.pag.list.next);
                pag.appendChild(this.pag.list.saveDraft); // Add "Save as Draft"
                pag.appendChild(this.pag.list.submit);
            };

            this.setSelected = function(target) {
                var min = 0,
                    max = this.count - 1;
                if (target > max || target < min) return;

                this.pag.list.prev.classList.toggle('hidden', target === min);
                this.pag.list.next.classList.toggle('hidden', target === max);
                this.pag.list.saveDraft_draft.classList.toggle('hidden', target === max);
                this.pag.list.submit.classList.toggle('hidden', target !== max);
                this.pag.list.saveDraft.classList.toggle('hidden', target !== max);

                this.tab.list[this.selected].classList.remove('selected');
                this.nav.list[this.selected].classList.remove('selected');

                this.selected = target;
                this.tab.list[this.selected].classList.add('selected');
                this.nav.list[this.selected].classList.add('selected');
            };

            // Function to save form data as a draft
            // this.saveDraft = function() {
            //     let formData = {};
            //     this.el.querySelectorAll("input, textarea").forEach(field => {
            //         formData[field.name] = field.value;
            //     });

            //     localStorage.setItem("draftData", JSON.stringify(formData));
            //     alert("Draft saved successfully!");
            // };

            // Load saved draft data
            this.loadDraft = function() {
                if (localStorage.getItem("draftData")) {
                    const savedData = JSON.parse(localStorage.getItem("draftData"));
                    Object.keys(savedData).forEach(name => {
                        const field = this.el.querySelector(`[name="${name}"]`);
                        if (field) field.value = savedData[name];
                    });
                }
            };

        };

        var tabbedForm = new tabs('tabbedForm');
        tabbedForm.init();
    </script>
    <!-- const initialDraftCount = {{ count($proprietors) ?? 0 }};
let proprietorCount = initialDraftCount || 0;

 


        // let proprietorCount = typeof initialDraftCount !== "undefined" ? initialDraftCount : 1;
        
                let maxProprietors;
            if (!initialDraftCount) {
                maxProprietors = 3;
            } else {
                maxProprietors = 4;
            } -->
    <script>
        const initialDraftCount = {{count($proprietors) ?? 1}};
        let proprietorCount = initialDraftCount || 1;




        // let proprietorCount = typeof initialDraftCount !== "undefined" ? initialDraftCount : 1;

        let maxProprietors;
        if (!initialDraftCount) {
            maxProprietors = 4;
        } else {
            maxProprietors = 4;
        }

        function getProprietorFields(index) {
            return `
    <div class="proprietor-block border p-3 mt-3" id="proprietor-${index}">
        <h5> Proprietor/Partner Details ${index + 1}</h5>
        <div class="row">
            <div class="col-md-6">
                <label>(i) Full name and house address of proprietor or partners or Directors <span style="color: red;">*</span></label>
                <div class="row">
                    <div class="col-md-6">
                    <label>Proprietor / Partner Name <span class="text-red">* </span> </label>
                    <input type="text" class="form-control mb-2" name="proprietor_name[]" placeholder="Name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, ' ')">
                   <span class="error text-danger proprietor_name_error" id="proprietor_name_error"></span>
                    </div>

                      <div class="col-md-6">
                         <label>Proprietor / Partner Address <span class="text-red">* </span> </label>
                        <textarea rows="3" class="form-control" name="proprietor_address[]" placeholder="Address"></textarea>
                <span class="error text-danger proprietor_address_error" id="proprietor_address_error"></span>
                    </div>
                </div>
               
                
            </div>
            <div class="col-md-6">
          
                <label>(ii) Age and qualification along with evidence <span style="color: red;">*</span></label>
                  <div class="row">
                        <div class="col-md-6">
                            <label>Age <span class="text-red">* </span> </label>
                            <input type="number" class="form-control mb-2 age-input" maxlength="2" min="15" name="age[]" placeholder="Age">
                 <span class="error text-danger age_error" id="age_error"></span>
                            </div>
                            <div class="col-md-6">
                             <label>Qualification <span class="text-red">* </span> </label>
                             <input type="text" class="form-control" name="qualification[]" placeholder="Qualification">
                <span class="error text-danger qualification_error" id="qualification_error"></span>
                             </div>
                    </div>
               
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <label>(iii) Father/Husband's name <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="fathers_name[]" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, ' ')">
            </div>
            <div class="col-md-6">
                <label>(iv) Present business of the applicant <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="present_business[]">
                 <span class="error text-danger present_business_error" id="present_business_error"></span>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <label>(v) Whether holding a competency certificate and if so, the number and validity of the competency certificate</label>
                <div>
                    <input type="radio" name="competency_certificate_holding[${index}]" value="yes" class="competency-toggle" data-index="${index}"> <label>Yes</label>
                    <input type="radio" name="competency_certificate_holding[${index}]" value="no" class="competency-toggle" data-index="${index}" > <label>No</label>
                     <span class="text-danger competency_certificate_holding_error ms-3" style="font-size: 0.875rem;"></span>
                </div>
                  
                <div class="competency-fields-${index} competency-fields mt-2" style="display: none;">
                        <div class="row">
                                        <div class="col-12 col-md-5 mt-1  competency-fields" >
                                            <label>Competency Certificate No <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control mt-1 competency_number" name="competency_certificate_number[]" placeholder="Certificate Number">
                                            <span class="error text-danger competency_number_error"></span>
                                        </div>
                                        <div class="col-12 col-md-5 mt-1 competency-fields" >
                                            <label> Validity <span style="color: red;">*</span></label>
                                            <input type="text"
                                                class="form-control competency_validity"
                                                name="competency_certificate_validity[]"
                                                placeholder="Validity"
                                              
                                                onfocus="this.type='date'; setDateRestrictions(this);"
                                                onblur="this.type='text'">

                                            <span class="error text-danger competency_validity_error"></span>



                                        </div>

                                        <div class="col-12 col-md-2 mt-3  competency-fields" >
                                           <button type="button" class="btn btn-primary" onclick="verifyCompetencyCertificateincrease(event, this)">Verify</button>
                                            <input type="hidden" name="proprietor_cc_verify[]" class="competency_status" value="0">

                                        </div>
                                         <div class="col-12 mt-1">
                                        <div class="text-danger competency_verify_result"></div>
                                    </div>
                                        
                    </div>
                    </div>
            </div>

            <div class="col-md-6">
                <label>(vi) Whether he is presently employed anywhere, If so the name and address of the employer.
                If not details of the Present business.</label>
                <div>
                    <input type="radio" name="presently_employed[${index}]" value="yes" class="employment-toggle" data-index="${index}"> <label>Yes</label>
                    <input type="radio" name="presently_employed[${index}]" value="no" class="employment-toggle" data-index="${index}" > <label>No</label>

                     <span class="text-danger presently_employed_error ms-3" ></span>
                </div>
                <div class="employment-fields-${index} employment-fields mt-2" style="display: none;">
                <div class="row">
                        <div class="col-12 col-md-6 mt-1">
                            <label>Name of the Employer <span class="text-red">*</span></label>
                            <input type="text" class="form-control mt-2 presently_employed_name" name="presently_employed_name[]" placeholder="Employer Name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, ' ')">

                            <span class="text-danger presently_employed_name_error ms-3"  id="presently_employed_name_error"></span>
                            
                        </div>
                        <div class="col-12 col-md-6 mt-1">
                            <label>Address of the Employer <span class="text-red">*</span></label>
                            <textarea class="form-control mt-2 presently_employed_address" name="presently_employed_address[]" placeholder="Employer Address"></textarea>

                            <span class="text-danger presently_employed_address_error ms-3" id="presently_employed_address_error" ></span>
                        </div>
                    </div>
                  
                    
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <label>(vii) If holding a competency certificate, details of previous experience with period. If the applicant has worked under a contractor, licensed by this Licensing Board, the name, address, and licence No. of the contractor.</label>
                <div>
                    <input type="radio" name="previous_experience[${index}]" value="yes" class="experience-toggle" data-index="${index}"> <label>Yes</label>
                    <input type="radio" name="previous_experience[${index}]" value="no" class="experience-toggle" data-index="${index}" > <label>No</label>
                    <span class="text-danger previous_experience_error ms-3" ></span>
                </div>
                <div class="experience-fields-${index} experience-fields mt-2" style="display: none;">
                <div class="row">
                    <div class="col-12 col-md-5 mt-1">
                         <label>Name of the Contractor <span class="text-red">*</span></label>
                        <input type="text" class="form-control mt-2" id="previous_experience_name_index" name="previous_experience_name[]" placeholder="Contractor Name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, ' ')">
                    </div>
                    <div class="col-12 col-md-5 mt-1">
                        <label>Address of the Contractor <span class="text-red">*</span></label>
                            <textarea class="form-control mt-2" id="previous_experience_address_index"  name="previous_experience_address[]" placeholder="Contractor Address"></textarea>
                     </div>

                      <div class="col-12 col-md-4 mt-1">
                         <label>Previous Electrical Assistance License Number <span class="text-red">*</span></label>
                              <input type="text" class="form-control mt-2 ea_license_number_index" id="previous_experience_lnumber_index"name="previous_experience_lnumber[]" placeholder="License Number">
                    </div>
                    <div class="col-12 col-md-4 mt-1">
                        <label>Previous Electrical Assistance License Validity <span class="text-red">*</span></label>
                              <input type="text" class="form-control mt-2 ea_license_validity_index" id="previous_experience_lnumber_validity_index" name="previous_experience_lnumber_validity[]" placeholder="License Number Validity"
                        onfocus="this.type='date'" >
                     </div>
                    <div class="col-12 col-md-2 mt-4">
                        <button type="button" class="btn btn-primary" onclick="verifyeaCertificateincrease(event, this)">Verify</button>
                         
                        <input type="hidden" name="proprietor_contractor_verify[]" class="contactor_license_verify" value="0">
                    </div>
                    

                     <div class="col-12 mt-1">
                        <input type="hidden" class="previous_license_verifiedea" value="1">
                        <div class="verifyeaincrease_result text-danger"></div>
                    </div>

                </div>
           
                    
                  

                  

                    <div class="ea_license_result_increase text-danger mt-1"></div>

                </div>

                
            </div>
        </div>

        <div class="text-right mt-3">
            <button class="btn btn-danger remove-proprietor" data-index="${index}"><i class="fa fa-trash"></i> Remove</button>
        </div>

 
        <div class="text-right mt-3">
            <button id="add-more-proprietor" class="btn btn-primary"><i class="fa fa-plus"></i> Add Proprietor /Partner</button>
        </div>
        
    </div>
    `;
        }


        // INIT ON PAGE LOAD
        document.addEventListener("DOMContentLoaded", function() {

            document.body.addEventListener("click", function(event) {
                const isFreshBtn = event.target.id === "add-more-proprietor";
                const isDraftBtn = event.target.id === "add-more-proprietor-draft";
                // alert('111');

                // Handle either button
                if (isFreshBtn || isDraftBtn) {
                    event.preventDefault();

                    if (!validateFirstProprietor()) {
                        return showError("Fill all required fields in the first proprietor section.");
                    }

                    if (!validateLastProprietor()) {
                        return showError("Fill all required fields in the current Proprietor/Partner section.");
                    }

                    if (proprietorCount >= maxProprietors) {
                        return showError("You can only add up to 4 proprietors.");
                    }

                    // Hide the clicked button
                    const staticButtonWrapper = event.target.closest('#static-add-button-wrapper');
                    staticButtonWrapper?.classList.add("d-none");

                    const container = document.getElementById("proprietor-container");
                    container.querySelectorAll("#add-more-proprietor, #add-more-proprietor-draft").forEach(btn => btn.parentNode.remove());

                    container.insertAdjacentHTML("beforeend", getProprietorFields(proprietorCount));
                    proprietorCount++;
                }

                // Remove Proprietor
                // Remove Proprietor (Dynamic)
                if (event.target.classList.contains("remove-proprietor")) {
                    const index = event.target.getAttribute("data-index");
                    document.getElementById("proprietor-" + index)?.remove();
                    proprietorCount--;

                    const blocks = document.querySelectorAll(".proprietor-block");
                    const lastBlock = blocks[blocks.length - 1];

                    // Only append the add button if total is less than 4 AND last block is valid
                    if (
                        proprietorCount < maxProprietors &&
                        lastBlock &&
                        !lastBlock.querySelector('#add-more-proprietor, #add-more-proprietor-draft')
                    ) {
                        lastBlock.insertAdjacentHTML("beforeend", `
                            <div class="text-right mt-3">
                                <button id="${getAddButtonId()}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> ${getAddButtonText()}
                                </button>
                            </div>
                        `);
                    }
                }


            });

            function validateProprietorBlock(block) {
                let isValid = true;
                const requiredSelectors = [
                    "input[name='proprietor_name[]']",
                    "textarea[name='proprietor_address[]']",
                    "input[name='age[]']",
                    "input[name='qualification[]']",
                    "input[name='fathers_name[]']",
                    "input[name='present_business[]']"
                ];
                requiredSelectors.forEach(selector => {
                    const input = block.querySelector(selector);
                    if (input && input.value.trim() === "") {
                        isValid = false;
                    }
                });
                return isValid;
            }


            document.body.addEventListener("change", function(event) {
                const index = event.target.dataset.index;

                if (event.target.classList.contains("competency-toggle")) {
                    document.querySelectorAll(`.competency-fields-${index}`).forEach(el => {
                        el.style.display = event.target.value === "yes" ? "block" : "none";
                    });
                }

                if (event.target.classList.contains("employment-toggle")) {
                    document.querySelectorAll(`.employment-fields-${index}`).forEach(el => {
                        el.style.display = event.target.value === "yes" ? "block" : "none";
                    });
                }

                if (event.target.classList.contains("experience-toggle")) {
                    document.querySelectorAll(`.experience-fields-${index}`).forEach(el => {
                        el.style.display = event.target.value === "yes" ? "block" : "none";
                    });
                }
            });

            document.body.addEventListener("input", function(event) {
                if (event.target.classList.contains("age-input")) {
                    let value = parseInt(event.target.value, 10);
                    if (value >= 50) {
                        event.target.value = 49;
                    } else if (value < 0 || isNaN(value)) {
                        event.target.value = "";
                    }
                }
            });

            // Helpers
            function showError(text) {
                Swal.fire({
                    title: "Error",
                    text: text,
                    icon: "error",
                    showCloseButton: true,
                    customClass: {
                        popup: 'swal2-popup-sm'
                    }
                });

                document.getElementById("static-add-button-wrapper")?.classList.remove("d-none");
                return false;
            }

            function getAddButtonId() {
                return document.querySelector("#add-more-proprietor-draft") ? "add-more-proprietor-draft" : "add-more-proprietor";
            }

            function getAddButtonText() {
                return document.querySelector("#add-more-proprietor-draft") ? "Add Draft Proprietor /Partner" : "Add Proprietor /Partner";
            }

        });

        function validateFirstProprietor() {
            let isValid = true;

            // Validate static fields
            const selectors = [
                "input[name='proprietor_name[]']",
                "textarea[name='proprietor_address[]']",
                "input[name='age[]']",
                "input[name='qualification[]']",
                "input[name='fathers_name[]']",
                "input[name='present_business[]']"
            ];

            selectors.forEach(sel => {
                const field = document.querySelector(sel);
                if (field && field.value.trim() === "") {
                    field.classList.add("is-invalid");
                    isValid = false;
                } else if (field) {
                    field.classList.remove("is-invalid");
                }
            });


            const compError = $(".competency_certificate_holding_error");

            if ($('input[name="competency_certificate_holding[0]"]:checked').length > 0) {
                // console.log('success');
                compError.text("").hide();

                const selectedValue = $('input[name="competency_certificate_holding[0]"]:checked').val();

                if (selectedValue === 'yes') {
                    const certNumber = $(".competency_number");
                    const certNumberError = $(".competency_number_error");

                    const certValidity = $(".competency_validity");
                    const certValidityError = $(".competency_validity_error");

                    // Validate Certificate Number
                    if (certNumber.val().trim() === "") {
                        certNumber.addClass("is-invalid");
                        certNumberError.text("Certificate number is required.");
                        isValid = false;
                    } else {
                        certNumber.removeClass("is-invalid");
                        certNumberError.text("");
                    }

                    // Validate Certificate Validity
                    if (certValidity.val().trim() === "") {
                        certValidity.addClass("is-invalid");
                        certValidityError.text("Certificate validity is required.");
                        isValid = false;
                    } else {
                        certValidity.removeClass("is-invalid");
                        certValidityError.text("");
                    }
                }

            } else {
                console.log('error');
                compError.text("Select Yes or No.").show(); // Show error
                isValid = false;
            }


            // employer address name-----------------------------

            const employerRadioError = $("#presently_employed_error");

            if ($('input[name="presently_employed[0]"]:checked').length > 0) {
                employerRadioError.text("").hide(); // Clear radio error

                const selectedValue = $('input[name="presently_employed[0]"]:checked').val();

                if (selectedValue === 'yes') {
                    const empName = $("#presently_employed_name");
                    const empNameError = $(".presently_employed_name_error");

                    const empAddress = $("#presently_employed_address");
                    const empAddressError = $(".presently_employed_address_error");

                    // Validate Name
                    if (empName.val().trim() === "") {
                        empName.addClass("is-invalid");
                        empNameError.text("Employer Name is required.");
                        isValid = false;
                    } else {
                        empName.removeClass("is-invalid");
                        empNameError.text("");
                    }

                    // Validate Address
                    if (empAddress.val().trim() === "") {
                        empAddress.addClass("is-invalid");
                        empAddressError.text("Employer Address is required.");
                        isValid = false;
                    } else {
                        empAddress.removeClass("is-invalid");
                        empAddressError.text("");
                    }
                }

            } else {
                employerRadioError.text("Select Yes or No.").show(); // Show radio button error
                isValid = false;
            }

            // ------------previous competency

            const previousRadioError = $("#previous_experience_error");

            if ($('input[name="previous_experience[0]"]:checked').length > 0) {
                previousRadioError.text("").hide(); // Clear radio error

                const selectedValue = $('input[name="previous_experience[0]"]:checked').val();

                if (selectedValue === 'yes') {
                    const empName = $("#previous_experience_name");
                    const empNameError = $(".previous_experience_name_error");

                    const empAddress = $("#previous_experience_address");
                    const empAddressError = $(".previous_experience_address_error");


                    const previousnumber = $("#previous_experience_lnumber");
                    const previousnumberError = $(".previous_experience_lnumber_error");

                    const previousvaliditynumber = $("#previous_experience_lnumber_validity");
                    const previousvaliditynumberError = $(".previous_experience_lnumber_validity_error");

                    // Validate Name
                    if (empName.val().trim() === "") {
                        empName.addClass("is-invalid");
                        empNameError.text(" Name of the Contractor  is required.");
                        isValid = false;
                    } else {
                        empName.removeClass("is-invalid");
                        empNameError.text("");
                    }

                    // Validate Address
                    if (empAddress.val().trim() === "") {
                        empAddress.addClass("is-invalid");
                        empAddressError.text("Address of the Contractor is required.");
                        isValid = false;
                    } else {
                        empAddress.removeClass("is-invalid");
                        empAddressError.text("");
                    }

                    if (previousnumber.val().trim() === "") {
                        previousnumber.addClass("is-invalid");
                        previousnumberError.text("License Number is required.");
                        isValid = false;
                    } else {
                        previousnumber.removeClass("is-invalid");
                        previousnumberError.text("");
                    }

                    if (previousvaliditynumber.val().trim() === "") {
                        previousvaliditynumber.addClass("is-invalid");
                        previousvaliditynumberError.text("License Number is required.");
                        isValid = false;
                    } else {
                        previousvaliditynumber.removeClass("is-invalid");
                        previousvaliditynumberError.text("");
                    }
                }

            } else {
                previousRadioError.text("Select Yes or No.").show(); // Show radio button error
                isValid = false;
            }


            return isValid;
        }


        function validateLastProprietor() {
            let isValid = true;

            const blocks = document.querySelectorAll(".proprietor-block");
            const lastBlock = blocks[blocks.length - 1];
            if (!lastBlock) return true;

            const index = lastBlock.id.split("-")[1]; // e.g., "proprietor-0" → "0"

            // === BASIC REQUIRED FIELDS ===
            const requiredFields = [
                "input[name='proprietor_name[]']",
                "textarea[name='proprietor_address[]']",
                "input[name='age[]']",
                "input[name='qualification[]']",
                "input[name='fathers_name[]']",
                "input[name='present_business[]']"
            ];

            requiredFields.forEach(sel => {
                const field = lastBlock.querySelector(sel);
                if (field && field.value.trim() === "") {
                    field.classList.add("is-invalid");
                    isValid = false;
                } else if (field) {
                    field.classList.remove("is-invalid");
                }
            });

            // === COMPETENCY CERTIFICATE RADIO VALIDATION ===
            const compRadios = lastBlock.querySelectorAll(`input[name="competency_certificate_holding[${index}]"]`);
            const compError = lastBlock.querySelector(".competency_certificate_holding_error");
            const selectedComp = Array.from(compRadios).find(r => r.checked);

            if (selectedComp) {
                if (compError) compError.textContent = "";

                if (selectedComp.value === "yes") {
                    const certNumber = lastBlock.querySelector(".competency_number");
                    const certNumberError = lastBlock.querySelector(".competency_number_error");

                    const certValidity = lastBlock.querySelector(".competency_validity");
                    const certValidityError = lastBlock.querySelector(".competency_validity_error");

                    if (certNumber && certNumber.value.trim() === "") {
                        certNumber.classList.add("is-invalid");
                        if (certNumberError) certNumberError.textContent = "Certificate number is required.";
                        isValid = false;
                    } else {
                        certNumber.classList.remove("is-invalid");
                        if (certNumberError) certNumberError.textContent = "";
                    }

                    if (certValidity && certValidity.value.trim() === "") {
                        certValidity.classList.add("is-invalid");
                        if (certValidityError) certValidityError.textContent = "Certificate validity is required.";
                        isValid = false;
                    } else {
                        certValidity.classList.remove("is-invalid");
                        if (certValidityError) certValidityError.textContent = "";
                    }
                }
            } else {
                if (compError) {
                    compError.textContent = "Select Yes or No.";
                    compError.style.display = "block";
                }
                isValid = false;
            }

            // === EMPLOYER NAME & ADDRESS VALIDATION ===
            const empRadios = lastBlock.querySelectorAll(`input[name="presently_employed[${index}]"]`);
            const empError = lastBlock.querySelector(".presently_employed_error");
            const selectedEmp = Array.from(empRadios).find(r => r.checked);

            if (selectedEmp) {
                if (empError) empError.textContent = "";

                if (selectedEmp.value === "yes") {
                    const empName = lastBlock.querySelector(`.presently_employed_name`);
                    const empNameError = lastBlock.querySelector(`.presently_employed_name_error`);

                    const empAddress = lastBlock.querySelector(`.presently_employed_address`);
                    const empAddressError = lastBlock.querySelector(`.presently_employed_address_error`);


                    if (empName && empName.value.trim() === "") {
                        empName.classList.add("is-invalid");
                        if (empNameError) empNameError.textContent = "Employer Name is required.";
                        isValid = false;
                    } else {
                        empName.classList.remove("is-invalid");
                        if (empNameError) empNameError.textContent = "";
                    }

                    if (empAddress && empAddress.value.trim() === "") {
                        empAddress.classList.add("is-invalid");
                        if (empAddressError) empAddressError.textContent = "Employer Address is required.";
                        isValid = false;
                    } else {
                        empAddress.classList.remove("is-invalid");
                        if (empAddressError) empAddressError.textContent = "";
                    }
                }
            } else {
                if (empError) {
                    empError.textContent = "Select Yes or No.";
                    empError.style.display = "block";
                }
                isValid = false;
            }

            // === PREVIOUS EXPERIENCE VALIDATION ===
            const prevRadios = lastBlock.querySelectorAll(`input[name="previous_experience[${index}]"]`);
            const prevError = lastBlock.querySelector(".previous_experience_error");
            const selectedPrev = Array.from(prevRadios).find(r => r.checked);

            if (selectedPrev) {
                if (prevError) prevError.textContent = "";

                if (selectedPrev.value === "yes") {
                    const prevName = lastBlock.querySelector(`#previous_experience_name_index`);
                    const prevNameError = lastBlock.querySelector(`.previous_experience_name_error`);

                    const prevAddress = lastBlock.querySelector(`#previous_experience_address_index`);
                    const prevAddressError = lastBlock.querySelector(`.previous_experience_address_error`);

                    const prevNumber = lastBlock.querySelector(`#previous_experience_lnumber_index`);
                    const prevNumberError = lastBlock.querySelector(`.previous_experience_lnumber_error`);

                    const prevValidity = lastBlock.querySelector(`#previous_experience_lnumber_validity_index`);
                    const prevValidityError = lastBlock.querySelector(`.previous_experience_lnumber_validity_error`);

                    if (prevName && prevName.value.trim() === "") {
                        prevName.classList.add("is-invalid");
                        if (prevNameError) prevNameError.textContent = "Contractor Name is required.";
                        isValid = false;
                    } else {
                        prevName.classList.remove("is-invalid");
                        if (prevNameError) prevNameError.textContent = "";
                    }

                    if (prevAddress && prevAddress.value.trim() === "") {
                        prevAddress.classList.add("is-invalid");
                        if (prevAddressError) prevAddressError.textContent = "Contractor Address is required.";
                        isValid = false;
                    } else {
                        prevAddress.classList.remove("is-invalid");
                        if (prevAddressError) prevAddressError.textContent = "";
                    }

                    if (prevNumber && prevNumber.value.trim() === "") {
                        prevNumber.classList.add("is-invalid");
                        if (prevNumberError) prevNumberError.textContent = "License Number is required.";
                        isValid = false;
                    } else {
                        prevNumber.classList.remove("is-invalid");
                        if (prevNumberError) prevNumberError.textContent = "";
                    }

                    if (prevValidity && prevValidity.value.trim() === "") {
                        prevValidity.classList.add("is-invalid");
                        if (prevValidityError) prevValidityError.textContent = "License Validity is required.";
                        isValid = false;
                    } else {
                        prevValidity.classList.remove("is-invalid");
                        if (prevValidityError) prevValidityError.textContent = "";
                    }
                }
            } else {
                if (prevError) {
                    prevError.textContent = "Select Yes or No.";
                    prevError.style.display = "block";
                }
                isValid = false;
            }

            return isValid;
        }
    </script>

    <script>
        function toggleCompetencyFields(show) {
            const fields = document.querySelectorAll('.competency-fields');

            fields.forEach(field => {
                field.style.display = show ? '' : 'none';

                if (show) {
                    const row = field.closest('.row');
                    if (!row) return;

                    const numberInput = row.querySelector('.competency_number');
                    const validityInput = row.querySelector('.competency_validity');
                    const verifyInput = row.querySelector('.proprietor_cc_verify');
                    const resultDiv = row.querySelector('.competency_verify_result');

                    if (numberInput) {
                        numberInput.value = '';
                        numberInput.readOnly = false;
                    }

                    if (validityInput) {
                        validityInput.value = '';
                        validityInput.readOnly = false;
                    }

                    if (verifyInput) {
                        verifyInput.value = '';
                    }

                    if (resultDiv) {
                        resultDiv.textContent = '';
                    }

                    // Replace Clear button with Verify button

                }
            });
        }


        function toggleEmploymentFields(show) {
            const fields = document.querySelectorAll('.employment-fields');

            fields.forEach(field => {
                field.style.display = show ? 'block' : 'none';

                if (show) {
                    const inputs = field.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        input.value = '';
                        input.readOnly = false;
                        input.disabled = false;
                    });
                }
            });
        }



        function toggleAuthorisedFields(show) {
            document.querySelectorAll(".authorised-fields").forEach(field => {
                field.style.display = show ? "block" : "none";
            });


        }


        // ------------------radiobutton clicked---------------

        // function toggleAuthorisedFields(show) {
        //     const section = document.querySelector('.authorised-fields');
        //     if (show) {
        //         section.style.display = 'block';
        //     } else {
        //         section.style.display = 'none';
        //         // Optionally clear values:
        //         document.getElementById('authorised_name').value = '';
        //         document.getElementById('authorised_designation').value = '';
        //     }
        // }
        // -------------------------------


        function toggleExperienceFields(show) {


            const fields = document.querySelectorAll('.experience-fields');

            fields.forEach(field => {
                field.style.display = show ? 'block' : 'none';

                if (show) {
                    const inputs = field.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        input.value = '';
                        input.readOnly = false;
                        input.disabled = false;
                    });
                }
            });
        }
        //    function toggleAuthorisedFields(show) {
        //     const section = document.querySelector('.authorised-fields');
        //     if (section) {
        //         section.style.display = show ? 'block' : 'none';
        //     }
        // }

        // // On page load, check if old or default value is 'yes'
        // document.addEventListener("DOMContentLoaded", function () {
        //     const selected = document.querySelector('input[name="authorised_name_designation"]:checked');
        //     if (selected) {
        //         toggleAuthorisedFields(selected.value === 'yes');
        //     }
        // });
        function toggleAuthorisedFields(show) {
            const section = document.querySelector('.authorised-fields');

            if (section) {
                if (show) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';

                    // Clear all input values inside the authorised-fields section
                    const inputs = section.querySelectorAll('input');
                    inputs.forEach(input => input.value = '');
                }
            }
        }

        // On page load, show/hide based on previously selected radio
        document.addEventListener("DOMContentLoaded", function() {
            const selected = document.querySelector('input[name="authorised_name_designation"]:checked');
            if (selected) {
                toggleAuthorisedFields(selected.value === 'yes');
            }
        });


        // recent---------------------
      function togglePreviousLicenseFields(show) {
    const section = document.querySelector(".previous-license-fields");

    if (!section) return;

    section.style.display = show ? "block" : "none";

    if (!show) {
        // Clear all input values and remove readonly
        const inputs = section.querySelectorAll("input");
        inputs.forEach(input => {
            input.value = "";
            input.removeAttribute("readonly");
        });

        // Reset verification result display
        const verifyResult = document.getElementById("verifyea_result");
        if (verifyResult) verifyResult.innerHTML = "";

        // Reset hidden verification input to null (empty)
        const verifyInput = section.querySelector("input.previous_contractor_license_verify");
        if (verifyInput) verifyInput.value = "";

        // Replace Clear button with Verify button
        const wrapper = document.getElementById("licenseVerificationBtnWrapper");
        if (wrapper) {
            wrapper.innerHTML = `
                <button type="button" class="btn btn-primary" id="verifyLicenseBtn" onclick="verifyeaCertificateprevoius(event, this)">Verify</button>
                <input 
                    type="hidden" 
                    name="previous_contractor_license_verify" 
                    class="previous_contractor_license_verify"
                    value="">
            `;
        }
    }
}
// -------------------


        // On page load, show/hide section based on saved value
        document.addEventListener("DOMContentLoaded", function() {
            const selected = document.querySelector('input[name="previous_contractor_license"]:checked');
            togglePreviousLicenseFields(selected?.value === 'yes');
        });

        function setDateRestrictions(input) {
            input.type = 'date';
            let currentYear = new Date().getFullYear();
            input.min = "1970-01-01";
            input.max = currentYear + "-12-31";
        }

        function setDateRestrictions(input) {
            input.type = 'date';

            // Set max as today
            const today = new Date().toISOString().split('T')[0];
            input.max = today;
        }

        document.addEventListener("DOMContentLoaded", function() {
            let applicantNameInput = document.getElementById("applicant_name");
            if (applicantNameInput) {

                applicantNameInput.addEventListener("focus", function() {
                    this.addEventListener("input", function() {
                        this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
                    });
                });

            }
        });


        document.addEventListener("DOMContentLoaded", function() {
            let applicantNameInput = document.getElementById("staff_name");
            if (applicantNameInput) {
                applicantNameInput.addEventListener("focus", function() {
                    this.addEventListener("input", function() {
                        this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
                    });
                });
            }
        });



        document.addEventListener("DOMContentLoaded", function() {
            let applicantNameInput = document.getElementById("fathers_name");

            if (applicantNameInput) {
                applicantNameInput.addEventListener("focus", function() {
                    this.addEventListener("input", function() {
                        this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
                    });
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            function restrictInputToLetters(inputElement) {
                inputElement.addEventListener("input", function() {
                    this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
                });
            }

            let staffNameInput = document.getElementById("staff_name");
            if (staffNameInput) {
                restrictInputToLetters(staffNameInput);
            }



            let proprietorNameInputs = document.querySelectorAll("[name='proprietor_name[]']");
            proprietorNameInputs.forEach(function(input) {
                restrictInputToLetters(input);
            });

            let fathermeInputs = document.querySelectorAll("[name='fathers_name[]']");
            fathermeInputs.forEach(function(input) {
                restrictInputToLetters(input);
            });



            let presently_employed_nameInputs = document.querySelectorAll("[name='presently_employed_name[]']");
            presently_employed_nameInputs.forEach(function(input) {
                restrictInputToLetters(input);
            });

            let previous_experience_nameInputs = document.querySelectorAll("[name='previous_experience_name[]']");
            previous_experience_nameInputs.forEach(function(input) {
                restrictInputToLetters(input);
            });

            let name_of_authorised_to_sign = document.querySelectorAll("[name='name_of_authorised_to_sign[]']");
            name_of_authorised_to_sign.forEach(function(input) {
                restrictInputToLetters(input);
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            let ageInput = document.getElementById("age");

            ageInput.addEventListener("input", function() {
                let value = parseInt(this.value, 10);
                if (value >= 50) {
                    this.value = 49; // Set max limit to 49
                } else if (value < 0 || isNaN(value)) {
                    this.value = ""; // Prevent negative numbers or invalid input
                }
            });
        });






        const wrapper = document.getElementById('authority-names-wrapper');
        const maxFields = 3; // Maximum allowed inputs

        wrapper.addEventListener('click', function(e) {
            // Add more fields
            if (e.target.closest('#add-more-authority-name')) {
                const currentCount = wrapper.querySelectorAll('.authority-name-row').length;

                if (currentCount < maxFields) {
                    const group = document.createElement('div');
                    group.classList.add('row', 'authority-name-row', 'mt-2');

                    group.innerHTML = `
                    <div class="col-12 col-md-7 authority-name-group">
                        <input type="text" class="form-control authority-name"
                               name="name_of_authorised_to_sign[]"
                               placeholder="Name of Authority"
                               oninput="this.value = this.value.replace(/[^a-zA-Z\\s]/g, '')">
                    </div>
                    <div class="col-12 col-md-5">
                        <button type="button" class="btn btn-danger remove-authority-name">
                            <i class="fa fa-trash-o"></i> Remove
                        </button>
                    </div>
                `;
                    wrapper.appendChild(group);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limit Reached',
                        text: 'You can add a maximum of 3 authority names.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                        width: '450px',
                    });
                }
            }

            // Remove individual row
            if (e.target.closest('.remove-authority-name')) {
                const row = e.target.closest('.authority-name-row');
                if (row) row.remove();
            }
        });


        // ----license check---------------
        function clearPreviousLicense() {
            document.getElementById('previous_application_number').removeAttribute('readonly');
            document.getElementById('previous_application_validity').removeAttribute('readonly');

            // Reset the hidden verification field
            document.querySelector('.previous_contractor_license_verify').value = '0';

            // Replace button with Verify
            document.getElementById('licenseVerificationBtnWrapper').innerHTML = `
        <button type="button" class="btn btn-primary" id="verifyLicenseBtn" onclick="verifyeaCertificateprevoius(event, this)">Verify</button>
          <input 
                                                type="hidden" 
                                                name="previous_contractor_license_verify" 
                                                class="previous_contractor_license_verify"
                                                value="{{ $application?->previous_contractor_license_verify ?? '' }}">
    `;
        }

        // --------------------------proprietorCC check ---------------------


        function clearCompetencyVerification(button) {
            const container = button.closest('.row');

            // Target inputs
            const numberInput = container.querySelector('.competency_number');
            const validityInput = container.querySelector('.competency_validity');
            const verifyBtn = document.createElement('button');
            const hiddenVerifyInput = container.querySelector('.proprietor_cc_verify');

            // Enable inputs
            if (numberInput) numberInput.readOnly = false;
            if (validityInput) validityInput.readOnly = false;

            // Remove "Clear" button
            button.remove();

            // Create and insert "Verify" button
            verifyBtn.type = 'button';
            verifyBtn.className = 'btn btn-primary mt-3 verify-btn';
            verifyBtn.innerText = 'Verify';
            verifyBtn.setAttribute('onclick', 'verifyCompetencyCertificate(event, this)');

            const buttonCol = container.querySelector('.col-md-2');
            if (buttonCol) {
                buttonCol.appendChild(verifyBtn);
            }

            // Reset hidden input (optional, based on your backend handling)
            if (hiddenVerifyInput) {
                hiddenVerifyInput.value = '';
            }

            // Clear result message
            const resultDiv = container.querySelector('.competency_verify_result');
            if (resultDiv) {
                resultDiv.textContent = '';
            }
        }

        // ------------contractor cc verify--------------------------

        function clearContractorLicenseVerification(button) {
            const container = button.closest('.row');

            // Target inputs
            const licenseInput = container.querySelector('.ea_license_number');
            const validityInput = container.querySelector('.ea_validity');
            const hiddenVerifyInput = container.querySelector('.proprietor_contractor_verify');
            const resultDiv = container.querySelector('.competency_verifyea_result');

            // Make inputs editable
            if (licenseInput) licenseInput.readOnly = false;
            if (validityInput) validityInput.readOnly = false;

            // Remove Clear button
            button.remove();

            // Create and insert Verify button
            const verifyBtn = document.createElement('button');
            verifyBtn.type = 'button';
            verifyBtn.className = 'btn btn-primary mt-3 verify-btn';
            verifyBtn.innerText = 'Verify';
            verifyBtn.setAttribute('onclick', 'verifyeaCertificate(event, this)');

            const buttonCol = container.querySelector('.col-md-2');
            if (buttonCol) {
                buttonCol.appendChild(verifyBtn);
            }

            // Clear the hidden verification value
            if (hiddenVerifyInput) {
                hiddenVerifyInput.value = '';
            }

            // Clear result message
            if (resultDiv) {
                resultDiv.textContent = '';
            }
        }


        // --------------------------

        $(document).on('click', '.clearBtn', function() {
            let row = $(this).closest('tr');

            // Make inputs editable
            row.find('.cc_number, .cc_validity').prop('readonly', false);

            // Update hidden input
            row.find('.staff_cc_verify').val('0');

            // Remove 'Clear' button and add 'Verify' button
            $(this).replaceWith(`
            <button type="button" class="btn btn-primary verifyBtn" onclick="validatestaffcertificate(event, this)">Verify</button>
        `);
        });
    </script>



    <!-- ------------------aadhaar check-------------------- -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeBtn = document.getElementById('remove-aadhaar-doc');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    const existingRow = document.getElementById('aadhaar-existing-row');
                    const fileRow = document.getElementById('aadhaar-file-row');

                    if (existingRow) existingRow.remove();
                    if (fileRow) fileRow.style.display = 'flex';
                });
            }
        });
    </script>
    <!-- ----------------------aadhaar documents-------------- -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupRemoveButton(btnId, existingRowId, fileRowId, fieldName) {
                const removeBtn = document.getElementById(btnId);
                if (!removeBtn) return;

                removeBtn.addEventListener('click', function() {
                    // Remove preview row
                    const existingRow = document.getElementById(existingRowId);
                    if (existingRow) existingRow.remove();

                    // Show file input
                    const fileRow = document.getElementById(fileRowId);
                    if (fileRow) fileRow.style.display = 'flex';

                    // Add hidden input to mark removal
                    let hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = fieldName + '_remove'; // matches backend
                    hidden.value = '1';
                    document.querySelector('form').appendChild(hidden);
                });
            }

            setupRemoveButton('remove-aadhaar-doc', 'aadhaar-existing-row', 'aadhaar-file-row', 'aadhaar_doc');
            setupRemoveButton('remove-pan-doc', 'pan-existing-row', 'pan-file-row', 'pancard_doc');
            setupRemoveButton('remove-gst-doc', 'gst-existing-row', 'gst-file-row', 'gst_doc');
        });

        // draft---------proprietorCount index--------
        function toggleEmploymentFieldsdraft(show, index) {
            const fields = document.querySelectorAll(`.employment-fields-${index}`);

            fields.forEach(field => {
                field.style.display = show ? 'block' : 'none';

                if (show) {
                    // Clear all input fields inside the block when toggled back to Yes
                    const inputs = field.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        input.value = '';
                        input.readOnly = false;
                        input.disabled = false;
                    });
                }
            });


        }

        function toggleCompetencyFieldsdraft(show, index) {
            const fields = document.querySelectorAll(`.competency-fields-${index}`);

            fields.forEach(field => {
                field.style.display = show ? '' : 'none';
            });

            if (show) {
                // Clear the inputs when switching back to 'Yes'
                const row = fields[0]?.closest('.row');
                if (!row) return;

                const numberInput = row.querySelector('.competency_number');
                const validityInput = row.querySelector('.competency_validity');
                const verifyInput = row.querySelector('.proprietor_cc_verify');
                const resultDiv = row.querySelector('.competency_verify_result');

                if (numberInput) {
                    numberInput.value = '';
                    numberInput.readOnly = false;
                }

                if (validityInput) {
                    validityInput.value = '';
                    validityInput.readOnly = false;
                }

                if (verifyInput) {
                    verifyInput.value = '';
                }

                if (resultDiv) {
                    resultDiv.textContent = '';
                }

                // Replace Clear button with Verify button if necessary
                const btnCol = row.querySelector('.col-md-2');
                const clearBtn = btnCol?.querySelector('.clear-btn');
                if (clearBtn) {
                    clearBtn.remove();

                    const verifyBtn = document.createElement('button');
                    verifyBtn.type = 'button';
                    verifyBtn.className = 'btn btn-primary mt-3 verify-btn';
                    verifyBtn.textContent = 'Verify';
                    verifyBtn.setAttribute('onclick', 'verifyCompetencyCertificate(event, this)');
                    btnCol.appendChild(verifyBtn);
                }
            }
        }


        function toggleExperienceFieldsdraft(show, index) {
            const block = document.querySelector(`.experience-fields-${index}`);

            if (block) {
                block.style.display = show ? 'block' : 'none';

                if (show) {
                    // Clear all input fields inside the block when toggled back to Yes
                    const inputs = block.querySelectorAll('input, textarea');
                    inputs.forEach(input => {
                        input.value = '';
                        input.readOnly = false;
                        input.disabled = false;
                    });

                    // Optional: If there's a verification result or clear button like in competency

                }
            }
        }

        // ----remove proprietorCount draft-------------
        $(document).on('click', '.remove-proprietor-entry', function() {
            $(this).closest('.proprietor-entry').remove();
            proprietorCount--;

            if (proprietorCount < maxProprietors) {
                const last = $('.proprietor-entry').last();

                // Re-add the add button only if not already there
                if ($('#add-more-proprietor-draft').length === 0 && $('#add-more-proprietor').length === 0) {
                    last.append(`
                <div class="text-right mt-3" id="static-add-button-wrapper">
                    <button id="add-more-proprietor-draft" class="btn btn-primary text-md-right">
                        <i class="fa fa-plus"></i> Add Draft Proprietor /Partner
                    </button>
                </div>
                <div id="proprietor-container"></div>
            `);
                }
            }
        });
    </script>