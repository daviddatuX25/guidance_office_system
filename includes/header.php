<!DOCTYPE html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICAT System</title>
    <!--CSS  -->
    <link rel="stylesheet" href="./src/libraries/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- JS -->
    <script defer src="./src/libraries/bootstrap.bundle.js"></script>
    <script src="./src/libraries/jquery.js"></script>
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
<script>
    // Function to show notification
    function showNotification(status, message) {
        let statusClass; // Declare statusClass
        const $notification = $('#notification');
        const $notifMessage = $('#notifMessage');

        // Set status class based on type
        switch(status) {
            case "success":
                statusClass = "bg-success text-white";
                break;
            case "error":
                statusClass = "bg-danger text-white";
                break;
            case "warning":
                statusClass = "bg-warning text-dark";
                break;
            default:
                statusClass = "bg-light text-dark";
        }

        $notification
            .removeClass('d-none bg-light bg-success bg-danger bg-warning text-white text-dark')
            .addClass('d-block ' + statusClass);
        $notifMessage.text(message);

        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $notification
                .removeClass('d-block ' + statusClass)
                .addClass('d-none bg-light text-dark');
        }, 5000); // 5000ms = 5 seconds
    }

    // Close button functionality
    $('#closeNotification').on('click', function() {
        $('#notification').removeClass('d-block').addClass('d-none');
    });
</script>
