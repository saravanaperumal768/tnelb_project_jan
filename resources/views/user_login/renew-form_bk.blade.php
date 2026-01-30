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
</style>


<section class="">
    <div class="container">
        <ul id="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-home"> </span> Dashboard</a></li>
            <li><a href="#"><span class=" fa fa-info-circle"> </span> Form - {{ $application_details->form_name }} - Renewal</a></li>

        </ul>
    </div>
</section>
<section class="apply-form">
    <div class="auto-container">
        <div class="wrapper-box">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="apply-card apply-card-info" data-select2-id="14">
                        <div class="apply-card-header" style="background-color: #70c6ef  !important;">
                            <div class="row">
                                <div class="col-6 col-lg-8">
                                    <h5 class="card-title_apply text-black text-left"> Renewal Form of
                                        <span style="font-weight: 600;">[ Form '{{ $application_details->form_name }}' -
                                            License '{{ $application_details->license_name }}' ] </span>
                                    </h5>
                                </div>

                                <div class="col-6 col-lg-4 text-md-right">
                                    <span><i class="fa fa-file-pdf-o" style="color: red;"></i> Important Notes (74 KB)</span>             
                                    English | <a href="{{url('assets/pdf/form_a_notes.pdf')}}" class="text-dark" target="_blank">தமிழ்</a>
                                </div>

                            </div>

                        </div>
                        <div class="apply-card-body">

                            <form id="edit_application_form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 ">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-5 ">
                                                            <label for="Name">1. Applicant's Name <span
                                                                    style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">விண்ணப்பதாரர்
                                                                பெயர்</label>
                                                        </div>

                                                        <div class="col-12 col-md-7">
                                                            <input type="hidden"
                                                                class="form-control text-box single-line"
                                                                id="login_id_store" name="login_id_store" type="text"
                                                                value="{{ Auth::user()->login_id }}">

                                                            {{-- <input type="text"
                                                                class="form-control text-box single-line"
                                                                id="old_id" name="old_id" type="text"
                                                                value="value= "{{ $applicationid }}"> --}}


                                                            <input type="hidden" id="application_id"
                                                                name="application_id"
                                                                value="{{ isset($application_details) ? $application_details->application_id : '' }}">
                                                            <input type="hidden" id="license_number"
                                                                name="license_number"
                                                                value="{{ isset($license_details) ? $license_details->license_number : '' }}">
                                                            <input autocomplete="off"
                                                                class="form-control text-box single-line"
                                                                id="Applicant_Name" name="Applicant_Name" type="text"
                                                                value="{{ isset($application_details) ? $application_details->applicant_name : Auth::user()->name }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-3">
                                                            <label for="Name">2. Father's Name <span
                                                                    style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">தகப்பனார் பெயர்</label>
                                                        </div>

                                                        <div class="col-12 col-md-8 pd-left-40">
                                                            <input autocomplete="off"
                                                                class="form-control text-box single-line"
                                                                id="Fathers_Name" name="Fathers_Name" type="text"
                                                                value="{{ isset($application_details) ? $application_details->fathers_name : '' }}">

                                                            <span class="error-message text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 ">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-5 ">
                                                            <label for="Name">3. Applicant Address <span
                                                                    style="color: red;">*</span><br><span
                                                                    class="text-label">(To be clear)</span>
                                                            </label>
                                                            <br>
                                                            <label for="tamil" class="tamil">விண்ணப்பதாரர் முகவரி
                                                                <span class="text-label">(தெளிவாக இருக்க
                                                                    வேண்டும்)</span></label>
                                                        </div>
                                                        <div class="col-12 col-md-7">
                                                            <textarea rows="3" class="form-control " name="applicants_address">{{ isset($application_details) ? $application_details->applicants_address : Auth::user()->address }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 ">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-7">
                                                            <div class="row align-items-center">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="Name">4. (i) D.O.B <span
                                                                            style="color: red;">*</span></label><br>
                                                                    <label for="tamil" class="tamil">பிறந்த நாள்,
                                                                        மாதம், வருடம்</label>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <input class="form-control text-box single-line"
                                                                        type="text" autocomplete="off"
                                                                        id="d_o_b" name="d_o_b"
                                                                        placeholder="YYYY/MM/DD"
                                                                        value="{{ $application_details->d_o_b }}">
                                                                    <span id="dob-error"
                                                                        class="text-danger d-block mt-1"
                                                                        style="display: none;"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-5">
                                                            <div class="row align-items-center">
                                                                <div class="col-12 col-md-5">
                                                                    <label for="Name">4. (ii) Age <span
                                                                            style="color: red;">*</span></label><br>
                                                                    <label for="tamil" class="tamil"> வயது</label>
                                                                </div>
                                                                <div class="col-12 col-md-7">
                                                                    <input autocomplete="off"
                                                                        class="form-control text-box single-line"
                                                                        id="age" name="age" type="number"
                                                                        value="{{ isset($application_details) ? $application_details->age : '' }}"
                                                                        placeholder="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center head_label">
                                                <div class="col-12 col-md-12 ">
                                                    <label> 5. Applicant's Educational/ Technical qualification and pass
                                                        details <span
                                                        style="color: red;">*</span><span class="text-label"> (documents to be uploaded)
                                                        </span></label>
                                                    <br>
                                                    <label for="tamil" class="tamil">விண்ணப்பதாரரின் தொழில்நுட்ப
                                                        தேர்ச்சி மற்றும் தேர்ச்சி பற்றிய விவரங்கள் <span
                                                        style="color: red;">*</span>
                                                        <span class="text-label">(ஆவணங்களை பதிவேற்ற
                                                            வேண்டும்)</span></label>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped"
                                                    id="education-table">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Education Level</th>
                                                            <th>Institution/School Name</th>
                                                            <th>Year of Passing</th>
                                                            <th>Percentage / Grade</th>
                                                            <th class="text-center">Upload Document (Consolidated
                                                                MarkSheet)
                                                                <br><span class="file-limit"> File type: PDF,PNG (Max
                                                                    100 KB)</span>
                                                            </th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="education-container">
                                                        @foreach ($edu_details as $edu_details)
                                                            <tr class="text-center">
                                                                <td>
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td>
                                                                    {{ isset($edu_details->educational_level) ? $edu_details->educational_level : 'No data' }}
                                                                </td>
                                                                <td>
                                                                    {{ isset($edu_details->institute_name) ? $edu_details->institute_name : '' }}
                                                                </td>
                                                                <td>
                                                                    {{ isset($edu_details->year_of_passing) ? $edu_details->year_of_passing : '' }}
                                                                </td>
                                                                <td>
                                                                    {{ isset($edu_details->percentage) ? $edu_details->percentage : '' }}
                                                                </td>
                                                                <td>
                                                                    @if (isset($edu_details->upload_document) && $edu_details->upload_document)
                                                                        <a class="text-primary"
                                                                            href="{{ url($edu_details->upload_document) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file-pdf-o"
                                                                                style="color: red"></i> View </a><br>
                                                                    @else
                                                                        No documents provided..
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($loop->last)
                                                                        <button type="button"
                                                                            class="btn btn-primary add-more-education">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center head_label">
                                                <div class="col-12 col-md-12 ">
                                                    <label> 6. Details of Previous and Current Work experiences <span
                                                            class="text-label"> <span
                                                            style="color: red;">*</span> (documents to be uploaded)
                                                        </span></label>
                                                    <br>
                                                    <label for="tamil" class="tamil">பெற்றுள்ள
                                                        முந்தைய மற்றும் தற்போதைய அனுபவங்களின் விவரங்கள்
                                                        <span style="color: red;">*</span> <span class="text-label">(ஆவணங்களை பதிவேற்ற
                                                            வேண்டும்)</span></label>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="work-table">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Company Name / Contractor</th>
                                                            <th>Years of Experience (Years)</th>
                                                            <th>Designation</th>
                                                            <th class="text-center">Upload Document (Experience
                                                                Certificate)
                                                                <br><span class="file-limit"> File type: PDF,PNG (Max
                                                                    100 KB)</span>
                                                            </th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="work-container">
                                                        @foreach ($exp_details as $exp_details)
                                                            <tr class="work-fields text-center">
                                                                <td>
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td>
                                                                    {{ isset($exp_details->company_name) && !empty($exp_details->company_name) ? $exp_details->company_name : '' }}
                                                                </td>
                                                                <td>
                                                                    {{ isset($exp_details->experience) && !empty($exp_details->experience) ? $exp_details->experience . ' Years' : '' }}
                                                                </td>
                                                                <td>
                                                                    {{ isset($exp_details->designation) && !empty($exp_details->designation) ? $exp_details->designation : '' }}
                                                                </td>
                                                                <td>
                                                                    @if (isset($exp_details->upload_document) && $exp_details->upload_document)
                                                                        <a class="text-primary"
                                                                            href="{{ url($exp_details->upload_document) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file-pdf-o"
                                                                                style="color: red"></i> View </a><br>
                                                                    @else
                                                                        No documents provided..
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($loop->last)
                                                                        <button type="button"
                                                                            class="btn btn-primary add-more-work">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-12 ">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-9 ">
                                                            <label for="Name">7. Have previously applied for
                                                                Electrical Assistant Qualification Certificate and if
                                                                yes then mention its number and date
                                                            </label>
                                                            <br>
                                                            <label for="tamil" class="tamil">இதற்கு முன்னாள்
                                                                விண்ணப்பம் செய்து மின் கம்பி உதவியாளர் தகுதி சான்றிதழ்
                                                                பெற்றுஉள்ளதா ஆம் என்றால் அதன் எண் மற்றும் நாளைக்
                                                                குறிப்பிடுக
                                                            </label>
                                                        </div>

                                                        <div class="col-md-1">
                                                            <label class="container">
                                                                <div class="declaration-container">
                                                                    <span class="checkmark"></span>Yes
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center mb-3"
                                                        id="previously_details"
                                                        style="{{ isset($license_details->license_number) ? 'display: flex;' : 'display: none;' }}">

                                                        <div
                                                            class="col-12 col-md-2 text-md-end d-flex align-items-center">
                                                            <label class="mb-0">License Number</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <input autocomplete="off" class="form-control"
                                                                id="previously_number" name="previously_number"
                                                                type="text" placeholder="License Number"
                                                                value="{{ isset($license_details) ? $license_details->license_number : '' }}" readonly>
                                                            <span id="licenseError"
                                                                class="text-danger d-block mt-1"></span>
                                                        </div>

                                                        <div
                                                            class="col-12 col-md-1 text-md-end d-flex align-items-center">
                                                            <label class="mb-0">Date</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <input autocomplete="off" class="form-control"
                                                                id="previously_date" name="previously_date"
                                                                type="date"
                                                                value="{{ isset($license_details) ? $license_details->expires_at : '' }}" readonly>
                                                            <span id="dateError"
                                                                class="text-danger d-block mt-1"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center"
                                                style="{{ isset($application_details->form_name) && $application_details->form_name == 'W' ? 'display: none;' : 'display: flex;' }}">
                                                <div class="col-12 col-md-12">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-9 ">
                                                            <label for="Name">8. Whether Passed the Electrical
                                                                Wireman Test and Obtained "Wireman Test
                                                                Certificate"</label>
                                                            <br>
                                                            <label for="tamil" class="tamil">மின் கம்பி மனிதன்
                                                                தேர்வு தேர்ச்சி பெற்று "கம்பி மனிதன் தேர்வு
                                                                சான்றிதழ்" பெற்றுள்ளதா</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            @if (isset($application_details) && !empty($application_details->wireman_details))
                                                                <input autocomplete="off"
                                                                    class="form-control text-box single-line"
                                                                    id="wireman_details" name="wireman_details"
                                                                    type="text" placeholder="License Number"
                                                                    value="{{ isset($application_details) ? $application_details->wireman_details : '' }}" readonly>
                                                                <span class="error-message text-danger"></span>
                                                            @else
                                                                <span class="text-danger">NA</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-12 ">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-6 ">
                                                            <label for="Name">9. Upload Passport Size Photo <span
                                                                    style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">பாஸ்போர்ட் அளவு
                                                                புகைப்படம் பதிவேற்ற</label>
                                                        </div>
                                                        <div
                                                            class="col-12 col-md-6 d-flex flex-column align-items-center text-center">
                                                            @if (file_exists($applicant_photo->upload_path))
                                                                <img src="{{ url($applicant_photo->upload_path) }}"
                                                                    id="preview_applicant"
                                                                    class="img-fluid border mb-2"
                                                                    style="max-width: 100px;height: 100px;" alt="Applicant Photo">
                                                            @else
                                                                <div class="d-flex justify-content-center align-items-center border mb-2"
                                                                    style="height: 200px; width: 200px; background-color: #f8f9fa;">
                                                                    <span class="text-muted">No Photo Available</span>
                                                                </div>
                                                            @endif
                                                            <button type="button" class="btn btn-primary btn-sm mb-2"
                                                                onclick="togglePhotoInput()">Edit/Upload Photo</button>
                                                            <div id="photo-input-wrapper"
                                                                style="display: none; width: 100%; max-width: 300px;">
                                                                <span class="file-limit"> File type: JPG, PNG (Max 50
                                                                    KB) </span>
                                                                <input autocomplete="off"
                                                                    class="form-control text-box single-line mb-1"
                                                                    id="upload_photo" name="upload_photo"
                                                                    type="file" accept="image/*">
                                                                <span class="error-message text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <table class="table table-bordered table-sm" style="width: 90%">
                                                        <tbody>
                                                            @php
                                                                $decryptedaadhar = Crypt::decryptString($application_details->aadhaar);
                                                                 $decryptedpan = Crypt::decryptString($application_details->pancard);

                                                 
                                                                 if (strlen($decryptedaadhar) === 12) {
                                                                    $masked = str_repeat('X', 8) . substr($decryptedaadhar, -4);
                                                                } else {
                                                                    $masked = 'Invalid Aadhaar';
                                                                }
                                                                if (strlen($decryptedpan) === 10) {
                                                                    $maskedPan = str_repeat('X', 6) . substr($decryptedpan, -4);
                                                                } else {
                                                                    $maskedPan = 'Invalid PAN';
                                                                }
                                                            @endphp
                                                            <tr>
                                                                <th style="width: 50%; vertical-align: middle;">
                                                                    (ii). Aadhaar Number <span style="color: red;">*</span><br>
                                                                    <span class="tamil">ஆதார் எண்</span>
                                                                </th>
                                                                <td style="width: 30%; text-align: center; vertical-align: middle;">
                                                                    {{ isset($masked) ? $masked : '' }}
                                                                </td>
                                                                <td style="width: 20%; text-align: center; vertical-align: middle;">
                                                                    @if (!empty($application_details->aadhaar_doc))
                                                                        <a href="{{ route('document.show', ['type' => 'aadhaar', 'filename' => $application_details->aadhaar_doc]) }}" target="_blank" style="color: #007bff;">
                                                                            <i class="fa fa-file-pdf-o" style="color: red;"></i> View
                                                                        </a>
                                                                    @else
                                                                        <span class="text-danger">NA</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                            
                                                            <tr>
                                                                <th style="vertical-align: middle;">
                                                                    (iii). Pan Card Number <span style="color: red;">*</span><br>
                                                                    <span class="tamil">நிரந்தர கணக்கு எண்</span>
                                                                </th>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    {{ isset($maskedPan) ? $maskedPan : 'NA' }}
                                                                </td>
                                                                <td style="width: 20%; text-align: center; vertical-align: middle;">
                                                                    @if (!empty($application_details->pan_doc))
                                                                        <a href="{{ route('document.show', ['type' => 'pan', 'filename' => $application_details->pan_doc]) }}" target="_blank" style="color: #007bff;"><i class="fa fa-file-pdf-o" style="color: red;"></i> View</a>
                                                                    @else
                                                                        <span class="text-danger">NA</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <hr>
                                            <div>
                                                <label class="container">
                                                    <div class="declaration-container">
                                                        <input type="checkbox" id="declarationCheckbox" required>
                                                        <span class="checkmark"></span>
                                                        <div>
                                                            I hereby declare that all the details mentioned above are
                                                            correct and true to the best of my knowledge. I request you
                                                            to issue me the qualification certificate.<br>
                                                            <span class="tamil">என் அறிவுக்கு எட்டியவரை மேலே
                                                                குறிப்பிட்டுள்ள விவரங்கள் யாவும் சரியானவை எனவும்
                                                                உண்மையானவை எனவும் உறுதி கூறுகிறேன். தகுதி சான்றிதழ்
                                                                எனக்கு வழங்குமாறு வேண்டுகிறேன்.</span>
                                                        </div>
                                                    </div>
                                                    <p id="checkboxError" style="color: red; display: none;">Please
                                                        check the declaration box before proceeding.</p>
                                                </label>
                                            </div>
                                            <input type="hidden" id="form_name" name="form_name"
                                                value="{{ isset($application_details) ? $application_details->form_name : '' }}">
                                            <input type="hidden" id="license_name" name="license_name"
                                                value="{{ isset($application_details) ? $application_details->license_name : '' }}">
                                            <input type="hidden" id="form_id" name="form_id"
                                                value="{{ isset($application_details) ? $application_details->form_id : '' }}">
                                            <input type="hidden" id="amount" name="amount" value="750">
                                            <input type="hidden" id="appl_type" name="appl_type" value="R">

                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 mt-5">
                                        <div class="form-group text-center">
                                            <button type="button" class="btn btn-success" id="btn_save_draft">Save
                                                as Draft</button>
                                            <button type="button" class="btn btn-primary"
                                                id="btn_submit_payment">Proceed for Payment</button>
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

<footer class="main-footer">
    @include('include.footer')
</footer>
</div>
<script>
    document.getElementById('upload_photo').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById('preview_applicant');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    });

    function togglePhotoInput() {
        const inputWrapper = document.getElementById('photo-input-wrapper');
        inputWrapper.style.display = inputWrapper.style.display === 'none' ? 'block' : 'none';
    }
</script>
<script>
    // Age calculation on DOB change
    $('#d_o_b').on('change', function() {
        const dob = new Date($(this).val());
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        $('#age').val(age);
    });

    // Add more education row
    $(document).on('click', '.add-more-education', function() {
        let currentYear = new Date().getFullYear();
        let yearOptions = '<option value="">Select Year</option>';
        for (let year = currentYear; year >= 1980; year--) {
            yearOptions += `<option value="${year}">${year}</option>`;
        }

        // calculate next serial number

        let serialNo = $('#education-container tr').length + 1;

       


        // let serialNo = $('#education-container .education-fields').length + 1;

        let newRow = `
        <tr class="education-fields text-center">
            <td>${serialNo}</td>
            <td> 
                <select class="form-control" name="educational_level[]" required>
                    <option value="">Select Education</option>
                    <option value="PG">PG</option>
                    <option value="UG">UG</option>
                    <option value="Diploma">Diploma</option>
                    <option value="+2">+2</option>
                    <option value="10">10</option>
                </select>
            </td>
            <td><input type="text" class="form-control" name="institute_name[]" required></td>
            <td>
                <select name="year_of_passing[]" class="form-control" required>
                    ${yearOptions}
                </select>
            </td>
            <td>
                <input type="number" step="0.1" class="form-control percentage-input" name="percentage[]" min="1" max="100" placeholder="Percentage" required>
                <span class="error text-danger percentage-error"></span>
            </td>
            <td>
                <input type="file" class="form-control" name="education_document[]" accept=".pdf,.png,.jpg,.jpeg" required>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-education">
                    <i class="fa fa-minus"></i>
                </button>
            </td>
        </tr>
    `;
        $('#education-container').append(newRow);
    });


    // Remove education row
    $(document).on('click', '.remove-education', function() {
        $(this).closest('tr').remove();
    });

    // Add more work row
    $(document).on('click', '.add-more-work', function() {

        let serialNo = $('#work-container .work-fields').length + 1;
        let newRow = `
                <tr class="work-fields text-center">
                    <td>${serialNo}</td>
                    <td>
                        <input autocomplete="off" class="form-control" name="work_level[]" type="text">
                    </td>
                    <td><input type="number" step="0.1" class="form-control" name="experience_years[]" min="0" max="50"></td>
                    <td><input autocomplete="off" class="form-control" name="designation[]" type="text"></td>
                    <td class="text-center">
                        <input class="form-control" name="work_document[]" type="file" accept=".pdf,application/pdf">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-work">
                            <i class="fa fa-minus"></i>
                        </button>
                    </td>
                </tr>
            `;
        $('#work-container').append(newRow);
    });

    // Remove work row
    $(document).on('click', '.remove-work', function() {
        $(this).closest('tr').remove();
    });

    // Form submission handler - same as
    $('#btn_save_draft, #btn_submit_payment').on('click', function(e) {
        e.preventDefault(); // Prevent default form submission

        $('.error-message').remove(); // Clear previous error messages
        let isValid = true;
        let firstErrorField = null; // To store the first error field


         // Validate Father's Name
         let nameRegex = /^[A-Za-z\s]+$/;

        let fathersName = $('#Fathers_Name').val().trim();
        if (fathersName === "") {
            let errorMsg = $('<span class="error-message text-danger d-block mt-1">Father\'s Name is required.</span>');
            $('#Fathers_Name').after(errorMsg);
            if (!firstErrorField) firstErrorField = $('#Fathers_Name');
            isValid = false;
        } else if (!nameRegex.test(fathersName)) {
            let errorMsg = $('<span class="error-message text-danger d-block mt-1">Only alphabets and spaces are allowed.</span>');
            $('#Fathers_Name').after(errorMsg);
            if (!firstErrorField) firstErrorField = $('#Fathers_Name');
            isValid = false;
        }



        let photoWrapper = $('#photo-input-wrapper');

        if (photoWrapper.is(':visible')) {
            let photoInput = $('#upload_photo')[0];

            if (photoInput.files.length === 0) {
                let errorMsg = $('<span class="error-message text-danger d-block mt-1">Photo upload is required.</span>');
                $('#upload_photo').after(errorMsg);
                if (!firstErrorField) firstErrorField = $('#upload_photo');
                isValid = false;
            }
        }


        if (!$('#declarationCheckbox').is(':checked')) {
            $('#checkboxError').show();
            if (!firstErrorField) firstErrorField = $('#checkboxError');
            isValid = false;
        } else {
            $('#checkboxError').hide();
        }


        let educationRows = $('#education-container .education-fields');

        if (educationRows.length > 0) {
            educationRows.each(function () {
                let eduLevel = $(this).find('select[name="educational_level[]"]');
                let instituteName = $(this).find('input[name="institute_name[]"]');
                let yearOfPassing = $(this).find('select[name="year_of_passing[]"]');
                let percentage = $(this).find('input[name="percentage[]"]');
                let education_upload = $(this).find('input[name="education_document[]"]');

                eduLevel.nextAll('.error-message').remove();
                yearOfPassing.nextAll('.error-message').remove();

                if (!eduLevel.val()) {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Education level is required.</span>');
                    eduLevel.after(errorMsg);
                    if (!firstErrorField) firstErrorField = eduLevel;
                    isValid = false;
                }

                if (instituteName.length && (instituteName.val() || '').trim() === "") {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Institution name is required.</span>');
                    instituteName.after(errorMsg);
                    if (!firstErrorField) firstErrorField = instituteName;
                    isValid = false;
                }

                if (!yearOfPassing.val()) {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Year of passing is required.</span>');
                    yearOfPassing.after(errorMsg);
                    if (!firstErrorField) firstErrorField = yearOfPassing;
                    isValid = false;
                }

                let percentageVal = (percentage.val() || '').trim();

                if (
                    percentageVal === "" ||
                    isNaN(percentageVal) ||
                    percentageVal < 0 ||
                    percentageVal > 100
                ) {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Percentage / Grade is required.</span>');
                    percentage.after(errorMsg);
                    if (!firstErrorField) firstErrorField = percentage;
                    isValid = false;
                }

                let educationUploadVal = (education_upload.val() || '').trim();

                if (educationUploadVal === "") {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Education upload is required.</span>');
                    education_upload.after(errorMsg);
                    if (!firstErrorField) firstErrorField = education_upload;
                    isValid = false;
                }
            });
        }

        let workRows = $('#work-container .work-fields');
        if (workRows.length > 0) {
            workRows.each(function () {
                let workLevel = $(this).find('input[name="work_level[]"]');
                let experience = $(this).find('input[name="experience_years[]"]');
                let designation = $(this).find('input[name="designation[]"]');
                let workDocument = $(this).find('input[name="work_document[]"]');

                if (!workLevel.length && !experience.length && !designation.length && !workDocument.length) {
                    return true; // continue to next row
                }

                if (!workLevel.val()) {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Please enter the company / contractor name.</span>');
                    workLevel.after(errorMsg);
                    if (!firstErrorField) firstErrorField = workLevel;
                    isValid = false;
                }

                let experienceVal = (experience.val() || '').trim();

                if (
                    experienceVal === "" ||
                    isNaN(experienceVal) ||
                    parseInt(experienceVal) < 0 ||
                    parseInt(experienceVal) > 50
                ) {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Year of experience is required</span>');
                    experience.after(errorMsg);
                    if (!firstErrorField) firstErrorField = experience;
                    isValid = false;
                }


                if (!designation.val()) {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Designation is required.</span>');
                    designation.after(errorMsg);
                    if (!firstErrorField) firstErrorField = designation;
                    isValid = false;
                }

                let workUploadVal = (workDocument.val() || '').trim();

                if (workUploadVal === "") {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Work upload is required.</span>');
                    workDocument.after(errorMsg);
                    if (!firstErrorField) firstErrorField = workDocument;
                    isValid = false;
                }


            });
        }

        let photoInputVisible = $('#photo-input-wrapper').is(':visible');
        // let photoInput = $('#upload_photo')[0];
        if (photoInputVisible && photoInput.files.length === 0) {
            let errorMsg = $(
                '<span class="error-message text-danger d-block mt-1">Kindly upload your photo before submitting</span>'
                );
            $('#upload_photo').after(errorMsg);
            if (!firstErrorField) firstErrorField = errorMsg;
            isValid = false;
        }

        
        // console.log("isValid before final check:", isValid);
        // console.log("firstErrorField:", firstErrorField);

        if (!isValid) {
            let offset = firstErrorField.offset();
            if (offset) {
                $('html, body').animate({ scrollTop: offset.top - 100 }, 500);
            }
            return; // stop further processing if invalid
        } else {
            // ✅ All validations passed — proceed here
            let form_name = $("#form_name").val();
            showDeclarationPopuprenew(form_name);
        }
    });

    // education-container .education-fields

    $(document).on('keyup change', '#education-container .education-fields input, #education-container .education-fields select', function () {
        const $field = $(this);
        if ($field.val().trim() !== '') {
            $field.nextAll('.error-message').first().remove();
            $field.closest('.education-fields').find('.error-message').filter(function () {
                return $(this).text().includes("Please fill in at least one field");
            }).remove();
        }
    });

    $(document).on('keyup change', '#work-container .work-fields input, #work-container .work-fields select', function () {
        const $field = $(this);
        if ($field.val().trim() !== '') {
            $field.nextAll('.error-message').first().remove();
            $field.closest('.work-fields').find('.error-message').filter(function () {
                return $(this).text().includes("Please fill in at least one field");
            }).remove();
        }
    });

    function showDeclarationPopuprenew(form_name) {
        var form_cost;
        
        if(form_name == 'S'){
            form_cost = 375;
        }else if(form_name == 'W'){
            form_cost = 250;
        }else if(form_name == 'WH'){
            form_cost = 120;
        }

        console.log(form_cost);

        // return false;

        const modalEl = document.getElementById('competencyInstructionsModal');
        const agreeCheckbox = modalEl.querySelector('#declaration-agree-renew');
        const errorText = modalEl.querySelector('#declaration-error-renew');
        const proceedBtn = modalEl.querySelector('#proceedPayment');

        document.getElementById('form_fees').textContent = 'Rs.' + form_cost + '/-';

        // Reset state
        agreeCheckbox.checked = false;
        errorText.classList.add('d-none');

        // Show the modal
        const modal = new bootstrap.Modal(modalEl, {
            backdrop: 'static', // Prevent closing by clicking outside
            keyboard: false     // Prevent closing with Esc
        });
        modal.show();
        

        // Remove any previous event listener to avoid duplicates
        proceedBtn.replaceWith(proceedBtn.cloneNode(true));

        // Re-assign proceed button listener
        modalEl.querySelector('#proceedPayment').addEventListener('click', function () {
            if (!agreeCheckbox.checked) {
                errorText.classList.remove('d-none');
                return;
            }

            // Hide modal
            modal.hide();



            let actionType = $(this).attr('id') === 'btn_save_draft' ? "draft" : "payment";

            let formData = new FormData($('#edit_application_form')[0]);
            formData.append('form_action', actionType);

            let applicationId = $('#application_id').val();
            let url = applicationId ?
                "{{ route('form.update', ['appl_id' => '__APPL_ID__']) }}".replace('__APPL_ID__', applicationId) :
                "{{ route('form.store') }}";

            // Add method override for PUT requests
            if (applicationId) {
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    if (response.status == "success") {

                        const login_id = window.login_id || "{{ auth()->user()->login_id ?? '' }}";
                        const application_id = response.application_id;
                        const transactionDate = new Date().toLocaleDateString('en-GB'); // e.g., 23/06/2025
                        const applicantName = response.applicantName || 'N/A';
                        const amount = form_cost;
                        const transactionId = "TRX" + Math.floor(100000 + Math.random() * 900000); // random ID
                        const payment_mode =  'UPI';

                        Swal.fire({
                            title: "<span style='color:#0d6efd;'>Initiate Payment</span>",
                            html: `
                                <div class="text-start" style="font-size: 14px; padding: 10px 0;">
                                    <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
                                        <tbody>
                                            <tr>
                                                <th style="text-align: left; padding: 6px 10px; width: 50%; color: #555;">Application ID</th>
                                                <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${application_id}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 6px 10px; color: #555;">Transaction ID</th>
                                                <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${transactionId}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 6px 10px; color: #555;">Date</th>
                                                <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${transactionDate}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 6px 10px; color: #555;">Applicant Name</th>
                                                <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${applicantName}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 10px; color: #333;">Amount</th>
                                                <td style="text-align: right; padding: 10px; font-weight: bold; color: #0d6efd;">Rs. ${amount} /-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            `,
                            icon: "info",
                            iconHtml: '<i class="swal2-icon" style="font-size: 1 em">ℹ️</i>',
                            width: '450px',
                            showCancelButton: true,
                            confirmButtonText: '<span class="btn btn-primary px-4 pr-4">Pay Now</span>',
                            cancelButtonText: '<span class="btn btn-danger px-4">Cancel</span>',
                            showCloseButton: true,
                            customClass: {
                                popup: 'swal2-border-radius',
                                actions: 'd-flex justify-content-around mt-3',
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {

                                $.ajax({
                                    url: "{{ route('form.updatePayment') }}",
                                    type: "POST",
                                    data: {
                                        login_id: login_id,
                                        application_id: application_id,
                                        transaction_id: transactionId,
                                        transactionDate: transactionDate,
                                        amount: amount,
                                        payment_mode: payment_mode,
                                        form_name:form_name,
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    
                                    success: function (response) {
                                        if (response.status == 200) {
                                            showPaymentSuccessPopup(application_id, transactionId, transactionDate, applicantName, amount);
                                        } else {
                                            alert(response.message || 'Something went wrong!');
                                        }
                                    },
                                    error: function (xhr) {
                                        // $('#saveDraftBtn, #submitPaymentBtn').prop('disabled', false);
                                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                                            let messages = Object.values(xhr.responseJSON.errors).flat().join("\n");
                                            alert("Validation errors:\n" + messages);
                                        } else {
                                            alert("An error occurred: " + xhr.responseText);
                                        }
                                    }
                                });

                            } else {
                                Swal.fire("Payment Failed", "Application saved as draft", "danger");
                            }
                        });
                    }else{
                        Swal.fire("Form Submission Failed", "Application not submitted", "danger");
                    }


                    
                },
                error: function(xhr) {
                    // $('#btn_save_draft, #btn_submit_payment').prop('disabled', true);
                    alert("An error occurred: " + xhr.responseText);
                }
            });
        });
    }

    function showPaymentInitiationPopuprenew(loginId) {
        const transactionDate = new Date().toLocaleDateString('en-GB'); // e.g., 23/06/2025
        const applicantName = $('#Applicant_Name').val() || 'N/A';
        const amount = "₹2500";
        const transactionId = "TRX" + Math.floor(100000 + Math.random() * 900000); // random ID

        Swal.fire({
            title: "<span style='color:#0d6efd;'>Initiate Payment</span>",
            html: `
                <div class="text-start" style="font-size: 14px; padding: 10px 0;">
                    <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <th style="text-align: left; padding: 6px 10px; width: 50%; color: #555;">Application ID</th>
                                <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${loginId}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; padding: 6px 10px; color: #555;">Transaction ID</th>
                                <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${transactionId}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; padding: 6px 10px; color: #555;">Date</th>
                                <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${transactionDate}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; padding: 6px 10px; color: #555;">Applicant Name</th>
                                <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${applicantName}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; padding: 10px; color: #333;">Amount</th>
                                <td style="text-align: right; padding: 10px; font-weight: bold; color: #0d6efd;">${amount}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `,
            icon: "info",
            iconHtml: '<i class="swal2-icon" style="font-size: 1 em">ℹ️</i>',
            width: '450px',
            showCancelButton: true,
            confirmButtonText: '<span class="btn btn-primary px-4 pr-4">Pay Now</span>',
            cancelButtonText: '<span class="btn btn-danger px-4">Cancel</span>',
            showCloseButton: true,
            customClass: {
                popup: 'swal2-border-radius',
                actions: 'd-flex justify-content-around mt-3',
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                showPaymentSuccessPopup(loginId, transactionId, transactionDate, applicantName, amount);
            } else {
                Swal.fire("Cancelled", "Payment not initiated.", "info");
            }
        });
    }

    function showPaymentSuccessPopup(loginId, transactionId, transactionDate, applicantName, amount) {
        Swal.fire({
            title: `<h3 style="color:#198754; font-size:1.5rem;">Payment Successful!</h3>`,
            html: `
        <div style="font-size: 14px; text-align: left; width: 100%; max-width: 100%;">
        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
            <div style="
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 4px 12px;
            font-size: 14px;
            max-width: 400px;
            border-right:2px solid #0d6efd;
            padding: 0px 25px;
            ">
            <div style="font-weight: bold;">Application ID:</div>
            <div style="word-break: break-word;">${loginId}</div>

            <div style="font-weight: bold;">Transaction ID:</div>
            <div style="word-break: break-word;">${transactionId}</div>

            <div style="font-weight: bold;">Transaction Date:</div>
            <div>${transactionDate}</div>

            <div style="font-weight: bold;">Applicant Name:</div>
            <div>${applicantName}</div>

            <div style="font-weight: bold;">Amount Paid:</div>
            <div>${amount}</div>
        </div>
            <div style="min-width: 220px;">
            <p><strong>Download Your Payment Receipt:</strong></p>
            <button class="btn btn-info btn-sm mb-2" onclick="paymentreceiptrenew('${loginId}')">
                <i class="fa fa-file-pdf-o text-danger"></i> 
                <i class="fa fa-download text-danger"></i>
                Download Receipt
            </button>
            <p class="mt-3"><strong>Download Your Application PDF:</strong></p>
            <button class="btn btn-primary btn-sm me-1" onclick="downloadPDFrenew('english', '${loginId}')">English PDF</button>
            <button class="btn btn-success btn-sm" onclick="downloadPDFrenew('tamil', '${loginId}')">Tamil PDF</button>
            </div>
        </div>
        </div>
        `,
            icon: "success",
            width: '50%', // adjust dynamically
            customClass: {
                popup: 'swal2-border-radius p-3'
            },
            confirmButtonText: "Go to Dashboard",
            confirmButtonColor: "#0d6efd",
            allowOutsideClick: true,
            allowEscapeKey: true,
            showCloseButton: true,
            willClose: () => {
                window.location.href = 'dashboard';
            }
        });
    }

    function paymentreceiptrenew(loginId) {
        window.open(`/payment-receipt/${loginId}`, '_blank');
    }

    function downloadPDFrenew(language, loginId) {
        let url = (language === 'tamil') ?
            `/generaterenewalTamilPDF/${loginId}` :
            `/generaterenewal-pdf/${loginId}`;
        window.open(url, '_blank');
    }
</script>
</body>

</html>
