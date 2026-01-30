$(document).ready(function() {

    $(document).on('click', '.editInstruction', function () {
    // Get all data-* attributes
        const licence_id = $(this).data('licence_id');
        
        $('#licence_id').val(licence_id);

        $.ajax({
            url: BASE_URL + '/admin/licence/getInstruction', // your Laravel route
            method: 'POST',
            data: {
                licence_id,
            },
            dataType: 'json',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status == 200) {
                    const editorText = JSON.parse(response.data);
                    console.log(editorText);
                    quill.setContents(editorText);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong',
                    });
                }
               
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

    $(document).on('click', '.btnInstruction', function () {
        const rec_id = $('#licence_id').val();
        const instructionData = JSON.stringify(quill.getContents());

        
        $.ajax({
            url: BASE_URL + '/admin/licence/updateInstruct', // your Laravel route
            method: 'POST',
            data: {
                rec_id,
                instructionData
            },
            dataType: 'json',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
               if (response.status == false) {
                    Swal.fire({
                        icon: 'warning',
                        title: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    })
                }else{
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
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
});



 

