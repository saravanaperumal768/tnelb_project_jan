$(document).ready(function () {
    // Handle English Modal
    $('.edit-newsboard-btn[data-bs-target="#inputFormModalEnglish"]').on('click', function () {
        const content = $(this).data('content');
        const id = $(this).data('id');
        $('#inputFormModalEnglish textarea[name="whatsnew_en"]').val(content);
        $('#inputFormModalEnglish input[name="id"]').val(id);
    });

    // Handle Tamil Modal
    $('.edit-newsboard-btn[data-bs-target="#inputFormModalTamil"]').on('click', function () {
        const content = $(this).data('content');
        const id = $(this).data('id');
        $('#inputFormModalTamil textarea[name="whatsnew_ta"]').val(content);
        $('#inputFormModalTamil input[name="id"]').val(id);
    });

    // Update English
    $('#updatewhats_english').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const id = form.find('input[name="id"]').val();
        const content = form.find('textarea[name="whatsnew_en"]').val();

        $.ajax({
            url: '/admin/update-whatsnew',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                whatsnew_en: content
            },
            success: function () {
                // Update content box
                $('#infobox4 .info-box-2-content').first().html(content);

                // Update data-content of edit button
                $(`.edit-newsboard-btn[data-id="${id}"]`).data('content', content);

                // Close modal
                const modalEl = document.getElementById('inputFormModalEnglish');
                bootstrap.Modal.getInstance(modalEl).hide();
            },
            error: function () {
                alert('English update failed!');
            }
        });
    });

    // Update Tamil
    $('#updatewhats_tamil').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const id = form.find('input[name="id"]').val();
        const content = form.find('textarea[name="whatsnew_ta"]').val();

        $.ajax({
            url: '/admin/update-whatsnew',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                whatsnew_ta: content
            },
            success: function () {
                // Update content box
                $('#infobox4 .info-box-2-content').last().html(content);

                // Update data-content of edit button
                $(`.edit-newsboard-btn[data-id="${id}"]`).data('content', content);

                // Close modal
                const modalEl = document.getElementById('inputFormModalTamil');
                bootstrap.Modal.getInstance(modalEl).hide();
            },
            error: function () {
                alert('Tamil update failed!');
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("addimage");
    const galleryRow = document.getElementById("gallery-row"); // updated selector

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(form);

        fetch("/admin/upload-image", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log("Success:", data);
            alert("Image uploaded successfully!");

            if (data.image) {
                const newCol = document.createElement("div");
                newCol.className = "col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-4";

                newCol.innerHTML = `
                    <a class="card style-6" href="#">
                        <img src="/admin/gallery/${data.image.image}" alt="${data.image.imagetitle}" class="slider-image text-center img-thumbnail1" />
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12 text-center mb-4">
                                    <b>${data.image.imagetitle}</b>
                                </div>
                            </div>
                        </div>
                    </a>
                `;

                galleryRow.appendChild(newCol); // Prepend into the existing row
                form.reset();
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Upload failed.");
        });
    });
});



$(document).ready(function () {
    // Show modal and populate data
    $('.btn-info').on('click', function () {
        let id = $(this).data('id');
        let image = $(this).closest('.card').find('img').attr('src');

        $('#editImageId').val(id);
        $('#editImagePreview').attr('src', image);
    });

    // AJAX Submit Form
    $('#editGalleryForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let id = $('#editImageId').val();

        $.ajax({
            url: '/admin/gallery/' + id,  // your route
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                $('#inputFormModaleditgallery').modal('hide');
                alert('Image updated successfully');
                location.reload(); // or update the DOM dynamically
            },
            error: function (xhr) {
                alert('Error updating image');
            }
        });
    });
});

$(document).ready(function () {
    // Set CSRF token in AJAX header
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addnewstaff').on('submit', function (e) {
        e.preventDefault();
// alert('111');
        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: STAFF_FORM_URL, // This will be defined globally in your Blade
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert('Staff member added successfully!');
                $('#addnewstaff')[0].reset();
            },
            error: function (xhr) {
                alert('Error adding staff member.');
                console.log(xhr.responseText);
            }
        });
    });
});

