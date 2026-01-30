async function showInstructPopup(licence_code,login_id) {

    try {

        let total_fees, renewl_fees, lateFee, lateMonths, form_cost, form_name, licence, renewalAmoutStartson, latefee_amount, latefee_starts, form_instruct, fees_date;

        const appl_type = $('#appl_type').val();
        const issued_licence = $('#license_number').val();

        

        const formResponse = await $.ajax({
            url: BASE_URL + "/licences/getFormInstruction",
            type: "POST",
            data: {
                appl_type,
                licence_code,
                _token: $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (formResponse.status == 200) {
            form_instruct = formResponse.data;
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

        // console.log(data);
        

        fees_date = data.fees_start_date
        certificate_name = data.certificate_name



        // 🔹 Now you can safely use form_cost everywhere below
        const modalEl = document.getElementById('competencyInstructionsModalP');
        const agreeCheckbox = modalEl.querySelector('#declaration-agree-renew');
        const errorText = modalEl.querySelector('#declaration-error-renew');
        const proceedBtn = modalEl.querySelector('#proceedtoPayment');

        document.getElementById('p_certificate_name').textContent = certificate_name;
        document.getElementById('p_fees_starts_from').textContent = fees_date;
        document.getElementById('p_form_fees').textContent = 'Rs.' + actual_fees + '/-';

        // Reset state
        agreeCheckbox.checked = false;
        errorText.classList.add('d-none');

        // Show modal
        const modalBody = modalEl.querySelector('#instructionContent');

        let html = '<p class="mt-3 text-center" style="color:#0069d9">*** No instructions available. ***</p>';
        if (form_instruct) {
            try {
                const delta = JSON.parse(form_instruct);
        
                if (delta && delta.ops) {
                    const converter = new QuillDeltaToHtmlConverter(delta.ops, {
                        multiLineParagraph: false,
                        listItemTag: "li",
                        paragraphTag: "p"
                    });
        
                    html = converter.convert();
                } else {
                    console.warn('Delta structure is invalid:', delta);
                }
            } catch (e) {
                console.error('Error parsing form_instruct JSON:', e, form_instruct);
            }
        } else {
            console.warn('form_instruct is null or empty:', form_instruct);
        }


        modalBody.innerHTML = html;
        const el = document.querySelector("#instructionContent");

        const modal = new bootstrap.Modal(modalEl, {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();

        
        // Remove old listeners
        const newProceedBtn = proceedBtn.cloneNode(true);
        proceedBtn.replaceWith(newProceedBtn);

        newProceedBtn.addEventListener('click', async function () {
            if (!agreeCheckbox.checked) {
                errorText.classList.remove('d-none');
                return;
            }
            modal.hide();
            let formData = new FormData($('#competency_form_p')[0]);
            let applicationId = $('#application_id').val();
            let formUrl;

            if (applicationId) {
                // if (appl_type === 'R') {
                //     formUrl = "{{ route('form.draft_renewal_submit', ['appl_id' => '__APPL_ID__']) }}"
                //         .replace('__APPL_ID__', applicationId);
                // } else {
                formUrl = BASE_URL + "/form_p/update";
                    // }
            } else {
                formUrl = BASE_URL + "/form_p/store";
            }


            console.log(formUrl);
            
            
            try {

                // 🔹 Submit form
                let saveResponse = await $.ajax({
                    url: formUrl,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr) {
                        console.error("Uncaught AJAX Error:", xhr);
                    }
                });

                if (saveResponse.status === "success") {

                    let form_type = appl_type === 'R' ? 'Renewal' : 'Fresh';
                    const application_id = saveResponse.application_id;
                    const transactionDate = saveResponse.date_apps;
                    const applicantName = saveResponse.applicantName || 'N/A';
                    const type_apps = saveResponse.type_of_apps || 'N/A';
                    const form_name = saveResponse.form_name || 'N/A';
                    const amount = total_fees;
                    const licence_name = saveResponse.licence_name || 'N/A';

                
                    let lateFeeRow = "";
                    if (lateFee > 0) {
                        lateFeeRow = `
                                <tr>
                                    <th style="text-align: left; padding: 6px 10px; color: #555;">Late Fees (${lateMonths} Months)</th>
                                    <td style="text-align: right; padding: 6px 10px; font-weight: 500;">Rs. ${lateFee} </td>
                                </tr>`;
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
                                url: BASE_URL + '/payment/updatePaymentFormP',
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
                                window.location.href = "/dashboard";
                            }); // your redirect URL
                        }
                    });
                } else {
                    Swal.fire("Form Submission Failed", "Application not submitted", "error");
                }
            } catch (xhr) {

                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;

                    // Remove any old error labels
                    $('.server-error').remove();
                    $('.is-invalid').removeClass('is-invalid');

                    $.each(errors, function (field, messages) {

                        let input;

                        // Handle array fields (field.0, field.1 etc.)
                        if (field.includes('.')) {
                            const baseField = field.split('.')[0];
                            input = $('[name="' + baseField + '[]"]');
                        } else {
                            input = $('[name="' + field + '"]');
                        }

                        if (input.length) {
                            input.addClass('is-invalid');

                            // Prevent duplicate messages
                            if (!input.next('.server-error').length) {
                                input.after(
                                    '<span class="text-danger server-error d-block mt-1">' +
                                    messages[0] +
                                    '</span>'
                                );
                            }
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
        console.error("Error fetching form cost or saving form:", err);

        console.error("❌ Uncaught AJAX Error:", xhr);

        // Check if Laravel validation failed (422)
        if (xhr.status === 422 && xhr.responseJSON?.errors) {
            // You can show validation messages here
            $.each(xhr.responseJSON.errors, function (key, msg) {
                console.log(key, msg);
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Request Failed",
                text: xhr.responseText || "Something went wrong. Please try again."
            });
        }
    }
}

// Proceed for Payment
$(document).ready(function () {
    $('#ProceedtoPayment').on('click', function (e) {
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

        $('#education-container .education-fields').each(function () {
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
                    const minSize = 5 * 1024;   // 5 KB
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

        $('#work-container .work-fields').each(function () {
            let workLevel = $(this).find('input[name="work_level[]"]');
            let experience = $(this).find('input[name="experience[]"]');
            let designation = $(this).find('input[name="designation[]"]');
            let workDocument = $(this).find('input[name="work_document[]"]');

            if (workLevel.length && (workLevel.val() === null || workLevel.val() === "")) {
                workLevel.after('<span class="error-message text-danger d-block mt-1">Please enter the power station name.</span>');
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
                    const minSize = 5 * 1024;   // 5 KB
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


        if ($('#institute-container .institute-fields').length === 0) {
            $('#institute-table').after('<span class="error-message text-danger d-block mt-1">At least one institute entry is required.</span>');
            if (!firstErrorField) firstErrorField = $('#institute-table');
            isValid = false;
        }

        $('#institute-container .institute-fields').each(function () {
            let institute_name_address = $(this).find('textarea[name="institute_name_address[]"]');
            let duration = $(this).find('input[name="duration[]"]');
            let from_date = $(this).find('input[name="from_date[]"]');
            let to_date = $(this).find('input[name="to_date[]"]');
            let instituteDocument = $(this).find('input[name="institute_document[]"]');

            if (institute_name_address.length && (institute_name_address.val() === null || institute_name_address.val() === "")) {
                institute_name_address.after('<span class="error-message text-danger d-block mt-1">Institute name and address is required.</span>');
                if (!firstErrorField) firstErrorField = institute_name_address;
                isValid = false;
            }

            if (duration.length && (duration.val().trim() === "" || isNaN(duration.val()) || parseInt(duration.val()) < 0 || parseInt(duration.val()) > 50)) {
                duration.after('<span class="error-message text-danger d-block mt-1"> Duration is required.</span>');
                if (!firstErrorField) firstErrorField = duration;
                isValid = false;
            }

            if (from_date.length && from_date.val().trim() === "") {
                from_date.after('<span class="error-message text-danger d-block mt-1">From Date is required.</span>');
                if (!firstErrorField) firstErrorField = from_date;
                isValid = false;
            }

            if (to_date.length && to_date.val().trim() === "") {
                to_date.after('<span class="error-message text-danger d-block mt-1">To Date is required.</span>');
                if (!firstErrorField) firstErrorField = to_date;
                isValid = false;
            }

            // 🔹 File validation (supports edit + new upload)
             if (instituteDocument.length && instituteDocument.val().trim() === "") {
                instituteDocument.after('<span class="error-message text-danger d-block mt-1">Institute upload is required.</span>');
                if (!firstErrorField) firstErrorField = instituteDocument;
                isValid = false;
            } else if (instituteDocument.length && instituteDocument[0].files.length > 0) {
                const file = instituteDocument[0].files[0]; // ✅ use raw DOM element
                if (file) {
                    const allowedType = 'application/pdf';
                    const minSize = 5 * 1024;   // 5 KB
                    const maxSize = 250 * 1024; // 250 KB

                    if (file.type !== allowedType) {
                        instituteDocument.after('<span class="error-message text-danger d-block mt-1">Only PDF files are allowed for Institute upload.</span>');
                        if (!firstErrorField) firstErrorField = instituteDocument;
                        isValid = false;
                    } else if (file.size < minSize || file.size > maxSize) {
                        instituteDocument.after('<span class="error-message text-danger d-block mt-1">File size permitted only 5 KB to 200 KB.</span>');
                        if (!firstErrorField) firstErrorField = instituteDocument;
                        isValid = false;
                    }
                }
            }
            
        });


        let employer_name = document.getElementById("employer_name");
        if (employer_name && employer_name.value.trim() === "") {
            employer_name.insertAdjacentHTML(
                'afterend',
                '<span class="error-message text-danger d-block mt-1">Employer Name is required.</span>'
            );

            if (!firstErrorField) firstErrorField = $(employer_name);
            isValid = false;
        }

        console.log(isValid);

        

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
            $('html, body').animate({ scrollTop: firstErrorField.offset().top - 100 }, 500);
            return;
        }

        let license_name = $("#license_name").val();
        let login_id = $("#login_id_store").val();
        showInstructPopup(license_name,login_id);
    });



    $("#pancard").on("keyup", function () {
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

    $("#aadhaar").on("input", function () {
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

    $(document).ready(function () {
        const aadhaarInput = document.getElementById("aadhaar_doc");
        const panInput = document.getElementById("pancard_doc")

        if (aadhaarInput) {
            aadhaarInput.addEventListener("change", function () {
                const aadhaarError = aadhaarInput.parentElement.querySelector(
                    ".error-message");

                if (this.files.length !== 0 && aadhaarError) {
                    aadhaarError.remove();
                }
            });
        }

        if (panInput) {
            panInput.addEventListener("change", function () {
                const panError = panInput.parentElement.querySelector(".error-message");

                if (this.files.length !== 0 && panError) {
                    panError.remove();
                }
            });
        }
    });

    $(document).on('keyup change', '#education-container .education-fields input, #education-container .education-fields select',
        function () {
            const $field = $(this);
            if ($field.val().trim() !== '') {
                $field.nextAll('.error-message').first().remove();
                $field.closest('.work-fields').find('.error-message').filter(function () {
                    return $(this).text().includes(
                        "Please fill in at least one field");
                }).remove();
            }
        });


    $(document).on('keyup change', '#work-container .work-fields input, #work-container .work-fields select',
        function () {
            const $field = $(this);
            if ($field.val().trim() !== '') {
                $field.nextAll('.error-message').first().remove();
                $field.closest('.work-fields').find('.error-message').filter(function () {
                    return $(this).text().includes("Please fill in at least one field");
                }).remove();
            }
        });


    $(document).on('keyup change', '#institute-container .institute-fields input, #institute-container .institute-fields select, #institute-container .institute-fields textarea',
        function () {
            const $field = $(this);
            if ($field.val().trim() !== '') {
                $field.nextAll('.error-message').first().remove();
                $field.closest('.institute-fields').find('.error-message').filter(function () {
                    return $(this).text().includes("Please fill in at least one field");
                }).remove();
            }
        });
    // -----------------fathers name Validation-------------

    let isValid = true;
    let firstErrorField = null;

    // Block numbers and special characters during typing
    $("#employer_name").on("input", function () {

        // Clear previous error message
        $(this).siblings(".error-message").remove();

        let employer_name = $(this).val().trim();
        let nameRegex = /^[A-Za-z\s.]+$/; // Adds dot support

        if (employer_name === "" || !nameRegex.test(employer_name)) {
            $(this).after('<span class="error-message text-danger d-block mt-1">Enter a valid Employer Name.</span>');
            if (!firstErrorField) firstErrorField = $(this);
            isValid = false;
        }
    });

    // Validate input on change
    $("#Fathers_Name").on("input", function () {
        $(".error-message", this.parentElement).remove(); // Clear previous error

        let fathersName = $(this).val().trim();
        let nameRegex = /^[A-Za-z\s]+$/;

        if (!nameRegex.test(fathersName)) {
            if (!firstErrorField) firstErrorField = $(this);
            isValid = false;
        }
    });

    // --------------------End------------


    $("#upload_photo").on("input change", function () {
        const $field = $(this);

        if ($field.val()) {
            $field.nextAll('.error-message').first().remove();
        }
    });



    $('#closePopup').on('click', function () {
        $('#pdfPopup').fadeOut(function () {
            window.location.href = "{{ route('dashboard') }}";
        });
    });


    // Save As Draft

    $('#DraftBtn').on('click', function(e) {
        e.preventDefault(); 

        $('.error-message').remove(); 
        let isValid = true;
        let firstErrorField = null; 

        let nameRegex = /^[A-Za-z\s]+$/;
        let dob = $('#d_o_b').val();

        // Validate Father's Name
        let fathersName = $('#Fathers_Name').val().trim();
        if (fathersName === "") {
            let errorMsg = $(
                '<span class="error-message text-danger d-block mt-1">Father\'s Name is required.</span>'
            );
            $('#Fathers_Name').after(errorMsg);
            if (!firstErrorField) firstErrorField = $('#Fathers_Name');
            isValid = false;
        } else if (!nameRegex.test(fathersName)) {
            let errorMsg = $(
                '<span class="error-message text-danger d-block mt-1">Only alphabets and spaces are allowed.</span>'
            );
            $('#Fathers_Name').after(errorMsg);
            if (!firstErrorField) firstErrorField = $('#Fathers_Name');
            isValid = false;
        }


        if (dob === "") {
            let errorMsg = $(
                '<span class="error-message text-danger d-block mt-1">Date of Birth is required.</span>'
            );
            $('#d_o_b').after(errorMsg);
            if (!firstErrorField) firstErrorField = errorMsg;
            isValid = false;
        }

        $('#education-container .education-fields').each(function () {

            let educationUpload = $(this).find('input[type="file"][name^="education_document["]');

            if (educationUpload.length && educationUpload[0].files.length > 0) {
                const file = educationUpload[0].files[0]; // ✅ use raw DOM element
                if (file) {
                    const allowedType = 'application/pdf';
                    const minSize = 5 * 1024;   // 5 KB
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

        $('#work-container .work-fields').each(function () {
            let workDocument = $(this).find('input[type="file"][name^="work_document["]');

           if (workDocument.length && workDocument[0].files.length > 0) {
                const file = workDocument[0].files[0]; // ✅ use raw DOM element
                if (file) {
                    const allowedType = 'application/pdf';
                    const minSize = 5 * 1024;   // 5 KB
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
        

        let licenseError = document.getElementById("licenseError");
        let dateError = document.getElementById("dateError");

        licenseError.textContent = '';
        dateError.textContent = '';

        $("#pancard-error").text("");
        $("#checkboxError").text("");


        // Validate Date of Birth

        const aadhaarInput = document.getElementById("aadhaar");
        const aadhaarError = document.getElementById("aadhaar-error");

        // get value, remove spaces, and trim
        const aadhaar = aadhaarInput.value.replace(/\s+/g, '').trim();

        const aadhaarRegex = /^[2-9]{1}[0-9]{11}$/;

        if (aadhaar !== '' && !aadhaarRegex.test(aadhaar)) {
            aadhaarError.textContent =
                "Please enter a valid 12-digit Aadhaar number (should not start with 0 or 1).";
            if (!firstErrorField) firstErrorField = aadhaar;
            isValid = false;
        } else {
            aadhaarError.textContent = "";
        }

        let aadhaarFileInput = $('#aadhaar_doc')[0];
        if (aadhaarFileInput) {
            if (aadhaarFileInput.files.length !== 0) {
                const file = aadhaarFileInput.files[0];
                const allowedType = 'application/pdf';
                const maxSize = 250 * 1024; // 250 KB

                if (file.type !== allowedType) {
                    let errorMsg = $(
                        '<span class="error-message text-danger d-block mt-1">Only PDF files are allowed for Aadhaar document.</span>'
                    );
                    $('#aadhaar_doc').after(errorMsg);
                    if (!firstErrorField) firstErrorField = $('#aadhaar_doc');
                    isValid = false;
                } else if (file.size > maxSize) {
                    let errorMsg = $(
                        '<span class="error-message text-danger d-block mt-1">File size permitted only 5 KB to 250 KB.</span>'
                    );
                    $('#aadhaar_doc').after(errorMsg);
                    if (!firstErrorField) firstErrorField = $('#aadhaar_doc');
                    isValid = false;
                }
            }
        }

        const pancardInput = document.getElementById("pancard");
        const pancardError = document.getElementById("pancard-error");
        const pancardValue = pancardInput.value.trim();
        const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;


        const pancardDocInput = document.getElementById("pancard_doc");
        
        if (pancardDocInput && pancardDocInput.files.length > 0) {
            const file = pancardDocInput.files[0];
            if (file) {
                const allowedType = 'application/pdf';
                const maxSize = 250 * 1024;
                if (file.type !== allowedType) {
                    $('#pancard_doc').after('<span class="error-message text-danger d-block mt-1">Only PDF files are allowed for PAN document.</span>');
                    if (!firstErrorField) firstErrorField = $('#pancard_doc');
                    isValid = false;
                } else if (file.size > maxSize) {
                    $('#pancard_doc').after('<span class="error-message text-danger d-block mt-1">File size permitted only 5 KB to 250 KB.</span>');
                    if (!firstErrorField) firstErrorField = $('#pancard_doc');
                    isValid = false;
                }
            }
        }



        // PAN document validation if PAN number is entered
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



        let photoInput = document.getElementById("upload_photo");
        
        if (photoInput && photoInput.files.length > 0) {
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

        if (!isValid) {

            $('html, body').animate({
                scrollTop: firstErrorField.offset().top - 100
            }, 500);

            return; 

        } else {
            let applicationId = $('#application_id').val();

            let applType = $('#appl_type').val();
            let formData = new FormData($('#competency_form_p')[0]);

            formData.append('form_action', 'draft');

            

            if (applType === "R") {
                // Renewal draft submit route
                url = BASE_URL + "/form/draft_renewal_submit";
            } else {
                // New application draft submit route
                url = BASE_URL + "/form_p/saveDraft";
            } 

            // let url = $(this).data("url");

            // if (applicationId) {
            //     url += "/" + applicationId;
            // }

            formData.append('application_id', applicationId);

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
                    if (response.status == 'success') {

                        Swal.fire({
                            title: 'Application Saved As Draft!',
                            html: 'Your Application ID: <strong>' + response.application_id + '</strong>',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = BASE_URL +'/dashboard'; // change as needed
                        });

                    }else{
                        Swal.fire("Failed", "Application not saved as draft", "error");
                    }

                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {

                        // First clear previous errors
                        $('.text-danger.server-error').remove();
                        $('.is-invalid').removeClass('is-invalid');

                        // Loop through errors  

                        $.each(xhr.responseJSON.errors, function (fieldName, messages) {

                            console.log(fieldName);
                            console.log(messages);
                            // Support dot notation (like education_document.0)
                            let fieldSelector = fieldName.replace(/\./g, '\\.'); // escape dot for jQuery

                            // Try to find the input by name
                            let field = $(`[name="${fieldName}"]`);
                            if (field.length === 0) {
                                // If not found directly, try fallback (use name starts with for array fields)
                                field = $(`[name^="${fieldName.split('.')[0]}"]`).eq(parseInt(fieldName.split('.')[1]));
                            }

                            // Add error message if input found
                            if (field.length) {
                                field.addClass('is-invalid');

                                // Append the error message after the input
                                field.after(`<span class="text-danger server-error">${messages[0]}</span>`);
                            }
                        });

                        let firstInvalid = $('.is-invalid').first();
                        if (firstInvalid.length) {
                            $('html, body').animate({
                                scrollTop: firstInvalid.offset().top - 100 // Adjust offset as needed
                            }, 500);
                        }
                    

                    } else {
                        Swal.fire("Error", xhr.responseText || "An unexpected error occurred.", "error");
                    }
                }
            });

        }
    });



});
