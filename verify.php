<?php
session_start();
$userId = $_SESSION['userId'] ?? null;
if (!$userId) {
    $redirectDIR  =  '/' . basename(__DIR__) . '/index.php';
    header("Location: $redirectDIR");
    $_SESSION['login_popup'] = true; 
    $_SESSION['redirectPage'] = 'icat.php';
    exit;
    }
?>