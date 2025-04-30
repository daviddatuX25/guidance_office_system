<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user) {
    $redirectDIR  =  'index.php';
    header("Location: $redirectDIR");
    $_SESSION['login_popup'] = true; 
    $_SESSION['redirectPage'] = 'icat.php';
    exit;
    }
?>