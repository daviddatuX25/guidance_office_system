<?php
$terms = $db->readAll($table = 'application_term', $columns = ['id', 'academic_year', 'semester'],[],[],null);
$strands = $db->readAll($table = 'strands', $columns = ['id', 'name'],[],[],null);
$courses = $db->readAll($table = 'courses', $columns = ['id', 'nickname'],[],[],null);
?>
<div class="container-fluid mt-4">
  <div class="mb-3">
      <label for="application_term" class="form-label">Enrollment Term: </label>
      <select class="form-select" id="application_term" name="application_term">
        <option value="">All terms...</option>
        <?php foreach ($terms as $term): ?>
          <option value="<?php echo htmlspecialchars($term['id']); ?>">
            <?php echo htmlspecialchars($term['academic_year'] . ' - ' . $term['semester']); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <small id="helpId" class="form-text text-muted">Select the academic term for enrollment.</small>
    </div>
  <div class="table-responsive w-80 mb-5">
      <table class="table table-striped table-hover" id="applicantTable">
          <thead>
              <tr>
                  <td><input id="checkAll" type="checkbox"></td>
                  <td>Applicant no.</td>
                  <td>Last Name</td>
                  <td>First Name</td>
                  <td>Middle Name</td>
                  <td>Sex</td>
                  <td>Strand</td>
                  <td>Preferred Course</td>
                  <td>Test Status</td>
                  <td></td>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
    </div>
    <button type="button" class="d-block d-md-none btn position-fixed bottom-0 end-0" data-bs-toggle="offcanvas" data-bs-target="#applicantButtons" style="z-index: 1050;">
        <i class="fas fa-chevron-up  fs-4"></i>
    </button>

    <div class="offcanvas offcanvas-bottom" data-bs-backdrop="false" id="applicantButtons">
      <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
        <div class="offcanvas-body">
          <div class="row mb-3 gy-1 gy-md-2 p-1 bg-white justify-content-center align-items-center">
            <button type="button" class="btn col-4 col-lg-2 col-md-3 col-sm-4 btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#addApplicantModal">
                <i class="fas fa-plus me-1"></i>Add
            </button>
            <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#multiDeleteApplicantModal">
                <i class="fas fa-trash me-1"></i>Delete
            </button>
            <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#printModal">
                <i class="fas fa-print me-1"></i>Print
            </button>
            <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#importApplicantsModal">
                <i class="fas fa-file-import me-1"></i>Import
            </button>
          </div>
       </div>
    </div>
  <!-- For Medium Screen Buttons -->
  <div class="d-none d-md-block row mb-3 gy-1 gy-md-2 position-sticky bottom-0 p-1 bg-white justify-content-center" style="z-index: 100;">
    <button type="button" class="btn col-4 col-lg-2 col-md-3 col-sm-4 btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#addApplicantModal">
        <i class="fas fa-plus me-1"></i>Add
    </button>
    <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-danger mx-1" id="multiDeleteApplicantModalBtn">
        <i class="fas fa-trash me-1"></i>Delete
    </button>
    <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#printModal">
        <i class="fas fa-print me-1"></i>Print
    </button>
    <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#importApplicantsModal">
        <i class="fas fa-file-import me-1"></i>Import
    </button>
  </div>
</div>


<!-- View Applicant Modal -->
<div class="modal fade" id="viewApplicantModal" tabindex="-1" aria-labelledby="viewApplicantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewApplicantModalLabel">View Applicant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Applicant no.</label>
                    <p class="form-control-plaintext text-primary" id="viewApplicantNo"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label">Application Term</label>
                    <p class="form-control-plaintext text-primary" id="viewApplicationTerm"></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Lastname</label>
                            <p class="form-control-plaintext text-primary " id="viewLastname"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Firstname</label>
                            <p class="form-control-plaintext text-primary" id="viewFirstname"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Middle name</label>
                            <p class="form-control-plaintext text-primary" id="viewMiddlename"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Suffix</label>
                            <p class="form-control-plaintext text-primary" id="viewSuffix"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sex</label>
                            <p class="form-control-plaintext text-primary" id="viewSex"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Strand</label>
                            <p class="form-control-plaintext text-primary" id="viewStrand"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">1st Preferred Course</label>
                            <p class="form-control-plaintext text-primary" id="viewCourse1"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">2nd Preferred Course</label>
                            <p class="form-control-plaintext text-primary" id="viewCourse2"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">3rd Preferred Course</label>
                            <p class="form-control-plaintext text-primary" id="viewCourse3"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Applicant Modal -->
<div class="modal fade" id="addApplicantModal" tabindex="-1" aria-labelledby="applicantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applicantModalLabel">Add Applicant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addApplicantForm">
                    <div class="mb-3">
                        <label for="addApplicantNo" class="form-label">Applicant no.</label>
                        <input type="text" class="form-control" id="addApplicantNo" name="applicant_no" placeholder="Enter applicant number" required>
                    </div>
                    <div class="mb-3">
                        <label for="addApplicationTerm" class="form-label">Applicant Term</label>
                        <select class="form-select" id="addApplicationTerm" name="applicant_term_id" required>
                            <?php foreach ($terms as $term): ?>
                                <option value="<?php echo htmlspecialchars($term['id']); ?>">
                                    <?php echo htmlspecialchars($term['academic_year'] . ' - ' . $term['semester']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="addLastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="addLastname" name="lastname" placeholder="Enter last name" required>
                            </div>
                            <div class="mb-3">
                                <label for="addFirstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="addFirstname" name="firstname" placeholder="Enter first name" required>
                            </div>
                            <div class="mb-3">
                                <label for="addMiddlename" class="form-label">Middle name</label>
                                <input type="text" class="form-control" id="addMiddlename" name="middlename" placeholder="Enter middle name">
                            </div>
                            <div class="mb-3">
                                <label for="addSuffix" class="form-label">Suffix</label>
                                <input type="text" class="form-control" id="addSuffix" name="suffix" placeholder="Enter suffix">
                            </div>
                            <div class="mb-3">
                                <label for="addSex" class="form-label">Sex</label>
                                <select class="form-select" id="addSex" name="sex" required>
                                    <option value="" disabled selected>Choose...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="addStrand" class="form-label">Strand</label>
                                <select class="form-select" id="addStrand" name="strand_id" required>
                                    <option value="" disabled selected>Choose...</option>
                                    <?php foreach ($strands as $strand): ?>
                                        <option value="<?php echo $strand['id']; ?>"><?php echo htmlspecialchars($strand['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                          <div class="mb-3">
                              <label for="addCourse<?php echo $i; ?>" class="form-label"><?php echo $i . ($i === 1 ? 'st' : ($i === 2 ? 'nd' : 'rd')); ?> Preferred Course</label>
                              <select class="form-select" id="addCourse<?php echo $i; ?>" name="course_<?php echo $i; ?>_id" required>
                                <option value="" disabled selected>Choose...</option>
                                  <?php foreach ($courses as $course): ?>
                                      <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['nickname']); ?></option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                          <?php endfor; ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExamResultModal">Add w/ Exam Result</button>
                <button type="button" class="btn btn-primary" id="addApplicantBtn" >Add Applicant</button> 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Applicant Modal -->
<div class="modal fade" id="editApplicantModal" tabindex="-1" aria-labelledby="editApplicantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editApplicantModalLabel">Edit Applicant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editApplicantForm">
                    <input type="hidden" id="editApplicantId" name="applicant_id">
                    <div class="mb-3">
                        <label for="editApplicantNo" class="form-label">Applicant no.</label>
                        <input type="text" class="form-control" id="editApplicantNo" name="applicant_no" placeholder="Enter applicant number" required>
                    </div>
                    <div class="mb-3">
                        <label for="editApplicationTerm" class="form-label">Applicant Term</label>
                        <select class="form-select" id="editApplicationTerm" name="applicant_term_id" required>
                            <?php foreach ($terms as $term): ?>
                                <option value="<?php echo htmlspecialchars($term['id']); ?>">
                                    <?php echo htmlspecialchars($term['academic_year'] . ' - ' . $term['semester']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editLastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="editLastname" name="lastname" required>
                            </div>
                            <div class="mb-3">
                                <label for="editFirstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="editFirstname" name="firstname" required>
                            </div>
                            <div class="mb-3">
                                <label for="editMiddlename" class="form-label">Middle name</label>
                                <input type="text" class="form-control" id="editMiddlename" name="middlename">
                            </div>
                            <div class="mb-3">
                                <label for="editSuffix" class="form-label">Suffix</label>
                                <input type="text" class="form-control" id="editSuffix" name="suffix">
                            </div>
                            <div class="mb-3">
                                <label for="editSex" class="form-label">Sex</label>
                                <select class="form-select" id="editSex" name="sex" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editStrand" class="form-label">Strand</label>
                                <select class="form-select" id="editStrand" name="strand_id" required>
                                    <?php foreach ($strands as $strand): ?>
                                        <option value="<?php echo $strand['id']; ?>"><?php echo htmlspecialchars($strand['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                            <div class="mb-3">
                            <label for="editCourse<?php echo $i; ?>" class="form-label"><?php echo $i . ($i === 1 ? 'st' : ($i === 2 ? 'nd' : 'rd')); ?> Preferred Course</label>
                            <select class="form-select" id="editCourse<?php echo $i; ?>" name="course_<?php echo $i; ?>_id" required>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['nickname']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="editApplicantBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Single Delete Modal -->
<div class="modal fade" id="singleDeleteApplicantModal" tabindex="-1" aria-labelledby="singleDeleteApplicantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="singleDeleteApplicantModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete: </p>
                <input type="hidden" name="applicant_id" id="singleDeleteApplicantId" value="">
                <p><strong>Applicant name:</strong> <span class="text-danger" id="singleDeleteApplicantName"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="singleDeleteApplicantBtn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Multi Delete Modal -->
<div class="modal fade" id="multiDeleteApplicantModal" tabindex="-1" aria-labelledby="multiDeleteApplicantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="multiDeleteApplicantModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete (<span style="font-weight:bolder" id="multiDeleteApplicantCount"></span> record/s) </p>
                <div class="list-group" id="multiDeleteApplicantElements">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="multiDeleteApplicantBtn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>


<!-- Import Records Modal -->
<div class="modal fade" id="importApplicantsModal" tabindex="-1" aria-labelledby="importApplicantsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importApplicantsModalLabel">Import Applicants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Application Term Selection -->
                <div class="mb-3">
                    <label for="importApplicationTermId" class="form-label">Application Term</label>
                    <select class="form-select" id="importApplicationTermId" name="application_term_id" required>
                        <option value="" disabled selected>Select Application Term</option>
                        <?php foreach ($terms as $term): ?>
                            <option value="<?php echo htmlspecialchars($term['id']); ?>">
                                <?php echo htmlspecialchars($term['academic_year'] . ' - ' . $term['semester']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- File Upload -->
                <div class="mb-3">
                    <label for="importFile" class="form-label">Upload CSV or Excel File</label>
                    <input class="form-control" type="file" id="importFile" name="import_file" accept=".csv, .xlsx, .xls" required>
                </div>

                <!-- Header and Data Row Specification -->
                <div class="row">
                    <div class="col-md-6">
                        <label for="importHeaderRowNo" class="form-label">Header Row Number</label>
                        <input type="number" class="form-control" id="importHeaderRowNo" name="header_row_number" value="1" min="1" required>
                    </div>
                    <div class="col-md-6">
                        <label for="importDataRowStart" class="form-label">Data Row Start</label>
                        <input type="number" class="form-control" id="importDataRowStart" name="data_row_start" value="2" min="2" required>
                    </div>
                </div>

                <hr>

                <!-- Matching Headers Section -->
                <h6>Matching Headers</h6>
                <p class="text-muted small">Map the columns from your file to the expected headers.</p>
                <div id="importFieldsContainer">
                </div>

                <hr>

                <h6>Expected Headers and Sample Data Preview</h6>
                <div class="importSamplesContainer">

                </div>
                <div class="d-flex justify-content-around align-items-center mb-3">
                    <button type="button" class="btn btn-secondary" id="prevSampleBtn" disabled>Previous</button>
                    <button type="button" class="btn btn-secondary" id="nextSampleBtn">Next</button>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="testImportButton">Test</button>
                <button type="submit" class="btn btn-success" id="importButton" disabled>Import</button>
            </div>
        </div>
    </div>
</div>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="printOptionsForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Print Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="printReportType" class="form-label">Report Type</label>
                        <select class="form-select" id="printReportType" name="report_type">
                            <option value="summary" selected>Summary</option>
                            <option value="ranges">Ranges</option>
                            <option value="template">Template</option>
                        </select>
                    </div>
                    <div id="printPreviewArea" class="border p-2" style="min-height: 100px;">
                        <p class="text-muted text-center">Print Content Area / Preview</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="executePrint()">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
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

// Import
// Load fields
let applicantFields = [];
$(document).ready(function () {
    // load the fields for the import modal
    // action is load_import_fields
    $.ajax({
        url: 'server/icat/applicant_info.php',
        type: 'GET',
        data: { action: 'load_import_fields' },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const fields = response.fields;
                let fieldHtml = '';
                fields.forEach(function (field) {
                    applicantFields.push(field)
                    fieldHtml += `
                        <div class="mb-2 row">
                            <label class="col-sm-5 col-form-label col-form-label-sm">${field.fieldName}:</label>
                            <div class="col-sm-7">
                                <select class="import-metadata form-select form-select-sm" id="${field.fieldId}">
                                    <option value="">None</option>
                                    <!-- Options will be dynamically populated after file upload -->
                                </select>
                            </div>
                        </div>
                    `;
                });
                $('#importFieldsContainer').html(fieldHtml); // Append the generated HTML to the container
            } else {
                showNotification('error','Failed to load import fields.');
            }
        },
        error: function () {
            showNotification('error','An error occurred while loading import fields.');
        }
    });
});

// Load headers data
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

// Display samples data
let samples = [];
function displaySample(_samples = [], $sampleIndex) {
    if (_samples.length !== 0) {
        samples = _samples; // Store the samples in the global variable
    }
    let sampleHtml = '';
    // use jquery
    samples.forEach(function (sample, sampleIndex) {
        sampleHtml += `
            <div id="sample${sampleIndex}" class="mb-3">
                <h6>Draft ${sampleIndex + 1}</h6>
        `;
        sample.forEach(function (field, fieldIndex) {
            const fieldName = field.fieldName;
            const fieldId = field.fieldId;
            const placeholder = field.placeholder;
            const value = field.data || '';
            const error = field.error || '';
            sampleHtml += `
                <div class="mb-3">
                    <label for="${fieldId}" class="form-label">${fieldName}</label>
                    <input type="text" class="form-control" name="${fieldName}" value="${value}" placeholder="${placeholder}" required>
                    ${error ? `<span class="text-danger small">${error}</span>` : ''}
                </div>
            `;
        });
        sampleHtml += `
                <button type="button" class="btn btn-danger remove-sample" data-index="${sampleIndex}">Remove</button>
            </div>
        `;
    });
    $('#importSamplesContainer').html(sampleHtml); // Append the generated HTML to the container
    $('#importSamplesCount').text(samples.length); // Update the count of samples
}
  

// Load the samples data
$('#testImportButton').on('click', function() {
    const formData = new FormData();
    formData.append('action', 'import_samples');
    formData.append('import_file', $('#importFile')[0].files[0]);
    formData.append('data_row_start', parseInt($('#importDataRowStart').val()));
    // Applicant fields and their value of the selected header
    applicantFieldsWithValue = [];
    applicantFields.forEach(function (field) {
        const selectedHeader = $(`#${field.fieldId}`).val();
        if (selectedHeader) {
            applicantFieldsWithValue.push({ fieldName: field.fieldName, fieldId: field.fieldId, headerIndex: selectedHeader });
        }
    });
    formData.append('applicant_fields', JSON.stringify(applicantFieldsWithValue));
    // Load existing samples from input fieldsif updated jquery
    if (samples.length !== 0) {
        let existingSamples = [];
        samples.forEach(function (sample, sampleIndex) {
            let sampleData = [];
            sample.forEach(function (field, fieldIndex) {
                const fieldName = field.fieldName;
                const fieldId = field.fieldId;
                const value = $(`#${fieldId}`).val();
                sampleData.push({ fieldName, fieldId, value });
            });
            existingSamples.push(sampleData);
        });
        formData.append('existing_samples', JSON.stringify(existingSamples)); // Append the samples data to the form data
    }
    // Send AJAX request to fetch samples
    $.ajax({
        url: 'server/icat/applicant_info.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success) {
                displaySample(response.samples, 0); // Display the samples in the modal
                showNotification('success','Samples loaded successfully!');
            } else {
                showNotification('error','Failed to load samples. Please check the file and try again.');
            }
        },
        error: function () {
            showNotification('error','An error occurred while loading samples.');
        }
    });

});
</script>