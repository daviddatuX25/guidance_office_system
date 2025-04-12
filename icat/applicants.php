<?php
require_once 'server/db.php'; 

$db = new Database();
$db->getConnection();

// Fetch all terms from the application_term table
$sql = "SELECT id, academic_year, semester FROM application_term ORDER BY academic_year DESC, semester";
$stmt = $db->query($sql);
$terms = $db->fetchAll($stmt);
?>

<div class="container">
<div class="container mt-4">
    <div class="mb-3">
        <label for="application_term" class="form-label">Enrollment Term: </label>
        <select class="form-select" id="application_term" name="application_term" aria-label="Select enrollment term">
            <option value="">Choose...</option>
            <?php foreach ($terms as $term): ?>
                <option value="<?php echo htmlspecialchars($term['id']); ?>">
                    <?php echo htmlspecialchars($term['academic_year'] . ' | ' . $term['semester']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small id="helpId" class="form-text text-muted">Select the academic term for enrollment.</small>
    </div>
    <table class="table table-stripped table-hover" id="applicantTable">
        <thead class="">
            <tr>
                <td></td>
                <td colspan="6" >Personal Information</td>
                <td></td>
                <td colspan="3" >Preferred Course</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Aplicant no.</td>
                <td>Last Name</td>
                <td>First Name</td>
                <td>Middle Name</td>
                <td>Suffix</td>
                <td>Sex</td>
                <td>Strand</td>
                <td>1st</td>
                <td>2nd</td>
                <td>3rd</td>
                <td>Test Status</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>

    function viewApplication(id) {
        // Implement view functionality here
        console.log("View application with ID:", id);
    }
    function editApplication(id) {
        // Implement edit functionality here
        console.log("Edit application with ID:", id);
    }
    function deleteApplication(id) {
        // Implement delete functionality here
        console.log("Delete application with ID:", id);
    }

// ----------------------------------------------------------
    $(document).ready(function() {
        $('#applicantTable').DataTable({
            processing: true,
            serverSide: false, // Disable server-side processing
            ajax: {
                url: './server/icat/applicants.php',
                type: 'POST',
                data: function(d) {
                    d.application_term = $('#application_term').val(); // Pass filter data
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
                { data: "applicant_no"},
                { data: "lastname"},
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
                            <div class="d-flex justify-content-center grid-gap-2">
                                <i class='fa-solid fa-eye' onclick='viewApplication(${data})'></i>
                                <i class='fa-solid fa-pen-to-square' onclick='editApplication(${data})'></i>
                                <i class='fa-solid fa-trash' onclick='deleteApplication(${data})'></i>
                            </div>
                        `;
                    },
                    orderable: false,
                    searchable: false
                }
            ],
            scrollX: true,
            columnDefs: [
                { width: '3%', targets: 0 },
                { width: '14%', targets: 1 },
                { width: '14%', targets: 2 },
                { width: '14%', targets: 3 },
                { width: '6%', targets: 4 },
                { width: '8%', targets: 5 },
                { width: '8%', targets: 6 },
                { width: '8%', targets: 7 },
                { width: '8%', targets: 8 },
                { width: '6%', targets: 9 },
                { width: '16%', targets: 10 },
                { width: '30%', targets: 11 }
            ]
        });

        // Reload table on filter change
        $('#application_term').on('change', function() {
            $('#applicantTable').DataTable().ajax.reload();
        });

        // Enrollment Term Change Event
        const $enrollmentTermSelect = $('#application_term');

        // Load the last selected term from localStorage
        const lastSelectedTerm = localStorage.getItem('selectedEnrollmentTerm');
        if (lastSelectedTerm) {
            $enrollmentTermSelect.val(lastSelectedTerm);
        }

        // Save the selected term to localStorage when it changes
        $enrollmentTermSelect.on('change', function() {
            const selectedTermId = $(this).val();
            if (selectedTermId) {
                localStorage.setItem('selectedEnrollmentTerm', selectedTermId);
            } else {
                localStorage.removeItem('selectedEnrollmentTerm');
            }
        });
    });

</script>