@include('include.header')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.all.min.js"></script>
<!-- @if(session('expired_license'))


<script>
Swal.fire({
    icon: 'warning',
    title: 'License Expired',
    width:450,
    html: `<p>Your license expired on <b>{{ session('expired_date') }}</b>.</p>
           <p>Please apply as a <b>fresh application</b>.</p>`,
    confirmButtonText: 'OK',
    confirmButtonColor: '#3085d6'
});
</script>
@endif -->


<style>
    .tab-error-bg {
        border: 1px solid red !important;
        /* background-color: red !important;   */
        color: #721c24 !important;
        font-weight: 600;
        border-radius: 6px;
    }


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

    .swal2-popup-sm {
        width: 35% !important;
        max-width: 100%;
        font-size: 0.95rem;
    }

    .nav-item {
        display: block;
        color: #023a73 !important;
        padding: 5px 5px;
        border-radius: 3px;
        border: 1px solid #cecaca;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 -1px 0px 0 rgb(3 90 179), 0 1px 5px 0 rgb(0 123 255);
    }

    .nav-item:nth-child(2) {
        border-left: none;
    }

    .tabs-section a.nav-item.selected {
        background-color: #035ab3;
        color: #fff !important;
    }
</style>


<section class="">
    <div class="auto-container_a">
        <ul id="breadcrumb">
            <li><a href="{{ route('dashboard')}}"><span class="fa fa-home"> </span> Dashboard</a></li>
            <li><a href="#"><span class=" fa fa-info-circle"> </span> Form A</a></li>

        </ul>
    </div>
</section>
<!-- <pre>
{{ Auth::user() }}
</pre>
exit; -->




<section class="tabs-section apply-card">
    <div class="auto-container_a">
        <div class="apply-card-header bg-form">
            <div class="row">
                <div class="col-12 col-lg-12 text-center">
                    <h5 class="card-title_apply text-white text-center text-uppercase"> <span style="font-weight: 600;">Application for Electrical Contractor's Licence-Grade 'A' </span></h5>

                    <h6 class="card-title_apply text-white mt-2 form-title text-uppercase">FORM - A / Licence EA</h4>
                        <!-- <h6 class="card-title_apply text-white text-center">(Read the Instructions overleaf before filling the form)</h6> -->
                </div>




            </div>

            <div class="row">


                <div class="col-12 col-lg-12 text-md-right">
                    <a href="{{url('assets/pdf/form_a_notes.pdf')}}" class="text-white" target="_blank">
                        <span class="text-white font-weight-bold"> &nbsp; Instructions </span>

                        English <i class="fa fa-file-pdf-o"></i> (74 KB)</a>

                </div>



            </div>
        </div>

        <form id="competency_form_a" enctype="multipart/form-data">

            @csrf
            <input type="hidden" class="form-control text-box single-line" id="login_id_store" name="login_id_store" value="{{ Auth::user()->login_id }}">
            <input type="hidden" class="form-control text-box single-line" id="form_name" name="form_name" value="A">


            <input type="hidden" class="form-control text-box single-line" id="license_name" name="license_name" value="EA">



            <input type="hidden" class="form-control text-box single-line" id="appl_type" name="appl_type" value="N">

            <input type="hidden" class="form-control text-box single-line" id="form_id" name="form_id" value="5">
            <input type="hidden" class="form-control text-box single-line" id="amount" name="amount" value="12000">


            <input type="hidden" name="record_id" id="record_id" value="{{ $application->application_id ?? '' }}">

            <div class="tabs" id="tabbedForm">
                <div class="row">
                    <div class="col-12 col-md-12 text-md-right text-head">
                        <p class="text-black f-s-14"> <span style="color: red;">*</span> Fields are Mandatory </p>
                    </div>

                </div>

                <nav class="tab-nav">
                    <!-- <button class="tab-btn active">Basic Details</button>
                    <button class="tab-btn">Proprietor Details</button>
                    <button class="tab-btn">Upload Documents</button> -->
                </nav>

                @php
                $application = $application ?? null;
                @endphp
                <div class="tab tab-btn" data-name="Basic Details">

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
                                    <textarea id="business_address" rows="2" class="form-control" name="business_address" placeholder="Business Address">{{ $application->business_address ?? '' }}</textarea>
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
                            <label>3) Ownership Type - Proprietor / Partners / Directors Details<span style="color: red;">*</span></label>

                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="offset-md-2 col-lg-3 mt-2 text-right ">
                            <h6 class="fw-bold">Type of Ownership</h6>
                        </div>


                        <div class="col-lg-3 ">
                            <select class="custom-select" name="application_ownershiptype" id="ownership_type_select">
                                <option value="1">---Select Ownership Type---</option>
                                <option value="pr" {{ isset($application) && $application->application_ownershiptype == 'pr' ? 'selected' : '' }}>Proprietorship</option>
                                <option value="pt" {{ isset($application) && $application->application_ownershiptype == 'pt' ? 'selected' : '' }}>Partnership</option>
                                <option value="pvt" {{ isset($application) && $application->application_ownershiptype == 'pvt' ? 'selected' : '' }}>Private Limited (PVT LTD)</option>

                                <option value="ltd" {{ isset($application) && $application->application_ownershiptype == 'ltd' ? 'selected' : '' }}>Limited (LTD)</option>
                            </select>
                            <span class="error text-danger" id="ownership_type_error"></span>

                        </div>
                    </div>


                    <!-- ----------------enter type ------------------ -->
                    <!-- Ownership Type -->
                    <div class="row mt-2" style="display: none;">
                        <div class="col-12 col-md-3 offset-md-2 text-md-right">
                            <label>Select Type <span class="text-red">*</span></label>
                        </div>
                        <div class="col-12 col-md-3">
                            <select class="form-control" id="type_of_ea_license" name="type_of_ea_license">
                                <option value="0">---Select Type---</option>
                                <option value="1">Proprietor</option>
                                <option value="2">Partners</option>
                                <option value="3">Directors</option>
                            </select>
                            <span class="error text-danger" id="type_of_ea_license_error"></span>
                        </div>
                    </div>


                    <!-- ----------------enter type ------------------ -->


                    @php
                    $proprietors = $proprietors ?? collect();
                    @endphp
                    <!-- Partner Section Template -->
                    <!-- Proprietor Details -->
                    <div id="proprietor-section" class="mt-3">
                        <div class="row mt-2">
                            <!-- <div class="col-md-12 col-12 text-md-right pb-20">
                                <button type="button" class="btn btn-primary" id="add-partner">
                                    <i class="fa fa-plus"></i> Add Partner
                                </button>

                            </div> -->

                            <div class="col-md-12 col-12  pb-20">
                                <h5 class="card-title_apply">Proprietor Details (if any)</h5>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered head_label_proprietor">
                                    <thead>
                                        <tr>
                                            <th>Name </th>
                                            <th>Father/s
                                                Husband/s
                                                Name</th>
                                            <th>D.O.B and Age</th>
                                            <th>Address </th>
                                            <th>Qualifications and Proof </th>


                                            <th>Present business of
                                                the applicant</th>
                                            <th>Competency
                                                Certificate and
                                                Validity </th>
                                            <th>Presently
                                                Employed
                                                and Address </th>
                                            <th>If holding a
                                                contractor
                                                certificate </th>
                                                <!-- <th>Proof</th> -->
                                            <!-- <input type="hidden" value="proprietor" name="ownership_type"> -->
                                            <th colspan="2" style="width: 100px;"> <button type="button" class="btn btn-primary" id="add-proprietor">
                                                    <i class="fa fa-plus"></i> Add
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($proprietors as $p)
                                        @if($p->ownership_type === 'pr')
                                        <tr data-id="{{ $p->id }}">
                                            <td>{{ $p->proprietor_name }}</td>
                                            <td>{{ $p->fathers_name }}</td>
                                            <td>{{ $p->age }}</td>
                                            <td>{{ $p->proprietor_address }}</td>
                                            <td>{{ $p->qualification }}</td>
                                            <td>{{ $p->present_business }}</td>
                                            <td data-competency="{{ $p->competency_certificate_holding }}" data-certno="{{ $p->competency_certificate_number }}" data-validity="{{ $p->competency_certificate_validity }}">
                                                @if($p->competency_certificate_holding == 'yes')
                                                Yes - CC_No: {{ $p->competency_certificate_number }},
                                                Validity: {{ \Carbon\Carbon::parse($p->competency_certificate_validity)->format('d-m-Y') }}
                                                @else
                                                No
                                                @endif
                                            </td>
                                            <td data-employed="{{ $p->presently_employed }}" data-employer="{{ $p->presently_employed_name }}" data-empaddress="{{ $p->presently_employed_address }}">
                                                {{ $p->presently_employed == 'yes' ? "Yes - {$p->presently_employed_name}, {$p->presently_employed_address}" : "No" }}
                                            </td>
                                            <td data-experience="{{ $p->previous_experience }}" data-expname="{{ $p->previous_experience_name }}" data-expaddress="{{ $p->previous_experience_address }}" data-explicense="{{ $p->previous_experience_lnumber }}" data-expvalidity="{{ $p->previous_experience_lnumber_validity }}">

                                                {{
                                                    $p->previous_experience == 'yes' 
                                                        ? "Yes - {$p->previous_experience_name}, {$p->previous_experience_address}, Lic No: {$p->previous_experience_lnumber}, Validity: " . \Carbon\Carbon::parse($p->previous_experience_lnumber_validity)->format('d-m-Y') 
                                                        : "No" 
                                                }}

                                            </td>
                                            <td style="display: none;">
                                                <input type="hidden" name="ownership_type[]" value="{{ $p->ownership_type }}">
                                            </td>


                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm update-proprietor-row" data-id="{{ $p->id }}">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-proprietor-row" data-id="{{ $p->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="col-12 col-md-5  text-md-right">
                                <h5>Number of Partners? (Min 2, Max 6)</h5>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="number" class="form-control" id="partner-count-input" min="2" max="6" />
                                <span class="error text-danger" id="partner-count-error"></span>
                            </div> -->


                        </div>

                        <!-- style="display:none;" -->
                        <div class="border box-shadow-blue p-3 mt-3" id="proprietor-sectionfresh" style="display:none;">

                            <!-- <h4 class="text-center">---------Proprietor Details --------------</h4> -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Proprietor Details </h5>
                                </div>
                            </div>
                            <div class="row mt-3">

                                <input type="hidden" name="ownership_type[]" value="pr">
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-12">
                                            <label for="Name">(i) Full name and house address of proprietor <span style="color: red;">*</span><br><span class="text-label" style="color: #023466;">(If it is partnership concern, partnership deed should be enclosed)</span></label>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <!-- <textarea rows="3" class="form-control" name="proprietor_name"></textarea> -->
                                            <label>Proprietor Name <span class="text-red">*</span></label>

                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" class="form-control mb-2 proprietor_name" maxlength="50" id="proprietor_name" name="proprietor_name[]" placeholder="Proprietor Name">

                                            <span class="error text-danger" id="proprietor_name_error"></span>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label>Proprietor Address <span class="text-red">*</span></label>

                                        </div>

                                        <div class="col-12 col-md-6">
                                            <textarea rows="3" class="form-control" name="proprietor_address[]" placeholder="Proprietor Address"></textarea>
                                            <span class="error text-danger" id="proprietor_address_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <label for="Name">(ii) Age and qualification along with
                                                evidence <span style="color: red;">*</span></label>
                                        </div>

                                    </div>



                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <label>Date Of Birth <span class="text-red">*</span></label>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <input type="date" class="form-control dob" name="dob[]">
                                            <span class="error text-danger dob_error"></span>
                                        </div>

                                        <div class="col-12 col-md-2">
                                            <label>Age <span class="text-red">*</span></label>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <input type="number" class="form-control age" name="age[]" readonly>
                                            <span class="error text-danger age_error"></span>
                                        </div>
                                    </div>


                                    <div class="row mt-2">
                                        <div class="col-12 col-md-3 ">
                                            <label>Qualification <span class="text-red">*</span></label>
                                        </div>
                                        <!-- <input type="text" class="form-control" id="qualification" name="qualification[]" placeholder="Qualification" value=""> -->
                                        <div class="col-12 col-md-3">
                                            <select class="form-control" id="qualification" name="qualification[]">
                                                <option disabled selected>Qualification</option>
                                                <option value="8 To 12">8 To 12</option>
                                                <option value="Diploma">Diploma</option>
                                                <option value="Degree">Degree</option>
                                                <option value="Master Degree">Master Degree</option>

                                            </select>
                                        </div>



                                    </div>

                                    <div class="row mt-2">

                                        <div class="col-12 col-md-3">
                                            <label>Qualification Proof <span class="text-red">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <input type="file" class="form-control" id="qual_proof" name="qual_proof[]" value="">
                                            <span class="error text-danger" id="qual_proof_error"></span>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <button class="btn btn-info"> <i class="fa fa-upload"></i> Upload </button>
                                        </div>

                                    </div>




                                </div>

                            </div>

                            <!-- ------------------------------------------ -->
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-4">
                                            <label for="Name">(iii) Father/Husband's name <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" class="form-control" id="fathers_name" maxlength="50" name="fathers_name[]" value="" placeholder="Father/Husband's name">
                                            <span class="error text-danger" id="fathers_name_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-5">
                                            <label for="Name">(iv) Present business of the applicant <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="text" class="form-control" id="present_business" name="present_business[]" value="" maxlength="50" placeholder="Present business of the applicant">
                                            <span class="error text-danger" id="present_business_error"></span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <!-- ---------------------- -->
                            <div class="row mt-2">
                                <!-- <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-12">
                                            <label for="competency_certificate_holding">(v) Whether holding a competency certificate and if so, the number and validity of the competency certificate</label>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="competency_yes" name="competency_certificate_holding[]" value="yes" onclick="toggleCompetencyFields(true)">
                                                <label class="form-check-label" for="competency_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    id="competency_no"
                                                    name="competency_certificate_holding[]"
                                                    value="no"
                                                    onclick="toggleCompetencyFields(false)"
                                                    checked>
                                                <label class="form-check-label" for="competency_no">No</label>
                                            </div>
                                            <span class="text-danger competency_certificate_holding_error_radio" style="font-size: 0.875rem; display: none;"></span>
                                            <span class="text-danger competency_certificate_holding_error ms-3"></span>
                                        </div>


                                        <div class="col-12 col-md-5 mt-1  competency-fields" style="display: none;">
                                            <label>Competency Certificate No <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control mt-1 competency_number" name="competency_certificate_number[]" maxlength="15" placeholder="Certificate Number">
                                            <span class="error text-danger competency_number_error"></span>
                                        </div>
                                        <div class="col-12 col-md-5 mt-1 competency-fields" style="display: none;">
                                            <label> Validity <span style="color: red;">*</span></label>
                                            <input type="date"
                                                class="form-control competency_validity"
                                                name="competency_certificate_validity[]"
                                                placeholder="Validity">

                                            <span class="error text-danger competency_validity_error"></span>



                                        </div>

                                        <div class="col-12 col-md-2 mt-3  competency-fields" style="display: none;">
                                            <button type="button" class="btn btn-primary" onclick="verifyCompetencyCertificate(event, this)">Verify</button>
                                            <input type="hidden" name="proprietor_cc_verify[]" class="competency_status" value="0">

                                            <input type="hidden" name="proprietor_cc_verify[]" class="proprietor_cc_verify" value="0">


                                        </div>

                                        <div class="col-12 mt-1">
                                            <div class="text-danger competency_verify_result"></div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-12">
                                            <label>(v) Whether holding a competency certificate and if so, the number and validity</label>
                                        </div>

                                        <div class="col-12 col-md-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    id="competency_yes"
                                                    name="competency_certificate_holding[]"
                                                    value="yes"
                                                    onclick="toggleCompetencyFields('proprietor', true)">
                                                <label class="form-check-label" for="competency_yes_proprietor">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    id="competency_no"
                                                    name="competency_certificate_holding[]"
                                                    value="no"
                                                    onclick="toggleCompetencyFields('proprietor', false)"
                                                    checked>
                                                <label class="form-check-label" for="competency_no_proprietor">No</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-5 mt-1 competency-fields-proprietor" style="display: none;">
                                            <label>Competency Certificate No <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control mt-1 competency_number" name="competency_certificate_number[]" maxlength="15" placeholder="Competency Certificate Number">
                                            <span class="error text-danger competency_number_error"></span>
                                        </div>

                                        <div class="col-12 col-md-5 mt-1 competency-fields-proprietor" style="display: none;">
                                            <label> Validity Date <span style="color: red;">*</span></label>
                                            <input type="date"
                                                class="form-control competency_validity"
                                                name="competency_certificate_validity[]"
                                                placeholder="Validity">

                                            <span class="error text-danger competency_validity_error"></span>
                                        </div>

                                        <div class="col-12 col-md-2 mt-3 competency-fields-proprietor" style="display: none;">
                                            <button type="button" class="btn btn-primary" onclick="verifyCompetencyCertificate(event, this)">Verify</button>
                                            <!-- <input type="hidden" name="proprietor_cc_verify[]" class="competency_status" value="0"> -->

                                            <input type="hidden" name="proprietor_cc_verify[]" class="proprietor_cc_verify" value="0">

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
                                                <input class="form-check-input" type="radio" id="employed_yes" name="presently_employed[]" value="yes" onclick="toggleEmploymentFields('proprietor', true)">
                                                <label class="form-check-label" for="employed_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="employed_no" name="presently_employed[]" value="no" onclick="toggleEmploymentFields('proprietor', false)" checked>
                                                <label class="form-check-label" for="employed_no">No</label>
                                            </div>
                                            <span class="error text-danger presently_employed_error" id="presently_employed_error"></span>
                                        </div>

                                        <div class="col-12 col-md-6 mt-1 employment-fields-proprietor" style="display: none;">
                                            <label>Name of the Employer <span class="text-red">*</span></label>
                                            <input type="text" class="form-control" id="presently_employed_name" name="presently_employed_name[]" maxlength="50" placeholder="Name of the Employer">
                                            <span class="error text-danger presently_employed_name_error"></span>
                                        </div>
                                        <div class="col-12 col-md-6 mt-1  employment-fields-proprietor" style="display: none;">
                                            <label>Address of the Employer <span class="text-red">*</span></label>
                                            <textarea class="form-control" id="presently_employed_address" name="presently_employed_address[]" placeholder="Address of the Employer"></textarea>

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
                                                <input class="form-check-input" type="radio" id="previous_experience" name="previous_experience[]" value="yes" onclick="toggleExperienceFields('proprietor', true)">
                                                <label class="form-check-label" for="previous_experience">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="previous_experience" name="previous_experience[]" value="no" onclick="toggleExperienceFields('proprietor', false)" checked>
                                                <label class="form-check-label" for="previous_experience">No</label>
                                            </div>


                                            <span class="error text-danger previous_experience_error" id="previous_experience_error"></span>
                                        </div>


                                        <div class="col-12 col-md-12  experience-fields-proprietor" style="display: none;">
                                            <div class="row">
                                                <div class="col-12 col-md-5 mt-1">
                                                    <label>Name of the Contractor <span class="text-red">*</span></label>
                                                    <input class="form-control" type="text" id="previous_experience_name" name="previous_experience_name[]" placeholder="Name of the Contractor">

                                                    <span class="error text-danger previous_experience_name_error"></span>
                                                </div>
                                                <div class="col-12 col-md-5 mt-1">
                                                    <label>Address of the Contractor <span class="text-red">*</span></label>
                                                    <textarea class="form-control" id="previous_experience_address" name="previous_experience_address[]" placeholder="Address of the Contractor"></textarea>

                                                    <span class="error text-danger previous_experience_address_error"></span>
                                                </div>

                                                <div class="col-12 col-md-5 mt-1">
                                                    <label>Previous EA Licence A Grade Licence Number <span class="text-red">*</span></label>
                                                    <input class="form-control ea_license_number" type="text" id="previous_experience_lnumber" maxlength="15" name="previous_experience_lnumber[]" placeholder="Previous EA Licence A Grade Licence Number">

                                                    <span class="error text-danger previous_experience_lnumber_error"></span>
                                                </div>

                                                <div class="col-12 col-md-5 mt-1">
                                                    <label>Previous EA Licence A Grade Validity Date <span class="text-red">*</span></label>
                                                    <input class="form-control ea_validity" type="date"
                                                        onfocus="(this.type='date')"
                                                        id="previous_experience_lnumber_validity" name="previous_experience_lnumber_validity[]" placeholder="License Number Validity">

                                                    <span class="error text-danger previous_experience_lnumber_validity_error"></span>
                                                </div>

                                                <div class="col-12 col-md-2 mt-5">
                                                    <button type="button" class="btn btn-primary" onclick="verifyeaCertificate(event, this)">Verify</button>
                                                    <!-- <input type="text" name="proprietor_contractor_verify[]" class="contactor_license_verify" value="0"> -->
                                                    <input type="hidden" name="proprietor_contractor_verify[]" class="proprietor_contractor_verify" value="0">

                                                </div>



                                                <div class="col-12 mt-1">
                                                    <div class="text-danger competency_verifyea_result"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-12 col-md-12 text-md-right">

                                            <button type="button" class="btn btn-success" id="save_proprietor">Save</button>
                                            <button type="button" class="btn btn-danger ms-2" id="cancel_proprietor">Cancel</button>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class=" mt-4 ">
                       <h3>Proprietor/Partner Details</h3> 
                        <div class="col-12 col-md-12 text-md-right" id="static-add-button-wrapper">
                            <button id="add-more-proprietor" class="btn btn-primary text-md-right"><i class="fa fa-plus"></i> Add Proprietor /Partner</button>
                        </div>
                        <div id="proprietor-container"></div> 
                    </div> -->
                        </div>
                    </div>
                    <!-- style="display:none;" -->
                    <div id="partner-section" class="mt-3">

                        <div class="row mt-2">
                            <!-- <div class="col-md-12 col-12 text-md-right pb-20">
                                <button type="button" class="btn btn-primary" id="add-partner">
                                    <i class="fa fa-plus"></i> Add Partner
                                </button>

                            </div> -->

                            <div class="col-md-12 col-12  pb-20">
                                <h5 class="card-title_apply">Partners Details (if any)</h5>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered head_label_partner">
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
                                                contractor
                                                certificate </th>

                                            <th colspan="2" style="width: 100px;">
                                                <button type="button" class="btn btn-primary" id="add-partner">
                                                    <i class="fa fa-plus"></i> Add
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($proprietors as $p)
                                        @if($p->ownership_type === 'pt')
                                        <tr data-id="{{ $p->id }}">
                                            <td>{{ $p->proprietor_name }}</td>
                                            <td>{{ $p->fathers_name }}</td>
                                            <td>{{ $p->age }}</td>
                                            <td>{{ $p->proprietor_address }}</td>
                                            <td>{{ $p->qualification }}</td>
                                            <td>{{ $p->present_business }}</td>
                                            <td data-competency="{{ $p->competency_certificate_holding }}" data-certno="{{ $p->competency_certificate_number }}" data-validity="{{ $p->competency_certificate_validity }}">
                                                @if($p->competency_certificate_holding == 'yes')
                                                Yes - CC_No: {{ $p->competency_certificate_number }},
                                                Validity: {{ \Carbon\Carbon::parse($p->competency_certificate_validity)->format('d-m-Y') }}
                                                @else
                                                No
                                                @endif
                                            </td>
                                            <td data-employed="{{ $p->presently_employed }}" data-employer="{{ $p->presently_employed_name }}" data-empaddress="{{ $p->presently_employed_address }}">
                                                {{ $p->presently_employed == 'yes' ? "Yes - {$p->presently_employed_name}, {$p->presently_employed_address}" : "No" }}
                                            </td>
                                            <td data-experience="{{ $p->previous_experience }}" data-expname="{{ $p->previous_experience_name }}" data-expaddress="{{ $p->previous_experience_address }}" data-explicense="{{ $p->previous_experience_lnumber }}" data-expvalidity="{{ $p->previous_experience_lnumber_validity }}">
                                                {{
                                                $p->previous_experience == 'yes' 
                                                    ? "Yes - {$p->previous_experience_name}, {$p->previous_experience_address}, Lic No: {$p->previous_experience_lnumber}, Validity: " . \Carbon\Carbon::parse($p->previous_experience_lnumber_validity)->format('d-m-Y') 
                                                    : "No" 
                                            }}
                                            </td>
                                            <td style="display: none;">
                                                <input type="hidden" name="ownership_type[]" value="{{ $p->ownership_type }}">
                                            </td>


                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm update-partner-row" data-id="{{ $p->id }}">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-partner-row" data-id="{{ $p->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>


                                        @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="col-12 col-md-5  text-md-right">
                                <h5>Number of Partners? (Min 2, Max 6)</h5>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="number" class="form-control" id="partner-count-input" min="2" max="6" />
                                <span class="error text-danger" id="partner-count-error"></span>
                            </div> -->


                        </div>

                        <div class="border box-shadow-blue card p-3 mt-2" id="partnersfill-section" style="display:none;">

                            <h5>Partner Details</h5>
                            <div class="p-3">
                                <div class="row mt-1 ">


                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(i) Full name and house address of partners <span style="color: red;">*</span><br><span class="text-label" style="color: #023466;">(If it is partnership concern, partnership deed should be enclosed)</span></label>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <input type="hidden" class="form-control mb-2 ownership_type" maxlength="20" id="ownership_type" name="ownership_type[]" value="pt">
                                                <!-- <textarea rows="3" class="form-control" name="proprietor_name"></textarea> -->
                                                <label>Partner's Name <span class="text-red">*</span></label>
                                                <input type="text" class="form-control mb-2 proprietor_name" maxlength="50" id="proprietor_name" name="proprietor_name[]" placeholder="Partner's Name">

                                                <span class="error text-danger" id="proprietor_name_error"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label>Partner's Address <span class="text-red">*</span></label>
                                                <textarea rows="3" class="form-control" name="proprietor_address[]" placeholder="Partner's Address"></textarea>
                                                <span class="error text-danger" id="proprietor_address_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(ii) Partner's Age and qualification along with
                                                    evidence <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label>Partner's Age <span class="text-red">*</span></label>
                                                <input type="number" class="form-control" min="12" max="80" id="age" name="age[]" placeholder="Partner's Age" value="">
                                                <span class="error text-danger" id="age_error"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label>Partner's Qualification <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" id="qualification" name="qualification[]" placeholder="Partner's Qualification" value="">
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
                                                <label for="Name">(iii) Partner's Father/Husband's name <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <input type="text" class="form-control" id="fathers_name" maxlength="50" name="fathers_name[]" value="" placeholder="Partner's Father/Husband's name">
                                                <span class="error text-danger" id="fathers_name_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(iv) Partner's Present business of the applicant <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <input type="text" class="form-control" id="present_business" name="present_business[]" value="" maxlength="50" placeholder="Partner's Present business of the applicant">
                                                <span class="error text-danger" id="present_business_error"></span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- ---------------------- -->
                                <div class="row mt-2">
                                    <!-- <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="competency_certificate_holding">(v) Whether holding a competency certificate and if so, the number and validity of the competency certificate</label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="competency_yes" name="competency_certificate_holding[0]" value="yes" onclick="toggleCompetencyFields_partners(true)">
                                                    <label class="form-check-label" for="competency_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="competency_no" name="competency_certificate_holding[0]" value="no" onclick="toggleCompetencyFields_partners(false)">
                                                    <label class="form-check-label" for="competency_no">No</label>
                                                </div>
                                              
                                                <span class="text-danger competency_certificate_holding_error ms-3"></span>
                                            </div>


                                            <div class="col-12 col-md-5 mt-1  competency-fields_partners" style="display: none;">
                                                <label>Competency Certificate No <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control mt-1 competency_number" name="competency_certificate_number[]" maxlength="15" placeholder="Certificate Number">
                                                <span class="error text-danger competency_number_error"></span>
                                            </div>
                                            <div class="col-12 col-md-5 mt-1 competency-fields_partners" style="display: none;">
                                                <label> Validity Date (DD/MM/YYYY) <span style="color: red;">*</span></label>
                                                <input type="text" 
                                                    onfocus="(this.type='date')"
                                                    class="form-control competency_validity"
                                                    name="competency_certificate_validity[]"
                                                    placeholder="License Number Validity">

                                                <span class="error text-danger competency_validity_error"></span>



                                            </div>

                                            <div class="col-12 col-md-2 mt-3  competency-fields_partners" style="display: none;">
                                                <button type="button" class="btn btn-primary" onclick="verifyCompetencyCertificate(event, this)">Verify</button>
                                               

                                                <input type="hidden" name="proprietor_cc_verify[]" class="proprietor_cc_verify" value="0">


                                            </div>

                                            <div class="col-12 mt-1">
                                                <div class="text-danger competency_verify_result"></div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label>(v) Whether holding a competency certificate and if so, the number and validity</label>
                                            </div>

                                            <div class="col-12 col-md-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        id="competency_yes_partner"
                                                        name="competency_certificate_holding[0]"
                                                        value="yes"
                                                        onclick="toggleCompetencyFields('partner', true)">
                                                    <label class="form-check-label" for="competency_yes_partner">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        id="competency_no_partner"
                                                        name="competency_certificate_holding[0]"
                                                        value="no"
                                                        onclick="toggleCompetencyFields('partner', false)"
                                                        checked>
                                                    <label class="form-check-label" for="competency_no_partner">No</label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-5 mt-1 competency-fields-partner" style="display: none;">
                                                <label>Competency Certificate No <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control mt-1 competency_number" name="competency_certificate_number[]" maxlength="15" placeholder="Competency Certificate Number">
                                                <span class="error text-danger competency_number_error"></span>
                                            </div>

                                            <div class="col-12 col-md-5 mt-1 competency-fields-partner" style="display: none;">
                                                <label> Validity Date (DD/MM/YYYY) <span style="color: red;">*</span></label>
                                                <input type="date"
                                                    onfocus="(this.type='date')"
                                                    class="form-control competency_validity"
                                                    name="competency_certificate_validity[]"
                                                    placeholder="License Number Validity">

                                                <span class="error text-danger competency_validity_error"></span>
                                            </div>

                                            <div class="col-12 col-md-2 mt-3 competency-fields-partner" style="display: none;">
                                                <button type="button" class="btn btn-primary" onclick="verifyCompetencyCertificate(event, this)">Verify</button>


                                                <input type="hidden" name="proprietor_cc_verify[]" class="proprietor_cc_verify" value="0">
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
                                                    <input class="form-check-input" type="radio" id="employed_yes" name="presently_employed[0]" value="yes" onclick="toggleEmploymentFields('partner', true)">
                                                    <label class="form-check-label" for="employed_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="employed_no" name="presently_employed[0]" value="no" onclick="toggleEmploymentFields('partner', false)">
                                                    <label class="form-check-label" for="employed_no">No</label>
                                                </div>
                                                <span class="error text-danger presently_employed_error" id="presently_employed_error"></span>
                                            </div>

                                            <div class="col-12 col-md-6 mt-1 employment-fields-partner" style="display: none;">
                                                <label>Name of the Employer <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" id="presently_employed_name" name="presently_employed_name[]" maxlength="50" placeholder="Name of the Employer">
                                                <span class="error text-danger presently_employed_name_error"></span>
                                            </div>
                                            <div class="col-12 col-md-6 mt-1  employment-fields-partner" style="display: none;">
                                                <label>Address of the Employer <span class="text-red">*</span></label>
                                                <textarea class="form-control" id="presently_employed_address" name="presently_employed_address[]" placeholder="Address of the Employer"></textarea>

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
                                                    <input class="form-check-input" type="radio" id="previous_experience" name="previous_experience[0]" value="yes" onclick="toggleExperienceFields('partner', true)">
                                                    <label class="form-check-label" for="previous_experience">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="previous_experience" name="previous_experience[0]" value="no" onclick="toggleExperienceFields('partner', false)">
                                                    <label class="form-check-label" for="previous_experience">No</label>
                                                </div>


                                                <span class="error text-danger previous_experience_error" id="previous_experience_error"></span>
                                            </div>


                                            <div class="col-12 col-md-12  experience-fields-partner" style="display: none;">
                                                <div class="row">
                                                    <div class="col-12 col-md-5 mt-1">
                                                        <label>Name of the Contractor <span class="text-red">*</span></label>
                                                        <input class="form-control" type="text" id="previous_experience_name" name="previous_experience_name[]" placeholder="Name of the Contractor">

                                                        <span class="error text-danger previous_experience_name_error"></span>
                                                    </div>
                                                    <div class="col-12 col-md-5 mt-1">
                                                        <label>Address of the Contractor <span class="text-red">*</span></label>
                                                        <textarea class="form-control" id="previous_experience_address" name="previous_experience_address[]" placeholder="Address of the Contractor"></textarea>

                                                        <span class="error text-danger previous_experience_address_error"></span>
                                                    </div>

                                                    <div class="col-12 col-md-5 mt-1">
                                                        <label>Previous EA Licence A Grade License Number <span class="text-red">*</span></label>
                                                        <input class="form-control ea_license_number" type="text" id="previous_experience_lnumber" maxlength="15" name="previous_experience_lnumber[]" placeholder="Previous EA Licence A Grade License Number">

                                                        <span class="error text-danger previous_experience_lnumber_error"></span>
                                                    </div>

                                                    <div class="col-12 col-md-5 mt-1">
                                                        <label>Previous EA Licence A Grade Validity Date (DD/MM/YYYY) <span class="text-red">*</span></label>
                                                        <input class="form-control ea_validity" type="date"
                                                            onfocus="(this.type='date')"
                                                            id="previous_experience_lnumber_validity" name="previous_experience_lnumber_validity[]" placeholder="License Number Validity">

                                                        <span class="error text-danger previous_experience_lnumber_validity_error"></span>
                                                    </div>

                                                    <div class="col-12 col-md-2 mt-5">
                                                        <button type="button" class="btn btn-primary" onclick="verifyeaCertificate(event, this)">Verify</button>
                                                        <!-- <input type="text" name="proprietor_contractor_verify[]" class="contactor_license_verify" value="0"> -->
                                                        <input type="hidden" name="proprietor_contractor_verify[]" class="proprietor_contractor_verify" value="0">

                                                    </div>



                                                    <div class="col-12 mt-1">
                                                        <div class="text-danger competency_verifyea_result"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-12 col-md-12 text-md-right">
                                                <button type="button" class="btn btn-success" id="save_partner">Save</button>

                                                <button type="button" id="cancel_update" class="btn btn-danger ms-2">Cancel</button>

                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div id="partner-container"></div>
                    </div>

                    <!-- Directorsstyle="display:none;" -->
                    <div id="director-section" class="mt-3">
                        <div class="row mt-2">
                            <!-- <div class="col-md-12 col-12 text-md-right pb-20">
                                <button type="button" class="btn btn-primary" id="add-partner">
                                    <i class="fa fa-plus"></i> Add Partner
                                </button>

                            </div> -->

                            <div class="col-md-12 col-12  pb-20">
                                <h5 class="card-title_apply">Directors Details (if any)</h5>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered head_label_director">
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
                                                contractor
                                                certificate </th>

                                            <th colspan="2" style="width: 100px;">
                                                <button type="button" class="btn btn-primary" id="add-director">
                                                    <i class="fa fa-plus"></i> Add
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($proprietors as $p)
                                        @if($p->ownership_type === 'dr')
                                        <tr data-id="{{ $p->id }}">
                                            <td>{{ $p->proprietor_name }}</td>
                                            <td>{{ $p->fathers_name }}</td>
                                            <td>{{ $p->age }}</td>
                                            <td>{{ $p->proprietor_address }}</td>
                                            <td>{{ $p->qualification }}</td>
                                            <td>{{ $p->present_business }}</td>
                                            <td data-competency="{{ $p->competency_certificate_holding }}" data-certno="{{ $p->competency_certificate_number }}" data-validity="{{ $p->competency_certificate_validity }}">
                                                @if($p->competency_certificate_holding == 'yes')
                                                Yes - CC_No: {{ $p->competency_certificate_number }},
                                                Validity: {{ \Carbon\Carbon::parse($p->competency_certificate_validity)->format('d-m-Y') }}
                                                @else
                                                No
                                                @endif
                                            </td>
                                            <td data-employed="{{ $p->presently_employed }}" data-employer="{{ $p->presently_employed_name }}" data-empaddress="{{ $p->presently_employed_address }}">
                                                {{ $p->presently_employed == 'yes' ? "Yes - {$p->presently_employed_name}, {$p->presently_employed_address}" : "No" }}
                                            </td>
                                            <td data-experience="{{ $p->previous_experience }}" data-expname="{{ $p->previous_experience_name }}" data-expaddress="{{ $p->previous_experience_address }}" data-explicense="{{ $p->previous_experience_lnumber }}" data-expvalidity="{{ $p->previous_experience_lnumber_validity }}">
                                                {{
                                                $p->previous_experience == 'yes' 
                                                    ? "Yes - {$p->previous_experience_name}, {$p->previous_experience_address}, Lic No: {$p->previous_experience_lnumber}, Validity: " . \Carbon\Carbon::parse($p->previous_experience_lnumber_validity)->format('d-m-Y') 
                                                    : "No" 
                                            }}
                                            </td>
                                            <td style="display: none;">
                                                <input type="hidden" name="ownership_type[]" value="{{ $p->ownership_type }}">
                                            </td>


                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm update-director-row" data-id="{{ $p->id }}">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-director-row" data-id="{{ $p->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="col-12 col-md-5  text-md-right">
                                <h5>Number of Partners? (Min 2, Max 6)</h5>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="number" class="form-control" id="partner-count-input" min="2" max="6" />
                                <span class="error text-danger" id="partner-count-error"></span>
                            </div> -->


                        </div>
                        <div class="border box-shadow-blue card p-3 mt-2" id="directorfill-section" style="display:none;">
                            <h5>Director Details</h5>
                            <div class=" p-3 ">
                                <div class="row  ">


                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(i) Full name and house address of Directors <span style="color: red;">*</span><br><span class="text-label" style="color: #023466;">(If it is partnership concern, partnership deed should be enclosed)</span></label>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <!-- <textarea rows="3" class="form-control" name="proprietor_name"></textarea> -->
                                                <input type="hidden" class="form-control mb-2 ownership_type" maxlength="20" id="ownership_type" name="ownership_type[]" value="dr">
                                                <label>Director's Name <span class="text-red">*</span></label>
                                                <input type="text" class="form-control mb-2 proprietor_name" maxlength="50" id="proprietor_name" name="proprietor_name[]" placeholder="Director's Name">

                                                <span class="error text-danger" id="proprietor_name_error"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label>Director's Address <span class="text-red">*</span></label>
                                                <textarea rows="3" class="form-control" name="proprietor_address[]" placeholder="Director's Address"></textarea>
                                                <span class="error text-danger" id="proprietor_address_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(ii) Director's Age and qualification along with
                                                    evidence <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label>Director's Age <span class="text-red">*</span></label>
                                                <input type="number" class="form-control" id="age" name="age[]" maxlength="2" min="15" max="70" placeholder="Director's Age" value="">
                                                <span class="error text-danger" id="age_error"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label> Director's Qualification <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" id="qualification" name="qualification[]" placeholder="Director's Qualification" value="">
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
                                                <label for="Name">(iii) Director's Father/Husband's name <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <input type="text" class="form-control" id="fathers_name" maxlength="50" name="fathers_name[]" value="" placeholder="Director's Father/Husband's name">
                                                <span class="error text-danger" id="fathers_name_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(iv) Director's Present business of the applicant <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <input type="text" class="form-control" id="present_business" name="present_business[]" value="" maxlength="50" placeholder="Director's Present business of the applicant">
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
                                                <label>(v) Whether holding a competency certificate and if so, the number and validity</label>
                                            </div>

                                            <div class="col-12 col-md-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        id="competency_yes_director"
                                                        name="competency_certificate_holding[0]"
                                                        value="yes"
                                                        onclick="toggleCompetencyFields('director', true)">
                                                    <label class="form-check-label" for="competency_yes_director">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        id="competency_no_director"
                                                        name="competency_certificate_holding[0]"
                                                        value="no"
                                                        onclick="toggleCompetencyFields('director', false)"
                                                        checked>
                                                    <label class="form-check-label" for="competency_no_director">No</label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-5 mt-1 competency-fields-director" style="display: none;">
                                                <label>Competency Certificate No <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control mt-1 competency_number" name="competency_certificate_number[]" maxlength="15" placeholder="Competency Certificate Number">
                                                <span class="error text-danger competency_number_error"></span>
                                            </div>

                                            <div class="col-12 col-md-5 mt-1 competency-fields-director" style="display: none;">
                                                <label> Validity Date (DD/MM/YYYY) <span style="color: red;">*</span></label>
                                                <input type="date"
                                                    onfocus="(this.type='date')"
                                                    class="form-control competency_validity"
                                                    name="competency_certificate_validity[]"
                                                    placeholder="License Number Validity">

                                                <span class="error text-danger competency_validity_error"></span>
                                            </div>

                                            <div class="col-12 col-md-2 mt-3 competency-fields-director" style="display: none;">
                                                <button type="button" class="btn btn-primary" onclick="verifyCompetencyCertificate(event, this)">Verify</button>


                                                <input type="hidden" name="proprietor_cc_verify[]" class="proprietor_cc_verify" value="0">
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
                                                    <input class="form-check-input" type="radio" id="employed_yes" name="presently_employed[0]" value="yes" onclick="toggleEmploymentFields('director', true)">
                                                    <label class="form-check-label" for="employed_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="employed_no" name="presently_employed[0]" value="no" onclick="toggleEmploymentFields('director', false)">
                                                    <label class="form-check-label" for="employed_no">No</label>
                                                </div>
                                                <span class="error text-danger presently_employed_error" id="presently_employed_error"></span>
                                            </div>

                                            <div class="col-12 col-md-6 mt-1 employment-fields-director" style="display: none;">
                                                <label>Name of the Employer <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" id="presently_employed_name" name="presently_employed_name[]" maxlength="50" placeholder="Name of the Employer">
                                                <span class="error text-danger presently_employed_name_error"></span>
                                            </div>
                                            <div class="col-12 col-md-6 mt-1  employment-fields-director" style="display: none;">
                                                <label>Address of the Employer <span class="text-red">*</span></label>
                                                <textarea class="form-control" id="presently_employed_address" name="presently_employed_address[]" placeholder="Address of the Employer"></textarea>

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
                                                    <input class="form-check-input" type="radio" id="previous_experience" name="previous_experience[0]" value="yes" onclick="toggleExperienceFields('director', true)">
                                                    <label class="form-check-label" for="previous_experience">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="previous_experience" name="previous_experience[0]" value="no" onclick="toggleExperienceFields('director', false)">
                                                    <label class="form-check-label" for="previous_experience">No</label>
                                                </div>


                                                <span class="error text-danger previous_experience_error" id="previous_experience_error"></span>
                                            </div>


                                            <div class="col-12 col-md-12  experience-fields-director" style="display: none;">
                                                <div class="row">
                                                    <div class="col-12 col-md-5 mt-1">
                                                        <label>Name of the Contractor <span class="text-red">*</span></label>
                                                        <input class="form-control" type="text" id="previous_experience_name" name="previous_experience_name[]" placeholder="Name of the Contractor">

                                                        <span class="error text-danger previous_experience_name_error"></span>
                                                    </div>
                                                    <div class="col-12 col-md-5 mt-1">
                                                        <label>Address of the Contractor <span class="text-red">*</span></label>
                                                        <textarea class="form-control" id="previous_experience_address" name="previous_experience_address[]" placeholder="Address of the Contractor"></textarea>

                                                        <span class="error text-danger previous_experience_address_error"></span>
                                                    </div>

                                                    <div class="col-12 col-md-5 mt-1">
                                                        <label>Previous EA Licence A Grade License Number <span class="text-red">*</span></label>
                                                        <input class="form-control ea_license_number" type="text" id="previous_experience_lnumber" maxlength="15" name="previous_experience_lnumber[]" placeholder="Previous EA Licence A Grade License Number">

                                                        <span class="error text-danger previous_experience_lnumber_error"></span>
                                                    </div>

                                                    <div class="col-12 col-md-5 mt-1">
                                                        <label>Previous EA Licence A Grade Validity Date (DD/MM/YYYY) <span class="text-red">*</span></label>
                                                        <input class="form-control ea_validity" type="date"
                                                            onfocus="(this.type='date')"
                                                            id="previous_experience_lnumber_validity" name="previous_experience_lnumber_validity[]" placeholder="License Number Validity">

                                                        <span class="error text-danger previous_experience_lnumber_validity_error"></span>
                                                    </div>

                                                    <div class="col-12 col-md-2 mt-5">
                                                        <button type="button" class="btn btn-primary" onclick="verifyeaCertificate(event, this)">Verify</button>
                                                        <!-- <input type="text" name="proprietor_contractor_verify[]" class="contactor_license_verify" value="0"> -->
                                                        <input type="hidden" name="proprietor_contractor_verify[]" class="proprietor_contractor_verify" value="0">

                                                    </div>



                                                    <div class="col-12 mt-1">
                                                        <div class="text-danger competency_verifyea_result"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-12 col-md-12 text-md-right">
                                                <button type="button" class="btn btn-success" id="save_director">Save</button>

                                                <button type="button" id="cancel_director" class="btn btn-danger ms-2">Cancel</button>

                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div id="director-container"></div>
                    </div>

                    <!-- <div class="row ">
                        <div class="col-12 col-md-12 text-center">
                        <p class="text-red">Choose Anyone Ownership and Enter the Details of Proprietor / Partners / Directors Details</p>
                        </div>
                     

                    </div> -->

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
                                                placeholder="Name of authorised signatory"
                                                value="{{ old('authorised_name', $application->authorised_name ?? '') }}">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label>Designation of authorised signatory <span class="text-red">*</span></label>
                                            <input class="form-control" type="text" maxlength="50" id="authorised_designation" name="authorised_designation"
                                                placeholder="Designation of authorised signatory"
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
                                            <td>{{ $i + 1 }}</td>
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
                                                @if ($i === 0)
                                                <span class="text-danger small">At present, we evaluate only C Certificate only </span><br>
                                                @endif

                                                <div class="text-white competency_verify_result mt-1"></div>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control cc_validity" name="cc_validity[]" placeholder="Validity"
                                                    onfocus="this.type='date'" value="{{ old('cc_validity.' . $i) }}">
                                                <span class="error text-danger">{{ $errors->first('cc_validity.' . $i) }}</span>

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary" onclick="validatestaffcertificate(event, this)">Verify</button>
                                                <input type="hidden" name="staff_cc_verify[]" class="staff_cc_verify" value="">


                                                @if ($i === $staff_count - 1)
                                                <!-- Show Add button only in 4th row -->
                                                <button type="button" class="btn btn-success" onclick="addStaffRow()">+ Add</button>
                                                @endif
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
                                            <td>{{ $i + 1 }}</td>

                                            <td>
                                                <input type="text" name="staff_name[]" maxlength="30" class="form-control"
                                                    value="{{ old('staff_name.' . $i, $staff->staff_name ?? '') }}"
                                                    placeholder="Name of the Person"
                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                                <span class="error text-danger">{{ $errors->first('staff_name.' . $i) }}</span>
                                            </td>

                                            <td>
                                                <select class="form-control" name="staff_qualification[]">
                                                    <option disabled {{ old('staff_qualification.' . $i, $staff->staff_qualification ?? '') == '' ? 'selected' : '' }}>Qualification </option>
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
                                                @if ($i === 0)
                                                <span class="text-danger small">At present, we evaluate only C Certificate only </span><br>
                                                @endif
                                                <div class="competency_verify_result text-danger small mt-1"></div>
                                                @if(isset($staff) && $staff->staff_cc_verify === '1')
                                                <span class="license-status text-success small">
                                                    <i class="fa fa-check"></i> License Verified
                                                </span>
                                                @elseif(isset($staff) && $staff->staff_cc_verify === '0')
                                                <span class="license-status text-danger small"> Invalid License</span>
                                                @endif
                                            </td>

                                            <td>
                                                <input type="date"
                                                    class="form-control cc_validity"
                                                    name="cc_validity[]"

                                                    value="{{ old('cc_validity.' . $i, isset($staff->cc_validity) ? \Carbon\Carbon::parse($staff->cc_validity)->format('Y-m-d') : '') }}"
                                                    @if(isset($staff) && $staff->staff_cc_verify === '1') readonly @endif>
                                                <span class="error text-danger">{{ $errors->first('cc_validity.' . $i) }}</span>
                                            </td>

                                            <td>
                                                <input type="hidden" name="staff_cc_verify[]" class="staff_cc_verify"
                                                    @if(isset($staff) && $staff->staff_cc_verify !== null)
                                                value="{{ $staff->staff_cc_verify }}"
                                                @endif>

                                                @if(isset($staff) && $staff->staff_cc_verify === '1')
                                                <button type="button" class="btn btn-danger clearBtn">Clear</button>
                                                @else
                                                <button type="button" class="btn btn-primary verifyBtn" onclick="validatestaffcertificate(event, this)">Verify</button>
                                                @endif

                                                @if ($i === $staff_count - 1)
                                                <!-- Show Add button only in 4th row -->
                                                <button type="button" class="btn btn-success" onclick="addStaffRow()">+ Add</button>
                                                @endif
                                            </td>


                                            <input type="hidden" name="staff_id[]" value="{{ $staff->id ?? '' }}">



                                            </tr>
                                            @endfor

                                    </tbody>



                                    @endif

                                </table>
                                <p class="text-red">Note : Minimum 4 Staff Details are Mandatory and one QC Detail is Mandatory</p>
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
                                            <textarea class="form-control" name="bank_address" placeholder="Name of the Bank and Address">{{ $banksolvency->bank_address ?? '' }}</textarea>
                                            <span class="error text-danger" id="bank_address_error"></span>
                                        </div>

                                    </div>


                                </div>
                                <div class="col-md-4">



                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <label for="comments">(ii). Validity Period <span style="color: red;">*</span></label>
                                        </div>

                                        <div class="col-12 col-md-12">
                                            <input type="date"
                                                class="form-control"
                                                name="bank_validity"
                                                placeholder="Validity"
                                                value="{{ isset($banksolvency) && $banksolvency->bank_validity ? \Carbon\Carbon::parse($banksolvency->bank_validity)->format('Y-m-d') : '' }}">


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
                                            <input type="number" class="form-control" id="bank_amount" max="99999"
                                                oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5);" name="bank_amount" value="{{ $banksolvency->bank_amount ?? '' }}" placeholder="Amount Rs">
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
                                            <label> [ 8 to 11 ] Attachments Points</label>

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
                                    <div class="row border-right-12">
                                        <div class="col-12">
                                            <label for="Name">
                                                (ii) The name of the person/persons whom the applicant has authorised to sign if any, on his/their behalf in case of Proprietor or Partnership concern
                                            </label>
                                        </div>

                                        <div class="col-12">
                                            <table class="table table-bordered" id="authority-names-table">
                                                <thead>
                                                    <tr>
                                                        <th>Name of Signatory</th>
                                                        <th>Age of Signatory</th>
                                                        <th>Qualification of Signatory</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!$application)
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="name_of_authorised_to_sign[]"
                                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                                        </td>
                                                        <td>
                                                            <input type="number" min="15" max="70" class="form-control" name="age_of_authorised_to_sign[]">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="qualification_of_authorised_to_sign[]"
                                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" id="add-more-authority-name">
                                                                <i class="fa fa-plus"></i> Add More
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @else
                                                    @php
                                                    $authorisedNames = !empty($application->name_of_authorised_to_sign)
                                                    ? json_decode($application->name_of_authorised_to_sign, true)
                                                    : [];

                                                    $age_of_authorised_to_sign = !empty($application->age_of_authorised_to_sign)
                                                    ? json_decode($application->age_of_authorised_to_sign, true)
                                                    : [];

                                                    $qualification_of_authorised_to_sign = !empty($application->qualification_of_authorised_to_sign)
                                                    ? json_decode($application->qualification_of_authorised_to_sign, true)
                                                    : [];
                                                    @endphp

                                                    @if(count($authorisedNames) > 0)
                                                    @foreach($authorisedNames as $index => $name)
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="name_of_authorised_to_sign[]"
                                                                value="{{ isset($authorisedNames[$index]) && trim($authorisedNames[$index]) !== 'null' ? trim($authorisedNames[$index]) : '' }}"
                                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                                        </td>
                                                        <td>
                                                            <input type="number" min="15" max="70" class="form-control"
                                                                name="age_of_authorised_to_sign[]"
                                                                value="{{ isset($age_of_authorised_to_sign[$index]) ? $age_of_authorised_to_sign[$index] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="qualification_of_authorised_to_sign[]"
                                                                value="{{ isset($qualification_of_authorised_to_sign[$index]) && trim($qualification_of_authorised_to_sign[$index]) !== 'null' ? trim($qualification_of_authorised_to_sign[$index]) : '' }}"
                                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                                        </td>
                                                        <td>
                                                            @if($index == 0)
                                                            <button type="button" class="btn btn-primary" id="add-more-authority-name">
                                                                <i class="fa fa-plus"></i> Add More
                                                            </button>
                                                            @else
                                                            <button type="button" class="btn btn-danger remove-authority-name">
                                                                <i class="fa fa-minus"></i> Remove
                                                            </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="name_of_authorised_to_sign[]" placeholder="Name of Authority"
                                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                                        </td>
                                                        <td>
                                                            <input type="number" min="12" max="80" class="form-control" name="age_of_authorised_to_sign[]" placeholder="Age of Authority">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="qualification_of_authorised_to_sign[]" placeholder="Qualification of Authority"
                                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" id="add-more-authority-name">
                                                                <i class="fa fa-plus"></i> Add More
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endif
                                                </tbody>
                                            </table>
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



                        </div>
                    </div>


                </div>

                <div class="tab " data-name="Equipment / Instruments List">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row align-items-center head_label">
                                <div class="col-12 col-md-12 title_bar">
                                    <label> Equipment / Instruments : The applicant should possess the following instruments: <span style="color: red;">*</span></label>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row mt-2">

                        <div class="col-md-12">

                            @php
                            /*
                            If $equipmentlist is NOT passed (fresh form),
                            treat it as empty collection
                            */
                            $equipmentlist = $equipmentlist ?? collect();

                            /*
                            Create map:
                            equip_id => equipment_value
                            */
                            $storedEquipment = collect($equipmentlist)
                            ->pluck('equipment_value', 'equip_id')
                            ->toArray();
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">S.No</th>
                                            <th>Equipment Name</th>
                                            <th>Equipment Type</th>
                                            <th>Availability</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($equiplist as $index => $equip)

                                        @php
                                        /*
                                        If data exists → use DB value
                                        Else → default NO
                                        */
                                        $savedValue = $storedEquipment[$equip->id] ?? 'no';
                                        @endphp

                                        <!-- Hidden inputs -->
                                        <input type="hidden"
                                            name="equipments[{{ $index }}][equip_id]"
                                            value="{{ $equip->id }}">

                                        <input type="hidden"
                                            name="equipments[{{ $index }}][licence_id]"
                                            value="{{ $equip->equip_licence_name }}">

                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <td>{{ $equip->equip_name }}</td>

                                            <td>{{ $equip->equipment_type }}</td>

                                            <td>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="equipments[{{ $index }}][value]"
                                                        value="yes"
                                                        {{ $savedValue === 'yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Yes</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="equipments[{{ $index }}][value]"
                                                        value="no"
                                                        {{ $savedValue === 'no' ? 'checked' : '' }}>
                                                    <label class="form-check-label">No</label>
                                                </div>
                                            </td>
                                        </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>


                            <p class="text-danger mt-2">
                                <strong>Note:</strong>
                                These instruments should be tested in Government Electrical Standards Laboratory
                                attached to the office of the Chief Electrical Inspector to Government, Chennai-32
                                or in the MRT Laboratory of TNEB within 3 months prior to the date of application.
                            </p>

                        </div>





                    </div>





                    <!-- -------------Equip end----------- -->


                </div>


                <div class="tab" data-name="Enclosures & Declarations">




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
        const hasApplication = {
            {
                isset($application) ? 'true' : 'false'
            }
        };
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
        function toggleCompetencyFields(type, show) {
            let fieldsClass = '';
            if (type === 'proprietor') {
                fieldsClass = '.competency-fields-proprietor';
            } else if (type === 'partner') {
                fieldsClass = '.competency-fields-partner';
            } else {
                fieldsClass = '.competency-fields-director';
            }

            const fields = document.querySelectorAll(fieldsClass);
            fields.forEach(field => {
                field.style.display = show ? '' : 'none';

                const numberInput = field.querySelector('.competency_number');
                const validityInput = field.querySelector('.competency_validity');
                const verifyInput = field.querySelector('.proprietor_cc_verify, .partner_cc_verify');
                const resultDiv = field.querySelector('.competency_verify_result');

                if (show) {
                    if (numberInput) numberInput.value = '';
                    if (validityInput) validityInput.value = '';
                    if (verifyInput) verifyInput.value = '';
                    if (resultDiv) resultDiv.textContent = '';
                }
            });
        }


        function toggleEmploymentFields(type, show) {
            let fieldsClass = '';

            if (type === 'proprietor') {
                fieldsClass = '.employment-fields-proprietor';
            } else if (type === 'partner') {
                fieldsClass = '.employment-fields-partner';
            } else {
                fieldsClass = '.employment-fields-director';
            }

            const fields = document.querySelectorAll(fieldsClass);
            fields.forEach(field => {
                field.style.display = show ? '' : 'none';

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


        function toggleExperienceFields(type, show) {

            let fieldsClass = '';

            if (type === 'proprietor') {
                fieldsClass = '.experience-fields-proprietor';
            } else if (type === 'partner') {
                fieldsClass = '.experience-fields-partner';
            } else {
                fieldsClass = '.experience-fields-director';
            }

            const fields = document.querySelectorAll(fieldsClass);
            // const fields = document.querySelectorAll('.experience-fields');

            fields.forEach(field => {
                field.style.display = show ? '' : 'none';

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

        function togglePreviousLicenseFields(show) {
            const section = document.querySelector(".previous-license-fields");

            if (!section) return;

            section.style.display = show ? "block" : "none";

            if (!show) {
                // Clear all input values and remove readonly
                const inputs = section.querySelectorAll('input');
                inputs.forEach(input => {
                    input.value = '';
                    input.removeAttribute('readonly');
                });

                // Reset verification result display
                const verifyResult = document.getElementById("verifyea_result");
                if (verifyResult) verifyResult.innerHTML = '';

                // Reset hidden verification input to 0
                const verifyInput = section.querySelector('input.previous_contractor_license_verify');
                if (verifyInput) verifyInput.value = '0';

                // Replace Clear button with Verify button
                const wrapper = document.getElementById("licenseVerificationBtnWrapper");
                if (wrapper) {
                    wrapper.innerHTML = `
                            <button type="button" class="btn btn-primary" id="verifyLicenseBtn" onclick="verifyeaCertificateprevoius(event, this)">Verify</button>
                              <input 
                                                type="hidden" 
                                                name="previous_contractor_license_verify" 
                                                class="previous_contractor_license_verify"
                                                value="{{ $application?->previous_contractor_license_verify ?? '' }}">
                        `;
                }
            }
        }


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


        // document.addEventListener("DOMContentLoaded", function() {
        //     let ageInput = document.getElementById("age");

        //     ageInput.addEventListener("input", function() {
        //         let value = parseInt(this.value, 10);
        //         if (value >= 50) {
        //             this.value = 49; // Set max limit to 49
        //         } else if (value < 0 || isNaN(value)) {
        //             this.value = ""; // Prevent negative numbers or invalid input
        //         }
        //     });
        // });



        const tableBody = document.querySelector('#authority-names-table tbody');
        const maxRows = 3;

        document.addEventListener('click', function(e) {
            // -------------------
            // Remove row first
            // -------------------
            if (e.target && e.target.closest('.remove-authority-name')) {
                const row = e.target.closest('tr');
                row.remove();
                return; // Important! Stop execution so it doesn't run the add logic
            }

            // -------------------
            // Add new row
            // -------------------
            if (e.target && e.target.id === 'add-more-authority-name') {
                const rows = tableBody.querySelectorAll('tr');
                const lastRow = rows[rows.length - 1];
                let allFilled = true;

                // Check if all inputs in last row are filled
                lastRow.querySelectorAll('input').forEach(input => {
                    if (!input.value.trim()) allFilled = false;
                });

                if (!allFilled) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Incomplete Row',
                        width: 450,
                        text: 'Please fill all fields in the last row before adding a new one.',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                if (rows.length >= maxRows) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limit Reached',
                        width: 450,
                        text: `You can add a maximum of ${maxRows} authority names.`,
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                // Clone the first row as a template
                const newRow = rows[0].cloneNode(true);
                newRow.querySelectorAll('input').forEach(input => input.value = '');
                const btn = newRow.querySelector('button');
                btn.className = 'btn btn-danger remove-authority-name';
                btn.innerHTML = '<i class="fa fa-minus"></i> Remove';
                tableBody.appendChild(newRow);
            }
        });


        // ----license check---------------
        function clearPreviousLicense() {
            // alert('111');
            const numberInput = document.getElementById('previous_application_number');
            const validityInput = document.getElementById('previous_application_validity');
            const hiddenInput = document.querySelector('.previous_contractor_license_verify');
            const statusDiv = document.querySelector('.license-status');
            const resultDiv = document.getElementById('verifyea_result');

            // Make inputs editable & clear values
            if (numberInput) {
                numberInput.removeAttribute('readonly');
                numberInput.value = '';
            }
            if (validityInput) {
                validityInput.removeAttribute('readonly');
                validityInput.value = '';
            }

            // Reset hidden verification field
            if (hiddenInput) {
                hiddenInput.value = '0';
            }

            // Clear the license status (Valid / Invalid)
            if (statusDiv) {
                statusDiv.innerHTML = '';
            }

            // Clear AJAX verification result
            if (resultDiv) {
                resultDiv.textContent = '';
            }

            // Replace Clear with Verify button
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
            const hiddenVerifyInput = container.querySelector('.proprietor_cc_verify');

            // Enable inputs and clear values
            if (numberInput) {
                numberInput.readOnly = false;
                numberInput.value = ''; // Clear value
            }
            if (validityInput) {
                validityInput.readOnly = false;
                validityInput.value = ''; // Clear value
            }

            // Remove "Clear" button
            button.remove();

            // Create and insert "Verify" button
            const verifyBtn = document.createElement('button');
            verifyBtn.type = 'button';
            verifyBtn.className = 'btn btn-primary mt-3 verify-btn';
            verifyBtn.innerText = 'Verify';
            verifyBtn.setAttribute('onclick', 'verifyCompetencyCertificate(event, this)');

            const buttonCol = container.querySelector('.col-md-2');
            if (buttonCol) {
                buttonCol.appendChild(verifyBtn);
            }

            // Reset hidden input (backend flag)
            if (hiddenVerifyInput) {
                hiddenVerifyInput.value = '';
            }

            // Clear result message
            const resultDiv = container.querySelector('.competency_verify_result');
            if (resultDiv) {
                resultDiv.textContent = '';
            }

            // Clear "Valid/Invalid License" status
            const statusDiv = container.querySelector('.license-status');
            if (statusDiv) {
                statusDiv.innerHTML = ''; // remove both valid & invalid messages
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

            // Make inputs editable & clear values
            if (licenseInput) {
                licenseInput.readOnly = false;
                licenseInput.value = ''; // clear value
            }
            if (validityInput) {
                validityInput.readOnly = false;
                validityInput.value = ''; // clear value
            }

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

            // Clear "Valid/Invalid License" status
            const statusDiv = container.querySelector('.license-status');
            if (statusDiv) {
                statusDiv.innerHTML = ''; // remove status
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
            const removeBtn = document.getElementById('remove-aadhaar-doc');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    // Remove the existing row (preview + hidden input)
                    const existingRow = document.getElementById('aadhaar-existing-row');
                    if (existingRow) existingRow.remove();

                    // Show the file input row
                    const fileRow = document.getElementById('aadhaar-file-row');
                    if (fileRow) fileRow.style.display = 'flex';
                });
            }

            const panRemoveBtn = document.getElementById('remove-pan-doc');
            if (panRemoveBtn) {
                panRemoveBtn.addEventListener('click', function() {
                    const existingRow = document.getElementById('pan-existing-row');
                    if (existingRow) existingRow.remove();

                    const fileRow = document.getElementById('pan-file-row');
                    if (fileRow) fileRow.style.display = 'flex';
                });
            }

            const gstRemoveBtn = document.getElementById('remove-gst-doc');
            if (gstRemoveBtn) {
                gstRemoveBtn.addEventListener('click', function() {
                    const existingRow = document.getElementById('gst-existing-row');
                    if (existingRow) existingRow.remove();

                    const fileRow = document.getElementById('gst-file-row');
                    if (fileRow) fileRow.style.display = 'flex';
                });
            }

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


        // ----------------------------ownership change------------------------

        $('#type_of_ea_license').on('change', function() {
            var selected = $(this).val();

            // Hide all first
            $('#proprietor-sectionfresh, #partner-section, #directorfill-section').hide();

            if (selected == "1") {
                $('#proprietor-sectionfresh').show();
            } else if (selected == "2") {
                $('#partner-section').show();
            } else if (selected == "3") {
                $('#directorfill-section').show();
            }
        });







        // -----------------add staff row---------------------

        function addStaffRow() {
            let rowCount = $('#staff-container tr').length;

            // ✅ Check if first 4 staff rows are filled before adding a new one
            let allFilled = true;
            $('#staff-container tr').slice(0, 4).each(function(index, tr) {
                let name = $(tr).find('input[name="staff_name[]"]').val().trim();
                let qualification = $(tr).find('select[name="staff_qualification[]"]').val();
                let category = $(tr).find('select[name="staff_category[]"]').val() || $(tr).find('input[name="staff_category[]"]').val();
                let ccNumber = $(tr).find('input[name="cc_number[]"]').val().trim();
                let ccValidity = $(tr).find('input[name="cc_validity[]"]').val().trim();

                // If any required field is missing, block adding
                if (!name || !qualification || !category || !ccNumber || !ccValidity) {
                    allFilled = false;
                    return false; // stop the loop
                }
            });

            if (!allFilled) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fill Required Fields',
                    text: 'Please fill all details for the first 4 staff members before adding a new one.',
                    confirmButtonText: 'OK',
                    width: 500
                });
                return;
            }



            let lastRow = $('#staff-container tr').last();

            // ✅ Step 3: Get field values from the last row
            let name = lastRow.find('input[name="staff_name[]"]').val()?.trim();
            let qualification = lastRow.find('select[name="staff_qualification[]"]').val();
            let category = lastRow.find('select[name="staff_category[]"]').val();
            let ccNumber = lastRow.find('input[name="cc_number[]"]').val()?.trim();
            let ccValidity = lastRow.find('input[name="cc_validity[]"]').val()?.trim();

            // ✅ Step 4: Check if any required field is empty
            if (!name || !qualification || !category || !ccNumber || !ccValidity) {
                Swal.fire({
                    icon: 'warning',
                    width: 450,
                    title: 'Incomplete Row',
                    text: 'Please fill all fields in the last staff row before adding a new one.',
                    confirmButtonText: 'OK'
                });
                return;
            }


            // ✅ Limit check
            if (rowCount >= 8) {
                Swal.fire({
                    icon: 'error',
                    width: 450,
                    title: 'Limit Reached',
                    text: 'You can add a maximum of 8 staff members.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // ✅ Append new row
            let newRow = `
        <tr class="staff-fields">
            <td>${rowCount + 1}</td>
            <td>
                <input type="text" name="staff_name[]" maxlength="30" 
                    class="form-control"
                    placeholder="Name of the Person"
                    oninput="this.value = this.value.replace(/[^a-zA-Z\\s]/g, '')">
                <span class="error text-danger"></span>
            </td>
            <td>
                <select class="form-control" name="staff_qualification[]">
                    <option disabled selected>Qualification</option>
                    <option value="PG">PG</option>
                    <option value="UG">UG</option>
                    <option value="Diploma">Diploma</option>
                    <option value="+2">+2</option>
                    <option value="10">10</option>
                </select>
                <span class="error text-danger"></span>
            </td>
            <td>
                <select class="form-control" name="staff_category[]">
                    <option disabled selected>Select Category</option>
                    <option value="QC">QC</option>
                    <option value="BC">BC</option>
                    <option value="B">B</option>
                </select>
                <span class="error text-danger"></span>
            </td>
            <td>
                <input type="text" class="form-control cc_number" name="cc_number[]" placeholder="Certificate No" maxlength="15">
                <span class="error text-danger"></span>
                <div class="text-white competency_verify_result mt-1"></div>
            </td>
            <td>
                <input type="date" class="form-control cc_validity" name="cc_validity[]" placeholder="Validity" 
                    onfocus="this.type='date'">
                <span class="error text-danger"></span>
            </td>
           <td>
                <button type="button" class="btn btn-primary" onclick="validatestaffcertificate(event, this)">Verify</button>
                <input type="hidden" name="staff_cc_verify[]" class="staff_cc_verify" value="">
                <br><br>
                <button type="button" class="btn btn-success" onclick="addStaffRow()">+ Add Staff</button> 
                <button type="button" class="btn btn-danger" onclick="removeStaffRow(this)">- Remove</button>
            </td>
        </tr>
    `;

            $('#staff-container').append(newRow);

            // Remove Add button from all previous rows
            $('#staff-container tr').each(function(index, tr) {
                $(tr).find('.btn-success').remove();
            });

            // Add Add button only to the last row
            $('#staff-container tr:last td:last').append('<button type="button" class="btn btn-success" onclick="addStaffRow()">+ Add</button>');
        }

        // -----------------// removeStaffRow----------------------------------
        function removeStaffRow(button) {
            let row = $(button).closest('tr');
            row.remove();

            // Re-index remaining rows
            $('#staff-container tr').each(function(index, tr) {
                $(tr).find('td:first').text(index + 1);
                // Add Add button to last row if missing
                if (index === $('#staff-container tr').length - 1 && $(tr).find('.btn-success').length === 0) {
                    $(tr).find('td:last').append('<button type="button" class="btn btn-success" onclick="addStaffRow()">+ Add</button>');
                }
            });
        }

        // ------instrumrnts report 1----------------------
        $('input[name="tested_documents"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('#tested_report_row').slideDown();
            } else {
                $('#tested_report_row').slideUp();
                $('#tested_report_id').val('');
                $('#tested_report_id_error').text('');
            }
        });

        // ------instrumrnts report 2----------------------

        $('input[name="equipment1"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('#invoice_row').slideDown();
            } else {
                $('#invoice_row').slideUp();
                $('#invoice_report_id').val('');
                $('#invoice_report_id_error').text('');
            }
        });


        $('input[name="instrument3"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('#instrument3_row').slideDown();
            } else {
                $('#instrument3_row').slideUp();
                $('#instrument3_id').val('');
                $('#instrument3_id_error').text('');
            }
        });


        // ---------------add proprietor-----------------

        let proprietorIndex = 0;
        let proprietoreditIndex = null;

        // Show form on Add Proprietor button click
        $("#add-proprietor").on("click", function() {
            let rowCount = $("#proprietor-section table tbody tr").length;
            if (rowCount > 0) {
                Swal.fire({
                    title: "Proprietor Entry Exists!",
                    width: 450,
                    text: "Only one proprietor entry is allowed.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#3085d6"
                });
                return;
            }

            // Reset form before showing
            resetproprietor(false);
            $("#proprietor-sectionfresh").slideDown();
            $("#save_proprietor").text("Save");
        });

        // Save or Update Proprietor
        $("#save_proprietor").on("click", function() {


            let $section = $("#proprietor-sectionfresh");


            let ownership_type = $section.find("input[name='ownership_type[]']").val().trim();
            // Basic text inputs
            let name = $section.find("input[name='proprietor_name[]']").val().trim();
            let address = $section.find("textarea[name='proprietor_address[]']").val().trim();
            let age = $section.find("input[name='age[]']").val().trim();
            let qualification = $section.find("input[name='qualification[]']").val().trim();
            let fathersName = $section.find("input[name='fathers_name[]']").val().trim();
            let presentBusiness = $section.find("input[name='present_business[]']").val().trim();



            // ✅ Ensure a default 'no' is checked if nothing is selected
            if (!$section.find("input[name^='competency_certificate_holding']:checked").length) {
                $section.find("input[name^='competency_certificate_holding'][value='no']").prop("checked", true);
            }
            if (!$section.find("input[name^='presently_employed']:checked").length) {
                $section.find("input[name^='presently_employed'][value='no']").prop("checked", true);
            }
            if (!$section.find("input[name^='previous_experience']:checked").length) {
                $section.find("input[name^='previous_experience'][value='no']").prop("checked", true);
            }

            // ✅ Radio button values
            let competency = $section.find("input[name^='competency_certificate_holding']:checked").val() || "no";
            let ccNum = $section.find("input[name='competency_certificate_number[]']").val().trim();
            let ccValidity = $section.find("input[name='competency_certificate_validity[]']").val().trim();

            // let ccverify = $section.find("input[name='proprietor_cc_verify[]']").val().trim();
            let ccverifyInput = $section.find("input[name='proprietor_cc_verify[]']").val();
            let ccverify = (ccverifyInput === null || ccverifyInput.trim() === "") ?
                null :
                parseInt(ccverifyInput, 10);

            let competencyDetails = competency === "yes" ? `Yes - CC_No: ${ccNum}, Validity: ${ccValidity}` : "No";

            let employed = $section.find("input[name^='presently_employed']:checked").val() || "no";
            let empName = $section.find("input[name='presently_employed_name[]']").val().trim();
            let empAddress = $section.find("textarea[name='presently_employed_address[]']").val().trim();
            let employedDetails = employed === "yes" ? `Yes - ${empName}, ${empAddress}` : "No";

            let experience = $section.find("input[name^='previous_experience']:checked").val() || "no";
            let expName = $section.find("input[name='previous_experience_name[]']").val().trim();
            let expAddress = $section.find("textarea[name='previous_experience_address[]']").val().trim();
            let expLicense = $section.find("input[name='previous_experience_lnumber[]']").val().trim();
            let expValidity = $section.find("input[name='previous_experience_lnumber_validity[]']").val().trim();

            // let expverify = $section.find("input[name='proprietor_contractor_verify[]']").val().trim();
            let expverifyInput = $section.find("input[name='proprietor_contractor_verify[]']").val();
            let expverify = (expverifyInput === null || expverifyInput.trim() === "") ?
                null :
                parseInt(expverifyInput, 10);

            let experienceDetails = experience === "yes" ?
                `Yes - ${expName}, ${expAddress}, Lic No: ${expLicense}, Validity: ${expValidity}` :
                "No";
            // Date format----------------
            let ccValidityFormatted = formatDateToDDMMYYYY(ccValidity);
            let expValidityFormatted = formatDateToDDMMYYYY(expValidity);
            // ✅ Validation
            if (!name || !address || !age || !qualification || !fathersName || !presentBusiness) {
                alert("Please fill all proprietor required fields!");
                return;
            }

            // ✅ Update existing row
            if (editIndex !== null) {

                // alert('not null');

                let $row = $("#proprietor-section table tbody tr").eq(editIndex);

                if (proprietoreditIndex !== null) {
                    $row.attr('data-id', proprietoreditIndex);
                    // alert(proprietoreditIndex);
                }
                $row.find("td").eq(0).text(name);
                $row.find("td").eq(1).text(fathersName);
                $row.find("td").eq(2).text(age);
                $row.find("td").eq(3).text(address);
                $row.find("td").eq(4).text(qualification);
                $row.find("td").eq(5).text(presentBusiness);
                let ccValidityYMD = formatDateToYMD(ccValidity); // for data-attributes
                let ccValidityFormatted = formatDateToDDMMYYYY(ccValidity);
                let expValidityYMD = formatDateToYMD(expValidity);
                let expValidityFormatted = formatDateToDDMMYYYY(expValidity);
                // alert(ccValidityFormatted);
                $row.find("td").eq(6)
                    .text(competencyDetails)
                    .attr({
                        'data-competency': competency,
                        'data-certno': ccNum,
                        'data-validity': ccValidity,
                        'data-validityverify': ccverify

                    });

                $row.find("td").eq(7)
                    .text(employedDetails)
                    .attr({
                        'data-employed': employed,
                        'data-employer': empName,
                        'data-empaddress': empAddress
                    });

                $row.find("td").eq(8)
                    .text(experienceDetails)
                    .attr({
                        'data-experience': experience,
                        'data-expname': expName,
                        'data-expaddress': expAddress,
                        'data-explicense': expLicense,
                        'data-expvalidity': expValidity,
                        'data-expverify': expverify
                    });

                resetproForm(true);
                editIndex = null;
            }
            // ✅ Add new row
            else {

                // alert('null');
                let rowCount = $("#proprietor-section table tbody tr").length;
                if (rowCount > 0) {
                    Swal.fire({
                        title: "Proprietor Entry Exists!",
                        width: 450,
                        text: "You can only add Only One Proprietor.",
                        icon: "warning",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#3085d6"
                    });
                    // alert("You can only add a maximum of 6 partners.");
                    return;
                }

                $("#proprietor-section table tbody").append(`
                    <tr>
                        <td>${name}</td>
                        <td>${fathersName}</td>
                        <td>${age}</td>
                        <td>${address}</td>
                        <td>${qualification}</td>
                        <td>${presentBusiness}</td>
                          <td 
                            data-competency="${competency}" 
                            data-certno="${ccNum}" 
                            data-validity="${ccValidity}"  
                            data-ccverify="${ccverify === null ? '' : ccverify}">
                            ${competency === 'yes' 
                                ? `Yes - CC_No: ${ccNum}, Validity: ${ccValidityFormatted}` 
                                : 'No'}
                            
                            </td>

                        <td data-employed="${employed}" data-employer="${empName}" data-empaddress="${empAddress}">${employed === 'yes' ? `Yes - ${empName}, ${empAddress}` : 'No'}</td>


                        <td data-experience="${experience}" data-expname="${expName}" data-expaddress="${expAddress}" data-explicense="${expLicense}" data-expvalidity="${expValidity}"  data-expverify="${expverify === null ? '' : expverify}">${experience === 'yes' ? `Yes - ${expName}, ${expAddress}, Lic No: ${expLicense}, Validity: ${expValidityFormatted}` : 'No'}</td>
                         <td style="display:none;" data-ownership="${ownership_type}">${ownership_type}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm update-proprietor-row"><i class="fa fa-pencil"></i></button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-proprietor-row"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                `);

                resetproForm(true);
                partnerIndex++;
            }


        });

        function resetproForm(hide = false) {
            let $section = $("#proprietor-sectionfresh");

            // Clear all text/number/textarea inputs
            $section.find("input[type='text'], input[type='number'], textarea").val("");

            // Clear all radio buttons
            $section.find("input[type='radio']").prop("checked", false);

            // Hide all conditional fields
            $(".competency-fields-prop, .employment-fields, .experience-fields").hide();

            // Reset Save button text
            $("#save_proprietor").text("Save");

            // Reset editIndex
            editIndex = null;

            $section.find(".text-danger").text("");

            // Hide form if needed
            if (hide) $section.slideUp();
        }


        // Edit row
        $(document).on("click", ".update-proprietor-row", function() {
            // alert('111');
            let $row = $(this).closest("tr");
            editIndex = $row.index();
            let ownershipValue = $row.find("td").eq(9).find("input[name='ownership_type[]']").val();
            // console.log("Ownership Value:", ownershipValue); 
            // alert(ownershipValue);
            // exit;


            let $section = $("#proprietor-sectionfresh");
            // let ownership_type = $section.find("input[name='ownership_type[]']").val().trim();
            // $section.find("input[name='ownership_type[]']").val($row.find("td").eq(9).text());    
            // Fill form with row data
            $section.find("input[name='proprietor_name[]']").val($row.find("td").eq(0).text());
            $section.find("input[name='fathers_name[]']").val($row.find("td").eq(1).text());
            $section.find("input[name='age[]']").val($row.find("td").eq(2).text());
            $section.find("textarea[name='proprietor_address[]']").val($row.find("td").eq(3).text());
            $section.find("input[name='qualification[]']").val($row.find("td").eq(4).text());
            $section.find("input[name='present_business[]']").val($row.find("td").eq(5).text());
            $section.find("input[name='ownership_type[]']").val(ownershipValue);


            // === Competency Section ===
            let tdCompetency = $row.find("td").eq(6);
            let competency = tdCompetency.attr('data-competency') || "no";
            let certNo = tdCompetency.attr('data-certno') || "";
            let validity = tdCompetency.attr('data-validity') || "";
            let ccValidityFormatted = formatDateToDDMMYYYY(validity);
            let formattedValidity = formatDateToYMD(validity);
            // alert(ccValidityFormatted);

            $section.find("input[name^='competency_certificate_holding'][value='" + competency + "']").prop("checked", true);
            $section.find("input[name='competency_certificate_number[]']").val(certNo);
            $section.find("input[name='competency_certificate_validity[]']").val(formattedValidity);

            // Show/hide related inputs
            if (competency === "yes") {
                $(".competency-fields-proprietor").slideDown();
            } else {
                $(".competency-fields-proprietor").slideUp();
            }

            // === Presently Employed Section ===
            let tdEmployed = $row.find("td").eq(7);
            let employed = tdEmployed.attr('data-employed') || "no";
            let empName = tdEmployed.attr('data-employer') || "";
            let empAddress = tdEmployed.attr('data-empaddress') || "";

            $section.find("input[name^='presently_employed'][value='" + employed + "']").prop("checked", true);
            $section.find("input[name='presently_employed_name[]']").val(empName);
            $section.find("textarea[name='presently_employed_address[]']").val(empAddress);

            if (employed === "yes") {
                $(".employment-fields-proprietor").slideDown();
            } else {
                $(".employment-fields-proprietor").slideUp();
            }

            // === Previous Experience Section ===
            let tdExperience = $row.find("td").eq(8);
            let experience = tdExperience.attr('data-experience') || "no";
            let expName = tdExperience.attr('data-expname') || "";
            let expAddress = tdExperience.attr('data-expaddress') || "";
            let expLicense = tdExperience.attr('data-explicense') || "";
            let expValidity = tdExperience.attr('data-expvalidity') || "";
            let expValidityFormatted = formatDateToDDMMYYYY(expValidity);
            let formattedexpValidity = formatDateToYMD(expValidity);


            $section.find("input[name^='previous_experience'][value='" + experience + "']").prop("checked", true);
            $section.find("input[name='previous_experience_name[]']").val(expName);
            $section.find("textarea[name='previous_experience_address[]']").val(expAddress);
            $section.find("input[name='previous_experience_lnumber[]']").val(expLicense);
            $section.find("input[name='previous_experience_lnumber_validity[]']").val(formattedexpValidity);

            if (experience === "yes") {
                $(".experience-fields-proprietor").slideDown();
            } else {
                $(".experience-fields-proprietor").slideUp();
            }


            // Show form
            $section.slideDown();

            // Change Save button to Update + Add Cancel button
            $("#save_proprietor").text("Update");
            if ($("#cancel_update").length === 0) {
                $("#save_proprietor").after(`
            <button type="button" id="cancel_proprietor" class="btn btn-danger ms-2">Cancel</button>
        `);
            }
        });

        // Delete row
        $(document).on("click", ".remove-proprietor-row", function() {
            $(this).closest("tr").remove();
        });


        function formatDateToYMD(dateString) {
            const parts = dateString.split("/");
            if (parts.length === 3) {
                return `${parts[2]}-${parts[1].padStart(2, "0")}-${parts[0].padStart(2, "0")}`;
            }
            return dateString;
        }

        function formatDateToDDMMYYYY(dateStr) {
            if (!dateStr) return "";
            const d = new Date(dateStr);
            const day = String(d.getDate()).padStart(2, "0");
            const month = String(d.getMonth() + 1).padStart(2, "0");
            const year = d.getFullYear();
            return `${day}-${month}-${year}`;
        }


        // Cancel update
        $(document).on("click", "#cancel_update", function() {
            resetproForm(false); // reset + hide
        });




        function resetproprietor(hide = false) {
            let $section = $("#proprietor-sectionfresh");


            $section.find("input[type='text'], input[type='number'], input[type='date'], input[type='file'], textarea").val("");



            // Hide dependent fields
            $(".competency-fields, .employment-fields, .experience-fields").hide();
            $("#save_proprietor").text("Save");
            proprietoreditIndex = null;

            if (hide) $section.slideUp();
        }



        $(document).on("click", ".remove-proprietor-row", function() {
            $(this).closest("tr").remove();

            // Reset indices after deletion
            proprietorIndex = 0; // allow adding new entry
            proprietoreditIndex = null; // clear any edit state

            // Optionally hide the form
            $("#proprietor-sectionfresh").slideUp();
        });




        // Cancel
        $(document).on("click", "#cancel_proprietor", function() {
            resetproForm(true);
        });



        // ------------add new partner--------------



        // Add partner form on button click
        // let partnerIndex = 0;
        let partnerIndex = 0;
        let editIndex = null;

        // Show partner form
        $("#add-partner").on("click", function() {
            let rowCount = $("#partner-section table tbody tr").length;
            if (rowCount >= 6) {

                Swal.fire({
                    title: "Partner Entry Exists!",
                    width: 450,
                    text: "You can only add a maximum of 6 partners..",
                    icon: "warning",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#3085d6"
                });

                // alert("You can only add a maximum of 6 partners.");
                return;
            }
            resetPartnerForm();
            $("#partnersfill-section").slideDown();
        });


        // $("#add-partner").on("click", function() {
        //     resetPartnerForm();

        //     let rowCount = $("#partner-section table tbody tr").length;
        //     if (rowCount >= 6) {
        //         alert("You can only add a maximum of 6 partners.");
        //         return; // stop here
        //     }
        //     $("#partnersfill-section").slideDown();
        //     if ($("#cancel_update").length === 0) {
        //         $("#save_partner").after(`
        //     <button type="button" id="cancel_update" class="btn btn-danger ms-2">Cancel</button>
        // `);
        //     }
        // });

        // Save or Update Partner
        $("#save_partner").on("click", function() {
            let $section = $("#partnersfill-section");

            let ownership_type = $section.find("input[name='ownership_type[]']").val().trim();
            // Basic text inputs
            let name = $section.find("input[name='proprietor_name[]']").val().trim();
            let address = $section.find("textarea[name='proprietor_address[]']").val().trim();
            let age = $section.find("input[name='age[]']").val().trim();
            let qualification = $section.find("input[name='qualification[]']").val().trim();
            let fathersName = $section.find("input[name='fathers_name[]']").val().trim();
            let presentBusiness = $section.find("input[name='present_business[]']").val().trim();



            // ✅ Ensure a default 'no' is checked if nothing is selected
            if (!$section.find("input[name^='competency_certificate_holding']:checked").length) {
                $section.find("input[name^='competency_certificate_holding'][value='no']").prop("checked", true);
            }
            if (!$section.find("input[name^='presently_employed']:checked").length) {
                $section.find("input[name^='presently_employed'][value='no']").prop("checked", true);
            }
            if (!$section.find("input[name^='previous_experience']:checked").length) {
                $section.find("input[name^='previous_experience'][value='no']").prop("checked", true);
            }

            // ✅ Radio button values
            let competency = $section.find("input[name^='competency_certificate_holding']:checked").val() || "no";
            let ccNum = $section.find("input[name='competency_certificate_number[]']").val().trim();
            let ccValidity = $section.find("input[name='competency_certificate_validity[]']").val().trim();

            // let ccverify = $section.find("input[name='proprietor_cc_verify[]']").val().trim();
            let ccverifyInput = $section.find("input[name='proprietor_cc_verify[]']").val();
            let ccverify = (ccverifyInput === null || ccverifyInput.trim() === "") ?
                null :
                parseInt(ccverifyInput, 10);

            let competencyDetails = competency === "yes" ? `Yes - CC_No: ${ccNum}, Validity: ${ccValidity}` : "No";

            let employed = $section.find("input[name^='presently_employed']:checked").val() || "no";
            let empName = $section.find("input[name='presently_employed_name[]']").val().trim();
            let empAddress = $section.find("textarea[name='presently_employed_address[]']").val().trim();
            let employedDetails = employed === "yes" ? `Yes - ${empName}, ${empAddress}` : "No";

            let experience = $section.find("input[name^='previous_experience']:checked").val() || "no";
            let expName = $section.find("input[name='previous_experience_name[]']").val().trim();
            let expAddress = $section.find("textarea[name='previous_experience_address[]']").val().trim();
            let expLicense = $section.find("input[name='previous_experience_lnumber[]']").val().trim();
            let expValidity = $section.find("input[name='previous_experience_lnumber_validity[]']").val().trim();

            // let expverify = $section.find("input[name='proprietor_contractor_verify[]']").val().trim();
            let expverifyInput = $section.find("input[name='proprietor_contractor_verify[]']").val();
            let expverify = (expverifyInput === null || expverifyInput.trim() === "") ?
                null :
                parseInt(expverifyInput, 10);

            let experienceDetails = experience === "yes" ?
                `Yes - ${expName}, ${expAddress}, Lic No: ${expLicense}, Validity: ${expValidity}` :
                "No";
            // Date format----------------
            let ccValidityFormatted = formatDateToDDMMYYYY(ccValidity);
            let expValidityFormatted = formatDateToDDMMYYYY(expValidity);
            // ✅ Validation
            if (!name || !address || !age || !qualification || !fathersName || !presentBusiness) {
                alert("Please fill all proprietor required fields!");
                return;
            }

            // ✅ Update existing row
            if (editIndex !== null) {

                // alert('not null');

                let $row = $("#partner-section table tbody tr").eq(editIndex);
                $row.find("td").eq(0).text(name);
                $row.find("td").eq(1).text(fathersName);
                $row.find("td").eq(2).text(age);
                $row.find("td").eq(3).text(address);
                $row.find("td").eq(4).text(qualification);
                $row.find("td").eq(5).text(presentBusiness);
                let ccValidityYMD = formatDateToYMD(ccValidity); // for data-attributes
                let ccValidityFormatted = formatDateToDDMMYYYY(ccValidity);
                let expValidityYMD = formatDateToYMD(expValidity);
                let expValidityFormatted = formatDateToDDMMYYYY(expValidity);
                // alert(ccValidityFormatted);
                $row.find("td").eq(6)
                    .text(competencyDetails)
                    .attr({
                        'data-competency': competency,
                        'data-certno': ccNum,
                        'data-validity': ccValidity,
                        'data-validityverify': ccverify

                    });

                $row.find("td").eq(7)
                    .text(employedDetails)
                    .attr({
                        'data-employed': employed,
                        'data-employer': empName,
                        'data-empaddress': empAddress
                    });

                $row.find("td").eq(8)
                    .text(experienceDetails)
                    .attr({
                        'data-experience': experience,
                        'data-expname': expName,
                        'data-expaddress': expAddress,
                        'data-explicense': expLicense,
                        'data-expvalidity': expValidity,
                        'data-expverify': expverify
                    });

                resetPartnerForm(true);
                editIndex = null;
            }
            // ✅ Add new row
            else {

                // alert('null');
                let rowCount = $("#partner-section table tbody tr").length;
                if (rowCount >= 6) {
                    Swal.fire({
                        title: "Partner Entry Exists!",
                        width: 450,
                        text: "You can only add a maximum of 6 partners..",
                        icon: "warning",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#3085d6"
                    });
                    alert("You can only add a maximum of 6 partners.");
                    return;
                }

                $("#partner-section table tbody").append(`
                    <tr>
                        <td>${name}</td>
                        <td>${fathersName}</td>
                        <td>${age}</td>
                        <td>${address}</td>
                        <td>${qualification}</td>
                        <td>${presentBusiness}</td>
                          <td 
                            data-competency="${competency}" 
                            data-certno="${ccNum}" 
                            data-validity="${ccValidity}"  
                            data-ccverify="${ccverify === null ? '' : ccverify}">
                            ${competency === 'yes' 
                                ? `Yes - CC_No: ${ccNum}, Validity: ${ccValidityFormatted}` 
                                : 'No'}
                            
                            </td>

                        <td data-employed="${employed}" data-employer="${empName}" data-empaddress="${empAddress}">${employed === 'yes' ? `Yes - ${empName}, ${empAddress}` : 'No'}</td>


                        <td data-experience="${experience}" data-expname="${expName}" data-expaddress="${expAddress}" data-explicense="${expLicense}" data-expvalidity="${expValidity}"  data-expverify="${expverify === null ? '' : expverify}">${experience === 'yes' ? `Yes - ${expName}, ${expAddress}, Lic No: ${expLicense}, Validity: ${expValidityFormatted}` : 'No'}</td>
                         <td style="display:none;" data-ownership="${ownership_type}">${ownership_type}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm update-partner-row"><i class="fa fa-pencil"></i></button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-partner-row"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                `);

                resetPartnerForm(true);
                partnerIndex++;
            }
        });

        // Reset form

        function resetPartnerForm(hide = false) {
            let $section = $("#partnersfill-section");

            // Clear all text/number/textarea inputs
            $section.find("input[type='text'], input[type='number'], textarea").val("");

            // Clear all radio buttons
            $section.find("input[type='radio']").prop("checked", false);

            // Hide all conditional fields
            $(".competency-fields-partner, .employment-fields-partner, .experience-fields-partner").hide();

            // Reset Save button text
            $("#save_partner").text("Save");

            // Reset editIndex
            editIndex = null;

            $section.find(".text-danger").text("");

            // Hide form if needed
            if (hide) $section.slideUp();
        }

        // function resetPartnerForm(hide = false) {
        //     let $section = $("#partnersfill-section");
        //     $section.find("input[type='text'], input[type='number'], textarea").val("");
        //     $section.find("input[type='radio']").prop("checked", false);
        //     $section.find("input[value='no']").prop("checked", true); // Default “No”
        //     if (hide) $section.slideUp();
        // }

        // Cancel update hides form
        $(document).on("click", "#cancel_update", function() {
            $("#partnersfill-section").slideUp();
        });


        // Remove partner row
        $(document).on("click", ".remove-partner-row", function() {
            $(this).closest("tr").remove();
        });

        // Update partner row
        $(document).on("click", ".update-partner-row", function() {
            let $row = $(this).closest("tr");
            editIndex = $row.index();
            let ownershipValue = $row.find("td").eq(9).find("input[name='ownership_type[]']").val();
            // console.log("Ownership Value:", ownershipValue); 
            // alert(ownershipValue);
            // exit;


            let $section = $("#partnersfill-section");
            // let ownership_type = $section.find("input[name='ownership_type[]']").val().trim();
            // $section.find("input[name='ownership_type[]']").val($row.find("td").eq(9).text());    
            // Fill form with row data
            $section.find("input[name='proprietor_name[]']").val($row.find("td").eq(0).text());
            $section.find("input[name='fathers_name[]']").val($row.find("td").eq(1).text());
            $section.find("input[name='age[]']").val($row.find("td").eq(2).text());
            $section.find("textarea[name='proprietor_address[]']").val($row.find("td").eq(3).text());
            $section.find("input[name='qualification[]']").val($row.find("td").eq(4).text());
            $section.find("input[name='present_business[]']").val($row.find("td").eq(5).text());
            $section.find("input[name='ownership_type[]']").val(ownershipValue);


            // === Competency Section ===
            let tdCompetency = $row.find("td").eq(6);
            let competency = tdCompetency.attr('data-competency') || "no";
            let certNo = tdCompetency.attr('data-certno') || "";
            let validity = tdCompetency.attr('data-validity') || "";
            let ccValidityFormatted = formatDateToDDMMYYYY(validity);
            let formattedValidity = formatDateToYMD(validity);
            // alert(ccValidityFormatted);

            $section.find("input[name^='competency_certificate_holding'][value='" + competency + "']").prop("checked", true);
            $section.find("input[name='competency_certificate_number[]']").val(certNo);
            $section.find("input[name='competency_certificate_validity[]']").val(formattedValidity);

            // Show/hide related inputs
            if (competency === "yes") {
                $(".competency-fields-partner").slideDown();
            } else {
                $(".competency-fields-partner").slideUp();
            }

            // === Presently Employed Section ===
            let tdEmployed = $row.find("td").eq(7);
            let employed = tdEmployed.attr('data-employed') || "no";
            let empName = tdEmployed.attr('data-employer') || "";
            let empAddress = tdEmployed.attr('data-empaddress') || "";

            $section.find("input[name^='presently_employed'][value='" + employed + "']").prop("checked", true);
            $section.find("input[name='presently_employed_name[]']").val(empName);
            $section.find("textarea[name='presently_employed_address[]']").val(empAddress);

            if (employed === "yes") {
                $(".employment-fields-partner").slideDown();
            } else {
                $(".employment-fields-partner").slideUp();
            }

            // === Previous Experience Section ===
            let tdExperience = $row.find("td").eq(8);
            let experience = tdExperience.attr('data-experience') || "no";
            let expName = tdExperience.attr('data-expname') || "";
            let expAddress = tdExperience.attr('data-expaddress') || "";
            let expLicense = tdExperience.attr('data-explicense') || "";
            let expValidity = tdExperience.attr('data-expvalidity') || "";
            let expValidityFormatted = formatDateToDDMMYYYY(expValidity);
            let formattedexpValidity = formatDateToYMD(expValidity);


            $section.find("input[name^='previous_experience'][value='" + experience + "']").prop("checked", true);
            $section.find("input[name='previous_experience_name[]']").val(expName);
            $section.find("textarea[name='previous_experience_address[]']").val(expAddress);
            $section.find("input[name='previous_experience_lnumber[]']").val(expLicense);
            $section.find("input[name='previous_experience_lnumber_validity[]']").val(formattedexpValidity);

            if (experience === "yes") {
                $(".experience-fields-partner").slideDown();
            } else {
                $(".experience-fields-partner").slideUp();
            }


            // Show form
            $section.slideDown();

            // Change Save button to Update + Add Cancel button
            $("#save_partner").text("Update");
            if ($("#cancel_update").length === 0) {
                $("#save_partner").after(`
            <button type="button" id="cancel_update" class="btn btn-danger ms-2">Cancel</button>
        `);
            }
        });

        function formatDateToYMD(dateString) {
            const parts = dateString.split("/");
            if (parts.length === 3) {
                return `${parts[2]}-${parts[1].padStart(2, "0")}-${parts[0].padStart(2, "0")}`;
            }
            return dateString;
        }

        function formatDateToDDMMYYYY(dateStr) {
            if (!dateStr) return "";
            const d = new Date(dateStr);
            const day = String(d.getDate()).padStart(2, "0");
            const month = String(d.getMonth() + 1).padStart(2, "0");
            const year = d.getFullYear();
            return `${day}-${month}-${year}`;
        }


        // Cancel update
        $(document).on("click", "#cancel_update", function() {
            resetPartnerForm(false); // reset + hide
        });


        // ------------------------------save director------------------

        let directorIndex = 0;
        let directoreditIndex = null;

        // Show partner form
        $("#add-director").on("click", function() {
            let rowCount = $("#director-section table tbody tr").length;
            if (rowCount >= 6) {

                Swal.fire({
                    title: "Directors Entry Exists!",
                    width: 450,
                    text: "You can only add a maximum of 6 Directors..",
                    icon: "warning",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#3085d6"
                });

                // alert("You can only add a maximum of 6 partners.");
                return;
            }
            resetDirectorForm();
            $("#directorfill-section").slideDown();
        });




        // Save or Update Partner
        $("#save_director").on("click", function() {
            let $section = $("#directorfill-section");

            let ownership_type = $section.find("input[name='ownership_type[]']").val().trim();
            // Basic text inputs
            let name = $section.find("input[name='proprietor_name[]']").val().trim();
            let address = $section.find("textarea[name='proprietor_address[]']").val().trim();
            let age = $section.find("input[name='age[]']").val().trim();
            let qualification = $section.find("input[name='qualification[]']").val().trim();
            let fathersName = $section.find("input[name='fathers_name[]']").val().trim();
            let presentBusiness = $section.find("input[name='present_business[]']").val().trim();



            // ✅ Ensure a default 'no' is checked if nothing is selected
            if (!$section.find("input[name^='competency_certificate_holding']:checked").length) {
                $section.find("input[name^='competency_certificate_holding'][value='no']").prop("checked", true);
            }
            if (!$section.find("input[name^='presently_employed']:checked").length) {
                $section.find("input[name^='presently_employed'][value='no']").prop("checked", true);
            }
            if (!$section.find("input[name^='previous_experience']:checked").length) {
                $section.find("input[name^='previous_experience'][value='no']").prop("checked", true);
            }

            // ✅ Radio button values
            let competency = $section.find("input[name^='competency_certificate_holding']:checked").val() || "no";
            let ccNum = $section.find("input[name='competency_certificate_number[]']").val().trim();
            let ccValidity = $section.find("input[name='competency_certificate_validity[]']").val().trim();

            // let ccverify = $section.find("input[name='proprietor_cc_verify[]']").val().trim();
            let ccverifyInput = $section.find("input[name='proprietor_cc_verify[]']").val();
            let ccverify = (ccverifyInput === null || ccverifyInput.trim() === "") ?
                null :
                parseInt(ccverifyInput, 10);

            let competencyDetails = competency === "yes" ? `Yes - CC_No: ${ccNum}, Validity: ${ccValidity}` : "No";

            let employed = $section.find("input[name^='presently_employed']:checked").val() || "no";
            let empName = $section.find("input[name='presently_employed_name[]']").val().trim();
            let empAddress = $section.find("textarea[name='presently_employed_address[]']").val().trim();
            let employedDetails = employed === "yes" ? `Yes - ${empName}, ${empAddress}` : "No";

            let experience = $section.find("input[name^='previous_experience']:checked").val() || "no";
            let expName = $section.find("input[name='previous_experience_name[]']").val().trim();
            let expAddress = $section.find("textarea[name='previous_experience_address[]']").val().trim();
            let expLicense = $section.find("input[name='previous_experience_lnumber[]']").val().trim();
            let expValidity = $section.find("input[name='previous_experience_lnumber_validity[]']").val().trim();

            // let expverify = $section.find("input[name='proprietor_contractor_verify[]']").val().trim();
            let expverifyInput = $section.find("input[name='proprietor_contractor_verify[]']").val();
            let expverify = (expverifyInput === null || expverifyInput.trim() === "") ?
                null :
                parseInt(expverifyInput, 10);

            let experienceDetails = experience === "yes" ?
                `Yes - ${expName}, ${expAddress}, Lic No: ${expLicense}, Validity: ${expValidity}` :
                "No";
            // Date format----------------
            let ccValidityFormatted = formatDateToDDMMYYYY(ccValidity);
            let expValidityFormatted = formatDateToDDMMYYYY(expValidity);
            // ✅ Validation
            if (!name || !address || !age || !qualification || !fathersName || !presentBusiness) {
                alert("Please fill all director required fields!");
                return;
            }

            // ✅ Update existing row
            if (directoreditIndex !== null) {

                // alert('not null');

                let $row = $("#director-section table tbody tr").eq(directoreditIndex);
                $row.find("td").eq(0).text(name);
                $row.find("td").eq(1).text(fathersName);
                $row.find("td").eq(2).text(age);
                $row.find("td").eq(3).text(address);
                $row.find("td").eq(4).text(qualification);
                $row.find("td").eq(5).text(presentBusiness);
                let ccValidityYMD = formatDateToYMD(ccValidity); // for data-attributes
                let ccValidityFormatted = formatDateToDDMMYYYY(ccValidity);
                let expValidityYMD = formatDateToYMD(expValidity);
                let expValidityFormatted = formatDateToDDMMYYYY(expValidity);
                // alert(ccValidityFormatted);
                $row.find("td").eq(6)
                    .text(competencyDetails)
                    .attr({
                        'data-competency': competency,
                        'data-certno': ccNum,
                        'data-validity': ccValidity,
                        'data-validityverify': ccverify

                    });

                $row.find("td").eq(7)
                    .text(employedDetails)
                    .attr({
                        'data-employed': employed,
                        'data-employer': empName,
                        'data-empaddress': empAddress
                    });

                $row.find("td").eq(8)
                    .text(experienceDetails)
                    .attr({
                        'data-experience': experience,
                        'data-expname': expName,
                        'data-expaddress': expAddress,
                        'data-explicense': expLicense,
                        'data-expvalidity': expValidity,
                        'data-expverify': expverify
                    });

                resetDirectorForm(true);
                directoreditIndex = null;
            }
            // ✅ Add new row
            else {

                // alert('null');
                let rowCount = $("#director-section table tbody tr").length;
                if (rowCount >= 6) {
                    Swal.fire({
                        title: "Partner Entry Exists!",
                        width: 450,
                        text: "You can only add a maximum of 6 partners..",
                        icon: "warning",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#3085d6"
                    });
                    alert("You can only add a maximum of 6 partners.");
                    return;
                }

                $("#director-section table tbody").append(`
                    <tr>
                        <td>${name}</td>
                        <td>${fathersName}</td>
                        <td>${age}</td>
                        <td>${address}</td>
                        <td>${qualification}</td>
                        <td>${presentBusiness}</td>
                          <td 
                            data-competency="${competency}" 
                            data-certno="${ccNum}" 
                            data-validity="${ccValidity}"  
                            data-ccverify="${ccverify === null ? '' : ccverify}">
                            ${competency === 'yes' 
                                ? `Yes - CC_No: ${ccNum}, Validity: ${ccValidityFormatted}` 
                                : 'No'}
                            
                            </td>

                        <td data-employed="${employed}" data-employer="${empName}" data-empaddress="${empAddress}">${employed === 'yes' ? `Yes - ${empName}, ${empAddress}` : 'No'}</td>


                        <td data-experience="${experience}" data-expname="${expName}" data-expaddress="${expAddress}" data-explicense="${expLicense}" data-expvalidity="${expValidity}"  data-expverify="${expverify === null ? '' : expverify}">${experience === 'yes' ? `Yes - ${expName}, ${expAddress}, Lic No: ${expLicense}, Validity: ${expValidityFormatted}` : 'No'}</td>
                         <td style="display:none;" data-ownership="${ownership_type}">${ownership_type}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm update-director-row"><i class="fa fa-pencil"></i></button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-director-row"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                `);

                resetDirectorForm(true);
                directorIndex++;
            }
        });

        // Reset form

        function resetDirectorForm(hide = false) {
            let $section = $("#directorfill-section");

            // Clear all text/number/textarea inputs
            $section.find("input[type='text'], input[type='number'], textarea").val("");

            // Clear all radio buttons
            $section.find("input[type='radio']").prop("checked", false);

            // Hide all conditional fields
            $(".competency-fields-director, .employment-fields-director, .experience-fields-director").hide();

            // Reset Save button text
            $("#save_director").text("Save");

            // Reset directoreditIndex
            directoreditIndex = null;

            $section.find(".text-danger").text("");

            // Hide form if needed
            if (hide) $section.slideUp();
        }

        // function resetDirectorForm(hide = false) {
        //     let $section = $("#directorfill-section");
        //     $section.find("input[type='text'], input[type='number'], textarea").val("");
        //     $section.find("input[type='radio']").prop("checked", false);
        //     $section.find("input[value='no']").prop("checked", true); // Default “No”
        //     if (hide) $section.slideUp();
        // }

        // Cancel update hides form
        $(document).on("click", "#cancel_director", function() {
            $("#directorfill-section").slideUp();
        });


        // Remove partner row
        $(document).on("click", ".remove-director-row", function() {
            $(this).closest("tr").remove();
        });

        // Update partner row
        $(document).on("click", ".update-director-row", function() {
            let $row = $(this).closest("tr");
            directoreditIndex = $row.index();
            let ownershipValue = $row.find("td").eq(9).find("input[name='ownership_type[]']").val();
            // console.log("Ownership Value:", ownershipValue); 
            // alert(ownershipValue);
            // exit;


            let $section = $("#directorfill-section");
            // let ownership_type = $section.find("input[name='ownership_type[]']").val().trim();
            // $section.find("input[name='ownership_type[]']").val($row.find("td").eq(9).text());    
            // Fill form with row data
            $section.find("input[name='proprietor_name[]']").val($row.find("td").eq(0).text());
            $section.find("input[name='fathers_name[]']").val($row.find("td").eq(1).text());
            $section.find("input[name='age[]']").val($row.find("td").eq(2).text());
            $section.find("textarea[name='proprietor_address[]']").val($row.find("td").eq(3).text());
            $section.find("input[name='qualification[]']").val($row.find("td").eq(4).text());
            $section.find("input[name='present_business[]']").val($row.find("td").eq(5).text());
            $section.find("input[name='ownership_type[]']").val(ownershipValue);


            // === Competency Section ===
            let tdCompetency = $row.find("td").eq(6);
            let competency = tdCompetency.attr('data-competency') || "no";
            let certNo = tdCompetency.attr('data-certno') || "";
            let validity = tdCompetency.attr('data-validity') || "";
            let ccValidityFormatted = formatDateToDDMMYYYY(validity);
            let formattedValidity = formatDateToYMD(validity);
            // alert(ccValidityFormatted);

            $section.find("input[name^='competency_certificate_holding'][value='" + competency + "']").prop("checked", true);
            $section.find("input[name='competency_certificate_number[]']").val(certNo);
            $section.find("input[name='competency_certificate_validity[]']").val(formattedValidity);

            // Show/hide related inputs
            if (competency === "yes") {
                $(".competency-fields-director").slideDown();
            } else {
                $(".competency-fields-director").slideUp();
            }

            // === Presently Employed Section ===
            let tdEmployed = $row.find("td").eq(7);
            let employed = tdEmployed.attr('data-employed') || "no";
            let empName = tdEmployed.attr('data-employer') || "";
            let empAddress = tdEmployed.attr('data-empaddress') || "";

            $section.find("input[name^='presently_employed'][value='" + employed + "']").prop("checked", true);
            $section.find("input[name='presently_employed_name[]']").val(empName);
            $section.find("textarea[name='presently_employed_address[]']").val(empAddress);

            if (employed === "yes") {
                $(".employment-fields-director").slideDown();
            } else {
                $(".employment-fields-director").slideUp();
            }

            // === Previous Experience Section ===
            let tdExperience = $row.find("td").eq(8);
            let experience = tdExperience.attr('data-experience') || "no";
            let expName = tdExperience.attr('data-expname') || "";
            let expAddress = tdExperience.attr('data-expaddress') || "";
            let expLicense = tdExperience.attr('data-explicense') || "";
            let expValidity = tdExperience.attr('data-expvalidity') || "";
            let expValidityFormatted = formatDateToDDMMYYYY(expValidity);
            let formattedexpValidity = formatDateToYMD(expValidity);


            $section.find("input[name^='previous_experience'][value='" + experience + "']").prop("checked", true);
            $section.find("input[name='previous_experience_name[]']").val(expName);
            $section.find("textarea[name='previous_experience_address[]']").val(expAddress);
            $section.find("input[name='previous_experience_lnumber[]']").val(expLicense);
            $section.find("input[name='previous_experience_lnumber_validity[]']").val(formattedexpValidity);

            if (experience === "yes") {
                $(".experience-fields-director").slideDown();
            } else {
                $(".experience-fields-director").slideUp();
            }


            // Show form
            $section.slideDown();

            // Change Save button to Update + Add Cancel button
            $("#save_director").text("Update");
            if ($("#cancel_director").length === 0) {
                $("#save_director").after(`
            <button type="button" id="cancel_director" class="btn btn-danger ms-2">Cancel</button>
        `);
            }
        });

        function formatDateToYMD(dateString) {
            const parts = dateString.split("/");
            if (parts.length === 3) {
                return `${parts[2]}-${parts[1].padStart(2, "0")}-${parts[0].padStart(2, "0")}`;
            }
            return dateString;
        }

        function formatDateToDDMMYYYY(dateStr) {
            if (!dateStr) return "";
            const d = new Date(dateStr);
            const day = String(d.getDate()).padStart(2, "0");
            const month = String(d.getMonth() + 1).padStart(2, "0");
            const year = d.getFullYear();
            return `${day}-${month}-${year}`;
        }


        // Cancel update
        $(document).on("click", "#cancel_director", function() {
            resetDirectorForm(false); // reset + hide
        });





        // --------------age restriction partner--------------------
        // document.querySelectorAll('input[name="age[]"]').forEach(input => {
        //     input.addEventListener('input', function() {
        //         let val = parseInt(this.value);
        //         const errorSpan = this.nextElementSibling;

        //         if (val > 80) {
        //             // errorSpan.textContent = "Age cannot be more than 70";
        //             this.value = '80'; // clear the input or set to max
        //         } else if (val < 12 && val !== 0 && this.value !== '') {
        //             // errorSpan.textContent = "Age cannot be less than 15";
        //         } else {
        //             errorSpan.textContent = "";
        //         }
        //     });
        // });

        // ------------------signatory solvency ------------------------------
        document.querySelectorAll('input[name="age_of_authorised_to_sign[]"]').forEach(input => {
            input.addEventListener('input', function() {
                let val = parseInt(this.value);
                const errorSpan = this.nextElementSibling;

                if (val > 80) {
                    // errorSpan.textContent = "Age cannot be more than 70";
                    this.value = ''; // clear the input or set to max
                } else if (val < 12 && val !== 0 && this.value !== '') {
                    // errorSpan.textContent = "Age cannot be less than 15";
                } else {
                    errorSpan.textContent = "";
                }
            });
        });

        // ------------------------------------------------equipment 14------------------
        function toggleTestedReport() {
            if ($("input[name='tested_documents']:checked").val() === "yes") {
                $("#tested_report_row").show();
            } else {
                $("#tested_report_row").hide();
                // Optional: clear fields when "No" selected
                $("#tested_report_id").val("");
                $("#validity_date_eq1").val("");
            }
        }

        // Run on page load (for pre-filled "yes")
        toggleTestedReport();

        // Run when user changes radio
        $("input[name='tested_documents']").change(function() {
            toggleTestedReport();
        });

        $("input[name='equipment1']").on("change", function() {
            if ($(this).val() === "yes") {
                $("#invoice_row").slideDown();
            } else {
                $("#invoice_row").slideUp();
            }
        });

        // Toggle for Instrument 3 section
        $("input[name='instrument3']").on("change", function() {
            if ($(this).val() === "yes") {
                $("#instrument3_row").slideDown();
            } else {
                $("#instrument3_row").slideUp();
            }
        });
    </script>
    <!-- 
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get references to the checkboxes and form
            var checkbox1 = document.getElementById("declarationCheckbox");
            var checkbox2 = document.getElementById("declarationCheckbox1");
            var errorMsg1 = checkbox1.parentElement.querySelector("#checkboxError");
            var errorMsg2 = checkbox2.parentElement.querySelector("#checkboxError");
            var form = document.getElementById("competency_form_a");
            var nextButton = document.querySelector(".pag-item-next");
            var submitButton = document.querySelector(".pag-item.btn-success");

            // Function to validate checkboxes
            function validateCheckboxes() {
                var valid = true;

                // Check if checkbox1 is checked
                if (!checkbox1.checked) {
                    errorMsg1.style.display = "block";
                    valid = false;
                } else {
                    errorMsg1.style.display = "none";
                }

                // Check if checkbox2 is checked
                if (!checkbox2.checked) {
                    errorMsg2.style.display = "block";
                    valid = false;
                } else {
                    errorMsg2.style.display = "none";
                }

                return valid;
            }

            // Validate on "Next" button click if we're on the last tab
            nextButton.addEventListener("click", function(event) {
                // Only validate if we're on the last tab with the declarations
                if (document.querySelector(".tab[data-name='Staff Details']").classList.contains("selected")) {
                    if (!validateCheckboxes()) {
                        event.preventDefault();
                    }
                }
            });

            // Validate on "Submit" button click
            submitButton.addEventListener("click", function(event) {
                if (!validateCheckboxes()) {
                    event.preventDefault();
                }
            });

            // Validate on form submission
            form.addEventListener("submit", function(event) {
                if (!validateCheckboxes()) {
                    event.preventDefault();
                }
            });
        });
    </script> -->