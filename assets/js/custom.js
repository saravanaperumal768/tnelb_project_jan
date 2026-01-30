$(document).ready(function () {

    // License verfication for FORM -w , FORM - WH ----------------------

    const regexRules = {
        license: /^(C|LC)\d+$/,
        certificate: /^(B|H|LWH|LB)\d+$/,
        supervisor:/^(B|C|LC|LB)\d+$/,
        helper:/^(H|LWH)\d+$/,
    };

    // ✅ Toggle Yes/No for all sections
    $(document).on("change", ".toggle-details", function () {
        const target = $(this).data("target");
        if ($(this).val() === "yes") {
            $(target).show();
        } else {
            $(target).hide()
                     .find("input[type=text], input[type=date]").val("");
            $(target).find("span.text-danger, span.text-success").text("");
        }
    });

    // ✅ Common Keyup Validation
    $(document).on("keyup", ".verify-input", function () {
        let value = $(this).val()?.trim().toUpperCase() || "";
        $(this).val(value);

        let type = $(this).data("type");
        let errorBox = $($(this).data("error"));
        let msgBox = $($(this).data("msg"));

        errorBox.text("");
        msgBox.text("");

        if (value === "") {
            errorBox.text("License Number is Required");
            return;
        }

        if (!regexRules[type].test(value)) {
            errorBox.text("Invalid License Number");
        }
    });

    // ✅ Common Date Validation
    $(document).on("change", ".verify-date", function () {
        let value = $(this).val()?.trim() || "";
        let errorBox = $($(this).data("error"));
        errorBox.text(value === "" ? "Date is Required" : "");
    });

    // ✅ Common Verify Button AJAX
    $(document).on("click", ".verify-btn", function () {
        // 🔹 Select only from the correct section
        let section = $(this).closest("#previously_details, #wireman_details");
        let input = section.find(".verify-input");
        let date = section.find(".verify-date");

        if (input.length === 0 || date.length === 0) {
            console.error("Input or date field not found!");
            return;
        }

        let value = input.val()?.trim().toUpperCase() || "";
        let dateVal = date.val()?.trim() || "";

        let type = $(this).data("type");
        let errorBox = $(input.data("error"));
        let dateErrorBox = $(date.data("error"));
        let msgBox = $(input.data("msg"));


        errorBox.text("");
        dateErrorBox.text("");

        let isValid = true;

        if (value === "") {
            errorBox.text("License Number is required");
            isValid = false;
        } else if (!regexRules[type].test(value)) {
            errorBox.text("Invalid License Number");
            isValid = false;
        }

        if (dateVal === "") {
            dateErrorBox.text("Date is required");
            isValid = false;
        } else {
            const regexDate = /^(\d{4})-(\d{2})-(\d{2})$/;
            const match = dateVal.match(regexDate);
        
            if (!match) {
                dateErrorBox.text("Invalid Date Format");
                isValid = false;
            } else {
                const year = parseInt(match[1]);
                const month = parseInt(match[2]);
                const day = parseInt(match[3]);
        
                const checkDate = new Date(year, month - 1, day);
        
                if (
                    checkDate.getFullYear() !== year ||
                    checkDate.getMonth() !== month - 1 ||
                    checkDate.getDate() !== day ||
                    year < 1900 || year > new Date().getFullYear()
                ) {
                    dateErrorBox.text("Enter a valid date");
                    isValid = false;
                }
            }
        }

        if (!isValid) return;


        let url = $(this).data("url");


        $.ajax({
            url: url,
            method: "POST",
            data: {
                license_number: value,
                date: dateVal,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                let $licenseNumber = type === 'license' ? $('#l_verify') : $('#cert_verify');

                console.log($licenseNumber);

                if (response.exists) {
                    $licenseNumber.val('1');

                      msgBox.removeClass("text-danger").addClass("text-success")
                          .html("&#10004; Valid License.");
                } else {
                    $licenseNumber.val('0');

                    msgBox.removeClass("text-success").addClass("text-danger")
                          .html("&#128683; Invalid License.");
                }
            },
            error: function () {
                msgBox.removeClass("text-success").addClass("text-danger")
                      .html("🚫 Error verifying license. Try again.");
            },
        });
    });


    $('#saveDraftBtn').on('click', function(e) {
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
            let formData = new FormData($('#competency_form_ws')[0]);

            formData.append('form_action', 'draft');

            

            if (applType === "R") {
                // Renewal draft submit route
                url = BASE_URL + "/form/draft_renewal_submit";
            } else {
                // New application draft submit route
                url = BASE_URL + "/form/draft_submit";
            } 

            // let url = $(this).data("url");

            if (applicationId) {
                url += "/" + applicationId;
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

    $(document).on('click', '.remove-doc_edu', function () {
        let fileInput = '<input type="file" class="form-control" name="education_document[]" accept=".pdf,application/pdf"><input type="hidden" name="removed_document[]" value="1">';

        $(this).closest('.file-section').replaceWith(fileInput);
    });

    $(document).on('click', '.remove-doc_work', function () {
        let fileInput = '<input type="file" class="form-control" name="work_document[]" accept=".pdf,application/pdf"><input type="hidden" name="removed_document_work[]" value="1">';

        $(this).closest('.file-section').replaceWith(fileInput);
    });


    $(document).on('click', '.remove_edu', function() {
        let edu_id = $(this).data('edu_id'); 


        let url = $(this).data('url');

        $.ajax({
            url:  url, // Laravel route
            type: "POST",
            data: {
                edu_id : edu_id,
                _token: $('meta[name="csrf-token"]').attr("content") // CSRF token
            },
            success: function (response) {
             
            },
            error: function () {
                Swal.fire("Error!", "Something went wrong. Try again!", "error");
            }
        });
    });

    $(document).on('click', '.remove_exp', function() {
        let exp_id = $(this).data('exp_id'); 


        console.log(exp_id);


        let url = $(this).data('url');

        $.ajax({
            url:  url, // Laravel route
            type: "POST",
            data: {
                exp_id : exp_id,
                _token: $('meta[name="csrf-token"]').attr("content") // CSRF token
            },
            success: function (response) {
             
            },
            error: function () {
                Swal.fire("Error!", "Something went wrong. Try again!", "error");
            }
        });
    });



    $(document).on('click', '.remove-docs', function () {
        let inputHtml = `
            <div class="aadhaar-doc-input">
                <input autocomplete="off" class="form-control text-box single-line" id="aadhaar_doc" name="aadhaar_doc" type="file" accept=".pdf,application/pdf">
                <span class="file-limit"> File type: PDF (Max 250 KB) </span>
                <small class="text-danger file-error"></small>
            </div>
        `;
    
        $(this).closest('.aadhaar-doc-container').replaceWith(inputHtml);

        $('#aadhaar_doc_removed').val('1');
    });

    $(document).on('click', '.remove-doc-pan', function () {
        let inputHtml = `
            <div class="pan-doc-input">
                <input autocomplete="off" class="form-control text-box single-line" id="pancard_doc" name="pancard_doc" type="file" accept=".pdf,application/pdf">
                <span class="file-limit"> File type: PDF (Max 250 KB) </span><br>
                <p class="text-danger file-error"></p>
            </div>
        `;
    
        $(this).closest('.pan-doc-container').replaceWith(inputHtml);

        $('#pan_doc_removed').val('1');
    });



    // Button toggle option for verify license

    $(document).on('click', '.remove_verify', function () {

        let type = $(this).data("type");


        console.log(type);


        if (type == 'superviser') {

            $('#previously_number').prop('readonly', false).val('').attr('value', '');;
            $('#previously_date').prop('readonly', false).val('').attr('value', '');;

            $('.verify_status').text('');

            $(this).remove();

            $('.btn-forms').length && $('.btn-forms').removeClass('d-none');

        }else if (type == 'superviser_two') {

            $('#certificate_no').prop('readonly', false).val('').attr('value', '');;
            $('#certificate_date').prop('readonly', false).val('').attr('value', '');;
            $('#verify_status').text('');

            $(this).remove(); 

            $('.verify-btn').length && $('.verify-btn').removeClass('d-none');
        }
        else{
            // Remove readonly attribute
            $('#certificate_no').prop('readonly', false).val('').attr('value', '');;
            $('#certificate_date').prop('readonly', false).val('').attr('value', '');;
    
            $('#verify_status').text('');
        
            $(this).remove(); // Remove the delete button
    
    
            $('.verify-btn').length && $('.verify-btn').removeClass('d-none');
        }
    });



    // $('.remove-pan-doc').click(function (e) {
    //     e.preventDefault();
    //     console.log('sdf');
    //     // Hide existing document section
        
    //     // Show file input
    //     $('.pan-doc-input').removeClass('d-none');
    //     $('.pan-doc-container').hide();

    //     // Mark document as removed
    //     $('#pan_doc_removed').val('1');
    // });


});
