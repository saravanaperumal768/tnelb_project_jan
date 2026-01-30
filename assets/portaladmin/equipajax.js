$(document).on("submit", "#addequipment", function (e) {
    e.preventDefault();

    // alert('111');
    

    // Clear previous errors
    $(".text-danger").addClass("d-none").text("");

    let formData = new FormData(this);

    $.ajax({
        // url: "{{ route('equipment.store') }}",

        url: BASE_URL + '/admin/equipment/operations', 
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
       success: function (res) {

    Swal.fire({
        icon: "success",
        title: "Success",
        text: res.message,
    });

    // Close modal
    $("#addFormModal").modal("hide");

    // Reset form
    $("#addequipment")[0].reset();

    // Build new row
    let rowCount = $("#style-3 tbody tr").length + 1;

    let statusBadge = res.data.status == 1
        ? `<span class="badge outline-badge-success">Active</span>`
        : `<span class="badge outline-badge-danger">Inactive</span>`;

    let newRow = `
        <tr>
            <td class="text-center">${rowCount}</td>
            <td>${res.data.licence_name}</td>
            
            <td>${res.data.equip_name}</td>
            <td>${res.data.equipment_type}</td>
            
            <td class="text-center">${res.data.created_at}</td>
            <td class="text-center">${statusBadge}</td>
            <td class="text-center"> <button class="btn btn-danger" id="{{ $index +1 }}">
                                                            Delete</button>
            </td>
        </tr>
    `;

    // Append to table
    $("#style-3 tbody").append(newRow);
},

        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                if (errors.equip_licence_name) {
                    
                    $(".error-form_cate")
                        .removeClass("d-none")
                        .text(errors.equip_licence_name[0]);
                }

                 if (errors.equipment_type) {
                    
                    $(".error-equipment_type")
                        .removeClass("d-none")
                        .text(errors.equipment_type[0]);
                }

                if (errors.equip_name) {
                    $(".error-cer_val")
                        .removeClass("d-none")
                        .text(errors.equip_name[0]);
                }
            } else {
                Swal.fire("Error", "Something went wrong", "error");
            }
        }
    });
});
        

$(document).on('change', '.equip-status-toggle', function () {

    let checkbox = $(this);
    let equipId  = checkbox.data('id');
    let status   = checkbox.is(':checked') ? 1 : 0;

    // 🔴 Ask confirmation ONLY when inactivating
    if (status === 0) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to inactivate this equipment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Inactivate',
            cancelButtonText: 'No',
        }).then((result) => {

            if (result.isConfirmed) {
                updateStatus(equipId, status, checkbox);
            } else {
                // ❌ revert toggle
                checkbox.prop('checked', true);
            }

        });

    } else {
        // 🟢 Activate directly (no confirmation)
        updateStatus(equipId, status, checkbox);
    }
});


function updateStatus(equipId, status, checkbox) {

    $.ajax({
        url: BASE_URL + '/admin/equipment/updateStatus',
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: equipId,
            status: status
        },
        success: function (response) {

            Swal.fire({
                icon: 'success',
                title: 'Updated',
                text: response.message,
                timer: 1500,
                showConfirmButton: false
            });

            // 🔄 Update badge instantly
            let badge = checkbox.closest('tr').find('.badge');

            if (status === 1) {
                badge
                    .removeClass('outline-badge-danger')
                    .addClass('outline-badge-success')
                    .text('Active');
            } else {
                badge
                    .removeClass('outline-badge-success')
                    .addClass('outline-badge-danger')
                    .text('Inactive');
            }
        },
        error: function () {
            Swal.fire('Error', 'Unable to update status', 'error');

            // rollback toggle on error
            checkbox.prop('checked', !status);
        }
    });
}


$(document).ready(function () {

    $('.licenseFilter').each(function () {

        let filter = $(this);
        let tableId = filter.data('table');
        let tableElement = $('#' + tableId);

        // ✅ Prevent DataTable reinitialisation
        let table;
        if ($.fn.DataTable.isDataTable(tableElement)) {
            table = tableElement.DataTable();
        } else {
            table = tableElement.DataTable({
                pageLength: 10
            });
        }

        // Column index of "Certificate Name / Form Name"
        let licenseColumn = table.column(1);
        let licenses = [];

        // Collect unique licence names
        licenseColumn.data().each(function (value) {
            let licenceName = value.split('/')[0].trim();
            if (!licenses.includes(licenceName)) {
                licenses.push(licenceName);
            }
        });

        // Populate dropdown
        licenses.sort().forEach(function (licence) {
            filter.append(`<option value="${licence}">${licence}</option>`);
        });

        // Filter on change
        filter.on('change', function () {
            let selected = $(this).val();

            if (selected) {
                licenseColumn.search(selected, true, false).draw();
            } else {
                licenseColumn.search('').draw();
            }
        });

    });

});
 

