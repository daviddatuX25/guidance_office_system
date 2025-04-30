<nav class="navbar navbar-expand navbar-light bg-light sticky-top">
    <div class="w-50 d-block d-md-none">
        <button class=" btn btn-primary m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="container justify-content-center">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link <?=$nav_index ?? '';?>" href="index.php" aria-current="page">Home</a>
            <a class="nav-item nav-link <?=$nav_icat ?? '';?>" href="icat.php">ICAT</a>
        </div>
    </div>
    <?php if (isset($nav_index) && !isset($_SESSION['user'])):?>
     <button type="button" class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
    <?php endif; ?>
    <?php if (isset($_SESSION['user'])):?>
        <button type="button" id="logout-button" class="btn btn-primary mx-3">Logout</button>
    <?php endif; ?>
</nav>