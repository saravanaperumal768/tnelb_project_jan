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
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-home"> </span> Dashboard</a></li>
            <li><a href="#"><span class=" fa fa-info-circle"> </span> Form {{ $application_details->form_name }}</a></li>

        </ul>
    </div>
</section>
<section class="apply-form">
    <div class="auto-container">
        <div class="wrapper-box">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="apply-card apply-card-info" data-select2-id="14">
                        <div class="apply-card-header" style="background-color: rgb(3 90 179); padding: 15px;">
                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <div class="text-center text-white text-uppercase font-weight-bold">
                                            <h5 class="card-title_apply text-white text-uppercase font-weight-bold" >
                                                Application for Power Generating Station Operation & Maintenance Competency Certificate
                                            </h5>
                                     
                                            <h6 class="card-title_apply text-white mt-2 form-title">FORM - P / Certificate P</h4>
                                            <small>DRAFT</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-12 text-right">
                                        <span class="text-white font-weight-bold" target="_blank"> Instructions 
                                           </span> <a href="{{url('assets/pdf/form_p_notes.pdf')}}" class="text-white" target="_blank">English <i class="fa fa-file-pdf-o" ></i>  (8 KB)</a>
                                    </div>
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
                                                        <div class="col-12 col-md-5 ">
                                                            <label for="Name">1. Applicant's Name <span style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">விண்ணப்பதாரர் பெயர்</label>
                                                        </div>
                                                        <div class="col-12 col-md-7">
                                                            <input autocomplete="off" class="form-control text-box single-line" id="Applicant_Name" name="applicant_name" type="text" value="{{ isset($application_details) ? $application_details->applicant_name : Auth::user()->name }}" readonly> 
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
                                                                id="Fathers_Name" name="fathers_name" type="text"
                                                                value="{{ isset($application_details) ? $application_details->fathers_name : '' }}" maxlength="50">

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
                                                            <textarea rows="3" class="form-control " name="applicants_address" maxlength="250">{{ isset($application_details) ? $application_details->applicants_address : Auth::user()->address }}</textarea>
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
                                                                        value="{{ ($application_details->d_o_b) ?? '' }}">
                                                                    <span id="dob-error" class="text-danger d-block mt-1" style="display: none;"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-5">
                                                            <div class="row align-items-center">
                                                                <div class="col-12 col-md-5">
                                                                    <label for="Name">(ii) Age <span
                                                                            style="color: red;">*</span></label><br>
                                                                    <label for="tamil" class="tamil">வயது</label>
                                                                </div>
                                                                <div class="col-12 col-md-7">
                                                                    <input autocomplete="off"
                                                                        class="form-control text-box single-line"
                                                                        id="age" name="age" type="number" value="{{ isset($application_details) ? $application_details->age : '' }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center head_label">
                                                <div class="col-12 col-md-12 ">
                                                    <label> 5. (i). Details of Technical Qualification passed by the applicant <span style="color: red;">*</span> <span class="text-label"> (Upload the documents) </span></label>
                                                    <br>
                                                    <label for="tamil" class="tamil">விண்ணப்பதாரரின் தொழில்நுட்ப தேர்ச்சி மற்றும் தேர்ச்சி பற்றிய விவரங்கள் <span class="text-label">(ஆவணங்களை பதிவேற்ற வேண்டும்)</span></label>
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
                                                                    200 KB)</span>
                                                            </th>
                                                            <th>
                                                                <button type="button"
                                                                    class="btn btn-primary add-more-education">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="education-container">
                                                        {{-- @php
                                                            var_dump($edu_details->isEmpty());die;
                                                        @endphp --}}
                                                        @if ($edu_details->isNotEmpty())
                                                        @foreach ($edu_details as $edu_details)
                                                        <tr class="education-fields text-center">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <select class="form-control" name="educational_level[]">
                                                                    <option disabled {{ empty($edu_details->educational_level) ? 'selected' : '' }}>Select Education</option>
                                                                    <option value="BEM" {{ $edu_details->educational_level == 'BEM' ? 'selected' : '' }}>B.E(Mechanical)</option>
                                                                    <option value="BEE" {{ $edu_details->educational_level == 'BEE' ? 'selected' : '' }}>B.E(Electrical)</option>
                                                                    <option value="DME" {{ $edu_details->educational_level == 'DME' ? 'selected' : '' }}>Diploma(Mechanical)</option>
                                                                    <option value="DEE" {{ $edu_details->educational_level == 'DEE' ? 'selected' : '' }}>Diploma(Electrical)</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" class="form-control" name="institute_name[]" value="{{ isset($edu_details->institute_name) ? $edu_details->institute_name : '' }}"></td>
                                                            <td>
                                                                <select name="year_of_passing[]" class="form-control">
                                                                    <option value="0" disabled {{ empty($edu_details->year_of_passing) ? 'selected' : '' }}>Select Year</option>
                                                                    @php
                                                                        $currentYear = date('Y');
                                                                    @endphp
                                                                    @for ($year = $currentYear; $year >= 1980; $year--)
                                                                        <option value="{{ $year }}" {{ $edu_details->year_of_passing == $year ? 'selected' : '' }}>
                                                                            {{ $year }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                            <td>
                                                            <input type="number" step="0.1" class="form-control percentage-input" name="percentage[]" min="1" max="99" value="{{ isset($edu_details->percentage) ? $edu_details->percentage : '' }}">
                                                            <span class="error text-danger percentage-error"></span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center file-section">
                                                                    @if (!empty($edu_details->upload_document))
                                                                    <div>
                                                                        <?php //var_dump(!empty($edu_details->upload_document)); ?>
                                                                            <a class="text-primary" href="{{ url('public/'. $edu_details->upload_document) }}" target="_blank">
                                                                                <i class="fa fa-file-pdf-o" style="color: red"></i> View
                                                                            </a>
                                                                        </div>
                                                                        <button class="btn btn-sm btn-danger ml-3 remove-doc_edu">Remove</button>
                                                                    @else
                                                                    <div>
                                                                        <input type="file" class="form-control" name="education_document[]" accept=".pdf,application/pdf">
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <button type="button" class="btn btn-danger remove-education remove_edu" data-edu_id = "{{ $edu_details->id }}" data-url= "{{ route('delete_education') }}">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </td>

                                                                <!-- 🔹 Add hidden fields here -->
                                                                <input type="hidden" name="edu_id[]" value="{{ $edu_details->id }}">
                                                                <input type="hidden" name="existing_document[]" value="{{ $edu_details->upload_document }}">
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr class="education-fields text-center">
                                                            <td>1</td>
                                                            <td> 
                                                                <select class="form-control" name="educational_level[]">
                                                                    <option selected disabled>Select Education</option>
                                                                    <option value="BEM">B.E(Mechanical)</option>
                                                                    <option value="BEE">B.E(Electrical)</option>
                                                                    <option value="DME">Diploma(Mechanical)</option>
                                                                    <option value="DEE">Diploma(Electrical)</option>
                                                                </select>
                                                            </td>
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
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </td>

                                                            <input type="hidden" name="edu_id[]" value="">
                                                            <input type="hidden" name="existing_document[]" value="">
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
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
                                                        <th>S.No</th>
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
                                                    @if ($institutes->isNotEmpty())
                                                    @foreach ($institutes as $institute)
                                                    <tr class="institute-fields text-center">
                                                        {{-- <td>
                                                            <input autocomplete="off" class="form-control" name="institute_name[]" type="text">
                                                        </td> --}}
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            <textarea autocomplete="off" class="form-control" name="institute_name_address[]" id="institute_name_address[]" cols="5" rows="3">{{ $institute->institute_name_address??'' }}</textarea>
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control" name="duration[]" type="number" value="{{ $institute->duration??'' }}">
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control" name="from_date[]" type="date" value="{{ $institute->from_date??'' }}">
                                                        </td>
                                                        <td>
                                                            <input autocomplete="off" class="form-control" name="to_date[]" type="date" value="{{ $institute->to_date??'' }}">
                                                        </td>
                                                        {{-- <td>
                                                            <input class="form-control" name="institute_document[]" type="file" accept=".pdf,application/pdf">
                                                        </td> --}}
                                                        <td>
                                                            @if (!empty($institute->upload_doc))
                                                                <div class="d-flex align-items-center file-section">
                                                                    <div>
                                                                        <a class="text-primary" href="{{ url($institute->upload_doc) }}" target="_blank">
                                                                            <i class="fa fa-file-pdf-o" style="color: red"></i> View
                                                                        </a>
                                                                    </div>
                                                                    <button class="btn btn-sm btn-danger ml-3 remove-inst">Remove</button>
                                                                </div>
                                                            @else
                                                                <input class="form-control" name="institute_document[]" type="file" accept=".pdf,application/pdf">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger remove-institute remove-inst-row" data-inst_id = "{{ $institute->id }}" data-url= "{{ route('delete_institute') }}">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </td>
                                                         <input type="hidden" name="institute_id[]" value="{{ $institute->id ?? '' }}">
                                                        <input type="hidden" name="exist_institute_document[]" value="{{ $institute->upload_doc ?? '' }}">
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                        <tr class="institute-fields text-center">
                                                            <td>1</td>
                                                            <td>
                                                               <textarea autocomplete="off" class="form-control" name="institute_name_address[]" id="institute_name_address[]" cols="5" rows="3">{{ $institute->institute_name_address??'' }}</textarea>
                                                           </td>
                                                           <td>
                                                               <input autocomplete="off" class="form-control" name="duration[]" type="number" value="{{ $institute->duration??'' }}" min="1" max="10">
                                                           </td>
                                                           <td>
                                                               <input autocomplete="off" class="form-control" name="from_date[]" type="date" value="{{ $institute->from_date??'' }}">
                                                           </td>
                                                           <td>
                                                               <input autocomplete="off" class="form-control" name="to_date[]" type="date" value="{{ $institute->to_date??'' }}">
                                                           </td>
                                                           <td>
                                                               <input class="form-control" name="institute_document[]" type="file" accept=".pdf,application/pdf">
                                                           </td>
                                                           <td>
                                                               <button type="button" class="btn btn-danger remove-empty_institute">
                                                                   <i class="fa fa-minus"></i>
                                                               </button>
                                                           </td>
                                                           <input type="hidden" name="institute_id[]">
                                                           <input type="hidden" name="institute_existdocument[]">
                                                        </tr>

                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                            <hr>
                                            <div class="row align-items-center head_label">
                                                <div class="col-12 col-md-12 ">
                                                    <label>(iii). Power Station to which he is aattached at present <span style="color: red;">*</span> <span class="text-label">(Upload the documents)</span></label>
                                                    <br>
                                                     <label for="tamil" class="tamil">தற்போது பணியாற்றும் மின்சார நிலையம் மற்றும் பயிற்சி பெற்ற காலம்<span style="color: red;">*</span>
                                                        <span class="text-label">(ஆவணங்களை பதிவேற்ற வேண்டும்)</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="work-table">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Power Station</th>
                                                            <th>Years of Experience (Years)</th>
                                                            <th>Designation</th>
                                                            <th class="text-center">Upload Document (Experience Certificate)
                                                                <br><span class="file-limit"> File type: PDF,PNG (Max
                                                                    200 KB)</span>
                                                            </th>
                                                            <th>
                                                                <button type="button" class="btn btn-primary add-more-work">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="work-container">
                                                        @if ($exp_details->isNotEmpty())
                                                        @foreach ($exp_details as $exp_details)
                                                        <tr class="work-fields text-center">
                                                            <td>
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>
                                                                <input autocomplete="off" class="form-control" name="work_level[]" type="text" value="{{ isset($exp_details->company_name) && !empty($exp_details->company_name) ? $exp_details->company_name : '' }}">
                                                            </td>
                                                            <td>
                                                                <input autocomplete="off" class="form-control" name="experience[]" type="number" value="{{ isset($exp_details->experience) && !empty($exp_details->experience) ? $exp_details->experience : '' }}">
                                                            </td>
                                                            <td>
                                                                <input autocomplete="off" class="form-control" name="designation[]" type="text" value="{{ isset($exp_details->designation) && !empty($exp_details->designation) ? $exp_details->designation : '' }}">
                                                            </td>
    
                                                            {{-- <td>
                                                                @if (isset($exp_details->upload_document) && $exp_details->upload_document)
                                                                        <a class="text-primary"
                                                                            href="{{ url(('public/'.$exp_details->upload_document) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file-pdf-o"
                                                                                style="color: red"></i> View </a><br>
                                                                @endif
                                                                <input class="form-control" name="work_document[]" type="file" accept=".pdf,application/pdf">
                                                            </td> --}}
                                                            <td>
                                                                @if (!empty($exp_details->upload_document))
                                                                    <div class="d-flex align-items-center file-section">
                                                                        <div>
                                                                            <a class="text-primary" href="{{ url('public/'.$exp_details->upload_document) }}" target="_blank">
                                                                                <i class="fa fa-file-pdf-o" style="color: red"></i> View
                                                                            </a>
                                                                        </div>
                                                                        <button class="btn btn-sm btn-danger ml-3 remove-doc_work">Remove</button>
                                                                    </div>
                                                                @else
                                                                    <input class="form-control" name="work_document[]" type="file" accept=".pdf,application/pdf">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger remove-work remove_exp" data-exp_id = "{{ $exp_details->id }}" data-url= "{{ route('delete_experience') }}">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </td>
                                                            <input type="hidden" name="work_id[]" value="{{ $exp_details->id ?? '' }}">
                                                            <input type="hidden" name="existing_work_document[]" value="{{ $exp_details->upload_document ?? '' }}">
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr class="work-fields text-center">
                                                            <td>1</td>
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
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </td>

                                                            <input type="hidden" name="work_id[]">
                                                            <input type="hidden" name="existing_work_document[]">
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center head_label">
                                                <div class="col-12 col-md-6">
                                                    <label>(iv). Name of the employer<span style="color: red;">*</span> <span class="text-label">(Upload the documents)</span></label>
                                                    <br>
                                                    <label for="tamil" class="tamil">தொழில் வழங்குநரின் பெயர்<span style="color: red;">*</span>
                                                        <span class="text-label">(ஆவணங்களை பதிவேற்ற வேண்டும்)</span></label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <textarea class="form-control" name="employer_name" id="employer_name" cols="5" rows="3">{{ isset($exp_details->company_name) && !empty($exp_details->company_name) ? $exp_details->company_name : '' }}</textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center" style=" {{ isset($application_details->form_name) && $application_details->form_name == 'S' ? 'display: flex;' : 'display: none;' }}">
                                                <div class="col-12 col-md-12 ">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-9 ">
                                                            <label for="Name">7. Have previously applied for Electrical Assistant Qualification Certificate and if yes then mention its number and date
                                                            </label>
                                                            <br>
                                                            <label for="tamil" class="tamil">இதற்கு முன்னாள் விண்ணப்பம் செய்துள்ளீர்களா ? ஆம் என்றால் அதன் குறிப்பு எண் மற்றும் தேதியை குறிப்பிடுக
                                                            </label>
                                                        </div>
    
                                                        <div class="col-md-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input toggle-details" type="radio" name="previous_license" id="previous_license_yes" data-target="#previously_details" value="yes" {{ !empty($application_details->previously_number) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="yesOption">Yes</label>
                                                            </div>
                                                              
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input toggle-details" type="radio" name="previous_license" id="previous_license_no" data-target="#previously_details" value="no" {{ empty($application_details->previously_number) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="noOption">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center" id="previously_details" style="display: {{ !empty($application_details->previously_number) ? 'flex' : 'none' }}; flex-wrap: wrap;">
    
                                                        <!-- License Number Label -->
                                                        <div class="col-12 col-md-2 text-md-right">
                                                            <label>License Number <span style="color: red;">*</span></label>
                                                        </div>
                                                    
                                                        <!-- License Number Input -->
                                                        <div class="col-12 col-md-3">
                                                            <input autocomplete="off" class="form-control text-box single-line verify-input"
                                                                   id="previously_number" name="previously_number" type="text"
                                                                   data-type="license" data-error="#licenseError" data-msg="#license_messagdfde"
                                                                   placeholder="License Number" {{ !empty($application_details->previously_number) ? 'readonly':'' }} value="{{ $application_details->previously_number }}">
                                                            <input type="hidden" id="l_verify" name="l_verify" value="{{ $application_details->license_verify }}">
                                                            <span id="licenseError" class="text-danger"></span>
                                                            <span id="verify_result"></span>
                                                            <span id="license_messagdfde" class="mt-1"></span>
                                                            <span class="mt-1 verify_status {{ $application_details->license_verify == 0 ? 'text-danger' : 'text-success' }}">
                                                                @if (!empty($application_details->previously_number))
                                                                    {!! $application_details->license_verify == 0 ? '&#128683; Invalid License.' : '&#10004; Valid License.' !!}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    
                                                        <!-- Date Label -->
                                                        <div class="col-12 col-md-1 text-md-right">
                                                            <label>Date <span style="color: red;">*</span></label>
                                                        </div>
                                                    
                                                        <!-- Date Input + Verify Button -->
                                                        <div class="col-12 col-md-6">
                                                            <div class="row g-2">
                                                                <div class="col-12 col-md-7">
                                                                    <input autocomplete="off" class="form-control text-box single-line verify-date"
                                                                           id="previously_date" name="previously_date" type="date"
                                                                           data-error="#dateError" {{ !empty($application_details->previously_number) ? 'readonly':'' }}  value="{{ $application_details->previously_date }}">
                                                                    <span id="dateError" class="text-danger"></span>
                                                                </div>
                                                                <div class="col-12 col-md-5">
                                                                    @if (!empty($application_details->previously_number))
                                                                        <button type="button" class="btn btn-danger remove_verify" data-type="superviser" style="margin-left: 10px;">Delete</button>
                                                                        <button type="button" class="btn btn-primary verify-btn btn-forms d-none" data-type="license" data-url="{{ route('verifylicense') }}" style="margin-left: 10px;">Verify</button>
                                                                    @else
                                                                        <button type="button" class="btn btn-primary verify-btn"
                                                                                data-type="license" data-url="{{ route('verifylicense') }}">
                                                                            Verify
                                                                        </button>
                                                                    @endif
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-12">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-md-9 ">
                                                            @if (isset($application_details->form_name) && $application_details->form_name == 'S')
                                                                @php
                                                                    $cert_name = 'Wireman Competency Certificate / Supervisor Competency Certificate';
                                                                @endphp

                                                            @else
                                                                @if (isset($application_details->form_name) && $application_details->form_name == 'WH')
                                                                    @php
                                                                    $cert_name = 'Wireman Helper Competency Certificate';
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $cert_name = 'Wireman Competency Certificate / Wireman Helper Competency Certificate';
                                                                    @endphp
                                                                @endif
                                                                
                                                            @endif
                                                            <label for="Name">{{ isset($application_details->form_name) && $application_details->form_name == 'S' ? '8':'7' }}. Do you possess {{ $cert_name }} issued by this Board? If so furnish the details and surrender the same.</label>
                                                            <br>
                                                            <label for="tamil" class="tamil">இந்த வாரியம் வழங்கிய கம்பி இணைப்பாளர் திறன் சான்றிதழ் / மேற்பார்வையாளர் திறன் சான்றிதழ் உங்களிடம் உள்ளதா? இருந்தால், அதன் விவரங்களை வழங்கி, அதனை ஒப்படைக்கவும்.</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input toggle-details" type="radio" name="previous_certificate" id="yesOption" data-target="#wireman_details" value="yes" {{ !empty($application_details->certificate_no) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="yesOption">Yes</label>
                                                            </div>
                                                                
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input toggle-details" type="radio" name="previous_certificate" id="noOption" data-target="#wireman_details" value="no" {{ empty($application_details->certificate_date) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="noOption">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3" id="wireman_details" style="display: {{ !empty($application_details->certificate_no) ? 'flex' : 'none' }}; flex-wrap: wrap;">
                                                        <div class="col-12 col-md-4 text-md-right">
                                                            <label>Certificate Number <span style="color: red;">*</span></label>
    
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            @php
                                                                if($application_details->form_name == 'S'){
                                                                    $cert_type = 'supervisor';
                                                                }else if($application_details->form_name == 'WH'){
                                                                    $cert_type = 'helper';
                                                                }else{
                                                                    $cert_type = 'certificate';
                                                                }

                                                            @endphp
                                                            <input class="form-control text-box single-line verify-input" id="certificate_no" name="certificate_no" type="text" data-type="{{ $cert_type }}" data-error="#certError" data-msg="#license_message" placeholder="Certificate No" maxlength="12" value="{{ $application_details->certificate_no }}" 
                                                            {{ !empty($application_details->certificate_no) ? 'readonly':'' }}>
                                                            <input type="hidden" id="cert_verify" name="cert_verify" value="{{ $application_details->cert_verify }}">
                                                            <span id="licenseError" class="text-danger"></span>
                                                            <span id="license_message" class="mt-1"></span>
                                                            <span id="verify_status" class="mt-1 {{ $application_details->cert_verify == 0 ? 'text-danger' : 'text-success' }}">
                                                                @if (!empty($application_details->certificate_no))
                                                                    {!! $application_details->cert_verify == 0 ? '&#128683; Invalid License.' : '&#10004; Valid License.' !!}
                                                                @endif
                                                            </span>
                                                            <span id="certError" class="text-danger"></span>
                                                        </div>
                                                        <div class="col-12 col-md-1 text-md-right">
                                                            <label>Date <span style="color: red;">*</span></label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <input class="form-control text-box single-line verify-date" id="certificate_date" name="certificate_date" data-error="#certDateError" type="date" value="{{ $application_details->certificate_date }}" {{ !empty($application_details->certificate_no) ? 'readonly':'' }}>
                                                            <span id="certDateError" class="text-danger"></span>
                                                        </div>
                                                        <div>
                                                            @if (!empty($application_details->certificate_no))
                                                                <button type="button" class="btn btn-danger remove_verify" data-type="superviser_two" style="margin-left: 10px;">Delete</button>
                                                                <button type="button" class="btn btn-primary verify-btn d-none" data-type="certificate" data-url="{{ route('verifylicense') }}" style="margin-left: 10px;">Verify</button>
                                                            @else
                                                                <button type="button" class="btn btn-primary verify-btn" data-type="certificate" data-url="{{ route('verifylicense') }}" style="margin-left: 10px;">Verify</button>
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
                                                            <label for="Name">{{ isset($application_details->form_name) && in_array($application_details->form_name, ['WH','W']) ? $sno = '8' : $sno = '9'  }}. (i) Upload Passport Size Photo <span
                                                                    style="color: red;">*</span></label>
                                                            <br>
                                                            <label for="tamil" class="tamil">பாஸ்போர்ட் அளவு
                                                                புகைப்படம் பதிவேற்ற</label>
                                                        </div>
                                                        <div
                                                            class="col-12 col-md-6 d-flex flex-column align-items-center text-center">
                                                            @if ( !empty($applicant_photo->upload_path))
                                                                <img src="{{ url($applicant_photo->upload_path) }}"
                                                                    id="preview_applicant"
                                                                    class="img-fluid border mb-2"
                                                                    style="max-width: 100px;" alt="Applicant Photo">
                                                                    <button type="button" class="btn btn-primary btn-sm mb-2" onclick="togglePhotoInput()">Edit/Upload Photo</button>
                                                            @endif

                                                            <div id="photo-input-wrapper" style="{{ !empty($applicant_photo->upload_path) ? 'display: none;' : 'display: block;' }}; width: 100%; max-width: 300px;">
                                                                <span class="file-limit"> File type: JPG, PNG (Max 50
                                                                    KB) </span>
                                                                <input autocomplete="off" class="form-control text-box single-line mb-1" id="upload_photo" name="upload_photo" type="file" accept="image/*">
                                                                <span class="error-message text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <table class="table">
                                                        <tr>
                                                            <td>(ii)</td>
                                                            @php

                                                                $decryptedaadhar = !empty($application_details->aadhaar)
                                                                    ? Crypt::decryptString($application_details->aadhaar)
                                                                    : null;


                                                                $decryptedpan = !empty($application_details->pancard)
                                                                    ? Crypt::decryptString($application_details->pancard)
                                                                    : null;

                                                            @endphp
                                                            <td>
                                                                <label for="Name">Aadhaar Number <span style="color: red;">*</span></label>
                                                                <br>
                                                                <label for="tamil" class="tamil">ஆதார் எண்</label>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control text-box" name="aadhaar" id="aadhaar" maxlength="14" value="{{ $decryptedaadhar }}">
                                                                <span id="aadhaar-error" class="text-danger"></span>
                                                            </td>
                                                            <td>
                                                                <label for="Name">(iii) Upload Aadhaar Document <span style="color: red;">*</span></label>
                                                                <br>
                                                                <label for="tamil" class="tamil">ஆதார் ஆவணத்தை பதிவேற்றவும் <span style="color: red;">*</span></label>
                                                            </td>
                                                            <td>
                                                                @if (!empty($application_details->aadhaar_doc))
                                                                    <div class="aadhaar-doc-container">
                                                                        <a href="{{ route('document.show', ['type' => 'aadhaar', 'filename' => $application_details->aadhaar_doc]) }}" target="_blank" style="color: #007bff;">
                                                                            <i class="fa fa-file-pdf-o" style="color: red;"></i> View
                                                                        </a>
                                                                        <button type="button" class="btn btn-sm btn-danger ml-3 remove-docs">Remove</button>
                                                                    </div>
                                                                @endif
                                                                    <div class="aadhaar-doc-input {{ !empty($application_details->aadhaar_doc) ? 'd-none' : '' }}">
                                                                        <input autocomplete="off" class="form-control text-box single-line" id="aadhaar_doc" name="aadhaar_doc" type="file" accept=".pdf,application/pdf">
                                                                        <span class="file-limit"> File type: PDF (Max 250 KB) </span>
                                                                        <small class="text-danger file-error"></small>
                                                                    </div>

                                                                    <input type="hidden" name="aadhaar_doc_removed" id="aadhaar_doc_removed" value="0">
                                                                
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
                                                                <input type="text" class="form-control text-box " name="pancard" id="pancard" value="{{ $decryptedpan }}">
                                                                <p id="pancard-error" class="text-danger"></p>
                                                            </td>
                                                            <td>
                                                                <label for="Name">(v) Upload Pan Card Document <span style="color: red;">*</span></label>
                                                                <br>
                                                                <label for="tamil" class="tamil">பான் கார்டு ஆவணத்தைப் பதிவேற்றவும் </label>
                                                            </td>
                                                            <td>
                                                                @if (!empty($application_details->pan_doc))
                                                                    <div class="pan-doc-container">
                                                                        <a href="{{ route('document.show', ['type' => 'pan', 'filename' => $application_details->pan_doc]) }}" target="_blank" style="color: #007bff;"><i class="fa fa-file-pdf-o" style="color: red;"></i> View</a>
                                                                        <button class="btn btn-sm btn-danger ml-3 remove-doc-pan">Remove</button>
                                                                    </div>
                                                                @endif
                                                                <div class="pan-doc-input {{ !empty($application_details->pan_doc) ? 'd-none' : '' }}">
                                                                    <input autocomplete="off" class="form-control text-box single-line" id="pancard_doc" name="pancard_doc" type="file" accept=".pdf,application/pdf">
                                                                    <span class="file-limit"> File type: PDF (Max 250 KB) </span><br>
                                                                    <p class="text-danger file-error"></p>
                                                                </div>

                                                                <input type="hidden" name="pan_doc_removed" id="pan_doc_removed" value="0">
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
                                                        <input type="checkbox" id="declarationCheckbox" required>
                                                        <span class="checkmark"></span>
                                                        <div>
                                                            I hereby declare that all the details mentioned above are
                                                            correct and true to the best of my knowledge. I request you
                                                            to issue me the qualification certificate. <span style="color: red;">*</span><br>
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
                                            <input type="hidden" class="form-control text-box single-line" id="login_id_store" name="login_id" value="{{ Auth::user()->login_id }}">
                                            <input type="hidden" id="application_id" name="application_id" value="{{ isset($application_details) ? $application_details->application_id : '' }}">
                                            <input type="hidden" id="license_number" name="license_number" value="{{ isset($license_details) ? $license_details->license_number : '' }}">
                                            <input type="hidden" id="form_name" name="form_name" value="{{ isset($application_details) ? $application_details->form_name : '' }}">
                                            <input type="hidden" id="license_name" name="license_name" value="{{ isset($application_details) ? $application_details->license_name : '' }}">
                                            <input type="hidden" id="form_id" name="form_id" value="{{ isset($application_details) ? $application_details->form_id : '' }}">
                                            {{-- <input type="hidden" id="amount" name="amount" value="{{ $fees_details->fees }}"> --}}
                                            <input type="hidden" id="appl_type" name="appl_type" value="N">
                                            {{-- <input type="hidden" id="form_action" name="form_action" value="{{ isset($application_details) ? $application_details->payment_status : '' }}"> --}}

                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 mt-5">
                                        <div class="form-group text-center">
                                            <button type="button" class="btn btn-success" id="DraftBtn" data-url="{{ route('form.draft_submit') }}">Save As Draft
                                                </button>
                                            <button type="button" class="btn btn-primary"
                                                id="ProceedtoPayment">Save and Proceed for Payment</button>
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
    $(document).on('click', function(e) {
        let container = document.getElementById("education-container");
        let educationRows = container.querySelectorAll(".education-fields");

        if (e.target.closest(".add-more-education")) {

            if (educationRows.length >= 5) {
                $('#education-table').next('.education-error').remove();

                $('<div class="text-danger mt-2 education-error">You can add a maximum of 5 education entries.</div>')
                .insertAfter('#education-table');

                setTimeout(() => {
                    $('.education-error').fadeOut();
                }, 7000);
                // alert("You can add a maximum of 5 education entries.");
                return;
            }

            let currentYear = new Date().getFullYear();
            let yearOptions = '<option value="">Select Year</option>';
            for (let year = currentYear; year >= 1980; year--) {
                yearOptions += `<option value="${year}">${year}</option>`;
            }

            // calculate next serial number
            let serialNo = $('#education-container .education-fields').length + 1;

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
                    <input type="file" class="form-control education-file" accept=".pdf,.png,.jpg,.jpeg" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-education">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
                <input type="hidden" name="edu_id[]" value="">
                <input type="hidden" name="existing_document[]" value="">
            </tr> `;
            $('#education-container').append(newRow);

            $("#education-container .education-fields").each(function (index) {
                $(this).find(".education-file").attr("name", `education_document[${index}]`);
            });

        }

        if (e.target.closest(".remove-education")) {
            // if (educationRows.length <= 1) {

            //     $('#education-table').next('.education-error').remove();

            //     $('<div class="text-danger mt-2 education-error">You must have at least one education entry.</div>')
            //     .insertAfter('#education-table');

            //     setTimeout(() => {
            //         $('.education-error').fadeOut();
            //     }, 7000);

            //     // alert("You must have at least one education entry.");
            //     return;
            // }
            e.target.closest("tr").remove();
        }
    });


    // Remove education row
    // $(document).on('click', '.remove-education', function() {
    //     $(this).closest('tr').remove();
    // });

    // Add more work row
    $(document).on('click', function(e) {

        let container = document.getElementById("work-container");
        let workRows = container.querySelectorAll(".work-fields");

        if (e.target.closest(".add-more-work")) {

            if (workRows.length >= 3) {

                $('#work-table').next('.work-error').remove();

                $('<div class="text-danger mt-2 work-error">You can add a maximum of 3 work experience entries.</div>')
                .insertAfter('#work-table');

                setTimeout(() => {
                    $('.work-error').fadeOut();
                }, 7000);

                // alert("You can add a maximum of 3 work experience entries.");
                return;
            }

            let serialNo = $('#work-container .work-fields').length + 1;
            let newRowIndex = serialNo - 1;
            let newRow = `
                    <tr class="work-fields text-center">
                        <td>${serialNo}</td>
                        <td><input type="text" class="form-control" name="work_level[]"></td>
                        <td><input type="number" step="0.1" class="form-control" name="experience[]" min="0" max="50"></td>
                        <td><input type="text" class="form-control" name="designation[]"></td>
                        <td class="text-center">
                            <input type="file" class="form-control" name="work_document[${newRowIndex}]" accept=".pdf,.png,.jpg,.jpeg">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger remove-work">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                        <input type="hidden" name="work_id[]">
                        <input type="hidden" name="existing_work_document[]">
                    </tr>
                `;
            $('#work-container').append(newRow);

            $('#work-container .work-fields').each(function (index) {
                $(this).find('.work-file').attr('name', `work_document[${index}]`);
            });
        }

            if (e.target.closest(".remove-work")) {
                // if (workRows.length <= 1) {

                //     $('#work-table').next('.work-error').remove();

                //     $('<div class="text-danger mt-2 work-error">You must have at least one work experience entry.</div>')
                //     .insertAfter('#work-table');

                //     setTimeout(() => {
                //         $('.work-error').fadeOut();
                //     }, 7000);

                    
                //     // alert("You must have at least one work experience entry.");
                //     return;
                // }
                e.target.closest("tr").remove();

            }



    });

    // Remove work row
    // $(document).on('click', '.remove-work', function() {
    //     $(this).closest('tr').remove();
    // });

    $(document).on('click', function(e) {

        let container = document.getElementById("institute-container");
        let workRows = container.querySelectorAll(".institute-fields");

        if (e.target.closest(".add-more-institute")) {


            if (workRows.length >= 2) {

                $('#institute-table').next('.institute-error').remove();

                $('<div class="text-danger mt-2 institute-error">You can add a maximum of 2 Institute entries.</div>')
                .insertAfter('#institute-table');

                setTimeout(() => {
                    $('.institute-error').fadeOut();
                }, 7000);

                return;
            }

            let serialNo = $('#institute-container .institute-fields').length + 1;
            let newRowIndex = serialNo - 1;
            let newRow = `
                    <tr class="institute-fields text-center">
                        <td>${serialNo}</td>
                        <td><textarea autocomplete="off" class="form-control" name="institute_name_address[]" id="institute_name_address[]" cols="5" rows="3"></textarea></td>
                        <td><input type="number" step="0.1" class="form-control" name="duration[]" min="0" max="50"></td>
                        <td><input type="date" class="form-control" name="from_date[]"></td>
                        <td><input type="date" class="form-control" name="to_date[]"></td>
                        <td class="text-center">
                            <input type="file" class="form-control" name="institute_document[${newRowIndex}]" accept=".pdf,.png,.jpg,.jpeg">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger remove-inst-row">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                        <input type="hidden" name="institute_id[]">
                        <input type="hidden" name="institute_document[]">
                    </tr>
                `;
            $('#institute-container').append(newRow);

            $('#institute-container .institute-fields').each(function (index) {
                $(this).find('.institute-file').attr('name', `institute_document[${index}]`);
            });
        }

        if (e.target.closest(".remove-inst-row")) {
            e.target.closest("tr").remove();

        }



    });

    
</script>
</body>

</html>
