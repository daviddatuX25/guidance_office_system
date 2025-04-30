<?php
require_once  './Main.php';

header('Content-Type: application/json');
error_log("POST Data: " . print_r($_POST, true));

// Define columns
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

// Define joins
$joins = [
    ['type' => 'LEFT', 'table' => 'strands s', 'condition' => 'a.strand_id = s.id'],
    ['type' => 'LEFT', 'table' => 'courses c1', 'condition' => 'a.course_1_id = c1.id'],
    ['type' => 'LEFT', 'table' => 'courses c2', 'condition' => 'a.course_2_id = c2.id'],
    ['type' => 'LEFT', 'table' => 'courses c3', 'condition' => 'a.course_3_id = c3.id'],
    ['type' => 'LEFT', 'table' => 'test_results tr', 'condition' => 'a.id = tr.applicant_id']
];

// Define filters
$where = []; // Default filter
if (!empty($_POST['application_term'])) {
    $where = [
        ['column' => 'a.application_term_id', 'operator' => '=', 'value' => $_POST['application_term']]
    ];
}

$data = $db->readAll('applicants a', $columns, $where, $joins, null );
$result = [
    "draw" => intval($_POST['draw'] ?? 0),
    "recordsTotal" => count($data),
    "data" => $data
];

// Return JSON response
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
http_response_code(200);
exit;
?>
