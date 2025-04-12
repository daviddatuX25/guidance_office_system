<?php
session_start();
include_once 'includes/header.php';
$nav_index = "active";
include_once 'includes/navbar.php';
include_once 'includes/loginForm.php';

if ($_SESSION['login_popup'] ?? false):
    if(!isset($_SESSION['userId'])):?>
    <script>
         $(document).ready(function() {
            $('#loginModal').modal("show");
         });
         showNotification('warning', 'Please login to access this page.');
    </script>
<?php endif;endif;
$_SESSION['login_popup'] = false;

?>

<script>
    $('#submit-login').click(function(e){
        e.preventDefault();
        const username = $('#username').val();
        const password = $('#password').val();
        if(username && password) {
            $.ajax({
                url: 'server/login.php',
                type: 'POST',
                data: {username: username, password: password},
                success: function(response) {
                    if(response.success) {
                        window.location.href = response.redirectPage || 'index.php';
                    } else {
                        showNotification('warning', response.notifMessage);
                    }
                },
                error: function() {
                    showNotification('warning', 'An error occurred. Please try again.');
                }
            });
        } else {
            showNotification('warning', 'Please fill in all fields.');
        }

    })
</script>

<?php include_once 'includes/footer.php'?>