<?php
header('Content-Type: application/json');
// Login Authenticate

if(isset($_POST['username']) && isset($_POST['password'])) {
    require_once 'db.php';
    $db = new Database();
    $conn = $db->getConnection();

    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    // When verifying login
    $user = $db->read(['username' => $username, 'password' => $password], 'users');
    if ($user) {
        $response['userId'] = $user['userId'];
        $response['success'] = true;
        $response['notifMessage'] = 'Login successful!';
        session_start();
        $response['redirectPage'] =  $_SESSION['redirectPage'] ?? 'index.php';
        unset($_SESSION['redirectPage']);
        $_SESSION['userId'] = $user['userId'];
    } else {
        $response['success'] = false;
        $response['notifMessage'] = 'Username and password do not match.';
    }
    echo json_encode($response);
} else {
    $response = ['success' => false];
    $response['notifMessage'] = 'Invalid Login Credentials!';
    echo json_encode($response);
}
?>