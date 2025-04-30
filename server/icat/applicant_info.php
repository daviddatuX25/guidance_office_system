<?php
require_once './Main.php';
header('Content-Type: application/json');
global $db;

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
    } else {
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
                    'course_2_id' => $_POST['course_2_id'],
                    'course_3_id' => $_POST['course_3_id']
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
                    echo json_encode(['success' => false], ['error' => 'Failed to delete applicant']);
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
                    echo json_encode(['success' => false], ['error' => 'Failed to delete applicants']);
                    http_response_code(500);
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