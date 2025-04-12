<nav class="navbar navbar-expand navbar-light bg-light">
    <?php if(isset($nav_icat)):?>
        <button class="btn d-md-none mx-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-expanded="false" aria-controls="sidebarMenu">
            <i class="fas fa-bars text-primary"></i>
        </button>    
    <?php endif;?>
    <div class="container justify-content-center">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link <?=$nav_index ?? '';?>" href="index.php" aria-current="page">Home</a>
            <a class="nav-item nav-link <?=$nav_icat ?? '';?>" href="icat.php">ICAT</a>
        </div>
    </div>
    <?php if (isset($nav_index) && !isset($_SESSION['userId'])):?>
     <button type="button" class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
    <?php endif; ?>
    <?php if (isset($_SESSION['userId'])):?>
        <button type="button" id="logout-button" class="btn btn-primary mx-3">Logout</button>
    <?php endif; ?>

</nav>