<?php
require_once '../verify.php'; // Avoid entry for direct access
require_once  '../db.php';

$db = new Database();
if (!$db) {
    echo "database connection error";
    exit;
}
?>