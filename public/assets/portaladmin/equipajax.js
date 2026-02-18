$(document).on("submit", "#addequipment", function (e) {
    e.preventDefault();

    // alert('111');

    // Clear previous errors
    $(".text-danger").addClass("d-none").text("");

    let formData = new FormData(this);

    $.ajax({
        // url: "{{ route('equipment.store') }}",

        url: BASE_URL + "/admin/equipment/operations",
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

            let statusBadge =
                res.data.status == 1
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
        },
    });
});

// ----------------Formmodule--------------------------------
// ----------short code---------------
$(document).on("keyup", "#module_name", function () {
    let text = $(this).val().trim();

    if (text === "") {
        $("#module_code").val("");
        return;
    }

    let words = text.split(/\s+/);
    let code = "";

    words.forEach((word) => {
        code += word.charAt(0).toUpperCase();
    });

    $("#module_code").val(code);
});

$(document).on("submit", "#addformmodule", function (e) {
    e.preventDefault();

    // alert('111');

    // Clear previous errors
    $(".text-danger").addClass("d-none").text("");

    let formData = new FormData(this);

    $.ajax({
        // url: "{{ route('equipment.store') }}",

        url: BASE_URL + "/admin/formmodule/storemodule",
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

            // location.reload();

            // Close modal
            $("#addmoduleFormModal").modal("hide");

            // Reset form
            $("#addformmodule")[0].reset();

            // Remove "No records found" row if exists
            $("#style-3 tbody tr.text-muted").remove();

            let rowCount = $("#style-3 tbody tr").length + 1;

            let statusBadge =
                res.data.status == 1
                    ? `<span class="badge outline-badge-success">Active</span>`
                    : `<span class="badge outline-badge-danger">Inactive</span>`;

            let newRow = `
                    <tr>
                        <td class="text-center">${rowCount}</td>
                        
                        <td>${res.data.module_name}</td>
                        <td>${res.data.module_code}</td>

                        <td class="text-center">${res.data.created_at}</td>
                        
                    </tr>
                `;

            $("#style-3 tbody").append(newRow);
        },

        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                if (errors.module_name) {
                    $(".error-cer_val")
                        .removeClass("d-none")
                        .text(errors.module_name[0]);
                }

                if (errors.module_code) {
                    $(".error-cer_code")
                        .removeClass("d-none")
                        .text(errors.module_code[0]);
                }
            } else {
                Swal.fire("Error", "Something went wrong", "error");
            }
        },
    });
});


// --------------generate route-------------

$(document).ready(function(){

    function generateFilePath(){

        let licenceText = $("#cert_license_id option:selected").text();
        let applType = $("#appl_type").val();

        // Get module_code from selected option
        let moduleCode = $("#form_module option:selected").data("code");

        // 🔥 Store into hidden input
        $("#module_code").val(moduleCode ?? "");

        if(!licenceText || !applType || !moduleCode) return;

        // Licence short code mapping
        let licenceMap = {
            "Electrical Contractor Licence Grade A": "EA",
            "Electrical Contractor Licence Grade B": "EB",
            "Electrical Contractor Licence Grade Super A": "ESA",
            "Electrical Contractor Licence Grade Super B": "ESB"
        };

        let licenceShort = licenceMap[licenceText] ?? "";

        if(!licenceShort) return;

        let applText = applType === "N" 
            ? "New_applications" 
            : "Renewal_applications";

        let tempPath = `uploads/temp/${licenceShort}/${applText}/${moduleCode}/`;
        let proPath  = `uploads/prod/${licenceShort}/${applText}/${moduleCode}/`;

        $("#filepath_temp").val(tempPath);
        $("#filepath_pro").val(proPath);
    }

    $("#cert_license_id, #appl_type, #form_module")
        .on("change", generateFilePath);

});


// ---------------------------------------------------------------

// ----------------filepath--------------------------------
$(document).on("submit", "#addfilepath", function (e) {
    e.preventDefault();

    // alert('111');

    // Clear previous errors
    $(".text-danger").addClass("d-none").text("");

    let formData = new FormData(this);

    $.ajax({
        // url: "{{ route('equipment.store') }}",

        url: BASE_URL + "/admin/formmodule/storepath",
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
                timer: 1500,
                showConfirmButton: false,
            });

            // Close modal correctly
            $("#addFormModal").modal("hide");

            // Reset form
            $("#addfilepath")[0].reset();

            // Remove "No records found" row if exists
            $("#style-3 tbody tr.text-muted").remove();

            let rowCount = $("#style-3 tbody tr").length + 1;

            let statusBadge =
                res.data.status == 1
                    ? `<span class="badge outline-badge-success">Active</span>`
                    : `<span class="badge outline-badge-danger">Inactive</span>`;

            let newRow = `
        <tr>
            <td class="text-center">${rowCount}</td>
            <td>${res.data.licence_name}</td>
            <td>${res.data.appl_type}</td>
            <td>${res.data.form_module}</td>
            <td>${res.data.filepath_temp}</td>
            <td>${res.data.filepath_pro}</td>
            <td class="text-center">${res.data.created_at}</td>
            <td class="text-center">${statusBadge}</td>
            <td class="text-center">
                <label class="switch">
                    <input type="checkbox"
                        class="equip-status-toggle"
                        data-id="${res.data.id}"
                        ${res.data.status == 1 ? "checked" : ""}>
                    <span class="slider round"></span>
                </label>
            </td>
        </tr>
    `;

            $("#style-3 tbody").append(newRow);
        },

        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                if (errors.cert_license_id) {
                    $(".error-cert_license_id")
                        .removeClass("d-none")
                        .text(errors.cert_license_id[0]);
                }

                if (errors.appl_type) {
                    $(".error-appl_type")
                        .removeClass("d-none")
                        .text(errors.appl_type[0]);
                }

                if (errors.form_module) {
                    $(".error-form_module")
                        .removeClass("d-none")
                        .text(errors.form_module[0]);
                }

                if (errors.filepath_temp) {
                    $(".error-filepath_temp")
                        .removeClass("d-none")
                        .text(errors.filepath_temp[0]);
                }

                if (errors.filepath_pro) {
                    $(".error-filepath_pro")
                        .removeClass("d-none")
                        .text(errors.filepath_pro[0]);
                }
            } else {
                Swal.fire("Error", "Something went wrong", "error");
            }
        },
    });
});

// ---------------------------------------------------------------

$(document).on("change", ".equip-status-toggle", function () {
    let checkbox = $(this);
    let equipId = checkbox.data("id");
    let status = checkbox.is(":checked") ? 1 : 0;

    // 🔴 Ask confirmation ONLY when inactivating
    if (status === 0) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to inactivate this equipment?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Inactivate",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(equipId, status, checkbox);
            } else {
                // ❌ revert toggle
                checkbox.prop("checked", true);
            }
        });
    } else {
        // 🟢 Activate directly (no confirmation)
        updateStatus(equipId, status, checkbox);
    }
});

function updateStatus(equipId, status, checkbox) {
    $.ajax({
        url: BASE_URL + "/admin/equipment/updateStatus",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: equipId,
            status: status,
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Updated",
                text: response.message,
                timer: 1500,
                showConfirmButton: false,
            });

            // 🔄 Update badge instantly
            let badge = checkbox.closest("tr").find(".badge");

            if (status === 1) {
                badge
                    .removeClass("outline-badge-danger")
                    .addClass("outline-badge-success")
                    .text("Active");
            } else {
                badge
                    .removeClass("outline-badge-success")
                    .addClass("outline-badge-danger")
                    .text("Inactive");
            }
        },
        error: function () {
            Swal.fire("Error", "Unable to update status", "error");

            // rollback toggle on error
            checkbox.prop("checked", !status);
        },
    });
}

// ---------update filepath status------------------------------

$(document).on("change", ".filepath-status-toggle", function () {
    // alert('updateStatusfilepath');
    let checkbox = $(this);
    let fileId = checkbox.data("id");
    let status = checkbox.is(":checked") ? 1 : 0;

    if (status === 0) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to inactivate this Filepath?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Inactivate",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatusfilepath(fileId, status, checkbox);
            } else {
                checkbox.prop("checked", true);
            }
        });
    } else {
        updateStatusfilepath(fileId, status, checkbox);
    }
});

function updateStatusfilepath(fileId, status, checkbox) {
    // alert('updateStatusfilepath');
    $.ajax({
        url: BASE_URL + "/admin/formmodule/updateStatus",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: fileId,
            status: status,
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Updated",
                text: response.message,
                timer: 1500,
                showConfirmButton: false,
            });

            // 🔄 Update badge instantly
            let badge = checkbox.closest("tr").find(".badge");

            if (status === 1) {
                badge
                    .removeClass("outline-badge-danger")
                    .addClass("outline-badge-success")
                    .text("Active");
            } else {
                badge
                    .removeClass("outline-badge-success")
                    .addClass("outline-badge-danger")
                    .text("Inactive");
            }
        },
        error: function () {
            Swal.fire("Error", "Unable to update status", "error");

            // rollback toggle on error
            checkbox.prop("checked", !status);
        },
    });
}

// --------------------------------------------------------------------------------------

// ---------update formodule status------------------------------

$(document).on("change", ".formodule-status-toggle", function () {
    // alert('updateStatusfilepath');
    let checkbox = $(this);
    let fileId = checkbox.data("id");
    let status = checkbox.is(":checked") ? 1 : 0;

    if (status === 0) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to inactivate this Form Module?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Inactivate",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatusformmodule(fileId, status, checkbox);
            } else {
                checkbox.prop("checked", true);
            }
        });
    } else {
        updateStatusformmodule(fileId, status, checkbox);
    }
});

function updateStatusformmodule(fileId, status, checkbox) {
    // alert('updateStatusfilepath');
    $.ajax({
        url: BASE_URL + "/admin/formmodulestatus/updateStatus",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: fileId,
            status: status,
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Updated",
                text: response.message,
                timer: 1500,
                showConfirmButton: false,
            });

            // 🔄 Update badge instantly
            let badge = checkbox.closest("tr").find(".badge");

            if (status === 1) {
                badge
                    .removeClass("outline-badge-danger")
                    .addClass("outline-badge-success")
                    .text("Active");
            } else {
                badge
                    .removeClass("outline-badge-success")
                    .addClass("outline-badge-danger")
                    .text("Inactive");
            }
        },
        error: function () {
            Swal.fire("Error", "Unable to update status", "error");

            // rollback toggle on error
            checkbox.prop("checked", !status);
        },
    });
}

// --------------------------------------------------------------------------------------

$(document).ready(function () {
    $(".licenseFilter").each(function () {
        let filter = $(this);
        let tableId = filter.data("table");
        let tableElement = $("#" + tableId);

        // ✅ Prevent DataTable reinitialisation
        let table;
        if ($.fn.DataTable.isDataTable(tableElement)) {
            table = tableElement.DataTable();
        } else {
            table = tableElement.DataTable({
                pageLength: 10,
            });
        }

        // Column index of "Certificate Name / Form Name"
        let licenseColumn = table.column(1);
        let licenses = [];

        // Collect unique licence names
        licenseColumn.data().each(function (value) {
            let licenceName = value.split("/")[0].trim();
            if (!licenses.includes(licenceName)) {
                licenses.push(licenceName);
            }
        });

        // Populate dropdown
        licenses.sort().forEach(function (licence) {
            filter.append(`<option value="${licence}">${licence}</option>`);
        });

        // Filter on change
        filter.on("change", function () {
            let selected = $(this).val();

            if (selected) {
                licenseColumn.search(selected, true, false).draw();
            } else {
                licenseColumn.search("").draw();
            }
        });
    });
});
