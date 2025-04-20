<nav class="navbar navbar-expand navbar-light bg-light sticky-top">
    <div class="w-50 d-block d-md-none"></div>
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