



<?php
session_start();
include_once 'includes/header.php';
$nav_index = "active";
include_once 'includes/navbar.php';
include_once 'includes/loginForm.php';

if ($_SESSION['login_popup'] ?? false):
    if(!isset($_SESSION['user'])):?>
    <script>
         $(document).ready(function() {
            $('#loginModal').modal("show");
         });
         showNotification('warning', 'Please login to access this page.');
    </script>
<?php endif;endif;
$_SESSION['login_popup'] = false;

?>

<header class="text-center py-5 bg-light">
    <div class="container">
      <h1 class="display-4">Welcome to Guidance & Counselling</h1>
      <p class="lead">Supporting your well-being, academic growth, and personal development.</p>
      <a href="#" class="btn btn-primary btn-lg">Book a Session</a>
    </div>
  </header>

  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Mental Health Support</h5>
              <p class="card-text">Talk to a counselor about anxiety, stress, or emotional concerns in a safe, confidential space.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Career Guidance</h5>
              <p class="card-text">Explore career options and make informed decisions about your future path with expert advice.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Academic Counselling</h5>
              <p class="card-text">Get help with time management, study habits, and learning strategies tailored to your needs.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

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