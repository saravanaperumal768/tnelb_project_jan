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

    #success {
        background: green;
    }

    #error {
        background: red;
    }

    #warning {
        background: coral;
    }

    #info {
        background: cornflowerblue;
    }

    #question {
        background: grey;
    }

    /* .swal2-popup.swal2-modal.swal2-show {
        width: 100%;
    } */

    .swal2-popup li {
        font-size: 15px;
        margin-bottom: 8px;
    }


    .swal2-popup li {
        font-size: 15px;
        margin-bottom: 8px;
    }

    .swal2-popup li ul{
        margin-left: 15px;
    }
    .form-header-logo {
        margin-right: 10px
    }
    .form-title{
        color: #227e37;
        font-weight: 700;
    }
</style>

<section class="">
    <div class="container">
        <ul id="breadcrumb">
            <li><a href="{{ route('dashboard')}}"><span class="fa fa-home"> </span> Dashboard</a></li>
            <li><a href="#"><span class=" fa fa-info-circle"> </span> Form P</a></li>

        </ul>
    </div>
</section>
<section class="apply-form">
    <div class="auto-container">
        <div class="wrapper-box">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="apply-card apply-card-info comp_certificate" data-select2-id="14">
                       <div class="apply-card-header" style="background-color: rgb(3 90 179); padding: 15px;">
                            <div class="row">

                                <div class="col-lg-12 col-12">

                                    <div class="text-center text-white text-uppercase font-weight-bold">
                                        {{-- <h5 class="card-title_apply text-black mb-1">GOVERNMENT OF TAMILNADU</h5>
                                        <h5 class="card-title_apply text-black mb-1">THE ELECTRICAL LICENSING BOARD</h5> --}}
                                        <h5 class="card-title_apply text-white text-uppercase font-weight-bold" >
                                            Application for Power Generating Station Operation & Maintenance Competency Certificate
                                        </h5>
                                     
                                        <h6 class="card-title_apply text-white mt-2 form-title">FORM - P / Certificate P</h4>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-4 col-12 text-md-right">
                                    <a href="{{url('assets/pdf/form_s_notes.pdf')}}" class="text-white" target="_blank"><span class="text-white" target="_blank"><i class="fa fa-file-pdf-o" style="color: red;"></i>  Instructions Download (8 KB)<br>
                                       </span> English</a>
                                </div> -->
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-12 text-right">
                                    <span class="text-white font-weight-bold" target="_blank"> Instructions 
                                       </span> <a href="{{url('assets/pdf/form_p_notes.pdf')}}" class="text-white" target="_blank">English <i class="fa fa-file-pdf-o" ></i>  (8 KB)</a>
                                </div>

                            </div>

                            

                        </div>

                         <div class="row">
                                <div class="col-lg-12 col-12 text-right text-head pl-5 mt-1" >
                                  <p class="pr-3 f-s-14"> <span class="text-red font-weight-bold">*</span> Fields are Mandatory </p>
                                </div>

                            </div>
                        
                        <div class="apply-card-body">
                            <form id="competency_form_p" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 ">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-5">
                                                            <label for="Name">1. Name of the applicant <span style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">விண்ணப்பதாரர் பெயர்</label>
                                                        </div>
                                                        <div class="col-12 col-md-7">
                                                            @php
                                                                // var_dump($user['salutation']);die;
                                                            @endphp
                                                            <input autocomplete="off" class="form-control text-box single-line" id="Applicant_Name" name="applicant_name" type="text" value="{{ $user['salutation'].' '.$user['applicant_name'] }}" readonly>
                                                        </div>
                                
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-4">
                                                            <label for="Name">2. Father's Name <span style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">தகப்பனார் பெயர்</label>
                                                        </div>

                                                        <div class="col-12 col-md-8 ">
                                                            <input autocomplete="off" class="form-control text-box single-line" id="Fathers_Name" name="fathers_name"
                                                                type="text" value="{{ isset($application) ? $application->fathers_name : '' }}" maxlength="50">
                                                                {{-- <div id="Fathers_Name_count" class="text-muted mt-1" style="font-size: 0.9rem;color:red!important;">0/50</div> --}}

                                                            <span class="error-message text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 ">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-5 ">
                                                            <label for="Name">3. Address of the applicant<span style="color: red;">*</span><br><span class="text-label">(To be clear)</span>
                                                            </label>
                                                            <br>
                                                            <label for="tamil" class="tamil">விண்ணப்பதாரர் முகவரி
                                                                <span class="text-label">(தெளிவாக இருக்க வேண்டும்)</span></label>
                                                        </div>
                                                        <div class="col-12 col-md-7">
                                                            <!-- <input autocomplete="off" class="form-control text-box single-line" id="Applicant_Name" name="Applicant_Name" type="text" value=""> -->
                                                            <textarea rows="3" class="form-control " id="applicants_address" name="applicants_address" maxlength="250">{{Auth::user()->address}}</textarea>
                                                            <span id="applicants_address_error" class="text-danger error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 ">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-7">
                                                            <div class="row align-items-center">
                                                                <div class="col-12 col-md-7">
                                                                    <label for="Name">4. (i) Date of Birth <span style="color: red;">*</span></label><br>
                                                                    <label for="tamil" class="tamil">பிறந்த நாள், மாதம், வருடம்</label>
                                                                </div>
                                                                <div class="col-12 col-md-5">
                                                                    <input autocomplete="off" class="form-control text-box single-line" id="d_o_b" name="d_o_b" type="text" placeholder="DD/MM/YYYY" value="{{ isset($application) ? $application->d_o_b : '' }}" >
                                                                    <!-- <span id="dobError" class="text-danger d-block mt-1" style="display: none;">Age must be 50 years or below.</span> -->
                                                                    <span id="dob-error" class="text-danger"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-5">
                                                            <div class="row align-items-center">
                                                                <div class="col-12 col-md-5">
                                                                    <label for="Name">(ii) Age <span style="color: red;">*</span></label><br>
                                                                    <label for="tamil" class="tamil"> வயது</label>
                                                                </div>
                                                                <div class="col-12 col-md-7">
                                                                    <input autocomplete="off" class="form-control text-box single-line" id="age" name="age" type="number" value="{{ isset($application) ? $application->age : '' }}" placeholder="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row align-items-center head_label">
                                                <div class="col-12 col-md-12 ">
                                                    <label> 5. (i).Details of Technical Qualification passed by the applicant <span style="color: red;">*</span> <span class="text-label"> (Upload the documents) </span></label>
                                                    <br>
                                                    <label for="tamil" class="tamil">விண்ணப்பதாரரின் தொழில்நுட்ப 
                                                        தேர்ச்சி மற்றும் தேர்ச்சி பற்றிய விவரங்கள் <span class="text-label">(ஆவணங்களை பதிவேற்ற வேண்டும்)</span></label>
                                                </div>

                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="education-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Education Level</th>
                                                            <th>Institution/School Name</th>
                                                            <th>Year of Passing</th>
                                                            <th>Percentage / Grade</th>
                                                            <th class="text-center">Upload Document (Consolidated MarkSheet)
                                                                <br><span class="file-limit"> File type: PDF,PNG (Max 200 KB)</span>
                                                            </th>
                                                            <th>
                                                                <button type="button" class="btn btn-primary add-more">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="education-container">
                                                        <tr class="education-fields">
                                                            <td> <select class="form-control" name="educational_level[]">
                                                                    <option selected disabled>Select Education</option>
                                                                    <option value="BEM">B.E(Mechanical)</option>
                                                                    <option value="BEE">B.E(Electrical)</option>
                                                                    <option value="DiplomaM">Diploma(Mechanical)</option>
                                                                    <option value="DiplomaE">Diploma(Electrical)</option>
                                                                </select></td>
                                                            <td><input type="text" class="form-control" name="institute_name[]"></td>
                                                            <td>
                                                                <select name="year_of_passing[]" class="form-control">
                                                                    <option value="0">Select Year</option>
                                                                    @php
                                                                        $currentYear = date('Y');
                                                                    @endphp
                                                                    @for ($year = $currentYear; $year >= 1980; $year--)
                                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                            <td>
                                                            <input type="number" step="0.1" class="form-control percentage-input" name="percentage[]" min="1" max="99" required>
                                                            <span class="error text-danger percentage-error"></span>
                                                            </td>
                                                            <td><input type="file" class="form-control" name="education_document[]" accept=".pdf,application/pdf"></td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger remove-education">
                                                                    <i class="fa fa-trash-o"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row align-items-center head_label">
                                            <div class="col-12 col-md-12 ">
                                                <label>(ii). Institute in which the applicant has undergone the training and the period<span style="color: red;">*</span> <span class="text-label">(Upload the documents)</span></label>
                                                <br>
                                                <label for="tamil" class="tamil">பெற்றுள்ள
                                                    விண்ணப்பதாரர் பயிற்சி பெற்ற நிறுவனம் மற்றும் பயிற்சி பெற்ற காலம்<span style="color: red;">*</span>
                                                    <span class="text-label">(ஆவணங்களை பதிவேற்ற வேண்டும்)</span></label>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="institute-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:20%">Institute Name & Address</th>
                                                        <th>Duration</th>
                                                        <th>From date</th>
                                                        <th>To date</th>
                                                        <th class="text-center">Upload Document (Experience Certificate)
                                                            <br><span class="file-limit"> File type: PDF,PNG (Max 200 KB)</span>
                                                        </th>
                                                        <th>
                                                            <button type="button" class="btn btn-primary add-more-institute">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="institute-container">
                                                    <tr class="institute-fields">
                                                        {{-- <td>
                                                            <input autocomplete="off" class="form-control" name="institute_name[]" type="text">
                                                        </td> --}}
                                                        <td>
                                                            <textarea autocomplete="off" class="form-control" name="institute_name_address[]" id="institute_name_address[]" cols="5" rows="3"></textarea>
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control" name="duration[]" type="text">
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control" name="from_date[]" type="date">
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control" name="to_date[]" type="date">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="institute_document[]" type="file" accept=".pdf,application/pdf">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger remove-institute">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <div class="row align-items-center head_label">
                                            <div class="col-12 col-md-12 ">
                                                <label>(iii). Power Station to which he is aattached at present<span style="color: red;">*</span> <span class="text-label">(Upload the documents)</span></label>
                                                <br>
                                                <label for="tamil" class="tamil">பெற்றுள்ள விண்ணப்பதாரர் பயிற்சி பெற்ற நிறுவனம் மற்றும் பயிற்சி பெற்ற காலம்<span style="color: red;">*</span>
                                                    <span class="text-label">(ஆவணங்களை பதிவேற்ற வேண்டும்)</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="work-table">
                                                <thead>
                                                    <tr>
                                                        <th>Power Station</th>
                                                        <th>Years of Experience</th>
                                                        <th>Designation</th>

                                                        <th class="text-center">Upload Document (Experience Certificate)
                                                            <br><span class="file-limit"> File type: PDF,PNG (Max 200 KB)</span>
                                                        </th>
                                                        <th>
                                                            <button type="button" class="btn btn-primary add-more-work">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="work-container">
                                                    <tr class="work-fields">
                                                        <td>
                                                            <input autocomplete="off" class="form-control" name="work_level[]" type="text">
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control" name="experience[]" type="number">
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control" name="designation[]" type="text">
                                                        </td>

                                                        <td>
                                                            <input class="form-control" name="work_document[]" type="file" accept=".pdf,application/pdf">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger remove-work">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <div class="row align-items-center head_label">
                                            <div class="col-12 col-md-6">
                                                <label>(iv). Name of the employer<span style="color: red;">*</span></label>
                                                <br>
                                                <label for="tamil" class="tamil">தொழில் வழங்குநரின் பெயர்</label>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <textarea class="form-control" name="employer_name" id="employer_name" cols="5" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12 ">
                                                <div class="row align-items-center">
                                                    <div class="col-12 col-md-9 ">
                                                        <label for="Name">6. Have you made any previous application? If so, State reference No. and date </label>
                                                        <br>
                                                        <label for="tamil" class="tamil">இதற்கு முன்னாள் விண்ணப்பம் செய்துள்ளீர்களா ? ஆம் என்றால் அதன் குறிப்பு எண் மற்றும் தேதியை குறிப்பிடுக
                                                        </label>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input toggle-details" type="radio" name="previous_license" id="previous_license_yes" data-target="#previously_details" value="yes">
                                                            <label class="form-check-label" for="yesOption">Yes</label>
                                                        </div>
                                                          
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input toggle-details" type="radio" name="previous_license" id="previous_license_no" data-target="#previously_details" value="no" checked>
                                                            <label class="form-check-label" for="noOption">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="previously_details" style="display: none;">
                                                    <div class="col-12 col-md-2 text-md-right">
                                                        <label> Application Number <span style="color: red;">*</span></label>

                                                    </div>
                                                    <div class="col-12 col-md-2">
                                                        <input autocomplete="off" class="form-control text-box single-line" id="previously_number" name="previously_number" type="text" data-type="license" placeholder="Application Number" value="">
                                                        <span id="licenseError" class="text-danger"></span>
                                                    </div>
                                                    <div class="col-12 col-md-1 text-md-right">
                                                        <label> Date <span style="color: red;">*</span></label>
                                                        <span id="licenseError" class="text-danger"></span>

                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <div class="row">
                                                            <div class="col-12 col-md-7">
                                                                <input autocomplete="off" class="form-control text-box single-line verify-date" id="previously_date" name="previously_date" type="date" data-error="#dateError" value="">
                                                                <span id="dateError" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row align-items-center head_label mt-2">
                                            <div class="col-12 col-md-12">
                                                <label>7. Upload Documents <span style="color: red;">*</span></label>
                                                <br>
                                                <label for="tamil" class="tamil">ஆவணங்களைப் பதிவேற்றவும்
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <table class="table">
                                                    <tr>
                                                        <td>(i)</td>
                                                        <td>
                                                            <label for="Name">Upload Photo <span style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">புகைப்படத்தைப் பதிவேற்றவும்
                                                            </label>
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control text-box single-line" id="upload_photo" name="upload_photo" type="file" value="" accept=".jpg,.jpeg,.png">
                                                            <span class="file-limit"> File type: JPG,PNG (Max 50 KB) </span>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>(ii)</td>
                                                        <td>
                                                            <label for="Name">Aadhaar Number <span style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">ஆதார் எண்</label>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control text-box" name="aadhaar" id="aadhaar" maxlength="14" >
                                                            <span id="aadhaar-error" class="text-danger"></span>
                                                        </td>
                                                        <td>
                                                            <label for="Name">(iii) Upload Aadhaar Document <span style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">ஆதார் ஆவணத்தை பதிவேற்றவும் <span style="color: red;">*</span></label>
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control text-box single-line" id="aadhaar_doc" name="aadhaar_doc" type="file" accept=".pdf,application/pdf">
                                                            <span class="file-limit"> File type: PDF (Max 250 KB) </span>
                                                            <small class="text-danger file-error"></small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>(iv)</td>
                                                        <td>
                                                            <label for="Name">Pan Card Number <span style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">நிரந்தர கணக்கு எண்</label>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control text-box " name="pancard" id="pancard">
                                                            <p id="pancard-error" class="text-danger"></p>
                                                        </td>
                                                        <td>
                                                            <label for="Name">(v) Upload Pan Card Document <span style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">பான் கார்டு ஆவணத்தைப் பதிவேற்றவும் </label>
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control text-box single-line" id="pancard_doc" name="pancard_doc" type="file" accept=".pdf,application/pdf">
                                                            <span class="file-limit"> File type: PDF (Max 250 KB) </span><br>
                                                            <p class="text-danger file-error"></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="col-12 col-md-6 " style="display: none;">
                                                <div class="row align-items-center">
                                                    <div class="col-12 col-md-5 ">
                                                        <label for="Name">(ii) Upload Signature
                                                        </label>
                                                        <br>
                                                        <label for="tamil" class="tamil">கையொப்பத்தைப் பதிவேற்றவும்</label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input autocomplete="off" class="form-control text-box single-line" id="upload_sign" name="upload_sign" type="file" accept="pdf/*">
                                                        <span class="file-limit"> File type: JPG,PNG (Max 50 KB) </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div>
                                            <label class="container">
                                                <div class="declaration-container">
                                                <input type="checkbox" id="declarationCheckbox" required {{ isset($application) ? 'checked' : '' }}>

                                                    <span class="checkmark"></span>
                                                    <div>
                                                        I hereby declare that the particulars stated above are correct and true to the best of
                                                        my knowledge.<span style="color: red;">*</span><br> I request that I may be granted a Power Generating Station Operation and
                                                        maintenance Competency Certificate.<br>
                                                        <span class="tamil">என் அறிவின் படி மேலே குறிப்பிட்டுள்ள விவரங்கள் அனைத்தும் சரியானதும் உண்மையானதுமாக இருப்பதாக நான் இங்கே அறிவிக்கிறேன்.</span>
                                                        <br>
                                                        <span class="tamil">மின்சாரம் உற்பத்தி நிலையத்தின் செயல்பாடு மற்றும் பராமரிப்பு திறன் சான்றிதழை எனக்கு வழங்குமாறு நான் கேட்டுக்கொள்கிறேன்.</span>
                                                    </div>

                                                </div>
                                                <span id="checkboxError" class="text-danger" style="display: none;">Please check the declaration box before proceeding.</span>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control text-box single-line" id="login_id_store" name="login_id" type="text" value="{{ $user['user_id'] }}">
                                    <input type="hidden" id="application_id" name="application_id" value="{{ $application->id ?? '' }}">
                                    <input type="hidden" id="form_name" name="form_name" value="P">
                                    <input type="hidden" id="license_name" name="license_name" value="P">
                                    {{-- <input type="hidden" id="amount" name="amount" value="750"> --}}
                                    <input type="hidden" id="appl_type" name="appl_type" value="N">
                                    <input type="hidden" id="form_action" name="form_action" value="draft">
                                    @csrf

                                </div>

                                <div class="text-center mb-2">
                                   <span style="color: red">(Please read the instructions carefully in the declaration popup before proceeding with the payment.</span>
                                   <span target="_blank">or click here <i class="fa fa-file-pdf-o" style="color: red;"></i> (7.1 KB)</span>
                                   English | <a href="{{url('assets/pdf/form_a_notes.pdf')}}" class="text-success" target="_blank">தமிழ்</a>
                                   <span style="color:red">).</span>
                               </div>
                                <div class="row mt-5">
                                    <div class="offset-md-5 col-12 col-md-6">
                                        <div class="form-group">
                                           @if(! isset($application))
                                            <button type="button" class="btn btn-primary btn-social" id="DraftBtn" data-url="{{ route('form.draft_submit') }}" data-id="{{ $application_details->application_id ?? '' }}">
                                                Save As Draft
                                            </button>
                                            @endif
                                            <button type="submit" class="btn btn-success btn-social" id="ProceedtoPayment">
                                                Save and Proceed for Payment
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="draftModal" class="overlay-bg" style="display: none;">
    <div class="otp-modal">
        <h5>Your Application Details Saved Successfully</h5>
        <br>
        <button onclick="closeDraftModal()">OK</button>
    </div>
</div>

</div>

<footer class="main-footer">
@include('include.footer')

<!-- JavaScript -->
<script>
    document.addEventListener("click", function(e) {
        let container = document.getElementById("education-container");
        let educationRows = container.querySelectorAll(".education-fields");

        // ✅ Prevent adding more than 5 entries
        if (e.target.closest(".add-more")) {
            if (educationRows.length >= 5) {
                 $('#education-table').next('.education-error').remove();

                    $('<div class="text-danger mt-2 education-error">You can add a maximum of 5 education entries.</div>')
                    .insertAfter('#education-table');

                    setTimeout(() => {
                        $('.education-error').fadeOut();
                    }, 7000);
                return;
            }

            let newRow = document.createElement("tr");
            newRow.classList.add("education-fields");
            newRow.innerHTML = `
                <td><select class="form-control" name="educational_level[]" required>
                        <option selected disabled>Select Education</option>
                        <option value="BEM">B.E(Mechanical)</option>
                        <option value="BEE">B.E(Electrical)</option>
                        <option value="DiplomaM">Diploma(Mechanical)</option>
                        <option value="DiplomaE">Diploma(Electrical)</option>
                    </select></td>
                <td><input type="text" class="form-control" name="institute_name[]" required></td>
                <td>
                    <select name="year_of_passing[]" class="form-control" required>
                        <option value="0">Select Year</option>
                        ${[...Array(new Date().getFullYear() - 1979).keys()]
                            .map(i => `<option value="${new Date().getFullYear() - i}">${new Date().getFullYear() - i}</option>`)
                            .join('')}
                    </select>
                </td>
                <td><input type="text" class="form-control" name="percentage[]" required></td>
                <td><input type="file" class="form-control" name="education_document[]"></td>
                <td>
                    <button type="button" class="btn btn-danger remove-education">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            `;

            container.appendChild(newRow);
        }

        /* Remove row functionality */
        if (e.target.closest(".remove-education")) {
            if (educationRows.length <= 1) {
                $('#education-table').next('.education-error').remove();

                $('<div class="text-danger mt-2 education-error">At least one education entry is required.</div>')
                .insertAfter('#education-table');

                setTimeout(() => {
                    $('.education-error').fadeOut();
                }, 7000);
                return;
            }
            e.target.closest("tr").remove();
        }
    });
</script>
<script>

    document.addEventListener("click", function(e) {
        let container = document.getElementById("work-container");
        let workRows = container.querySelectorAll(".work-fields");

        // Prevent adding more than 3 entries
        if (e.target.closest(".add-more-work")) {
            if (workRows.length >= 3) {
                $('#work-table').next('.work-error').remove();

                $('<div class="text-danger mt-2 work-error">You can add a maximum of 3 work experience entries.</div>')
                .insertAfter('#work-table');

                setTimeout(() => {
                    $('.work-error').fadeOut();
                }, 7000);
                return;
            }

            let newRow = document.createElement("tr");
            newRow.classList.add("work-fields");

            newRow.innerHTML = `
            <td><input autocomplete="off" class="form-control" name="work_level[]" type="text"></td>
                <td><input autocomplete="off" class="form-control" name="experience[]" type="number"></td>
                <td><input autocomplete="off" class="form-control" name="designation[]" type="text"></td>
                <td><input class="form-control" name="work_document[]" type="file"></td>
                <td>
                <button type="button" class="btn btn-danger remove-work">
                <i class="fa fa-trash-o"></i>
                </button>
                </td>
                `;

                container.appendChild(newRow);
            }

            // Remove row functionality
            if (e.target.closest(".remove-work")) {
                if (workRows.length <= 1) {
                    $('#work-table').next('.work-error').remove();

                $('<div class="text-danger mt-2 work-error">At least one work experience entry is required.</div>')
                .insertAfter('#work-table');

                setTimeout(() => {
                    $('.work-error').fadeOut();
                }, 7000);

                // alert("You must have at least one work experience entry.");
                    return;
                }
                e.target.closest("tr").remove();
        }
    });

    
    document.addEventListener("click", function(e) {
        let container = document.getElementById("institute-container");
        let instituteEntry = container.querySelectorAll(".institute-fields");

        // Prevent adding more than 3 entries
        if (e.target.closest(".add-more-institute")) {
            if (instituteEntry.length >= 3) {
                $('#institute-table').next('.institute-error').remove();

                $('<div class="text-danger mt-2 institute-error">You can add a maximum of 3 institute entries.</div>')
                .insertAfter('#institute-table');

                setTimeout(() => {
                    $('.institute-error').fadeOut();
                }, 7000);
                return;
            }

            let newRow = document.createElement("tr");
            newRow.classList.add("institute-fields");

            newRow.innerHTML = `
            <td><textarea autocomplete="off" class="form-control" name="institute_name_address[]" id="institute_name_address[]" cols="5" rows="3"></textarea></td>
            <td><input type="number" step="0.1" class="form-control" name="duration[]" min="0" max="50"></td>    
            <td><input type="date" class="form-control" name="from_date[]"></td>
                <td><input type="date" class="form-control" name="to_date[]"></td>
                <td class="text-center">
                    <input type="file" class="form-control" name="institute_document[]" accept=".pdf,.png,.jpg,.jpeg">
                </td>
                <td>
                <button type="button" class="btn btn-danger remove-inst-row">
                <i class="fa fa-trash-o"></i>
                </button>
                </td>
                `;

                container.appendChild(newRow);
            }

            // Remove row functionality
            if (e.target.closest(".remove-institute")) {
                if (instituteEntry.length <= 1) {
                    // alert("You must have at least one work experience entry.");

                     $('#institute-table').next('.institute-error').remove();

                    $('<div class="text-danger mt-2 institute-error">You must have at least one institute entry.</div>')
                    .insertAfter('#institute-table');

                    setTimeout(() => {
                        $('.institute-error').fadeOut();
                    }, 7000);

                    return;
                }
                e.target.closest("tr").remove();
        }
    });


    $('#verify_form_s').on('click', function () {
        const licenseNumber = $('#certificate_no').val().trim().toUpperCase();
        const date = $('#certificate_date').val().trim();
        const regex = /^(B|C|LC|LB)\d+$/;
        

        licenseError.textContent = '';
        $('#dateError').text('');

        let isValid = true;

        if (licenseNumber === '' || !regex.test(licenseNumber)) {
            licenseError.textContent = 'Enter a valid License Number';
            isValid = false;
        }

        if (date === '') {
            $('#dateError').text('Date is required');
            isValid = false;
        }else {
            const regexDate = /^(\d{4})-(\d{2})-(\d{2})$/; 
            const parts = date.match(regexDate);

            if (!parts) {
                $('#dateError').text('Enter a valid date');
                isValid = false;
            } else {
                const year = parseInt(parts[1], 10);
                const month = parseInt(parts[2], 10) - 1;
                const day = parseInt(parts[3], 10);

                const checkDate = new Date(year, month, day);

                if (
                    checkDate.getFullYear() !== year ||
                    checkDate.getMonth() !== month ||
                    checkDate.getDate() !== day ||
                    year < 1800 // ✅ Optional: Prevents year < 1900
                ) {
                    $('#dateError').text('Enter a valid date');
                    isValid = false;
                }
            }
        }

        if (!isValid) return;

        $.ajax({
            url: "{{ route('verifylicense') }}",
            method: "POST",
            data: {
                license_number: licenseNumber,
                date: date,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                let $msgBox = $("#license_message");

                if (response.exists) {
                    $msgBox
                        .removeClass("text-danger")
                        .addClass("text-success")
                        .html("&#10004; License verified.");
                } else {
                    $msgBox
                        .removeClass("text-success")
                        .addClass("text-danger")
                        .html("&#10060; License not found.");
                }
            },
            error: function (xhr, status, error) {
                let $msgBox = $("#license_message");

                $msgBox
                    .removeClass("text-success")
                    .addClass("text-danger")
                    .html("🚫 Error verifying license. Try again.");
            },
        });
    });

</script>