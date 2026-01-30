$(document).ready(function() {

    $('#feesForm').on('submit', function(e) {
        e.preventDefault();

        let isValid = true;
    
        const fields = [
            {
                name: "form_cate",
                selector: "select[name='form_cate']",
                errorSelector: ".error-form_cate",
                validate: function (val) {
                    if (val === "") return "Please choose the category";
                    return null;
                },
            },
            {
                name: "cert_name",
                selector: "input[name='cert_name']",
                errorSelector: ".error-cer_val",
                validate: function (val) {
                    if (val === "") return "Please fill the Certificate / Licence Name";
                    if (!/^[a-zA-Z\s]+$/.test(val)) return "Category name should contain only letters and spaces";
                    return null;
                },
            },
            {
                name: "cate_licence_code",
                selector: "input[name='cate_licence_code']",
                errorSelector: ".error-cert_code",
                validate: function (val) {
                    if (val === "") return "Please fill the Certificate / Licence Code";
                    if (!/^[A-Z0-9]+$/.test(val)) return "Category code should contain only uppercase letters and numbers";
                    return null;
                },
            },
            {
                name: "form_name",
                selector: "input[name='form_name']",
                errorSelector: ".error-form_name",
                validate: function (val) {
                    if (val === "") return "Please fill the Form Name";
                    if (!/^[A-Z0-9]+$/.test(val)) return "Form Name should contain only uppercase letters and numbers";
                    return null;
                },
            },
            {
                name: "form_code",
                selector: "input[name='form_code']",
                errorSelector: ".error-form_code",
                validate: function (val) {
                    if (val === "") return "Please fill the Form code";
                    return null;
                },
            },
        ];
    
        $(".error").addClass("d-none").text("");
        $("input, select").css("border", "");

        

        let formData = new FormData(this);

        // console.log(formData);
        // return false;
        
    
        // Handle checkboxes explicitly if needed
        $(this).find('input[type=checkbox]').each(function() {
            formData.set(this.name, $(this).is(':checked') ? 1 : 0);
        });

        $.ajax({
            url: BASE_URL + '/admin/licences/updateFees', 
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#addFormModal').modal('hide');
                    $('#feesForm')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Refresh the page after the alert closes
                        location.reload();
                    });
                } else {
                        Swal.fire({
                        icon: 'error',
                        title: response.message,
                    });
                }
            },
            error: function(xhr) {
                let msg = 'An unexpected error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: msg,
                });
            }
        });
    });

    // Add/Edit 
    $("#addForms").on("submit", function (e) {
        e.preventDefault();
    
        let isValid = true;
    
        const fields = [
            {
                name: "form_cate",
                selector: "select[name='form_cate']",
                errorSelector: ".error-form_cate",
                validate: function (val) {
                    if (val === "") return "Please choose the category";
                    return null;
                },
            },
            {
                name: "cert_name",
                selector: "input[name='cert_name']",
                errorSelector: ".error-cer_val",
                validate: function (val) {
                    if (val === "") return "Please fill the Certificate / Licence Name";
                    if (!/^[a-zA-Z\s]+$/.test(val)) return "Category name should contain only letters and spaces";
                    return null;
                },
            },
            {
                name: "cate_licence_code",
                selector: "input[name='cate_licence_code']",
                errorSelector: ".error-cert_code",
                validate: function (val) {
                    if (val === "") return "Please fill the Certificate / Licence Code";
                    if (!/^[A-Z0-9]+$/.test(val)) return "Category code should contain only uppercase letters and numbers";
                    return null;
                },
            },
            {
                name: "form_name",
                selector: "input[name='form_name']",
                errorSelector: ".error-form_name",
                validate: function (val) {
                    if (val === "") return "Please fill the Form Name";
                    if (!/^[A-Za-z0-9 ]+$/.test(val)) return "Form Name should contain only letters,space and numbers";
                    return null;
                },
            },
            {
                name: "form_code",
                selector: "input[name='form_code']",
                errorSelector: ".error-form_code",
                validate: function (val) {
                    if (val === "") return "Please fill the Form code";
                    return null;
                },
            },
        ];
    
        $(".error").addClass("d-none").text("");
        $("input, select").css("border", "");
    
        fields.forEach((field) => {
            const input = $(field.selector);
            const value = $.trim(input.val());
            const errorMsg = $(field.errorSelector);
            const error = field.validate(value);
    
            input.off("input change").on("input change", function () {
                $(this).css("border", "");
                errorMsg.addClass("d-none").text("");
            });

    
            if (error) {
                input.css("border", "1px solid red");
                errorMsg.text(error).removeClass("d-none");
                if (isValid) input.focus(); // Focus first invalid field
                isValid = false;
            }
        });
    
        if (!isValid) return false; // stop form submission if validation fails
    
        // Prepare form data
        let formData = new FormData(this);

        console.log(formData);
    
        // Disable button while submitting
        const submitBtn = $("#addForms button[type='submit']");
        submitBtn.prop("disabled", true).text("Creating...");
    
        // AJAX submission
        $.ajax({
            url: BASE_URL + "/admin/licences/add_licence",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        icon: "success",
                        title: response.message || "Form created successfully!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $("#addForms")[0].reset();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: response.message || "Something went wrong!",
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: xhr.responseJSON?.message || "Please try again later.",
                });
            },
            complete: function () {
                submitBtn.prop("disabled", false).text("Create");
            },
        });
    });
        


    
    // Click to edit

    $(document).on('click', '.editFormBtn', function () {
    // Get all data-* attributes
        const form_id = $(this).data('id');
        const form_name = $(this).data('form_name');
        const cert_name = $(this).data('cert_name');
        const fresh_fee = $(this).data('fresh_form_fees');
        const renewal_fee = $(this).data('renewal_form_fees');
        const late_fee = $(this).data('renewal_late_fees');
        const fresh_fees_on = $(this).data('fresh_fees_on');
        const renewal_fees_on = $(this).data('renewal_fees_on');
        const late_fees_on = $(this).data('renewal_late_fees_on');
        // const fresh_duration = $(this).data('fresh_form_duration');
        // const renewal_duration = $(this).data('renewal_form_duration');
        // const late_duration = $(this).data('renewal_late_fees_duration');
        // const fresh_duration_on = $(this).data('fresh_form_duration_on');
        // const renewal_duration_on = $(this).data('renewal_form_duration_on');
        // const late_duration_on = $(this).data('renewal_late_fees_duration_on');

        const fresh_fees_ends_on =  $(this).data('fresh_fees_ends_on');
        const renewal_fees_ends_on =  $(this).data('renewal_fees_ends_on');
        const renewal_late_fees_ends_on =  $(this).data('renewal_late_fees_ends_on');
        const fresh_form_duration_ends_on =  $(this).data('fresh_form_duration_ends_on');
        // const renewal_form_duration_ends_on =  $(this).data('renewal_form_duration_ends_on');
        // const renewal_late_fees_duration_ends_on =  $(this).data('renewal_late_fees_duration_ends_on');
        const status = $(this).data('form_status');

        console.log(cert_name);

        

        // Fill modal inputs
        $('#form_id').val(form_id);
        // $('#openHistoryBtn').attr('data-form_id', '').attr('data-form_id', cert_name);

        
        // $('#cert_name').val(cert_name);
        $('#cert_name_edit').val(cert_name).trigger('change');
        $('#cert_val').val(cert_name);

        $('#form_name_edit').val(form_name);
        $('#fresh_fees').val(fresh_fee);
        $('#fresh_fees_on').val(fresh_fees_on);
        $('#renewal_fees').val(renewal_fee);
        $('#renewal_fees_starts').val(renewal_fees_on);
        $('#latefee_for_renewal').val(late_fee);
        $('#late_renewal_fees_starts').val(late_fees_on);
        // $('#freshform_duration').val(fresh_duration);
        // $('#freshform_duration_starts').val(fresh_duration_on);
        // $('#renewal_form_duration').val(renewal_duration);
        // $('#renewal_duration_starts').val(renewal_duration_on);
        // $('#renewal_late_fee_duration').val(late_duration);
        // $('#renewal_late_fee_duration_starts').val(late_duration_on);
        $('#fresh_fees_ends_on').val(fresh_fees_ends_on);
        $('#renewal_fees_ends_on').val(renewal_fees_ends_on);
        $('#late_renewal_fees_ends_on').val(renewal_late_fees_ends_on);
        // $('#freshform_duration_ends').val(fresh_form_duration_ends_on);
        // $('#renewal_duration_ends').val(renewal_form_duration_ends_on);
        // $('#renewal_late_fee_duration_ends').val(renewal_late_fees_duration_ends_on);

        
        if (status == 1) {
            $('#form_status').prop('checked', true);
        } else {
            $('#form_status').prop('checked', false);
        }

    });

    function formatDateForInput(value) {
        if (!value) return '';
        // works for both "2025-11-04 00:00:00" and ISO "2025-11-04T00:00:00.000Z"
        return value.toString().split('T')[0].split(' ')[0];
    }




    $(document).on('click', '.editValidity', function () {
    // Get all data-* attributes
        const rec_id = $(this).data('id');
        const cert_id = $(this).data('cert_id');
        const form_type = $.trim($(this).data('form_type'));
        const validity = $(this).data('validity');
        const start_date = $(this).data('start_date');

        // const status = $(this).data('form_status');  

        // Fill modal inputs
        $('#edit_form_id').val(rec_id);
        $('#cert_id').val(cert_id).trigger('change');
        $('#form_type').val(form_type).trigger('change');   

        $('#fresh_form_duration, #fresh_form_duration_on, #renewal_form_duration, #renewal_duration_on, #renewal_late_fee_duration, #renewal_late_fee_duration_on').val('');
        // $('#form_name_edit').val(form_name);

        switch (form_type) {
            case 'N': // New Form
                $('#fresh_form_duration').val(validity);
                $('#fresh_form_duration_on').val(formatDateForInput(start_date));
                break;

            case 'R': // Renewal Form
                $('#renewal_form_duration').val(validity);
                $('#renewal_duration_on').val(formatDateForInput(start_date));
                break;

            case 'L': // Late Fee Form
                $('#renewal_late_fee_duration').val(validity);
                $('#renewal_late_fee_duration_on').val(formatDateForInput(start_date));
                break;

            default:
                console.warn('Unknown form_type:', form_type);
                break;
        }

        $(".modal-title").text("Edit Validity Details");

        // $('#freshform_duration').val(fresh_duration);
        // $('#freshform_duration_starts').val(fresh_duration_on);
        // $('#fresh_form_duration_ends_on').val(fresh_fees_ends_on);
        // $('#renewal_form_duration').val(renewal_duration);
        // $('#renewal_duration_starts').val(renewal_duration_on);
        // $('#renewal_late_fee_duration').val(late_duration);
        // $('#renewal_late_fee_duration_starts').val(late_duration_on);
        // $('#freshform_duration_ends').val(fresh_form_duration_ends_on);
        // $('#renewal_duration_ends').val(renewal_form_duration_ends_on);
        // $('#renewal_late_fee_duration_ends').val(renewal_late_fees_ends_on);

        
        // if (status == 1) {
        //     $('#form_status').prop('checked', true);
        // } else {
        //     $('#form_status').prop('checked', false);
        // }

    });


    //Update Form Details
    $('#editForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
            
        // Handle checkboxes explicitly if needed
        $(this).find('input[type=checkbox]').each(function() {
            formData.set(this.name, $(this).is(':checked') ? 1 : 0);
        });

        $.ajax({
            url: BASE_URL + '/admin/licences/updateForm', // your Laravel route
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status == false) {
                    $('#editFormModal').modal('hide');
                    Swal.fire({
                        icon: 'warning',
                        title: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    })
                }else{
                    $('#editFormModal').modal('hide');
                    $('#editForm')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
                
                // Optionally refresh the table here
            },
            error: function (xhr) {
                console.error(xhr.responseText);

                let msg = 'An unexpected error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: msg,
                    });
            }
        });
    });


    $(document).on('click', '.openHistoryBtn', function(e) {
        e.preventDefault();

        const form_id = $(this).data('id');
        console.log(form_id);

        // return false;
        

        $.ajax({
            url: BASE_URL + '/admin/licences/formHistory', // your Laravel route
            method: 'POST',
            dataType: 'json',
            data:{
                form_id : form_id
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Optionally refresh the table here
                $('#formHistoryTable tbody').html(response.html);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                let msg = 'An unexpected error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: msg,
                    });
            }
        });
        $('#viewHistoryModal').modal('show');

        // Close the first modal
        // $('#editFormModal').modal('hide');

        // Open the second modal after the first one is hidden
        // $('#editFormModal').on('hidden.bs.modal', function() {
        //     $('#viewHistoryModal').modal('show');
        //     // Remove this handler so it doesn't trigger again
        //     $(this).off('hidden.bs.modal');
        // });
    });



    // Master category script for add License category

    $("#addCategory").on("submit", function (e) {
        e.preventDefault();

        let cateInput = $("input[name='cate_name']");
        let cateName = $.trim(cateInput.val());
        let errorMsg = $(".error-cate");

        // Reset previous states
        cateInput.css("border", "");
        errorMsg.addClass("d-none");

        // Custom validation
        if (cateName === "") {
            cateInput.css("border", "1px solid red");
            errorMsg.text("Please fill the Category").removeClass("d-none");
            cateInput.focus();
            return false;
        } else if (cateName.length < 3) {
            cateInput.css("border", "1px solid red");
            errorMsg.text("Category name must be at least 3 characters").removeClass("d-none");
            cateInput.focus();
            return false;
        } else if (!/^[a-zA-Z\s]+$/.test(cateName)) {
            cateInput.css("border", "1px solid red");
            errorMsg.text("Category name should contain only letters and spaces").removeClass("d-none");
            cateInput.focus();
            return false;
        }

        // Prepare form data
        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL + "/admin/licences/add_category", // change this to your route
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log(response);
                
                if (response.status) {
                    Swal.fire({
                        icon: "success",
                        title: response.message || "Category created successfully!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#addCategory")[0].reset();

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: response.message || "Something went wrong!",
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: xhr.responseJSON?.message || "Please try again later.",
                });
            },
            complete: function () {
                $("#addCategory button[type='submit']")
                    .prop("disabled", false)
                    .text("Create");
            }
        });
    });


    $("#addCategory").on("submit", function (e) {
        e.preventDefault();

        let cateInput = $("input[name='cate_name']");
        let cateName = $.trim(cateInput.val());
        let errorMsg = $(".error-cate");

        // Reset previous states
        cateInput.css("border", "");
        errorMsg.addClass("d-none");

        // Custom validation
        if (cateName === "") {
            cateInput.css("border", "1px solid red");
            errorMsg.text("Please fill the Category").removeClass("d-none");
            cateInput.focus();
            return false;
        } else if (cateName.length < 3) {
            cateInput.css("border", "1px solid red");
            errorMsg.text("Category name must be at least 3 characters").removeClass("d-none");
            cateInput.focus();
            return false;
        } else if (!/^[a-zA-Z\s]+$/.test(cateName)) {
            cateInput.css("border", "1px solid red");
            errorMsg.text("Category name should contain only letters and spaces").removeClass("d-none");
            cateInput.focus();
            return false;
        }

        // Prepare form data
        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL + "/admin/licences/add_category", // change this to your route
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log(response);
                
                if (response.status) {
                    $('#addForms').modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: response.message || "Category created successfully!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#addCategory")[0].reset();

                } else {
                    $('#addForms').modal('hide');
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: response.message || "Something went wrong!",
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: xhr.responseJSON?.message || "Please try again later.",
                });
            },
            complete: function () {
                $("#addCategory button[type='submit']")
                    .prop("disabled", false)
                    .text("Create");
            }
        });
    });

    // Optional: remove red border while typing
    $("input[name='cate_name']").on("input", function () {
        $(this).css("border", "");
        $(".error-cate").addClass("d-none");
    });





    //Add Certificate / forms

    // 🔹 1. Auto-uppercase while typing (runs immediately)
    $("input[name='cate_licence_code']").on("input", function () {
        console.log('sdsds');
        this.value = this.value.toUpperCase();
    });

    $("input[name='form_code']").on("input", function () {
        console.log('sdsds');
        this.value = this.value.toUpperCase();
    });

    // 🔹 2. Hide red border + error message as user types (runs immediately)
    $("#addForms").on("input", "input, select", function () {
        $(this).css("border", "");
        $(this).siblings(".error").addClass("d-none").text("");
    });


    // Get all data-* attributes for edit category
    $(document).on('click', '.editCategoryBtn', function () {
        const cate_id = $(this).data('cate_id');
        const category_name = $(this).data('category_name');
        const status = $(this).data('status');

        // Fill modal inputs
        $('#cate_id').val(cate_id);
        $('#edit_cate_name').val(category_name);
        $('#status').val(status);
        
    });

    
    $("#edit_category_form").on("submit", function (e) {
        e.preventDefault();

        let isValid = true; // flag to track form validity
    
        // Define your fields and rules
        const fields = [
            {
                name: "edit_cate_name",
                selector: "input[name='edit_cate_name']",
                errorSelector: ".error-cate_name_error",
                validate: function (val) {
                    if (val == "") return "Please fill the Category Name";
                    if (!/^[a-zA-Z\s]+$/.test(val)) return "Category name should contain only letters and spaces";
                    return null;
                },
            },
            {
                name: "status",
                selector: "select[name='status']",
                errorSelector: ".error-cate_status",
                validate: function (val) {
                    if (val === "") return "Please choose the category";
                    return null;
                },
            },
        ];
    
        // Reset previous states
        $(".error").addClass("d-none").text("");
        $("input, select").css("border", "");
    
        // Loop through fields for validation
        fields.forEach((field) => {
            const input = $(field.selector);
            const value = $.trim(input.val());
            const errorMsg = $(field.errorSelector);
            const error = field.validate(value);
    
            // Add "hide error when typing" listener once
            input.off("input change").on("input change", function () {
                $(this).css("border", "");
                errorMsg.addClass("d-none").text("");
            });

    
            if (error) {
                input.css("border", "1px solid red");
                errorMsg.text(error).removeClass("d-none");
                if (isValid) input.focus(); // Focus first invalid field
                isValid = false;
            }
        });
    
        if (!isValid) return false; // stop form submission if validation fails
    
        // Prepare form data
        let formData = new FormData(this);

        console.log(formData);
    
    
        // AJAX submission
        $.ajax({
            url: BASE_URL + "/admin/licences/add_category",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status) {
                    $('#addCategoryModal').modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: response.message || "Form created successfully!",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        location.reload();
                    });
                    
                } else {
                    $('#addCategoryModal').modal('hide');
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: response.message || "Something went wrong!",
                    });
                }
            },
            error: function (xhr) {
                
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: xhr.responseJSON?.message || "Please try again later.",
                });
            },
            
        });

    });


    // Fields specific to Renewal form (R)
    function getFieldsByFormType(formType) {
         // Always common fields
        const baseFields = [
            {
                name: "cert_id",
                selector: "select[name='cert_id']",
                errorSelector: ".error-licence",
                validate: (val) => (!val ? "Please choose the Certificate / Licence" : null),
            },
            // {
            //     name: "form_status",
            //     selector: "input[name='form_status']",
            //     errorSelector: ".error-form_status",
            //     validate: (val) => (val === "" ? "Please choose the status" : null),
            // },
        ];

        // Fields specific to New form (N)
            const newFields = [
                {
                    name: "fresh_form_duration",
                    selector: "input[name='fresh_form_duration']",
                    errorSelector: ".error-validity",
                    validate: (val) => (!val ? "Please fill the Validity" : null),
                },
                {
                    name: "fresh_form_duration_on",
                    selector: "input[name='fresh_form_duration_on']",
                    errorSelector: ".error-validity_from",
                    validate: (val) => (!val ? "Please choose the validity from date" : null),
                },
                // {
                //     name: "fresh_form_duration_ends_on",
                //     selector: "input[name='fresh_form_duration_ends_on']",
                //     errorSelector: ".error-validity_to",
                //     validate: (val) => (!val ? "Please choose the validity to date" : null),
                // },
            ];
        const renewalFields = [
            {
                name: "renewal_form_duration",
                selector: "input[name='renewal_form_duration']",
                errorSelector: ".error-renewal_validity",
                validate: (val) => (!val ? "Please fill the Renewal validity" : null),
            },
            {
                name: "renewal_duration_on",
                selector: "input[name='renewal_duration_on']",
                errorSelector: ".error-renewal_duration_on",
                validate: (val) => (!val ? "Please choose the Renewal from date" : null),
            },
        ];
        const LateFeeFields = [
            {
                name: "renewal_late_fee_duration",
                selector: "input[name='renewal_late_fee_duration']",
                errorSelector: ".error-latefee_validity",
                validate: (val) => (!val ? "Please fill the Late Fee validity" : null),
            },
            {
                name: "renewal_late_fee_duration_on",
                selector: "input[name='renewal_late_fee_duration_on']",
                errorSelector: ".error-latefee_fee_date",
                validate: (val) => (!val ? "Please choose the Late Fee from date" : null),
            },
        ]

        if (formType === "N") return [...baseFields, ...newFields];
        if (formType === "R") return [...baseFields, ...renewalFields];
        if (formType === "L") return [...baseFields, ...LateFeeFields];
        return baseFields; // default fallback
    }

        // Return fields based on form_type

    // Add Validity
    $("#validity_form").on("submit", function (e) {
        e.preventDefault();

        let isValid = true; // flag to track form validity

        const formType = $("select[name='form_type']").val();
        const fields = getFieldsByFormType(formType);
    
        // Reset previous states
        $(".error").addClass("d-none").text("");
        $("input, select").css("border", "");
    
        // Loop through fields for validation
        fields.forEach((field) => {
            const input = $(field.selector);
            const value = $.trim(input.val());
            const errorMsg = $(field.errorSelector);
            const error = field.validate(value);


            // console.log("🔍 Checking field:", field.name || field.selector);
            // console.log("   → Value:", value);
            // console.log("   → Validation result:", error ? "❌ " + error : "✅ OK");
    
            // Add "hide error when typing" listener once
            input.off("input change").on("input change", function () {
                $(this).css("border", "");
                errorMsg.addClass("d-none").text("");
            });

    
            if (error) {
                input.css("border", "1px solid red");
                errorMsg.text(error).removeClass("d-none");

                if (isValid) input.focus(); // Focus first invalid field
                isValid = false;
            }
        });

    
        if (!isValid) return false; // stop form submission if validation fails
    
        // Prepare form data
        let formData = new FormData(this);

        console.log(formData);
    
    
        // AJAX submission
        $.ajax({
            url: BASE_URL + "/admin/licences/updateValidity",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status === "success") {
                    $('#addDurationModal').modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: response.message || "Form created successfully!",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        location.reload();
                    });
                
                } else if (response.status === "warning") {
                    $('#addDurationModal').modal('hide');
                    Swal.fire({
                        icon: "warning",
                        title: "Warning",
                        text: response.message || "No changes detected!",
                        confirmButtonText: "OK",
                    });
                
                } else {
                    $('#addDurationModal').modal('hide');
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: response.message || "Something went wrong!",
                        confirmButtonText: "OK",
                    });
                }
            },
            error: function (xhr) {
                
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: xhr.responseJSON?.message || "Please try again later.",
                });
            },
            
        });

    });

    
    //Get Edit certificates/Licences
    $(document).on('click', '.editForm', function () {
    // Get all data-* attributes
        const row_id = $(this).data('row_id');
        const form_name = $(this).data('form_name');
        const licence_name = $(this).data('licence_name');
        const category = $(this).data('category');
        const cert_licence_code = $(this).data('cert_licence_code');
        const form_code = $(this).data('form_code');
        const form_status = $(this).data('status');


        // Fill modal inputs
        $('#edit_cert_id').val(row_id);
        $('#edit_form_cate').val(category).trigger('change');
        $('#edit_cert_name').val(licence_name);
        $('#edit_cate_licence_code').val(cert_licence_code);
        $('#edit_form_name').val(form_name);
        $('#edit_form_code').val(form_code);
        $('#edit_form_status').val(form_status).trigger('change');
        
    });

     function getValidationRules(isEdit = false) {
        const prefix = isEdit ? "edit_" : "";
        return [
            {
                selector: `select[name='${prefix}form_cate']`,
                errorSelector: `.error-${prefix}form_cate`,
                validate: val => val === "" ? "Please choose the category" : null
            },
            {
                selector: `input[name='${prefix}cert_name']`,
                errorSelector: `.error-${isEdit ? "cer_error" : "cer_val"}`,
                validate: val => {
                    if (val === "") return "Please fill the Certificate / Licence Name";
                    if (!/^[a-zA-Z\s]+$/.test(val))
                        return "Certificate name should contain only letters and spaces";
                    return null;
                }
            },
            {
                selector: `input[name='${prefix}cate_licence_code']`,
                errorSelector: `.error-${isEdit ? "cert_code_error" : "cert_code"}`,
                validate: val => {
                    if (val === "") return "Please fill the Certificate / Licence Code";
                    if (!/^[A-Z0-9]+$/.test(val))
                        return "Certificate code should contain only uppercase letters and numbers";
                    return null;
                }
            },
            {
                selector: `input[name='${prefix}form_name']`,
                errorSelector: `.error-${prefix}form_name`,
                validate: val => val === "" ? "Please fill the Form Name" : null
            },
            {
                selector: `input[name='${prefix}form_code']`,
                errorSelector: `.error-${prefix}form_code`,
                validate: val => val === "" ? "Please fill the Form Code" : null
            },
            {
                selector: `select[name='${prefix}form_status']`,
                errorSelector: `.error-${prefix}form_status`,
                validate: val => val === "" ? "Please choose the Status" : null
            },
        ];
    }

    $(document).on("submit", "#editForms", function (e) {
        e.preventDefault();
        const form = $(this);
        const isEdit = form.attr("id") === "editForms";
        const fields = getValidationRules(isEdit);

        let isValid = true;

        // Reset errors
        form.find(".error").addClass("d-none").text("");
        form.find("input, select").css("border", "");

        // Validate fields
        fields.forEach(f => {
            const input = form.find(f.selector);
            const val = $.trim(input.val());
            const err = f.validate(val);
            const errMsg = form.find(f.errorSelector);

            input.off("input change").on("input change", function () {
                $(this).css("border", "");
                errMsg.addClass("d-none").text("");
            });

            if (err) {
                input.css("border", "1px solid red");
                errMsg.text(err).removeClass("d-none");
                if (isValid) input.focus();
                isValid = false;
            }
        });

        if (!isValid) return false;

        // Prepare form data
        const formData = new FormData();

        // Dynamically rename edit fields to backend expected names
        if (isEdit) {
            formData.append("cert_id", form.find("#edit_cert_id").val());
            formData.append("form_cate", form.find("#edit_form_cate").val());
            formData.append("cert_name", form.find("#edit_cert_name").val());
            formData.append("cate_licence_code", form.find("#edit_cate_licence_code").val());
            formData.append("form_name", form.find("#edit_form_name").val());
            formData.append("form_code", form.find("#edit_form_code").val());
            formData.append("form_status", form.find("#edit_form_status").val());
        } else {
            formData.append("form_cate", form.find("#form_cate").val());
            formData.append("cert_name", form.find("#cert_name").val());
            formData.append("cate_licence_code", form.find("#cate_licence_code").val());
            formData.append("form_name", form.find("#form_name").val());
            formData.append("form_code", form.find("#form_code").val());
            formData.append("form_status", form.find("#form_status").val());
        }

        const submitBtn = form.find("button[type='submit']");
        // submitBtn.prop("disabled", true).text(isEdit ? "Updating..." : "Creating...");

        $.ajax({
            url: BASE_URL + "/admin/licences/add_licence",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            success: function (res) {
                if (res.status) {
                    Swal.fire({
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        location.reload(); // ✅ reloads page after alert closes
                    });
                    
                    form[0].reset();
                    form.closest(".modal").modal("hide");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: res.message || "Something went wrong!",
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: xhr.responseJSON?.message || "Please try again later.",
                });
            },
            // complete: function () {
            //     submitBtn.prop("disabled", false).text(isEdit ? "Update" : "Create");
            // }
        });
    });


    function getFeesValidationRules() {
        const type = $("#fees_type").val();

        const rules = [
            {
                selector: "select[name='cert_name']",
                errorSelector: ".error-cert_name",
                validate: val => val === "" ? "Please choose the Certificate / Licence" : null
            },
            {
                selector: "select[name='fees_type']",
                errorSelector: ".error-fees_type",
                validate: val => val === "" ? "Please choose the Fees Type" : null
            }
        ];
        

        // ✅ Add only the relevant rules based on type
        if (type === "N") {
            rules.push(
                {
                    selector: "input[name='fresh_fees']",
                    errorSelector: ".error-fresh_fees",
                    validate: val => val === "" ? "Please enter the Fresh Fees amount" : null
                },
                {
                    selector: "input[name='fresh_fees_on']",
                    errorSelector: ".error-fresh_fees_on",
                    validate: val => val === "" ? "Please select the Fresh Fees start date" : null
                }
            );
        } else if (type === "R") {
            rules.push(
                {
                    selector: "input[name='renewal_fees']",
                    errorSelector: ".error-renewal_fees",
                    validate: val => val === "" ? "Please enter the Renewal Fees amount" : null
                },
                {
                    selector: "input[name='renewal_fees_as_on']",
                    errorSelector: ".error-renewal_fees_as_on",
                    validate: val => val === "" ? "Please select the Renewal Fees start date" : null
                },
            );
        } else if (type === "L") {
            rules.push(
                {
                    selector: "input[name='late_fees']",
                    errorSelector: ".error-late_fees",
                    validate: val => val === "" ? "Please enter the Late Fees amount" : null
                },
                {
                    selector: "input[name='late_fees_on']",
                    errorSelector: ".error-late_fees_on",
                    validate: val => val === "" ? "Please select the Late Fees start date" : null
                }
            );
        }

        return rules;
    }



    $(document).on("submit", "#addFees", function (e) {
        e.preventDefault();
// alert('1111');
// exit;
        // console.log('sdfdsf');
        

        const form = $(this);
        const isEdit = form.find("#record_id").val() !== "";
        const fields = getFeesValidationRules(isEdit);

        let isValid = true;

        // Reset old errors
        form.find(".error").addClass("d-none").text("");
        form.find("input, select").css("border", "");

        // Validate
        fields.forEach(f => {
            const input = form.find(f.selector);
            const val = $.trim(input.val());
            const err = f.validate(val);
            const errMsg = form.find(f.errorSelector);

            console.log(err);
            console.log(errMsg);

            input.off("input change").on("input change", function () {
                $(this).css("border", "");
                errMsg.addClass("d-none").text("");
            });

            if (err) {
                input.css("border", "1px solid red");
                errMsg.text(err).removeClass("d-none");
                if (isValid) input.focus();
                isValid = false;
            }
        });

        console.log(isValid);

        if (!isValid) return false;

        // ✅ Prepare FormData
        const formData = new FormData(form[0]);

        // Convert status (checkbox “on” → 1/0)
        const status = form.find("input[name='form_status']").is(":checked") ? 1 : 0;
        formData.set("form_status", status);

        // ✅ Dynamic URL (Add vs Edit)
        const url = isEdit
            ? BASE_URL + "/admin/licence/update/" + $("#record_id").val()
            : BASE_URL + "/admin/licence/store";

        console.log(url);
        
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
           
            success: function (res) {
                Swal.close();
                if (res.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: res.message || "Saved successfully!",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        $("#addFormModal").modal("hide");
                        location.reload(); // optional refresh
                    });
                
                } else if (res.status === "warning") {
                    Swal.fire({
                        icon: "warning",
                        title: "Warning",
                        text: res.message || "No changes detected!",
                        showConfirmButton: true,
                    });
                
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: res.message || "Something went wrong!",
                    });
                }
            },
            error: function (xhr) {
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: xhr.responseJSON?.message || "Please try again later.",
                });
            },
        });
    });
});


