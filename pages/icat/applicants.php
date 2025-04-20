<?php
require_once 'server/db.php'; 

$db = new Database();
$db->getConnection();

// Fetch all terms from the application_term table
$sql = "SELECT id, academic_year, semester FROM application_term ORDER BY academic_year DESC, semester";
$stmt = $db->query($sql);
$terms = $db->fetchAll($stmt);
?>

<div class="mb-3">
    <label for="application_term" class="form-label">Enrollment Term: </label>
    <select class="form-select" id="application_term" name="application_term" aria-label="Select enrollment term">
        <option value="">All</option>
        <?php foreach ($terms as $term): ?>
            <option value="<?php echo htmlspecialchars($term['id']); ?>">
                <?php echo htmlspecialchars($term['academic_year'] . ' | ' . $term['semester']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <small id="helpId" class="form-text text-muted">Select the academic term for enrollment.</small>
</div>
<div class="">
    <div class="table-responsive w-80">
        <table class="table table-striped table-hover" id="applicantTable">
            <thead>
                <tr>
                    <td></td>
                    <td colspan="6">Personal Information</td>
                    <td></td>
                    <td colspan="3">Preferred Course</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Applicant no.</td>
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
    <div class="d-flex flex-column flex-sm-row position-sticky bottom-0 p-1 bg-white justify-content-center" style="z-index: 100;">
        <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#applicantModal">
            <i class="fas fa-plus me-1"></i>Add
        </button>
        <button type="button" class="btn btn-danger mx-1" id="deleteApllicantButton" onclick="deleteApplicant()">
            <i class="fas fa-trash me-1"></i>Delete
        </button>
        <button type="button" class="btn btn-primary mx-1" id="generateButton" onclick="generate()">
            <i class="fas fa-gears me-1"></i>Generate
        </button>
        <button type="button" class="btn btn-primary mx-1" id="printButton" onclick="printX()">
            <i class="fas fa-print me-1"></i>Print
        </button>
        <button type="button" class="btn btn-success mx-1" id="exportRecordsButton" onclick="ExportRecords()">
            <i class="fas fa-file-export me-1"></i>Export
        </button>
        <button type="button" class="btn btn-primary mx-1" id="importRecordsButton" onclick="importRecords()">
            <i class="fas fa-file-import me-1"></i>Import
        </button>
    </div>
</div>
<!-- Modals -->
<!-- Add Participant Modal -->
<div class="modal fade" id="applicantModal" tabindex="-1" aria-labelledby="applicantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="applicantModalLabel">Add Applicant</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <!-- Applicant No. Field -->
          <div class="mb-3">
            <label for="applicantNo" class="form-label">Applicant no.</label>
            <input type="text" class="form-control" id="applicantNo" placeholder="Enter applicant number">
          </div>
          <!-- Two Columns for Personal Details and Additional Attributes -->
          <div class="row">
            <!-- Left Column: Personal Details -->
            <div class="col-md-6">
              <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" id="lastname" placeholder="Enter last name">
              </div>
              <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" id="firstname" placeholder="Enter first name">
              </div>
              <div class="mb-3">
                <label for="middlename" class="form-label">Middle name</label>
                <input type="text" class="form-control" id="middlename" placeholder="Enter middle name">
              </div>
            </div>
            <!-- Right Column: Additional Attributes -->
            <div class="col-md-6">
              <div class="mb-3">
                <label for="sex" class="form-label">Sex</label>
                <input type="text" class="form-control" id="sex" placeholder="Enter sex">
              </div>
              <div class="mb-3">
                <label for="strand" class="form-label">Strand</label>
                <input type="text" class="form-control" id="strand" placeholder="Enter strand">
              </div>
              <div class="mb-3">
                <label for="course" class="form-label">Course</label>
                <input type="text" class="form-control" id="course" placeholder="Enter course">
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#addExamResultModal"> Add w/ Exam Result </button>
          <button type="button" class="btn btn-primary">Add Applicant</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Exam Result -->
  <!-- Modal -->
  <div class="modal fade" id="addExamResultModal" tabindex="-1" aria-labelledby="addExamResultModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="addExamResultModalLabel">Add Exam Result</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <!-- Applicant Information -->
          <div class="mb-3">
            <label for="applicantNo" class="form-label">Applicant no.</label>
            <input type="text" class="form-control" id="applicantNo" value="002">
          </div>
          <div class="mb-3">
            <label for="applicantName" class="form-label">Applicant Name</label>
            <input type="text" class="form-control" id="applicantName" value="David Data Sarmiento" disabled>
          </div>

          <!-- Scores Section -->
          <h6>Scores</h6>
          <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
              <div class="mb-3">
                <label for="spatialA" class="form-label">Spatial A.</label>
                <input type="text" class="form-control" id="spatialA">
              </div>
              <div class="mb-3">
                <label for="perceptualA" class="form-label">Perceptual A.</label>
                <input type="text" class="form-control" id="perceptualA">
              </div>
            </div>
            <!-- Right Column -->
            <div class="col-md-6">
              <div class="mb-3">
                <label for="generalA" class="form-label">General A.</label>
                <input type="text" class="form-control" id="generalA">
              </div>
              <div class="mb-3">
                <label for="numericalA" class="form-label">Numerical A.</label>
                <input type="text" class="form-control" id="numericalA">
              </div>
              <div class="mb-3">
                <label for="manualD" class="form-label">Manual D.</label>
                <input type="text" class="form-control" id="manualD">
              </div>
              <div class="mb-3">
                <label for="verbalA" class="form-label">Verbal A.</label>
                <input type="text" class="form-control" id="verbalA">
              </div>
            </div>
          </div>

          <!-- Date Taken Section -->
          <div class="mb-3">
            <label for="dateTaken" class="form-label">Date Taken</label>
            <div class="d-flex align-items-center">
              <input type="date" class="form-control me-2" id="dateTaken">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="rememberDate">
                <label class="form-check-label" for="rememberDate">Remember</label>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Add Exam Result</button>
        </div>
      </div>
    </div>
  </div>

