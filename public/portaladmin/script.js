$(document).ready(function () {
    // Add submenu
    $('#submenuFormadd').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let submitBtn = $('#submenuFormadd button[type="submit"]');
        submitBtn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: submenuInsertRoute,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function (response) {
                if (response.success && response.menu) {
                    $('#submenuFormadd')[0].reset();
                    submitBtn.prop('disabled', false).text('Add');
                    $('#inputFormModal').modal('hide');

                    let newRow = `
                        <tr data-id="${response.menu.id}">
                            <td class="text-center">New</td>
                            <td>${response.menu.menu_name_en}</td>
                            <td>${response.menu.menu_name_ta}</td>
                            <td>${response.menu.page_url}</td>
                            <td>
                                <span class="badge ${response.menu.status == '1' ? 'badge-success' : 'badge-dark'}">
                                    ${response.menu.status == '1' ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                            <td>
                                <ul class="table-controls">
                                    <li>
                                        <a href="javascript:void(0);" class="editsubMenu"
                                           data-id="${response.menu.id}"
                                           data-menu_name_en="${response.menu.menu_name_en}"
                                           data-menu_name_ta="${response.menu.menu_name_ta}"
                                           data-page_url="${response.menu.page_url}"
                                           data-page_url_ta="${response.menu.page_url_ta}"
                                           data-page_type="${response.menu.page_type}"
                                           data-parent_code="${response.menu.parent_code}"
                                           data-page_content="${response.menu.page_content}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#inputFormModaledit"
                                           title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-edit-2 p-1 br-8 mb-1">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="bs-tooltip deleteMenu"
                                           data-id="${response.menu.id}"
                                           title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-trash p-1 br-8 mb-1">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4
                                                          a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>`;
                    $('#sortable-submenu').append(newRow);
                    $('#sortable-submenu tr').each(function (index) {
                        $(this).find('td:first').text(index + 1);
                    });
                } else {
                    alert('Menu could not be created.');
                    submitBtn.prop('disabled', false).text('Add');
                }
            },
            error: function (xhr) {
                alert('An error occurred while saving the menu.');
                submitBtn.prop('disabled', false).text('Add');
            }
        });
    });

    // Edit submenu
    $(document).on('click', '.editsubMenu', function () {
        const el = $(this);
        $('#submenuFormedit input[name="menu_name_en"]').val(el.data('menu_name_en'));
        $('#submenuFormedit input[name="menu_name_ta"]').val(el.data('menu_name_ta'));
        $('#submenuFormedit input[name="page_url"]').val(el.data('page_url'));
        $('#submenuFormedit input[name="page_url_ta"]').val(el.data('page_url_ta'));
        $('#submenuFormedit select[name="page_type"]').val(el.data('page_type'));
        $('#submenuFormedit select[name="parent_code"]').val(el.data('parent_code'));
        $('#submenuFormedit select[name="page_content"]').val(el.data('page_content'));
        $('#menu_id').val(el.data('id'));
        $('#inputFormModaledit').modal('show');
    });

    // Submit edit submenu form
    $(document).on('submit', '#submenuFormedit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: submenuUpdateRoute,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function (response) {
                if (response.success) {
                    const menu = response.menu;
                    const row = $(`#sortable-submenu tr[data-id="${menu.id}"]`);
                    row.find('td:nth-child(2)').text(menu.menu_name_en);
                    row.find('td:nth-child(3)').text(menu.menu_name_ta);
                    row.find('td:nth-child(4)').text(menu.page_url);
                    row.find('span.badge')
                        .removeClass('badge-success badge-dark')
                        .addClass(menu.status == 1 ? 'badge-success' : 'badge-dark')
                        .text(menu.status == 1 ? 'Active' : 'Inactive');

                    $('#inputFormModaledit').modal('hide');
                    $('#submenuFormedit')[0].reset();
                    row.addClass('table-success');
                    setTimeout(() => row.removeClass('table-success'), 1500);
                }
            },
            error: function (xhr) {
                alert('An error occurred!');
            }
        });
    });

    // Delete submenu
    $(document).on('click', '.deleteMenu', function () {
        const menuId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will mark the menu as inactive.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, deactivate it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/portaladmin/submenus/${menuId}/deactivatesubmenu`,
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Deactivated!', response.message, 'success');
                            $(`tr[data-id="${menuId}"]`).find('.badge')
                                .removeClass('badge-success').addClass('badge-dark').text('Inactive');
                        } else {
                            Swal.fire('Failed', response.message || 'Could not deactivate.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // Toggle status submenu
    $(document).on('click', '.toggleStatussubmenu', function () {
        const menuId = $(this).data('id');
        const newStatus = $(this).data('status');
        const isActivating = newStatus == 1;

        Swal.fire({
            title: isActivating ? 'Activate this menu?' : 'Deactivate this menu?',
            icon: isActivating ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonText: isActivating ? 'Yes, activate it!' : 'Yes, deactivate it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/portaladmin/submenus/${menuId}/toggle-statussubmenu`,
                    type: 'POST',
                    data: { status: newStatus },
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Success!', response.message, 'success');
                            const row = $(`tr[data-id="${menuId}"]`);
                            const badge = row.find('.badge');
                            const controlList = row.find('.table-controls');

                            badge.toggleClass('badge-success badge-dark').text(isActivating ? 'Active' : 'Inactive');

                            controlList.find('.toggleStatussubmenu').parent().remove();
                            controlList.append(`
                                <li>
                                    <a href="javascript:void(0);" class="toggleStatussubmenu bs-tooltip"
                                       data-id="${menuId}" data-status="${isActivating ? 0 : 1}"
                                       title="${isActivating ? 'Deactivate' : 'Activate'}">
                                        ${isActivating ?
                                            '<svg class="feather feather-trash p-1 br-8 mb-1" ...>...</svg>' :
                                            '<svg class="feather feather-check-circle p-1 br-8 mb-1" ...>...</svg>'
                                        }
                                    </a>
                                </li>
                            `);
                        } else {
                            Swal.fire('Error', response.message || 'Action failed.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Server error occurred.', 'error');
                    }
                });
            }
        });
    });

    // Reordering submenu
    $('#sortable-submenu').sortable({
        update: function () {
            let data = [];
            $('#sortable-submenu tr').each(function (index) {
                let id = $(this).data('id');
                data.push({ id: id, order_id: index + 1 });
            });

            $.ajax({
                url: submenuReorderRoute,
                method: 'POST',
                data: { data: data, _token: csrfToken },
                success: function (response) {
                    if (response.status === 'success') {
                        $('#reorderAlert').removeClass('d-none').fadeIn();
                        setTimeout(function () {
                            $('#reorderAlert').fadeOut();
                        }, 3000);
                    } else {
                        alert('Reorder failed: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('AJAX error: ' + xhr.responseText);
                }
            });
        }
    });

    // Summernote initialization for newsboards
    $('#newsboard_en, #newsboard_ta').summernote({
        height: 200,
        placeholder: 'Enter content here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });

    // Newsboard English
    $('.edit-newsboard-btn').on('click', function () {
        var content = $(this).data('content');
        var id = $(this).data('id');
        $('#newsboard_en').summernote('code', content);
        $('#newsboard_id').val(id);
    });

    $('#update_english').on('submit', function (e) {
        e.preventDefault();
        var id = $('#newsboard_id').val();
        var content = $('#newsboard_en').summernote('code');

        $.post(newsboardUpdateRoute, {
            _token: csrfToken,
            id: id,
            newsboard_en: content
        }, function (response) {
            alert('News Board updated successfully!');
            $('.info-box-4-content.English').html(content);
            $('.edit-newsboard-btn').data('content', content);
            $('#inputFormModal').modal('hide');
        });
    });

    // Newsboard Tamil
    $('.edit-newsboard-tamil-btn').on('click', function () {
        var content = $(this).data('content');
        var id = $(this).data('id');
        $('#newsboard_ta').summernote('code', content);
        $('#newsboard_ta_id').val(id);
    });

    $('#update_tamil').on('submit', function (e) {
        e.preventDefault();
        var id = $('#newsboard_ta_id').val();
        var content = $('#newsboard_ta').summernote('code');

        $.post(newsboardUpdateTamilRoute, {
            _token: csrfToken,
            id: id,
            newsboard_ta: content
        }, function (response) {
            alert('Tamil News Board updated successfully!');
            $('.info-box-4-content.Tamil').html(content);
            $('.edit-newsboard-tamil-btn').data('content', content);
            $('#inputFormModalTamil').modal('hide');
        });
    });
});

// You must define these route variables from blade or layout
const csrfToken = '{{ csrf_token() }}';
const submenuInsertRoute = "{{ route('portaladmin.submenus.insertsubmenu') }}";
const submenuUpdateRoute = "{{ route('portaladmin.submenus.updatesubitems') }}";
const submenuReorderRoute = "{{ route('portaladmin.submenu.reorders') }}";
const newsboardUpdateRoute = "{{ route('portaladmin.newsboard.update') }}";
const newsboardUpdateTamilRoute = "{{ route('portaladmin.newsboard.updatetamil') }}";
