<?php
// Include PHPSpreadsheet classes
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database connection
$conn = mysqli_connect("localhost", "root", "", "rohanne");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the database
$sql = "SELECT * FROM tbl_applicants";
$result = mysqli_query($conn, $sql);

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'ILOCOS SUR POLYTECHNIC STATE COLLEGE');
$sheet->setCellValue('A2', 'TAGUDIN CAMPUS');
$sheet->setCellValue('A3', 'ICAT RESULTS');

// Set column headers
$sheet->setCellValue('A5', 'Application Number');
$sheet->setCellValue('B5', 'Family Name');
$sheet->setCellValue('C5', 'First Name');
$sheet->setCellValue('D5', 'Middle Name');
$sheet->setCellValue('E5', 'Sex');
$sheet->setCellValue('F5', 'Strand');
$sheet->setCellValue('G5', 'Course');
$sheet->setCellValue('H5', 'General Ability');
$sheet->setCellValue('I5', 'Verbal Aptitude');
$sheet->setCellValue('J5', 'Numerical Aptitude');
$sheet->setCellValue('K5', 'Spatial Aptitude');
$sheet->setCellValue('L5', 'Perceptual Aptitude');
$sheet->setCellValue('M5', 'Manual Dexterity');
$sheet->setCellValue('N5', 'Date Taken');

// Fill data from the database
$rowIndex = 6;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . $rowIndex, $row['appNo']);
        $sheet->setCellValue('B' . $rowIndex, $row['lastname']);
        $sheet->setCellValue('C' . $rowIndex, $row['firstname']);
        $sheet->setCellValue('D' . $rowIndex, $row['midname']);
        $sheet->setCellValue('E' . $rowIndex, $row['sex']);
        $sheet->setCellValue('F' . $rowIndex, $row['strand']);
        $sheet->setCellValue('G' . $rowIndex, $row['course']);
        $sheet->setCellValue('H' . $rowIndex, $row['genAbility']);
        $sheet->setCellValue('I' . $rowIndex, $row['verbal']);
        $sheet->setCellValue('J' . $rowIndex, $row['numerical']);
        $sheet->setCellValue('K' . $rowIndex, $row['s_patial']);
        $sheet->setCellValue('L' . $rowIndex, $row['p_erceptual']);
        $sheet->setCellValue('M' . $rowIndex, $row['m_anDexterity']);
        $sheet->setCellValue('N' . $rowIndex, $row['date_taken']);
        $rowIndex++;
    }
}

// Save Excel file
$filename = "ICATS_results_" . date('Ymd') . ".xlsx";
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// Set headers to force download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Clear output buffer to prevent unwanted output in the downloaded file
ob_end_clean();

// Output the file to the browser
readfile($filename);

// Close connection
mysqli_close($conn);
?>
