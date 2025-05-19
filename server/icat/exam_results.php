<?php
require_once './Main.php';
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
header('Content-Type: application/json');
global $db;

// Predefined fields for import
$examResultFields = [
    ['fieldName' => 'Applicant No', 'fieldId' => 'import_ApplicantNo', 'placeholder' => 'Enter applicant number'],
    ['fieldName' => 'Date Taken', 'fieldId' => 'import_DateTaken', 'placeholder' => 'Enter date (YYYY-MM-DD)'],
    ['fieldName' => 'General Ability', 'fieldId' => 'import_GeneralAbility', 'placeholder' => 'Enter general ability score'],
    ['fieldName' => 'Verbal Aptitude', 'fieldId' => 'import_VerbalAptitude', 'placeholder' => 'Enter verbal aptitude score'],
    ['fieldName' => 'Numerical Aptitude', 'fieldId' => 'import_NumericalAptitude', 'placeholder' => 'Enter numerical aptitude score'],
    ['fieldName' => 'Spatial Aptitude', 'fieldId' => 'import_SpatialAptitude', 'placeholder' => 'Enter spatial aptitude score'],
    ['fieldName' => 'Perceptual Aptitude', 'fieldId' => 'import_PerceptualAptitude', 'placeholder' => 'Enter perceptual aptitude score'],
    ['fieldName' => 'Manual Dexterity', 'fieldId' => 'import_ManualDexterity', 'placeholder' => 'Enter manual dexterity score'],
    ['fieldName' => 'Remarks', 'fieldId' => 'import_Remarks', 'placeholder' => 'Enter remarks']
];
$notRequiredFields = ['Remarks'];

// GET requests (view, multi-view, import fields)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'view' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result = $db->readOne(
            'test_results tr',
            [
                'tr.*',
                'a.applicant_no',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'CONCAT(at.academic_year, " | ", at.semester) AS application_term'
            ],
            [['column' => 'tr.id', 'operator' => '=', 'value' => $id]],
            [
                ['type' => 'LEFT', 'table' => 'applicants a', 'condition' => 'tr.applicant_id = a.id'],
                ['type' => 'LEFT', 'table' => 'application_term at', 'condition' => 'a.application_term_id = at.id']
            ]
        );
        if ($result) {
            echo json_encode(['success' => true, 'data' => $result]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Exam result not found']);
            http_response_code(404);
        }
        exit;
    } elseif (isset($_GET['action']) && $_GET['action'] === 'view_multi' && isset($_GET['ids'])) {
        $ids = $_GET['ids'];
        if (!is_array($ids)) {
            echo json_encode(['success' => false, 'error' => 'Invalid IDs format']);
            http_response_code(400);
            exit;
        }
        $sanitizedIds = array_map('intval', $ids);
        $results = $db->readAll(
            'test_results tr',
            [
                'tr.*',
                'a.applicant_no',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'CONCAT(at.academic_year, " | ", at.semester) AS application_term'
            ],
            [['column' => 'tr.id', 'operator' => 'IN', 'value' => $sanitizedIds]],
            [
                ['type' => 'LEFT', 'table' => 'applicants a', 'condition' => 'tr.applicant_id = a.id'],
                ['type' => 'LEFT', 'table' => 'application_term at', 'condition' => 'a.application_term_id = at.id']
            ]
        );
        if ($results) {
            echo json_encode(['success' => true, 'data' => $results]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No exam results found']);
            http_response_code(404);
        }
        exit;
    } elseif (isset($_GET['action']) && $_GET['action'] === 'load_import_fields') {
        echo json_encode(['success' => true, 'fields' => $examResultFields]);
        http_response_code(200);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action or missing parameters']);
        http_response_code(400);
        exit;
    }
}

// POST requests (DataTable, CRUD, import)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'datatable') {
        $columns = [
            'tr.id AS exam_result_id',
            'a.applicant_no',
            'a.lastname',
            'a.firstname',
            'a.middlename',
            'tr.date_taken',
            'tr.general_ability',
            'tr.verbal_aptitude',
            'tr.numerical_aptitude',
            'tr.spatial_aptitude',
            'tr.perceptual_aptitude',
            'tr.manual_dexterity',
            'tr.remarks'
        ];
        $joins = [
            ['type' => 'LEFT', 'table' => 'applicants a', 'condition' => 'tr.applicant_id = a.id'],
            ['type' => 'LEFT', 'table' => 'application_term at', 'condition' => 'a.application_term_id = at.id']
        ];
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 10);
        $searchValue = $_POST['search']['value'] ?? '';
        $orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
        $orderDirection = $_POST['order'][0]['dir'] ?? 'asc';
        $orderColumn = $columns[$orderColumnIndex];
        $where = [];
        if (!empty($searchValue)) {
            $where[] = [
                'column' => 'CONCAT(a.applicant_no, " ", a.lastname, " ", a.firstname, " ", a.middlename)',
                'operator' => 'LIKE',
                'value' => "%$searchValue%"
            ];
        }
        if (!empty($_POST['application_term'])) {
            $where[] = [
                'column' => 'a.application_term_id',
                'operator' => '=',
                'value' => $_POST['application_term']
            ];
        }
        $data = $db->readAll('test_results tr', $columns, $where, $joins, $length, $start, [$orderColumn => $orderDirection]);
        $totalRecords = $db->count('test_results tr');
        $filteredRecords = $db->count('test_results tr', $where, $joins);
        echo json_encode([
            'draw' => intval($_POST['draw'] ?? 0), // Align with provided implementation
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data ?: [] // Ensure data is an array
        ]);
        exit;
    } elseif (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'add':
                $applicant = $db->readOne('applicants', ['*'], [['column' => 'applicant_no', 'operator' => '=', 'value' => $_POST['applicant_no']]]);
                if (!$applicant) {
                    echo json_encode(['success' => false, 'error' => 'Invalid applicant number: ' .  $_POST['applicant_no']]);
                    http_response_code(400);
                    exit;
                }
                $data = [
                    'applicant_id' => $applicant['id'],
                    'date_taken' => $_POST['date_taken'],
                    'general_ability' => intval($_POST['general_ability']),
                    'verbal_aptitude' => intval($_POST['verbal_aptitude']),
                    'numerical_aptitude' => intval($_POST['numerical_aptitude']),
                    'spatial_aptitude' => intval($_POST['spatial_aptitude']),
                    'perceptual_aptitude' => intval($_POST['perceptual_aptitude']),
                    'manual_dexterity' => intval($_POST['manual_dexterity']),
                    'remarks' => $_POST['remarks'] ?? null
                ];
                $result = $db->create('test_results', $data);
                echo json_encode(['success' => $result !== false, 'data' => $result]);
                break;
            case 'edit':
                $id = intval($_POST['id']);
                $applicant = $db->readOne('applicants', ['id'], [['column' => 'applicant_no', 'operator' => '=', 'value' => $_POST['applicant_no']]]);
                if (!$applicant) {
                    echo json_encode(['success' => false, 'error' => 'Invalid applicant number']);
                    http_response_code(400);
                    exit;
                }
                $data = [
                    'applicant_id' => $applicant['id'],
                    'date_taken' => $_POST['date_taken'],
                    'general_ability' => intval($_POST['general_ability']),
                    'verbal_aptitude' => intval($_POST['verbal_aptitude']),
                    'numerical_aptitude' => intval($_POST['numerical_aptitude']),
                    'spatial_aptitude' => intval($_POST['spatial_aptitude']),
                    'perceptual_aptitude' => intval($_POST['perceptual_aptitude']),
                    'manual_dexterity' => intval($_POST['manual_dexterity']),
                    'remarks' => $_POST['remarks'] ?? null
                ];
                $result = $db->update('test_results', $data, [['column' => 'id', 'operator' => '=', 'value' => $id]]);
                echo json_encode(['success' => $result, 'error' => $result ? null : 'Failed to update exam result']);
                break;
            case 'delete_single':
                $id = intval($_POST['id']);
                $result = $db->delete('test_results', [['column' => 'id', 'operator' => '=', 'value' => $id]]);
                echo json_encode(['success' => $result, 'error' => $result ? null : 'Failed to delete exam result']);
                break;
            case 'delete_multi':
                $ids = $_POST['ids'];
                if (!is_array($ids)) {
                    echo json_encode(['success' => false, 'error' => 'Invalid IDs format']);
                    http_response_code(400);
                    exit;
                }
                $sanitizedIds = array_map('intval', $ids);
                $result = $db->delete('test_results', [['column' => 'id', 'operator' => 'IN', 'value' => $sanitizedIds]]);
                echo json_encode(['success' => $result, 'error' => $result ? null : 'Failed to delete exam results']);
                break;
            case 'import_samples_metadata':
                $headerRowNumber = intval($_POST['header_row_number']);
                $file = $_FILES['import_file'];
                try {
                    $spreadsheet = IOFactory::load($file['tmp_name']);
                    $sheet = $spreadsheet->getActiveSheet();
                    $data = $sheet->toArray();
                    $headers = $data[$headerRowNumber - 1] ?? null;
                    if ($headers === null) {
                        echo json_encode(['success' => false, 'error' => 'Header row is empty']);
                        http_response_code(400);
                        exit;
                    }
                    $encodedHeaders = array_map(function ($header, $index) {
                        return ['headerData' => $header, 'headerIndex' => $index];
                    }, $headers, array_keys($headers));
                    echo json_encode(['success' => true, 'headers' => $encodedHeaders]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                }
                break;
            case 'import_samples':
                $applicantFields = json_decode($_POST['applicant_fields']);
                $dataRowStart = intval($_POST['data_row_start']);
                foreach ($applicantFields as $key => $field) {
                    $applicantFields[$key]->headerIndex = intval($field->headerIndex);
                }
                $samples = [];
                if (isset($_POST['existing_samples'])) {
                    $existingSamples = json_decode($_POST['existing_samples']);
                    foreach ($existingSamples as $key => $sample) {
                        $samples[$key] = $sample;
                        foreach ($sample as $fieldIdx => $field) {
                            $samples[$key][$fieldIdx] = $field;
                            if (empty($field->data) && !in_array($field->fieldName, $notRequiredFields)) {
                                if ($field->fieldName === 'Applicant No') {
                                    $applicant = $db->readOne('applicants', ['id'], [['column' => 'applicant_no', 'operator' => '=', 'value' => $field->data]]);
                                    if (!$applicant) {
                                        $samples[$key][$fieldIdx]->error = 'Invalid applicant number';
                                    }
                                } else {
                                    $samples[$key][$fieldIdx]->error = 'Field is required';
                                }
                            } else {
                                $samples[$key][$fieldIdx]->error = null;
                            }
                        }
                    }
                } else {
                    $file = $_FILES['import_file'];
                    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
                        echo json_encode(['success' => false, 'error' => 'Missing or invalid file upload']);
                        http_response_code(400);
                        break;
                    }
                    try {
                        $spreadsheet = IOFactory::load($file['tmp_name']);
                        $sheet = $spreadsheet->getActiveSheet();
                        $data = $sheet->toArray();
                        if ($dataRowStart < 1 || $dataRowStart > count($data)) {
                            echo json_encode(['success' => false, 'error' => 'Invalid data row start']);
                            http_response_code(400);
                            break;
                        }
                        $dataRows = array_slice($data, $dataRowStart - 1);
                        foreach ($dataRows as $rowIndex => $row) {
                            foreach ($applicantFields as $fieldIndex => $field) {
                                $headerIndex = $field->headerIndex;
                                $samples[$rowIndex][$fieldIndex]['fieldName'] = $field->fieldName;
                                $samples[$rowIndex][$fieldIndex]['fieldId'] = $field->fieldId . '_' . $rowIndex;
                                $samples[$rowIndex][$fieldIndex]['data'] = isset($row[$headerIndex]) ? trim($row[$headerIndex]) : '';
                                if (empty($samples[$rowIndex][$fieldIndex]['data']) && !in_array($field->fieldName, $notRequiredFields)) {
                                    if ($field->fieldName === 'Applicant No') {
                                        $applicant = $db->readOne('applicants', ['id'], [['column' => 'applicant_no', 'operator' => '=', 'value' => $samples[$rowIndex][$fieldIndex]['data']]]) ?? null;
                                        if (!$applicant) {
                                            $samples[$rowIndex][$fieldIndex]['error'] = 'Invalid applicant number';
                                        }
                                    } else {
                                        $samples[$rowIndex][$fieldIndex]['error'] = 'Field is required';
                                    }
                                } else {
                                    $samples[$rowIndex][$fieldIndex]['error'] = null;
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
            case 'import':
                $applicantFields = json_decode($_POST['applicant_fields']);
                $dataRowStart = intval($_POST['data_row_start']);
                $file = $_FILES['import_file'];
                try {
                    $spreadsheet = IOFactory::load($file['tmp_name']);
                    $sheet = $spreadsheet->getActiveSheet();
                    $data = $sheet->toArray();
                    $dataRows = array_slice($data, $dataRowStart - 1);
                    $successCount = 0;
                    foreach ($dataRows as $row) {
                        $data = [];
                        foreach ($applicantFields as $field) {
                            $headerIndex = intval($field->headerIndex);
                            $value = isset($row[$headerIndex]) ? trim($row[$headerIndex]) : '';
                            if ($field->fieldName === 'Applicant No') {
                                $applicant = $db->readOne('applicants', ['id'], [['column' => 'applicant_no', 'operator' => '=', 'value' => $value]]);
                                if ($applicant) {
                                    $data['applicant_id'] = $applicant['id'];
                                } else {
                                    continue; // Skip invalid applicant
                                }
                            } elseif ($field->fieldName === 'Date Taken') {
                                $data['date_taken'] = $value;
                            } elseif ($field->fieldName === 'General Ability') {
                                $data['general_ability'] = $value ? intval($value) : 0;
                            } elseif ($field->fieldName === 'Verbal Aptitude') {
                                $data['verbal_aptitude'] = $value ? intval($value) : 0;
                            } elseif ($field->fieldName === 'Numerical Aptitude') {
                                $data['numerical_aptitude'] = $value ? intval($value) : 0;
                            } elseif ($field->fieldName === 'Spatial Aptitude') {
                                $data['spatial_aptitude'] = $value ? intval($value) : 0;
                            } elseif ($field->fieldName === 'Perceptual Aptitude') {
                                $data['perceptual_aptitude'] = $value ? intval($value) : 0;
                            } elseif ($field->fieldName === 'Manual Dexterity') {
                                $data['manual_dexterity'] = $value ? intval($value) : 0;
                            } elseif ($field->fieldName === 'Remarks') {
                                $data['remarks'] = $value ?: null;
                            }
                        }
                        if ($db->create('test_results', $data)) {
                            $successCount++;
                        }
                    }
                    echo json_encode(['success' => true, 'message' => "$successCount exam results imported successfully"]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                }
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