$(document).ready(function () {

    // Load current application term selected
    const $termSelect = $('#application_term');
    const savedTerm = localStorage.getItem('selectedEnrollmentTerm');
    if (savedTerm) {
        $termSelect.val(savedTerm);
        $('#addApplicantTerm').val(savedTerm);
    }

    // Handle change event
    $termSelect.change(function () {
        const selected = $(this).val();
        const saved = localStorage.getItem('selectedEnrollmentTerm');
        if (selected !== saved) {
            localStorage.setItem('selectedEnrollmentTerm', selected);
            table.ajax.reload(null, true);
            $('#addApplicantTerm').val(selected);
        }
    });

    // Initialize DataTable
    const table = $('#applicantTable').DataTable({
        processing: true,
        serverSide: true, // Enable server-side processing
        ajax: {
            url: 'server/icat/applicant_info.php', // Backend endpoint
            type: 'POST',
            data: function(d) {
                d.action = 'datatable'; // Add custom action parameter
                d.application_term = $termSelect.val(); // Pass additional parameters if needed
            },
            error: function(xhr) {
                console.error("AJAX Error:", xhr.responseText);
            }
        },
        columns: [
            {
                data: "application_id",
                render: function(data) {
                    return `<input type="checkbox" class="applicant-checkbox" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: "applicant_no" },
            { data: "lastname" },
            { data: "firstname" },
            { data: "middlename" },
            { data: "sex" },
            { data: "strand" },
            { data: "course_1" },
            { data: "test_status" },
            {
                data: "application_id",
                render: function(data) {
                    return `
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn p-0 border-0 bg-transparent view-applicant" data-id="${data}">
                                <i class="fa-solid fa-eye px-1"></i>
                            </button>
                            <button type="button" class="btn p-0 border-0 bg-transparent edit-applicant" data-id="${data}">
                                <i class="fa-solid fa-pen-to-square px-1"></i>
                            </button>
                            <button type="button" class="btn p-0 border-0 bg-transparent delete-applicant" data-id="${data}">
                                <i class="fa-solid fa-trash px-1"></i>
                            </button>
                        </div>
                    `;
                },
                orderable: false,
                searchable: false
            }
        ],
        scrollX: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100, { label: 'All', value: -1 }]
    }).on('draw', function () {
        // Update the checkbox state after each draw
        const allChecked = $('.applicant-checkbox:checked').length === $('.applicant-checkbox').length;
        $('#checkAll').prop('checked', allChecked);
    });
});


// Load applicant data into the modal for viewing
$(document).on('click', '.view-applicant', function () {
    const applicantId = $(this).data('id'); // Get the applicant ID from the button's data attribute
    $.ajax({
        url: 'server/icat/applicant_info.php',
        type: 'GET',
        data: { action: 'view', id: applicantId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const applicant = response.data;
                $('#viewApplicantNo').text(applicant.applicant_no);
                $('#viewApplicationTerm').text(applicant.application_term);
                $('#viewLastname').text(applicant.lastname);
                $('#viewFirstname').text(applicant.firstname);
                $('#viewMiddlename').text(applicant.middlename);
                $('#viewSuffix').val(applicant.suffix);
                $('#viewSex').text(applicant.sex);
                $('#viewStrand').text(applicant.strand);
                $('#viewCourse1').text(applicant.course_1);
                $('#viewCourse2').text(applicant.course_2);
                $('#viewCourse3').text(applicant.course_3);
                // Show the modal
                $('#viewApplicantModal').modal('show');
            } else {
                alert(response.error || 'Failed to fetch applicant details.');
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            alert('An error occurred while fetching applicant details.');
        }
    });
});

// Add new applicant
$(document).on('click', '#addApplicantBtn', function () {
    const formData = {
        action: 'add',
        applicant_no: $('#addApplicantNo').val(),
        application_term_id: $('#addApplicationTerm').val(),
        lastname: $('#addLastname').val(),
        firstname: $('#addFirstname').val(),
        middlename: $('#addMiddlename').val(),
        sex: $('#addSex').val(),
        suffix: $('#addSuffix').val(),
        strand_id: $('#addStrand').val(),
        course_1_id: $('#addCourse1').val(),
        course_2_id: $('#addCourse2').val(),
        course_3_id: $('#addCourse3').val()
    }
    $.ajax({
        url: 'server/icat/applicant_info.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            if (response.success) {
                showNotification('success','Applicant added successfully!');
                $('#addApplicantModal').modal('hide');
                $('#applicantTable').DataTable().ajax.reload(null, false); // Reload the DataTable without resetting pagination
            } else {
                showNotification('error', response.error ?? 'Failed to add applicant.');
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            showNotification('error','An error occurred while adding the applicant.');
        }
    });
});

var loadedApplicantData = [];
// Load Edit applicant data into the modal for editing
$(document).on('click', '.edit-applicant', function () {
    const applicantId = $(this).data('id'); // Get the applicant ID from the button's data attribute
    $.ajax({
        url: 'server/icat/applicant_info.php',
        type: 'GET',
        data: { action: 'view', id: applicantId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const applicant = response.data;
                loadedApplicantData = applicant; // Store the loaded applicant data in a global variable
                // Populate the view modal fields
                $('#editApplicantId').val(applicant.id);
                $('#editApplicantNo').val(applicant.applicant_no);
                $('#editApplicationTerm').val(applicant.application_term_id);
                $('#editLastname').val(applicant.lastname);
                $('#editFirstname').val(applicant.firstname);
                $('#editMiddlename').val(applicant.middlename);
                $('#editSuffix').val(applicant.suffix)
                $('#editSex').val(applicant.sex);
                $('#editStrand').val(applicant.strand_id);
                $('#editCourse1').val(applicant.course_1_id);
                $('#editCourse2').val(applicant.course_2_id);
                $('#editCourse3').val(applicant.course_3_id);
                // Show the modal
                $('#editApplicantModal').modal('show');
            } else {
                alert(response.error || 'Failed to fetch applicant details.');
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            alert('An error occurred while fetching applicant details.');
        }
    });
});

$(document).on('click', '#editApplicantBtn', function () {
    const formData = {
        action: 'edit',
        id: $('#editApplicantId').val(),
        applicant_no: $('#editApplicantNo').val(),
        application_term_id: $('#editApplicationTerm').val(),
        lastname: $('#editLastname').val(),
        firstname: $('#editFirstname').val(),
        middlename: $('#editMiddlename').val(),
        suffix: $('#editSuffix').val(),
        sex: $('#editSex').val(),
        strand_id: $('#editStrand').val(),
        course_1_id: $('#editCourse1').val(),
        course_2_id: $('#editCourse2').val(),
        course_3_id: $('#editCourse3').val()
    };
    const keysToCompare = ['applicant_no', 'application_term_id', 'lastname', 'firstname', 'middlename', 'suffix', 'strand_id', 'course_1_id', 'course_2_id', 'course_3_id'];
    if(keysToCompare.every(key => formData[key] == loadedApplicantData[key])){
        showNotification('error','No changes detected!');
        return;
    }
    
    $.ajax({
        url: 'server/icat/applicant_info.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            if (response.success) {
                showNotification('success','Applicant updated successfully!');
                $('#editApplicantModal').modal('hide');
                $('#applicantTable').DataTable().ajax.reload(null, false); // Reload the DataTable without resetting pagination
            } else {
                showNotification('error', response.error ?? 'Failed to update applicant.');
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            showNotification('error','An error occurred while updating the applicant.');
        }
    });
});

$(document).on('change', '#checkAll', function () {
    $('.applicant-checkbox').prop('checked', this.checked);
});

$(document).on('change', '.applicant-checkbox', function () {
    if (!this.checked) {
      $('#checkAll').prop('checked', false);
    } else if ($('.applicant-checkbox:checked').length === $('.applicant-checkbox').length) {
      $('#checkAll').prop('checked', true);
    }
});

$(document).on('click', '.delete-applicant', function () {
    $applicantID = $(this).data('id');
    $.ajax({
        url: 'server/icat/applicant_info.php',
        type: 'GET',
        data: { action: 'view', id: $applicantID },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const applicant = response.data;
                $('#singleDeleteApplicantNo').text(applicant.applicant_no);
                $('#singleDeleteApplicantName').text(`${applicant.lastname}, ${applicant.firstname} ${applicant.middlename}`);
                $('#singleDeleteApplicantId').val(applicant.id);
                $('#singleDeleteApplicantModal').modal('show');
            }
        }
    })
});

$(document).on('click', '#singleDeleteApplicantBtn', function () {
    const applicantId = $('#singleDeleteApplicantId').val();
    $.ajax({
        url: 'server/icat/applicant_info.php',
        type: 'POST',
        data: { action: 'delete_single', id: applicantId },
        success: function (response) {
            if (response.success) {
                showNotification('success','Applicant deleted successfully!');
                $('#singleDeleteApplicantModal').modal('hide');
                $('#applicantTable').DataTable().ajax.reload(null, false); // Reload the DataTable without resetting pagination
            } else {
                showNotification('error', response.error ?? 'Failed to delete applicant.');
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            showNotification('errpr','An error occurred while deleting the applicant.');
        }
    });
});

function unselectEditModalData(id) {
    const element = $(`.toBeDeleted[data-id="${id}"]`);
    if (element.length) {
        element.remove(); // Remove the selected applicant from the modal
        const selectedIds = $('.toBeDeleted').map(function () {
            return $(this).data('id');
        }).get(); // Get all selected IDs
        $('#multiDeleteApplicantCount').text(selectedIds.length);
        $('.applicant-checkbox[value="'+ id +'"]').prop('checked', false); // Uncheck the checkbox in the main table
    }
}

$(document).on('click', '#multiDeleteApplicantModalBtn', function () {
    $('#multiDeleteApplicantElements').html('');
    selectedIds = $('.applicant-checkbox:checked').map(function () {
        return $(this).val();
    }).get(); // Get all selected IDs

    if (selectedIds.length === 0) {
        showNotification('error','Please select at least one applicant to delete.');
        return;
    }

    $.ajax({
        url: 'server/icat/applicant_info.php',
        type: 'GET',
        data: { action: 'view_multi', ids: selectedIds },
        success: function (response) {
            if (response.success) {
                const applicants = response.data;
                let applicantElements = '';
                applicants.forEach(function (applicant) {
                    applicantElements += `
                        <div class="list-group-item d-flex justify-content-between align-items-center toBeDeleted" data-id="${applicant.id}">
                            <span>${applicant.lastname}, ${applicant.firstname} ${applicant.middlename}</span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="unselectEditModalData(${applicant.id})">Unselect</button>
                        </div>
                    `;
                });
                $('#multiDeleteApplicantElements').html(applicantElements);
                $('#multiDeleteApplicantCount').text(applicants.length);
                $('#multiDeleteApplicantModal').modal('show');
            } else {
                showNotification('error','Could not fetch applicant details.');
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            showNotification('error','Something went wrong!');
        }
    });
   
});

$(document).on('click', '#multiDeleteApplicantBtn', function () {
    const selectedIds = $('.toBeDeleted').map(function () {
        return $(this).data('id');
    }).get(); // Get all selected IDs

    if (selectedIds.length === 0) {
        showNotification('error','Please select at least one applicant to delete.');
        $('#multiDeleteApplicantModal').modal('hide');
        return;
    }

    $.ajax({
        url: 'server/icat/applicant_info.php',
        type: 'POST',
        data: { action: 'delete_multi', ids: selectedIds },
        success: function (response) {
            if (response.success) {
                showNotification('success','Selected applicants deleted successfully!');
                $('#applicantTable').DataTable().ajax.reload(null, false); // Reload the DataTable without resetting pagination
            } else {
                showNotification('error','Failed to delete selected applicants.');
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            alert('An error occurred while deleting the applicants.');
        }
    });
});

// Impor
$('#importFile, #importHeaderRowNo').on('change', function () {
    const headerRowNumber = $('#importHeaderRowNo').val();
    const formData = new FormData();
    formData.append('action', 'import_samples_metadata');
    formData.append('header_row_number', headerRowNumber);
    formData.append('import_file', $('#importFile')[0].files[0]);

     // Clear dropdown options on failure
     $('.import-metadata.form-select').each(function () {
        $(this).empty().append('<option value="">None</option>');
    });
    
    // Send AJAX request to fetch headers
    $.ajax({
        url: 'server/icat/applicant_info.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success) {
                // Populate the matching header dropdowns
                $('.import-metadata.form-select').each(function () {
                    const select = $(this);
                    select.empty(); // Clear existing options
                    select.append('<option value="">None</option>'); // Add default option

                    // Add options from the encoded headers
                    response.headers.forEach(header => {
                        select.append(`<option value="${header.headerIndex}">${header.headerData}</option>`);
                    });
                });
                showNotification('success','Headers loaded successfully!');
            } else {
                showNotification('error','Failed to load headers. Please check the file and try again.');
            }
        },
        error: function () {
            showNotification('error','An error occurred while loading headers.');
        }
    });
});
  
  