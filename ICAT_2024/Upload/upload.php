<?php
require 'vendor/autoload.php'; // Include the PhpSpreadsheet autoload file

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK && $_FILES['excelFile']['size'] > 0) {
    $tmpName = $_FILES['excelFile']['tmp_name'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'rohanne');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Load the spreadsheet
    $spreadsheet = IOFactory::load($tmpName);

    // Get the first worksheet
    $worksheet = $spreadsheet->getActiveSheet();

    $sql = "CREATE TABLE IF NOT EXISTS tbl_applicants (
        `id` INT(200) AUTO_INCREMENT PRIMARY KEY,
        `appNo` VARCHAR(255),
        `lastname` VARCHAR(255),
        `firstname` VARCHAR(255),
        `midname.` VARCHAR(255),
        `sex` VARCHAR(255),
        `strand` VARCHAR(255),
        `course` VARCHAR(255),
        `genAbility` VARCHAR(255),
        `verbal` VARCHAR(255),
        `numerical` VARCHAR(255),
        `s_patial` VARCHAR(255),
        `p_erceptual` VARCHAR(255),
        `m_anDexterity` VARCHAR(255)
    )";

    if ($conn->query($sql) === FALSE) {
        echo "Error creating table: " . $conn->error;
    }


    $data = [];
    foreach ($worksheet->getRowIterator() as $row) {
        $rowData = [];
        foreach ($row->getCellIterator() as $cell) {
            $rowData[] = $cell->getValue();
        }
        $data[] = $rowData;
    }

    foreach ($data as $row) {
        $sql = "INSERT INTO tbl_applicants (`appNo`, `lastname`, `firstname`, `midname`, `sex`, `strand`, `course`, `genAbility`, `verbal`, `numerical`, `s_patial`, `p_erceptual`, `m_anDexterity`) 
        VALUES ('" . implode("','", $row) . "')";
        $conn->query($sql);
    }

    $conn->close();
    echo "Upload successful";
} else {
    echo "Upload failed";
}
?>
