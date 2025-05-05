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
<!-- <script>
function viewApplication(id) {
  console.log("View application with ID:", id);
}

function editApplication(id) {
  console.log("Edit application with ID:", id);
}

function deleteApplication(id) {
  console.log("Delete application with ID:", id);
}

function submitAddApplicant() {
  // Placeholder for AJAX submission
  console.log('Add applicant submitted');
}

function submitEditApplicant() {
    // Placeholder for AJAX submission
    console.log('Edit applicant submitted');
}

function submitAddExamResult() {
    // Placeholder for AJAX submission
    console.log('Add exam result submitted');
}

function submitDeleteApplicant() {
    // Placeholder for AJAX submission
    console.log('Delete applicant submitted');
}

function executePrint() {
    console.log('Print executed');
}
</script> -->