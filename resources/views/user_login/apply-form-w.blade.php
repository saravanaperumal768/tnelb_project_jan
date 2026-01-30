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
</style>
<section class="">
    <div class="container">
        <ul id="breadcrumb">
            <li><a href="{{ route('dashboard')}}"><span class="fa fa-home"> </span> Dashboard</a></li>
            <li><a href="#"><span class=" fa fa-info-circle"> </span> Form W</a></li>

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
                                        <h5 class="card-title_apply text-white text-uppercase font-weight-bold">
                                            Application for Wireman Competency Certificate
                                        </h5>
                                        <h5 class="card-title_apply text-white text-uppercase mt-2">
                                            மின்கம்பியாளர் தகுதி சான்றிதழ் பெறுவதற்கான விண்ணப்பம்
                                        </h5>
                                        <h6 class="card-title_apply text-white mt-2 form-title">FORM - W / Certificate B</h4>
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
                                    </span> <a href="{{url('assets/pdf/form_w_notes.pdf')}}" class="text-white" target="_blank">தமிழ் <i class="fa fa-file-pdf-o" ></i> (38 KB)</a>
                                </div>

                            </div>
                        </div>

                          <div class="row">
                                <div class="col-lg-12 col-12 text-right text-head pl-5 mt-1" >
                                  <p class="pr-3 f-s-14"> <span class="text-red font-weight-bold">*</span> Fields are Mandatory </p>
                                </div>

                          </div>
                        <div class="apply-card-body">

                        <form id="competency_form_ws" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 ">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-5 ">
                                                            <label for="Name">1. Applicant's Name <span style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">விண்ணப்பதாரர் பெயர்</label>
                                                        </div>

                                                        <div class="col-12 col-md-7">
                                                            <input type="hidden" class="form-control text-box single-line" id="login_id_store" name="login_id" type="text" value="{{ Auth::user()->login_id }}">
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
                                                            <input autocomplete="off" class="form-control text-box single-line" id="Fathers_Name" name="fathers_name" type="text" value="{{ isset($application) ? $application->fathers_name : '' }}" maxlength="50">
                                                            <span class="error-message text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 ">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-5 ">
                                                            <label for="Name">3. Applicant Address <span style="color: red;">*</span><br><span class="text-label">(To be clear)</span>
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
                                                                <div class="col-12 col-md-7 ">
                                                                    <label for="Name">4. (i) D.O.B <span style="color: red;">*</span></label>
                                                                    <br>
                                                                    <label for="tamil" class="tamil">பிறந்த நாள்,மாதம், வருடம்</label>
                                                                </div>
                                                                <div class="col-12 col-md-5">
                                                                    <input autocomplete="off" class="form-control text-box single-line" id="d_o_b" name="d_o_b" type="text"  placeholder="DD/MM/YYYY" value="{{ isset($application) ? $application->d_o_b : '' }}">
                                                                    <span id="dob-error" class="text-danger"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-5">
                                                            <div class="row align-items-center">
                                                                <div class="col-12 col-md-5 ">
                                                                    <label for="Name">4. (ii) Age <span style="color: red;">*</span></label>
                                                                    <br>
                                                                    <label for="tamil" class="tamil"> வயது</label>
                                                                </div>
                                                                <div class="col-12 col-md-7">
                                                                    <input autocomplete="off" class="form-control text-box single-line" id="age" name="age" type="number"  value="{{ isset($application) ? $application->age : '' }}" placeholder="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>



                                            </div>
                                            <hr>
                                            <div class="row align-items-center head_label">
                                                <div class="col-12 col-md-12 ">
                                                    <label> 5. Applicant's Educational/ Technical Qualification and pass details <span style="color: red;">*</span> <span class="text-label"> (Upload the documents) </span></label>
                                                    <br>
                                                    <label for="tamil" class="tamil">விண்ணப்பதாரரின் தொழில்நுட்ப
                                                        தேர்ச்சி மற்றும் தேர்ச்சி பற்றிய விவரங்கள் <span style="color: red;">*</span>
                                                        <span class="text-label">(ஆவணங்களை பதிவேற்ற வேண்டும்)</span></label>
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
                                                                <br><span class="file-limit"> File type: PDF ( Min 5 KB Max 200 KB)</span>
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
                                                                    <option value="PG">PG</option>
                                                                    <option value="UG">UG</option>
                                                                    <option value="Diploma">Diploma</option>
                                                                    <option value="+2">+2</option>
                                                                    <option value="10">10</option>
                                                                </select></td>
                                                            <td><input type="text" class="form-control" name="institute_name[]"></td>
                                                            <td>
                                                                <select name="year_of_passing[]" class="form-control">
                                                                    <option value="0">Select Year</option>
                                                                    <script>
                                                                        let currentYear = new Date().getFullYear();
                                                                        for (let year = currentYear; year >= 1980; year--) {
                                                                            document.write(`<option value="${year}">${year}</option>`);
                                                                        }
                                                                    </script>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" class="form-control" name="percentage[]"></td>
                                                            <td><input type="file" class="form-control" name="education_document[]"></td>
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
                                                <label>6. Details of Previous and Current Work experiences <span style="color: red;">*</span> <span class="text-label"> (Upload the documents) </span></label>
                                                <br>
                                                <label for="tamil" class="tamil">பெற்றுள்ள
                                                    முந்தைய மற்றும் தற்போதைய அனுபவங்களின் விவரங்கள் <span style="color: red;">*</span>
                                                    <span class="text-label">(ஆவணங்களை பதிவேற்ற வேண்டும்)</span></label>
                                            </div>

                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="work-table">
                                                <thead>
                                                    <tr>
                                                        <th>Company Name / Contractor</th>
                                                        <th>Years of Experience</th>
                                                        <th>Designation</th>

                                                        <th class="text-center">Upload Document (Experience Certificate)
                                                            <br><span class="file-limit"> File type: PDF ( Min 5 KB Max 200 KB)</span>
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
                                                            <input class="form-control" name="work_document[]" type="file">
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
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-9 ">
                                                <label for="Name">7. Have you applied for and obtained a Certificate of Qualification for Wireman / Wireman Helper ? If yes, please state its number and date.
                                                </label>
                                                <br>
                                                <label for="tamil" class="tamil">இதற்கு முன்னாள் விண்ணப்பம் செய்து கம்பியாட்கள் தகுதி சான்றிதழ் / மின் கம்பி உதவியாளர் தகுதி சான்றிதழ் பெற்றுஉள்ளதா ஆம் என்றால் அதன் எண் மற்றும் நாளைக் குறிப்பிடுக
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input toggle-details" type="radio" name="wireman_license" id="wireman_license_yes" data-target="#previously_details" value="yes">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>
                                                      
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input toggle-details" type="radio" name="wireman_license" id="wireman_license_no" data-target="#previously_details" value="no" checked>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row align-items-center" id="previously_details" style="display: none;">
                                            <div class="col-12 col-md-2 text-md-right">
                                                <label> License Number <span style="color: red;">*</span></label>

                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input autocomplete="off" class="form-control text-box single-line" id="previously_number" name="certificate_no" type="text" placeholder="License Number" maxlength="12">
                                                <input type="hidden" id="cert_verify" name="cert_verify" value="0">
                                                <span id="licenseError" class="text-danger"></span>
                                                <span id="license_message" class="mt-1"></span>
                                            </div>
                                            <div class="col-12 col-md-1 text-md-right">
                                                <label> Date <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input autocomplete="off" class="form-control text-box single-line" id="previously_date" name="certificate_date" type="date">
                                                        <span id="dateError" class="text-danger"></span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" id="verify_btn" class="btn btn-primary">Verify</button>
                                                    </div>
                                                </div>
                                                <span id="dateError" class="text-danger"></span>
                                            </div>
                                            {{-- <div class="col-12 col-md-3">
                                                
                                            </div> --}}
                                        </div>
                                        <hr>

                                        <div class="row align-items-center"  style="display: none;">
                                            <div class="col-12 col-md-12 ">
                                                <div class="row align-items-center">
                                                    <div class="col-12 col-md-9 ">
                                                        <label for="Name">8. Do you possess Wireman.C.C/Wireman Helper.C.C issued by this Board? if so furnish the Details and surrender the same
                                                        </label>
                                                        <br>
                                                        <label for="tamil" class="tamil">இந்த வாரியத்தால் வழங்கப்பட்ட Wireman.C.C/Wireman Helper.C.C உங்களிடம் உள்ளதா? அப்படியானால் விவரங்களை அளித்து அதையே சரணடையவும்
                                                        </label>
                                                    </div>


                                                    <!-- <div class="col-md-1">
                                                        <input name="previous_exp" type="radio" value="1">
                                                        <label for="Yes">Yes</label>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <input name="previous_exp" type="radio" value="0">
                                                        <label for="No">No</label>
                                                    </div> -->
                                                    <div class="col-md-1">
                                                        <label class="container">
                                                            <div class="wireman-container">
                                                                <input type="checkbox" id="wireman_license">
                                                                <span class="checkmark"></span>
                                                                Yes
                                                            </div>

                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="row offset-md-3" id="wireman_details" style="display: none;">
                                                    <div class="col-12 col-md-4 text-md-right">
                                                        <label>Wireman License Number </label>

                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <input autocomplete="off" class="form-control text-box single-line" id="wireman_details" name="wireman_details" type="text" placeholder="License Number" value="">
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                        {{-- <hr> --}}
                                        <div class="row align-items-center head_label mt-2">
                                            <div class="col-12 col-md-12">
                                                <label>8. Upload Documents <span style="color: red;">*</span></label>
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
                                                            <input autocomplete="off" class="form-control text-box single-line" id="upload_photo" name="upload_photo" type="file" value="" accept="image/*">
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
                                                            <span class="file-limit"> File type: PDF (Max 250 KB) </span>
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
                                                        <input autocomplete="off" class="form-control text-box single-line" id="upload_sign" name="upload_sign" type="file" value="" accept="image/*">
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
                                                    I hereby declare that all the details mentioned above are correct and true to the best of my knowledge. I request you to issue me the qualification certificate.<br>
                                                    என் அறிவுக்கு எட்டியவரை மேலே குறிப்பிட்டுள்ள விவரங்கள் யாவும் சரியானவை எனவும் உண்மையானவை எனவும் உறுதி கூறுகிறேன். தகுதி சான்றிதழ் எனக்கு வழங்குமாறு வேண்டுகிறேன்.
                                                </div>
                                                <span id="checkboxError" class="text-danger" style="display: none;">Please check the declaration box before proceeding.</span>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" id="form_name" name="form_name" value="W">
                                    <input type="hidden" id="license_name" name="license_name" value="B">
                                    <input type="hidden" id="amount" name="amount" value="500">
                                    <input type="hidden" id="form_id" name="form_id" value="2">
                                    <input type="hidden" id="appl_type" name="appl_type" value="N">
                                    @csrf
                                    <input type="hidden" id="form_action" name="form_action" value="draft">
                                </div>
                                <div class="row mt-5">
                                    <div class="offset-md-5 col-12 col-md-6">
                                        <div class="form-group">
                                        @if(! isset($application))
                                            <button type="button" class="btn btn-primary btn-social" id="saveDraftBtn" data-url="{{ route('form.draft_submit') }}" data-id="{{ $application_details->application_id ?? '' }}"> Save As Draft </button>
                                            @endif
                                            <button type="submit" class="btn btn-success btn-social" id="submitPaymentBtn">
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

<!-- Modal Popup -->
<div id="draftModal" class="overlay-bg" style="display: none;">
    <div class="otp-modal">
        <h5>Your Application Details Saved Successfully</h5>
        <br>
        <button onclick="closeDraftModal()">OK</button>
    </div>
</div>

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

<!-- JavaScript -->
<script>
    // document.getElementById('saveDraftBtn').addEventListener('click', function() {
    //     document.getElementById('draftModal').style.display = 'flex';
    // });

    function closeDraftModal() {
        document.getElementById('draftModal').style.display = 'none';
    }
</script>

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
                <option value="PG">PG</option>
                <option value="UG">UG</option>
                <option value="Diploma">Diploma</option>
                <option value="+2">+2</option>
                <option value="10">10</option>
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

        // ✅ Remove row functionality
        if (e.target.closest(".remove-education")) {
            if (educationRows.length <= 1) {
                $('#education-table').next('.education-error').remove();

                $('<div class="text-danger mt-2 education-error">At least one education entry is required.</div>')
                .insertAfter('#education-table');

                setTimeout(() => {
                    $('.education-error').fadeOut();
                }, 7000);

                // alert("You have to at least one education entry.");
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
</script>
