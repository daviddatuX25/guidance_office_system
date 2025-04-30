    <div class="container mt-4">
        <h2>Exam Results Management</h2>
        <button type="button" class="btn btn-info mb-2" data-bs-toggle="modal" data-bs-target="#viewExamResultModal">
            View Exam Result
        </button>
        <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#editExamResultModal">
            Edit Exam Result
        </button>
        <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addExamResultsModal">
            Add Exam Result
        </button>
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addApplicantModal">
            Add Applicant
        </button>
        <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#importRecordsModal">
            Import Records
        </button>
        <button type="button" class="btn btn-light mb-2 border" data-bs-toggle="modal" data-bs-target="#printModal">
            Print
        </button>
        <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
            Delete Record
        </button>
    </div>

    <!-- View Exam Result Modal -->
    <div class="modal fade" id="viewExamResultModal" tabindex="-1" aria-labelledby="viewExamResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewExamResultModalLabel">View Exam Result Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Applicant No:</strong> <span id="viewApplicantNo"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Name:</strong> <span id="viewApplicantName"></span>
                        </div>
                    </div>
                    <hr>
                    <h6>Scores:</h6>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">General Ability</label>
                            <input type="number" class="form-control" id="viewGeneralAbility" readonly>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Verbal Aptitude</label>
                            <input type="number" class="form-control" id="viewVerbalAptitude" readonly>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Numerical Aptitude</label>
                            <input type="number" class="form-control" id="viewNumericalAptitude" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Spatial Aptitude</label>
                            <input type="number" class="form-control" id="viewSpatialAptitude" readonly>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Perceptual Aptitude</label>
                            <input type="number" class="form-control" id="viewPerceptualAptitude" readonly>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Manual Dexterity</label>
                            <input type="number" class="form-control" id="viewManualDexterity" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Date Taken</label>
                            <input type="date" class="form-control" id="viewDateTaken" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Exam Result Modal -->
    <div class="modal fade" id="editExamResultModal" tabindex="-1" aria-labelledby="editExamResultModalLabel" aria-hidden "true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editExamResultForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editExamResultModalLabel">Edit Exam Result</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editRecordId" name="record_id">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Applicant No:</strong> <span id="editApplicantNoDisplay"></span>
                                <input type="hidden" id="editApplicantNo" name="applicant_no">
                            </div>
                            <div class="col-md-6">
                                <strong>Name:</strong> <span id="editApplicantNameDisplay"></span>
                            </div>
                        </div>
                        <hr>
                        <h6>Scores:</h6>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="editGeneralAbility" class="form-label">General Ability</label>
                                <input type="number" class="form-control" id="editGeneralAbility" name="general_ability" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="editVerbalAptitude" class="form-label">Verbal Aptitude</label>
                                <input type="number" class="form-control" id="editVerbalAptitude" name="verbal_aptitude" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="editNumericalAptitude" class="form-label">Numerical Aptitude</label>
                                <input type="number" class="form-control" id="editNumericalAptitude" name="numerical_aptitude" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="editSpatialAptitude" class="form-label">Spatial Aptitude</label>
                                <input type="number" class="form-control" id="editSpatialAptitude" name="spatial_aptitude" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="editPerceptualAptitude" class="form-label">Perceptual Aptitude</label>
                                <input type="number" class="form-control" id="editPerceptualAptitude" name="perceptual_aptitude" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="editManualDexterity" class="form-label">Manual Dexterity</label>
                                <input type="number" class="form-control" id="editManualDexterity" name="manual_dexterity" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="editDateTaken" class="form-label">Date Taken</label>
                                <input type="date" class="form-control" id="editDateTaken" name="date_taken" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Exam Result Modal -->
    <div class="modal fade" id="addExamResultsModal" tabindex="-1" aria-labelledby="addExamResultModalLabel" aria-hidden="true">
        <div class="class modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addExamResultForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExamResultModalLabel">Add Exam Result</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="addApplicantNo" class="form-label">Applicant No</label>
                                <input type="text" class="form-control" id="addApplicantNo" name="applicant_no" required placeholder="Enter Applicant No">
                            </div>
                        </div>
                        <hr>
                        <h6>Scores:</h6>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="addGeneralAbility" class="form-label">General Ability</label>
                                <input type="number" class="form-control" id="addGeneralAbility" name="general_ability" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="addVerbalAptitude" class="form-label">Verbal Aptitude</label>
                                <input type="number" class="form-control" id="addVerbalAptitude" name="verbal_aptitude" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="addNumericalAptitude" class="form-label">Numerical Aptitude</label>
                                <input type="number" class="form-control" id="addNumericalAptitude" name="numerical_aptitude" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="addSpatialAptitude" class="form-label">Spatial Aptitude</label>
                                <input type="number" class="form-control" id="addSpatialAptitude" name="spatial_aptitude" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="addPerceptualAptitude" class="form-label">Perceptual Aptitude</label>
                                <input type="number" class="form-control" id="addPerceptualAptitude" name="perceptual_aptitude" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="addManualDexterity" class="form-label">Manual Dexterity</label>
                                <input type="number" class="form-control" id="addManualDexterity" name="manual_dexterity" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="addDateTaken" class="form-label">Date Taken</label>
                                <input type="date" class="form-control" id="addDateTaken" name="date_taken" required>
                            </div>
                        </div>
                    </div>
                    <div fellas="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Exam Result</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Applicant Modal (unchanged from original) -->
    <div class="modal fade" id="addApplicantModal" tabindex="-1" aria-labelledby="addApplicantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addApplicantForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addApplicantModalLabel">Add New Applicant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="addAppApplicantHN" class="form-label">Applicant HN</label>
                                <input type="text" class="form-control" id="addAppApplicantHN" name="applicant_hn" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="addAppLastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="addAppLastname" name="lastname" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="addAppFirstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="addAppFirstname" name="firstname" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="addAppMiddlename" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="addAppMiddlename" name="middlename">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="addAppSex" class="form-label">Sex</label>
                                <select class="form-select" id="addAppSex" name="sex" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="addAppStrand" class="form-label">Strand</label>
                                <input type="text" class="form-control" id="addAppStrand" name="strand">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="addAppCourse" class="form-label">Course</label>
                                <input type="text" class="form-control" id="addAppCourse" name="course">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Applicant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Records Modal (updated field names) -->
    <div class="modal fade" id="importRecordsModal" tabindex="-1" aria-labelledby="importRecordsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="importRecordsForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importRecordsModalLabel">Import Records from File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Upload CSV or Excel File</label>
                            <input class="form-control" type="file" id="csvFile" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Expected Headers</h6>
                                <ul class="list-group">
                                    <li class="list-group-item">Applicant No</li>
                                    <li class="list-group-item">General Ability</li>
                                    <li class="list-group-item">Verbal Aptitude</li>
                                    <li class="list-group-item">Numerical Aptitude</li>
                                    <li class="list-group-item">Spatial Aptitude</li>
                                    <li class="list-group-item">Perceptual Aptitude</li>
                                    <li class="list-group-item">Manual Dexterity</li>
                                    <li class="list-group-item">Date Taken</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Matching File Headers</h6>
                                <p class="text-muted small">Map the columns from your file to the expected headers.</p>
                                <div id="headerMappingArea">
                                    <div class="mb-2 row">
                                        <label class="col-sm-5 col-form-label col-form-label-sm">Applicant No:</label>
                                        <div class="col-sm-7">
                                            <select class="form-select form-select-sm" name="map_applicant_no">
                                                <option>Column A</option><option>Column B</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label class="col-sm-5 col-form-label col-form-label-sm">General Ability:</label>
                                        <div class="col-sm-7">
                                            <select class="form-select form-select-sm" name="map_general_ability">
                                                <option>Column A</option><option>Column B</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Add similar mappings for other fields -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal (unchanged) -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteRecordForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="deleteRecordIdInput" name="record_id">
                        Are you sure you want to delete this record? This action cannot be undone.
                        <div id="recordToDeleteDetails" class="mt-2 text-muted small"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Proceed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Print Modal (unchanged) -->
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
                        <button type="button" class="btn btn-primary" id="executePrintButton">Print</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Example: Setting data for the Edit Modal before showing it
        const editExamResultModal = document.getElementById('editExamResultModal');
        editExamResultModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const recordId = button.getAttribute('data-bs-record-id');
            const applicantNo = button.getAttribute('data-bs-applicant-no');
            const applicantName = button.getAttribute('data-bs-applicant-name');
            const modalTitle = editExamResultModal.querySelector('.modal-title');
            const applicantNoDisplay = editExamResultModal.querySelector('#editApplicantNoDisplay');
            const applicantNameDisplay = editExamResultModal.querySelector('#editApplicantNameDisplay');
            const recordIdInput = editExamResultModal.querySelector('#editRecordId');
            const applicantNoInput = editExamResultModal.querySelector('#editApplicantNo');

            modalTitle.textContent = `Edit Exam Result for ${applicantName}`;
            applicantNoDisplay.textContent = applicantNo;
            applicantNameDisplay.textContent = applicantName;
            recordIdInput.value = recordId;
            applicantNoInput.value = applicantNo;
        });

        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const recordId = button.getAttribute('data-bs-record-id');
            const recordInfo = button.getAttribute('data-bs-record-info') || 'this item';
            const recordIdInput = deleteModal.querySelector('#deleteRecordIdInput');
            const recordDetailsArea = deleteModal.querySelector('#recordToDeleteDetails');
            recordIdInput.value = recordId;
            recordDetailsArea.textContent = `Details: ${recordInfo} (ID: ${recordId})`;
        });
    </script>