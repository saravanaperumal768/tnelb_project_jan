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
        const content = editors['whatsnew_en']
            ? editors['whatsnew_en'].getData()
            : form.find('textarea[name="whatsnew_en"]').val();
        const status = form.find('select[name="status"]').val();
    
        $.ajax({
            url: '/admin/update-whatsnew',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                whatsnew_en: content,
                status: status
            },
            success: function () {
                const row = $(`tr[data-id="${id}"]`);
    
                // ✅ Update the content in the table
                row.find('td.table_tdcontrol').html(content);
    
                // ✅ Update the data attributes for next edit
                row.find('.editscrollcontent')
                    .data('whatsnew_en', content)
                    .data('status', status);
    
                // ✅ Update status badge
                const badgeText = {
                    '1': 'Published',
                    '0': 'Draft',
                    '2': 'Disabled'
                };
    
                const badgeClass = {
                    '1': 'badge-success',
                    '0': 'badge-dark',
                    '2': 'badge-danger'
                };
    
                row.find('td .badge')
                    .removeClass('badge-success badge-dark badge-danger')
                    .addClass(badgeClass[status])
                    .text(badgeText[status]);
    
                // ✅ Close the modal
                const modalEl = document.getElementById('inputFormModalEnglish');
                bootstrap.Modal.getInstance(modalEl).hide();
            },
            error: function () {
                alert('Update failed!');
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
            url: BASE_URL +  '/admin/update-whatsnew',
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
$(document).ready(function () {
    // Open modal and populate form fields when clicking edit button
    $(document).on('click', '.edit-gallery-btn', function () {
        let id = $(this).data('id');
        let image = $(this).data('image');
        let title = $(this).data('title');

        $('#editImageId').val(id);
        $('#editImagePreview').attr('src', image);
        $('#editImageTitle').val(title);
    });

    // AJAX form submission to update gallery image and title
    $('#editGalleryForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let id = $('#editImageId').val();

        $.ajax({
            url: BASE_URL + '/admin/gallery/' + id,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: function (response) {
                // Close modal
                $('#inputFormModaleditgallery').modal('hide');

                if (response.image && response.imagetitle) {
                    // Find the gallery card corresponding to the updated image
                    const card = $(`.edit-gallery-btn[data-id="${id}"]`).closest('.col-xxl-4');
                    const newImageSrc = `/portaladmin/gallery/${response.image}`;

                    // Update the image source and alt attribute
                    card.find('img')
                        .attr('src', newImageSrc)
                        .attr('alt', response.imagetitle);

                    // Update the image title text
                    card.find('b').text(response.imagetitle);

                    // Update the edit button data attributes so modal can be opened with new data next time
                    const editBtn = card.find('.edit-gallery-btn');
                    editBtn.attr('data-image', newImageSrc);
                    editBtn.attr('data-title', response.imagetitle);
                }

                // Alert after updating the DOM
                alert('Image updated successfully');
            },
            error: function (xhr) {
                alert('Error updating image');
            }
        });
    });
});



$(document).ready(function () {
    $('.delete-gallery').on('click', function () {
        let button = $(this); // the clicked delete button
        let id = button.data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will deactivate the image.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, deactivate it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL +  '/admin/gallery/delete/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deactivated!',
                            'The image has been deactivated.',
                            'success'
                        );

                        // Remove the entire card
                        button.closest('.col-xxl-4').remove();
                    },
                    error: function () {
                        Swal.fire(
                            'Error!',
                            'Fill the Fields Properly while deactivating.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});



$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addnewstaff').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: BASE_URL +  "/admin/staff/insert",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#addnewstaff')[0].reset();
                $('.error-text').text('');
            
                // Get the number of rows already in the table
                var rowCount = $('#staffTableBody tr').length + 1;
            
                // Append new row
                $('#staffTableBody').append(`
                    <tr>
                        <td>${rowCount}</td>
                        <td>${response.staff.staff_name}</td>
                        <td>${response.staff.name}</td>
                        <td>${response.staff.email}</td>
                        <td>${response.staff.form_name}</td>
                    </tr>
                `);
            
                // Show success alert
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Staff member added successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    $('.error-text').text('');
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    console.log(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Fill the Fields Properly!',
                    });
                }
            }
        });
    });
});

// ---Menu Page_type modal--------

$(document).ready(function () {
    $('#page_type_menu').on('change', function () {
        let selected = $(this).val();

        if (selected === 'Static Page') {
            $('#staticFields').show();
            $('#pdfFields, #urlFields').hide();
        } else if (selected === 'pdf') {
            $('#pdfFields').show();
            $('#staticFields, #urlFields').hide();
        } else if (selected === 'url') {
            $('#urlFields').show();
            $('#staticFields, #pdfFields').hide();
        } else {
            $('#staticFields, #pdfFields, #urlFields').hide();
        }
    });
});


//   ------------------------------





// --------------------submenu selectbox---------------

$(document).ready(function () {
    function toggleSubMenuFields(type) {
        if (type === 'pdf') {
            $('.pdf-inputs').removeClass('d-none');
            $('.static-page-inputs').addClass('d-none');
            $('.url-inputs').addClass('d-none');
        } else if (type === 'Static Page') {
            $('.static-page-inputs').removeClass('d-none');
            $('.pdf-inputs').addClass('d-none');
            $('.url-inputs').addClass('d-none');
        } else if (type === 'url') {
            $('.url-inputs').removeClass('d-none');
            $('.static-page-inputs').addClass('d-none');
            $('.pdf-inputs').addClass('d-none');
        } else {
            $('.pdf-inputs').addClass('d-none');
            $('.static-page-inputs').addClass('d-none');
            $('.url-inputs').addClass('d-none');
        }
    }

    $('#page_type_submenu').on('change', function () {
        const selected = $(this).val();
        toggleSubMenuFields(selected);
    });

    // Trigger on page load (if value already selected)
    $('#page_type_submenu').trigger('change');
});



// ---------------------

    // Called when modal is opened or on page_type change
    
    function toggleSubMenuInputs(type) {
        if (type && type.toLowerCase() === 'pdf') {
            $('.pdf-input').removeClass('d-none');
            $('.rte-input').addClass('d-none');
        } else {
            $('.pdf-input').addClass('d-none');
            $('.rte-input').removeClass('d-none');
        }
    }

    // Change inputs on dropdown change
    $(document).on('change', '#page_type', function () {
        toggleSubMenuInputs($(this).val());
    });

    // Edit button click - populate form
    $(document).on('click', '.editsubMenu', function () {
        const el = $(this);

        $('#submenuFormedit input[name="menu_name_en"]').val(el.data('menu_name_en'));
        $('#submenuFormedit input[name="menu_name_ta"]').val(el.data('menu_name_ta'));
        $('#submenuFormedit input[name="page_url"]').val(el.data('page_url'));
        $('#submenuFormedit input[name="page_url_ta"]').val(el.data('page_url_ta'));
        $('#submenuFormedit select[name="parent_code"]').val(el.data('parent_code'));
        $('#submenuFormedit input[name="order_id"]').val(el.data('order_id'));
        $('#submenuFormedit select[name="page_type"]').val(el.data('page_type'));
        $('#menu_id').val(el.data('id'));
        const pdfEn = el.data('pdf_en');
                const pdfTa = el.data('pdf_ta');

                // Remove 'admin/' prefix if present
                const cleanPdfEn = pdfEn ? pdfEn.replace(/^admin\//, '') : null;
                const cleanPdfTa = pdfTa ? pdfTa.replace(/^admin\//, '') : null;

                if (cleanPdfEn) {
                    $('#submenu_pdf_link_en')
                        .attr('href', '/' + cleanPdfEn)
                        .removeClass('d-none');
                } else {
                    $('#submenu_pdf_link_en').addClass('d-none');
                }

                if (cleanPdfTa) {
                    $('#submenu_pdf_link_ta')
                        .attr('href', '/' + cleanPdfTa)
                        .removeClass('d-none');
                } else {
                    $('#submenu_pdf_link_ta').addClass('d-none');
                }

    
        toggleSubMenuInputs(el.data('page_type'));
        $('#inputFormModaledit').modal('show');

        toggleSubMenuInputs(el.data('page_type'));
        $('#inputFormModaledit').modal('show');
    });

    // Reset form visibility on modal close
    $('#inputFormModaledit').on('hidden.bs.modal', function () {
        $('.pdf-input').addClass('d-none');
        $('.rte-input').removeClass('d-none');
    });

// ------------ckewditor-------------
let editors = {}; // Store CKEditor instances

// Initialize all editors first
document.querySelectorAll('.rich-editor').forEach(textarea => {
    ClassicEditor
        .create(textarea)
        .then(editor => {
            editors[textarea.id] = editor;
        })
        .catch(error => {
            console.error(error);
        });
});

// Fill content and set ID when modal is opened
$(document).on('click', '.editsubMenucontent', function () {
    const submenu_content_en = $(this).data('submenu_content_en');
    const submenu_content_ta = $(this).data('submenu_content_ta');
    const id = $(this).data('id');

    // Set CKEditor content
    if (editors['submenu_content_en']) {
        editors['submenu_content_en'].setData(submenu_content_en || '');
    }

    if (editors['submenu_content_ta']) {
        editors['submenu_content_ta'].setData(submenu_content_ta || '');
    }

    // Set hidden input field for ID
    $('#submenu_id').val(id);
});

// ----submenucontent---------------------------
// $('#submenucontentedit').on('submit', function(e) {
//     e.preventDefault();

//     const id = $('#submenu_id').val();
//     const submenu_content_en = editors['submenu_content_en'].getData();
//     const submenu_content_ta = editors['submenu_content_ta'].getData();

//     $.ajax({
//         url: '/admin/update-submenu-content',
//         method: 'POST',
//         data: {
//             _token: $('meta[name="csrf-token"]').attr('content'),
//             id: id,
//             submenu_content_en: submenu_content_en,
//             submenu_content_ta: submenu_content_ta,
//         },
//         success: function(response) {
//             if (response.success) {
//                 // Update content on table
//                 $(`#content_en_${id}`).html(submenu_content_en);
//                 $(`#content_ta_${id}`).html(submenu_content_ta);

//                 // Optional: If modal is still open and you want to refresh CKEditor content
//                 if (editors['submenu_content_en']) {
//                     editors['submenu_content_en'].setData(submenu_content_en);
//                 }
//                 if (editors['submenu_content_ta']) {
//                     editors['submenu_content_ta'].setData(submenu_content_ta);
//                 }

//                 // Hide modal
//                 $('#editsubMenucontent').modal('hide');
//             }
//         },
//         error: function(xhr) {
//             console.log(xhr.responseText);
//         }
//     });
// });


$('#submenucontentedit').on('submit', function(e) {
    e.preventDefault();

    const id = $('#submenu_id').val();
    const submenu_content_en = editors['submenu_content_en'].getData();
    const submenu_content_ta = editors['submenu_content_ta'].getData();

    $.ajax({
        url: BASE_URL +  '/admin/update-submenu-content',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id,
            submenu_content_en: submenu_content_en,
            submenu_content_ta: submenu_content_ta,
        },
        success: function(response) {
            if (response.success) {
                // Optionally update table view immediately
                $(`#content_en_${id}`).html(submenu_content_en);
                $(`#content_ta_${id}`).html(submenu_content_ta);

                // Close modal
                $('#editsubMenucontent').modal('hide');

                // Reload the page after a slight delay to ensure smooth UX
                setTimeout(() => {
                    location.reload();
                }, 300); // 300ms delay (optional)
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
});


// ----------------NewsController----------------------

$(document).on('click', '[data-bs-target="#inputFormModaleditboard"]', function () {
    const id = $(this).data('id');
    const heading = $(this).data('heading');
    const newsboard_en = $(this).data('newsboard_en');
    const status = $(this).data('status');
    const language = $(this).data('language');

    // Set values
    $('#board_id').val(id);
    $('#status_select').val(status);
    $('#language_select').val(language);

    // Set heading
    if (typeof editors !== 'undefined' && editors['heading']) {
        editors['heading'].setData(heading || '');
    } else {
        $('#heading').val(heading || '');
    }

    // Set Notice Board Content using CKEditor (if exists)
    if (typeof editors !== 'undefined' && editors['newsboard_en']) {
        editors['newsboard_en'].setData(newsboard_en || '');
    } else {
        $('#newsboard_en').val($('<div/>').html(newsboard_en).text() || '');
    }
});


// ----newscontroller update ---------------------
// Fill modal form on edit click
$(document).on('click', '.editsubMenucontent', function () {
    const id = $(this).data('id');
    const heading = $(this).data('heading');
    const newsboard_en = $(this).data('newsboard_en');
    const status = $(this).data('status');
    const language = $(this).data('language');

    $('#board_id').val(id);
    $('#status_select').val(status);
    $('#language_select').val(language);

    if (editors['heading']) editors['heading'].setData(heading || '');
    if (editors['newsboard_en']) editors['newsboard_en'].setData(newsboard_en || '');
});

// // Submit edit form
// $('#noticeboardedit').on('submit', function (e) {
//     e.preventDefault();

//     const heading = editors['heading'] ? editors['heading'].getData() : $('#heading').val();
//     const newsboard_en = editors['newsboard_en'] ? editors['newsboard_en'].getData() : $('#newsboard_en').val();

//     const formData = {
//         id: $('#board_id').val(),
//         status: $('#status_select').val(),
//         language: $('#language_select').val(),
//         heading: heading,
//         newsboard_en: newsboard_en,
//         updated_by: 'admin',
//         _token: $('meta[name="csrf-token"]').attr('content')
//     };

//     $.ajax({
//         url: '/admin/newsboard/updatenews',
//         type: 'POST',
//         data: formData,
//         success: function (response) {
//             if (response.success) {
//                 const news = response.news;
//                 const row = $('tr[data-id="' + news.id + '"]');

//                 // Update row content
//                 row.find('td:eq(1)').text(news.language);
//                 row.find('td:eq(2)').text(news.updated_at.substring(0, 10));
//                 row.find('td:eq(3)').html(news.heading);
//                 row.find('td:eq(4)').html(news.newsboard_en);

//                 let badgeClass = '', badgeText = '';
//                 if (news.status == '1') {
//                     badgeClass = 'badge-success'; badgeText = 'Published';
//                 } else if (news.status == '0') {
//                     badgeClass = 'badge-dark'; badgeText = 'Draft';
//                 } else if (news.status == '2') {
//                     badgeClass = 'badge-danger'; badgeText = 'Disabled';
//                 }
//                 row.find('td:eq(5)').html(`<span class="badge ${badgeClass}">${badgeText}</span>`);

//                 // Update data on edit button
//                 const editBtn = row.find('a[data-bs-toggle="modal"]');
//                 editBtn.data('heading', news.heading);
//                 editBtn.data('newsboard_en', news.newsboard_en);
//                 editBtn.data('status', news.status);
//                 editBtn.data('language', news.language);

//                 // Close modal
//                 $('#inputFormModaleditboard').modal('hide');
//             }
//         },
//         error: function (xhr) {
//             alert('Fill the Fields Properly!');
//             console.log(xhr.responseText);
//         }
//     });
// });
// // --------------------------

$(document).on('click', '.editscrollcontent', function () {
    const id = $(this).data('id');
    const whatsnew_en = $(this).data('whatsnew_en');
    const language = $(this).data('language');
    const status = $(this).data('status'); // ✅ FIXED

    $('#whatsnew_en_id').val(id);
    $('#status_select').val(status);      // ✅ FIXED
    $('#language_select').val(language);

    if (editors['whatsnew_en']) {
        editors['whatsnew_en'].setData(whatsnew_en || '');
    } else {
        $('textarea[name="whatsnew_en"]').val(whatsnew_en || '');
    }
});

// ------------------------------------------------


let currentEditSliderId = null;

$('.edit-open-media').on('click', function () {
    currentEditSliderId = $(this).data('slider-id');
    $('#editMediaLibraryModal').modal('show');
});

$('#editSelectImageBtn').on('click', function () {
    var selectedRadio = $('input[name="editMediaSelect"]:checked');
    if (selectedRadio.length > 0) {
        var imageId = selectedRadio.val();
        var imagePath = selectedRadio.closest('.card').find('img').data('path');

        // Set hidden input value
        $('#editSliderImagePath' + currentEditSliderId).val(imageId);

        // Show preview
        $('#editSliderImagePreview' + currentEditSliderId).html(
            '<img src="' + imagePath + '" class="img-fluid" style="max-height:150px;">'
        );

        // Close media modal
        $('#editMediaLibraryModal').modal('hide');
    } else {
        alert("Please select an image.");
    }
});


// -----------slider----------------


$('#insertslider').on('submit', function(e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    // Clear previous errors
    $('#sliderNameError, #sliderImageError, #sliderCaptionError, #sliderCaptionTaError, #sliderStatusError').text('');

    $.ajax({
        url: BASE_URL + '/admin/homeslider/insertdata',
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
    $('#insertslider')[0].reset();
    $('#additems').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');

    Swal.fire('Success', 'Slider added successfully!', 'success');

    const slider = response.slider;
    const media = slider.media; // ✅ fetched via relation

    const statusLabel = slider.slider_status == '1' ? 'Published' : (slider.slider_status == '0' ? 'Draft' : 'Disabled');
    const statusClass = slider.slider_status == '1' ? 'badge-success' : (slider.slider_status == '0' ? 'badge-dark' : 'badge-danger');

    const captionTa = slider.slider_caption_ta || '-----';

    const mediaHtml = media ? `
        <a href="/${media.filepath_img_pdf}" class="defaultGlightbox glightbox-content">
            <img src="/${media.filepath_img_pdf}" alt="${media.alt_text_en}" class="img-fluid" />
            <p class="text-info mt-1">Click to View</p>
        </a>` : '<span class="text-danger">No image found</span>';

    const newRow = `
        <tr id="slider-row-${slider.id}">
            <td class="text-center index">#</td>
            <td class="text-center slider-caption table_tdcontrol">${slider.slider_caption}</td>
            <td class="text-center slider-caption table_tdcontrol">${captionTa}</td>
            <td class="text-center">${mediaHtml}</td>
            <td class="text-center index">${slider.updated_at?.substring(0, 10).split('-').reverse().join('-')}</td>
            <td class="text-center">
                <span class="badge ${statusClass}">${statusLabel}</span>
            </td>
            <td class="text-center">
                <div class="action-btns">
                    <i class="fa fa-pencil text-primary me-2 cursor-pointer"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal${slider.id}"
                        title="Edit"></i>
                </div>
            </td>
        </tr>`;

    $('#sliderTableBody').prepend(newRow);

    $('#sliderTableBody tr').each(function(index) {
        $(this).find('td.index:first').text(index + 1);
    });

    if (typeof GLightbox !== 'undefined') {
        GLightbox({ selector: '.defaultGlightbox' });
    }
},

        error: function(xhr) {
            let errors = xhr.responseJSON?.errors;
            if (errors) {
                if (errors.slider_image) $('#sliderImageError').text(errors.slider_image[0]);
                if (errors.slider_caption) $('#sliderCaptionError').text(errors.slider_caption[0]);
                if (errors.slider_caption_ta) $('#sliderCaptionTaError').text(errors.slider_caption_ta[0]);
                if (errors.slider_status) $('#sliderStatusError').text(errors.slider_status[0]);
            } else {
                Swal.fire("Error", "Something went wrong", "error");
            }
        }
    });
});

// ---------slider update ----------------------
$('#selectImageBtn').on('click', function () {
    var selectedRadio = $('input[name="mediaSelect"]:checked');

    if (selectedRadio.length > 0) {
        var imageId = selectedRadio.val();
        var imagePath = selectedRadio.closest('.card').find('img').data('path');

        // Store only the ID in the hidden input
        $('#sliderImagePath').val(imageId);

        // Show preview using full image path
        $('#sliderImagePreview').html('<img src="' + imagePath + '" class="img-fluid rounded" style="max-height:150px;">');

        // Close media modal
        $('#mediaLibraryModal').modal('hide');

        // Reopen add modal after media modal is closed
        $('#mediaLibraryModal').on('hidden.bs.modal', function () {
            $('#additems').modal('show');
            $(this).off('hidden.bs.modal'); // Remove listener to avoid duplicate openings
        });

    } else {
        alert("Please select an image.");
    }
});






// --------------------media image edit------------------------


// $(document).on('click', '.choose-media-image', function () {
//     const imagePath = $(this).data('path');
//     const sliderId = $('#mediaModal').data('target-id');

//     $(`form[data-id="${sliderId}"] .slider_image_path`).val(imagePath);
//     $(`#preview_${sliderId}`).attr('src', '/' + imagePath);

//     $('#mediaModal').modal('hide');
// });

$(document).on('submit', '.sliderupdate-form', function (e) {
    e.preventDefault();

    let form = $(this);
    let sliderId = form.data('id');
    let url = form.data('url');
    let formData = new FormData(this);

    $.ajax({
        url: `${url}/${sliderId}`,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
       success: function (response) {
            const slider = response.slider;
            const statusLabel = slider.slider_status == 1 ? 'Published' : slider.slider_status == 0 ? 'Draft' : 'Disabled';
            const statusClass = slider.slider_status == 1 ? 'badge-success' : slider.slider_status == 0 ? 'badge-dark' : 'badge-danger';
            const caption_ta = slider.slider_caption_ta ? slider.slider_caption_ta : '<p>-----</p>';

            const imageUrl = slider.media ? '/' + slider.media.filepath_img_pdf : '';
            const imageAlt = slider.media ? slider.media.alt_text_en ?? 'Slider Image' : 'Slider Image';

            const updatedRow = `
                <tr id="slider-row-${slider.id}">
                    <td class="text-center index">#</td>
                    <td class="text-center slider-caption table_tdcontrol">${slider.slider_caption}</td>
                    <td class="text-center slider-caption table_tdcontrol">${caption_ta}</td>
                    <td class="text-center">
                        ${slider.media ? `
                        <a href="${imageUrl}" class="defaultGlightbox glightbox-content">
                            <img src="${imageUrl}" alt="${imageAlt}" class="img-fluid" />
                            <p class="text-info mt-1">Click to View</p>
                        </a>` : `<p class="text-danger">Media not found</p>`}
                    </td>
                    <td class="text-center index">${formatDMY(slider.updated_at)}</td>
                    <td class="text-center slider-caption">
                        <span class="badge ${statusClass}">${statusLabel}</span>
                    </td>
                    <td class="text-center">
                        <i class="fa fa-pencil text-primary me-2 cursor-pointer"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal${slider.id}" 
                        title="Edit"></i>
                    </td>
                </tr>`;

            $(`#slider-row-${slider.id}`).replaceWith(updatedRow);

            $('#sliderTableBody tr').each(function (index) {
                $(this).find('td.index:first').text(index + 1);
            });

            if (typeof GLightbox !== 'undefined') {
                GLightbox({ selector: '.defaultGlightbox' });
            }

            $('#editModal' + sliderId).modal('hide');
            Swal.fire('Updated', 'Slider updated successfully.', 'success');
        },
        error: function (xhr) {
            Swal.fire('Error', 'Update failed.', 'error');
        }
    });
});

function formatDMY(dateStr) {
    const d = new Date(dateStr);
    return `${String(d.getDate()).padStart(2, '0')}-${String(d.getMonth() + 1).padStart(2, '0')}-${d.getFullYear()}`;
}



// ----------------------------------------------------------------------------

$(document).ready(function () {

    // Submit Add Menu Form
    $('#menuForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let submitBtn = $('#menuForm button[type="submit"]');
        submitBtn.prop('disabled', true).text('Saving...');

          // Get page type to validate conditionally
    const pageType = $('select[name="page_type"]').val();
    const externalUrl = $('input[name="external_url"]').val();

    if (pageType === 'url') {
        // Regex to check if URL starts with http:// or https://
        const urlPattern = /^(http:\/\/|https:\/\/).+/i;
        if (!urlPattern.test(externalUrl)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid URL',
                text: 'Please enter a valid URL starting with http:// or https://'
            });
            submitBtn.prop('disabled', false).text('Add');
            return;
        }
    }

        $.ajax({
            url: BASE_URL +  "/admin/menus/insertmenu",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success && response.data) {
                    const menu = response.data;
                    const page = menu.menu_page; // Related page content

                    // Reset form
                    $('#menuForm')[0].reset();
                    let modal = bootstrap.Modal.getInstance(document.getElementById('inputFormModaladd'));
                    if (modal) modal.hide();
                    submitBtn.prop('disabled', false).text('Add');

                    // Generate page type content
                    let pageTypeContent = '—';
                    if (menu.page_type === 'Static Page') {
                        pageTypeContent = page?.page_url || '';
                    } else if (menu.page_type === 'pdf') {
                        pageTypeContent = '';
                        if (page?.pdf_en) {
                            pageTypeContent += `<a href="${window.location.origin}/${page.pdf_en}" target="_blank" class="me-2" title="English PDF"><i class="fa fa-file-pdf-o text-danger"></i></a>`;
                        }
                        if (page?.pdf_ta) {
                            pageTypeContent += `<a href="${window.location.origin}/${page.pdf_ta}" target="_blank" title="Tamil PDF"><i class="fa fa-file-pdf-o text-success"></i></a>`;
                        }
                    } else if (menu.page_type === 'url') {
                        pageTypeContent = `<a href="${page?.external_url || '#'}" target="_blank">External Link</a>`;
                    }

                    // Status badge
                    let statusLabel = '', badgeClass = '';
                    if (menu.status == 1) {
                        statusLabel = 'Published'; badgeClass = 'badge-success';
                    } else if (menu.status == 0) {
                        statusLabel = 'Draft'; badgeClass = 'badge-dark';
                    } else if (menu.status == 2) {
                        statusLabel = 'Disabled'; badgeClass = 'badge-danger';
                    }

                    // Static page content edit icon
                    let staticPageLink = '';
                    if (menu.page_type === 'Static Page') {
                        staticPageLink = `<li><a href="/admin/menuscontent/${menu.id}"  title="Edit Content"><i class="fa fa-file-text-o"></i></a></li>`;
                    }

                    // New row HTML
                    const newRow = `
                    <tr data-id="${menu.id}">
                        <td class="text-center">1</td>
                        <td>${menu.menu_name_en}</td>
                        <td>${menu.menu_name_ta}</td>
                        <td class="text-capitalize">${menu.page_type}</td>
                        <td class="external-url">${pageTypeContent}</td>
                        <td>${menu.order_id}</td>
                        <td><span class="badge ${badgeClass}">${statusLabel}</span></td>
                        <td>
                            <ul class="table-controls">
                                <li>
                                    <a href="javascript:void(0);" class="editMenu"
                                        data-id="${menu.id}"
                                        data-menu_name_en="${menu.menu_name_en}"
                                        data-menu_name_ta="${menu.menu_name_ta}"
                                        data-page_type="${menu.page_type}"
                                        data-order_id="${menu.order_id}"
                                        data-status="${menu.status}"
                                        data-page_url="${page?.page_url || ''}"
                                        data-page_url_ta="${page?.page_url_ta || ''}"
                                        data-pdf_en="${page?.pdf_en ? window.location.origin + '/' + page.pdf_en : ''}"
                                        data-pdf_ta="${page?.pdf_ta ? window.location.origin + '/' + page.pdf_ta : ''}"
                                        data-external_url="${page?.external_url || ''}"
                                        data-footer_quicklinks_id="${page?.footer_quicklinks_id || ''}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#inputFormModaledit"
                                        title="Edit">
                                        <i class="fa fa-pencil text-primary me-2 cursor-pointer"></i>
                                    </a>
                                </li>
                                ${staticPageLink}
                            </ul>
                        </td>
                    </tr>
                `;

                $('#sortable').prepend(newRow);
                $('#sortable tr').each(function (index) {
                    $(this).find('td:first').text(index + 1);
                });

                Swal.fire('Success', response.message, 'success');
            } else {
                Swal.fire('Error', 'Failed to save menu', 'error');
                submitBtn.prop('disabled', false).text('Add');
            }
        },
        error: function (xhr) {
            submitBtn.prop('disabled', false).text('Add');

            const errors = xhr.responseJSON?.errors;
            if (errors) {
                let errorMessages = '';
                $.each(errors, function (key, messages) {
                    errorMessages += `${messages[0]}<br>`;
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessages,
                });
            } else {
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            }
        }
        });
    });

    // Handle Edit Menu
 $(document).ready(function () {

    function toggleFieldsEdit(pageType) {
        $('#staticFieldsEdit, #pdfFieldsEdit, #urlFieldsEdit').hide();

        if (pageType === 'Static Page') {
            $('#staticFieldsEdit').show();
        } else if (pageType === 'pdf') {
            $('#pdfFieldsEdit').show();
        } else if (pageType === 'url') {
            $('#urlFieldsEdit').show();
        }
    }

    // Page Type dropdown change
    $('#page_type_menuedit').on('change', function () {
        toggleFieldsEdit($(this).val());
    });

    // When Edit button is clicked
    $(document).on('click', '.editMenu', function () {
        const el = $(this);

        // Reset the form and hide pdf links
        $('#menuFormedit')[0].reset();
        $('#pdf_en_link, #pdf_ta_link').hide();

        // Set hidden fields
        $('#menu_id').val(el.data('id'));
        $('#original_order_id').val(el.data('order_id'));
        $('#order_id_input').val(el.data('order_id'));
        $('#statusSelectEdit').val(el.data('status'));

        // Set dropdowns
        const pageType = el.data('page_type');
        $('#page_type_menuedit').val(pageType).trigger('change');

        // Set common fields
        $('input[name="menu_name_en"]').val(el.data('menu_name_en') || '');
        $('input[name="menu_name_ta"]').val(el.data('menu_name_ta') || '');

        // Static Page values
        if (pageType === 'Static Page') {
            $('input[name="page_url"]').val(el.data('page_url') || '');
            $('input[name="page_url_ta"]').val(el.data('page_url_ta') || '');
        }

        // PDF values
        if (pageType === 'pdf') {
            const pdfEn = el.data('pdf_en');
            const pdfTa = el.data('pdf_ta');
            if (pdfEn) $('#pdf_en_link').attr('href', pdfEn).show();
            if (pdfTa) $('#pdf_ta_link').attr('href', pdfTa).show();
        }

        // URL value
        if (pageType === 'url') {
            $('input[name="external_url"]').val(el.data('external_url') || '');
        }

        // ✅ Handle footer quicklinks checkbox
        const footerQuicklinks = el.data('footer_quicklinks_id');
        if (footerQuicklinks && footerQuicklinks != 0) {
            $('#form-check-default-checked').prop('checked', true);
        } else {
            $('#form-check-default-checked').prop('checked', false);
        }

        // Show the modal
        $('#inputFormModaledit').modal('show');
    });

});


    // Toggle fields based on page type
    function toggleFieldsEdit(type) {
        $('#staticFieldsEdit, #pdfFieldsEdit, #urlFieldsEdit').hide();
        if (type === 'Static Page') {
            $('#staticFieldsEdit').show();
        } else if (type === 'pdf') {
            $('#pdfFieldsEdit').show();
        } else if (type === 'url') {
            $('#urlFieldsEdit').show();
        }
    }

    // On dropdown change in edit form
    $('#page_type_menuedit').on('change', function () {
        toggleFieldsEdit($(this).val());
    });

});


// ---------------menu edit-----------------------
$(document).ready(function () {
    function toggleFieldsEdit(pageType) {
        $('#staticFieldsEdit, #pdfFieldsEdit, #urlFieldsEdit').hide();

        if (pageType === 'Static Page') {
            $('#staticFieldsEdit').show();
        } else if (pageType === 'pdf') {
            $('#pdfFieldsEdit').show();
        } else if (pageType === 'url') {
            $('#urlFieldsEdit').show();
        }
    }

    // On page type dropdown change
    $('#page_type_menuedit').on('change', function () {
        toggleFieldsEdit($(this).val());
    });

    // When Edit button is clicked
    $(document).on('click', '.editMenu', function () {
        const el = $(this);
    
        $('#menuFormedit')[0].reset();
        $('#pdf_en_link, #pdf_ta_link').hide();
    
        $('#menu_id').val(el.data('id'));
        $('#original_order_id').val(el.data('order_id'));
        $('#order_id_input').val(el.data('order_id'));
        $('#statusSelectEdit').val(el.data('status'));
    
        const pageType = el.data('page_type');
        $('#page_type_menuedit').val(pageType).trigger('change');
    
        // Set common fields
        $('input[name="menu_name_en"]').val(el.data('menu_name_en') || '');
        $('input[name="menu_name_ta"]').val(el.data('menu_name_ta') || '');
    
        // Static Page
        if (pageType === 'Static Page') {
            $('input[name="page_url"]').val(el.data('page_url') || '');
            $('input[name="page_url_ta"]').val(el.data('page_url_ta') || '');
        }
    
        // PDF Type
        if (pageType === 'pdf') {
            const pdfEn = el.data('pdf_en');
            const pdfTa = el.data('pdf_ta');
            if (pdfEn) $('#pdf_en_link').attr('href', pdfEn).show();
            if (pdfTa) $('#pdf_ta_link').attr('href', pdfTa).show();
        }
    
        // URL Type
        if (pageType === 'url') {
            $('input[name="external_url"]').val(el.data('external_url') || '');
        }
    
        $('#inputFormModaledit').modal('show');
    });
    
});


// ---------------------------

$(document).on('submit', '#menuFormedit', function(e) {
    e.preventDefault();
    // alert('111');
    

    const form = this;
    const formData = new FormData(form);

    const pageType = $(form).find('select[name="page_type"]').val();
    const externalUrl = $(form).find('input[name="external_url"]').val();
    const menuNameEn = $(form).find('input[name="menu_name_en"]').val().trim();
    const menuNameTa = $(form).find('input[name="menu_name_ta"]').val().trim();

    // ✅ Validate required fields manually before AJAX
    if (menuNameEn === '' || menuNameTa === '') {
        let message = '';
        if (menuNameEn === '') message += 'Menu Name (English) is required.<br>';
        if (menuNameTa === '') message += 'Menu Name (Tamil) is required.<br>';

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: message,
        });
        return; // stop form submission
    }

    // ✅ Validate external_url if page_type is "url"
    if (pageType === 'url') {
        const urlPattern = /^(http:\/\/|https:\/\/)/i;
        if (!externalUrl || !urlPattern.test(externalUrl)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid External URL',
                text: 'Please enter a valid URL starting with http:// or https://'
            });
            return;
        }
    }

    $.ajax({
        url: BASE_URL+"/admin/menus/updateitems",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.conflict) {
                Swal.fire({
                    title: 'Duplicate Order ID',
                    text: response.message,
                    icon: 'warning',
                    confirmButtonText: 'OK',
                });
                return;
            }

            if (response.success) {
                handleMenuUpdate(response.menu);
            }
        },
        error: function(xhr) {
            let errors = xhr.responseJSON?.errors;
            if (errors) {
                let errorMessages = '';
                $.each(errors, function (key, messages) {
                    errorMessages += `${messages[0]}<br>`;
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessages,
                });
            } else {
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            }
        }
    });

    function handleMenuUpdate(menu) {
            const row = $(`#sortable tr[data-id="${menu.id}"]`);

            // 1. Update Menu Name, Page Type
            row.find('td:nth-child(2)').text(menu.menu_name_en || '');
            row.find('td:nth-child(3)').text(menu.menu_name_ta || '');
            row.find('td:nth-child(4)').text(menu.page_type || '');

            // 2. Page Type Content Column
            let contentCol = '';
            if (menu.page_type === 'Static Page') {
                contentCol = menu.page_url || '—';
            } else if (menu.page_type === 'pdf') {
                const links = [];
                if (menu.pdf_en) {
                    links.push(`<a href="/${menu.pdf_en}" target="_blank" class="me-2" title="English PDF">
                                    <i class="fa fa-file-pdf-o text-danger"></i>
                                </a>`);
                }
                if (menu.pdf_ta) {
                    links.push(`<a href="/${menu.pdf_ta}" target="_blank" title="Tamil PDF">
                                    <i class="fa fa-file-pdf-o text-success"></i>
                                </a>`);
                }
                contentCol = links.join(' ');
            } else if (menu.page_type === 'url') {
                contentCol = `<a href="${menu.external_url}" target="_blank">External Link</a>`;
            } else if (menu.page_type === 'submenu') {
                contentCol = '—';
            }
            row.find('td:nth-child(5)').html(contentCol);

            // 3. Order ID
            row.find('td:nth-child(6)').text(menu.order_id || '');

            // 4. Status Badge
            const badge = row.find('td:nth-child(7) .badge');
            badge.removeClass('badge-success badge-dark badge-danger');
            if (menu.status == 1) {
                badge.addClass('badge-success').text('Published');
            } else if (menu.status == 0) {
                badge.addClass('badge-dark').text('Draft');
            } else if (menu.status == 2) {
                badge.addClass('badge-danger').text('Disabled');
            }

            // 5. Update Edit Button Attributes
            const page = menu.menu_page || {};

            const editBtn = row.find('.editMenu');
            editBtn.data('menu_name_en', menu.menu_name_en || '');
            editBtn.data('menu_name_ta', menu.menu_name_ta || '');
            editBtn.data('page_type', menu.page_type || '');
            editBtn.data('order_id', menu.order_id || '');
            editBtn.data('status', menu.status);

            editBtn.data('page_url', page.page_url || '');
            editBtn.data('page_url_ta', page.page_url_ta || '');
            editBtn.data('external_url', page.external_url || '');
            editBtn.data('pdf_en', page.pdf_en ? `/${page.pdf_en}` : '');
            editBtn.data('pdf_ta', page.pdf_ta ? `/${page.pdf_ta}` : '');
            editBtn.data('footer_quicklinks_id', page.footer_quicklinks_id || 0); // ✅ Added

            // 6. Update Static Page icon (fa-file-text-o)
            const controlsList = row.find('ul.table-controls');
            controlsList.find('li').eq(1).remove(); // remove second icon if exists

            if (menu.page_type === 'Static Page') {
                controlsList.append(`
                    <li>
                        <a href="/admin/menuscontent/${menu.id}"  title="Edit">
                            <i class="fa fa-file-text-o"></i>
                        </a>
                    </li>
                `);
            }

            // 7. Close modal and reset form
            $('#inputFormModaledit').modal('hide');
            $('#menuFormedit')[0].reset();

            // 8. Visual feedback
            row.addClass('table-success');
            setTimeout(() => row.removeClass('table-success'), 1500);
        }
 
    
});


// -------------menucontentedit-----------------------

// English Content Submit
$(document).on('submit', '#menucontentedit_en', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: BASE_URL +  "/admin/menus/updatemenucontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});

// Tamil Content Submit
$(document).on('submit', '#menucontentedit_ta', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: BASE_URL +  "/admin/menus/updatemenucontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});


// ----------------------------submenu--------------------------
$(document).ready(function () {
    // Submit Add Submenu Form
    $('#submenuFormadd').on('submit', function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);
    
        const menuNameEn = form.menu_name_en.value.trim();
        const menuNameTa = form.menu_name_ta.value.trim();
        const pageType   = form.page_type.value;
        const parentCode = form.parent_code.value;
        const orderId    = form.order_id.value.trim();
        const externalUrl = form.external_url?.value.trim();
        const pageUrl    = form.page_url?.value.trim();
        const pageUrlTa  = form.page_url_ta?.value.trim();
        const pdfEn      = form.pdf_en?.files[0];
        const pdfTa      = form.pdf_ta?.files[0];
    
        let errors = [];
    
        // ✅ General validation
        if (menuNameEn === '') errors.push('Sub Menu Name (English) is required.');
        if (menuNameTa === '') errors.push('Sub Menu Name (Tamil) is required.');
        if (pageType === '') errors.push('Menu Type is required.');
        if (parentCode === '') errors.push('Main Menu is required.');
        if (orderId === '' || isNaN(orderId)) errors.push('Order ID must be a number.');
    
        // ✅ Page type-based validation
        if (pageType === 'Static Page') {
            if (!pageUrl) errors.push('Sub Menu Page URL (English) is required.');
            if (!pageUrlTa) errors.push('Sub Menu Page URL (Tamil) is required.');
        } else if (pageType === 'url') {
            const urlPattern = /^(http:\/\/|https:\/\/)/i;
            if (!externalUrl || !urlPattern.test(externalUrl)) {
                errors.push('Valid External URL starting with http:// or https:// is required.');
            }
        } else if (pageType === 'pdf') {
            if (!pdfEn) errors.push('English PDF is required.');
            if (!pdfTa) errors.push('Tamil PDF is required.');
        }
    
        // ✅ Show errors if any
        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errors.join('<br>')
            });
            return;
        }
    
        // ✅ Disable submit and proceed with AJAX
        let submitBtn = $('#submenuFormadd button[type="submit"]');
        submitBtn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: BASE_URL +  "/admin/submenus/insertsubmenu",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success && response.data) {
                    const submenu = response.data;

                    // Reset form and close modal
                    $('#submenuFormadd')[0].reset();
                    let modal = bootstrap.Modal.getInstance(document.getElementById('inputFormModal'));
                    if (modal) modal.hide();
                    submitBtn.prop('disabled', false).text('Add');

                    // Get submenu page details
                    const page = submenu.submenu_page || submenu.submenuPage;

                    // Badge setup
                    let statusLabel = '', badgeClass = '';
                    if (submenu.status == 1) {
                        statusLabel = 'Published'; badgeClass = 'badge-success';
                    } else if (submenu.status == 0) {
                        statusLabel = 'Draft'; badgeClass = 'badge-dark';
                    } else if (submenu.status == 2) {
                        statusLabel = 'Disabled'; badgeClass = 'badge-danger';
                    }

                    // Page content column
                    let pageContent = '—';
                    if (submenu.page_type === 'Static Page') {
                        pageContent = page?.page_url || '';
                    } else if (submenu.page_type === 'pdf') {
                        pageContent = '';
                        if (page?.pdf_en) {
                            pageContent += `<a href="${window.location.origin}/${page.pdf_en}" target="_blank" class="me-2" title="English PDF"><i class="fa fa-file-pdf-o text-danger"></i></a>`;
                        }
                        if (page?.pdf_ta) {
                            pageContent += `<a href="${window.location.origin}/${page.pdf_ta}" target="_blank" title="Tamil PDF"><i class="fa fa-file-pdf-o text-success"></i></a>`;
                        }
                    } else if (submenu.page_type === 'url') {
                        pageContent = `<a href="${page?.external_url || '#'}" target="_blank">External Link</a>`;
                    }

                    // Action buttons
                    let actionButtons = `<ul class="table-controls">`;

                    // Edit submenu button
                    actionButtons += `
                        <li>
                            <a href="javascript:void(0);" class="editsubMenu"
                                data-id="${submenu.id}"
                                data-menu_name_en="${submenu.menu_name_en}"
                                data-menu_name_ta="${submenu.menu_name_ta}"
                                data-page_type="${submenu.page_type}"
                                data-order_id="${submenu.order_id}"
                                data-status="${submenu.status}"
                                data-page_url="${page?.page_url || ''}"
                                data-page_url_ta="${page?.page_url_ta || ''}"
                                data-pdf_en="${page?.pdf_en ? window.location.origin + '/' + page.pdf_en : ''}"
                                data-pdf_ta="${page?.pdf_ta ? window.location.origin + '/' + page.pdf_ta : ''}"
                                data-external_url="${page?.external_url || ''}"
                                data-parent_code="${submenu.parent_code}"
                                data-bs-toggle="modal"
                                data-bs-target="#inputFormModaledit"
                                title="Edit">
                                <i class="fa fa-pencil text-primary me-2 cursor-pointer"></i>
                            </a>
                        </li>
                    `;

                    // Add edit content button if static page
                    if (submenu.page_type === 'Static Page') {
                        actionButtons += `
                            <li>
                                <a href="javascript:void(0);" class="editsubMenucontent"
                                    data-id="${submenu.id}"
                                    data-menu_name_en="${submenu.menu_name_en}"
                                    data-menu_name_ta="${submenu.menu_name_ta}"
                                    data-page_url="${page?.page_url || ''}"
                                    data-page_url_ta="${page?.page_url_ta || ''}"
                                    data-page_type="${submenu.page_type}"
                                    data-parent_code="${submenu.parent_code}"
                                    data-submenu_content_en="${page?.submenu_content_en || ''}"
                                    data-submenu_content_ta="${page?.submenu_content_ta || ''}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editsubMenucontent"
                                    title="Edit Content">
                                    <i class="fa fa-file-text-o"></i>
                                </a>
                            </li>
                        `;
                    }

                    actionButtons += `</ul>`;

                    // New row
                    const newRow = `
                        <tr data-id="${submenu.id}">
                            <td class="text-center">1</td>
                            <td>${submenu.menu_name_en}</td>
                            <td>${submenu.menu_name_ta}</td>
                            <td>${submenu.parent_code}</td>
                            <td>${submenu.order_id}</td>
                            <td><span class="badge ${badgeClass}">${statusLabel}</span></td>
                            <td>${actionButtons}</td>
                        </tr>
                    `;

                    // Prepend to table and re-index
                    $('#sortable-submenu').prepend(newRow);
                    $('#sortable-submenu tr').each(function (index) {
                        $(this).find('td:first').text(index + 1);
                    });

                    Swal.fire('Success', 'Submenu added successfully', 'success');
                } else {
                    Swal.fire('Error', 'Failed to add submenu', 'error');
                    submitBtn.prop('disabled', false).text('Add');
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON?.errors;
                $('span.error-text').text('');
                if (errors) {
                    let msg = '';
                    $.each(errors, function (key, message) {
                        msg += `${message[0]}<br>`;
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Validation Error',
                        html: msg
                    });
                }
                submitBtn.prop('disabled', false).text('Add');
            }
        });
    });

    // Toggle input fields by page_type
    $('#page_type_submenu').on('change', function () {
        const selected = $(this).val();
        $('.static-page-inputs, .pdf-inputs, .url-inputs').addClass('d-none');

        if (selected === 'Static Page') {
            $('.static-page-inputs').removeClass('d-none');
        } else if (selected === 'pdf') {
            $('.pdf-inputs').removeClass('d-none');
        } else if (selected === 'url') {
            $('.url-inputs').removeClass('d-none');
        }
    }).trigger('change');
});
// --------------------submenu edit--------------------

$(document).ready(function () {
    function toggleEditFields() {
        const selected = $('#page_type_edit').val();

        $('.static-page-inputs, .pdf-inputs, .url-inputs').addClass('d-none');

        if (selected === 'Static Page') {
            $('.static-page-inputs').removeClass('d-none');
        } else if (selected === 'pdf') {
            $('.pdf-inputs').removeClass('d-none');
        } else if (selected === 'url') {
            $('.url-inputs').removeClass('d-none');
        }
    }

    $('#page_type_edit').on('change', toggleEditFields).trigger('change');

    // Pre-fill form when editing submenu
    $(document).on('click', '.editsubMenu', function () {
        $('#submenuFormedit')[0].reset();

        const $el = $(this);

        $('#menu_id').val($el.data('id'));
        $('#page_type_edit').val($el.data('page_type')).trigger('change');
        $('input[name="menu_name_en"]').val($el.data('menu_name_en'));
        $('input[name="menu_name_ta"]').val($el.data('menu_name_ta'));
        $('select[name="parent_code"]').val($el.data('parent_code'));
        $('input[name="page_url"]').val($el.data('page_url'));
        $('input[name="page_url_ta"]').val($el.data('page_url_ta'));
        $('input[name="external_url"]').val($el.data('external_url'));
        $('input[name="order_id"]').val($el.data('order_id'));
        $('select[name="status"]').val($el.data('status'));

        // ✅ Show checkbox checked/unchecked based on footer_quicklinks_id
        if ($el.data('footer_quicklinks_id') && $el.data('footer_quicklinks_id') != 0) {
            $('#form-check-default-checked').prop('checked', true);
        } else {
            $('#form-check-default-checked').prop('checked', false);
        }

        // PDF preview
        const pdfEn = $el.data('pdf_en');
        const pdfTa = $el.data('pdf_ta');

        if (pdfEn) {
            $('#submenu_pdf_link_en').attr('href', pdfEn).removeClass('d-none');
        } else {
            $('#submenu_pdf_link_en').addClass('d-none');
        }

        if (pdfTa) {
            $('#submenu_pdf_link_ta').attr('href', pdfTa).removeClass('d-none');
        } else {
            $('#submenu_pdf_link_ta').addClass('d-none');
        }
    });
});


// -------------update submenu---------------------------

$(document).on('submit', '#submenuFormedit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    
    const menuNameEn = form.menu_name_en.value.trim();
    const menuNameTa = form.menu_name_ta.value.trim();
    const pageType   = form.page_type.value;
    const parentCode = form.parent_code.value;
    const orderId    = form.order_id.value.trim();
    const externalUrl = form.external_url?.value.trim();
    const pageUrl    = form.page_url?.value.trim();
    const pageUrlTa  = form.page_url_ta?.value.trim();
    const pdfEn      = form.pdf_en?.files[0];
    const pdfTa      = form.pdf_ta?.files[0];
    const status     = form.status.value;

    let errors = [];

    // ✅ Basic validation
    if (menuNameEn === '') errors.push('Sub Menu Name (English) is required.');
    if (menuNameTa === '') errors.push('Sub Menu Name (Tamil) is required.');
    if (pageType === '') errors.push('Page Type is required.');
    if (parentCode === '') errors.push('Parent Menu is required.');
    if (orderId === '' || isNaN(orderId)) errors.push('Order ID must be a number.');
    if (status === '') errors.push('Status is required.');

    // ✅ Page-type-based validation
    if (pageType === 'Static Page') {
        if (!pageUrl) errors.push('Page URL (English) is required for Static Page.');
        if (!pageUrlTa) errors.push('Page URL (Tamil) is required for Static Page.');
    } else if (pageType === 'url') {
        const urlPattern = /^(http:\/\/|https:\/\/)/i;
        if (!externalUrl || !urlPattern.test(externalUrl)) {
            errors.push('Valid External URL (http:// or https://) is required.');
        }
    } else if (pageType === 'pdf') {
        // PDF is optional here on edit; remove these lines if you want to make it required:
        if (!pdfEn && !$('#submenu_pdf_link_en').attr('href')) {
            errors.push('English PDF is required.');
        }
        if (!pdfTa && !$('#submenu_pdf_link_ta').attr('href')) {
            errors.push('Tamil PDF is required.');
        }
    }

    // ✅ Show errors
    if (errors.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errors.join('<br>')
        });
        return;
    }

    $.ajax({
        url: BASE_URL +  "/admin/submenus/updatesubitems",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.conflict) {
                Swal.fire({
                    title: 'Duplicate Order ID',
                    text: response.message,
                    icon: 'warning',
                    confirmButtonText: 'OK',
                });
                return;
            }

            if (response.success) {
                handleSubmenuUpdate(response.submenu); // ✅ Use 'submenu' from JSON
            }
        },
        error: function(xhr) {
            Swal.fire('Error', 'An unexpected error occurred.', 'error');
        }
    });

    function handleSubmenuUpdate(menu) {
    const row = $(`#sortable-submenu tr[data-id="${menu.id}"]`);
    if (row.length === 0) {
        console.warn("Row not found for submenu ID:", menu.id);
        return;
    }

    row.find('td:nth-child(2)').text(menu.menu_name_en || '');
    row.find('td:nth-child(3)').text(menu.menu_name_ta || '');
    row.find('td:nth-child(4)').text(menu.parent_menu_name || '—');
    row.find('td:nth-child(5)').text(menu.order_id || '');

    // ✅ Update status badge
    const badge = row.find('td:nth-child(6) .badge');
    badge.removeClass('badge-success badge-dark badge-danger');

    if (menu.status == 1) {
        badge.addClass('badge-success').text('Published');
    } else if (menu.status == 0) {
        badge.addClass('badge-dark').text('Draft');
    } else if (menu.status == 2) {
        badge.addClass('badge-danger').text('Disabled');
    }

    // ✅ Update footer quick links checkbox/text (Assuming column 8)
    row.find('td:nth-child(8)').html(menu.footer_quicklinks_id == 1
        ? '<i class="fa fa-check text-success"></i>'
        : '<i class="fa fa-times text-danger"></i>');

    // ✅ Update Action links (Static Page Link)
    const actionCell = row.find('td:nth-child(7) ul');
actionCell.find('li.static-page-link').remove();

if (menu.page_type === 'Static Page') {
    const staticLink = `
        <li class="static-page-link">
            <a href="/admin/submenuscontent/${menu.id}" title="Edit">
                <i class="fa fa-file-text-o"></i>
            </a>
        </li>
    `;
    actionCell.append(staticLink);
}

    $('#inputFormModaledit').modal('hide');
    $('#submenuFormedit')[0].reset();

    row.addClass('table-success');
    setTimeout(() => row.removeClass('table-success'), 1500);
}

    
});


// ----------------------------------------


// English Content Submit
$(document).on('submit', '#submenucontentedit_en', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: BASE_URL +  "/admin/menus/updatesubmenucontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});

// Tamil Content Submit
$(document).on('submit', '#submenucontentedit_ta', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: BASE_URL +  "/admin/menus/updatesubmenucontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});


// --------------------------------------------------------------------------------------
$(document).ready(function () {
    // Reset the form and hide fields when modal opens
    $('#inputFormModaladd').on('show.bs.modal', function () {
        const form = $('#newsboardform')[0];
        form.reset();

        $('#pdfFields').hide();
        $('#urlFields').hide();
    });

    // Show relevant fields when content_type changes
    $('#content_type_board').on('change', function () {
        const selectedType = $(this).val();

        if (selectedType === 'pdf') {
            $('#pdfFields').show();
            $('#urlFields').hide();
        } else if (selectedType === 'url') {
            $('#pdfFields').hide();
            $('#urlFields').show();
        } else {
            $('#pdfFields').hide();
            $('#urlFields').hide();
        }
    });
});

// --satrtdate-------------------------
// Set min date to today
$(document).ready(function () {
    const today = new Date().toISOString().split('T')[0];
    $('#startdate').attr('min', today);
});

// ---------------------------newsboard insert------------------------------------



$(document).on('submit', '#newsboardform', function(e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    // Cleanup fields based on content_type
   
    let errors = [];

    let subjectEn = form.subject_en.value.trim();
    let subjectTa = form.subject_ta.value.trim();
    let startDate = form.startdate.value;
    let endDate   = form.enddate.value;
    let contentType = form.content_type.value;

    let pdfEn = form.pdf_en?.files[0];
    let pdfTa = form.pdf_ta?.files[0];
    let externalUrl = form.external_url?.value.trim();

    // ✅ Basic required fields
    if (!subjectEn) errors.push('Subject (English) is required.');
    if (!subjectTa) errors.push('Subject (Tamil) is required.');
    if (!startDate) errors.push('Start Date is required.');
    if (!endDate) errors.push('End Date is required.');
    if (!contentType) errors.push('Content Type must be selected.');

    // ✅ Start Date <= End Date
    if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
        errors.push('End Date must be after or equal to Start Date.');
    }

    // ✅ Content-type based checks
    if (contentType === 'pdf') {
        if (!pdfEn) errors.push('PDF (English) is required.');
        if (!pdfTa) errors.push('PDF (Tamil) is required.');
    }

    if (contentType === 'url') {
        const urlPattern = /^(https?:\/\/)/i;
        if (!externalUrl || !urlPattern.test(externalUrl)) {
            errors.push('Valid External URL (http:// or https://) is required.');
        }
    }

    // ✅ Show error using Swal.fire if any
    if (errors.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errors.join('<br>'),
        });
        return;
    }

    // ✅ Cleanup unused fields
    if (contentType === 'Static Page') {
        formData.delete('pdf_en');
        formData.delete('pdf_ta');
        formData.delete('external_url');
    } else if (contentType === 'pdf') {
        formData.delete('external_url');
    } else if (contentType === 'url') {
        formData.delete('pdf_en');
        formData.delete('pdf_ta');
    }

    $.ajax({
        url: BASE_URL +  "/admin/newsboard/insert",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            if (response.success) {
                Swal.fire('Success', response.message, 'success');

                $('#inputFormModaladd').modal('hide');
                $('#newsboardform')[0].reset();
                $('#pdfFields, #urlFields').hide();

                const news = response.data;

                const rowCount = $('#style-3 tbody tr').length + 1;

                // Format dates as dd-mm-yyyy
                const formatDate = (dateString) => {
                    const date = new Date(dateString);
                    return date.toLocaleDateString('en-GB');
                };

                const formattedStartDate = formatDate(news.startdate);
                const formattedEndDate = formatDate(news.enddate);

                const statusLabel = (news.status == 1) ? 'Published' : (news.status == 0) ? 'Draft' : 'Disabled';
                const statusClass = (news.status == 1) ? 'badge-success' : (news.status == 0) ? 'badge-dark' : 'badge-danger';

                const newRow = `
                    <tr data-id="${news.id}">
                        <td class="checkbox-column text-center">${rowCount}</td>
                        <td>${news.subject_en}</td>
                        <td>${news.subject_ta}</td>
                        <td>${formattedStartDate}</td>
                        <td>${formattedEndDate}</td>
                        <td class="table_tdcontrol">${news.page_type}</td>
                        <td><span class="badge ${statusClass}">${statusLabel}</span></td>
                        <td class="text-center">
                            <ul class="table-controls">
                                <li>
                                    <a href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#inputFormModaleditboard"
                                       data-id="${news.id}"
                                       data-subject_en="${news.subject_en}"
                                       data-subject_ta="${news.subject_ta}"
                                       data-startdate="${news.startdate}"
                                       data-enddate="${news.enddate}"
                                       data-page_type="${news.page_type}"
                                       data-pdf_en="${news.pdf_en ?? ''}"
                                       data-pdf_ta="${news.pdf_ta ?? ''}"
                                       data-external_url="${news.external_url ?? ''}"
                                       class="bs-tooltip editboardMenucontent"
                                       title="Edit">
                                       <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                    </a>
                                </li>
                                ${news.page_type === 'Static Page' ? `
                                <li>
                                    <a href="/admin/noticeboardcontent/${news.id}"  title="Edit">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                </li>` : ''}
                            </ul>
                        </td>
                    </tr>
                `;

                $('#style-3 tbody').prepend(newRow);
            } else {
                Swal.fire('Warning', response.message, 'warning');
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});


// ---edit pass records------------------
$(document).ready(function () {
    // Show modal and populate fields with existing data
    $(document).on('click', '.editboardMenucontent', function () {
        const modal = $('#inputFormModaleditboard');

        // Fill inputs
        modal.find('#board_id').val($(this).data('id'));
        modal.find('textarea[name="subject_en"]').val($(this).data('subject_en'));
        modal.find('textarea[name="subject_ta"]').val($(this).data('subject_ta'));
        modal.find('input[name="startdate"]').val($(this).data('startdate'));
        modal.find('input[name="enddate"]').val($(this).data('enddate'));
        modal.find('#contenttype_editboard').val($(this).data('page_type')).trigger('change');

        // Populate external_url
        const external_url = $(this).data('external_url');
        modal.find('#external_url_input').val(external_url);

        // Populate existing PDF links
        const pdf_en = $(this).data('pdf_en');
        const pdf_ta = $(this).data('pdf_ta');

        if (pdf_en) {
            modal.find('#existing_pdf_en').removeClass('d-none').attr('href', pdf_en);
        } else {
            modal.find('#existing_pdf_en').addClass('d-none').attr('href', '#');
        }

        if (pdf_ta) {
            modal.find('#existing_pdf_ta').removeClass('d-none').attr('href', pdf_ta);
        } else {
            modal.find('#existing_pdf_ta').addClass('d-none').attr('href', '#');
        }
    });

    // Show relevant fields on content type change
    $('#contenttype_editboard').on('change', function () {
        const selected = $(this).val();

        if (selected === 'pdf') {
            $('#pdfFields_noticeboard').show();
            $('#urlFields_noticeboard').hide();
        } else if (selected === 'url') {
            $('#urlFields_noticeboard').show();
            $('#pdfFields_noticeboard').hide();
        } else {
            $('#pdfFields_noticeboard').hide();
            $('#urlFields_noticeboard').hide();
        }
    });

    // Reset form on modal hide
    $('#inputFormModaleditboard').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('#pdfFields_noticeboard').hide();
        $('#urlFields_noticeboard').hide();
        $('#existing_pdf_en, #existing_pdf_ta').addClass('d-none').attr('href', '#');
    });
});





// // On content_type change in edit form
// $(document).on('change', '#contenttype_editboard', function () {
//     const selectedType = $(this).val();
//     toggleEditFields(selectedType);
// });

// // Utility function to show/hide based on type
// function toggleEditFields(type) {
//     if (type === 'pdf') {
//         $('#pdfFields').show();
//         $('#urlFields').hide();
//     } else if (type === 'url') {
//         $('#urlFields').show();
//         $('#pdfFields').hide();
//     } else {
//         $('#pdfFields').hide();
//         $('#urlFields').hide();
//     }
// }

// --------------------------------

$(document).ready(function () {
    const today = new Date().toISOString().split('T')[0];
    $('[name="startdate"]').attr('min', today);
});

$(document).on('submit', '#whatsnewform', function (e) {
    e.preventDefault();
  const subject_en = $('[name="subject_en"]').val().trim();
    const subject_ta = $('[name="subject_ta"]').val().trim();
    const startdate = $('[name="startdate"]').val().trim();
    const enddate = $('[name="enddate"]').val().trim();
    const content_type = $('#content_type_board').val();
    const external_url = $('[name="external_url"]').val().trim();
    const pdf_en = $('[name="pdf_en"]')[0].files[0];
    const pdf_ta = $('[name="pdf_ta"]')[0].files[0];

    let errorMessages = [];

    // Basic required fields
    if (!subject_en) errorMessages.push("Subject (English) is required.");
    if (!subject_ta) errorMessages.push("Subject (Tamil) is required.");
    if (!startdate) errorMessages.push("Start Date is required.");
    if (!enddate) errorMessages.push("End Date is required.");
    if (!content_type) errorMessages.push("Content Type is required.");

    // Specific validation based on content type
    if (content_type === "url") {
        const urlPattern = /^(https?:\/\/)[^\s$.?#].[^\s]*$/gm;
        if (!external_url || !urlPattern.test(external_url)) {
            errorMessages.push("Please enter a valid URL starting with http:// or https://");
        }
    }

    if (content_type === "pdf") {
        if (!pdf_en && !pdf_ta) {
            errorMessages.push("Please upload at least one PDF (English or Tamil).");
        }
        if (pdf_en && pdf_en.type !== 'application/pdf') {
            errorMessages.push("English PDF must be a valid .pdf file.");
        }
        if (pdf_ta && pdf_ta.type !== 'application/pdf') {
            errorMessages.push("Tamil PDF must be a valid .pdf file.");
        }
    }

    // Show errors if any
    if (errorMessages.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errorMessages.join('<br>')
        });
        return;
    }

    // ✅ Proceed to AJAX only if no client-side error
    let formData = new FormData(this);

    // Clean up fields
    if (content_type === 'url') {
        formData.delete('pdf_en');
        formData.delete('pdf_ta');
    } else if (content_type === 'pdf') {
        formData.delete('external_url');
    }

    $.ajax({
        url: BASE_URL +  '/admin/whatsnew/insert', // Update if different
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                Swal.fire('Success', response.message, 'success');
        
                $('#whatsnewform')[0].reset();
                $('#pdfFields, #urlFields').hide();
                $('#inputFormModaladdnews').modal('hide');
        
                let news = response.data;
        
                let statusText = news.status == 1 ? 'Published' : (news.status == 0 ? 'Draft' : 'Disabled');
                let badgeClass = news.status == 1 ? 'badge-success' : (news.status == 0 ? 'badge-dark' : 'badge-danger');
        
                let newRow = `
                    <tr data-id="${news.id}">
                        <td class="checkbox-column text-center">NEW</td>
                        <td>${news.subject_en}</td>
                        <td>${news.subject_ta}</td>
                        <td>${news.startdate}</td>
                        <td>${news.enddate}</td>
                        <td class="table_tdcontrol">${news.page_type}</td>
                        <td>
                            <span class="badge ${badgeClass}">
                                ${statusText}
                            </span>
                        </td>
                        <td class="text-center">
                            <ul class="table-controls">
                                <li>
                                    <a href="javascript:void(0);"
                                        data-bs-toggle="modal"
                                        data-bs-target="#inputFormModaleditboard"
                                        data-id="${news.id}"
                                        data-subject_en="${news.subject_en}"
                                        data-subject_ta="${news.subject_ta}"
                                        data-startdate="${news.startdate}"
                                        data-enddate="${news.enddate}"
                                        data-page_type="${news.page_type}"
                                        data-pdf_en="${news.pdf_en ? '/' + news.pdf_en : ''}"
                                        data-pdf_ta="${news.pdf_ta ? '/' + news.pdf_ta : ''}"
                                        data-external_url="${news.external_url || ''}"
                                        class="bs-tooltip editboardMenucontent" title="Edit">
                                        <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                    </a>
                                </li>
                                ${news.page_type === 'Static Page' ? `
                                <li>
                                    <a href="/admin/noticeboardcontent/${news.id}" title="Edit">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                </li>` : ''}
                            </ul>
                        </td>
                    </tr>
                `;
        
                // Remove "No records found" row if exists
                $('tbody tr td[colspan="8"]').closest('tr').remove();
        
                // Append to tbody
                $('table tbody').prepend(newRow);
            } else {
                Swal.fire('Warning', response.message, 'warning');
            }
        },
        
       error: function (xhr) {
    if (xhr.status === 422) {
        // Laravel validation failed
        let errors = xhr.responseJSON.errors;
        let errorList = '';

        $.each(errors, function (key, value) {
            errorList += `• ${value[0]}<br>`;
        });

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errorList
        });
    } else {
        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
    }

    console.log(xhr.responseText); // for debugging
}

    });
});


// ---------------------------------------------------------------



// --------------toggle edit newsbaord---------------------


function toggleEditBoardFields(type, data = {}) {
    if (type === 'pdf') {
        $('#pdfFields').show();
        $('#urlFields').hide();

        // Show existing PDF links
        if (data.pdf_en) {
            $('#existing_pdf_en').removeClass('d-none').attr('href', '/' + data.pdf_en);
        } else {
            $('#existing_pdf_en').addClass('d-none');
        }

        if (data.pdf_ta) {
            $('#existing_pdf_ta').removeClass('d-none').attr('href', '/' + data.pdf_ta);
        } else {
            $('#existing_pdf_ta').addClass('d-none');
        }

    } else if (type === 'url') {
        $('#pdfFields').hide();
        $('#urlFields').show();

        $('#external_url_input').val(data.external_url || '');
    } else {
        $('#pdfFields').hide();
        $('#urlFields').hide();
    }
}

// On content type change
$('#contenttype_editboard').on('change', function () {
    let selectedType = $(this).val();
    toggleEditBoardFields(selectedType);
});

// Example: Fill form when edit button is clicked
function populateNoticeBoardEditForm(data) {
    $('#board_id').val(data.id);
    $('textarea[name="subject_en"]').val(data.subject_en);
    $('textarea[name="subject_ta"]').val(data.subject_ta);
    $('input[name="startdate"]').val(data.startdate);
    $('input[name="enddate"]').val(data.enddate);
    $('#contenttype_editboard').val(data.page_type);

    toggleEditBoardFields(data.page_type, data);
}



// ------------------------Newsboaed update ---------------------

// ------------------------Newsboaed update ---------------------
// ✅ URL validation helper
function isValidUrl(string) {
    try {
        let url = new URL(string);
        return url.protocol === "http:" || url.protocol === "https:";
    } catch (_) {
        return false;
    }
}

$('#noticeboardedit').on('submit', function (e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);
    let submitBtn = $(form).find('button[type="submit"]');
    let valid = true;
    let errorMessage = '';

    // Basic validation
    const subject_en = form.subject_en.value.trim();
    const subject_ta = form.subject_ta.value.trim();
    const startdate = form.startdate.value;
    const enddate = form.enddate.value;
    const pageType = form.content_type.value;
    const url = form.external_url?.value.trim();

    const pdfEn = form.pdf_en?.value.trim();   // ✅ English PDF input
const pdfTa = form.pdf_ta?.value.trim();   // ✅ Tamil PDF input

    if (!subject_en) {
        errorMessage = 'Please enter Subject (English).';
        valid = false;
    } else if (!subject_ta) {
        errorMessage = 'Please enter Subject (Tamil).';
        valid = false;
    } else if (!startdate) {
        errorMessage = 'Please select Start Date.';
        valid = false;
    } else if (!enddate) {
        errorMessage = 'Please select End Date.';
        valid = false;
    } else if (startdate > enddate) {
        errorMessage = 'End Date must be after or equal to Start Date.';
        valid = false;
    } else if (!pageType) {
        errorMessage = 'Please select Content Type.';
        valid = false;
    } else if (pageType === 'url' && (!url || !isValidUrl(url))) {
        errorMessage = 'Please enter a valid URL starting with http or https.';
        valid = false;
    }else if (pageType === 'pdf' && (!pdfEn || !pdfTa)) {
    errorMessage = 'Please upload both English and Tamil PDF files.';
    valid = false;
}

    if (!valid) {
        Swal.fire('Validation Error', errorMessage, 'warning');
        return;
    }

    submitBtn.prop('disabled', true).text('Saving...');

    $.ajax({
        url: BASE_URL + "/admin/newsboard/updateboard",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const news = response.data;

                const pageType = news.page_type;
                const statusBadge = news.status == 1 ? 'badge-success' :
                                    (news.status == 0 ? 'badge-dark' :
                                    (news.status == 2 ? 'badge-danger' : ''));

                const statusText = news.status == 1 ? 'Published' :
                                   (news.status == 0 ? 'Draft' :
                                   (news.status == 2 ? 'Disabled' : ''));

                let newRow = `
                    <td class="checkbox-column text-center">#</td>
                    <td class="table_tdcontrol">${breakTextByWords(news.subject_en)}</td>
                    <td class="table_tdcontrol">${breakTextByWords(news.subject_ta)}</td>
                    <td>${formatDate(news.startdate)}</td>
                    <td>${formatDate(news.enddate)}</td>
                    <td class="table_tdcontrol">${breakTextByWords(pageType)}</td>
                    <td><span class="badge ${statusBadge}">${statusText}</span></td>
                    <td class="text-center">
                        <ul class="table-controls">
                            <li>
                                <a href="javascript:void(0);"
                                   data-bs-toggle="modal"
                                   data-bs-target="#inputFormModaleditboard"
                                   data-id="${news.id}"
                                   data-subject_en="${news.subject_en}"
                                   data-subject_ta="${news.subject_ta}"
                                   data-startdate="${news.startdate}"
                                   data-enddate="${news.enddate}"
                                   data-page_type="${news.page_type}"
                                   data-pdf_en="${news.pdf_en ? '/' + news.pdf_en : ''}"
                                   data-pdf_ta="${news.pdf_ta ? '/' + news.pdf_ta : ''}"
                                   data-external_url="${news.external_url || ''}"
                                   class="bs-tooltip editboardMenucontent" title="Edit">
                                    <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                </a>
                            </li>
                            ${news.page_type === 'Static Page' ? `
                            <li><a href="/admin/noticeboardcontent/${news.id}" title="Edit">
                                <i class="fa fa-file-text-o"></i></a></li>` : ''}
                        </ul>
                    </td>
                `;

                // Update the row in table
                const row = $(`tr[data-id="${news.id}"]`);
                row.html(newRow);

                // Reset and close modal
                form.reset();
                let modal = bootstrap.Modal.getInstance(document.getElementById('inputFormModaleditboard'));
                modal.hide();

                Swal.fire('Success', response.message, 'success');
            } else {
                Swal.fire('Error', 'Update failed', 'error');
            }
            submitBtn.prop('disabled', false).text('Update');
        },
        error: function () {
            submitBtn.prop('disabled', false).text('Update');
            Swal.fire('Error', 'Fill the Fields Properly', 'error');
        }
    });
});


function breakTextByWords(text, wordsPerLine = 6) {
    if (!text) return '';
    let words = text.split(/\s+/);
    let lines = [];
    for (let i = 0; i < words.length; i += wordsPerLine) {
        lines.push(words.slice(i, i + wordsPerLine).join(" "));
    }
    return lines.join("<br>");
}



// Format date to dd-mm-yyyy
function formatDate(dateStr) {
    const date = new Date(dateStr);
    return ('0' + date.getDate()).slice(-2) + '-' +
           ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
           date.getFullYear();
}



// -----------------------------------------------
// 🔁 Function to update row in table
function updateRow(news) {
    let row = $('#news_row_' + news.id);

    row.find('.subject_en').text(news.subject_en);
    row.find('.subject_ta').text(news.subject_ta);
    row.find('.startdate').text(formatDate(news.startdate));
    row.find('.enddate').text(formatDate(news.enddate));
    row.find('.page_type').text(news.page_type);

    // Update data attributes for edit button (optional)
    let editBtn = row.find('.editNewsBtn');
    editBtn.data('subject_en', news.subject_en);
    editBtn.data('subject_ta', news.subject_ta);
    editBtn.data('startdate', news.startdate);
    editBtn.data('enddate', news.enddate);
    editBtn.data('page_type', news.page_type);
    editBtn.data('external_url', news.external_url);
}

function formatDate(dateStr) {
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-GB'); // DD-MM-YYYY
}


// ----------------------------------------------------------------------



$(document).ready(function () {
    // For any modal with class `.reset-on-open`, reset the form inside it on open
    $('.reset-on-open').on('show.bs.modal', function () {
        const form = $(this).find('form')[0];
        if (form) {
            form.reset(); // Reset standard fields

            // Optionally clear file inputs, hidden fields, etc.
            $(form).find('input[type="file"]').val('');
            $(form).find('input[type="hidden"]').not('[name="_token"]').val('');
            // $(form).find('textarea').val('');
            $(form).find('select').val('');

            // Hide conditional fields
            $(form).find('#pdfFields, #urlFields').hide();
        }
    });
});

// ------------------------Board Content Edit--------------------
// --------------------edit pass whatsnews records-------------------

$(document).ready(function () {
    // Show modal and populate fields with existing data
    $(document).on('click', '.editscrollMenucontent', function () {
        const modal = $('#inputFormModaleditboard');

        // Fill inputs
        modal.find('#whatsnew_id').val($(this).data('id'));
        modal.find('textarea[name="subject_en"]').val($(this).data('subject_en'));
        modal.find('textarea[name="subject_ta"]').val($(this).data('subject_ta'));
        modal.find('input[name="startdate"]').val($(this).data('startdate'));
        modal.find('input[name="enddate"]').val($(this).data('enddate'));
        modal.find('#contenttype_editboard').val($(this).data('page_type')).trigger('change');

        // Populate external_url
        const external_url = $(this).data('external_url');
        modal.find('#external_url_input').val(external_url);

        // Populate existing PDF links
        const pdf_en = $(this).data('pdf_en');
        const pdf_ta = $(this).data('pdf_ta');

        if (pdf_en) {
            modal.find('#existing_pdf_en').removeClass('d-none').attr('href', pdf_en);
        } else {
            modal.find('#existing_pdf_en').addClass('d-none').attr('href', '#');
        }

        if (pdf_ta) {
            modal.find('#existing_pdf_ta').removeClass('d-none').attr('href', pdf_ta);
        } else {
            modal.find('#existing_pdf_ta').addClass('d-none').attr('href', '#');
        }
    });

    // Show relevant fields on content type change
    $('#contenttype_editboard').on('change', function () {
        const selected = $(this).val();

        if (selected === 'pdf') {
            $('#pdfFields_noticeboard').show();
            $('#urlFields_noticeboard').hide();
        } else if (selected === 'url') {
            $('#urlFields_noticeboard').show();
            $('#pdfFields_noticeboard').hide();
        } else {
            $('#pdfFields_noticeboard').hide();
            $('#urlFields_noticeboard').hide();
        }
    });

    // Reset form on modal hide
    $('#inputFormModaleditboard').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('#pdfFields_noticeboard').hide();
        $('#urlFields_noticeboard').hide();
        $('#existing_pdf_en, #existing_pdf_ta').addClass('d-none').attr('href', '#');
    });
});


// ----------------------------------------------------



// ------------------------Newsboaed update ---------------------

$('#scrollboardedit').on('submit', function (e) {
    // alert('scroll update');
    e.preventDefault();

     let form = this;
    let formData = new FormData(form);
    let contentType = $('#contenttype_editboard').val();
    let errors = [];

    const subject_en = form.subject_en.value.trim();
    const subject_ta = form.subject_ta.value.trim();
    const startdate = form.startdate.value;
    const enddate = form.enddate.value;
    const external_url = form.external_url?.value.trim() || '';
    const pdf_en = form.pdf_en?.files[0];
    const pdf_ta = form.pdf_ta?.files[0];

    // Basic checks
    if (!startdate) errors.push("Start Date is required.");
    if (!enddate) errors.push("End Date is required.");
    if (!contentType) errors.push("Content Type is required.");

    // URL validation
    if (contentType === "url") {
        const urlRegex = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;
        if (!external_url || !urlRegex.test(external_url)) {
            errors.push("Please enter a valid URL starting with http:// or https://");
        }
    }

    // PDF validation
    if (contentType === "pdf") {
        if (!pdf_en && !pdf_ta) {
            errors.push("At least one PDF (English or Tamil) is required.");
        }
        if (pdf_en && pdf_en.type !== "application/pdf") {
            errors.push("English PDF must be a valid PDF file.");
        }
        if (pdf_ta && pdf_ta.type !== "application/pdf") {
            errors.push("Tamil PDF must be a valid PDF file.");
        }
    }

    // Show errors
    if (errors.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errors.join('<br>')
        });
        return;
    }

    // 🟢 Proceed to AJAX if validation passes
    let submitBtn = $(form).find('button[type="submit"]');
    submitBtn.prop('disabled', true).text('Saving...');

    $.ajax({
        url:  BASE_URL + "/admin/whatsnew/updatescrollboard", // adjust route accordingly
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const news = response.data;

                const pageType = news.page_type;
                const statusBadge = news.status == 1 ? 'badge-success' :
                                    (news.status == 0 ? 'badge-dark' :
                                    (news.status == 2 ? 'badge-danger' : ''));

                const statusText = news.status == 1 ? 'Published' :
                                   (news.status == 0 ? 'Draft' :
                                   (news.status == 2 ? 'Disabled' : ''));

                let newRow = `
                    <td class="checkbox-column text-center">#</td>
                   <td>${wordWrap(news.subject_en, 20)}</td>
                     <td>${wordWrap(news.subject_ta, 20)}</td>
                    <td>${formatDate(news.startdate)}</td>
                    <td>${formatDate(news.enddate)}</td>
                    <td class="table_tdcontrol">${pageType}</td>
                    <td><span class="badge ${statusBadge}">${statusText}</span></td>
                    <td class="text-center">
                        <ul class="table-controls">
                            <li>
                                <a href="javascript:void(0);"
                                   data-bs-toggle="modal"
                                   data-bs-target="#inputFormModaleditboard"
                                   data-id="${news.id}"
                                   data-subject_en="${news.subject_en}"
                                   data-subject_ta="${news.subject_ta}"
                                   data-startdate="${news.startdate}"
                                   data-enddate="${news.enddate}"
                                   data-page_type="${news.page_type}"
                                   data-pdf_en="${news.pdf_en ? '/' + news.pdf_en : ''}"
                                   data-pdf_ta="${news.pdf_ta ? '/' + news.pdf_ta : ''}"
                                   data-external_url="${news.external_url || ''}"
                                   class="bs-tooltip editboardMenucontent" title="Edit">
                                    <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                </a>
                            </li>
                            ${news.page_type === 'Static Page' ? `
                                <li><a href="/admin/noticeboardcontent/${news.id}"  title="Edit">
                                    <i class="fa fa-file-text-o"></i></a></li>` : ''}
                        </ul>
                    </td>
                `;

                // Update the row in table
                const row = $(`tr[data-id="${news.id}"]`);
                row.html(newRow);

                // Reset and close modal
                form.reset();
                let modal = bootstrap.Modal.getInstance(document.getElementById('inputFormModaleditboard'));
                modal.hide();

                Swal.fire('Success', response.message, 'success');
            } else {
                Swal.fire('Error', 'Update failed', 'error');
            }
            submitBtn.prop('disabled', false).text('Update');
        },
          error: function (xhr) {
            submitBtn.prop('disabled', false).text('Update');

            if (xhr.status === 422) {
                let errorList = '';
                $.each(xhr.responseJSON.errors, function (key, value) {
                    errorList += `• ${value[0]}<br>`;
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Server Validation Error',
                    html: errorList
                });
            } else {
                Swal.fire('Error', 'Something went wrong. Try again.', 'error');
            }
        }
    });
});


function wordWrap(str, maxWidth) {
    if (!str) return "";
    let newLineStr = "<br>";
    let result = "";
    while (str.length > maxWidth) {
        let found = false;
        // break line at last space within maxWidth
        for (let i = maxWidth; i >= 0; i--) {
            if (str.charAt(i).match(/\s/)) {
                result += str.slice(0, i) + newLineStr;
                str = str.slice(i + 1);
                found = true;
                break;
            }
        }
        // if no space found, force break
        if (!found) {
            result += str.slice(0, maxWidth) + newLineStr;
            str = str.slice(maxWidth);
        }
    }
    return result + str;
}
// Format date to dd-mm-yyyy
function formatDate(dateStr) {
    const date = new Date(dateStr);
    return ('0' + date.getDate()).slice(-2) + '-' +
           ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
           date.getFullYear();
}


// ------------------------------newsboardcontent update------------------


$(document).ready(function () {
    // English
    $('#newsboardcontent_en').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL +  "/admin/newsboard/updateNewsBoardContent",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.success) {
                    Swal.fire("Updated!", res.message, "success");
                } else {
                    Swal.fire("Error!", "Update failed", "error");
                }
            },
            error: function () {
                Swal.fire("Error!", "Something went wrong", "error");
            }
        });
    });

    // Tamil
    $('#newsboardcontent_ta').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL +  "/admin/newsboard/updateNewsBoardContent",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.success) {
                    Swal.fire("Updated!", res.message, "success");
                } else {
                    Swal.fire("Error!", "Update failed", "error");
                }
            },
            error: function () {
                Swal.fire("Error!", "Something went wrong", "error");
            }
        });
    });
});

// ---------------------------------------
$(document).ready(function () {
    const today = new Date().toISOString().split('T')[0];
    // $('#freshamount_starts, #renewalamount_starts, #latefee_starts').attr('min', today);

    $('#newFormMaster').on('submit', function (e) {
        e.preventDefault();

        const form_name = $('#form_name').val().trim();
        const license_name = $('#license_name').val().trim();
        const fresh_amount = $('#fresh_amount').val().trim();
        const freshamount_starts = $('#freshamount_starts').val();
        const renewal_amount = $('#renewal_amount').val().trim();
        const renewalamount_starts = $('#renewalamount_starts').val();
        const latefee_amount = $('#latefee').val().trim();
        const latefee_starts = $('#latefee_starts').val();
        const duration_freshfee = $('#duration_freshfee').val().trim();
        const duration_renewalfee = $('#duration_renewalfee').val().trim();
        const duration_latefee = $('#duration_latefee').val().trim();
        const status = $('select[name="status"]').val();

        // ✅ Required field validation (excluding *_ends)
        if (!form_name || !license_name || !fresh_amount || !freshamount_starts ||
            !renewal_amount || !renewalamount_starts || !latefee_amount || !latefee_starts ||
            !duration_freshfee || !duration_renewalfee || !duration_latefee || !status) {
            return Swal.fire("Required", "Please fill all required fields marked with *", "warning");
        }

        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL +  "/admin/forms/newforminsert",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                Swal.fire("Success", "Form added successfully!", "success").then(() => {
                    $('#inputFormModaladdforms').modal('hide');
                    $('#newFormMaster')[0].reset();
                    appendFormRow(response.form);
                });
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errorMsg = '<ul class="text-start">';
                    $.each(xhr.responseJSON.errors, function (field, message) {
                        errorMsg += `<li>${message[0]}</li>`;
                    });
                    errorMsg += '</ul>';
                    Swal.fire({ icon: 'error', title: 'Validation Error', html: errorMsg });
                } else {
                    Swal.fire("Error", "Something went wrong. Try again.", "error");
                }
            }
        });
    });

    function appendFormRow(form) {
        let statusClass = form.status == '1' ? 'badge-success' :
                          form.status == '0' ? 'badge-dark' : 'badge-danger';
        let statusText = form.status == '1' ? 'Active' : 'Inactive';

        let row = `
        <tr data-id="${form.id}">
            <td>${form.form_name}</td>
            <td>${form.license_name}</td>
            <td>${form.fresh_amount}</td>
            <td>${form.freshamount_starts} to <br>${form.freshamount_ends ?? '--'}<br>[ ${form.freshamount_starts && form.freshamount_ends ? moment(form.freshamount_ends).diff(moment(form.freshamount_starts), 'days') : '--'} days ]</td>
            <td>${form.renewal_amount}</td>
            <td>${form.renewalamount_starts} to <br>${form.renewalamount_ends ?? '--'}<br>[ ${form.renewalamount_starts && form.renewalamount_ends ? moment(form.renewalamount_ends).diff(moment(form.renewalamount_starts), 'days') : '--'} days ]</td>
            <td>${form.latefee_amount}</td>
            <td>${form.latefee_starts} to <br>${form.latefee_ends ?? '--'}<br>[ ${form.latefee_starts && form.latefee_ends ? moment(form.latefee_ends).diff(moment(form.latefee_starts), 'days') : '--'} days ]</td>
            <td>${form.duration_freshfee || '--'}</td>
            <td>${form.duration_renewalfee || '--'}</td>
            <td>${form.duration_latefee || '--'}</td>
            <td><span class="badge ${statusClass}">${statusText}</span></td>
            <td>
                <ul class="table-controls">
                    <li>
                        <a href="javascript:void(0);" class="editformdata" data-id="${form.id}" data-form_name="${form.form_name}" data-license_name="${form.license_name}" data-fresh_amount="${form.fresh_amount}" data-renewal_amount="${form.renewal_amount}" data-freshamount_starts="${form.freshamount_starts}" data-freshamount_ends="${form.freshamount_ends}" data-renewalamount_starts="${form.renewalamount_starts}" data-renewalamount_ends="${form.renewalamount_ends}" data-latefee_amount="${form.latefee_amount}" data-latefee_starts="${form.latefee_starts}" data-latefee_ends="${form.latefee_ends}" data-status="${form.status}" data-bs-toggle="modal" data-bs-target="#inputFormModaleditforms">
                            <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                        </a>
                        <a href="/admin/forms/instructions/${form.id}">
                            <i class="fa fa-book"></i>
                        </a>
                    </li>
                </ul>
            </td>
        </tr>`;

        $('#formtable').prepend(row);
    }
});




// -------------------formtbl----------------------

// Handle Edit Button Click
$(document).on('click', '.editformdata', function () {
    // Get data attributes from clicked element
    let form_id = $(this).data('id');
    let form_name = $(this).data('form_name');
    let license_name = $(this).data('license_name');

    // (I think you meant separate period fields here – right now you are reusing license_name)
    let fresh_period = $(this).data('fresh_period');
    // alert(fresh_period);
    let renewal_period = $(this).data('renewal_period');

    let fresh_amount = $(this).data('fresh_amount');
    let renewal_amount = $(this).data('renewal_amount');
    let instructions = $(this).data('instructions');
    let status = $(this).data('status');

    // Handle dates (strip time part if exists)
    let freshamount_starts = $(this).data('freshamount_starts') ? $(this).data('freshamount_starts').toString().split(" ")[0] : "";
    let freshamount_ends = $(this).data('freshamount_ends') ? $(this).data('freshamount_ends').toString().split(" ")[0] : "";
    let renewalamount_starts = $(this).data('renewalamount_starts') ? $(this).data('renewalamount_starts').toString().split(" ")[0] : "";
    let renewalamount_ends = $(this).data('renewalamount_ends') ? $(this).data('renewalamount_ends').toString().split(" ")[0] : "";
    let latefee_starts = $(this).data('latefee_starts') ? $(this).data('latefee_starts').toString().split(" ")[0] : "";
    let latefee_ends = $(this).data('latefee_ends') ? $(this).data('latefee_ends').toString().split(" ")[0] : "";

    let latefee_amount = $(this).data('latefee_amount');
    let duration_freshfee = $(this).data('duration_freshfee');
    let duration_renewalfee = $(this).data('duration_renewalfee');
    let duration_latefee = $(this).data('duration_latefee');

    // Set values into modal form fields
    $('#form_id').val(form_id);
    $('#editformstbls input[name="form_name"]').val(form_name);
    $('#editformstbls input[name="license_name"]').val(license_name);

    $('#editformstbls input[name="fresh_period"]').val(fresh_period);
    $('#editformstbls input[name="renewal_period"]').val(renewal_period);

    $('#editformstbls input[name="fresh_amount"]').val(fresh_amount);
    $('#editformstbls input[name="renewal_amount"]').val(renewal_amount);
    $('#editformstbls textarea[name="instructions"]').val(instructions);
    $('#editformstbls select[name="status"]').val(status);

    // Dates (in yyyy-mm-dd so <input type="date"> accepts them)
    $('#editformstbls input[name="freshamount_starts"]').val(freshamount_starts);
    $('#editformstbls input[name="freshamount_ends"]').val(freshamount_ends);
    $('#editformstbls input[name="renewalamount_starts"]').val(renewalamount_starts);
    $('#editformstbls input[name="renewalamount_ends"]').val(renewalamount_ends);
    $('#editformstbls input[name="latefee_starts"]').val(latefee_starts);
    $('#editformstbls input[name="latefee_ends"]').val(latefee_ends);

    $('#editformstbls input[name="latefee_amount"]').val(latefee_amount);
    $('#editformstbls input[name="duration_freshfee"]').val(duration_freshfee);
    $('#editformstbls input[name="duration_renewalfee"]').val(duration_renewalfee);
    $('#editformstbls input[name="duration_latefee"]').val(duration_latefee);
});



// ------------------------------------------------


$(document).ready(function () {
    // English
    $('#forminstructions').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL +  "/admin/formcontent/updateforminstructions",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.success) {
                    Swal.fire("Updated!", res.message, "success");
                } else {
                    Swal.fire("Error!", "Update failed", "error");
                }
            },
            error: function () {
                Swal.fire("Error!", "Something went wrong", "error");
            }
        });
    });

 
});

// -------------------------------------Edit form Details---------------------


$(document).on("submit", "#editformstbls", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    // Frontend Date Validation
    const dates = {
        fresh_start: $('#freshamount_starts').val(),
        fresh_end: $('#freshamount_ends').val(),
        renewal_start: $('#renewalamount_starts').val(),
        renewal_end: $('#renewalamount_ends').val(),
        late_start: $('#latefee_starts').val(),
        late_end: $('#latefee_ends').val()
    };

    if (dates.fresh_end < dates.fresh_start) {
        return Swal.fire('Invalid', 'Fresh License End Date must be after Start Date.', 'error');
    }
    if (dates.renewal_end < dates.renewal_start) {
        return Swal.fire('Invalid', 'Renewal End Date must be after Start Date.', 'error');
    }
    if (dates.late_end < dates.late_start) {
        return Swal.fire('Invalid', 'Late Fee End Date must be after Start Date.', 'error');
    }

    $.ajax({
        url: BASE_URL +  '/admin/forms/updateform',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            Swal.fire("Success", "Form updated successfully", "success").then(() => {
                  location.reload();
                // $('#inputFormModaleditforms').modal('hide');

                // Remove old row and add new
                // $('tr[data-id="' + $('input[name="id"]').val() + '"]').remove();
                // $('#formtable').prepend(generateRowHTML(response.form));
            });
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                if (xhr.responseJSON.message) {
                    // Show custom start date error
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: xhr.responseJSON.message
                    });
                } else if (xhr.responseJSON.errors) {
                    // Show normal Laravel validation errors
                    let errorMsg = '<ul class="text-start">';
                    $.each(xhr.responseJSON.errors, function (field, message) {
                        errorMsg += `<li>${message[0]}</li>`;
                    });
                    errorMsg += '</ul>';
                    Swal.fire({ icon: 'error', title: 'Validation Error', html: errorMsg });
                }
            } else {
                Swal.fire("Error", "Something went wrong. Try again.", "error");
            }
        }
    });
});
function generateRowHTML(form) {
    return `
        <tr data-id="${form.id}">
            <td>${form.form_name}</td>
            <td>${form.license_name}</td>
            <td>${form.fresh_amount}</td>
            <td>${form.freshamount_starts} </td>
            <td>${form.renewal_amount}</td>
            <td>${form.renewalamount_starts} </td>
            <td>${form.latefee_amount}</td>
            <td>${form.latefee_starts} </td>
            <td>${form.duration_freshfee ?? '--'}</td>
            <td>${form.duration_renewalfee ?? '--'}</td>
            <td>${form.duration_latefee ?? '--'}</td>
            <td>
                <span class="badge ${form.status == 1 ? 'badge-success' : (form.status == 0 ? 'badge-dark' : 'badge-danger')}">
                    ${form.status == 1 ? 'Active' : (form.status == 0 ? 'Inactive' : 'Disabled')}
                </span>
            </td>
            <td>
                <ul class="table-controls">
                     <ul class="table-controls">
                    <li>
                        <a href="javascript:void(0);" class="editformdata"
                            data-id="${form.id}"
                            data-form_name="${form.form_name}"
                            data-license_name="${form.license_name}"
                            data-fresh_amount="${form.fresh_amount}"
                            data-renewal_amount="${form.renewal_amount}"
                            data-instructions="${form.instructions ?? ''}"
                            data-freshamount_starts="${form.freshamount_starts}"
                            data-freshamount_ends="${form.freshamount_ends ?? ''}"
                            data-renewalamount_starts="${form.renewalamount_starts}"
                            data-renewalamount_ends="${form.renewalamount_ends ?? ''}"
                            data-latefee_amount="${form.latefee_amount}"
                            data-latefee_starts="${form.latefee_starts}"
                            data-latefee_ends="${form.latefee_ends ?? ''}"
                            data-duration_freshfee="${form.duration_freshfee ?? ''}"
                            data-duration_renewalfee="${form.duration_renewalfee ?? ''}"
                            data-duration_latefee="${form.duration_latefee ?? ''}"
                            data-status="${form.status}"
                            data-bs-toggle="modal" data-bs-target="#inputFormModaleditforms">
                            <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/form_instructions/${form.id}">
                            <i class="fa fa-book"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/form_history/${form.old_id ?? form.id}">
                            <i class="fa fa-history"></i>
                        </a>
                    </li>
                </ul>
            </td>
        </tr>
    `;
}



// -----------staff Add---------------------

$(document).ready(function () {
    $("#newstaffmaster").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL +  "/admin/staff/insertstaff",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                Swal.fire("Success", response.message, "success").then(() => {
                    let staff = response.staff;
                    let formNames = response.form_names.join(', ');
                    let statusText = '';
                    let statusClass = '';
            
                    if (staff.status == '1') {
                        statusText = 'Published';
                        statusClass = 'badge-success';
                    } else if (staff.status == '0') {
                        statusText = 'Draft';
                        statusClass = 'badge-dark';
                    } else if (staff.status == '2') {
                        statusText = 'Disabled';
                        statusClass = 'badge-danger';
                    }
            
                    let newRow = `
                        <tr data-id="${staff.id}">
                            <td class="text-center">New</td>
                            <td>${staff.name}</td>
                            <td>${staff.email}</td>
                            <td>${staff.staff_name}</td>
                            <td>${formNames}</td>
                            <td><span class="badge ${statusClass}">${statusText}</span></td>
                            <td>
                                <ul class="table-controls">
                                    <li>
                                        <a href="javascript:void(0);" class="editformdata"
                                            data-id="${staff.id}"
                                            data-form_name=""
                                            data-license_name=""
                                            data-fresh_amount=""
                                            data-renewal_amount=""
                                            data-instructions=""
                                            data-status="${staff.status}"
                                            data-bs-toggle="modal" data-bs-target="#inputFormModaleditstaffs">
                                            <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    `;
            
                    $('#formtable').append(newRow);
                    $('#newstaffmaster')[0].reset(); // Optional: reset form
                    $('#newstaffModal').modal('hide'); // Hide modal if used
                });
            },
            
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let messages = '';
            
                    // Map field names to readable labels
                    const fieldNames = {
                        name: 'Designation Name',
                        email: 'Email',
                        staff_name: 'Staff Name',
                        handle_forms: 'Handling Forms',
                        status: 'Status'
                    };
            
                    Object.keys(errors).forEach(function (key) {
                        let label = fieldNames[key] || key;
                        messages += `<strong>${label}:</strong> ${errors[key][0]}<br>`;
                    });
            
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: messages
                    });
                } else {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            }
            
            
        });
    });
});

// -------------------------edit
$(document).on('click', '.editstaffdata', function () {
    let staff_id = $(this).data('id');
    let staff_name = $(this).data('staff_name');
    let name = $(this).data('name');
    let email = $(this).data('email');
    let handle_forms = $(this).data('handle_forms'); // This is JSON string or array
    let status = $(this).data('status');

    // Set values
    $('#editstaffstbls input[name="id"]').val(staff_id);
    $('#editstaffstbls input[name="staff_name"]').val(staff_name);
    $('#editstaffstbls input[name="name"]').val(name);
    $('#editstaffstbls input[name="email"]').val(email);
    $('#editstaffstbls select[name="status"]').val(status);

    // Reset all checkboxes first
    $('#editstaffstbls input[name="handle_forms[]"]').prop('checked', false);

    try {
        let formsArray = typeof handle_forms === 'string' ? JSON.parse(handle_forms) : handle_forms;

        if (Array.isArray(formsArray)) {
            formsArray.forEach(function (formId) {
                $('#handle_forms_' + formId).prop('checked', true);
            });
        }
    } catch (e) {
        console.error("Invalid handle_forms data", e);
    }
});

// --------------------update staff----------------------------


$(document).ready(function () {
    $("#editstaffstbls").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL +  "/admin/staff/updatestaff",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                Swal.fire("Success", response.message, "success").then(() => {
                    let staff = response.staff;
                    let formNames = response.form_names.join(', ');
                    let statusText = '';
                    let statusClass = '';
            
                    if (staff.status == '1') {
                        statusText = 'Published';
                        statusClass = 'badge-success';
                    } else if (staff.status == '0') {
                        statusText = 'Draft';
                        statusClass = 'badge-dark';
                    } else if (staff.status == '2') {
                        statusText = 'Disabled';
                        statusClass = 'badge-danger';
                    }
            
                    let updatedRow = `
                        <td class="text-center">-</td>
                        <td>${staff.name}</td>
                        <td>${staff.email}</td>
                        <td>${staff.staff_name}</td>
                        <td>${formNames}</td>
                        <td><span class="badge ${statusClass}">${statusText}</span></td>
                        <td>
                            <ul class="table-controls">
                                <li>
                                    <a href="javascript:void(0);" class="editstaffdata"
                                        data-id="${staff.id}"
                                        data-name="${staff.name}"
                                        data-email="${staff.email}"
                                        data-staff_name="${staff.staff_name}"
                                        data-handle_forms='${JSON.stringify(staff.handle_forms)}'
                                        data-status="${staff.status}"
                                        data-bs-toggle="modal" data-bs-target="#inputFormModaleditstaffs">
                                        <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    `;
            
                    // Replace the row content based on staff ID
                    $(`#formtable tr[data-id="${staff.id}"]`).html(updatedRow);
            
                    // Optional: reset form and close modal
                    $('#editstaffstbls')[0].reset();
                    $('#inputFormModaleditstaffs').modal('hide');
                });
            },
            
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let messages = '';
                    Object.keys(errors).forEach(function (key) {
                        messages += errors[key][0] + '<br>';
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: messages
                    });
                } else {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            }
        });
    });
});


// -------------contact Details----------------

$(document).ready(function () {
    $('#contactdetailsupdate').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL +  '/admin/contact/updatecontact', // change URL if needed
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.fire("Success", response.message, "success");
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let message = '';
                    Object.values(errors).forEach(err => {
                        message += err[0] + '<br>';
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: message
                    });
                } else {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            }
        });
    });
});

// -----------------------------------------------------------------------

$(document).ready(function () {

    // Submit Add Menu Form
    $('#quicklinksForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let submitBtn = $('#quicklinksForm button[type="submit"]');
        submitBtn.prop('disabled', true).text('Saving...');

          // Get page type to validate conditionally
    const pageType = $('select[name="page_type"]').val();
    const externalUrl = $('input[name="external_url"]').val();

    if (pageType === 'url') {
        // Regex to check if URL starts with http:// or https://
        const urlPattern = /^(http:\/\/|https:\/\/).+/i;
        if (!urlPattern.test(externalUrl)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid URL',
                text: 'Please enter a valid URL starting with http:// or https://'
            });
            submitBtn.prop('disabled', false).text('Add');
            return;
        }
    }

        $.ajax({
            url: BASE_URL +  "/admin/quicklinks/insertquicklinks",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
         success: function (response) {
                if (response.success && response.data) {
                    const menu = response.data;
                    const page = menu.menu_page;

                    $('#quicklinksForm')[0].reset();
                    let modal = bootstrap.Modal.getInstance(document.getElementById('inputFormModaladd'));
                    if (modal) modal.hide();
                    submitBtn.prop('disabled', false).text('Add');

                    let pageTypeContent = '—';
                    if (menu.page_type === 'Static Page') {
                        pageTypeContent = page?.page_url || '';
                    } else if (menu.page_type === 'pdf') {
                        pageTypeContent = '';
                        if (page?.pdf_en) {
                            pageTypeContent += `<a href="${window.location.origin}/${page.pdf_en}" target="_blank" class="me-2" title="English PDF"><i class="fa fa-file-pdf-o text-danger"></i></a>`;
                        }
                        if (page?.pdf_ta) {
                            pageTypeContent += `<a href="${window.location.origin}/${page.pdf_ta}" target="_blank" title="Tamil PDF"><i class="fa fa-file-pdf-o text-success"></i></a>`;
                        }
                    } else if (menu.page_type === 'url') {
                        pageTypeContent = `<a href="${page?.external_url || '#'}" target="_blank">External Link</a>`;
                    }

                    let statusLabel = '', badgeClass = '';
                    if (menu.status == 1) {
                        statusLabel = 'Published'; badgeClass = 'badge-success';
                    } else if (menu.status == 0) {
                        statusLabel = 'Draft'; badgeClass = 'badge-dark';
                    } else if (menu.status == 2) {
                        statusLabel = 'Disabled'; badgeClass = 'badge-danger';
                    }

                    let staticPageLink = '';
                    if (menu.page_type === 'Static Page') {
                        staticPageLink = `<li><a href="/admin/quicklinkscontent/${menu.id}"  title="Edit Content"><i class="fa fa-file-text-o"></i></a></li>`;
                    }

                    const newRow = `
                        <tr data-id="${menu.id}">
                            <td class="text-center">0</td>
                            <td>${menu.footer_menu_en}</td>
                            <td>${menu.footer_menu_ta}</td>
                            <td class="text-capitalize">${menu.page_type}</td>
                            <td class="external-url">${pageTypeContent}</td>
                            <td>
                                ${
                                    menu.menu_id
                                        ? 'Main Menu'
                                        : menu.submenu_id
                                            ? 'Sub Menu'
                                            : '--'
                                }
                            </td>
                            <td>${menu.order_id}</td>
                            <td>
                                <span class="badge ${badgeClass}">${statusLabel}</span>
                            </td>
                            <td>
                                ${
                                    menu.menu_id || menu.submenu_id
                                        ? 'Edit Not <br>Allowed'
                                        : `
                                        <ul class="table-controls">
                                            <li>
                                                <a href="javascript:void(0);" class="editquicklinks"
                                                    data-id="${menu.id}"
                                                    data-footer_menu_en="${menu.footer_menu_en}"
                                                    data-footer_menu_ta="${menu.footer_menu_ta}"
                                                    data-page_url="${page?.page_url || ''}"
                                                    data-page_url_ta="${page?.page_url_ta || ''}"
                                                    data-page_type="${menu.page_type}"
                                                    data-order_id="${menu.order_id}"
                                                    data-status="${menu.status}"
                                                    data-pdf_en="${page?.pdf_en ? window.location.origin + '/' + page.pdf_en : ''}"
                                                    data-pdf_ta="${page?.pdf_ta ? window.location.origin + '/' + page.pdf_ta : ''}"
                                                    data-external_url="${page?.external_url || ''}"
                                                    data-bs-toggle="modal" data-bs-target="#inputFormModaledit"
                                                    title="Edit">
                                                    <i class="fa fa-pencil text-primary me-2 cursor-pointer"></i>
                                                </a>
                                            </li>
                                            ${staticPageLink}
                                        </ul>
                                    `
                                }
                            </td>
                        </tr>`;

                    $('#sortable').prepend(newRow);

                    // Update S.No for all rows
                    $('#sortable tr').each(function (index) {
                        $(this).find('td:first').text(index + 1);
                    });

                    Swal.fire('Success', response.message, 'success');
                } else {
                    Swal.fire('Error', 'Failed to save menu', 'error');
                    submitBtn.prop('disabled', false).text('Add');
                }
            },
            error: function (xhr) {
                submitBtn.prop('disabled', false).text('Add');

                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMessages = '';
                    $.each(errors, function (key, messages) {
                        errorMessages += `${messages[0]}<br>`;
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorMessages,
                    });
                } else {
                    Swal.fire('Error', 'An unexpected error occurred.', 'error');
                }
            }
        });
    });

    // Handle Edit Menu
  $(document).on('click', '.editquicklinks', function () {
    const el = $(this);
    $('#quicklinksFormedit')[0].reset();

    // Set basic fields first
    $('#quicklinksFormedit input[name="id"]').val(el.data('id'));
    $('#quicklinksFormedit input[name="footer_menu_en"]').val(el.data('footer_menu_en'));
    $('#quicklinksFormedit input[name="footer_menu_ta"]').val(el.data('footer_menu_ta'));
    $('#quicklinksFormedit input[name="order_id"]').val(el.data('order_id'));
    $('#quicklinksFormedit select[name="page_type"]').val(el.data('page_type'));
    $('#quicklinksFormedit select[name="status"]').val(el.data('status'));

    // Call toggleFieldsEdit BEFORE setting conditional values
    const type = el.data('page_type');
    toggleFieldsEdit(type); // <-- Moved up

    // Now set conditional values
    if (type === 'Static Page') {
        $('#quicklinksFormedit input[name="page_url"]').val(el.data('page_url'));
        $('#quicklinksFormedit input[name="page_url_ta"]').val(el.data('page_url_ta'));
    } else if (type === 'pdf') {
        if (el.data('pdf_en')) {
            $('#pdf_en_link').attr('href', el.data('pdf_en')).show();
        } else {
            $('#pdf_en_link').hide();
        }

        if (el.data('pdf_ta')) {
            $('#pdf_ta_link').attr('href', el.data('pdf_ta')).show();
        } else {
            $('#pdf_ta_link').hide();
        }
    } else if (type === 'url') {
        $('#quicklinksFormedit input[name="external_url"]').val(el.data('external_url'));
    }

    $('#inputFormModaledit').modal('show');
});


    // Toggle fields based on page type
    function toggleFieldsEdit(type) {
        $('#staticFieldsEdit, #pdfFieldsEdit, #urlFieldsEdit').hide();
        if (type === 'Static Page') {
            $('#staticFieldsEdit').show();
        } else if (type === 'pdf') {
            $('#pdfFieldsEdit').show();
        } else if (type === 'url') {
            $('#urlFieldsEdit').show();
        }
    }

    // On dropdown change in edit form
    $('#page_type_menuedit').on('change', function () {
        toggleFieldsEdit($(this).val());
    });

});


// --------------update quicklinks-------------------

$(document).on('submit', '#quicklinksFormedit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    const pageType = $(form).find('select[name="page_type"]').val();
    const externalUrl = $(form).find('input[name="external_url"]').val();
    const menuNameEn = $(form).find('input[name="footer_menu_en"]').val().trim();
    const menuNameTa = $(form).find('input[name="footer_menu_ta"]').val().trim();

    // ✅ Validate required fields manually before AJAX
    if (menuNameEn === '' || menuNameTa === '') {
        let message = '';
        if (menuNameEn === '') message += 'Menu Name (English) is required.<br>';
        if (menuNameTa === '') message += 'Menu Name (Tamil) is required.<br>';

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: message,
        });
        return; // stop form submission
    }

    // ✅ Validate external_url if page_type is "url"
    if (pageType === 'url') {
        const urlPattern = /^(http:\/\/|https:\/\/)/i;
        if (!externalUrl || !urlPattern.test(externalUrl)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid External URL',
                text: 'Please enter a valid URL starting with http:// or https://'
            });
            return;
        }
    }

    $.ajax({
        url: BASE_URL +  "/admin/quicklinks/quicklinksedit",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
       success: function(response) {
            if (response.success) {
                const menu = response.menu;
                const page = menu.menu_page || {};
                const row = $(`#sortable tr[data-id="${menu.id}"]`);

                // Update fields
                row.find('td:nth-child(2)').text(menu.footer_menu_en || '');
                row.find('td:nth-child(3)').text(menu.footer_menu_ta || '');
                row.find('td:nth-child(4)').text(menu.page_type || '');

                // Page type content
                let contentHtml = '—';
                if (menu.page_type === 'Static Page') {
                    contentHtml = page.page_url || '—';
                } else if (menu.page_type === 'pdf') {
                    contentHtml = '';
                    if (page.pdf_en) {
                        contentHtml += `<a href="/${page.pdf_en}" target="_blank" class="me-2" title="English PDF"><i class="fa fa-file-pdf-o text-danger"></i></a>`;
                    }
                    if (page.pdf_ta) {
                        contentHtml += `<a href="/${page.pdf_ta}" target="_blank" title="Tamil PDF"><i class="fa fa-file-pdf-o text-success"></i></a>`;
                    }
                } else if (menu.page_type === 'url') {
                    contentHtml = `<a href="${page.external_url}" target="_blank">External Link</a>`;
                }

                row.find('td:nth-child(5)').html(contentHtml);

                // Interlink
                const interlink = menu.menu_id ? 'Main Menu' : (menu.submenu_id ? 'Sub Menu' : '--');
                row.find('td:nth-child(6)').text(interlink);

                // Order ID
                row.find('td:nth-child(7)').text(menu.order_id || '');

                // Status
                const badge = row.find('td:nth-child(8) .badge');
                badge.removeClass('badge-success badge-dark badge-danger');
                if (menu.status == 1) {
                    badge.addClass('badge-success').text('Published');
                } else if (menu.status == 0) {
                    badge.addClass('badge-dark').text('Draft');
                } else if (menu.status == 2) {
                    badge.addClass('badge-danger').text('Disabled');
                }

                // Update edit button
                const editBtn = row.find('.editquicklinks');
                editBtn.data('footer_menu_en', menu.footer_menu_en || '');
                editBtn.data('footer_menu_ta', menu.footer_menu_ta || '');
                editBtn.data('page_type', menu.page_type || '');
                editBtn.data('order_id', menu.order_id || '');
                editBtn.data('status', menu.status || '');
                editBtn.data('page_url', page.page_url || '');
                editBtn.data('page_url_ta', page.page_url_ta || '');
                editBtn.data('external_url', page.external_url || '');
                editBtn.data('pdf_en', page.pdf_en ? `/${page.pdf_en}` : '');
                editBtn.data('pdf_ta', page.pdf_ta ? `/${page.pdf_ta}` : '');

                // Update static page content icon
                const controls = row.find('ul.table-controls');
                controls.find('li').eq(1).remove();
                if (menu.page_type === 'Static Page') {
                    controls.append(`
                        <li>
                            <a href="/admin/quicklinkscontent/${menu.id}" title="Edit">
                                <i class="fa fa-file-text-o"></i>
                            </a>
                        </li>
                    `);
                }

                // Close modal and feedback
                $('#inputFormModaledit').modal('hide');
                $('#quicklinksFormedit')[0].reset();
                row.addClass('table-success');
                setTimeout(() => row.removeClass('table-success'), 1500);
            }
        },
        error: function(xhr) {
            let errors = xhr.responseJSON?.errors;
            if (errors) {
                let msg = '';
                $.each(errors, (key, val) => msg += `${val[0]}<br>`);
                Swal.fire({ icon: 'error', title: 'Validation Error', html: msg });
            } else {
                Swal.fire('Error', 'Unexpected error occurred.', 'error');
            }
        }
    });

    function handleMenuUpdate(menu) {
        const row = $(`#sortable tr[data-id="${menu.id}"]`);
    
        // 1. Update Menu Name, Page Type
        row.find('td:nth-child(2)').text(menu.menu_name_en || '');
        row.find('td:nth-child(3)').text(menu.menu_name_ta || '');
        row.find('td:nth-child(4)').text(menu.page_type || '');
    
        // 2. Page Type Content Column
        let contentCol = '';
        if (menu.page_type === 'Static Page') {
            contentCol = menu.page_url || '—';
        } else if (menu.page_type === 'pdf') {
            const links = [];
            if (menu.pdf_en) {
                links.push(`<a href="/${menu.pdf_en}" target="_blank" class="me-2" title="English PDF">
                                <i class="fa fa-file-pdf-o text-danger"></i>
                            </a>`);
            }
            if (menu.pdf_ta) {
                links.push(`<a href="/${menu.pdf_ta}" target="_blank" title="Tamil PDF">
                                <i class="fa fa-file-pdf-o text-success"></i>
                            </a>`);
            }
            contentCol = links.join(' ');
        } else if (menu.page_type === 'url') {
            contentCol = `<a href="${menu.external_url}" target="_blank">External Link</a>`;
        } else if (menu.page_type === 'submenu') {
            contentCol = '—';
        }
        row.find('td:nth-child(5)').html(contentCol);
    
        // 3. Order ID
        row.find('td:nth-child(6)').text(menu.order_id || '');
    
        // 4. Status Badge
        const badge = row.find('td:nth-child(7) .badge');
        badge.removeClass('badge-success badge-dark badge-danger');
        if (menu.status == 1) {
            badge.addClass('badge-success').text('Published');
        } else if (menu.status == 0) {
            badge.addClass('badge-dark').text('Draft');
        } else if (menu.status == 2) {
            badge.addClass('badge-danger').text('Disabled');
        }
    
        // 5. Update Edit Button Attributes
        const page = menu.menu_page || {};

        const editBtn = row.find('.editMenu');
        editBtn.data('menu_name_en', menu.menu_name_en || '');
        editBtn.data('menu_name_ta', menu.menu_name_ta || '');
        editBtn.data('page_type', menu.page_type || '');
        editBtn.data('order_id', menu.order_id || '');
        editBtn.data('status', menu.status);
        
        editBtn.data('page_url', page.page_url || '');
        editBtn.data('page_url_ta', page.page_url_ta || '');
        editBtn.data('external_url', page.external_url || '');
        editBtn.data('pdf_en', page.pdf_en ? `/${page.pdf_en}` : '');
        editBtn.data('pdf_ta', page.pdf_ta ? `/${page.pdf_ta}` : '');
        
    
        // 6. Update Static Page icon (fa-file-text-o)
        const controlsList = row.find('ul.table-controls');
        controlsList.find('li').eq(1).remove(); // remove second icon if exists
    
        if (menu.page_type === 'Static Page') {
            controlsList.append(`
                <li>
                    <a href="/admin/quicklinkscontent/${menu.id}"  title="Edit">
                        <i class="fa fa-file-text-o"></i>
                    </a>
                </li>
            `);
        }
    
        // 7. Close modal and reset form
        $('#inputFormModaledit').modal('hide');
        $('#quicklinksFormedit')[0].reset();
    
        // 8. Visual feedback
        row.addClass('table-success');
        setTimeout(() => row.removeClass('table-success'), 1500);
    }
    
    
    
    
    
});
// -----------------------------------Quicklinks Content------------------


$(document).on('submit', '#quicklinkscontentedit_en', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: BASE_URL + "/admin/quicklinkscontent/updatequicklinkcontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});

// Tamil Content Submit
$(document).on('submit', '#quicklinkscontentedit_ta', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
// updatemenucontent
    $.ajax({
        url: BASE_URL + "/admin/quicklinkscontent/updatequicklinkcontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});



// -----------------------------------------------
$(document).ready(function () {
    // Open modal and update order_id on show
    $('#inputFormModaladdusefullinks').on('shown.bs.modal', function () {
        let nextOrderId = $('#usefulLinksTable tbody tr').length + 1;
        $('input[name="order_id"]').val(nextOrderId);
    });

    // Handle form submission
    $(document).on('submit', '#usefullinksnew', function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        // Scoped input values
        let menuEn = $(form).find('input[name="menu_name_en"]').val().trim();
        let menuTa = $(form).find('input[name="menu_name_ta"]').val().trim();
        let pageType = $(form).find('select[name="page_type"]').val();
        let status = $(form).find('select[name="status"]').val();
        let errors = [];

        if (!menuEn) errors.push('Menu Name (English) is required.');
        if (!menuTa) errors.push('Menu Name (Tamil) is required.');
        if (!pageType) errors.push('Page Type is required.');
        if (!status) errors.push('Status is required.');

        // Page type specific validation
        if (pageType === 'Static Page') {
            let pageUrl = $(form).find('input[name="page_url"]').val().trim();
            let pageUrlTa = $(form).find('input[name="page_url_ta"]').val().trim();
            if (!pageUrl) errors.push('Page URL (English) is required.');
            if (!pageUrlTa) errors.push('Page URL (Tamil) is required.');
        }

        if (pageType === 'url') {
            let extUrl = $(form).find('input[name="external_url"]').val().trim();
            const urlPattern = /^(http:\/\/|https:\/\/)/i;
            if (!extUrl || !urlPattern.test(extUrl)) {
                errors.push('Valid External URL is required (http:// or https://).');
            }
        }

        // Show errors
        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errors.join('<br>')
            });
            return;
        }

        // Submit via AJAX
        $.ajax({
            url: BASE_URL + '/admin/usefullinks/insertusefullinks',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.fire('Success', response.message, 'success');

                // Close modal and reset form
                $('#inputFormModaladdusefullinks').modal('hide');
                $(form)[0].reset();
                $('#staticFields, #pdfFields, #urlFields').hide();

                // Append new row to the table
                const link = response.data;
                const count = $('#usefulLinksTable tbody tr').length + 1;

                let newRow = `
                    <tr data-id="${link.id}">
                        <td class="text-center">${count}</td>
                        <td>${link.menu_name_en}</td>
                        <td>${link.menu_name_ta}</td>
                        <td class="text-capitalize">${link.page_type}</td>
                        <td class="external-url">`;

                if (link.page_type === 'Static Page') {
                    newRow += link.menu_page?.page_url ?? '';
                } else if (link.page_type === 'pdf') {
                    if (link.menu_page?.pdf_en) {
                        newRow += `<a href="${link.menu_page.pdf_en}" target="_blank" class="me-2" title="English PDF"><i class="fa fa-file-pdf-o text-danger"></i></a>`;
                    }
                    if (link.menu_page?.pdf_ta) {
                        newRow += `<a href="${link.menu_page.pdf_ta}" target="_blank" title="Tamil PDF"><i class="fa fa-file-pdf-o text-success"></i></a>`;
                    }
                } else if (link.page_type === 'url') {
                    newRow += `<a href="${link.menu_page?.external_url ?? '#'}" target="_blank">External Link</a>`;
                } else if (link.page_type === 'submenu') {
                    newRow += '—';
                }

                newRow += `</td>
                        <td>${link.order_id}</td>
                        <td>
                            <span class="badge ${link.status == '1' ? 'badge-success' : (link.status == '0' ? 'badge-dark' : 'badge-danger')}">
                                ${link.status == '1' ? 'Published' : (link.status == '0' ? 'Draft' : 'Disabled')}
                            </span>
                        </td>
                        <td>
                            <ul class="table-controls">
                                <li>
                                    <a href="javascript:void(0);" class="editusefullinks"
                                        data-id="${link.id}"
                                        data-menu_name_en="${link.menu_name_en}"
                                        data-menu_name_ta="${link.menu_name_ta}"
                                        data-page_url="${link.menu_page?.page_url ?? ''}"
                                        data-page_url_ta="${link.menu_page?.page_url_ta ?? ''}"
                                        data-page_type="${link.page_type}"
                                        data-order_id="${link.order_id}"
                                        data-status="${link.status}"
                                        data-pdf_en="${link.menu_page?.pdf_en ?? ''}"
                                        data-pdf_ta="${link.menu_page?.pdf_ta ?? ''}"
                                        data-external_url="${link.menu_page?.external_url ?? ''}"
                                        data-bs-toggle="modal" data-bs-target="#inputFormModaledit">
                                        <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                    </a>
                                </li>
                                ${link.page_type === 'Static Page' ? `
                                <li>
                                    <a href="/admin/usefullinkscontent/${link.id}" title="Edit">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                </li>` : ''}
                            </ul>
                        </td>
                    </tr>
                `;

                $('#usefulLinksTable tbody').prepend(newRow);

                // Update next order_id
                $('input[name="order_id"]').val(count + 1);
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    let serverErrors = xhr.responseJSON.errors;
                    let msg = '';
                    $.each(serverErrors, function (key, val) {
                        msg += `${val[0]}<br>`;
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Server Validation Failed',
                        html: msg
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong. Please try again later.', 'error');
                }
            }
        });
    });
});


// -------------------------edit useful links-----------------------------

function toggleFieldsEdit(type) {
    $('#staticFieldsEdit, #pdfFieldsEdit, #urlFieldsEdit').hide();

    if (type === 'Static Page') {
        $('#staticFieldsEdit').show();
    } else if (type === 'pdf') {
        $('#pdfFieldsEdit').show();
    } else if (type === 'url') {
        $('#urlFieldsEdit').show();
    }
}

$('#page_type_menuedit').on('change', function () {
    toggleFieldsEdit($(this).val());
});

$(document).on('click', '.editusefullinks', function () {
    const el = $(this);
    $('#editusefullinks')[0].reset(); // Reset form

    // Set base values
    $('#editusefullinks input[name="id"]').val(el.data('id'));
    $('#editusefullinks input[name="original_order_id"]').val(el.data('order_id'));
    $('#editusefullinks input[name="menu_name_en"]').val(el.data('menu_name_en'));
    $('#editusefullinks input[name="menu_name_ta"]').val(el.data('menu_name_ta'));
    $('#editusefullinks input[name="order_id"]').val(el.data('order_id'));
    $('#editusefullinks select[name="status"]').val(el.data('status'));

    const type = el.data('page_type');
    $('#editusefullinks select[name="page_type"]').val(type).trigger('change');

    // Set type-specific values
    if (type === 'Static Page') {
        $('#editusefullinks input[name="page_url"]').val(el.data('page_url'));
        $('#editusefullinks input[name="page_url_ta"]').val(el.data('page_url_ta'));
    } else if (type === 'pdf') {
        $('#pdf_en_link').attr('href', el.data('pdf_en')).toggle(!!el.data('pdf_en'));
        $('#pdf_ta_link').attr('href', el.data('pdf_ta')).toggle(!!el.data('pdf_ta'));
    } else if (type === 'url') {
        $('#editusefullinks input[name="external_url"]').val(el.data('external_url'));
    }

    // Show modal
    $('#inputFormModaledit').modal('show');
});
// ----------------------------------------
$(document).on('submit', '#editusefullinks', function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    const pageType = $(form).find('select[name="page_type"]').val();
    const externalUrl = $(form).find('input[name="external_url"]').val();
    const menuNameEn = $(form).find('input[name="menu_name_en"]').val().trim();
    const menuNameTa = $(form).find('input[name="menu_name_ta"]').val().trim();

    if (menuNameEn === '' || menuNameTa === '') {
        let message = '';
        if (menuNameEn === '') message += 'Menu Name (English) is required.<br>';
        if (menuNameTa === '') message += 'Menu Name (Tamil) is required.<br>';

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: message,
        });
        return;
    }

    if (pageType === 'url') {
        const urlPattern = /^(http:\/\/|https:\/\/)/i;
        if (!externalUrl || !urlPattern.test(externalUrl)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid External URL',
                text: 'Please enter a valid URL starting with http:// or https://'
            });
            return;
        }
    }

    $.ajax({
        url: BASE_URL + "/admin/usefullinks/updatelinks",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.conflict) {
                Swal.fire({
                    title: 'Duplicate Order ID',
                    text: response.message,
                    icon: 'warning',
                    confirmButtonText: 'OK',
                });
                return;
            }

            if (response.success) {
                updateTableRow(response.menu);
                 $('#inputFormModaledit').modal('hide'); 
            }
        },
        error: function (xhr) {
            let errors = xhr.responseJSON?.errors;
            if (errors) {
                let errorMessages = '';
                $.each(errors, function (key, messages) {
                    errorMessages += `${messages[0]}<br>`;
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessages,
                });
            } else {
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            }
        }
    });

    function updateTableRow(menu) {
        const page = menu.menu_page || {};
        const row = $(`#usefulLinksTable tr[data-id="${menu.id}"]`);

        row.find('td:nth-child(2)').text(menu.menu_name_en);
        row.find('td:nth-child(3)').text(menu.menu_name_ta);
        row.find('td:nth-child(4)').text(menu.page_type);

        // Handle content (PDF/URL/Static)
        let contentHtml = '—';
        if (menu.page_type === 'Static Page') {
            contentHtml = page.page_url || '—';
        } else if (menu.page_type === 'url') {
            contentHtml = `<a href="${page.external_url}" target="_blank">External Link</a>`;
        } else if (menu.page_type === 'pdf') {
            const links = [];
            if (page.pdf_en) {
                links.push(`<a href="/${page.pdf_en}" target="_blank" class="me-2" title="English PDF">
                                <i class="fa fa-file-pdf-o text-danger"></i>
                            </a>`);
            }
            if (page.pdf_ta) {
                links.push(`<a href="/${page.pdf_ta}" target="_blank" title="Tamil PDF">
                                <i class="fa fa-file-pdf-o text-success"></i>
                            </a>`);
            }
            contentHtml = links.join(' ');
        }
        row.find('td:nth-child(5)').html(contentHtml);

        // Order ID
        row.find('td:nth-child(6)').text(menu.order_id);

        // Status badge
        const badge = row.find('td:nth-child(7) .badge');
        badge.removeClass('badge-success badge-dark badge-danger');
        if (menu.status == 1) {
            badge.addClass('badge-success').text('Published');
        } else if (menu.status == 0) {
            badge.addClass('badge-dark').text('Draft');
        } else if (menu.status == 2) {
            badge.addClass('badge-danger').text('Disabled');
        }

        // Update data-* attributes of the edit button
        const editBtn = row.find('.editusefullinks');
        editBtn.data('menu_name_en', menu.menu_name_en);
        editBtn.data('menu_name_ta', menu.menu_name_ta);
        editBtn.data('page_type', menu.page_type);
        editBtn.data('order_id', menu.order_id);
        editBtn.data('status', menu.status);
        editBtn.data('page_url', page.page_url || '');
        editBtn.data('page_url_ta', page.page_url_ta || '');
        editBtn.data('external_url', page.external_url || '');
        editBtn.data('pdf_en', page.pdf_en ? `/${page.pdf_en}` : '');
        editBtn.data('pdf_ta', page.pdf_ta ? `/${page.pdf_ta}` : '');

        // Visual feedback
        row.addClass('table-success');
        setTimeout(() => row.removeClass('table-success'), 1500);
    }
});

// ---------------------------usefullinkscontent-------------------------------



// English Content Submit
$(document).on('submit', '#usefullinkscontent_en', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

   

    $.ajax({
        url: BASE_URL + "/admin/usefullinkscontent/updateusefullinkscontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});

// Tamil Content Submit
$(document).on('submit', '#usefullinkscontent_ta', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: BASE_URL + "/admin/usefullinkscontent/updateusefullinkscontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});

// ---------------------------footerbottomlinks-------------

$(document).ready(function () {
    // Open modal and update order_id on show
    $('#inputFormModaladdfooterbottom').on('shown.bs.modal', function () {
        let nextOrderId = $('#footerbottomTable tbody tr').length + 1;
        $('input[name="order_id"]').val(nextOrderId);
    });

    // Handle form submission
    $(document).on('submit', '#footerbottomlinksnew', function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        // Scoped input values
        let menuEn = $(form).find('input[name="menu_name_en"]').val().trim();
        let menuTa = $(form).find('input[name="menu_name_ta"]').val().trim();
        let pageType = $(form).find('select[name="page_type"]').val();
        let status = $(form).find('select[name="status"]').val();
        let errors = [];

        if (!menuEn) errors.push('Menu Name (English) is required.');
        if (!menuTa) errors.push('Menu Name (Tamil) is required.');
        if (!pageType) errors.push('Page Type is required.');
        if (!status) errors.push('Status is required.');

        // Page type specific validation
        if (pageType === 'Static Page') {
            let pageUrl = $(form).find('input[name="page_url"]').val().trim();
            let pageUrlTa = $(form).find('input[name="page_url_ta"]').val().trim();
            if (!pageUrl) errors.push('Page URL (English) is required.');
            if (!pageUrlTa) errors.push('Page URL (Tamil) is required.');
        }

        if (pageType === 'url') {
            let extUrl = $(form).find('input[name="external_url"]').val().trim();
            const urlPattern = /^(http:\/\/|https:\/\/)/i;
            if (!extUrl || !urlPattern.test(extUrl)) {
                errors.push('Valid External URL is required (http:// or https://).');
            }
        }

        // Show errors
        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errors.join('<br>')
            });
            return;
        }

        // Submit via AJAX
        $.ajax({
            url: BASE_URL + '/admin/footerbottomlinks/insertfooterbottomlinks',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.fire('Success', response.message, 'success');

                // Close modal and reset form
                $('#inputFormModaladdfooterbottom').modal('hide');
                $(form)[0].reset();
                $('#staticFields, #pdfFields, #urlFields').hide();

                // Append new row to the table
                const link = response.data;
                const count = $('#footerbottomTable tbody tr').length + 1;

                let newRow = `
                    <tr data-id="${link.id}">
                        <td class="text-center">${count}</td>
                        <td>${link.menu_name_en}</td>
                        <td>${link.menu_name_ta}</td>
                        <td class="text-capitalize">${link.page_type}</td>
                        <td class="external-url">`;

                if (link.page_type === 'Static Page') {
                    newRow += link.menu_page?.page_url ?? '';
                } else if (link.page_type === 'pdf') {
                    if (link.menu_page?.pdf_en) {
                        newRow += `<a href="${link.menu_page.pdf_en}" target="_blank" class="me-2" title="English PDF"><i class="fa fa-file-pdf-o text-danger"></i></a>`;
                    }
                    if (link.menu_page?.pdf_ta) {
                        newRow += `<a href="${link.menu_page.pdf_ta}" target="_blank" title="Tamil PDF"><i class="fa fa-file-pdf-o text-success"></i></a>`;
                    }
                } else if (link.page_type === 'url') {
                    newRow += `<a href="${link.menu_page?.external_url ?? '#'}" target="_blank">External Link</a>`;
                } else if (link.page_type === 'submenu') {
                    newRow += '—';
                }

                newRow += `</td>
                        <td>${link.order_id}</td>
                        <td>
                            <span class="badge ${link.status == '1' ? 'badge-success' : (link.status == '0' ? 'badge-dark' : 'badge-danger')}">
                                ${link.status == '1' ? 'Published' : (link.status == '0' ? 'Draft' : 'Disabled')}
                            </span>
                        </td>
                        <td>
                            <ul class="table-controls">
                                <li>
                                    <a href="javascript:void(0);" class="editusefullinks"
                                        data-id="${link.id}"
                                        data-menu_name_en="${link.menu_name_en}"
                                        data-menu_name_ta="${link.menu_name_ta}"
                                        data-page_url="${link.menu_page?.page_url ?? ''}"
                                        data-page_url_ta="${link.menu_page?.page_url_ta ?? ''}"
                                        data-page_type="${link.page_type}"
                                        data-order_id="${link.order_id}"
                                        data-status="${link.status}"
                                        data-pdf_en="${link.menu_page?.pdf_en ?? ''}"
                                        data-pdf_ta="${link.menu_page?.pdf_ta ?? ''}"
                                        data-external_url="${link.menu_page?.external_url ?? ''}"
                                        data-bs-toggle="modal" data-bs-target="#inputFormModaledit">
                                        <i class="fa fa-pencil text-primary me-2 cursor-pointer" title="Edit"></i>
                                    </a>
                                </li>
                                ${link.page_type === 'Static Page' ? `
                                <li>
                                    <a href="/admin/footerbottomlinkscontent/${link.id}" title="Edit">
                                        <i class="fa fa-file-text-o"></i>
                                    </a>
                                </li>` : ''}
                            </ul>
                        </td>
                    </tr>
                `;

                $('#footerbottomTable tbody').prepend(newRow);

                // Update next order_id
                $('input[name="order_id"]').val(count + 1);
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    let serverErrors = xhr.responseJSON.errors;
                    let msg = '';
                    $.each(serverErrors, function (key, val) {
                        msg += `${val[0]}<br>`;
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Server Validation Failed',
                        html: msg
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong. Please try again later.', 'error');
                }
            }
        });
    });
});


// --------------------------------------edit footer_bottom--------------


function toggleFieldsEdit(type) {
    $('#staticFieldsEdit, #pdfFieldsEdit, #urlFieldsEdit').hide();

    if (type === 'Static Page') {
        $('#staticFieldsEdit').show();
    } else if (type === 'pdf') {
        $('#pdfFieldsEdit').show();
    } else if (type === 'url') {
        $('#urlFieldsEdit').show();
    }
}

$('#page_type_menuedit').on('change', function () {
    toggleFieldsEdit($(this).val());
});

$(document).on('click', '.editfooterbottomlinks', function () {
    const el = $(this);
    $('#editfooterbottomlinks')[0].reset(); // Reset form

    // Set base values
    $('#editfooterbottomlinks input[name="id"]').val(el.data('id'));
    $('#editfooterbottomlinks input[name="original_order_id"]').val(el.data('order_id'));
    $('#editfooterbottomlinks input[name="menu_name_en"]').val(el.data('menu_name_en'));
    $('#editfooterbottomlinks input[name="menu_name_ta"]').val(el.data('menu_name_ta'));
    $('#editfooterbottomlinks input[name="order_id"]').val(el.data('order_id'));
    $('#editfooterbottomlinks select[name="status"]').val(el.data('status'));

    const type = el.data('page_type');
    $('#editfooterbottomlinks select[name="page_type"]').val(type).trigger('change');

    // Set type-specific values
    if (type === 'Static Page') {
        $('#editfooterbottomlinks input[name="page_url"]').val(el.data('page_url'));
        $('#editfooterbottomlinks input[name="page_url_ta"]').val(el.data('page_url_ta'));
    } else if (type === 'pdf') {
        $('#pdf_en_link').attr('href', el.data('pdf_en')).toggle(!!el.data('pdf_en'));
        $('#pdf_ta_link').attr('href', el.data('pdf_ta')).toggle(!!el.data('pdf_ta'));
    } else if (type === 'url') {
        $('#editfooterbottomlinks input[name="external_url"]').val(el.data('external_url'));
    }

    // Show modal
    $('#inputFormModaledit').modal('show');
});


// ----------------------------edit footerbottom----------------------

$(document).on('submit', '#editfooterbottomlinks', function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    const pageType = $(form).find('select[name="page_type"]').val();
    const externalUrl = $(form).find('input[name="external_url"]').val();
    const menuNameEn = $(form).find('input[name="menu_name_en"]').val().trim();
    const menuNameTa = $(form).find('input[name="menu_name_ta"]').val().trim();

    if (menuNameEn === '' || menuNameTa === '') {
        let message = '';
        if (menuNameEn === '') message += 'Menu Name (English) is required.<br>';
        if (menuNameTa === '') message += 'Menu Name (Tamil) is required.<br>';

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: message,
        });
        return;
    }

    if (pageType === 'url') {
        const urlPattern = /^(http:\/\/|https:\/\/)/i;
        if (!externalUrl || !urlPattern.test(externalUrl)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid External URL',
                text: 'Please enter a valid URL starting with http:// or https://'
            });
            return;
        }
    }

    $.ajax({
        url: BASE_URL + "/admin/editfooterbottomlinks/updatebottomlinks",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.conflict) {
                Swal.fire({
                    title: 'Duplicate Order ID',
                    text: response.message,
                    icon: 'warning',
                    confirmButtonText: 'OK',
                });
                return;
            }

            if (response.success) {
                updateTableRow(response.menu);
                 $('#inputFormModaledit').modal('hide'); 
            }
        },
        error: function (xhr) {
            let errors = xhr.responseJSON?.errors;
            if (errors) {
                let errorMessages = '';
                $.each(errors, function (key, messages) {
                    errorMessages += `${messages[0]}<br>`;
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessages,
                });
            } else {
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            }
        }
    });

    function updateTableRow(menu) {
        const page = menu.menu_page || {};
        const row = $(`#footerbottomTable tr[data-id="${menu.id}"]`);

        row.find('td:nth-child(2)').text(menu.menu_name_en);
        row.find('td:nth-child(3)').text(menu.menu_name_ta);
        row.find('td:nth-child(4)').text(menu.page_type);

        // Handle content (PDF/URL/Static)
        let contentHtml = '—';
        if (menu.page_type === 'Static Page') {
            contentHtml = page.page_url || '—';
        } else if (menu.page_type === 'url') {
            contentHtml = `<a href="${page.external_url}" target="_blank">External Link</a>`;
        } else if (menu.page_type === 'pdf') {
            const links = [];
            if (page.pdf_en) {
                links.push(`<a href="/${page.pdf_en}" target="_blank" class="me-2" title="English PDF">
                                <i class="fa fa-file-pdf-o text-danger"></i>
                            </a>`);
            }
            if (page.pdf_ta) {
                links.push(`<a href="/${page.pdf_ta}" target="_blank" title="Tamil PDF">
                                <i class="fa fa-file-pdf-o text-success"></i>
                            </a>`);
            }
            contentHtml = links.join(' ');
        }
        row.find('td:nth-child(5)').html(contentHtml);

        // Order ID
        row.find('td:nth-child(6)').text(menu.order_id);

        // Status badge
        const badge = row.find('td:nth-child(7) .badge');
        badge.removeClass('badge-success badge-dark badge-danger');
        if (menu.status == 1) {
            badge.addClass('badge-success').text('Published');
        } else if (menu.status == 0) {
            badge.addClass('badge-dark').text('Draft');
        } else if (menu.status == 2) {
            badge.addClass('badge-danger').text('Disabled');
        }

        // Update data-* attributes of the edit button
        const editBtn = row.find('.editfooterbottomlinks');
        editBtn.data('menu_name_en', menu.menu_name_en);
        editBtn.data('menu_name_ta', menu.menu_name_ta);
        editBtn.data('page_type', menu.page_type);
        editBtn.data('order_id', menu.order_id);
        editBtn.data('status', menu.status);
        editBtn.data('page_url', page.page_url || '');
        editBtn.data('page_url_ta', page.page_url_ta || '');
        editBtn.data('external_url', page.external_url || '');
        editBtn.data('pdf_en', page.pdf_en ? `/${page.pdf_en}` : '');
        editBtn.data('pdf_ta', page.pdf_ta ? `/${page.pdf_ta}` : '');

        // Visual feedback
        row.addClass('table-success');
        setTimeout(() => row.removeClass('table-success'), 1500);
    }
});


// --------------------footer bottom content------------------



// English Content Submit
$(document).on('submit', '#footerbottomcontent_en', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

   

    $.ajax({
        url: BASE_URL + "/admin/footerbottomlinkscontent/updatefootercontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});

// Tamil Content Submit
$(document).on('submit', '#footerbottomcontent_ta', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: BASE_URL + "/admin/footerbottomlinkscontent/updatefootercontent",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            Swal.fire('Success', response.message, 'success');
        },
        error: function () {
            Swal.fire('Error', 'Fill the Fields Properly.', 'error');
        }
    });
});


// ------------------------------footerbottom content textarea-------------

$(document).ready(function () {
    $('#footerbottomupdate_en, #footerbottomupdate_ta').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL + '/admin/footerbottom/updatecopyrights',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated Successfully!',
                    text: response.message || 'Footer updated.',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                let errorMessage = "Something went wrong.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed!',
                    text: errorMessage,
                    confirmButtonText: 'Close'
                });
            }
        });
    });
});

// ---------------------------------------media--------

  document.getElementById('fileTypeSelect').addEventListener('change', function () {
        const selectedType = this.value;
        const fileInput = document.getElementById('fileInput');

        if (selectedType === 'pdf') {
            fileInput.setAttribute('accept', 'application/pdf');
        } else if (selectedType === 'image') {
            fileInput.setAttribute('accept', 'image/*');
        } else {
            fileInput.removeAttribute('accept');
        }
    });

    // Trigger the change once on load to set default accept value
    document.getElementById('fileTypeSelect').dispatchEvent(new Event('change'));


    // -------------------------media Insert---------------

    


    // Change file accept type on selection
    $('#fileTypeSelect').on('change', function () {
        const selectedType = $(this).val();
        const fileInput = $('#fileInput');

        if (selectedType === 'pdf') {
            fileInput.attr('accept', 'application/pdf');
        } else {
            fileInput.attr('accept', 'image/*');
        }
    }).trigger('change');

    // AJAX form submission
    $('#insertmedia').on('submit', function (e) {
        e.preventDefault();

   

        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0];

        if (!file) {
            alert('Please choose a file.');
            return;
        }

        if (file.size > 256000) { // 250KB = 256000 bytes
            alert('File size must be less than or equal to 250KB.');
            return;
        }

        const formData = new FormData(this);

        $.ajax({
            url: BASE_URL + "/admin/media/insertmedia", // Adjust route name
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
         success: function (response) {
    $('#addmediaitems').modal('hide');

    if (response.success && response.media) {
        const media = response.media;

        let html = '';
        if (media.type === 'image') {
            html += `
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-6 mb-4">
                    <a class="card style-6" href="#">
                        <img src="/${media.filepath_img_pdf}" alt="${media.alt_text_en}" class="slider-image text-center img-thumbnail1" />
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12 text-center mb-4">
                                    <b>${media.title_en ?? 'Untitled'}</b>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-danger delete-media" data-id="${media.id}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            `;
        } else {
            html += `
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-6 mb-4">
                    <div class="card style-6">
                        <a href="/${media.filepath_img_pdf}" target="_blank">
                            <img src="/assets/portaladmin/pdf-icon.png" alt="${media.alt_text_en}" class="slider-image text-center img-thumbnail1" />
                        </a>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12 text-center mb-4">
                                    <b>${media.title_en ?? 'Untitled'}</b>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-danger delete-media" data-id="${media.id}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        $('#gallery-row').prepend(html); // Add new card at the top
        $('#insertmedia')[0].reset();
        $('#fileTypeSelect').trigger('change');

        // ✅ Show SweetAlert success
        Swal.fire({
            icon: 'success',
            title: 'Media Added!',
            text: 'Your file has been added successfully.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    }
},
       error: function (xhr) {
    if (xhr.status === 422) {
        let errors = xhr.responseJSON.errors;
        let errorMessages = '';

        // Combine all validation error messages
        Object.values(errors).forEach(function (messages) {
            messages.forEach(function (msg) {
                errorMessages += `<div>${msg}</div>`;
            });
        });

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errorMessages,
            confirmButtonColor: '#d33',
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#d33',
        });
    }
}


        });
    });


// ----------------------media delete------------------

$(document).on('click', '.delete-media', function () {
    let button = $(this); // the clicked delete button
    let id = button.data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This will deactivate the media item.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, deactivate it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + '/admin/media/delete/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    Swal.fire(
                        'Deactivated!',
                        'The media item has been removed.',
                        'success'
                    );

                    // Remove the full card (col div)
                    button.closest('.col-xxl-2, .col-xl-2, .col-lg-2, .col-md-2, .col-sm-6').remove();
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'Something went wrong while deleting.',
                        'error'
                    );
                }
            });
        }
    });
});


// ---------------media edit-------------------
$(document).on('click', '.open-edit-media-modal', function (e) {
    e.preventDefault();

    const id = $(this).data('id');
    const titleEn = $(this).data('title-en');
    const titleTa = $(this).data('title-ta');
    const altEn = $(this).data('alt-en');
    const altTa = $(this).data('alt-ta');
    const type = $(this).data('type');
    const filePath = $(this).data('path'); // Use full path to PDF or image

    // Fill form fields
    $('#editImageId').val(id);
    $('#editmediaForm input[name="title_en"]').val(titleEn);
    $('#editmediaForm input[name="title_ta"]').val(titleTa);
    $('#editmediaForm input[name="alt_text_en"]').val(altEn);
    $('#editmediaForm input[name="alt_text_ta"]').val(altTa);
    $('#editmediaForm select[name="type"]').val(type);

    // Reset preview block
    $('#editImagePreview').hide();
    $('#editPdfLink').hide();
    $('#currentImageWrapper').hide();

    // Show correct preview
   if (type === 'image') {
        $('#editImagePreview').attr('src', filePath).show();
        $('#editPdfLink').hide(); // ensure link is hidden
        $('#currentImageWrapper').show();
    } else if (type === 'pdf') {
        $('#editPdfLink').attr('href', filePath).text('View PDF').show();
        $('#editImagePreview').hide(); // ensure image is hidden
        $('#currentImageWrapper').show();
    }

    // Open modal
    $('#inputFormModaleditgallery').modal('show');
});


// --------------------update media------------------
$(document).on("submit", "#editmediaForm", function (e) {
    e.preventDefault();

    let form = $(this);
    let formData = new FormData(this);
    let submitBtn = form.find("button[type='submit']");

    submitBtn.prop("disabled", true).text("Updating...");

    $.ajax({
        url: BASE_URL + "/admin/media/updatemedia",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status === "success") {
                Swal.fire("Success", response.message, "success");

                const media = response.media;

                const updatedCard = `
                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-6 mb-4">
                        <a class="card style-6 open-edit-media-modal"
                            href="#"
                            data-id="${media.id}"
                            data-title-en="${media.title_en}"
                            data-title-ta="${media.title_ta}"
                            data-alt-en="${media.alt_text_en}"
                            data-alt-ta="${media.alt_text_ta}"
                            data-type="${media.type}"
                            data-path="${media.path}">

                            <img src="${media.type === 'pdf' ? '/assets/portaladmin/pdf-icon.png' : media.path}" alt="${media.alt_text_en}" class="slider-image text-center img-thumbnail1" />

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-8 text-left mb-4">
                                        <b>${media.title_en || 'Untitled'}</b>
                                    </div>
                                    <div class="col-4 text-left">
                                        <button class="btn btn-danger delete-media" data-id="${media.id}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;

                $(`#gallery-row .open-edit-media-modal[data-id='${media.id}']`).closest(".col-xxl-2").replaceWith(updatedCard);
                $('#inputFormModaleditgallery').modal('hide');
            } else {
                Swal.fire("Error", response.message, "error");
            }

            submitBtn.prop("disabled", false).text("Update");
        },
        error: function (xhr) {
            let message = "Something went wrong";

            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                message = Object.values(xhr.responseJSON.errors).map(arr => arr[0]).join("<br>");
            } else if (xhr.responseJSON?.message) {
                message = xhr.responseJSON.message;
            }

            Swal.fire("Validation Error", message, "error");
            submitBtn.prop("disabled", false).text("Update");
        }
    });
});

// --------------media menu----------------------
let currentPdfTarget = '';

    function openMediaLibraryPdf(fieldId) {

          
        currentPdfTarget = fieldId;
      alert(currentPdfTarget);
        const modal = new bootstrap.Modal(document.getElementById('mediaLibraryModalpdfmenu'));
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const selectBtn = document.getElementById('selectImageBtnpdfmenu');

        selectBtn.addEventListener('click', function () {
            const selected = document.querySelector('input[name="mediaSelect"]:checked');
            if (!selected) {
                alert('Please select a PDF.');
                return;
            }

            const image = selected.closest('.card').querySelector('.media-image');
            const filePath = image.getAttribute('data-path');
            const pdfId = selected.value;

            if (currentPdfTarget) {
                // Set PDF ID as value
                document.getElementById(currentPdfTarget).value = pdfId;

                // Show preview link
                const fileName = filePath.split('/').pop();
                const previewElement = document.getElementById('preview_' + currentPdfTarget);
                previewElement.innerHTML = `
                    <a href="${filePath}" target="_blank">
                        <i class="fa fa-file-pdf-o text-danger"></i> ${fileName}
                    </a>`;
            }

            // Hide modal
            const modalEl = document.getElementById('mediaLibraryModalpdfmenu');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        });
    });





