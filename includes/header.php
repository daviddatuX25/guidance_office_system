<!DOCTYPE html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICAT System</title>
    <!--CSS  -->
    <link rel="stylesheet" href="./libraries/bootstrap.min.css">
    <link rel="stylesheet" href="./libraries/DataTables/datatables.min.css"> <!-- DataTables CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- JS -->
    <script defer src="./libraries/bootstrap.bundle.js"></script> <!-- Bootstrap JS Bundle with Popper -->
    <script defer src="./libraries/DataTables/datatables.min.js"></script> <!-- DataTables JS -->
    <script src="./libraries/jquery.js"></script> <!-- jQuery library -->
    <script src="./src/js/main.js"></script> <!-- Main script -->
</head>
<body>

<!-- Notification (Absolute, Top-Right, Small) -->
<div id="notification" class="d-none position-absolute top-0 end-0 m-3 p-3 bg-light border rounded shadow-sm" style="z-index: 1050;">
    <div class="d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Notification</h6>
        <button type="button" class="btn-close" id="closeNotification" aria-label="Close"></button>
    </div>
    <div class="mt-2">
        <p id="notifMessage">This is a notification message.</p>
    </div>
</div>
<?php
 if (isset($_SESSION['loginMessage'])) {
    echo '<script>showNotification("success"," '. $_SESSION['loginMessage'] . '  ");</script>';
    unset($_SESSION['loginMessage']);
}
?>