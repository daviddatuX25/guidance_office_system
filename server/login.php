<?php
header('Content-Type: application/json');
// Login Authenticate

if(isset($_POST['username']) && isset($_POST['password'])) {
    require_once 'db.php';
    $db = new Database();
    $db->getConnection();

    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    // When verifying login
    $user = $db->read(['username' => $username, 'password' => $password], 'adminuser');
    if ($user) {
        $response['success'] = true;
        session_start();
        $_SESSION['loginMessage'] = "You have successfully logged in,  " . $user['nickname'] . "!";
        $_SESSION['userId'] = $user['id'];
        $response['redirectPage'] =  $_SESSION['redirectPage'] ?? 'index.php';
        unset($_SESSION['redirectPage']);
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