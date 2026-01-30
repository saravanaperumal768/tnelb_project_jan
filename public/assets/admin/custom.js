$(document).ready(function () {
  // $("#login_form").submit(function (e) {
  //   e.preventDefault();

  //   var user_name = $('#username').val();
  //   var user_pass = $('#password').val();
  //   var token = $('#token').val();

  //   if (!user_name || !user_pass || !token) {
  //     alert("Please fill all fields.");
  //     return;
  //   }

  // // Hash password (SHA-512)
  //   user_pass = sha512(user_pass);
  //   var randomnumber = Math.floor((Math.random() * 1000000) + 1);
  //   var randompassword = randomnumber + sha512(user_pass);
  //   var final_password = sha512(randompassword);
  //   alert(final_password);
  //   var obj = {
  //     username: user_name,
  //     password: final_password,
  //     token: token
  //   };

  //   $.ajax({
  //     method: "POST",
  //     url: "ajaxServices/Login.php",
  //     data: obj,
  //     success: function (response) {
  //       if (response.includes("Invalid Captcha")) {
  //         alert("Captcha incorrect! Try again.");
  //       } else if (response.includes("Please Enter Correct Username Or Password")) {
  //         alert("Incorrect credentials!");
  //       } else {
  //         window.location.href = response;
  //       }
  //     }
  //   });
  // });



  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  




  $('.other_reason').maxlength({
    placement:"bottom",
  });
});
