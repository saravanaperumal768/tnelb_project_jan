    </div>
    <footer class="main-footer d-flex justify-content-between px-4 py-3">
        <div class="footer-left">
            <a href="">Test</a>
        </div>
        <div class="footer-right">
            <a href="">Test</a>
        </div>
    </footer>
    <div class="scroll-to-top scroll-to-target" data-target="html"><span class="icon-arrow"></span></div>
</body>
<!--Scroll to top-->

<script src="{{ url('assets/js/jquery.js') }}"></script>
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

<script src="{{ url('assets/js/script.js') }}"></script>
<!-- --------------------------------------------------------------- -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/mixitup/3.2.2/mixitup.min.js'></script>
<!-- fancybox -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js'></script>
<!-- Fancybox js -->
<script>
    /*Downloaded from https://www.codeseek.co/ezra_siton/mixitup-fancybox3-JydYqm */
    // 1. querySelector
    var containerEl = document.querySelector(".portfolio-item");
    // 2. Passing the configuration object inline
    //https://www.kunkalabs.com/mixitup/docs/configuration-object/
    var mixer = mixitup(containerEl, {
        animation: {
            effects: "fade translateZ(-100px)",
            effectsIn: "fade translateY(-100%)",
            easing: "cubic-bezier(0.645, 0.045, 0.355, 1)"
        }
    });
    // fancybox insilaze & options //
    $("[data-fancybox]").fancybox({
        loop: true,
        hash: true,
        transitionEffect: "slide",
        /* zoom VS next////////////////////
        clickContent - i modify the deafult - now when you click on the image you go to the next image - i more like this approach than zoom on desktop (This idea was in the classic/first lightbox) */
        clickContent: function(current, event) {
            return current.type === "image" ? "next" : false;
        }
    });
</script>


<script>
    $('a[data-toggle="formtab"]').click(function() {
        event.preventDefault();
        var targetId = $(this).attr('href');

        $('.tabs-panels').removeClass('active')
        $('a[data-toggle="formtab"]').removeClass('active');

        $(targetId).addClass('active');
        $('a[href="' + targetId + '"]').addClass('active')



    });
</script>
<!-- 
<script>
    $('a[data-toggle="formtab"]').click(function (event) {
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
    // JavaScript to ensure footer is at the bottom
    // function setFooterPosition() {
    //     const body = document.body;
    //     const html = document.documentElement;
    //     const wrapper = document.querySelector('.page-wrapper');
    //     const footer = document.querySelector('.footer-bottom');

    //     // Reset height to auto before recalculating
    //     wrapper.style.minHeight = '500';

    //     // Calculate height of visible content
    //     const contentHeight = Math.max(
    //         body.scrollHeight, body.offsetHeight,
    //         html.clientHeight, html.scrollHeight, html.offsetHeight
    //     );

    //     // Adjust wrapper height
    //     if (contentHeight < window.innerHeight) {
    //         wrapper.style.minHeight = `${window.innerHeight}px`;
    //     }
    // }

    // Run on load and resize
    window.addEventListener('load', setFooterPosition);
    window.addEventListener('resize', setFooterPosition);
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.all.min.js"> </script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let NameInput = document.getElementById("Name");

        NameInput.addEventListener("input", function() {
            this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Only letters and spaces
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        let phoneInput = document.getElementById("PhoneNo");
        let phoneError = document.getElementById("PhoneNoError");

        phoneInput.addEventListener("input", function() {
            // Remove non-digits
            this.value = this.value.replace(/[^0-9]/g, '');

            // Limit to 10 digits
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }

            // Live validation
            if (this.value.length === 10) {
                if (!/^[6-9]\d{9}$/.test(this.value)) {
                    phoneError.textContent = "Enter a valid 10-digit mobile number starting with 6-9.";
                } else {
                    phoneError.textContent = "";
                }
            } else {
                phoneError.textContent = "";
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        let aadhaarInput = document.getElementById("aadhaar");
        let aadhaarError = document.getElementById("aadhaarError");

        aadhaarInput.addEventListener("input", function() {
            this.value = this.value.replace(/[^0-9]/g, '');

            if (this.value.length > 12) {
                this.value = this.value.slice(0, 12);
            }

            if (this.value.length === 12) {
                aadhaarError.textContent = "";
            } else if (this.value.length > 0) {
                aadhaarError.textContent = "Aadhaar number must be exactly 12 digits.";
            } else {
                aadhaarError.textContent = "";
            }
        });
    });


    $(document).ready(function() {

   
        $("#form1").submit(function(event) {
            event.preventDefault();

            // Clear previous error messages
            $("#PhoneNoError").text("");
            $("#EmailError").text("");
            $("#NameError").text("");
            $("#GenderError").text("");
            $("#AddressError").text("");
            $("#StateError").text("");
            $("#DistrictError").text("");
            $("#PincodeError").text("");
            $("#aadhaarError").text("");
            $("#pancardError").text("");

            let name = $("#Name").val().trim();
            let gender = $("input[name='gender']:checked").val();
            let phone = $("#PhoneNo").val().trim();
            let email = $("#EmailAddress").val().trim();
            let address = $("#Address").val().trim();
            let state = $("#state").val();
            let district = $("#district").val();
            let pincode = $("#pincode").val().trim();

            let aadhaar = $("#aadhaar").val().trim();
            let pancard = $("#pancard").val().trim();




            let formData = {
                _token: "{{ csrf_token() }}",
                Name: name,
                gender: gender,
                PhoneNo: phone,
                EmailAddress: email,
                Address: address,
                state: state,
                district: district,
                pincode: pincode,
                aadhaar: aadhaar,
                pancard: pancard,
            };

            $.ajax({
                type: "POST",
                url: "{{ route('register.store') }}",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $("#login-id-display").text(response.login_id);
                        $("#success-popup").fadeIn();
                        $("#overlay").fadeIn();
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;

                        if (errors.Name) {
                            $("#NameError").text(errors.Name[0]);
                        }
                        if (errors.gender) {
                            $("#GenderError").text(errors.gender[0]);
                        }
                        if (errors.PhoneNo) {
                            $("#PhoneNoError").text(errors.PhoneNo[0]);
                        }
                        if (errors.EmailAddress) {
                            $("#EmailError").text(errors.EmailAddress[0]);
                        }
                        if (errors.Address) {
                            $("#AddressError").text(errors.Address[0]);
                        }
                        if (errors.state) {
                            $("#StateError").text(errors.state[0]);
                        }
                        if (errors.district) {
                            $("#DistrictError").text(errors.district[0]);
                        }
                        if (errors.pincode) {
                            $("#PincodeError").text(errors.pincode[0]);
                        }

                        if (errors.aadhaar) {
                            $("#aadhaarError").text(errors.aadhaar[0]);
                        }
                        if (errors.pancard) {
                            $("#pancardError").text(errors.pancard[0]);
                        }
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        $("#login-form").submit(function(event) {
            event.preventDefault(); // Prevent form submission

            let phone = $("#phone").val().trim();
            let captcha = $("input[name='captcha']").val().trim();
            let errors = [];



            // if (phone === "" || !/^\d{10}$/.test(phone)) {
            //     errors.push("Enter a valid 10-digit mobile number.");
            // }

            if (captcha === "") {
                errors.push("CAPTCHA is required.");
            }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('login.check') }}", // Laravel route
                data: {
                    _token: "{{ csrf_token() }}",
                    phone: phone,
                    captcha: captcha
                },
                success: function(response) {
                    if (response.success) {
                        // alert("Login successful!");
                        // window.location.href = "/dashboard";

                        $("#otp-overlay").fadeIn();
                        $("#overlay-bg").fadeIn();
                    }
                },
                error: function(xhr) {
                    let response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        $("#phone").after('<span class="text-danger">' + response.message + '</span>'); // Show error below input
                    } else {
                        alert("An error occurred. Please try again.");
                    }
                }
            });
        });

 document.addEventListener("DOMContentLoaded", function() {
            function OTPInput() {
                const inputs = document.querySelectorAll('.otp-inputs > input');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].addEventListener('input', function() {
                        if (this.value.length > 1) {
                            this.value = this.value[0]; // Limit input to one character
                        }
                        if (this.value !== '' && i < inputs.length - 1) {
                            inputs[i + 1].focus(); // Move to the next input field
                        }
                    });

                    inputs[i].addEventListener('keydown', function(event) {
                        if (event.key === 'Backspace') {
                            this.value = '';
                            if (i > 0) {
                                inputs[i - 1].focus(); // Move to the previous input field on backspace
                            }
                        }
                    });
                }
            }

            OTPInput();

            const validateBtn = document.getElementById('validateBtn');
            validateBtn.addEventListener('click', function() {
                let otp = '';
                document.querySelectorAll('.otp-inputs > input').forEach(input => otp += input.value);

                // If OTP is correct, redirect user to the login page
                if (otp === '123456') {
                    window.location.href = "{{ route('user_login') }}";

                } else {
                    alert("Incorrect OTP, please try again.");
                }
            });
        });


        // Refresh CAPTCHA
        $("#refresh-captcha").click(function(event) {
            event.preventDefault();
            $("#image-captcha").attr("src", "{{ url('captcha/image') }}?rand=" + Math.random());
        });
    });

    let profile = document.querySelector('.profile');
    let menu = document.querySelector('.menu');

    profile.onclick = function() {
        menu.classList.toggle('active');
    }
</script>


<script type="text/javascript">
        var refreshButton = document.getElementById("refresh-captcha");
        var captchaImage = document.getElementById("image-captcha");

        refreshButton.onclick = function(event) {
            event.preventDefault();
            captchaImage.src = './captcha/image.php?' + Date.now();
        };

        $("#contact-form").submit(function(e) {

            // console.log('asd');


            e.preventDefault(); // avoid to execute the actual submit of the form.

            // var phone = $("#phone").val();

            var phone = $('input[name="phone"]').val();
            // return false;


            intRegex = /[0-9 -()+]+$/;

            if ((phone.length < 10) || (!intRegex.test(phone))) {
                alert('Please enter a valid phone number.');
                return false;
            }


            if (phone.length !== 0) {
                $('#otp_card').removeAttr("style");


            }
            console.log(phone);
            return false;

            // $.ajax({
            //     type: "POST",
            //     url: '',
            //     data: form.serialize(), // serializes the form's elements.
            //     success: function(data)
            //     {
            //     alert(data); // show response from the php script.
            //     }
            // });

        });

        document.addEventListener("DOMContentLoaded", function() {

            function OTPInput() {
                const inputs = document.querySelectorAll('.otp-inputs > input');

                inputs.forEach((input, i) => {
                    input.addEventListener('input', function() {
                        if (this.value.length > 1) {
                            this.value = this.value[0];
                        }
                        if (this.value !== '' && i < inputs.length - 1) {
                            inputs[i + 1].focus();
                        }
                    });

                    input.addEventListener('keydown', function(event) {
                        if (event.key === 'Backspace') {
                            this.value = '';
                            if (i > 0) {
                                inputs[i - 1].focus();
                            }
                        }
                    });
                });
            }

            OTPInput();

            $("#validateBtn").click(function() {
                let otp = "";
                $(".otp-inputs > input").each(function() {
                    otp += $(this).val();
                });

                if (otp.length !== 6) {
                    alert("Please enter a valid 6-digit OTP.");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('login.verify') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        otp: otp
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect_url;
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        const errMsg = xhr.responseJSON?.message || "Something went wrong.";
                        alert(errMsg);
                    }
                });
            });

        });


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

        // Function to handle OTP input behavior
        document.addEventListener("DOMContentLoaded", function() {
            function OTPInput() {
                const inputs = document.querySelectorAll('.otp-inputs > input');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].addEventListener('input', function() {
                        if (this.value.length > 1) {
                            this.value = this.value[0]; // Limit input to one character
                        }
                        if (this.value !== '' && i < inputs.length - 1) {
                            inputs[i + 1].focus(); // Move to the next input field
                        }
                    });

                    inputs[i].addEventListener('keydown', function(event) {
                        if (event.key === 'Backspace') {
                            this.value = '';
                            if (i > 0) {
                                inputs[i - 1].focus(); // Move to the previous input field on backspace
                            }
                        }
                    });
                }
            }

            OTPInput();

            const validateBtn = document.getElementById('validateBtn');
            validateBtn.addEventListener('click', function() {
                let otp = '';
                document.querySelectorAll('.otp-inputs > input').forEach(input => otp += input.value);

                // If OTP is correct, redirect user to the login page
                if (otp === '123456') {
                    window.location.href = "{{ route('user_login') }}";

                } else {
                    alert("Incorrect OTP, please try again.");
                }
            });
        });

        $(document).ready(function() {
            $("#refresh-captcha").click(function(e) {
                e.preventDefault();
                $("#image-captcha").attr("src", "{{ url('captcha/image') }}?" + Math.random());
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $("#add-more-education").click(function() {
            // Clone the last set of education fields
            let newFields = $(".education-fields").last().clone();

            // Clear input values inside the cloned fields
            newFields.find("input").val("");
            newFields.find("select").prop("selectedIndex", 0);

            // Append cloned fields to the container
            $("#education-container").append(newFields);
        });
    });
</script>


<script>
    $(document).ready(function() {
        $("#add-more-work").click(function() {
            // Clone the last work fields section
            let newFields = $(".work-fields").last().clone();

            // Clear input values
            newFields.find("input").val("");
            newFields.find("input[type='checkbox']").prop("checked", false);

            // Append cloned fields to the container
            $("#work-container").append(newFields);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#saveDraftBtn, #submitPaymentBtn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission

            $('.error-message').remove(); // Clear previous error messages
            let isValid = true;
            let firstErrorField = null; // To store the first error field

            // Validate at least one education row exists
            if ($('#education-container .education-fields').length === 0) {
                let errorMsg = $('<span class="error-message text-danger d-block mt-1">At least one educational qualification is required.</span>');
                $('#education-table').after(errorMsg);
                if (!firstErrorField) firstErrorField = errorMsg;
                isValid = false;
            }

            let nameRegex = /^[A-Za-z\s]+$/; // Allows only letters and spaces

            // Validate Father's Name
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

            // Validate Applicant's Name
            let applicantName = $('#Applicant_Name').val().trim();
            if (applicantName === "") {
                let errorMsg = $('<span class="error-message text-danger d-block mt-1">Applicant\'s Name is required.</span>');
                $('#Applicant_Name').after(errorMsg);
                if (!firstErrorField) firstErrorField = $('#Applicant_Name');
                isValid = false;
            } else if (!nameRegex.test(applicantName)) {
                let errorMsg = $('<span class="error-message text-danger d-block mt-1">Only alphabets and spaces are allowed.</span>');
                $('#Applicant_Name').after(errorMsg);
                if (!firstErrorField) firstErrorField = $('#Applicant_Name');
                isValid = false;
            }

            // Scroll to the first error field if validation fails
            if (!isValid && firstErrorField) {
                $('html, body').animate({
                    scrollTop: firstErrorField.offset().top - 50
                }, 500);
            }



            // Validate Date of Birth
            let dob = $('#d_o_b').val();
            if (dob === "") {
                let errorMsg = $('<span class="error-message text-danger d-block mt-1">Date of Birth is required.</span>');
                $('#d_o_b').after(errorMsg);
                if (!firstErrorField) firstErrorField = errorMsg;
                isValid = false;
            }

            if (!$('#declarationCheckbox').is(':checked')) {
                $('#checkboxError').show();
                if (!firstErrorField) firstErrorField = $('#checkboxError');
                isValid = false;
            } else {
                $('#checkboxError').hide();
            }

            let photoInput = $('#upload_photo')[0];
            if (photoInput.files.length === 0) {
                let errorMsg = $('<span class="error-message text-danger d-block mt-1">Photo upload is required.</span>');
                $('#upload_photo').after(errorMsg);
                if (!firstErrorField) firstErrorField = errorMsg;
                isValid = false;
            }

            // Validate each education row
            $('#education-container .education-fields').each(function() {
                let eduLevel = $(this).find('select[name="educational_level[]"]');
                let instituteName = $(this).find('input[name="institute_name[]"]');
                let yearOfPassing = $(this).find('select[name="year_of_passing[]"]');
                let percentage = $(this).find('input[name="percentage[]"]');

                if (eduLevel.val() === null) {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Please select education level.</span>');
                    eduLevel.after(errorMsg);
                    if (!firstErrorField) firstErrorField = errorMsg;
                    isValid = false;
                }

                if (instituteName.val().trim() === "") {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Institution name is required.</span>');
                    instituteName.after(errorMsg);
                    if (!firstErrorField) firstErrorField = errorMsg;
                    isValid = false;
                }

                if (yearOfPassing.val() === "0") {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Please select a valid year of passing.</span>');
                    yearOfPassing.after(errorMsg);
                    if (!firstErrorField) firstErrorField = errorMsg;
                    isValid = false;
                }

                if (percentage.val().trim() === "" || isNaN(percentage.val()) || percentage.val() < 0 || percentage.val() > 100) {
                    let errorMsg = $('<span class="error-message text-danger d-block mt-1">Enter a valid Percentage / Grade.</span>');
                    percentage.after(errorMsg);
                    if (!firstErrorField) firstErrorField = errorMsg;
                    isValid = false;
                }
            });

            if (!isValid) {
                // Scroll to the first error
                $('html, body').animate({
                    scrollTop: firstErrorField.offset().top - 100
                }, 500);
                return; // Stop form submission if validation fails
            }

            let actionType = $(this).attr('id') === 'saveDraftBtn' ? "draft" : "payment";
            let formData = new FormData($('#competency_form_ws')[0]);
            formData.append('form_action', actionType);

            $.ajax({
                url: "{{ route('form.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#saveDraftBtn, #submitPaymentBtn').prop('disabled', true);
                },
                success: function(response) {
                    if (actionType === "draft") {
                        Swal.fire({
                            title: "Success!",
                            text: "Form saved as draft!",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "{{ route('dashboard') }}"; // Redirect to dashboard
                        });
                    } else {
                        showDeclarationPopup(response.login_id);
                        // Swal.fire({
                        //     title: "Payment Success!",
                        //     text: "Your payment has been processed successfully.",
                        //     icon: "success",
                        //     confirmButtonText: "OK"
                        // }).then(() => {
                        //     $('#pdfButtons').html(`
                        //         <button class="btn btn-primary" onclick="downloadPDF('english', '${response.login_id}')">Download English PDF</button>
                        //         <button class="btn btn-success" onclick="downloadPDF('tamil', '${response.login_id}')">Download Tamil PDF</button>
                        //     `);
                        //     $('#pdfPopup').fadeIn();
                        // });
                    }
                    $('#saveDraftBtn, #submitPaymentBtn').prop('disabled', false);
                },
                error: function(xhr) {
                    $('#saveDraftBtn, #submitPaymentBtn').prop('disabled', false);
                    alert("An error occurred: " + xhr.responseText);
                }
            });
        });

        $('#closePopup').on('click', function() {
            $('#pdfPopup').fadeOut(function() {
                window.location.href = "{{ route('dashboard') }}";
            });
        });
    });


    function showDeclarationPopup(loginId) {
        Swal.fire({
            title: "Instructions",
            html: `
        <div style="text-align: left;">
            <p><strong>Please confirm the following:</strong></p>
         
            <ul style="text-align: left; margin-top: 10px;margin-left:5px;">
                <li><strong>1.(i)</strong> Fees for the issue of 'EA' Contractor licence from 01.01.2024 onwards Rs.30,000/-.</li>
                <li><strong>(ii)</strong> Mode of Payment: Fees should be sent in favour of the Secretary, Electrical Licensing Board, Chennai by Bank Demand Draft obtained from any Scheduled Bank or Co-operative Bank payable at Chennai. Remittance of fees by any other method will not be accepted.</li>
                <li><strong>2.</strong> The Proprietor or the Managing Partner/Director should have attained the age of 25 years and should have passed a minimum educational qualification of VIII Standard.</li>
                <li><strong>3.</strong> Establishment: The applicant shall employ the following minimum staff on a full-time basis solely for the purpose of contract works:</li>
                <li><strong>(i)</strong> One Supervisor holding Supervisor Competency Certificate granted by the Board with a minimum Technical Educational qualification of a Diploma in Electrical Engineering...</li>
                <li><strong>4.</strong> Instruments: The applicant should possess the following instruments: 
                    <ul>
                        <li>One Number Earth Resistance Tester</li>
                        <li>One Number 500 Volts Insulation Tester</li>
                        <li>One Number 1000 Volts Insulation Tester</li>
                        <li>One Number Phase Sequence Indicator</li>
                        <li>One Number Tong Type Ammeter</li>
                        <li>One Number Live Line Tester</li>
                        <li>One Number Portable Voltmeter (Hand Operated)</li>
                    </ul>
                </li>
                <li><strong>9.</strong> Financial Status: The applicant shall produce a Bank Solvency Certificate for Rs.50,000/- in Form 'G'...</li>
            </ul>

            <input type="checkbox" id="declaration-agree" name="cc_form" required>
            <label for="declaration-agree"> I agree to the following terms:</label>
        </div>
        `,
            showCancelButton: true,
            confirmButtonText: "Proceed",
            cancelButtonText: "Cancel",
            preConfirm: () => {
                let isChecked = document.getElementById("declaration-agree").checked;
                if (!isChecked) {
                    Swal.showValidationMessage("You must agree to proceed.");
                }
                return isChecked;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showPaymentSuccessPopup(loginId);
            }
        });
    }

    // Function to show Payment Success Popup
    function showPaymentSuccessPopup(loginId) {
        Swal.fire({
            title: "Payment Success!",
            text: "Your payment has been processed successfully.",
            icon: "success",
            confirmButtonText: "Download PDF"
        }).then(() => {
            $('#pdfButtons').html(`
            <button class="btn btn-primary" onclick="downloadPDF('english', '${loginId}')">Download English PDF</button>
            <button class="btn btn-success" onclick="downloadPDF('tamil', '${loginId}')">Download Tamil PDF</button>
        `);
            $('#pdfPopup').fadeIn();
        });
    }

    function downloadPDF(language, loginId) {
        let url = (language === 'tamil') ? `generateTamilPDF/${loginId}` : `generate-pdf/${loginId}`;
        window.open(url, '_blank'); // Open PDF in a new tab
    }

    function downloadPDF(language, loginId) {
        let url = (language === 'tamil') ? `generateTamilPDF/${loginId}` : `generate-pdf/${loginId}`;
        window.open(url, '_blank'); // Open in a new tab
    }

    $(document).ready(function() {
        let currentYear = new Date().getFullYear();
        let minDate = "1950-01-01"; // Minimum date (Jan 1, 1950)
        let maxDate = `${currentYear}-12-31`; // Maximum date (Dec 31, Current Year)

        $('#d_o_b').attr('min', minDate);
        $('#d_o_b').attr('max', maxDate);
    });

    $(document).ready(function() {
        let currentYear = new Date().getFullYear();
        let minDate = `${currentYear - 50}-01-01`; // Maximum age 50 years
        let maxDate = `${currentYear}-12-31`;

        $('#d_o_b').attr('min', minDate);
        $('#d_o_b').attr('max', maxDate);

        $('#d_o_b').on('change', function() {
            let dobValue = $(this).val();
            if (dobValue) {
                let dob = new Date(dobValue);
                let today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                let monthDiff = today.getMonth() - dob.getMonth();
                let dayDiff = today.getDate() - dob.getDate();

                // Adjust age if the birthday hasn't occurred yet this year
                if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                    age--;
                }

                if (age > 50) {
                    $('#dobError').show();
                    $('#age').val('');
                    $('#d_o_b').val('');
                } else {
                    $('#dobError').hide();
                    $('#age').val(age);
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $("#competency_form_a").on("submit", function(e) {
            e.preventDefault(); // Prevent form submission

            let formData = new FormData(this);
            let actionType = $(document.activeElement).hasClass("save-draft") ? "draft" : "submit";
            formData.append("form_action", actionType); // Append action type

            // **Staff Validation**
            let isValid = true;
            $(".error").text(""); // Clear previous errors

            let staffRows = $(".staff-fields");
            if (staffRows.length !== 4) {
                Swal.fire({
                    title: "Error!",
                    text: "Exactly 4 staff entries are required.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
                return;
            }

            staffRows.each(function(index, row) {
                $(row).find("input, select").each(function() {
                    if (!$(this).val().trim()) {
                        isValid = false;
                        let fieldName = $(this).attr("name").replace("[]", "");
                        $("#" + fieldName + "_error").text("This field is required.");
                    }
                });
            });

            if (!isValid) {
                return; // Stop submission if validation fails
            }

            $.ajax({
                url: "{{ route('forma.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function() {
                    $(".save-draft, .submit-payment").prop("disabled", true);
                },
                success: function(response) {
                    let loginId = response.login_id;

                    if (actionType === "draft") {
                        Swal.fire({
                            title: "Success!",
                            text: "Form saved as draft!",
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then(() => {
                            window.location.href = "dashboard";
                        });
                    } else {
                        // Show declaration popup first
                        showDeclarationPopup(loginId).then((result) => {
                            if (result.isConfirmed) {
                                // Show payment success message
                                Swal.fire({
                                    title: "Payment Success!",
                                    text: "Your payment has been processed successfully.",
                                    icon: "success",
                                    confirmButtonText: "OK",
                                }).then(() => {
                                    // Redirect to PDF generation
                                    window.location.href = `generatea-pdf/${loginId}`;
                                });
                            }
                        });
                    }

                    $(".save-draft, .submit-payment").prop("disabled", false);
                },
                error: function(xhr, status, error) {
                    $(".save-draft, .submit-payment").prop("disabled", false);

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(field, messages) {
                                $("#" + field + "_error").text(messages[0]);
                            });
                        }
                    } else {
                        Swal.fire("Error!", "Something went wrong. Please try again later.", "error");
                    }
                },
            });
        });

        function showDeclarationPopup(loginId) {
            Swal.fire({
                title: "Instructions",
                html: `
           <div style="text-align: left;">
                <p><strong>Please confirm the following:</strong></p>
               
                <ul style="text-align: left; margin-top: 10px;">
                    <li><strong>1.(i)</strong> Fees for the issue of 'EA' Contractor licence from 01.01.2024 onwards Rs.30,000/-.</li>
                    <li><strong>(ii)</strong> Mode of Payment: Fees should be sent in favour of the Secretary, Electrical Licensing Board, Chennai by Bank Demand Draft obtained from any Scheduled Bank or Co-operative Bank payable at Chennai. Remittance of fees by any other method will not be accepted.</li>
                    <li><strong>2.</strong> The Proprietor or the Managing Partner/Director should have attained the age of 25 years and should have passed a minimum educational qualification of VIII Standard.</li>
                    <li><strong>3.</strong> Establishment: The applicant shall employ the following minimum staff on a full-time basis solely for the purpose of contract works:</li>
                    <li><strong>(i)</strong> One Supervisor holding Supervisor Competency Certificate granted by the Board with a minimum Technical Educational qualification of a Diploma in Electrical Engineering or holding Supervisor Competency Certificate granted by the Board based on the certificate of Competency issued by the Board of Examiners, Directorate of Technical Education, Chennai, and having installation experience for a period of not less than two years and completion of at least five numbers of High Voltage works involving Transformer erection.</li>
                    <li><strong>(ii)</strong> Two Wiremen holding valid Wiremen Competency Certificate granted by this Electrical Licensing Board. Applicants holding self-certificates can be taken into account for the above purpose. Consent letters obtained from the employees, including for self, should be furnished in the prescribed form. A detailed experience certificate of the appointed Supervisor is to be enclosed in original along with an attested copy clearly indicating the works carried out. The original Competency Certificates of the staff, including self, should be sent.</li>
                    <li><strong>4.</strong> Instruments: The applicant should possess the following instruments:</li>
                    <ul>
                        <li>One Number Earth Resistance Tester</li>
                        <li>One Number 500 Volts Insulation Tester</li>
                        <li>One Number 1000 Volts Insulation Tester</li>
                        <li>One Number Phase Sequence Indicator</li>
                        <li>One Number Tong Type Ammeter</li>
                        <li>One Number Live Line Tester</li>
                        <li>One Number Portable Voltmeter (Hand Operated)</li>
                    </ul>
                    <li>These instruments should be tested in the Government Electrical Standards Laboratory attached to the office of the Chief Electrical Inspector to Government, Chennai-32, or in the MRT Laboratory of TNEB within three months prior to the date of application and test reports sent along with the application.</li>
                    <li><strong>5.</strong> Specimen signatures of the contractor and their authorized person should be sent in triplicate on a separate sheet.</li>
                    <li><strong>6.</strong> All the columns should be answered in words and figures, and no columns should be left blank.</li>
                    <li><strong>7.</strong> Grade 'EA' Contractors can undertake High Voltage installation and all Medium Voltage and Low Voltage electrical installation works.</li>
                    <li><strong>8.</strong> Applicants applying from outside Tamil Nadu should have a branch office in Tamil Nadu, and all correspondences will be made to that address only.</li>
                    <li><strong>9.</strong> Financial Status: The applicant shall produce a Bank Solvency Certificate for Rs.50,000/- (Rupees fifty thousand only) in Form 'G' valid for a minimum period of three years obtained from a Scheduled Bank or Co-operative Bank operating in this State, mentioning the full name and address of the contractor as mentioned in Columns 1 and 2 of the application, obtained in the Bank's letterhead with the Bank's seal.</li>
                </ul>

                 <input type="checkbox" id="declaration-agree" name="enclosure" required>
                <label for="declaration-agree"> I agree to the following terms:</label>
            </div>

        `,
                showCancelButton: true,
                confirmButtonText: "Proceed",
                cancelButtonText: "Cancel",
                preConfirm: () => {
                    let isChecked = document.getElementById("declaration-agree").checked;
                    if (!isChecked) {
                        Swal.showValidationMessage("You must agree to proceed.");
                    }
                    return isChecked;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `generatea-pdf/${loginId}`;
                }
            });
        }
        // **Clear Error Messages on Input**
        $("input, select, textarea").on("input change", function() {
            let fieldName = $(this).attr("name").replace("[]", "");
            $("#" + fieldName + "_error").text("");
        });

        // **Close PDF Popup and Redirect**
        $("#closePopup").on("click", function() {
            $("#pdfPopup").fadeOut(function() {
                window.location.href = "dashboard";
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let applicantNameInput = document.getElementById("Applicant_Name");

        applicantNameInput.addEventListener("focus", function() {
            this.addEventListener("input", function() {
                this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        let applicantNameInput = document.getElementById("Fathers_Name");

        applicantNameInput.addEventListener("focus", function() {
            this.addEventListener("input", function() {
                this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
            });
        });
    });



    $(document).ready(function() {
        function restrictToLetters(inputSelector) {
            $(document).on("input", inputSelector, function() {
                this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Allow only letters and spaces
            });
        }

        // Apply validation to multiple fields
        restrictToLetters("[name='institute_name[]']");
        restrictToLetters("[name='work_level[]']");
        restrictToLetters("[name='Designation[]']");

    });

    document.addEventListener("DOMContentLoaded", function() {
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
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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

        // Form validation on submit
        document.querySelector("form").addEventListener("submit", function(event) {
            if (checkbox.checked) {
                let isValid = true;

                if (licenseInput.value.trim() === "") {
                    licenseError.textContent = "License Number is required.";
                    isValid = false;
                } else {
                    licenseError.textContent = "";
                }

                if (dateInput.value.trim() === "") {
                    dateError.textContent = "Date is required.";
                    isValid = false;
                } else {
                    dateError.textContent = "";
                }

                if (!isValid) {
                    event.preventDefault(); // Prevent form submission if validation fails
                }
            }
        });
    });
</script>
<script>
    document.getElementById("filter-status-login").addEventListener("change", function(e) {
        const filter = e.target.value;

        // Filter projects
        document.querySelectorAll(".project-card-login").forEach(card => {
            if (filter === "all" || card.dataset.status === filter) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });

        // Filter tasks
        document.querySelectorAll(".table-login tbody tr").forEach(row => {
            if (filter === "all" || row.dataset.status === filter) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

</script>
</html>