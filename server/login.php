<?php
header('Content-Type: application/json');
// Login Authenticate

if(isset($_POST['username']) && isset($_POST['password'])) {
    require_once 'db.php';
    $db = new Database();

    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    // When verifying login
    $columns = ['*'];
    $where = [
        ['column' => 'username', 'operator' => '=', 'value' => $username],
        ['column' => 'password', 'operator' => '=', 'value' => $password]
    ];
    $user = $db->readOne('adminuser', $columns, $where, [], [], null);
  
    if ($user) {
        $response['success'] = true;
        session_start();
        $_SESSION['loginMessage'] = "You have successfully logged in,  " . $user['nickname'] . "!";
        $_SESSION['user'] = $user;
        $response['redirectPage'] =  $_SESSION['redirectPage'] ?? 'index.php';
        unset($_SESSION['redirectPage']);
    } else {
        
        $response['success'] = false;
        $response['notifMessage'] = 'Username and password do not match.';
    }
    echo json_encode($response);
    exit;
} else {
    $response = ['success' => false];
    $response['notifMessage'] = 'Invalid Login Credentials!';
    echo json_encode($response);
    exit;
}
?>