<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 1);

require_once '../../verify.php';

require_once '../db.php';

require_once '../DataTable.php';

$db = new Database();
$conn = $db->getConnection();
$dataTable = new DataTable($db);

header('Content-Type: application/json');
error_log("POST Data: " . print_r($_POST, true));
// Define columns
print_r($_POST, true);
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
    ['type' => 'LEFT', 'table' => 'strands s', 'on' => 'a.strand_id = s.id'],
    ['type' => 'LEFT', 'table' => 'courses c1', 'on' => 'a.course_1_id = c1.id'],
    ['type' => 'LEFT', 'table' => 'courses c2', 'on' => 'a.course_2_id = c2.id'],
    ['type' => 'LEFT', 'table' => 'courses c3', 'on' => 'a.course_3_id = c3.id'],
    ['type' => 'LEFT', 'table' => 'test_results tr', 'on' => 'a.id = tr.applicant_id']
];

// Define filters
$filters = []; // Default filter
if (!empty($_POST['application_term'])) {
    $filters['a.application_term_id'] = $_POST['application_term'];
}

// Fetch data without pagination or ordering
$result = $dataTable->fetch(
    'applicants a',
    $columns,
    $joins,
    $filters
);

// Return JSON response
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>
