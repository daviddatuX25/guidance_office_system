<?php
require_once './Main.php';
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
header('Content-Type: application/json');
global $db;

// Pre data
$applicantFields = [
    ['fieldName' => 'Applicant No', 'fieldId' => 'import_ApplicantNo', 'placeholder' => 'Enter applicant number'],
    ['fieldName' => 'Lastname', 'fieldId' => 'import_Lastname', 'placeholder' => 'Enter last name'],
    ['fieldName' => 'Firstname', 'fieldId' => 'import_Firstname', 'placeholder' => 'Enter first name'],
    ['fieldName' => 'Middlename', 'fieldId' => 'import_Middlename', 'placeholder' => 'Enter middle name'],
    ['fieldName' => 'Suffix', 'fieldId' => 'import_Suffix', 'placeholder' => 'Enter suffix'],
    ['fieldName' => 'Strand Name', 'fieldId' => 'import_StrandName', 'placeholder' => 'Enter strand name'],
    ['fieldName' => '1st Course Nickname', 'fieldId' => 'import_Course1Nickname', 'placeholder' => 'Enter course 1 nickname'],
    ['fieldName' => '2nd Course Nickname', 'fieldId' => 'import_Course2Nickname', 'placeholder' => 'Enter course 2 nickname'],
    ['fieldName' => '3rd Course Nickname', 'fieldId' => 'import_Course3Nickname', 'placeholder' => 'Enter course 3 nickname']
];
$notRequiredFields = ['2nd Course Nickname', '3rd Course Nickname', 'Suffix', 'Middlename'];
// Handle GET requests (e.g., viewing a single applicant)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'view' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $applicant = $db->readOne(
            'applicants a',
            [
                'a.*, 
                s.name AS strand, 
                c1.nickname AS course_1, 
                c2.nickname AS course_2, 
                c3.nickname AS course_3, 
                CONCAT(at_.academic_year, " | ", at_.semester) AS application_term'
            ],
            [
                ['column' => 'a.id', 'operator' => '=', 'value' => $id]
            ],
            [
                ['type' => 'LEFT', 'table' => 'strands s', 'condition' => 'a.strand_id = s.id'],
                ['type' => 'LEFT', 'table' => 'courses c1', 'condition' => 'a.course_1_id = c1.id'],
                ['type' => 'LEFT', 'table' => 'courses c2', 'condition' => 'a.course_2_id = c2.id'],
                ['type' => 'LEFT', 'table' => 'courses c3', 'condition' => 'a.course_3_id = c3.id'],
                ['type' => 'LEFT', 'table' => 'application_term at_', 'condition' => 'a.application_term_id = at_.id']
            ]
        );
        if ($applicant) {
            echo json_encode(['success' => true, 'data' => $applicant]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Applicant not found']);
            http_response_code(404);
        }
        exit;
    } 

    // Handle multi-view request
    if (isset($_GET['action']) && $_GET['action'] === 'view_multi' && isset($_GET['ids'])) {
        $ids = $_GET['ids'];
    
        // Ensure $ids is an array and sanitize the input
        if (!is_array($ids)) {
            echo json_encode(['success' => false, 'error' => 'Invalid IDs format']);
            http_response_code(400);
            exit;
        }
    
        $sanitizedIds = array_map('intval', $ids); // Sanitize IDs to ensure they are integers

        // Fetch multiple applicants
        $applicants = $db->readAll(
            'applicants a',
            [
                'a.*, 
                s.name AS strand, 
                c1.nickname AS course_1, 
                c2.nickname AS course_2, 
                c3.nickname AS course_3, 
                CONCAT(at_.academic_year, " | ", at_.semester) AS application_term'
            ],
            [
                ['column' => 'a.id', 'operator' => 'IN', 'value' => $sanitizedIds]
            ],
            [
                ['type' => 'LEFT', 'table' => 'strands s', 'condition' => 'a.strand_id = s.id'],
                ['type' => 'LEFT', 'table' => 'courses c1', 'condition' => 'a.course_1_id = c1.id'],
                ['type' => 'LEFT', 'table' => 'courses c2', 'condition' => 'a.course_2_id = c2.id'],
                ['type' => 'LEFT', 'table' => 'courses c3', 'condition' => 'a.course_3_id = c3.id'],
                ['type' => 'LEFT', 'table' => 'application_term at_', 'condition' => 'a.application_term_id = at_.id']
            ]
        );
        if ($applicants) {
            echo json_encode(['success' => true, 'data' => $applicants]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No applicants found']);
            http_response_code(404);
        }
        exit;   
    } 
    if (isset($_GET['action']) && $_GET['action'] === 'load_import_fields'){
        $response = [
            'success' => true,
            'fields' => $applicantFields
        ];
        echo json_encode($response);
        http_response_code(200);
        exit;
    }
    
    else {
        echo json_encode(['success' => false, 'error' => 'Invalid action or missing parameters']);
        http_response_code(400);
        exit;   
    }
    
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DataTables request
    if ($_POST['action'] === 'datatable') {
        $columns = [
            'a.applicant_no',
            'a.lastname',
            'a.firstname',
            'a.middlename',
            'a.suffix',
            'a.sex',
            's.name AS strand',
            'c1.nickname AS course_1',
            'c2.nickname AS course_2',
            'c3.nickname AS course_3',
            'IF(tr.applicant_id IS NOT NULL, "Taken", "Not Taken") AS test_status',
            'a.id AS application_id'
        ];

        $joins = [
            ['type' => 'LEFT', 'table' => 'strands s', 'condition' => 'a.strand_id = s.id'],
            ['type' => 'LEFT', 'table' => 'courses c1', 'condition' => 'a.course_1_id = c1.id'],
            ['type' => 'LEFT', 'table' => 'courses c2', 'condition' => 'a.course_2_id = c2.id'],
            ['type' => 'LEFT', 'table' => 'courses c3', 'condition' => 'a.course_3_id = c3.id'],
            ['type' => 'LEFT', 'table' => 'test_results tr', 'condition' => 'a.id = tr.applicant_id']
        ];

        // Pagination parameters
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 10);

        // Search parameter
        $searchValue = $_POST['search']['value'] ?? '';

        // Order parameters
        $orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
        $orderDirection = $_POST['order'][0]['dir'] ?? 'asc';
        $orderColumn = $columns[$orderColumnIndex];

        // Build WHERE clause for search
        $where = [];
        if (!empty($searchValue)) {
            $where[] = [
                'column' => 'CONCAT(a.applicant_no, " ", a.lastname, " ", a.firstname, " ", a.middlename)',
                'operator' => 'LIKE',
                'value' => "%$searchValue%"
            ];
        }

        // Add application term filter if provided
        if (!empty($_POST['application_term'])) {
            $where[] = [
                'column' => 'a.application_term_id',
                'operator' => '=',
                'value' => $_POST['application_term']
            ];
        }

        // Fetch filtered data
        $data = $db->readAll('applicants a', $columns, $where, $joins, $length, $start, [$orderColumn => $orderDirection]);

        // Fetch total records
        $totalRecords = $db->count('applicants a');
        $filteredRecords = $db->count('applicants a', $where, $joins);

        // Return JSON response
        echo json_encode([
            'draw' => intval($_POST['draw'] ?? 0),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
        exit;
    } elseif (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'add':
                $data = [
                    'applicant_no' => $_POST['applicant_no'],
                    'application_term_id' => $_POST['application_term_id'],
                    'lastname' => $_POST['lastname'],
                    'firstname' => $_POST['firstname'],
                    'middlename' => $_POST['middlename'],
                    'suffix' => $_POST['suffix'],
                    'sex' => $_POST['sex'],
                    'strand_id' => $_POST['strand_id'],
                    'course_1_id' => $_POST['course_1_id'],
                    'course_2_id' => $_POST['course_2_id'] ?? null,
                    'course_3_id' => $_POST['course_3_id'] ?? null
                ];
                $result = $db->create('applicants', $data);
                echo json_encode(['success' => $result !== false, 'data' => $result]);
                break;

            case 'edit':
                $id = intval($_POST['id']);
                $data = [
                    'applicant_no' => $_POST['applicant_no'],
                    'lastname' => $_POST['lastname'],
                    'firstname' => $_POST['firstname'],
                    'middlename' => $_POST['middlename'],
                    'suffix' => $_POST['suffix'],
                    'sex' => $_POST['sex'],
                    'strand_id' => $_POST['strand_id'],
                    'course_1_id' => $_POST['course_1_id'],
                    'course_2_id' => $_POST['course_2_id'],
                    'course_3_id' => $_POST['course_3_id'],
                    'application_term_id' => $_POST['application_term_id']
                ];
                $result = $db->update('applicants', $data, 
                    [['column' =>'id', 'operator' => '=', 'value' => $id]]
                );

                if ($result) {
                    echo json_encode(['success' => true]);
                    http_response_code(200);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to update applicant']);
                    http_response_code(500);
                }
                break;

            case 'delete_single':
                if (!isset($_POST['id'])) {
                    echo json_encode(['success' => false, 'error' => 'No applicant to be deleted']);
                    http_response_code(400);
                    break;
                }
                $id = intval($_POST['id']);

                $result = $db->delete('applicants',
                    [['column' =>'id', 'operator' => '=', 'value' => $id]]
                );
                if ($result) {
                    echo json_encode(['success' => true]);
                    http_response_code(200);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to delete applicant']);
                    http_response_code(500);
                }
                break;

            case 'delete_multi':
                if (!isset($_POST['ids'])) {
                    echo json_encode(['success' => false, 'error' => 'No applicants to be deleted']);
                    http_response_code(400);
                    break;
                }
                $ids = $_POST['ids'];
                // Ensure $ids is an array and sanitize the input
                if (!is_array($ids)) {
                    echo json_encode(['success' => false, 'error' => 'Invalid IDs format']);
                    http_response_code(400);
                    exit;
                }
                $sanitizedIds = array_map('intval', $ids); // Sanitize IDs to ensure they are integers
                $result = $db->delete('applicants',
                    [['column' =>'id', 'operator' => 'IN', 'value' => $sanitizedIds]]
                );
                if ($result) {
                    echo json_encode(['success' => true]);
                    http_response_code(200);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to delete applicants']);
                    http_response_code(500);
                }
                break;

            case 'import_samples_metadata':
                $headerRowNumber = intval($_POST['header_row_number']);
                $file = $_FILES['import_file'];
                // Load the file and convert it to an array (use PhpSpreadsheet or similar library)
                try { 
                    $spreadsheet = IOFactory::load($file['tmp_name']);
                    $sheet = $spreadsheet->getActiveSheet();
                    $data = $sheet->toArray();
                    
                    // Extract headers from the specified row
                    $headers = $data[$headerRowNumber - 1] ?? null ; // Adjust for zero-based index
                    // Check if it is not null
                    if ($headers === null) {
                        echo json_encode(['success' => false, 'error' => 'Header row is empty']);
                        http_response_code(400);
                        exit;
                    }
                    
                    // Encode headers as { headerData, headerIndex }
                    $encodedHeaders = [];
                    foreach ($headers as $index => $header) {
                        $encodedHeaders[] = [
                            'headerData' => $header,
                            'headerIndex' => $index
                        ];
                    }
                    echo json_encode(['success' => true, 'headers' => $encodedHeaders]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                }
                break;
            case 'import_samples':
                // Json decode applicant_fields
                $applicantFields = json_decode($_POST['applicant_fields']); // [fieldName, fieldId, headerIndex]
                // Get the data row start
                $dataRowStart = intval($_POST['data_row_start']);
                // Validate and process the applicant fields
                foreach ($applicantFields as $key => $field) {
                    if (isset($field->headerIndex)) {
                        $applicantFields[$key]->headerIndex = intval($field->headerIndex); // Convert to integer index
                    } else {
                        echo json_encode(['success' => false, 'error' => "Missing header index for field: {$field['fieldName']}"]);
                        http_response_code(400);
                        exit;
                    }
                }
                // Samples
                $samples = [];
                // Check if post existing_samples exist
                if (isset($_POST['existing_samples'])) {
                    $existingSamples = json_decode($_POST['existing_samples']);
                    foreach ($existingSamples as $key => $sample) {
                        $samples[$key] = $sample;
                        foreach ($sample as $fieldIdx => $field){
                            $samples[$key][$fieldIdx] = $field;
                            if (empty($field->data) && !in_array($field->fieldName, $notRequiredFields)) {
                                // See if Courses and Strand are equivalent to existing strands or courses
                                if (strpos($field->fieldName, 'course') !== false ) {
                                    $courseNickname = $field->data;
                                    $course = $db->readOne('courses', ['id'], [['column' => 'nickname', 'operator' => '=', 'value' => $courseNickname]]) ?? null;
                                    if (empty($course)) {
                                        $samples[$key][$fieldIdx]->error = "Course does not exists";
                                    }
                                } elseif (strpos($field->fieldName, 'strand') !== false) {
                                    $strandName = $field->data;
                                    $strand = $db->readOne('strands', ['id'], [['column' => 'name', 'operator' => '=', 'value' => $strandName]]) ?? null;
                                    if (empty($strand)) {
                                        $samples[$key][$fieldIdx]->error  = "Strand does not exists";
                                    }
                                } else {
                                    $samples[$key][$fieldIdx]->error  = "Field is required";
                                }
                            } else {
                                $samples[$key][$fieldIdx]->error  = null; // No error for other fields
                            }                            
                        }
                    }
                } else {
                    // Get the uploaded file
                    $file = $_FILES['import_file'];
                    if (!isset($_FILES['import_file']) || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
                        echo json_encode(['success' => false, 'error' => 'Missing or invalid file upload']);
                        http_response_code(400);
                        break;
                    }
                    
                   
                    try {
                        // Load the spreadsheet
                        $spreadsheet = IOFactory::load($file['tmp_name']);
                        $sheet = $spreadsheet->getActiveSheet();
                        $data = $sheet->toArray();

                        // Extract data rows starting from the specified data row up untl the end
                        // Adjust for zero-based index
                        if ($dataRowStart < 1 || $dataRowStart > count($data)) {
                            echo json_encode(['success' => false, 'error' => 'Invalid data row start']);
                            http_response_code(400);
                            break;
                        }
                        $dataRows = array_slice($data, $dataRowStart - 1); // Adjust for zero-based index

                        // Process each row
                        foreach ($dataRows as $rowIndex => $row) {
                            foreach ($applicantFields as $fieldIndex => $field) {
                                $headerIndex = $field->headerIndex;
                                // Check if the column-data exists in the current row
                                $samples[$rowIndex][$fieldIndex]['fieldName'] = $field->fieldName;
                                $samples[$rowIndex][$fieldIndex]['fieldId'] = $field->fieldId . '_' . $rowIndex; // Unique field ID for each row
                                if (isset($row[$headerIndex])) {
                                    $samples[$rowIndex][$fieldIndex]['data'] = trim($row[$headerIndex]); // Trim whitespace
                                } else {
                                    $samples[$rowIndex][$fieldIndex]['data'] = '';
                                }
                                // Check if Courses and Strand are equivalent to existing strands or courses
                                if (empty($samples[$rowIndex][$fieldIndex]['data']) && !in_array($field->fieldName, $notRequiredFields)) {
                                    if (strpos($field->fieldName, 'course') !== false) {
                                        $courseNickname = $samples[$rowIndex][$fieldIndex]['data'];
                                        $course = $db->readOne('courses', ['id'], [['column' => 'nickname', 'operator' => '=', 'value' => $courseNickname]]) ?? null;
                                        if (empty($course)) {
                                            $samples[$rowIndex][$fieldIndex]['error'] = "Invalid course nickname";
                                        }
                                    } elseif (strpos($field->fieldName, 'strand') !== false) {
                                        $strandName = $samples[$rowIndex][$fieldIndex]['data'];
                                        $strand = $db->readOne('strands', ['id'], [['column' => 'name', 'operator' => '=', 'value' => $strandName]]) ?? null;
                                        if (empty($strand)) {
                                            $samples[$rowIndex][$fieldIndex]['error'] = "Strand does not exists";
                                        }
                                    } else {
                                        $samples[$rowIndex][$fieldIndex]['error'] = "Field is required";
                                    }

                                } else {
                                    $samples[$rowIndex][$fieldIndex]['error'] = null; // No error for other fields
                                }
                            }
                        }
                    } catch (Exception $e) {
                        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                        http_response_code(500);
                    }
                }
                echo json_encode(['success' => true, 'samples' => $samples]);
                break;
            default:
                echo json_encode(['success' => false, 'error' => 'Invalid action']);
                http_response_code(400);
                break;
        }
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'No action specified']);
        http_response_code(400);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    http_response_code(405);
    exit;
}
?>