function viewApplication(id) {
    // Popup window
    const viewModal = document.getElementById('viewApplicationModal')
    const bs_modal = new bootstrap.Modal(viewModal);
    bs_modal.show();

    // Get data relateds
    console.log("View application with ID:", id);
}

function editApplication(id) {
    console.log("Edit application with ID:", id);
}

function deleteApplication(id) {
    console.log("Delete application with ID:", id);
}

$(document).ready(function() {

    // Load the selected term from localStorage if available
    const selectedETerm = localStorage.getItem('selectedEnrollmentTerm');
    if (selectedETerm) {
        $('#application_term').val(selectedETerm);
    } else {
        $('#application_term').val('');
    }
        
    const table = $('#applicantTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: './server/icat/applicants.php',
            type: 'POST',
            data: function(d) {
                d.application_term = $('#application_term').val();
            },
            error: function(xhr, error, code) {
                console.error("AJAX Error:", xhr.responseText);
            }
        },
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<input type="checkbox" class="applicant-checkbox" value="${row.id}">`;
                }
            },
            { data: "applicant_no" },
            { data: "lastname" },
            { data: "firstname" },
            { data: "middlename" },
            { data: "suffix" },
            { data: "sex" },
            { data: "strand" },
            { data: "course_1" },
            { data: "course_2" },
            { data: "course_3" },
            { data: "test_status" },
            {
                data: "application_id",
                render: function(data, type, row) {
                    return `
                        <div class="d-flex justify-content-center">
                            <i class="fa-solid fa-eye px-1" onclick="viewApplication(${data})"></i>
                            <i class="fa-solid fa-pen-to-square px-1" onclick="editApplication(${data})"></i>
                            <i class="fa-solid fa-trash px-1" onclick="deleteApplication(${data})"></i>
                        </div>
                    `;
                },
                orderable: false,
                searchable: false
            }
        ],
        scrollX: true,
        fixedColumns: {
            leftColumns: 1
        },
        columnDefs: [
            { width: '30px', targets: 0 },  // Fixed pixel widths for consistency
            { width: '80px', targets: 1 },
            { width: '120px', targets: 2 },
            { width: '120px', targets: 3 },
            { width: '80px', targets: 4 },
            { width: '60px', targets: 5 },
            { width: '60px', targets: 6 },
            { width: '80px', targets: 7 },
            { width: '80px', targets: 8 },
            { width: '80px', targets: 9 },
            { width: '80px', targets: 10 },
            { width: '100px', targets: 11 },
            { width: '80px', targets: 12 }
        ],
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100, {label: 'All', value: -1}], 
        drawCallback: function(settings) {
            this.api().columns.adjust();
            if (this.api().responsive) {
                this.api().responsive.recalc();
            }
        }
    });

    // Renew the table when the term changes
    $('#application_term').change(function() {
        const selectedTermVal = $(this).val();
        localStorage.setItem('selectedEnrollmentTerm', selectedTermVal);
        // Reload the DataTable with the updated application_term
        table.ajax.reload(null, false); // Reload the data without resetting pagination
    });

    // Save the selected term to localStorage when it changes
    $('#application_term').on('change', function() {
        const selectedTermId = $(this).val();
        if (selectedTermId) {
            localStorage.setItem('selectedEnrollmentTerm', selectedTermId);
        } else {
            localStorage.removeItem('selectedEnrollmentTerm');
        }
    });




});