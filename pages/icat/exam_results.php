<?php
$terms = $db->readAll('application_term', ['id', 'academic_year', 'semester']);
?>
    <div class="container-fluid mt-4">
        <div class="mb-3">
            <label for="exam_results_application_term" class="form-label">Enrollment Term:</label>
            <select class="form-select" id="exam_results_application_term" name="application_term">
                <option value="">All terms...</option>
                <?php foreach ($terms as $term): ?>
                    <option value="<?php echo htmlspecialchars($term['id']); ?>">
                        <?php echo htmlspecialchars($term['academic_year'] . ' - ' . $term['semester']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Select the academic term for exam results.</small>
        </div>
        <div class="table-responsive mb-5">
            <table class="table table-striped table-hover" id="examResultsTable">
                <thead>
                    <tr>
                        <th><input class="check-all" type="checkbox"></th>
                        <th>Applicant No.</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Date Taken</th>
                        <th>General</th>
                        <th>Verbal</th>
                        <th>Numerical</th>
                        <th>Spatial</th>
                        <th>Perceptual</th>
                        <th>Manual</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="d-none d-md-block row mb-3 gy-1 gy-md-2 position-sticky bottom-0 p-1 bg-white justify-content-center" style="z-index: 100;">
            <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#addExamResultModal">
                <i class="fas fa-plus me-1"></i>Add
            </button>
            <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-danger mx-1 multi-delete-exam-result">
                <i class="fas fa-trash me-1"></i>Delete
            </button>
            <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#printModal">
                <i class="fas fa-print me-1"></i>Print
            </button>
            <button type="button" class="btn col-4 col-lg-2 col-md-3 btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#importExamResultsModal">
                <i class="fas fa-file-import me-1"></i>Import
            </button>
        </div>
    </div>

    <!-- View Exam Result Modal -->
    <div class="modal fade" id="viewExamResultModal" tabindex="-1" aria-labelledby="viewExamResultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewExamResultModalLabel">View Exam Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Applicant No.</label>
                        <p class="form-control-plaintext text-primary view-applicant-no"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Applicant Name</label>
                        <p class="form-control-plaintext text-primary view-applicant-name"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Application Term</label>
                        <p class="form-control-plaintext text-primary view-application-term"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date Taken</label>
                        <p class="form-control-plaintext text-primary view-date-taken"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">General Ability</label>
                                <p class="form-control-plaintext text-primary view-general-ability"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Verbal Aptitude</label>
                                <p class="form-control-plaintext text-primary view-verbal-aptitude"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Numerical Aptitude</label>
                                <p class="form-control-plaintext text-primary view-numerical-aptitude"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Spatial Aptitude</label>
                                <p class="form-control-plaintext text-primary view-spatial-aptitude"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Perceptual Aptitude</label>
                                <p class="form-control-plaintext text-primary view-perceptual-aptitude"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Manual Dexterity</label>
                                <p class="form-control-plaintext text-primary view-manual-dexterity"></p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <p class="form-control-plaintext text-primary view-remarks"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Exam Result Modal -->
    <div class="modal fade" id="addExamResultModal" tabindex="-1" aria-labelledby="addExamResultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamResultModalLabel">Add Exam Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="add-exam-result-form">
                        <div class="mb-3">
                            <label for="add_applicant_no" class="form-label">Applicant No.</label>
                            <input type="text" class="form-control" name="applicant_no" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_date_taken" class="form-label">Date Taken</label>
                            <input type="date" class="form-control" name="date_taken" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="add_general_ability" class="form-label">General Ability</label>
                                    <input type="number" class="form-control" name="general_ability" min="0" max="255" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_verbal_aptitude" class="form-label">Verbal Aptitude</label>
                                    <input type="number" class="form-control" name="verbal_aptitude" min="0" max="255" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_numerical_aptitude" class="form-label">Numerical Aptitude</label>
                                    <input type="number" class="form-control" name="numerical_aptitude" min="0" max="255" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="add_spatial_aptitude" class="form-label">Spatial Aptitude</label>
                                    <input type="number" class="form-control" name="spatial_aptitude" min="0" max="255" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_perceptual_aptitude" class="form-label">Perceptual Aptitude</label>
                                    <input type="number" class="form-control" name="perceptual_aptitude" min="0" max="255" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_manual_dexterity" class="form-label">Manual Dexterity</label>
                                    <input type="number" class="form-control" name="manual_dexterity" min="0" max="255" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="add_remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary add-exam-result-btn">Add Exam Result</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Exam Result Modal -->
    <div class="modal fade" id="editExamResultModal" tabindex="-1" aria-labelledby="editExamResultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExamResultModalLabel">Edit Exam Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="edit-exam-result-form">
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label for="edit_applicant_no" class="form-label">Applicant No.</label>
                            <input type="text" class="form-control" name="applicant_no" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_date_taken" class="form-label">Date Taken</label>
                            <input type="date" class="form-control" name="date_taken" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_general_ability" class="form-label">General Ability</label>
                                    <input type="number" class="form-control" name="general_ability" min="0" max="255" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_verbal_aptitude" class="form-label">Verbal Aptitude</label>
                                    <input type="number" class="form-control" name="verbal_aptitude" min="0" max="255" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_numerical_aptitude" class="form-label">Numerical Aptitude</label>
                                    <input type="number" class="form-control" name="numerical_aptitude" min="0" max="255" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_spatial_aptitude" class="form-label">Spatial Aptitude</label>
                                    <input type="number" class="form-control" name="spatial_aptitude" min="0" max="255" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_perceptual_aptitude" class="form-label">Perceptual Aptitude</label>
                                    <input type="number" class="form-control" name="perceptual_aptitude" min="0" max="255" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_manual_dexterity" class="form-label">Manual Dexterity</label>
                                    <input type="number" class="form-control" name="manual_dexterity" min="0" max="255" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary edit-exam-result-btn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Single Delete Modal -->
    <div class="modal fade" id="singleDeleteExamResultModal" tabindex="-1" aria-labelledby="singleDeleteExamResultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="singleDeleteExamResultModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete:</p>
                    <input type="hidden" class="single-delete-exam-result-id">
                    <p><strong>Applicant No.:</strong> <span class="text-danger single-delete-applicant-no"></span></p>
                    <p><strong>Applicant Name:</strong> <span class="text-danger single-delete-applicant-name"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger single-delete-exam-result-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi Delete Modal -->
    <div class="modal fade" id="multiDeleteExamResultModal" tabindex="-1" aria-labelledby="multiDeleteExamResultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="multiDeleteExamResultModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete (<span style="font-weight:bolder" class="multi-delete-exam-result-count"></span> record/s)</p>
                    <div class="list-group multi-delete-exam-result-elements"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger multi-delete-exam-result-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Exam Results Modal -->
    <div class="modal fade" id="importExamResultsModal" tabindex="-1" aria-labelledby="importExamResultsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importExamResultsModalLabel">Import Exam Results</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="import-exam-results-form">
                        <div class="mb-3">
                            <label for="import_file" class="form-label">Upload CSV or Excel File</label>
                            <input class="form-control" type="file" name="import_file" accept=".csv, .xlsx, .xls" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="import_header_row_no" class="form-label">Header Row Number</label>
                                <input type="number" class="form-control" name="header_row_number" value="1" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="import_data_row_start" class="form-label">Data Row Start</label>
                                <input type="number" class="form-control" name="data_row_start" value="2" min="2" required>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <h6>Matching Headers</h6>
                    <p class="text-muted small">Map the columns from your file to the expected headers.</p>
                    <div class="import-fields-container"></div>
                    <hr>
                    <h6>Sample Data Preview</h6>
                    <div class="import-samples-container"></div>
                    <div class="d-flex justify-content-around align-items-center mb-3">
                        <button type="button" class="btn btn-secondary prev-sample-btn" disabled>Previous</button>
                        <span class="import-samples-count">0</span>
                        <button type="button" class="btn btn-secondary next-sample-btn">Next</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning test-import-btn">Test</button>
                    <button type="button" class="btn btn-success import-btn" disabled>Import</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="print-options-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="printModalLabel">Print Options</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="print_report_type" class="form-label">Report Type</label>
                            <select class="form-select" name="report_type">
                                <option value="summary" selected>Summary</option>
                                <option value="detailed">Detailed</option>
                                <option value="template">Template</option>
                            </select>
                        </div>
                        <div class="print-preview-area border p-2" style="min-height: 100px;">
                            <p class="text-muted text-center">Print Content Area / Preview</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary print-btn">Print</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="generate/js/script.js"></script>
    <script>
    $(document).ready(function () {
        const $termSelect = $('#exam_results_application_term');
        const savedTerm = localStorage.getItem('selectedEnrollmentTerm');
        if (savedTerm) {
            $termSelect.val(savedTerm);
        }

        $termSelect.change(function () {
            const selected = $(this).val();
            localStorage.setItem('selectedEnrollmentTerm', selected);
            table.ajax.reload(null, true);
        });

        const table = $('#examResultsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'server/icat/exam_results.php',
            type: 'POST',
            data: function (d) {
                d.action = 'datatable';
                d.application_term = $termSelect.val();
                d.draw = d.draw || 1; // Ensure draw is always sent, default to 1 if undefined
                return d;
            },
            dataSrc: function (json) {
                if (!json || !json.data) {
                    console.error('Invalid DataTable response:', json);
                    return [];
                }
                // Ensure draw is present in response, fallback to request draw if missing
                json.draw = json.draw || parseInt($('input[name="draw"]').val()) || 1;
                return json.data;
            },
            error: function (xhr) {
                console.error("AJAX Error:", xhr.responseText);
                showNotification('error', 'Failed to load exam results.');
            }
        },
        columns: [
            {
                data: "exam_result_id",
                render: function (data) {
                    return `<input type="checkbox" class="exam-result-checkbox" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: "applicant_no" },
            { data: "lastname" },
            { data: "firstname" },
            { data: "middlename" },
            { data: "date_taken" },
            { data: "general_ability" },
            { data: "verbal_aptitude" },
            { data: "numerical_aptitude" },
            { data: "spatial_aptitude" },
            { data: "perceptual_aptitude" },
            { data: "manual_dexterity" },
            { data: "remarks" },
            {
                data: "exam_result_id",
                render: function (data) {
                    return `
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn p-0 border-0 bg-transparent view-exam-result" data-id="${data}">
                                <i class="fa-solid fa-eye px-1"></i>
                            </button>
                            <button type="button" class="btn p-0 border-0 bg-transparent edit-exam-result" data-id="${data}">
                                <i class="fa-solid fa-pen-to-square px-1"></i>
                            </button>
                            <button type="button" class="btn p-0 border-0 bg-transparent delete-exam-result" data-id="${data}">
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
        lengthMenu: [5, 10, 25, 50, 100, { label: 'All', value: -1 }],
        drawCallback: function (settings) {
            const allChecked = $('.exam-result-checkbox:checked').length === $('.exam-result-checkbox').length;
            $('.check-all').prop('checked', allChecked);
        }
    });

        // View Exam Result
        $(document).on('click', '.view-exam-result', function () {
            const id = $(this).data('id');
            $.ajax({
                url: 'server/icat/exam_results.php',
                type: 'GET',
                data: { action: 'view', id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const result = response.data;
                        const $modal = $('#viewExamResultModal');
                        $modal.find('.view-applicant-no').text(result.applicant_no);
                        $modal.find('.view-applicant-name').text(`${result.lastname}, ${result.firstname} ${result.middlename}`);
                        $modal.find('.view-application-term').text(result.application_term);
                        $modal.find('.view-date-taken').text(result.date_taken);
                        $modal.find('.view-general-ability').text(result.general_ability);
                        $modal.find('.view-verbal-aptitude').text(result.verbal_aptitude);
                        $modal.find('.view-numerical-aptitude').text(result.numerical_aptitude);
                        $modal.find('.view-spatial-aptitude').text(result.spatial_aptitude);
                        $modal.find('.view-perceptual-aptitude').text(result.perceptual_aptitude);
                        $modal.find('.view-manual-dexterity').text(result.manual_dexterity);
                        $modal.find('.view-remarks').text(result.remarks || 'N/A');
                        $modal.modal('show');
                    } else {
                        showNotification('error', response.error || 'Failed to fetch exam result.');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    showNotification('error', 'An error occurred while fetching exam result.');
                }
            });
        });

        // Add Exam Result
        $(document).on('click', '.add-exam-result-btn', function () {
            const $form = $(this).closest('.modal-content').find('.add-exam-result-form');
            const formData = {
                action: 'add',
                applicant_no: $form.find('[name="applicant_no"]').val(),
                date_taken: $form.find('[name="date_taken"]').val(),
                general_ability: $form.find('[name="general_ability"]').val(),
                verbal_aptitude: $form.find('[name="verbal_aptitude"]').val(),
                numerical_aptitude: $form.find('[name="numerical_aptitude"]').val(),
                spatial_aptitude: $form.find('[name="spatial_aptitude"]').val(),
                perceptual_aptitude: $form.find('[name="perceptual_aptitude"]').val(),
                manual_dexterity: $form.find('[name="manual_dexterity"]').val(),
                remarks: $form.find('[name="remarks"]').val()
            };
            $.ajax({
                url: 'server/icat/exam_results.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        showNotification('success', 'Exam result added successfully!');
                        $('#addExamResultModal').modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        showNotification('error', response.error || 'Failed to add exam result.');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    showNotification('error', 'An error occurred while adding the exam result.');
                }
            });
        });

        // Edit Exam Result
        $(document).on('click', '.edit-exam-result', function () {
            const id = $(this).data('id');
            $.ajax({
                url: 'server/icat/exam_results.php',
                type: 'GET',
                data: { action: 'view', id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const result = response.data;
                        const $form = $('#editExamResultModal').find('.edit-exam-result-form');
                        $form.find('[name="id"]').val(result.id);
                        $form.find('[name="applicant_no"]').val(result.applicant_no);
                        $form.find('[name="date_taken"]').val(result.date_taken);
                        $form.find('[name="general_ability"]').val(result.general_ability);
                        $form.find('[name="verbal_aptitude"]').val(result.verbal_aptitude);
                        $form.find('[name="numerical_aptitude"]').val(result.numerical_aptitude);
                        $form.find('[name="spatial_aptitude"]').val(result.spatial_aptitude);
                        $form.find('[name="perceptual_aptitude"]').val(result.perceptual_aptitude);
                        $form.find('[name="manual_dexterity"]').val(result.manual_dexterity);
                        $form.find('[name="remarks"]').val(result.remarks);
                        $('#editExamResultModal').modal('show');
                    } else {
                        showNotification('error', response.error || 'Failed to fetch exam result.');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    showNotification('error', 'An error occurred while fetching exam result.');
                }
            });
        });

        $(document).on('click', '.edit-exam-result-btn', function () {
            const $form = $(this).closest('.modal-content').find('.edit-exam-result-form');
            const formData = {
                action: 'edit',
                id: $form.find('[name="id"]').val(),
                applicant_no: $form.find('[name="applicant_no"]').val(),
                date_taken: $form.find('[name="date_taken"]').val(),
                general_ability: $form.find('[name="general_ability"]').val(),
                verbal_aptitude: $form.find('[name="verbal_aptitude"]').val(),
                numerical_aptitude: $form.find('[name="numerical_aptitude"]').val(),
                spatial_aptitude: $form.find('[name="spatial_aptitude"]').val(),
                perceptual_aptitude: $form.find('[name="perceptual_aptitude"]').val(),
                manual_dexterity: $form.find('[name="manual_dexterity"]').val(),
                remarks: $form.find('[name="remarks"]').val()
            };
            $.ajax({
                url: 'server/icat/exam_results.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        showNotification('success', 'Exam result updated successfully!');
                        $('#editExamResultModal').modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        showNotification('error', response.error || 'Failed to update exam result.');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    showNotification('error', 'An error occurred while updating the exam result.');
                }
            });
        });

        // Delete Exam Result
        $(document).on('click', '.delete-exam-result', function () {
            const id = $(this).data('id');
            $.ajax({
                url: 'server/icat/exam_results.php',
                type: 'GET',
                data: { action: 'view', id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const result = response.data;
                        const $modal = $('#singleDeleteExamResultModal');
                        $modal.find('.single-delete-exam-result-id').val(result.id);
                        $modal.find('.single-delete-applicant-no').text(result.applicant_no);
                        $modal.find('.single-delete-applicant-name').text(`${result.lastname}, ${result.firstname} ${result.middlename}`);
                        $modal.modal('show');
                    }
                }
            });
        });

        $(document).on('click', '.single-delete-exam-result-btn', function () {
            const $modal = $(this).closest('.modal-content');
            const id = $modal.find('.single-delete-exam-result-id').val();
            $.ajax({
                url: 'server/icat/exam_results.php',
                type: 'POST',
                data: { action: 'delete_single', id: id },
                success: function (response) {
                    if (response.success) {
                        showNotification('success', 'Exam result deleted successfully!');
                        $('#singleDeleteExamResultModal').modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        showNotification('error', response.error || 'Failed to delete exam result.');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    showNotification('error', 'An error occurred while deleting the exam result.');
                }
            });
        });

        // Multi Delete
        $(document).on('click', '.multi-delete-exam-result', function () {
            const selectedIds = $('.exam-result-checkbox:checked').map(function () {
                return $(this).val();
            }).get();
            if (selectedIds.length === 0) {
                showNotification('error', 'Please select at least one exam result to delete.');
                return;
            }
            $.ajax({
                url: 'server/icat/exam_results.php',
                type: 'GET',
                data: { action: 'view_multi', ids: selectedIds },
                success: function (response) {
                    if (response.success) {
                        const results = response.data;
                        let elements = '';
                        results.forEach(function (result) {
                            elements += `
                                <div class="list-group-item d-flex justify-content-between align-items-center to-be-deleted" data-id="${result.id}">
                                    <span>${result.lastname}, ${result.firstname} ${result.middlename} (${result.applicant_no})</span>
                                    <button type="button" class="btn btn-sm btn-danger unselect-delete-btn" data-id="${result.id}">Unselect</button>
                                </div>
                            `;
                        });
                        const $modal = $('#multiDeleteExamResultModal');
                        $modal.find('.multi-delete-exam-result-elements').html(elements);
                        $modal.find('.multi-delete-exam-result-count').text(results.length);
                        $modal.modal('show');
                    } else {
                        showNotification('error', 'Could not fetch exam result details.');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    showNotification('error', 'Something went wrong!');
                }
            });
        });

        $(document).on('click', '.multi-delete-exam-result-btn', function () {
            const selectedIds = $('.to-be-deleted').map(function () {
                return $(this).data('id');
            }).get();
            if (selectedIds.length === 0) {
                showNotification('error', 'Please select at least one exam result to delete.');
                $('#multiDeleteExamResultModal').modal('hide');
                return;
            }
            $.ajax({
                url: 'server/icat/exam_results.php',
                type: 'POST',
                data: { action: 'delete_multi', ids: selectedIds },
                success: function (response) {
                    if (response.success) {
                        showNotification('success', 'Selected exam results deleted successfully!');
                        $('#multiDeleteExamResultModal').modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        showNotification('error', 'Failed to delete selected exam results.');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    showNotification('error', 'An error occurred while deleting the exam results.');
                }
            });
        });

        // Unselect in Multi-Delete
        $(document).on('click', '.unselect-delete-btn', function () {
            const id = $(this).data('id');
            $(`.to-be-deleted[data-id="${id}"]`).remove();
            const selectedIds = $('.to-be-deleted').map(function () {
                return $(this).data('id');
            }).get();
            $('#multiDeleteExamResultModal').find('.multi-delete-exam-result-count').text(selectedIds.length);
            $('.exam-result-checkbox[value="' + id + '"]').prop('checked', false);
        });

        // Check All
        $(document).on('change', '.check-all', function () {
            $('.exam-result-checkbox').prop('checked', this.checked);
        });

        $(document).on('change', '.exam-result-checkbox', function () {
            if (!this.checked) {
                $('.check-all').prop('checked', false);
            } else if ($('.exam-result-checkbox:checked').length === $('.exam-result-checkbox').length) {
                $('.check-all').prop('checked', true);
            }
        });

        // Import Fields
        let examResultFields = [];
        $.ajax({
            url: 'server/icat/exam_results.php',
            type: 'GET',
            data: { action: 'load_import_fields' },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    examResultFields = response.fields;
                    let fieldHtml = '';
                    examResultFields.forEach(function (field, index) {
                        fieldHtml += `
                            <div class="mb-2 row">
                                <label class="col-sm-5 col-form-label col-form-label-sm">${field.fieldName}:</label>
                                <div class="col-sm-7">
                                    <select class="import-metadata form-select form-select-sm" data-field-index="${index}">
                                        <option value="">None</option>
                                    </select>
                                </div>
                            </div>
                        `;
                    });
                    $('#importExamResultsModal .import-fields-container').html(fieldHtml);
                } else {
                    showNotification('error', 'Failed to load import fields.');
                }
            },
            error: function () {
                showNotification('error', 'An error occurred while loading import fields.');
            }
        });

        // Load Headers
        $('#importExamResultsModal').on('change', '[name="import_file"], [name="header_row_number"]', function () {
            const $form = $(this).closest('.import-exam-results-form');
            const headerRowNumber = $form.find('[name="header_row_number"]').val();
            const formData = new FormData();
            formData.append('action', 'import_samples_metadata');
            formData.append('header_row_number', headerRowNumber);
            formData.append('import_file', $form.find('[name="import_file"]')[0].files[0]);
            $('#importExamResultsModal .import-metadata').each(function () {
                $(this).empty().append('<option value="">None</option>');
            });
            $.ajax({
                url: 'server/icat/exam_results.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        $('#importExamResultsModal .import-metadata').each(function () {
                            const $select = $(this);
                            $select.empty().append('<option value="">None</option>');
                            response.headers.forEach(header => {
                                $select.append(`<option value="${header.headerIndex}">${header.headerData}</option>`);
                            });
                        });
                        showNotification('success', 'Headers loaded successfully!');
                    } else {
                        showNotification('error', 'Failed to load headers. Please check the file and try again.');
                    }
                },
                error: function () {
                    showNotification('error', 'An error occurred while loading headers.');
                }
            });
        });

        // Load Samples
        let samples = [];
        function displaySample(_samples = [], $sampleIndex) {
            if (_samples.length !== 0) {
                samples = _samples;
            }
            let sampleHtml = '';
            samples.forEach(function (sample, sampleIndex) {
                sampleHtml += `<div class="sample-group mb-3" data-sample-index="${sampleIndex}"><h6>Draft ${sampleIndex + 1}</h6>`;
                sample.forEach(function (field) {
                    const fieldName = field.fieldName;
                    const fieldId = `${field.fieldId}_${sampleIndex}`; // Unique ID for sample
                    const placeholder = field.placeholder;
                    const value = field.data || '';
                    const error = field.error || '';
                    sampleHtml += `
                        <div class="mb-3">
                            <label for="${fieldId}" class="form-label">${fieldName}</label>
                            <input type="text" class="form-control sample-field" name="${fieldName}_${sampleIndex}" value="${value}" placeholder="${placeholder}" required>
                            ${error ? `<span class="text-danger small">${error}</span>` : ''}
                        </div>
                    `;
                });
                sampleHtml += `<button type="button" class="btn btn-danger remove-sample-btn" data-sample-index="${sampleIndex}">Remove</button></div>`;
            });
            $('#importExamResultsModal .import-samples-container').html(sampleHtml);
            $('#importExamResultsModal .import-samples-count').text(samples.length);
        }

        $(document).on('click', '.test-import-btn', function () {
            const $modal = $(this).closest('#importExamResultsModal');
            const $form = $modal.find('.import-exam-results-form');
            const formData = new FormData();
            formData.append('action', 'import_samples');
            formData.append('import_file', $form.find('[name="import_file"]')[0].files[0]);
            formData.append('data_row_start', $form.find('[name="data_row_start"]').val());
            const applicantFieldsWithValue = [];
            examResultFields.forEach(function (field, index) {
                const $select = $modal.find(`.import-metadata[data-field-index="${index}"]`);
                const selectedHeader = $select.val();
                if (selectedHeader) {
                    applicantFieldsWithValue.push({ fieldName: field.fieldName, fieldId: field.fieldId, headerIndex: selectedHeader });
                }
            });
            formData.append('applicant_fields', JSON.stringify(applicantFieldsWithValue));
            if (samples.length !== 0) {
                let existingSamples = [];
                samples.forEach(function (sample, sampleIndex) {
                    let sampleData = [];
                    sample.forEach(function (field) {
                        const fieldName = field.fieldName;
                        const fieldId = `${field.fieldId}_${sampleIndex}`;
                        const value = $modal.find(`[name="${fieldName}_${sampleIndex}"]`).val();
                        sampleData.push({ fieldName, fieldId, data: value });
                    });
                    existingSamples.push(sampleData);
                });
                formData.append('existing_samples', JSON.stringify(existingSamples));
            }
            $.ajax({
                url: 'server/icat/exam_results.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        displaySample(response.samples, 0);
                        showNotification('success', 'Samples loaded successfully!');
                        $modal.find('.import-btn').prop('disabled', false);
                    } else {
                        showNotification('error', 'Failed to load samples. Please check the file and try again.');
                    }
                },
                error: function () {
                    showNotification('error', 'An error occurred while loading samples.');
                }
            });
        });

        $(document).on('click', '.remove-sample-btn', function () {
            const sampleIndex = $(this).data('sample-index');
            samples.splice(sampleIndex, 1);
            displaySample();
        });

        $(document).on('click', '.import-btn', function () {
            const $modal = $(this).closest('#importExamResultsModal');
            const $form = $modal.find('.import-exam-results-form');
            const formData = new FormData();
            formData.append('action', 'import');
            formData.append('import_file', $form.find('[name="import_file"]')[0].files[0]);
            formData.append('data_row_start', $form.find('[name="data_row_start"]').val());
            const applicantFieldsWithValue = [];
            examResultFields.forEach(function (field, index) {
                const $select = $modal.find(`.import-metadata[data-field-index="${index}"]`);
                const selectedHeader = $select.val();
                if (selectedHeader) {
                    applicantFieldsWithValue.push({ fieldName: field.fieldName, fieldId: field.fieldId, headerIndex: selectedHeader });
                }
            });
            formData.append('applicant_fields', JSON.stringify(applicantFieldsWithValue));
            $.ajax({
                url: 'server/icat/exam_results.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        showNotification('success', response.message);
                        $modal.modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        showNotification('error', response.error || 'Failed to import exam results.');
                    }
                },
                error: function () {
                    showNotification('error', 'An error occurred while importing exam results.');
                }
            });
        });

        // Print
        $(document).on('click', '.print-btn', function () {
            const $form = $(this).closest('.print-options-form');
            const reportType = $form.find('[name="report_type"]').val();
            const selectedIds = $('.exam-result-checkbox:checked').map(function () {
                return $(this).val();
            }).get();
            window.location.href = `server/icat/exam_results.php?action=generate_print&report_type=${reportType}&ids=${selectedIds.join(',')}`;
        });
    });
    </script>