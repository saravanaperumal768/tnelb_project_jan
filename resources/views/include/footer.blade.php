<style>
    .popup-overlay_pdf {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .popup_pdf-content {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        max-width: 400px;
        width: 90%;
        margin-left: 600px;
        margin-top: 200px;
        /* Responsive width */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    #pdfButtons button {
        margin: 5px;
    }

    .swal2-icon.swal2-info.swal2-icon-show {
        width: 50px;
        height: 50px;
        margin-top: 10px;
    }

    button.swal2-confirm {
        margin-right: 20px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        font-size: 14px;
    }

    .info-row .label {
        font-weight: 600;
        color: #333;
    }

    .info-row .value {
        text-align: right;
        color: #555;
        flex-shrink: 0;
        margin-left: 10px;
    }

    .swal2-popup {
        max-width: 95vw !important;
        overflow-x: hidden !important;
    }
</style>

<div id="pdfPopup" class="popup-overlay_pdf">
    <div class="popup_pdf-content">
        <h4>Download Your Application PDF</h4>
        <div id="pdfButtons"></div>
        <button id="closePopup" class="btn btn-danger mt-2">Close</button>
    </div>
</div>


<div class="footer-bottom">
    <div class="auto-container">

        <div class="wrapper-box">
            <div class="row text-center">
                <div class="col-lg-12  text-center">

                    <!-- <div class="col-lg-2 col-md-2 col-12"></div> -->
                    <div class="col-lg-12 col-md-8 col-12  ">
                        @foreach($footerbottom as $footerbottommenu)
                        @php
                        $link = '#';
                        $target = '';
                        $label = $footerbottommenu->menu_name_en;

                        if ($footerbottommenu->page_type === 'Static Page') {
                        $link = '/tnelb_web' . $footerbottommenu->menuPage?->page_url ?? '#';
                        } elseif ($footerbottommenu->page_type === 'url') {
                        $link = $footerbottommenu->menuPage?->external_url ?? '#';
                        $target = '_blank';
                        }
                        @endphp

                        @if($footerbottommenu->page_type === 'pdf')
                        @if($footerbottommenu->menuPage?->pdf_en)
                        <i class="fa fa-file "></i>
                        <a href="{{ asset($footerbottommenu->menuPage->pdf_en) }}" target="_blank" title="English PDF">
                            <i class="fa fa-file-pdf-o text-danger"></i> {{ $label }} (EN)
                        </a>
                        @endif
                        @if($footerbottommenu->menuPage?->pdf_ta)
                        <i class="fa fa-file "></i>
                        <a href="{{ asset($footerbottommenu->menuPage->pdf_ta) }}" target="_blank" title="Tamil PDF">
                            <i class="fa fa-file-pdf-o text-success"></i> {{ $label }} (TA)
                        </a>
                        @endif
                        @elseif($footerbottommenu->page_type === 'submenu')
                        — {{ $label }}
                        @else
                        <i class="fa fa-file "></i>
                        <a href="{{ $link }}" target="{{ $target }}">{{ $label }}</a>
                        @endif
                        @endforeach
                        <!-- <i class="fa fa-file "></i> <a rel="noopener" href="websitepolicies.php"> Website Policies
                        </a><span>
                            | </span>

                        <i class="fa fa-question"></i><a rel="noopener" href="#"> Help </a>
                        <span>|</span>

                        <i class="fa fa-comment"></i> <a rel="noopener" href="niot_feedback.php"> Feedback </a>
                        <span>|</span>

                        <i class="fa fa-id-badge"></i> <a rel="noopener" href="#"
                            onclick="set_session_home_menu('','','niot_contactus.php')"> Contact Us</a> -->

                    </div>
                    <!-- <div class="col-lg-2 col-md-2 col-12"></div> -->
                </div>
            </div>

            <div class="col-lg-12 pt-2">
                <div class="  text-center middleContent text-white"> © Content Owned and Maintained by Tamilnadu
                    Electrical Licensing Board (TNELB), <br> Website Designed and Developed By<a rel="noopener"
                        href="http://www.nic.in/" target="blank" class="external_link pt-2"> National Informatics Centre
                        (NIC) </a>,
                    <a rel="noopener" href="http://meity.gov.in/" target="blank" class="external_link pt-2"> Ministry of
                        Electronics &amp; Information Technology</a>, Government of India
                </div>
            </div>
            <div class="copyright">
                <div class="text">©
                    <script>
                        document.write(new Date().getFullYear());
                    </script> <a href="#">TNELB</a> - All rights reserved.
                </div>
            </div>
        </div>
    </div>
</div>
</footer>
</div>
</div>
<!--End pagewrapper-->


<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="icon-arrow"></span></div>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="{{ url('assets/js/jquery.js') }}"></script>
<script src="{{ url('assets/js/scriptnew.js') }}"></script>
<script src="{{ url('assets/js/popper.min.js') }}"></script>
<script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ url('assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('assets/js/jquery.fancybox.js') }}"></script>
<script src="{{ url('assets/js/isotope.js') }}"></script>
<script src="{{ url('assets/js/owl.js') }}"></script>
<script src="{{ url('assets/js/appear.js') }}"></script>
<script src="{{ url('assets/js/wow.js') }}"></script>
<script src="{{ url('assets/js/lazyload.js') }}"></script>
<script src="{{ url('assets/js/scrollbar.js') }}"></script>
<script src="{{ url('assets/js/TweenMax.min.js') }}"></script>
<script src="{{ url('assets/js/swiper.min.js') }}"></script>
<script src="{{ url('assets/js/jquery.polyglot.language.switcher.js') }}"></script>
<script src="{{ url('assets/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ url('assets/js/parallax-scroll.js') }}"></script>
<script src="{{ url('assets/admin/src/plugins/src/flatpickr/flatpickr.js') }}"></script>
{{-- <script src="{{ url('assets/admin/src/plugins/src/flatpickr/custom-flatpickr.js') }}"></script> --}}

<script src="{{ url('assets/js/script.js') }}"></script>
<script src="{{ url('assets/js/custom.js') }}"></script>
<script src="{{ url('assets/js/form_p_script.js') }}"></script>

<script src="{{ url('assets/js/forma.js') }}"></script>

<script src="{{ url('assets/js/formsa.js') }}"></script>

<script src="{{ url('assets/js/formsb.js') }}"></script>

<script src="{{ url('assets/js/formb.js') }}"></script>


<script src="{{ asset('assets/admin/src/plugins/src/editors/quill/QuillDeltaToHtmlConverter.bundle.js') }}"></script>
<!-- --------------------------------------------------------------- -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/mixitup/3.2.2/mixitup.min.js'></script>
<!-- fancybox -->
{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js'></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        $('a[data-toggle="formtab"]').click(function(event) {
            event.preventDefault();
            var targetId = $(this).attr('href');

            $('.tabs-panels').removeClass('active');
            $('a[data-toggle="formtab"]').removeClass('active');

            $(targetId).addClass('active');
            $('a[href="' + targetId + '"]').addClass('active');
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

<!--
<script>
    $('a[data-toggle="formtab"]').click(function(event) {
        event.preventDefault(); // Prevent default anchor click behavior
        var targetId = $(this).attr('href'); // Get the target tab's ID

        // Remove active class from all tabs and links
        $('.tabs-panels').removeClass('active');
        $('a[data-toggle="formtab"]').removeClass('active');

        // Add active class to the clicked tab and its corresponding content
        $(targetId).addClass('active');
        $('a[href="' + targetId + '"]').addClass('active');
    });
</script> -->

<script>
    // contractor licence age calculation---------------------
    $(document).on("change", ".dob", function() {

        let dobVal = $(this).val();
        if (!dobVal) return;

        let dob = new Date(dobVal);
        let today = new Date();

        let age = today.getFullYear() - dob.getFullYear();
        let m = today.getMonth() - dob.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        let section = $("#proprietor-sectionfresh");

        if (age < 25) {
            section.find(".age_error").text("Minimum age is 25");
            section.find(".age").val('');
            return;
        }

        section.find(".age_error").text('');
        section.find(".age").val(age);
    });

document.addEventListener("DOMContentLoaded", function () {

    const hiddenBtn = document.getElementById('hiddenBtn');
    const chooseBtn = document.getElementById('chooseBtn');

    chooseBtn.addEventListener('click', () => hiddenBtn.click());

    hiddenBtn.addEventListener('change', function () {
        chooseBtn.innerText = this.files.length > 0
            ? this.files[0].name
            : 'Choose';
    });

});



    // JavaScript to ensure footer is at the bottom
    function setFooterPosition() {
        const body = document.body;
        const html = document.documentElement;
        const wrapper = document.querySelector('.page-wrapper');
        const footer = document.querySelector('.footer-bottom');

        // Reset height to auto before recalculating
        wrapper.style.minHeight = '500';

        // Calculate height of visible content
        const contentHeight = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );

        // Adjust wrapper height
        if (contentHeight < window.innerHeight) {
            wrapper.style.minHeight = `${window.innerHeight}px`;
        }
    }

    // Run on load and resize
    window.addEventListener('load', setFooterPosition);
    window.addEventListener('resize', setFooterPosition);
</script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        new Cleave('#aadhaar', {
            delimiter: ' ',
            blocks: [4, 4, 4],
            numericOnly: true
        });


        const dobInput = document.getElementById('d_o_b');

        var fp = flatpickr(dobInput, {
            dateFormat: "d-m-Y",
            // mode: "range"
        });

        // also trigger validation for manual typing
        dobInput.addEventListener('keyup', () => validateDOB(dobInput.value));
        dobInput.addEventListener('change', () => validateDOB(dobInput.value));


        $('#previously_number').on('keyup', function() {
            const value = $(this).val().trim().toUpperCase();
            $(this).val(value);
            const regex = /^(B|H|LB|LWH)\d+$/;

            $('#license_messagdfde').text();

            if (value === '') {
                licenseError.textContent = 'License Number is Required';
                return; // ✅ Stop further checks if empty
            }

            if (!regex.test(value)) {
                licenseError.textContent = 'Invalid License Number';
            } else {
                licenseError.textContent = ''; // ✅ Clear error when valid
            }
        });

        $('#previously_date').on('change', function() {
            const value = $(this).val().trim();

            if (value !== '') {
                $('#dateError').text(''); // ✅ Clear error if not empty
                // You can add other logic here if needed
            }
        });

    });

    function validateDOB(value) {
        const dobInput = document.getElementById('d_o_b');
        const ageInput = document.getElementById('age');
        const errorElement = document.getElementById("dob-error");
        const errorMessage = $('.error-message').first().text('');

        const err = document.querySelector('#d_o_b + .error-message');
        if (err) err.textContent = '';

        errorElement.textContent = "";
        ageInput.value = '';
        errorMessage.textContent = "";


        if (!value || value.trim() === "") {
            errorElement.textContent = "Date of Birth is required.";
            return;
        }

        const match = value.trim().match(/^(\d{2})-(\d{2})-(\d{4})$/);
        if (!match) {
            errorElement.textContent = "Please enter date in DD-MM-YYYY format.";
            return;
        }

        const dd = parseInt(match[1], 10);
        const mm = parseInt(match[2], 10);
        const yyyy = parseInt(match[3], 10);

        const selectedDate = new Date(yyyy, mm - 1, dd);

        if (
            selectedDate.getFullYear() !== yyyy ||
            selectedDate.getMonth() !== (mm - 1) ||
            selectedDate.getDate() !== dd
        ) {
            errorElement.textContent = "Invalid calendar date.";
            return;
        }

        const min = new Date(1970, 0, 1);
        const max = new Date(2010, 11, 31);
        if (selectedDate < min || selectedDate > max) {
            errorElement.textContent = "Minimum age should be 15 and above";
            return;
        }

        const today = new Date();
        let age = today.getFullYear() - yyyy;
        const m = today.getMonth() - (mm - 1);
        if (m < 0 || (m === 0 && today.getDate() < dd)) {
            age--;
        }

        if (age < 0) {
            errorElement.textContent = "Age cannot be negative.";
            return;
        }

        ageInput.value = age;
    }




    document.addEventListener('DOMContentLoaded', function() {
        const addressField = document.getElementById('applicants_address');
        const errorField = document.getElementById('applicants_address_error');

        const regex = /^[A-Za-z0-9\s,.\-#\/]*$/;
        if (addressField) {
            addressField.addEventListener('keyup', function(e) {
                let address = addressField.value;

                // enforce 500 characters max
                if (address.length > 250) {
                    addressField.value = address.substring(0, 250);
                    errorField.textContent = 'Maximum 250 characters reached.';
                    return;
                }


                // clear error if within limit
                errorField.textContent = '';

                if (!regex.test(address)) {
                    errorField.textContent =
                        'Only letters, numbers, spaces, comma, dot, dash, #, / are allowed.';
                }

            });
        }
    });

    $(document).ready(function() {


        let profile = document.querySelector('.profile');
        let menu = document.querySelector('.menu');

        if (profile && menu) {
            profile.onclick = function() {
                menu.classList.toggle('active');
            };
        }

        $("#contact-form").submit(function(e) {
            e.preventDefault(); // Avoid the form submission

            var phone = $('input[name="phone"]').val();

            var intRegex = /[0-9 -()+]+$/;

            if ((phone.length < 10) || (!intRegex.test(phone))) {
                alert('Please enter a valid phone number.');
                return false;
            }

            // Show OTP modal if the phone number is valid
            if (phone.length !== 0) {
                $('#otp-overlay').show();
                $('#overlay-bg').show();
            }

            return false;
        });


        $("#refresh-captcha").click(function(e) {
            e.preventDefault();
            $("#image-captcha").attr("src", "{{ url('captcha/image') }}?" + Math.random());
        });





        $("#add-more-education").click(function() {
            // Clone the last set of education fields
            let newFields = $(".education-fields").last().clone();

            // Clear input values inside the cloned fields
            newFields.find("input").val("");
            newFields.find("select").prop("selectedIndex", 0);

            // Append cloned fields to the container
            $("#education-container").append(newFields);
        });

        $("#add-more-work").click(function() {
            // Clone the last work fields section
            let newFields = $(".work-fields").last().clone();

            // Clear input values
            newFields.find("input").val("");
            newFields.find("input[type='checkbox']").prop("checked", false);

            // Append cloned fields to the container
            $("#work-container").append(newFields);
        });


        // License verfication---------------------------------------

        $('#verify_btn').on('click', function() {
            let dateError = document.getElementById("dateError");


            const licenseNumber = $('#previously_number').val().trim();
            const date = $('#previously_date').val().trim();
            const verify_result = document.getElementById("licenseError");
            const $btn = $(this);
            const regex = /^(B|H|LB|LWH)\d+$/;

            licenseError.textContent = '';
            dateError.textContent = '';

            let isValid = true;

            if (licenseNumber === '' || !regex.test(licenseNumber)) {
                // $btn.after('<div class="text-danger mt-1">⚠️ Enter license number and date.</div>');
                verify_result.textContent = 'License Number is required.';
                isValid = false;
            }

            if (date === '') {
                dateError.textContent = 'Date is required';
                isValid = false;
            } else {
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

            // Save original button text
            const originalBtnHtml = $btn.html();

            // Remove any previous message
            $('.license-result-msg').remove();


            $.ajax({
                url: "{{ route('verifylicense') }}",
                method: "POST",
                data: {
                    license_number: licenseNumber,
                    date: date,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    let $msgBox = $("#license_message");
                    let $licenseNumber = $('#l_verify');

                    if (response.exists) {

                        isLicenseVerified = true;
                        $licenseNumber.val('1');

                        $msgBox
                            .removeClass("text-danger")
                            .addClass("text-success")
                            .html("&#10004; Valid License.");
                    } else {
                        isLicenseVerified = false;
                        $licenseNumber.val('0');
                        $msgBox
                            .removeClass("text-success")
                            .addClass("text-danger")
                            .html("&#10060; Invalid License.");
                    }
                },
                error: function(xhr, status, error) {
                    let $msgBox = $("#license_message");

                    $msgBox
                        .removeClass("text-success")
                        .addClass("text-danger")
                        .html("🚫 Error verifying license. Try again.");

                    console.error(xhr.responseText || error);
                },
            });

        });


        // -----------form A --------------code ---------------


        //-------------------------------------------------- competency form submit action---------------------------------------


        //-------------------------------------------------- competency form submit action---------------------------------------


        $('#submitPaymentBtn').on('click', function(e) {
            e.preventDefault();

            $('.error-message').remove();
            let isValid = true;
            let firstErrorField = null;

            let dobEl = $('#d_o_b');
            if (dobEl.length && dobEl.val() === "") {
                let errorMsg = $('<span class="error-message text-danger d-block mt-1">Date of Birth is required.</span>');
                dobEl.after(errorMsg);
                if (!firstErrorField) firstErrorField = dobEl;
                isValid = false;
            }

            let nameRegex = /^[A-Za-z\s]+$/;
            let fathersNameEl = $('#Fathers_Name');
            if (fathersNameEl.length) {
                let fathersName = fathersNameEl.val().trim();
                if (fathersName === "") {
                    fathersNameEl.after('<span class="error-message text-danger d-block mt-1">Father\'s Name is required.</span>');
                    if (!firstErrorField) firstErrorField = fathersNameEl;
                    isValid = false;
                } else if (!nameRegex.test(fathersName)) {
                    fathersNameEl.after('<span class="error-message text-danger d-block mt-1">Only alphabets and spaces are allowed.</span>');
                    if (!firstErrorField) firstErrorField = fathersNameEl;
                    isValid = false;
                }
            }

            let applicantNameEl = $('#Applicant_Name');
            if (applicantNameEl.length) {
                let applicantName = applicantNameEl.val().trim();
                if (applicantName === "") {
                    applicantNameEl.after('<span class="error-message text-danger d-block mt-1">Applicant\'s Name is required.</span>');
                    if (!firstErrorField) firstErrorField = applicantNameEl;
                    isValid = false;
                } else if (!nameRegex.test(applicantName)) {
                    applicantNameEl.after('<span class="error-message text-danger d-block mt-1">Only alphabets and spaces are allowed.</span>');
                    if (!firstErrorField) firstErrorField = applicantNameEl;
                    isValid = false;
                }
            }

            if ($('#education-container .education-fields').length === 0) {
                $('#education-table').after('<span class="error-message text-danger d-block mt-1">At least one educational qualification is required.</span>');
                if (!firstErrorField) firstErrorField = $('#education-table');
                isValid = false;
            }

            $('#education-container .education-fields').each(function() {
                let eduLevel = $(this).find('select[name="educational_level[]"]');
                let instituteName = $(this).find('input[name="institute_name[]"]');
                let yearOfPassing = $(this).find('select[name="year_of_passing[]"]');
                let percentage = $(this).find('input[name="percentage[]"]');
                let educationUpload = $(this).find('input[name="education_document[]"]');

                if (eduLevel.length && (eduLevel.val() === null || eduLevel.val() === "")) {
                    eduLevel.after('<span class="error-message text-danger d-block mt-1">Education level is required.</span>');
                    if (!firstErrorField) firstErrorField = eduLevel;
                    isValid = false;
                }

                if (instituteName.length && instituteName.val().trim() === "") {
                    instituteName.after('<span class="error-message text-danger d-block mt-1">Institution name is required.</span>');
                    if (!firstErrorField) firstErrorField = instituteName;
                    isValid = false;
                }

                if (yearOfPassing.length && (yearOfPassing.val() === "0" || yearOfPassing.val() === "")) {
                    yearOfPassing.after('<span class="error-message text-danger d-block mt-1">Year of passing is required.</span>');
                    if (!firstErrorField) firstErrorField = yearOfPassing;
                    isValid = false;
                }

                if (percentage.length && (percentage.val().trim() === "" || isNaN(percentage.val()) || percentage.val() < 0 || percentage.val() > 100)) {
                    percentage.after('<span class="error-message text-danger d-block mt-1">Percentage / Grade is required</span>');
                    if (!firstErrorField) firstErrorField = percentage;
                    isValid = false;
                }

                if (educationUpload.length && educationUpload.val() === "") {
                    educationUpload.after('<span class="error-message text-danger d-block mt-1">Education certificate upload is required.</span>');
                    if (!firstErrorField) firstErrorField = educationUpload;
                    isValid = false;
                } else if (educationUpload.length && educationUpload[0].files.length > 0) {
                    const file = educationUpload[0].files[0]; // ✅ use raw DOM element
                    if (file) {
                        const allowedType = 'application/pdf';
                        const minSize = 5 * 1024; // 5 KB
                        const maxSize = 250 * 1024; // 250 KB

                        if (file.type !== allowedType) {
                            educationUpload.after('<span class="error-message text-danger d-block mt-1">Only PDF files are allowed for Education upload.</span>');
                            if (!firstErrorField) firstErrorField = educationUpload;
                            isValid = false;
                        } else if (file.size < minSize || file.size > maxSize) {
                            educationUpload.after('<span class="error-message text-danger d-block mt-1">File size permitted only 5 KB to 200 KB.</span>');
                            if (!firstErrorField) firstErrorField = educationUpload;
                            isValid = false;
                        }
                    }
                }
            });

            $('#work-container .work-fields').each(function() {
                let workLevel = $(this).find('input[name="work_level[]"]');
                let experience = $(this).find('input[name="experience[]"]');
                let designation = $(this).find('input[name="designation[]"]');
                let workDocument = $(this).find('input[name="work_document[]"]');

                if (workLevel.length && (workLevel.val() === null || workLevel.val() === "")) {
                    workLevel.after('<span class="error-message text-danger d-block mt-1">Please enter the company / contractor name.</span>');
                    if (!firstErrorField) firstErrorField = workLevel;
                    isValid = false;
                }

                if (experience.length && (experience.val().trim() === "" || isNaN(experience.val()) || parseInt(experience.val()) < 0 || parseInt(experience.val()) > 50)) {
                    experience.after('<span class="error-message text-danger d-block mt-1">Year of experience is required.</span>');
                    if (!firstErrorField) firstErrorField = experience;
                    isValid = false;
                }

                if (designation.length && designation.val().trim() === "") {
                    designation.after('<span class="error-message text-danger d-block mt-1">Designation is required.</span>');
                    if (!firstErrorField) firstErrorField = designation;
                    isValid = false;
                }

                if (workDocument.length && workDocument.val().trim() === "") {
                    workDocument.after('<span class="error-message text-danger d-block mt-1">Experience certificate upload is required.</span>');
                    if (!firstErrorField) firstErrorField = workDocument;
                    isValid = false;
                } else if (workDocument.length && workDocument[0].files.length > 0) {
                    const file = workDocument[0].files[0]; // ✅ use raw DOM element
                    if (file) {
                        const allowedType = 'application/pdf';
                        const minSize = 5 * 1024; // 5 KB
                        const maxSize = 250 * 1024; // 250 KB

                        if (file.type !== allowedType) {
                            workDocument.after('<span class="error-message text-danger d-block mt-1">Only PDF files are allowed for Experience certificate.</span>');
                            if (!firstErrorField) firstErrorField = workDocument;
                            isValid = false;
                        } else if (file.size < minSize || file.size > maxSize) {
                            workDocument.after('<span class="error-message text-danger d-block mt-1">File size permitted only 5 KB to 200 KB.</span>');
                            if (!firstErrorField) firstErrorField = workDocument;
                            isValid = false;
                        }
                    }
                }
            });

            let aadhaarInput = document.getElementById("aadhaar");
            let aadhaarError = document.getElementById("aadhaar-error");
            if (aadhaarInput && aadhaarError) {
                const aadhaar = aadhaarInput.value.replace(/\s+/g, '').trim();
                const aadhaarRegex = /^[2-9]{1}[0-9]{11}$/;
                if (aadhaar === "") {
                    aadhaarError.textContent = "Aadhaar number is required.";
                    if (!firstErrorField) firstErrorField = $(aadhaarInput);
                    isValid = false;
                } else if (!aadhaarRegex.test(aadhaar)) {
                    aadhaarError.textContent = "Please enter a valid 12-digit Aadhaar number (should not start with 0 or 1).";
                    if (!firstErrorField) firstErrorField = $(aadhaarInput);
                    isValid = false;
                } else {
                    aadhaarError.textContent = "";
                }
            }

            let aadhaarFileInput = document.getElementById("aadhaar_doc");
            if (aadhaarFileInput && $(aadhaarFileInput).is(":visible")) {
                if (aadhaarFileInput && aadhaarFileInput.files.length === 0) {
                    $('#aadhaar_doc').after('<span class="error-message text-danger d-block mt-1">Aadhaar document upload is required.</span>');
                    if (!firstErrorField) firstErrorField = $('#aadhaar_doc');
                    isValid = false;
                } else if (aadhaarFileInput && aadhaarFileInput.files.length > 0) {
                    const file = aadhaarFileInput.files[0];
                    if (file) {
                        const allowedType = 'application/pdf';
                        const maxSize = 250 * 1024;
                        if (file.type !== allowedType) {
                            $('#aadhaar_doc').after('<span class="error-message text-danger d-block mt-1">Only PDF files are allowed for Aadhaar document.</span>');
                            if (!firstErrorField) firstErrorField = $('#aadhaar_doc');
                            isValid = false;
                        } else if (file.size > maxSize) {
                            $('#aadhaar_doc').after('<span class="error-message text-danger d-block mt-1">File size permitted only 5 KB to 250.</span>');
                            if (!firstErrorField) firstErrorField = $('#aadhaar_doc');
                            isValid = false;
                        }
                    }
                }
            }

            let pancardInput = document.getElementById("pancard");
            let pancardError = document.getElementById("pancard-error");
            if (pancardInput && pancardError) {
                const pancardValue = pancardInput.value.trim();
                if (pancardValue === "") {
                    pancardError.textContent = "PAN number is required.";
                    if (!firstErrorField) firstErrorField = $(pancardInput);
                    isValid = false;
                }
            }


            let pancardDocInput = document.getElementById("pancard_doc");

            if (pancardDocInput && $(pancardDocInput).is(":visible")) {
                if (pancardDocInput && pancardDocInput.files.length === 0) {
                    $('#pancard_doc').after('<span class="error-message text-danger d-block mt-1">PAN card document is required.</span>');
                    if (!firstErrorField) firstErrorField = $('#pancard_doc');
                    isValid = false;
                } else if (pancardDocInput && pancardDocInput.files.length > 0) {
                    const file = pancardDocInput.files[0];
                    if (file) {
                        const allowedType = 'application/pdf';
                        const maxSize = 250 * 1024;
                        if (file.type !== allowedType) {
                            $('#pancard_doc').after('<span class="error-message text-danger d-block mt-1">Only PDF files are allowed for PAN document.</span>');
                            if (!firstErrorField) firstErrorField = $('#pancard_doc');
                            isValid = false;
                        } else if (file.size > maxSize) {
                            $('#pancard_doc').after('<span class="error-message text-danger d-block mt-1">File size permitted only 5 KB to 250.</span>');
                            if (!firstErrorField) firstErrorField = $('#pancard_doc');
                            isValid = false;
                        }
                    }
                }
            }



            if (!$('#declarationCheckbox').is(':checked')) {
                $('#checkboxError').show();
                if (!firstErrorField) firstErrorField = $('#checkboxError');
                isValid = false;
            } else {
                $('#checkboxError').hide();
            }


            let photoInput = document.getElementById("upload_photo");

            if (photoInput && $(photoInput).is(':visible') && photoInput.files.length === 0) {
                $(photoInput).nextAll('.error-message').remove();
                $('#upload_photo').after('<span class="error-message text-danger d-block mt-1">Photo upload is required.</span>');
                if (!firstErrorField) firstErrorField = $('#upload_photo');
                isValid = false;
            } else if (photoInput && photoInput.files.length > 0) {
                const file = photoInput.files[0];
                if (file) {
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    const maxSize = 50 * 1024;
                    if (!allowedTypes.includes(file.type)) {
                        $('#upload_photo').after('<span class="error-message text-danger d-block mt-1">Only JPG, JPEG, or PNG images are allowed for photo upload.</span>');
                        if (!firstErrorField) firstErrorField = $('#upload_photo');
                        isValid = false;
                    } else if (file.size > maxSize) {
                        $('#upload_photo').after('<span class="error-message text-danger d-block mt-1">File size permitted only 5 KB to 50 KB.</span>');
                        if (!firstErrorField) firstErrorField = $('#upload_photo');
                        isValid = false;
                    }
                }
            }



            if (!isValid && firstErrorField) {
                $('html, body').animate({
                    scrollTop: firstErrorField.offset().top - 100
                }, 500);
                return;
            }

            let license_name = $("#license_name").val();
            showDeclarationPopup(license_name);
        });



        $("#pancard").on("keyup", function() {
            let value = $(this).val().toUpperCase();

            // Limit to 10 characters
            if (value.length > 10) {
                value = value.slice(0, 10);
            }

            $(this).val(value); // Force uppercase and max length

            if (/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(value)) {
                $("#pancard-error").text(""); // valid
            } else {
                $("#pancard-error").text("Enter valid 10-character PAN (e.g., ABCDE1234F).");
            }
        });

        $("#aadhaar").on("input", function() {
            let value = $(this).val();

            // Remove all spaces from masked input
            const digitsOnly = value.replace(/\s+/g, '');

            // Validate Aadhaar: must be 12 digits starting with 2–9
            if (digitsOnly.length === 14) {
                if (/^[2-9]{1}[0-9]{11}$/.test(digitsOnly)) {
                    $("#aadhaar-error").text(""); // ✅ Valid Aadhaar
                    $("#aadhaar_error").text("");

                } else {
                    $("#aadhaar-error").text("Enter valid Aadhaar Number.");
                    $("#aadhaar_error").text("Enter valid Aadhaar Number.");
                }
            } else {
                $("#aadhaar-error").text("");
                $("#aadhaar_error").text("");
            }
        });

        $(document).ready(function() {
            const aadhaarInput = document.getElementById("aadhaar_doc");
            const panInput = document.getElementById("pancard_doc")

            if (aadhaarInput) {
                aadhaarInput.addEventListener("change", function() {
                    const aadhaarError = aadhaarInput.parentElement.querySelector(
                        ".error-message");

                    if (this.files.length !== 0 && aadhaarError) {
                        aadhaarError.remove();
                    }
                });
            }

            if (panInput) {
                panInput.addEventListener("change", function() {
                    const panError = panInput.parentElement.querySelector(".error-message");

                    if (this.files.length !== 0 && panError) {
                        panError.remove();
                    }
                });
            }
        });

        $(document).on('keyup change', '#education-container .education-fields input, #education-container .education-fields select',
            function() {
                const $field = $(this);
                if ($field.val().trim() !== '') {
                    $field.nextAll('.error-message').first().remove();
                    $field.closest('.work-fields').find('.error-message').filter(function() {
                        return $(this).text().includes(
                            "Please fill in at least one field");
                    }).remove();
                }
            });


        $(document).on('keyup change', '#work-container .work-fields input, #work-container .work-fields select',
            function() {
                const $field = $(this);
                if ($field.val().trim() !== '') {
                    $field.nextAll('.error-message').first().remove();
                    $field.closest('.work-fields').find('.error-message').filter(function() {
                        return $(this).text().includes("Please fill in at least one field");
                    }).remove();
                }
            });
        // -----------------fathers name Validation-------------

        let isValid = true;
        let firstErrorField = null;

        // Block numbers and special characters during typing
        $("#Fathers_Name").on("keypress", function(e) {
            let char = String.fromCharCode(e.which);
            if (!/^[a-zA-Z\s]$/.test(char)) {
                e.preventDefault();
            }
        });

        // Validate input on change
        $("#Fathers_Name").on("input", function() {
            $(".error-message", this.parentElement).remove(); // Clear previous error

            let fathersName = $(this).val().trim();
            let nameRegex = /^[A-Za-z\s]+$/;

            if (!nameRegex.test(fathersName)) {
                if (!firstErrorField) firstErrorField = $(this);
                isValid = false;
            }
        });

        // --------------------End------------


        $("#upload_photo").on("input change", function() {
            const $field = $(this);

            if ($field.val()) {
                $field.nextAll('.error-message').first().remove();
            }
        });



        $('#closePopup').on('click', function() {
            $('#pdfPopup').fadeOut(function() {
                window.location.href = "{{ route('dashboard') }}";
            });
        });





        $("#competency_form_a_renewal").on("submit", function(e) {


            e.preventDefault(); // Prevent default form submission


            let isValid = true;

            // Declarations
            let applicantName = $("#applicant_name").val().trim();
            let businessAddress = $("textarea[name='business_address']").val().trim();

            // alert(applicantName);

            if (applicantName === "") {
                $("#applicant_name_error").text("Name is required.");
                isValid = false;
            }

            $("#applicant_name").on("keyup", function() {
                if ($(this).val().trim() !== "") {
                    $("#applicant_name_error").text("");
                }
            });

            if (businessAddress === "") {
                $("#business_address_error").text("Business address is required.");
                isValid = false;
            }

            $("#business_address").on("keyup", function() {
                if ($(this).val().trim() !== "") {
                    $("#business_address_error").text("");
                }
            });

            let authorisedSelected = $('input[name="authorised_name_designation"]:checked').val();
            $("#authorised_name_designation_error").text("");


            $("#authorised_name").next(".error").remove();
            $("#authorised_designation").next(".error").remove();

            if (!authorisedSelected) {
                $("#authorised_name_designation_error").text(
                    "Select Yes or No for authorised signatory.");
                isValid = false;
            } else if (authorisedSelected === "yes") {
                let authName = $("#authorised_name").val().trim();
                let authDesig = $("#authorised_designation").val().trim();

                if (authName === "") {
                    $("#authorised_name").after(
                        '<span class="error text-danger d-block">Authorised Name is required.</span>'
                    );
                    isValid = false;
                }

                if (authDesig === "") {
                    $("#authorised_designation").after(
                        '<span class="error text-danger d-block">Authorised Designation is required.</span>'
                    );
                    isValid = false;
                }
            }



            $('input[name="authorised_name_designation"]').on("change", function() {
                $("#authorised_name_designation_error").text("");
            });

            // Authorised Name & Designation Inputs
            $("#authorised_name, #authorised_designation").on("keyup", function() {
                $(this).next(".error").remove(); // remove dynamically appended span
            });

            // ------------------ 3. Previous Contractor License ------------------
            let previousSelected = $('input[name="previous_contractor_license"]:checked').val();


            if (!previousSelected) {
                $("#previous_contractor_license_error").text(
                    " select Yes or No for previous application.");
                isValid = false;
            } else if (previousSelected === "yes") {
                let prevAppNo = $("#previous_application_number").val().trim();
                $("#previous_application_number").next(".error").remove();

                if (prevAppNo === "") {
                    $("#previous_application_number").after(
                        '<span class="error text-danger d-block">Previous License Number is required.</span>'
                    );
                    isValid = false;
                }
            }
            $('input[name="previous_contractor_license"]').on("change", function() {
                $("#previous_contractor_license_error").text("");
            });
            $("#previous_application_number").on("keyup", function() {
                $(this).next(".error").remove(); // remove dynamically appended span
            });


            // ---------------- 7 Bank------------------------


            let bankAddress = $("textarea[name='bank_address']").val().trim();
            let bankValidity = $("input[name='bank_validity']").val().trim();
            let bankAmount = $("#bank_amount").val().trim();

            if (bankAddress === "") {
                $("#bank_address_error").text("Bank name and address is required.");
                isValid = false;
            }

            if (bankValidity === "") {
                $("#bank_validity_error").text("Validity period is required.");
                isValid = false;
            }

            if (bankAmount === "") {
                $("#bank_amount_error").text("Amount is required.");
                isValid = false;
            }

            // Clear bank_address error on typing
            $("textarea[name='bank_address']").on("keyup", function() {
                if ($(this).val().trim() !== "") {
                    $("#bank_address_error").text("");
                }
            });

            // Clear bank_validity error on typing
            $("input[name='bank_validity']").on("keyup change", function() {
                if ($(this).val().trim() !== "") {
                    $("#bank_validity_error").text("");
                }
            });

            // Clear bank_amount error on typing
            $("#bank_amount").on("keyup change", function() {
                if ($(this).val().trim() !== "") {
                    $("#bank_amount_error").text("");
                }
            });


            // -----------------8-----------------

            let criminalOffence = $('input[name="criminal_offence"]:checked').val();
            if (!criminalOffence) {
                $("#criminal_offence_error").text(" select Yes or No ");
                isValid = false;
            }

            $('input[name="criminal_offence"]').on("change", function() {
                $("#criminal_offence_error").text("");
            });


            // -----------------9-----------------

            let consent_letter_enclose = $('input[name="consent_letter_enclose"]:checked').val();
            if (!consent_letter_enclose) {
                $("#consent_letter_enclose_error").text(" select Yes or No ");
                isValid = false;
            }

            $('input[name="consent_letter_enclose"]').on("change", function() {
                $("#consent_letter_enclose_error").text("");
            });


            // -----------------10-----------------

            let cc_holders_enclosed = $('input[name="cc_holders_enclosed"]:checked').val();
            if (!cc_holders_enclosed) {
                $("#cc_holders_enclosed_error").text(" select Yes or No ");
                isValid = false;
            }

            $('input[name="cc_holders_enclosed"]').on("change", function() {
                $("#cc_holders_enclosed_error").text("");
            });

            // -----------------10 (ii)-----------------

            let purchase_bill_enclose = $('input[name="purchase_bill_enclose"]:checked').val();
            if (!purchase_bill_enclose) {
                $("#purchase_bill_enclose_error").text(" select Yes or No ");
                isValid = false;
            }

            $('input[name="purchase_bill_enclose"]').on("change", function() {
                $("#purchase_bill_enclose_error").text("");
            });

            // -----------------10-----------------

            let test_reports_enclose = $('input[name="test_reports_enclose"]:checked').val();
            if (!test_reports_enclose) {
                $("#test_reports_enclose_error").text(" select Yes or No ");
                isValid = false;
            }

            $('input[name="test_reports_enclose"]').on("change", function() {
                $("#test_reports_enclose_error").text("");
            });


            // -----------------11-----------------

            let specimen_signature_enclose = $('input[name="specimen_signature_enclose"]:checked')
                .val();
            if (!specimen_signature_enclose) {
                $("#specimen_signature_enclose_error").text(" select Yes or No ");
                isValid = false;
            }

            $('input[name="specimen_signature_enclose"]').on("change", function() {
                $("#specimen_signature_enclose_error").text("");
            });


            // -----------------11 (ii)-----------------

            let separate_sheet = $('input[name="separate_sheet"]:checked').val();
            if (!separate_sheet) {
                $("#separate_sheet_error").text(" select Yes or No ");
                isValid = false;
            }

            $('input[name="separate_sheet"]').on("change", function() {
                $("#separate_sheet_error").text("");
            });

            //   ----------------aadhaar change gap-----------------
            // Aadhaar number validation
            const aadhaarnumber = document.getElementById("aadhaar");
            const aadhaarErrormsg = document.getElementById("aadhaar_error");
            const aadhaar = aadhaarnumber.value.replace(/\s+/g, '').trim();
            // let aadhaar = $("#aadhaar").val().trim();
            const aadhaarRegex = /^[2-9]{1}[0-9]{11}$/;
            if (aadhaar === "") {
                aadhaarErrormsg.textContent = "Aadhaar number is required.";
                if (!firstErrorField) firstErrorField = aadhaar;
                isValid = false;
            } else if (!aadhaarRegex.test(aadhaar)) {
                aadhaarErrormsg.textContent =
                    "Please enter a valid 12-digit Aadhaar number (should not start with 0 or 1).";
                if (!firstErrorField) firstErrorField = aadhaar;
                isValid = false;
            } else {
                aadhaarErrormsg.textContent = "";
            }


            // Clear errors on file change
            $("#aadhaar_doc").on("change", function() {
                $('#aadhaar_doc_error').text("");
            });

            $("#pancard_doc").on("change", function() {
                $('#pancard_doc_error').text("");
            });

            $("#gst_doc").on("change", function() {
                $('#gst_doc_error').text("");
            });

            // -------------------end doc--------------------


            const pancard = $("#pancard").val().trim().toUpperCase();
            const panPattern = /^[A-Z]{5}[0-9]{4}[A-Z]$/;

            if (pancard === "") {
                $("#pancard_error").text("PAN card number is required.");
                isValid = false;
            } else if (!panPattern.test(pancard)) {
                $("#pancard_error").text("Invalid PAN format (e.g., ABCDE1234F)").css("color", "red");
                isValid = false;
            } else {
                $("#pancard_error").text("");
            }

            $("#pancard").on("keyup", function() {
                const value = $(this).val().toUpperCase();
                $(this).val(value); // Convert input to uppercase automatically

                const panPattern = /^[A-Z]{5}[0-9]{4}[A-Z]$/;

                if (panPattern.test(value)) {
                    $("#pancard_error").text("");
                } else {
                    $("#pancard_error").text("Invalid PAN format (e.g., ABCDE1234F)").css(
                        "color", "red");
                }
            });



            const gst_number = $("#gst_number").val().trim().toUpperCase();

            if (gst_number === "") {
                $("#gst_number_error").text("GST Number is required.");
                isValid = false;
            } else if (!/^[A-Z0-9]{15}$/.test(gst_number)) {
                $("#gst_number_error").text("Enter 15-character alphanumeric GST Number.");
                isValid = false;
            } else {
                $("#gst_number_error").text("");
            }

            $("#gst_number").on("keyup", function() {
                const value = $(this).val().toUpperCase();
                $(this).val(value); // Force uppercase

                if (/^[A-Z0-9]{15}$/.test(value)) {
                    $("#gst_number_error").text("");
                } else {
                    $("#gst_number_error").text("Enter 15-character alphanumeric GST Number.");
                }
            });




            // -------------------- 1. Proprietor Validation --------------------
            let proprietorValid = true;

            $(".border.box-shadow-blue, .proprietor-block").each(function() {
                const name = $(this).find('input[name="proprietor_name[]"]');
                const address = $(this).find('textarea[name="proprietor_address[]"]');
                const age = $(this).find('input[name="age[]"]');
                const qualification = $(this).find('input[name="qualification[]"]');
                const fatherName = $(this).find('input[name="fathers_name[]"]');

                if (name.val().trim() === "") {
                    name.siblings('.error').text("Name is required.");
                    proprietorValid = false;
                }

                if (address.val().trim() === "") {
                    address.siblings('.error').text("Address is required.");
                    proprietorValid = false;
                }

                if (age.val().trim() === "") {
                    age.siblings('.error').text("Age is required.");
                    proprietorValid = false;
                }

                if (qualification.val().trim() === "") {
                    qualification.siblings('.error').text("Qualification is required.");
                    proprietorValid = false;
                }

                if (fatherName.val().trim() === "") {
                    fatherName.siblings('.error').text("Father/Husband's Name is required.");
                    proprietorValid = false;
                }

                // Optional fields (only if 'Yes' is selected)   
                const index = $(this).index();
                const competencyYes = $(this).find(
                        'input[name="competency_certificate_holding[${index}]"]:checked')
                    .val() === "yes";
                if (competencyYes) {
                    const certNo = $(this).find(
                        'input[name="competency_certificate_number[]"]');
                    const certValid = $(this).find(
                        'input[name="competency_certificate_validity[]"]');
                    if (certNo.val().trim() === "") {
                        certNo.after(
                            '<span class="error text-danger">Certificate Number is required.</span>'
                        );
                        proprietorValid = false;
                    }
                    if (certValid.val().trim() === "") {
                        certValid.after(
                            '<span class="error text-danger">Certificate Validity is required.</span>'
                        );
                        proprietorValid = false;
                    }
                }

                const employedYes = $(this).find(
                    'input[name="presently_employed[${index}]"]:checked').val() === "yes";
                if (employedYes) {
                    const employerName = $(this).find(
                        'input[name="presently_employed_name[]"]');
                    const employerAddress = $(this).find(
                        'textarea[name="presently_employed_address[]"]');
                    if (employerName.val().trim() === "") {
                        employerName.after(
                            '<span class="error text-danger">Employer name is required.</span>'
                        );
                        proprietorValid = false;
                    }
                    if (employerAddress.val().trim() === "") {
                        employerAddress.after(
                            '<span class="error text-danger">Employer address is required.</span>'
                        );
                        proprietorValid = false;
                    }
                }

                const experienceYes = $(this).find(
                    'input[name="previous_experience[${index}]"]:checked').val() === "yes";
                if (experienceYes) {
                    const expName = $(this).find('input[name="previous_experience_name[]"]');
                    const expAddress = $(this).find(
                        'textarea[name="previous_experience_address[]"]');
                    const expLicense = $(this).find(
                        'input[name="previous_experience_lnumber[]"]');
                    if (expName.val().trim() === "") {
                        expName.after(
                            '<span class="error text-danger">Contractor Name is required.</span>'
                        );
                        proprietorValid = false;
                    }
                    if (expAddress.val().trim() === "") {
                        expAddress.after(
                            '<span class="error text-danger">Contractor Address is required.</span>'
                        );
                        proprietorValid = false;
                    }
                    if (expLicense.val().trim() === "") {
                        expLicense.after(
                            '<span class="error text-danger">License Number is required.</span>'
                        );
                        proprietorValid = false;
                    }
                }
            });


            let staffValid = true;
            let staffCount = 0;

            // Clear all previous error messages once before loop
            $(".staff-fieldsrenew .error").text("");

            $(".staff-fieldsrenew").each(function() {
                const name = $(this).find('input[name="staff_name[]"]');
                const qual = $(this).find('select[name="staff_qualification[]"]');
                const ccNum = $(this).find('input[name="cc_number[]"]');
                const ccValid = $(this).find('input[name="cc_validity[]"]');
                const category = $(this).find('select[name="staff_category[]"]');

                const nameVal = name.val().trim();
                const ccNumVal = ccNum.val().trim();
                const ccValidVal = ccValid.val().trim();
                const qualVal = qual.val();
                const categoryVal = category.val();

                // Live error clearing
                name.on("keyup", function() {
                    if ($(this).val().trim() !== "") {
                        name.siblings(".error").text("");
                    }
                });

                qual.on("change", function() {
                    if ($(this).val() !== "") {
                        qual.siblings(".error").text("");
                    }
                });

                ccNum.on("keyup", function() {
                    if ($(this).val().trim() !== "") {
                        ccNum.siblings(".error").text("");
                    }
                });

                ccValid.on("change keyup", function() {
                    if ($(this).val().trim() !== "") {
                        ccValid.siblings(".error").text("");
                    }
                });

                category.on("change", function() {
                    if ($(this).val() !== "") {
                        category.siblings(".error").text("");
                    }
                });

                // Validation
                if (nameVal === "") {
                    name.siblings(".error").text("Name is required.");
                    staffValid = false;
                }

                if (!qualVal) {
                    qual.siblings(".error").text("Qualification is required.");
                    staffValid = false;
                }

                if (ccNumVal === "") {
                    ccNum.siblings(".error").text("Certificate Number is required.");
                    staffValid = false;
                }

                if (ccValidVal === "") {
                    ccValid.siblings(".error").text("Certificate Validity is required.");
                    staffValid = false;
                }

                if (!categoryVal) {
                    category.siblings(".error").text("Category is required.");
                    staffValid = false;
                }

                // Count only if all fields filled
                if (nameVal && qualVal && ccNumVal && ccValidVal && categoryVal) {
                    staffCount++;
                }
            });

            // Declaration Checkboxes
            const declaration1Checked = $("#declarationCheckbox").is(":checked");
            const declaration2Checked = $("#declarationCheckbox1").is(":checked");

            if (!declaration1Checked) {
                $("#declaration3_error").text("⚠ Please check this declaration before proceeding.");
                isValid = false;
            }

            if (!declaration2Checked) {
                $("#declaration4_error").text("⚠ Please check this declaration before proceeding.");
                isValid = false;
            }

            // Clear errors on change
            $("#declarationCheckbox").on("change", function() {
                if ($(this).is(":checked")) {
                    $("#declaration3_error").text("");
                }
            });

            $("#declarationCheckbox1").on("change", function() {
                if ($(this).is(":checked")) {
                    $("#declaration4_error").text("");
                }
            });

            console.log({
                applicantName,
                businessAddress,
                aadhaar,
                pancard,
                gst_number
            });
            console.group("🔍 Form Validation Summary");

            console.log("➡ Applicant Name:", applicantName);
            console.log("➡ Business Address:", businessAddress);
            console.log("➡ Aadhaar:", aadhaar);
            console.log("➡ PAN:", pancard);
            console.log("➡ GST:", gst_number);
            console.log("➡ Authorised Signatory:", authorisedSelected);
            if (authorisedSelected === "yes") {
                console.log("    ↪ Authorised Name:", $("#authorised_name").val().trim());
                console.log("    ↪ Authorised Designation:", $("#authorised_designation").val().trim());
            }
            console.log("➡ Previous License:", previousSelected);
            if (previousSelected === "yes") {
                console.log("    ↪ Previous App Number:", $("#previous_application_number").val()
                    .trim());
            }

            // Prepare formData
            const formData = new FormData($('#competency_form_a_renewal')[0]);
            const applicationId = $('#application_id').val();
            const status = $('select[name="status"]').val();
            const actionType = status == "0" ? "draft" : "submit";
            // let actionType = "submit";

            formData.append("form_action", actionType);

            if (isValid) {
                if (actionType === "draft") {
                    submitFormAFinalrenew(formData, actionType, applicationId);
                } else {
                    showDeclarationPopupformArenew(formData, applicationId);
                }
            }
        });


        function showDeclarationPopupformArenew(formData, applicationId) {
            Swal.fire({
                title: '<h5 class="mb-3" style="color: white; background-color: #0d6efd; padding: 10px 20px; text-align:left;">📋 Instructions & Declaration For Renewal</h5>',
                html: `
            <div style="text-align: left; max-height: 500px; overflow-y: auto; padding: 0 10px; font-size: 14px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                <ol class="instruct" style="margin-left: 20px; padding-left: 10px;">
                    <li>
                      <span style="color: #0d6efd; font-weight: 600;">Fees:</span> 
                      <ol type="i" style="margin-left: 20px; margin-top: 5px;">
                        <li>Fees Issue for <strong> Electrical Contractor/s Licence-Grade "EA"</strong> from <span style="color:#198754;">01.01.2024</span> onwards is <span style="color:#dc3545; font-weight:600;">Rs. 6,000/-</span>.</li>
                        <li>The fee must be paid by <strong>Demand Draft</strong> from any <span style="color:#0d6efd;">Scheduled Bank</span> or <span style="color:#0d6efd;">Co-operative Bank</span>, in favour of <strong>Secretary, Electrical Licensing Board, Chennai – 600 032</strong>, payable at Chennai. <em style="color:#6c757d;">Other methods of payment will not be accepted.</em></li>
                      </ol>
                    </li>
                    <li>
                      The <span style="color:#0d6efd; font-weight:600;">applicant’s signature</span> and <span style="color:#0d6efd; font-weight:600;">photo</span> affixed in the application must be attested by a <span style="color:#198754;">Gazetted Officer</span>.
                    </li>
                    <li>
                      <u><strong>With Experience:</strong></u>
                      <ul style="margin-left: 20px; list-style-type: disc;">
                        <li>Two years experience in erection or operation and maintenance in High Voltage installation.</li>
                        <li><strong>OR</strong></li>
                        <li>The applicant should hold a <strong>Electrical Contractor/s Licence-Grade "EA"</strong> from the Department of Technical Education, Chennai.</li>
                      </ul>
                    </li>
                    <li>The applicant should possess a <span style="color:#0d6efd; font-weight:600;">Diploma</span> or <span style="color:#0d6efd; font-weight:600;">Degree</span> in Electrical Engineering or an <span style="color:#0d6efd; font-weight:600;">A.M.I.E.</span> Certificate (Part A & B).</li>
                    <li><span style="color:#0d6efd; font-weight:600;">Photographs:</span> Three passport-size photographs (6cm x 4cm), taken within the last three months, must be provided.</li>
                    <li><span style="color:#0d6efd; font-weight:600;">Signature:</span> Applicant’s signature in triplicate on a separate sheet of paper must be provided.</li>
                    <li><span style="color:#0d6efd; font-weight:600;">Proof of Age:</span> Original and photocopy of age proof document must be submitted.</li>
                    <li><span style="color:#0d6efd; font-weight:600;">Application Form:</span> All columns must be filled clearly in words and figures. No column should be left blank.</li>
                    <li>Application should be in the <strong>prescribed form only</strong>.</li>
                </ol>

                <div class="form-check mt-4">
                    <input type="checkbox" class="form-check-input" id="declaration-agree-renew">
                    <label for="declaration-agree-renew" class="form-check-label" style="font-weight: 600;">
                        I have read and agree to the above instructions.
                    </label>
                    <div class="text-danger mt-2 d-none" id="declaration-error-renew">You must agree to proceed.</div>
                </div>
            </div>
        `,
                showCancelButton: true,
                confirmButtonText: "Proceed",
                cancelButtonText: "Cancel",
                width: '80%',
                customClass: {
                    popup: 'swal-xl',
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                didOpen: () => {
                    const confirmBtn = Swal.getConfirmButton();
                    confirmBtn.disabled = true;
                    const checkbox = Swal.getHtmlContainer().querySelector(
                        "#declaration-agree-renew");
                    checkbox?.addEventListener("change", () => {
                        confirmBtn.disabled = !checkbox.checked;
                    });
                },
                preConfirm: () => {
                    const isChecked = Swal.getHtmlContainer().querySelector(
                        "#declaration-agree-renew")?.checked;
                    if (!isChecked) {
                        Swal.getHtmlContainer().querySelector("#declaration-error-renew").classList
                            .remove("d-none");
                        return false;
                    }
                    return true;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitFormAFinalrenew(formData, "submit", applicationId);
                }
            });
        }


        function submitFormAFinalrenew(formData, actionType, applicationId) {

            // alert(applicationId);
            let url = applicationId ?
                "{{ route('forma.update', ['appl_id' => '_APPL_ID']) }}".replace('_APPL_ID', applicationId) :
                "{{ route('forma.store') }}";


            if (applicationId) {
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function() {
                    $(".save-draft, .submit-payment").prop("disabled", true);
                },
                success: function(response) {
                    const applicationId = response
                        .application_id; // ✅ Get application_id returned from backend
                    const transactionId = response.transaction_id || 'TXN' + Math.floor(Math
                        .random() * 900000 + 100000);
                    const transactionDate = new Date().toLocaleDateString('en-GB');
                    const applicantName = $("#applicant_name").val() || "Applicant";
                    const amount = $("#amount").val() || "6000";

                    if (actionType === "draft") {
                        Swal.fire("Saved!", "Draft saved successfully!", "success").then(() => {
                            window.location.href = BASE_URL + "/dashboard";
                        });
                    } else {
                        // ✅ Pass returned application_id to the next popup
                        showPaymentInitiationPopupformArenew(applicationId, transactionId,
                            transactionDate, applicantName, amount);
                    }

                    $(".save-draft, .submit-payment").prop("disabled", false);
                },
                error: function(xhr) {
                    $(".save-draft, .submit-payment").prop("disabled", false);
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, message) {
                            $('#${field}_error').text(message);
                        });
                    } else {
                        Swal.fire("Error!", "Something went wrong. Try again.", "error");
                    }
                }
            });
        }


        function showPaymentInitiationPopupformArenew(application_id, transactionId, transactionDate,
            applicantName, amount) {
            Swal.fire({
                title: "<span style='color:#0d6efd;'>Initiate Payment</span>",
                html: `<div class="text-start" style="font-size: 14px; padding: 10px 0;">
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
        </div>`,
                icon: "info",
                showCancelButton: true,
                confirmButtonText: 'Pay Now',
                cancelButtonText: 'Cancel',
                width: '40%',
                showCloseButton: true,
                customClass: {
                    popup: 'swal2-popup-sm'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simulate delay and then show payment success popup
                    setTimeout(() => {
                        showPaymentSuccessPopupformArenew(application_id, transactionId,
                            transactionDate, applicantName, amount);
                    }, 1000);
                }
            });
        }


        function showPaymentSuccessPopupformArenew(application_id, transactionId, transactionDate,
            applicantName, amount) {

            let loginId = application_id;
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful',
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
            <div style="word-break: break-word;">${application_id}</div>

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
            <button class="btn btn-info btn-sm mb-2" onclick="paymentreceiptrenew('${application_id}')">
                <i class="fa fa-file-pdf-o text-danger"></i> 
                <i class="fa fa-download text-danger"></i>
                Download Receipt
            </button>
            <p class="mt-3"><strong>Download Your Application PDF:</strong></p>
            <button class="btn btn-primary btn-sm me-1" onclick="downloadPDFformArenew('${loginId}')">English PDF</button>
            
            </div>
        </div>
        </div>
        `,
                confirmButtonText: 'OK',
                width: '40%',
                customClass: {
                    popup: 'swal2-popup-sm'
                }
            }).then(() => {
                window.location.href = BASE_URL + "/dashboard"; // Redirect or reset form as needed
            });
        }




        // ----------------------renew end-----------------------



        function showDeclarationPopupformA(formData) {
            Swal.fire({
                title: '<h5 class="mb-3" style="color: white; background-color: #0d6efd; padding: 10px 20px; text-align:left;">📋 Instructions & Declaration</h5>',
                html: `
            <div style="text-align: left; max-height: 500px; overflow-y: auto; padding: 0 10px; font-size: 14px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                <ol class="instruct" style="margin-left: 20px; padding-left: 10px;">
                    <li>
                      <span style="color: #0d6efd; font-weight: 600;">Fees:</span> 
                      <ol type="i" style="margin-left: 20px; margin-top: 5px;">
                        <li>Fees Issue for <strong> Electrical Contractor/s Licence-Grade "EA"</strong> from <span style="color:#198754;">01.01.2024</span> onwards is <span style="color:#dc3545; font-weight:600;">Rs. 12,000/-</span>.</li>
                        <li>The fee must be paid by <strong>Demand Draft</strong> from any <span style="color:#0d6efd;">Scheduled Bank</span> or <span style="color:#0d6efd;">Co-operative Bank</span>, in favour of <strong>Secretary, Electrical Licensing Board, Chennai – 600 032</strong>, payable at Chennai. <em style="color:#6c757d;">Other methods of payment will not be accepted.</em></li>
                      </ol>
                    </li>
                    <li>
                      The <span style="color:#0d6efd; font-weight:600;">applicant’s signature</span> and <span style="color:#0d6efd; font-weight:600;">photo</span> affixed in the application must be attested by a <span style="color:#198754;">Gazetted Officer</span>.
                    </li>
                    <li>
                      <u><strong>With Experience:</strong></u>
                      <ul style="margin-left: 20px; list-style-type: disc;">
                        <li>Two years experience in erection or operation and maintenance in High Voltage installation.</li>
                        <li><strong>OR</strong></li>
                        <li>The applicant should hold a <strong>Electrical Contractor/s Licence-Grade "EA"</strong> from the Department of Technical Education, Chennai.</li>
                      </ul>
                    </li>
                    <li>The applicant should possess a <span style="color:#0d6efd; font-weight:600;">Diploma</span> or <span style="color:#0d6efd; font-weight:600;">Degree</span> in Electrical Engineering or an <span style="color:#0d6efd; font-weight:600;">A.M.I.E.</span> Certificate (Part A & B).</li>
                    <li><span style="color:#0d6efd; font-weight:600;">Photographs:</span> Three passport-size photographs (6cm x 4cm), taken within the last three months, must be provided.</li>
                    <li><span style="color:#0d6efd; font-weight:600;">Signature:</span> Applicant’s signature in triplicate on a separate sheet of paper must be provided.</li>
                    <li><span style="color:#0d6efd; font-weight:600;">Proof of Age:</span> Original and photocopy of age proof document must be submitted.</li>
                    <li><span style="color:#0d6efd; font-weight:600;">Application Form:</span> All columns must be filled clearly in words and figures. No column should be left blank.</li>
                    <li>Application should be in the <strong>prescribed form only</strong>.</li>
                </ol>

                <div class="form-check mt-4">
                    <input type="checkbox" class="form-check-input" id="declaration-agree-renew">
                    <label for="declaration-agree-renew" class="form-check-label" style="font-weight: 600;">
                        I have read and agree to the above instructions.
                    </label>
                    <div class="text-danger mt-2 d-none" id="declaration-error-renew">You must agree to proceed.</div>
                </div>
            </div>
        `,
                showCancelButton: true,
                confirmButtonText: "Proceed",
                cancelButtonText: "Cancel",
                width: '80%',
                customClass: {
                    popup: 'swal-xl',
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                didOpen: () => {
                    const confirmBtn = Swal.getConfirmButton();
                    confirmBtn.disabled = true;
                    const checkbox = Swal.getHtmlContainer().querySelector(
                        "#declaration-agree-renew");

                    if (checkbox) {
                        checkbox.addEventListener("change", () => {
                            confirmBtn.disabled = !checkbox.checked;
                        });
                    }
                },
                preConfirm: () => {
                    const isChecked = Swal.getHtmlContainer().querySelector(
                        "#declaration-agree-renew")?.checked;
                    if (!isChecked) {
                        Swal.getHtmlContainer().querySelector("#declaration-error-renew").classList
                            .remove("d-none");
                        return false;
                    }
                    return true;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitFormAFinal(formData, "submit");
                }
            });
        }


        function submitFormAFinal(formData, actionType) {
            $.ajax({
                url: "{{ route('forma.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function() {
                    $(".save-draft, .submit-payment").prop("disabled", true);
                },
                success: function(response) {
                    const loginId = response.login_id;
                    const transactionId = response.transaction_id || 'TXN123456';
                    const transactionDate = new Date().toLocaleDateString('en-GB');
                    const applicantName = $("#applicant_name").val() || "Applicant";
                    const amount = $("#amount").val() || "30000";

                    if (actionType === "draft") {
                        Swal.fire("Saved!", "Draft saved successfully!", "success").then(() => {
                            window.location.href = BASE_URL + "/dashboard";
                        });
                    } else {
                        showPaymentInitiationPopupformA(loginId, transactionId, transactionDate,
                            applicantName, amount);
                    }

                    $(".save-draft, .submit-payment").prop("disabled", false);
                },
                error: function(xhr) {
                    $(".save-draft, .submit-payment").prop("disabled", false);
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, message) {
                            // $(#${field}_error).text(message);
                            $(`#${field}_error`).text(message);
                        });
                    } else {
                        Swal.fire("Error!", "Something went wrong. Try again.", "error");
                    }
                }
            });
        }


        function showPaymentInitiationPopupformA(application_id, transactionId, transactionDate, applicantName,
            amount) {
            Swal.fire({
                title: "<span style='color:#0d6efd;'>Initiate Payment</span>",
                html: `<div class="text-start" style="font-size: 14px; padding: 10px 0;">
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
        </div>`,
                icon: "info",
                showCancelButton: true,
                confirmButtonText: 'Pay Now',
                cancelButtonText: 'Cancel',
                showCloseButton: true,
                customClass: {
                    popup: 'swal2-popup-sm'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simulate delay and then show payment success popup
                    setTimeout(() => {
                        showPaymentSuccessPopupformA(application_id, transactionId,
                            transactionDate, applicantName, amount);
                    }, 1000);
                }
            });
        }





        function showPaymentSuccessPopupformA(application_id, transactionId, transactionDate, applicantName,
            amount) {

            let loginId = application_id;
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful',
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
            <div style="word-break: break-word;">${application_id}</div>

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
            <button class="btn btn-info btn-sm mb-2" onclick="paymentreceipt('${application_id}')">
                <i class="fa fa-file-pdf-o text-danger"></i> 
                <i class="fa fa-download text-danger"></i>
                Download Receipt
            </button>
            <p class="mt-3"><strong>Download Your Application PDF:</strong></p>
            <button class="btn btn-primary btn-sm me-1" onclick="downloadPDFformA('${loginId}')">English PDF</button>

            </div>
            </div>
            </div>
            `,
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'swal2-popup-sm'
                }
            }).then(() => {
                window.location.href = BASE_URL + "/dashboard"; // Redirect or reset form as needed
            });
        }



        $("#closePopup").on("click", function() {
            $("#pdfPopup").fadeOut(function() {
                window.location.href = BASE_URL + "/dashboard";
            });
        });

        // function downloadPDF(language) {
        //     let url = (language === 'tamil') ? `${BASE_URL}/generateTamilPDF/${loginId}` : `${BASE_URL}/generate-pdf/${loginId}`;
        //     window.open(url, '_blank');
        // }

        document.addEventListener("DOMContentLoaded", function() {
            let applicantNameInput = document.getElementById("Applicant_Name");

            applicantNameInput.addEventListener("focus", function() {
                this.addEventListener("input", function() {
                    this.value = this.value.replace(/[^A-Za-z\s]/g,
                        ''); // Allow only letters and spaces
                });
            });


            let applicantFatherNameInput = document.getElementById("Fathers_Name");

            applicantFatherNameInput.addEventListener("focus", function() {
                this.addEventListener("input", function() {
                    this.value = this.value.replace(/[^A-Za-z\s]/g,
                        ''); // Allow only letters and spaces
                });
            });

            $('#previously_date').datepicker({
                dateFormat: 'dd-mm-yy',
                maxDate: -1 // yesterday
            });

            let checkbox = document.getElementById("previous_exp");
            let detailsDiv = document.getElementById("previously_details");
            let licenseInput = document.getElementById("previously_number");
            let dateInput = document.getElementById("previously_date");
            let licenseError = document.getElementById("licenseError");
            let dateError = document.getElementById("dateError");



            checkbox.addEventListener("change", function() {
                if (this.checked) {
                    detailsDiv.style.display = "flex"; // Show details section
                    licenseInput.setAttribute("required", "required");
                    dateInput.setAttribute("required", "required");
                } else {
                    detailsDiv.style.display = "none"; // Hide details section
                    licenseInput.removeAttribute("required");
                    dateInput.removeAttribute("required");
                    licenseError.textContent = "";
                    dateError.textContent = "";
                }
            });

        });


        restrictToLetters("[name='institute_name[]']");
        restrictToLetters("[name='work_level[]']");
        restrictToLetters("[name='Designation[]']");

        document.querySelectorAll(".percentage-input").forEach(input => {
            input.addEventListener("blur", function() {
                let value = parseFloat(this.value); // Convert to float
                let errorSpan = this.nextElementSibling;

                if (isNaN(value) || value < 1 || value > 99) {
                    errorSpan.textContent = "Please enter a valid number between 1 and 99.";
                    this.classList.add("is-invalid"); // Adds red border
                } else {
                    errorSpan.textContent = "";
                    this.classList.remove("is-invalid");
                }
            });
        });


        // Form validation on submit
        // document.getElementById("competency_form_ws").addEventListener("submit", function(event) {

        // });

    });




    function showDeclarationModal(form_name) {

        let appl_types = $('#appl_type').val();

        let form_cost;

        if (appl_types == 'R') {
            if (form_name == 'A') {
                form_cost = 6000
            }
        } else {
            if (form_name == 'A') {
                form_cost = 12000
            }
        }

        const modal = new bootstrap.Modal(document.getElementById('declarationModal'));

        modal.show();


        document.getElementById('ea_fees').textContent = 'Rs.' + form_cost + '/-';

        document.addEventListener("DOMContentLoaded", function() {
            let applicantNameInput = document.getElementById("applicant_name");

            applicantNameInput.addEventListener("focus", function() {
                this.addEventListener("input", function() {
                    this.value = this.value.replace(/[^A-Za-z\s]/g,
                        ''); // Allow only letters and spaces
                });
            });
        });

        document.getElementById('ea_declarationProceedBtn').onclick = function() {
            const checkbox = document.getElementById('declaration-agree');
            const errorMsg = document.getElementById('declaration-error');

            if (!checkbox.checked) {
                errorMsg.classList.remove('d-none');
                return;
            }

            errorMsg.classList.add('d-none');
            modal.hide();

            var formData = new FormData($('#competency_form_a')[0]);
            var actionType = $(document.activeElement).hasClass("save-draft") ? "draft" : "submit";
            formData.append("form_action", actionType);

            let applicationId = $('#application_id').val();

            let url = applicationId ?
                "{{ route('forma.update', ['appl_id' => '__APPL_ID__']) }}".replace('__APPL_ID__', applicationId) :
                "{{ route('forma.store') }}";

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

                    if (response.status == 200) {
                        const login_id = window.login_id || "{{ auth()->user()->login_id ?? '' }}";
                        const application_id = response.application_id;
                        const transactionDate = new Date().toLocaleDateString(
                            'en-GB'); // e.g., 23/06/2025
                        const applicantName = response.applicantName || 'N/A';
                        const amount = form_cost;
                        const transactionId = "TRX" + Math.floor(100000 + Math.random() *
                            900000); // random ID
                        const payment_mode = 'UPI';

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
                                    url: "{{ route('payment.updatePayment') }}",
                                    type: "POST",
                                    data: {
                                        login_id: login_id,
                                        application_id: application_id,
                                        transaction_id: transactionId,
                                        transactionDate: transactionDate,
                                        amount: amount,
                                        payment_mode: payment_mode,
                                        _token: $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },

                                    success: function(response) {
                                        if (response.status == 200) {
                                            showPaymentSuccessPopup(application_id,
                                                transactionId, transactionDate,
                                                applicantName, amount);
                                        } else {
                                            alert(response.message ||
                                                'Something went wrong!');
                                        }
                                    },
                                    error: function(xhr) {
                                        if (xhr.responseJSON && xhr.responseJSON
                                            .errors) {
                                            let messages = Object.values(xhr
                                                    .responseJSON.errors).flat()
                                                .join("\n");
                                            // alert("Validation errors:\n" + messages);
                                            Swal.fire("Error", messages, "danger");
                                        } else {
                                            alert("An error occurred: " + xhr
                                                .responseText);
                                        }
                                    }
                                });

                            } else {
                                Swal.fire("Payment Failed", "Application saved as draft",
                                    "danger");
                            }
                        });
                    } else {
                        return
                    }
                },
                error: function(xhr) {
                    alert("An error occurred: " + xhr.responseText);
                }
            });
        };

    }

    function getPaymentsService(licence_code, issued_licence, appl_type, callback) {

        return new Promise((resolve, reject) => {


            $.ajax({
                url: "{{ route('licences.getPaymentDetails') }}",
                type: "POST",
                data: {
                    licence_code: licence_code,
                    issued_licence: issued_licence,
                    appl_type: appl_type,
                    _token: $('meta[name="csrf-token"]').attr(
                        'content')
                },
                success: function(response) {

                    if (response.status == 'success') {
                        resolve(response.fees_details);
                    } else {
                        Swal.fire("Error", response.message, "danger");
                        reject(response);
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let messages = Object.values(xhr.responseJSON.errors).flat().join("\n");
                        Swal.fire("Error", messages, "danger");
                    } else {
                        Swal.fire("An error occurred: " + xhr.responseText);
                    }
                    reject(xhr);
                }
            });
        });

    }


    async function showDeclarationPopup(licence_code) {

        try {

            let total_fees, renewl_fees, lateFee, lateMonths, form_cost, form_name, licence, renewalAmoutStartson, latefee_amount, latefee_starts, form_instruct, fees_date;

            const appl_type = $('#appl_type').val();
            const issued_licence = $('#license_number').val();

            const formResponse = await $.ajax({
                url: "{{ route('licences.getFormInstruction') }}",
                type: "POST",
                data: {
                    appl_type,
                    licence_code,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (formResponse.status == 200) {
                form_instruct = formResponse.data;
            } else {
                Swal.fire("Error", "Instruction not available", "error");
                return;
            }

            const data = await getPaymentsService(licence_code, issued_licence, appl_type);


            if (data) {
                if (data.lateFees < 0) {
                    actual_fees = data.basic_fees;
                    total_fees = data.total_fees;
                    lateMonths = data.late_months;
                } else {
                    actual_fees = data.basic_fees;
                    lateMonths = data.late_months;
                    total_fees = data.total_fees;
                    lateFee = data.lateFees;
                }
            }

            fees_date = data.fees_start_date
            certificate_name = data.certificate_name

            console.log(certificate_name);



            // 🔹 Now you can safely use form_cost everywhere below
            const modalEl = document.getElementById('competencyInstructionsModal');
            const agreeCheckbox = modalEl.querySelector('#declaration-agree-renew');
            const errorText = modalEl.querySelector('#declaration-error-renew');
            const proceedBtn = modalEl.querySelector('#proceedPayment');

            document.getElementById('certificate_name').textContent = certificate_name;
            document.getElementById('fees_starts_from').textContent = fees_date;
            document.getElementById('form_fees').textContent = 'Rs.' + actual_fees + '/-';

            // Reset state
            agreeCheckbox.checked = false;
            errorText.classList.add('d-none');

            // Show modal
            const modalBody = modalEl.querySelector('#instructionContent');


            const delta = JSON.parse(form_instruct);

            console.log(delta);
            const converter = new QuillDeltaToHtmlConverter(delta.ops, {
                multiLineParagraph: false,
                listItemTag: "li",
                paragraphTag: "p"
            });

            const html = converter.convert();


            modalBody.innerHTML = html;
            const el = document.querySelector("#instructionContent");
            console.log("innerHTML:", el.innerHTML);
            console.log("textContent:", el.textContent);

            // return false;

            const modal = new bootstrap.Modal(modalEl, {
                backdrop: 'static',
                keyboard: false
            });
            modal.show();

            // Remove old listeners
            proceedBtn.replaceWith(proceedBtn.cloneNode(true));

            // Re-assign click listener
            modalEl.querySelector('#proceedPayment').addEventListener('click', async function() {
                if (!agreeCheckbox.checked) {
                    errorText.classList.remove('d-none');
                    return;
                }

                modal.hide();

                let formData = new FormData($('#competency_form_ws')[0]);
                let applicationId = $('#application_id').val();
                let formUrl;

                if (applicationId) {
                    if (appl_type === 'R') {
                        formUrl = "{{ route('form.draft_renewal_submit', ['appl_id' => '__APPL_ID__']) }}"
                            .replace('__APPL_ID__', applicationId);
                    } else {
                        formUrl = "{{ route('form.update', ['appl_id' => '__APPL_ID__']) }}"
                            .replace('__APPL_ID__', applicationId);
                    }
                } else {
                    formUrl = "{{ route('form.store') }}";
                }
                try {
                    // 🔹 Submit form
                    let saveResponse = await $.ajax({
                        url: formUrl,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        error: function(xhr) {
                            console.error("Uncaught AJAX Error:", xhr);
                        }
                    });

                    if (saveResponse.status === "success") {


                        let form_type = appl_type === 'R' ? 'Renewal' : 'Fresh';

                        const login_id = window.login_id || "{{ auth()->user()->login_id ?? '' }}";
                        const application_id = saveResponse.application_id;

                        const transactionDate = saveResponse.date_apps;
                        const applicantName = saveResponse.applicantName || 'N/A';
                        const type_apps = saveResponse.type_of_apps || 'N/A';
                        const form_name = saveResponse.form_name || 'N/A';
                        const amount = total_fees;
                        const licence_name = saveResponse.licence_name || 'N/A';

                        console.log(application_id);
                        // const serviceCharge = 10;
                        // let lateFee = typeof lateFee !== "undefined" ? lateFee : 0;
                        // let total_charge = Number(amount) + Number(serviceCharge);
                        let lateFeeRow = "";
                        if (lateFee > 0) {
                            lateFeeRow = `
                                <tr>
                                    <th style="text-align: left; padding: 6px 10px; color: #555;">Late Fees (${lateMonths} Months)</th>
                                    <td style="text-align: right; padding: 6px 10px; font-weight: 500;">Rs. ${lateFee} </td>
                                </tr>
                            `;
                        }


                        const transactionId = "TRX" + Math.floor(100000 + Math.random() * 900000);
                        const payment_mode = 'UPI';

                        // 🔹 Show payment popup
                        Swal.fire({
                            title: "<span style='color:#0d6efd;'>₹ Payment Details</span>",
                            html: `
                            <div class="text-start" style="font-size: 14px; padding: 10px 0;">
                                <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
                                    <tbody>
                                            <tr>
                                            <th style="text-align: left; padding: 6px 10px; color: #555;">Application ID</th>
                                            <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${application_id}</td>
                                            </tr>
                                            <tr>
                                            <th style="text-align: left; padding: 6px 10px; color: #555;">Applicant Name</th>
                                            <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${applicantName}</td>
                                            </tr>
                                            <tr>
                                            <th style="text-align: left; padding: 6px 10px; color: #555;">Type of Application</th>
                                            <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${licence_name}</td>
                                            </tr>
                                            <tr>
                                            <th style="text-align: left; padding: 6px 10px; color: #555;">Type of Form</th>
                                            <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${form_type}</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align: left; padding: 6px 10px; color: #555;">Date</th>
                                                <td style="text-align: right; padding: 6px 10px; font-weight: 500;">${transactionDate}</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: left; padding: 10px; color: #333;">Application Fees</th>
                                                    <td style="text-align: right; padding: 10px; font-weight: bold; color: #0d6efd;">Rs. ${actual_fees} </td>
                                                    </tr>
                                                            ${lateFeeRow}
                                                                <tr>
                                                                    <th style="text-align: left; padding: 6px 10px; color: #555;">Total</th>
                                                                    <td style="text-align: right; padding: 6px 10px; font-weight: 500;">Rs. ${amount}</td>
                                                                    </tr>
                                                                    </tbody>
                                                                    </table>
                                                                    </div>
                                                                    `,
                            width: '515px',
                            showCancelButton: true,
                            confirmButtonText: '<span class="btn btn-primary px-4 pr-4 payment">Pay Now</span>',
                            cancelButtonText: '<span class="btn btn-danger px-4">Cancel</span>',
                            showCloseButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            customClass: {
                                popup: 'swal2-border-radius',
                                actions: 'd-flex justify-content-around mt-3',
                            },
                            buttonsStyling: false,
                            footer: '<div><span style="font-size: 13px;">Note: </span><span style="font-size: 13px;color: red;">Total Amount will be including service charges of payment gateway as applicable</span>',
                            preConfirm: async () => {
                                const paymentResponse = await $.ajax({
                                    url: "{{ route('payment.updatePayment') }}",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        login_id,
                                        application_id,
                                        applicantName,
                                        transaction_id: transactionId,
                                        transactionDate,
                                        amount,
                                        payment_mode,
                                        form_name,
                                        form_type,
                                        lateFee,
                                        lateMonths

                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                // ✅ Success condition
                                if (paymentResponse.status === 200) {
                                    // alert(paymentResponse.status);
                                    showPaymentSuccessPopup(application_id, transactionId, transactionDate, applicantName, amount, form_type, licence_name);


                                } else {
                                    Swal.fire({
                                        title: "Payment Failed",
                                        text: paymentResponse.message || "Something went wrong!",
                                        icon: "error",
                                        timer: 3000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        // window.location.href = BASE_URL + "/dashboard";
                                    });
                                }
                            }

                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    title: "Payment Failed!",
                                    text: "Application Saved as Draft",
                                    icon: "error",
                                    timer: 3000, // Auto close in 3 seconds
                                    timerProgressBar: true
                                }).then(() => {
                                    window.location.href = "BASE_URL/dashboard";
                                }); // your redirect URL
                            }
                        });
                    } else {
                        Swal.fire("Form Submission Failed", "Application not submitted", "error");
                    }
                } catch (xhr) {
                    console.error("❌ Form Submit Error:", xhr);

                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        const errors = xhr.responseJSON.errors;

                        // Remove any old error labels
                        $('.server-error').remove();
                        $('.is-invalid').removeClass('is-invalid');

                        $.each(errors, function(field, messages) {
                            // Find input by name (supports array names)
                            const input = $('[name="' + field + '"]');
                            if (input.length) {
                                input.addClass('is-invalid');
                                input.after('<span class="text-danger server-error">' + messages[0] + '</span>');
                            }
                        });

                        Swal.fire({
                            icon: "warning",
                            title: "Validation Error",
                            text: "Please correct the highlighted fields."
                        });
                        return;
                    }
                }

            });
        } catch (err) {
            // console.error("Error fetching form cost or saving form:", err);

            // console.error("❌ Uncaught AJAX Error:", xhr);

            // Check if Laravel validation failed (422)
            // if (xhr.status === 422 && xhr.responseJSON?.errors) {
            //     // You can show validation messages here
            //     $.each(xhr.responseJSON.errors, function (key, msg) {
            //         console.log(key, msg);
            //     });
            // } else {
            //     Swal.fire({
            //         icon: "error",
            //         title: "Request Failed",
            //         text: xhr.responseText || "Something went wrong. Please try again."
            //     });
            // }
        }
    }

    function showPaymentSuccessPopup(loginId, transactionId, transactionDate, applicantName, amount, form_type, licence_name) {

        // alert(applicantName);
        $("#ps_applicantName_competency").text(applicantName);
        $("#ps_applicationId_competency").text(loginId);
        $("#ps_licenceName_competency").text(licence_name);
        $("#ps_transactionId_competency").text(transactionId);
        $("#ps_transactionDate_competency").text(transactionDate);
        $("#ps_amount_competency").text(amount);

        // store ID globally for download actions
        window.paymentAppId = loginId;
        window.paymentFormType = form_type;
        $("#paymentSuccessModal").modal({
            backdrop: 'static',
            keyboard: false
        });

        // Show bootstrap modal
        $("#paymentSuccessModal").modal("show");


        // Swal.fire({
        //     title: `<h3 style="color:#198754; font-size:1.5rem;">Payment Successful!</h3>`,
        //     html: `
        //     <div style="font-size: 14px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: flex-start;">
        //         <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; max-width: 90%; margin: 0 auto;">
        //             <div style="
        //             display: grid;
        //             grid-template-columns: auto 1fr;
        //             gap: 7px 50px;
        //             font-size: 14px;
        //             max-width: 350px;
        //             border-right:2px solid #0d6efd;
        //             padding: 0px 15px;
        //             ">
        //             <div style="font-weight: bold;">Applicant Name:</div>
        //             <div>${applicantName}</div>
        //             <div style="font-weight: bold;">Application ID:</div>
        //             <div style="word-break: break-word;">${loginId}</div>

        //             <div style="font-weight: bold;">Type of Application:</div>
        //             <div style="word-break: break-word;">${licence_name}</div>

        //             <div style="font-weight: bold;">Transaction ID:</div>
        //             <div style="word-break: break-word;">${transactionId}</div>

        //             <div style="font-weight: bold;">Transaction Date:</div>
        //             <div>${transactionDate}</div>


        //             <div style="font-weight: bold;">Amount Paid:</div>
        //             <div>${amount}</div>
        //             </div>
        //             <div style="min-width: 200px; text-align: center;">
        //                 <p><strong>Download Your Payment Receipt:</strong></p>
        //                 <button class="btn btn-info btn-sm mb-2" onclick="paymentreceipt('${loginId}')">
        //                     <i class="fa fa-file-pdf-o text-danger"></i> 
        //                     <i class="fa fa-download text-danger"></i>
        //                     Download Receipt
        //                     </button>
        //                     <p class="mt-2"><strong>Download Your Application PDF:</strong></p>
        //                     <button class="btn btn-primary btn-sm me-1" onclick="downloadPDF('english', '${loginId}')"><i class="fa fa-file-pdf-o text-danger"></i> 
        //                         English</button>
        //                         <button class="btn btn-success btn-sm" onclick="downloadPDF('tamil', '${loginId}')"><i class="fa fa-file-pdf-o text-danger"></i> 
        //                             Tamil</button>
        //                             </div>
        //                             </div>
        //                             </div>
        //                             `,
        //     // 🧹 removed: icon: "success",
        //     width: '50%',
        //     customClass: {
        //         popup: 'swal2-border-radius p-3'
        //     },
        //     confirmButtonText: "Go to Dashboard",
        //     confirmButtonColor: "#0d6efd",
        //     allowOutsideClick: false,
        //     allowEscapeKey: false,
        //     showCloseButton: false,
        //     didOpen: () => {
        //         const iconEl = document.querySelector('.swal2-icon');
        //         if (iconEl) {
        //             iconEl.style.display = 'none'; // hide icon if still rendered
        //         }

        //         const popup = document.querySelector('.swal2-popup');
        //         if (popup) {
        //             popup.style.marginTop = '10px';
        //             popup.style.padding = '10px 20px';
        //         }

        //         const container = document.querySelector('.swal2-container');
        //         if (container) {
        //             container.style.alignItems = 'flex-start';
        //             container.style.paddingTop = '20px';
        //         }
        //     },
        //     willClose: () => {
        //         window.location.href = BASE_URL + '/dashboard';
        //     }
        // });

    }



    // Open Payment Receipt in New Tab
    //  function paymentreceipt(loginId) {
    //     window.open(`/payment-receipt/${loginId}`, '_blank');
    // }

    function downloadPDF(language) {
        let url = (language === 'tamil') ? `${BASE_URL}/generateTamilPDF/${window.paymentAppId}` : `${BASE_URL}/generate-pdf/${window.paymentAppId}`;
        window.open(url, '_blank');
    }



    // **Close PDF Popup and Redirect**
    function restrictToLetters(inputSelector) {
        $(document).on("input", inputSelector, function() {
            this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
        });
    }


    function maskAadhaarFull(aadhaar) {
        aadhaar = aadhaar.replace(/\D/g, '');
        if (aadhaar.length !== 12) return 'Invalid Aadhaar';
        return 'XXXXXXXX' + aadhaar.slice(-4);
    }




    // ---------------verify formA license---------------

    function verifyCompetencyLicense() {
        const licenseNumber = $('#competency_number').val().trim();
        const date = $('#competency_certificate_validity').val().trim();
        const resultBox = $('#competency_verify_result');

        if (!licenseNumber || !date) {
            resultBox.text('⚠ Enter license number and date.');
            return;
        }

        resultBox.html(`<span class="text-info">Verifying...</span>`);


        $.ajax({
            url: "{{ route('verifylicenseformAcc') }}",
            method: 'POST',
            data: {
                license_number: licenseNumber,
                date: date,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.exists) {
                    resultBox.html('<span class="text-success">&#10004; License verified.</span>');
                } else {
                    resultBox.html('<span class="text-white">&#10060; License not found.</span>');
                }
            },
            error: function(xhr) {
                resultBox.html('<span class="text-white">🚫 Error verifying license. Try again.</span>');
                console.error(xhr.responseText);
            }
        });
    }

    // Trigger verification on input change or blur
    $('#competency_number, #competency_certificate_validity').on('change blur', function() {
        verifyCompetencyLicense();
    });





    function paymentreceipt() {
        if (!window.paymentAppId) {
            alert("Application ID not found!");
            return;
        }
        window.open(`${BASE_URL}/payment-receipt/${window.paymentAppId}`, "_blank");
    }


    // **Close PDF Popup and Redirect**
    function restrictToLetters(inputSelector) {
        $(document).on("input", inputSelector, function() {
            this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
        });
    }


    function maskAadhaarFull(aadhaar) {
        aadhaar = aadhaar.replace(/\D/g, '');
        if (aadhaar.length !== 12) return 'Invalid Aadhaar';
        return 'XXXXXXXX' + aadhaar.slice(-4);
    }




    // ---------------verify formA license---------------

    function verifyCompetencyLicense() {
        const licenseNumber = $('#competency_number').val().trim();
        const date = $('#competency_certificate_validity').val().trim();
        const resultBox = $('#competency_verify_result');

        if (!licenseNumber || !date) {
            resultBox.text('⚠ Enter license number and date.');
            return;
        }

        resultBox.html(`<span class="text-info">Verifying...</span>`);


        $.ajax({
            url: "{{ route('verifylicenseformAcc') }}",
            method: 'POST',
            data: {
                license_number: licenseNumber,
                date: date,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.exists) {
                    resultBox.html('<span class="text-success">&#10004; License verified.</span>');
                } else {
                    resultBox.html('<span class="text-white">&#10060; License not found.</span>');
                }
            },
            error: function(xhr) {
                resultBox.html('<span class="text-white">🚫 Error verifying license. Try again.</span>');
                console.error(xhr.responseText);
            }
        });
    }

    // Trigger verification on input change or blur
    $('#competency_number, #competency_certificate_validity').on('change blur', function() {
        verifyCompetencyLicense();
    });


    // ---------------------------------------------

    $(document).on('change blur', '.competency_number, .competency_validity', function() {
        const $parent = $(this).closest('.competency-fields');

        // Safe value retrieval with fallback to empty string
        const licenseNumber = ($parent.find('.competency_number').val() || '').trim();
        const date = ($parent.find('.competency_validity').val() || '').trim();
        const resultBox = $parent.find('.competency_verify_result');

        if (!licenseNumber || !date) {
            resultBox.text('⚠ Enter license number and date.');
            return;
        }

        resultBox.html(`<span class="text-info">Verifying...</span>`);

        $.ajax({
            url: "{{ route('verifylicenseformAcc') }}",
            method: 'POST',
            data: {
                license_number: licenseNumber,
                date: date,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.exists) {
                    resultBox.html('<span class="text-success">&#10004; License verified.</span>');
                } else {
                    resultBox.html('<span class="text-danger">&#10060; License not found.</span>');
                }
            },
            error: function(xhr) {
                resultBox.html('<span class="text-danger">🚫 Error verifying license. Try again.</span>');
                console.error(xhr.responseText);
            }
        });
    });




    // ---------------formA staff license check----------------------


    // $(document).on('change blur', '.cc_number, .cc_validity', function() {
    //     const $row = $(this).closest('.staff-fields');
    //     const licenseNumber = $row.find('.cc_number').val().trim();
    //     const date = $row.find('.cc_validity').val().trim();
    //     const resultBox = $row.find('.competency_verify_result');

    //     if (!licenseNumber || !date) {
    //         resultBox.text('⚠ Enter certificate number and validity date.');
    //         return;
    //     }

    //     resultBox.html(`<span class="text-info">Verifying...</span>`);


    //     $.ajax({
    //         url: "{{ route('verifylicenseformAcc') }}",
    //         method: 'POST',
    //         data: {
    //             license_number: licenseNumber,
    //             date: date,
    //             _token: $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             if (response.exists) {
    //                 resultBox.html('<span class="text-success">&#10004; License verified.</span>');
    //             } else {
    //                 resultBox.html('<span class="text-danger">&#10060; License not found.</span>');
    //             }
    //         },
    //         error: function(xhr) {
    //             resultBox.html(
    //                 '<span class="text-danger">🚫 Error verifying license. Try again.</span>');
    //             console.error(xhr.responseText);
    //         }
    //     });
    // });


    // ------------------------------

    function verifyEALicense() {
        const licenseNumber = $('#previous_experience_lnumber').val().trim();
        const date = $('#previous_experience_lnumber_validity').val().trim();
        const resultBox = $('#competency_verifyea_result');

        if (!licenseNumber || !date) {
            resultBox.text('⚠ Enter license number and date.');
            return;
        }

        resultBox.html(`<span class="text-info">Verifying...</span>`);


        $.ajax({
            url: "{{ route('verifylicenseformAea') }}",
            method: 'POST',
            data: {
                license_number: licenseNumber,
                date: date,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.exists) {
                    resultBox.html('<span class="text-success">&#10004; License verified.</span>');
                } else {
                    resultBox.html('<span class="text-danger">&#10060; License not found.</span>');
                }
            },
            error: function(xhr) {
                resultBox.html('<span class="text-danger">🚫 Error verifying license. Try again.</span>');
                console.error(xhr.responseText);
            }
        });
    }

    // Trigger verification on input change or blur
    $('#previous_experience_lnumber, #previous_experience_lnumber_validity').on('change blur', function() {
        verifyEALicense();
    });

    // --------------------------------5--------------------------------

    // $('#previous_application_number, #previous_application_validity').on('change blur', function() {
    //     const licenseNumber = $('#previous_application_number').val().trim();
    //     const date = $('#previous_application_validity').val().trim();
    //     const resultBox = $('#verifyea_result');

    //     if (!licenseNumber || !date) {
    //         resultBox.text('⚠ Enter license number and date.');
    //         return;
    //     }

    //     resultBox.html(`<span class="text-info">Verifying...</span>`);


    //     $.ajax({
    //         url: "{{ route('verifylicenseformAea') }}",
    //         method: 'POST',
    //         data: {
    //             license_number: licenseNumber,
    //             date: date,
    //             _token: $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             if (response.exists) {
    //                 resultBox.html('<span class="text-success">&#10004; License verified.</span>');
    //             } else {
    //                 resultBox.html('<span class="text-danger">&#10060; License not found.</span>');
    //             }
    //         },
    //         error: function(xhr) {
    //             resultBox.html(
    //                 '<span class="text-danger">🚫 Error verifying license. Try again.</span>');
    //             console.error(xhr.responseText);
    //         }
    //     });
    // });


    // -------------------

    $(document).on('change blur', '.ea_license_number, .ea_license_validity', function() {
        const $parent = $(this).closest('.experience-fields');
        const licenseNumber = $parent.find('.ea_license_number').val().trim();
        const date = $parent.find('.ea_license_validity').val().trim();
        const resultBox = $parent.find('.ea_license_result');

        if (!licenseNumber || !date) {
            resultBox.text('⚠ Enter license number and date.');
            return;
        }

        resultBox.html(`<span class="text-info">Verifying...</span>`);


        $.ajax({
            url: "{{ route('verifylicenseformAea') }}",
            method: 'POST',
            data: {
                license_number: licenseNumber,
                date: date,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.exists) {
                    resultBox.html('<span class="text-success">&#10004; License verified.</span>');
                } else {
                    resultBox.html('<span class="text-danger">&#10060; License not found.</span>');
                }
            },
            error: function(xhr) {
                resultBox.html(
                    '<span class="text-danger">🚫 Error verifying license. Try again.</span>');
                console.error(xhr.responseText);
            }
        });
    });
</script>

</body>

</html>