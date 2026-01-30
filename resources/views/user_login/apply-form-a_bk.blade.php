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

    .swal2-popup li ul{
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
            <li><a href="{{ route('dashboard')}}"><span class="fa fa-home"> </span> Dashboard</a></li>
            <li><a href="#"><span class=" fa fa-info-circle"> </span> Form A</a></li>

        </ul>
    </div>
</section>


<section class="tabs-section apply-card">
    <div class="container">
        <div class="apply-card-header" style="background-color: #70c6ef  !important;">
            <div class="row">
                <div class="col-6 col-lg-8">
                    <h5 class="card-title_apply text-black text-left"> <span style="font-weight: 600;">New Application for Electrical Contractor's Licence-Grade `A' </span></h5>
                    <h6 class="card-title_apply text-black text-left">(Read the Instructions overleaf before filling the form)</h6>
                </div>

                <div class="col-6 col-lg-4 text-md-right">
                    <span style="color: #000;"> <i class="fa fa-file-pdf-o" style="color: red;"></i>&nbsp; Enclosures Download 38 KB</span>
                    <br>
                    <a href="{{url('assets/pdf/form_a_notes.pdf')}}" class="text-dark" target="_blank">English | தமிழ்</a>

                </div>

                <div class="col-6 col-lg-12">


                </div>

            </div>
        </div>

        <form id="competency_form_a" enctype="multipart/form-data">

            @csrf
                <input type="hidden" class="form-control text-box single-line" id="login_id_store" name="login_id_store" value="{{ Auth::user()->login_id }}">
                <input type="hidden" class="form-control text-box single-line" id="form_name" name="form_name" value="A">
                <input type="hidden" class="form-control text-box single-line" id="license_name" name="license_name" value="EA">
    
                <input type="hidden" class="form-control text-box single-line" id="form_id" name="form_id" value="5">
                <input type="hidden" class="form-control text-box single-line" id="amount" name="amount" value="20000">
                <div class="tabs" id="tabbedForm">
                    <div class="row">
                        <div class="col-12 col-md-12 text-md-right">
                            <p style="color: #023466;font-weight:600;"> <span style="color: red;">*</span> Fileds are Mandatory </p>
                        </div>
    
                    </div>
    
                    <nav class="tab-nav"></nav>
    
                    <div class="tab" data-name="Basic Details">
    
                        <div class="row">
    
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-12">
                                        <label for="Name">1. Name in which Electrical Contractor's licence is applied for <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-12">
    
    
                                        <input autocomplete="off" class="form-control text-box single-line" id="applicant_name" name="applicant_name" type="text" value="">
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
                                        <textarea rows="2" class="form-control" name="business_address"></textarea>
                                        <span class="error text-danger" id="business_address_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
    
    
    
    
                        <div class=" border box-shadow-blue p-3 mt-3">
                            <div class="row mt-3">
    
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-12">
                                            <label for="Name">3.(i) Full name and house address of proprietor or partners or Directors <span style="color: red;">*</span><br><span class="text-label" style="color: #023466;">(If it is partnership concern, partnership deed should be enclosed)</span></label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <!-- <textarea rows="3" class="form-control" name="proprietor_name"></textarea> -->
                                            <input type="text" class="form-control mb-2" name="proprietor_name[]" placeholder="Name">
    
                                            <span class="error text-danger" id="proprietor_name_error"></span>
                                        </div>
                                        <div class="col-12 col-md-6">
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
                                            <input type="number" class="form-control" id="age" name="age[]" placeholder="Age" value="">
                                            <span class="error text-danger" id="age_error"></span>
                                        </div>
                                        <div class="col-12 col-md-6">
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
                                            <input type="text" class="form-control" id="fathers_name" name="fathers_name[]" value="">
                                            <span class="error text-danger" id="fathers_name_error"></span>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-12">
                                            <label for="Name">(iv) Present business of the applicant</label>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <input type="text" class="form-control" id="present_business" name="present_business[]" value="">
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
                                            <span class="error text-danger" id="competency_certificate_holding_error"></span>
                                        </div>
    
                                        <!-- Hidden by default -->
                                        <div class="col-12 col-md-12 mt-1  competency-fields" style="display: none;">
                                            <input type="text" class="form-control mt-2" name="competency_certificate_number[]" placeholder="Certificate Number">
                                        </div>
                                        <div class="col-12 col-md-12 mt-1 competency-fields" style="display: none;">
                                            <input type="text" class="form-control" id="competency_certificate_validity[]" onfocus="setDateRestrictions(this)" name="competency_certificate_validity[]"
                                                placeholder="Validity"
                                                onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
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
    
                                        <div class="col-12 col-md-12 mt-1 employment-fields" style="display: none;">
                                            <input type="text" class="form-control" id="presently_employed_name" name="presently_employed_name[]" placeholder="Name">
                                        </div>
                                        <div class="col-12 col-md-12 mt-1  employment-fields" style="display: none;">
                                            <textarea class="form-control" name="presently_employed_address[]" placeholder="Address"></textarea>
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
                                                <div class="col-12 col-md-12 mt-1">
                                                    <input class="form-control" type="text" id="previous_experience_name" name="previous_experience_name[]" placeholder="Name">
                                                </div>
                                                <div class="col-12 col-md-12 mt-1">
                                                    <textarea class="form-control" id="previous_experience_address" name="previous_experience_address[]" placeholder="Address"></textarea>
                                                </div>
                                                <div class="col-12 col-md-12 mt-1">
                                                    <input class="form-control" type="text" id="previous_experience_lnumber" name="previous_experience_lnumber[]" placeholder="License Number">
                                                </div>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                        <div class=" mt-4 ">
                            <!-- <h3>Proprietor/Partner Details</h3> -->
                            <div class="col-12 col-md-12 text-md-right">
                                <button id="add-more-proprietor" class="btn btn-primary text-md-right"><i class="fa fa-plus"></i> Add Proprietor /Partner</button>
                            </div>
                            <div id="proprietor-container"></div>
                        </div>
    
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-12">
                                        <label for="Name">4. Name and designation of authorised
                                            signatory if any in the case of limited
                                            company. <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-12">
    
                                        <input style="display:none;" class="form-check-input" type="radio" id="authorised_name_designation" name="authorised_name_designation" value="yes" onclick="toggleAuthorisedFields(true)">
                                        <!-- <label class="form-check-label" for="authorised_name_designation">Yes</label> -->
    
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="authorised_yes" name="authorised_name_designation" value="yes" onclick="toggleAuthorisedFields(true)">
                                            <label class="form-check-label" for="authorised_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="authorised_no" name="authorised_name_designation" value="yes" onclick="toggleAuthorisedFields(false)">
                                            <label class="form-check-label" for="authorised_no">No</label>
                                        </div>
                                        <span class="error text-danger" id="authorised_name_designation_error"></span>
                                    </div>
    
    
    
                                    <!-- Hidden by default -->
                                    <div class="col-12 col-md-12  authorised-fields" style="display: none;">
                                        <div class="row">
    
                                            <div class="col-12 col-md-6">
                                                <input class="form-control" type="text" id="authorised_name" name="authorised_name" placeholder="Name">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <input class="form-control" type="text" id="authorised_designation" name="authorised_designation" placeholder="Designation">
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
                                    <div class="col-12 col-md-12">
    
                                        <input style="display:none;" class="form-check-input" type="radio" id="previous_contractor_license" name="previous_contractor_license" value="yes" onclick="togglePreviousLicenseFields(true)">
    
    
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="previous_contractor_license" name="previous_contractor_license" value="yes" onclick="togglePreviousLicenseFields(true)">
                                            <label class="form-check-label" for="previous_contractor_license">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="previous_contractor_license" name="previous_contractor_license" value="no" onclick="togglePreviousLicenseFields(false)">
                                            <label class="form-check-label" for="previous_contractor_license">No</label>
                                        </div>
                                        <span class="error text-danger" id="previous_contractor_license_error"></span>
                                    </div>
    
                                    <!-- Hidden by default -->
                                    <div class="col-12 col-md-6  previous-license-fields" style="display: none;">
                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <input class="form-control" type="text" id="previous_application_number" name="previous_application_number" placeholder="Previous License Number">
                                            </div>
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
                                    <div class="col-12 col-md-12 ">
                                        <label>6. Details of Staff appointed on full time basis: <span style="color: red;">*</span></label>
    
    
                                    </div>
    
                                </div>
    
    
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="staff-table">
                                        <thead>
                                            <tr>
                                                <th>S.NO</th>
                                                <th>Name of Person</th>
                                                <th>Qualification</th>
                                                <th colspan="2">Competency Certificate Number and Validity</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="staff-container">
                                            <tr class="staff-fields">
                                                <td>1</td>
                                                <td><input type="text" name="staff_name[]" class="form-control">
                                                    <span class="error text-danger"></span>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="staff_qualification[]">
                                                        <option selected disabled>Qualification</option>
                                                        <option value="PG">PG</option>
                                                        <option value="UG">UG</option>
                                                        <option value="Diploma">Diploma</option>
                                                        <option value="+2">+2</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                    <span class="error text-danger"></span>
                                                </td>
                                                <td><input type="text" class="form-control" name="cc_number[]" placeholder="Certificate No">
                                                    <span class="error text-danger"></span>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="cc_validity[]" placeholder="Validity"
                                                        onfocus="this.type='date'" onblur="this.type='text'">
                                                    <span class="error text-danger"></span>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="staff_category[]">
                                                        <option selected disabled>Select Category</option>
                                                        <option value="QC">QC</option>
                                                        <option value="BC">BC</option>
                                                        <option value="B">B</option>
                                                    </select>
                                                    <span class="error text-danger"></span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary add-more"><i class="fa fa-plus"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
    
                                <!-- <script>
                                    document.addEventListener("click", function(e) {
                                        let container = document.getElementById("staff-container");
                                        let staffRows = container.querySelectorAll(".staff-fields");
    
                                        // ✅ Add new row (Max limit: 4)
                                        if (e.target.closest(".add-more")) {
                                            if (staffRows.length >= 4) {
                                                alert("You can add a maximum of 4 staff entries.");
                                                return;
                                            }
    
                                            let newRow = document.createElement("tr");
                                            newRow.classList.add("staff-fields");
                                            newRow.innerHTML = `
        <td>${staffRows.length + 1}</td>
        <td><input type="text" name="staff_name[]" class="form-control"></td>
        <td>
            <select class="form-control" name="staff_qualification[]">
                <option selected disabled>Qualification</option>
                <option value="PG">PG</option>
                <option value="UG">UG</option>
                <option value="Diploma">Diploma</option>
                <option value="+2">+2</option>
                <option value="10">10</option>
            </select>
        </td>
        <td><input type="text" class="form-control" name="cc_number[]" placeholder="Competency Certificate Number"></td>
        <td>
            <input type="text" class="form-control" name="cc_validity[]" placeholder="Validity"
                onfocus="(this.type='date')" onblur="(this.type='text')">
        </td>
        <td>
            <button type="button" class="btn btn-danger remove-staff">
                <i class="fa fa-trash-o"></i>
            </button>
        </td>
    `;
    
                                            container.appendChild(newRow);
                                        }
    
                                        // ✅ Remove row functionality (Min: 1)
                                        if (e.target.closest(".remove-staff")) {
                                            if (staffRows.length <= 1) {
                                                alert("At least one staff entry is required.");
                                                return;
                                            }
                                            e.target.closest("tr").remove();
    
                                            // ✅ Update S.NO after removal
                                            container.querySelectorAll(".staff-fields").forEach((row, index) => {
                                                row.children[0].textContent = index + 1;
                                            });
                                        }
                                    });
                                </script> -->
    
                            </div>
    
                        </div>
    
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row align-items-center head_label">
                                    <div class="col-12 col-md-12 ">
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
                                                <textarea class="form-control" name="bank_address"></textarea>
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
                                                <input type="text" class="form-control" name="bank_validity" placeholder="Validity"
                                                    onfocus="setDateRestrictions(this)" onblur="validateDate(this)">
                                                <span class="error text-danger" id="bank_validity_error"></span>
                                            </div>
    
                                        </div>
                                    </div>
    
                                    <div class="col-md-4">
    
    
    
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="comments">(iii). Amount Rs <span style="color: red;">*</span></label>
                                            </div>
    
                                            <div class="col-12 col-md-12">
                                                <input type="number" class="form-control" id="bank_amount" name="bank_amount" value="">
                                                <span class="error text-danger" id="bank_amount_error"></span>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
    
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-7">
                                                <label for="Name">8. Has the applicant or any of his/her
                                                    staff referred to under item 6, been at
                                                    any time convicted in any court of law
                                                    or punished by any other authority for
                                                    criminal offences <span style="color: red;">*</span>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-5">
    
                                                <input style="display: none;" class="form-check-input" type="radio" id="criminal_offence_yes" name="criminal_offence" value="yes">
    
    
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="criminal_offence_yes" name="criminal_offence" value="yes">
                                                    <label class="form-check-label" for="criminal_offence_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="criminal_offence_no" name="criminal_offence" value="no">
                                                    <label class="form-check-label" for="criminal_offence_yes">No</label>
                                                </div>
                                                <span class="error text-danger" id="criminal_offence_error"></span>
                                            </div>
    
    
    
                                        </div>
                                    </div>
    
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">9. (i) Whether consent letter, of the
                                                    competency certificate holder are
                                                    enclosed. (including for self) <span style="color: red;">*</span>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <input style="display: none;" class="form-check-input" type="radio" id="consent_letter_enclose" name="consent_letter_enclose" value="yes">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="consent_letter_enclose" name="consent_letter_enclose" value="yes">
                                                    <label class="form-check-label" for="consent_letter">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="consent_letter_enclose" name="consent_letter_enclose" value="no">
                                                    <label class="form-check-label" for="consent_letter_enclose">No</label>
                                                </div>
                                                <span class="error text-danger" id="consent_letter_enclose_error"></span>
                                            </div>
    
    
    
                                        </div>
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(ii) Whether original booklet of
                                                    competency certificate holders are
                                                    enclosed? (including for self) <span style="color: red;">*</span>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <input style="display: none;" class="form-check-input" type="radio" id="cc_holders_enclosed" name="cc_holders_enclosed" value="yes">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="cc_holders_enclosed" name="cc_holders_enclosed" value="yes">
                                                    <label class="form-check-label" for="cc_enclosed">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="cc_holders_enclosed" name="cc_holders_enclosed" value="no">
                                                    <label class="form-check-label" for="cc_enclosed">No</label>
                                                </div>
                                                <span class="error text-danger" id="cc_holders_enclosed_error"></span>
                                            </div>
    
    
    
                                        </div>
                                    </div>
    
    
                                </div>
                                <hr>
                                <!-- ------------------------------------------------------- -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">10. (i)Whether purchase bill for all the
                                                    instruments are enclosed in Original <span style="color: red;">*</span>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <input style="display: none;" class="form-check-input" type="radio" id="purchase_bill_enclose" name="purchase_bill_enclose" value="yes">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="purchase_bill_enclose" name="purchase_bill_enclose" value="yes">
                                                    <label class="form-check-label" for="purchase_bill_enclose">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="purchase_bill_enclose" name="purchase_bill_enclose" value="no">
                                                    <label class="form-check-label" for="purchase_bill_enclose">No</label>
                                                </div>
                                                <span class="error text-danger" id="purchase_bill_enclose_error"></span>
                                            </div>
    
    
    
                                        </div>
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(ii) Whether the test reports for
                                                    instruments and deeds for possess
                                                    of the instruments are enclosed in
                                                    original? <span style="color: red;">*</span>
    
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <input style="display: none;" class="form-check-input" type="radio" id="test_reports_enclose" name="test_reports_enclose" value="yes">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="test_reports_enclose" name="test_reports_enclose" value="yes">
                                                    <label class="form-check-label" for="test_reports">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="test_reports_enclose" name="test_reports_enclose" value="no">
                                                    <label class="form-check-label" for="test_reports">No</label>
                                                </div>
                                                <span class="error text-danger" id="test_reports_enclose_error"></span>
                                            </div>
    
    
    
                                        </div>
                                    </div>
    
    
                                </div>
    
                                <hr>
    
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row align-items-center border-right-12">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">11. (i) Whether specimen signature of
                                                    the Proprietor or of the authorised
                                                    signatory (in case of limited
                                                    company in triplicate is enclosed) <span style="color: red;">*</span>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-6 ">
                                                <input style="display: none;" class="form-check-input" type="radio" id="specimen_signature_enclose" name="specimen_signature_enclose" value="yes">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="specimen_signature_enclose" name="specimen_signature_enclose" value="yes">
                                                    <label class="form-check-label" for="specimen_signature">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="specimen_signature_enclose" name="specimen_signature_enclose" value="no">
                                                    <label class="form-check-label" for="specimen_signature">No</label>
                                                </div>
    
                                            </div>
                                            <span class="error text-danger" id="specimen_signature_enclose_error"></span>
    
    
                                        </div>
                                    </div>
    
                                    <div class="col-md-4">
                                        <div class="row align-items-center border-right-12">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(ii) The name of the person/persons
                                                    whom the applicant has
                                                    authorised to sign if any, on his/their behalf in case of Proprietor or Partnership concern
    
                                                </label>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-7">
                                                    <input type="text" class="form-control authority-name" name="name_of_authorised_to_sign[]" placeholder="Name of Authority">
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <button type="button" id="add-more-authority-name" class="btn btn-primary"><i class="fa fa-plus"></i> Add More</button>
                                                </div>
                                            </div>
                                            <div id="authority-name-container"></div>
    
    
    
                                        </div>
                                    </div>
    
                                    <div class="col-md-4">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-12">
                                                <label for="Name">(iii) Whether the applicant enclosed
                                                    the specimen signature of the
                                                    above person/ persons in triplicate
                                                    in a separate sheet of paper <span style="color: red;">*</span>
    
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-12 ">
                                                <input style="display: none;" class="form-check-input" type="radio" id="separate_sheet" name="separate_sheet" value="yes">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="separate_sheet" name="separate_sheet" value="yes">
                                                    <label class="form-check-label" for="separate_sheet">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="separate_sheet" name="separate_sheet" value="no">
                                                    <label class="form-check-label" for="separate_sheet">No</label>
                                                </div>
                                                <span class="error text-danger" id="separate_sheet_error"></span>
                                            </div>
    
    
    
                                        </div>
                                    </div>
    
    
                                </div>
                                <hr>
                                <div class="row">
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
    
                        <div class="row">
                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(ii) Aadhaar Number
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">ஆதார் எண்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control text-box " name="aadhaar" id="aadhaar">
                                        <span class="error text-danger" id="aadhaar_error"></span>
                                    </div>
                                </div>
                            </div>
    
    
    
                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(iii) Upload Aadhaar Document
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">ஆதார் ஆவணத்தை பதிவேற்றவும்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input autocomplete="off" class="form-control text-box single-line" id="aadhaar_doc" name="aadhaar_doc" type="file" value="">
                                        <span class="file-limit"> File type: PDF (Max 250 KB) </span>
                                    </div>
                                    <span class="error text-danger" id="aadhaar_doc_error"></span>
                                </div>
                            </div>
    
                        </div>
                        <hr>
    
                        <div class="row">
                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(iv) Pan Card Number
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">ஆதார் எண்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control text-box " name="pancard" id="pancard">
                                        <span class="error text-danger" id="pancard_error"></span>
                                    </div>
                                </div>
                            </div>
    
    
    
                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(v) Upload Pan Card Document
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">பான் கார்டு ஆவணத்தைப் பதிவேற்றவும்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input autocomplete="off" class="form-control text-box single-line" id="pancard_doc" name="pancard_doc" type="file" value="">
                                        <span class="file-limit"> File type: PDF (Max 250 KB) </span>
                                    </div>
                                    <span class="error text-danger" id="pancard_doc_error"></span>
                                </div>
                            </div>
    
                        </div>
                        <hr>
    
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(vi) GST Number
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">ஜிஎஸ்டி எண்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control text-box " name="gst_number" id="gst_number">
                                        <span class="error text-danger" id="gst_number_error"></span>
                                    </div>
                                    
                                </div>
                            </div>
    
    
    
                            <div class="col-12 col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 ">
                                        <label for="Name">(vii) Upload GST Document
                                        </label>
                                        <br>
                                        <label for="tamil" class="tamil">ஜிஎஸ்டி ஆவணத்தைப் பதிவேற்றவும்
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input autocomplete="off" class="form-control text-box single-line" id="gst_doc" name="gst_doc" type="file" value="">
                                        <span class="file-limit"> File type: PDF (Max 250 KB) </span>
                                    </div>
                                    <span class="error text-danger" id="gst_doc_error"></span>
                                </div>
                            </div>
    
                        </div>
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <h6 style="color: #023466;">Declaration</h6>
                                    </div>
    
                                </div>
                                <label class="container mt-2">
                                    <div class="declaration-container">
                                        <input type="checkbox" id="declarationCheckbox" name="declaration1" value="1">
                                        <span class="checkmark"></span>
                                        <div>
                                            I/We hereby declare that the particulars stated above are correct to the best of my/our knowledge and belief.
                                        </div>
                                    </div>
                                    <span class="error text-danger" id="declaration1_error"></span>
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
                                    <span class="error text-danger" id="declaration2_error"></span>
                                    <!-- <p id="declaration2_error" class="error text-danger" style="display: none;">
                                    ⚠ Please check the declaration box before proceeding.
                                </p> -->
                                </label>
    
    
                                <div class="row enclosures">
                                    <div class="col-12 col-md-12">
                                        <h6>Enclosures :</h6>
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
    
    
                </div>
    
    
                <nav class="tab-pag"></nav>
        </div>
    
        </form>
    </div>
</section>


<!-- JavaScript -->



<footer class="main-footer">
    @include('include.footer')
    <script>
        document.getElementById('saveDraftBtn').addEventListener('click', function() {
            document.getElementById('draftModal').style.display = 'flex';
        });
    
        function closeDraftModal() {
            document.getElementById('draftModal').style.display = 'none';
        }
    </script>

    <script>
        // Function to show the draft saved popup

        // Attach event listener to the "Save As Draft" button
        // document.querySelector('.btn-primary').addEventListener('click', function(event) {
        //     event.preventDefault(); // Prevent form submission
        //     showDraftPopup(); // Show the popup
        // });
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

                // Save as Draft button
                list.saveDraft = document.createElement('button');
                list.saveDraft.className = 'pag-item btn btn-info text-white';
                list.saveDraft.innerHTML = 'Save as Draft';

                list.saveDraft.type = 'submit';
                // list.saveDraft.onclick = this.saveDraft.bind(this);

                list.submit = document.createElement('button');
                list.submit.className = 'pag-item btn btn-success text-white';
                list.submit.type = 'submit';
                list.submit.innerHTML = 'Proceed Payment';

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

    <script>
        let proprietorCount = 1;
        const maxProprietors = 4;

        function getProprietorFields(index) {
            return `
            <div class="proprietor-block border p-3 mt-3" id="proprietor-${index}">
                <h5>3.Proprietor/Partner Details ${index }</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label>(i) Full name and house address of proprietor or partners or Directors <span style="color: red;">*</span></label>
                   <input type="text" class="form-control mb-2" name="proprietor_name[]" placeholder="Name">

                         <textarea rows="3" class="form-control" name="proprietor_address[]" placeholder="Address"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>(ii)Age and qualification along with evidence <span style="color: red;">*</span></label>
                                          <input type="number" class="form-control mb-2 age-input" name="age[]" placeholder="Age">
                    <input type="text" class="form-control" name="qualification[]" placeholder="Qualification">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>(iii) Father/Husband's name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="fathers_name[]">
                    </div>
                    <div class="col-md-6">
                        <label>(iv) Present business of the applicant</label>
                        <input type="text" class="form-control" name="present_business[]">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>(v) Whether holding a competency certificate and if so, the number and validity of the competency certificate</label>
                        <div class="">
                            <input type="radio" id="competency_yes" name="competency_certificate_holding[${index}]" value="yes" class="competency-toggle" data-index="${index}"> 
                            <label> Yes</label>
                            
                        <input type="radio" id="competency_no" name="competency_certificate_holding[${index}]" value="no" class="competency-toggle" data-index="${index}" checked>  <label> No</label>
                        </div>
                        <div class="competency-fields-${index} competency-fields mt-2" style="display: none;">
                            <input type="text" class="form-control mt-2" name="competency_certificate_number[]" placeholder="Certificate Number">
                        <input type="date" class="form-control mt-2" name="competency_certificate_validity[]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>(vi) Whether he is presently employed anywhere, If so the name and address of the employer.
                            If not details of the Present business.</label>
                        <div>
                            <input type="radio" name="presently_employed[${index}]" value="yes" class="employment-toggle" data-index="${index}">  <label> Yes</label>
                            <input type="radio" name="presently_employed[${index}]" value="no" class="employment-toggle" data-index="${index}" checked>  <label> No</label>
                        </div>
                        <div class="employment-fields-${index} employment-fields mt-2" style="display: none;">
                            <input type="text" class="form-control mt-2" name="presently_employed_name[]" placeholder="Employer Name">
                            <textarea class="form-control mt-2" name="presently_employed_address[]" placeholder="Employer Address"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>(vii) If holding a competency certificate, details of previous experience with period. If the applicant has worked under a contractor, licensed by this Licensing Board, the name, address, and licence No. of the contractor.</label>
                        <div>
                            <input type="radio" name="previous_experience[${index}]" value="yes" class="experience-toggle" data-index="${index}">  <label> Yes</label>
                            <input type="radio" name="previous_experience[${index}]" value="no" class="experience-toggle" data-index="${index}" checked>  <label> No</label>
                        </div>
                        <div class="experience-fields-${index} experience-fields mt-2" style="display: none;">
                            <input type="text" class="form-control mt-2" name="previous_experience_name[]" placeholder="Contractor Name">
                            <textarea class="form-control mt-2" name="previous_experience_address[]" placeholder="Contractor Address"></textarea>
                            <input type="text" class="form-control mt-2" name="previous_experience_lnumber[]" placeholder="License Number">
                        </div>
                    </div>
                </div>

                <button class="btn btn-danger mt-3 remove-proprietor" data-index="${index}">Remove</button>
            </div>
        `;
        }

        $(document).ready(function() {
            
        $("#add-more-proprietor").click(function(event) {
            event.preventDefault();

            if (!validateFirstProprietor()) {
                alert("Please fill all required fields in the first proprietor before adding more.");
                return;
            }

            if (proprietorCount < maxProprietors) {
                $("#proprietor-container").append(getProprietorFields(proprietorCount));
                proprietorCount++;
            } else {
                alert("Maximum of 4 proprietors allowed.");
            }
        });

        // Remove Proprietor Block
        $(document).on("click", ".remove-proprietor", function() {
            let index = $(this).data("index");
            $("#proprietor-" + index).remove();
            proprietorCount--;
        });

        // Toggle Competency Fields
        $(document).on("change", ".competency-toggle", function() {
            let index = $(this).data("index");
            $(".competency-fields-" + index).toggle($(this).val() === "yes");
        });

        // Toggle Employment Fields
        $(document).on("change", ".employment-toggle", function() {
            let index = $(this).data("index");
            $(".employment-fields-" + index).toggle($(this).val() === "yes");
        });

        // Toggle Experience Fields
        $(document).on("change", ".experience-toggle", function() {
            let index = $(this).data("index");
            $(".experience-fields-" + index).toggle($(this).val() === "yes");
        });

        // Restrict Age Input (Max 49)
        $(document).on("input", ".age-input", function() {
            let value = parseInt($(this).val(), 10);
            if (value >= 50) {
                $(this).val(49);
            } else if (value < 0 || isNaN(value)) {
                $(this).val("");
            }
        });

        function validateFirstProprietor() {
            let isValid = true;

            const requiredFields = [
                "input[name='proprietor_name[]']",
                "textarea[name='proprietor_address[]']",
                "input[name='age[]']",
                "input[name='qualification[]']",
                "input[name='fathers_name[]']",
                "input[name='present_business[]']",
                // "input[name='presently_employed[0]']",
                // "input[name='previous_experience[0]']"

            ];

            requiredFields.forEach(selector => {
                let field = $(selector).first();
                if (field.val().trim() === "") {
                    field.addClass("is-invalid");
                    isValid = false;
                } else {
                    field.removeClass("is-invalid");
                }
            });

            return isValid;
        }
    });




        $(document).ready(function() {
            let maxFields = 3; // Maximum allowed input fields
            let fieldCount = 1; // Start with 1 because there's already one input field

            $("#add-more-authority-name").click(function(e) {
                e.preventDefault(); // Prevent form submission

                if (fieldCount < maxFields) {
                    let newField = `
                <div class="row mt-2 authority-field">
                    <div class="col-12 col-md-7">
                        <input type="text" class="form-control authority-name" name="name_of_authorised_to_sign[]" placeholder="Name of Authority">
                    </div>
                    <div class="col-12 col-md-5">
                        <button type="button" class="btn btn-danger remove-authority-name"><i class="fa fa-trash"></i> Remove</button>
                    </div>
                </div>
            `;

                    $("#authority-name-container").append(newField);
                    fieldCount++; // Increase count when adding a new field
                } else {
                    alert("You can add a maximum of 3 authority names.");
                }
            });

            // Remove a dynamically added field
            $(document).on("click", ".remove-authority-name", function() {
                $(this).closest(".authority-field").remove();
                fieldCount--; // Decrease count when removing a field
            });
        });

        $(document).ready(function() {
            function restrictToLetters(inputSelector) {
                $(document).on("input", inputSelector, function() {
                    this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
                });
            }

            // Apply validation to multiple fields
            restrictToLetters("[name='proprietor_name[]']");
            restrictToLetters("[name='fathers_name[]']");
            restrictToLetters("[name='presently_employed_name[]']");
            restrictToLetters("[name='previous_experience_name[]']");
            restrictToLetters("[name='qualification[]']");
        });
    </script>

    <script>
        function toggleCompetencyFields(show) {
            document.querySelectorAll(".competency-fields").forEach(field => {
                field.style.display = show ? "block" : "none";
            });
        }

        function toggleEmploymentFields(show) {
            document.querySelectorAll(".employment-fields").forEach(field => {
                field.style.display = show ? "block" : "none";
            });
        }


        function toggleAuthorisedFields(show) {
            document.querySelectorAll(".authorised-fields").forEach(field => {
                field.style.display = show ? "block" : "none";
            });
        }

        function toggleExperienceFields(show) {
            document.querySelector(".experience-fields").style.display = show ? "block" : "none";
        }

        function toggleAuthorisedFields(show) {
            document.querySelector(".authorised-fields").style.display = show ? "block" : "none";
        }

        function togglePreviousLicenseFields(show) {
            document.querySelector(".previous-license-fields").style.display = show ? "block" : "none";
        }

        function setDateRestrictions(input) {

            input.type = 'date';
            let currentYear = new Date().getFullYear();
            input.min = "1970-01-01";
            input.max = currentYear + "-12-31";
        }

        function validateDate(input) {
            let dateValue = input.value;
            if (!dateValue) return; // Allow empty input

            let selectedDate = new Date(dateValue);
            let minDate = new Date("1970-01-01");
            let maxDate = new Date();

            if (selectedDate < minDate || selectedDate > maxDate) {
                input.value = "1970-01-01"; // Automatically set to 1970
            }

            input.type = 'text';
        }



        document.addEventListener("DOMContentLoaded", function() {
            let applicantNameInput = document.getElementById("staff_name");

            applicantNameInput.addEventListener("focus", function() {
                this.addEventListener("input", function() {
                    this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
                });
            });
        });



        document.addEventListener("DOMContentLoaded", function() {
            let applicantNameInput = document.getElementById("fathers_name");

            applicantNameInput.addEventListener("focus", function() {
                this.addEventListener("input", function() {
                    this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
                });
            });
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


        document.addEventListener("DOMContentLoaded", function() {
            let ageInput = document.getElementById("bank_amount");

            ageInput.addEventListener("input", function() {
                let value = parseInt(this.value, 10);
                if (value >= 100000) {
                    this.value = 99999; // Set max limit to 49
                } else if (value < 0 || isNaN(value)) {
                    this.value = ""; // Prevent negative numbers or invalid input
                }
            });
        });
    </script>

    <script>
       


        document.addEventListener("click", function(e) {
            let container = document.getElementById("staff-container");
            let staffRows = container.querySelectorAll(".staff-fields");

            if (e.target.closest(".add-more")) {
                if (staffRows.length >= 4) {
                    alert("You can add a maximum of 4 staff entries.");
                    return;
                }

                let newRow = document.createElement("tr");
                newRow.classList.add("staff-fields");
                newRow.innerHTML = `
                    <td>${staffRows.length + 1}</td>
                    <td><input type="text" name="staff_name[]" class="form-control">
                        <span class="error text-danger" id="staff_name_error"></span>
                    </td>
                    <td>
                        <select class="form-control" name="staff_qualification[]">
                            <option selected disabled>Qualification</option>
                            <option value="PG">PG</option>
                            <option value="UG">UG</option>
                            <option value="Diploma">Diploma</option>
                            <option value="+2">+2</option>
                            <option value="10">10</option>
                        </select>
                        <span class="error text-danger" id="staff_qualification_error"></span>
                    </td>
                    <td><input type="text" class="form-control" name="cc_number[]" placeholder="Competency Certificate Number">
                        <span class="error text-danger" id="cc_number_error"></span>
                    </td>
                    <td>
                        <input type="date" class="form-control" name="cc_validity[]" placeholder="Validity">
                        <span class="error text-danger" id="cc_validity_error"></span>
                    </td>
                    <td>
                        <select class="form-control" name="staff_category[]">
                            <option selected disabled>Select Category</option>
                            <option value="QC">QC</option>
                            <option value="BC">BC</option>
                            <option value="B">B</option>
                        </select>
                        <span class="error text-danger" id="staff_category_error"></span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-staff">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                `;
                container.appendChild(newRow);
            }

            if (e.target.closest(".remove-staff")) {
                if (staffRows.length <= 1) {
                    alert("At least one staff entry is required.");
                    return;
                }
                e.target.closest("tr").remove();

                container.querySelectorAll(".staff-fields").forEach((row, index) => {
                    row.children[0].textContent = index + 1;
                });
            }
        });
    </script>