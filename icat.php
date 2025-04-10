<?php
    session_start();
    $userId = $_SESSION['userId'] ?? null;

    if (!$userId) {
        header("Location: index.php");
        session_start();
        $_SESSION['login_popup'] = true; 
        $_SESSION['redirectPage'] = 'icat.php';
        exit;
    }
    require_once 'vendor/autoload.php';
    require_once 'db.php';

    include_once 'includes/header.php';
    $nav_icat = "active";
    include_once 'includes/navbar.php';
?>
<div class="d-flex flex-wrap">
    <!-- Sidebar with Nav Pills -->
    <div class="collapse bg-light h-100 d-md-block" id="sidebarMenu" data-width="full">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light h-100 w-md-25">
            <ul class="nav nav-pills flex-column mb-auto" id="sidebarNav" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active d-flex align-items-center" id="home-tab" data-bs-toggle="pill" href="#home" role="tab" aria-controls="home" aria-selected="true">
                        <i class="fas fa-home me-md-2"></i><span class="nav-text d-none d-md-inline">Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="dashboard-tab" data-bs-toggle="pill" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false">
                        <i class="fas fa-chart-line me-md-2"></i><span class="nav-text d-none d-md-inline">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="orders-tab" data-bs-toggle="pill" href="#orders" role="tab" aria-controls="orders" aria-selected="false">
                        <i class="fas fa-shopping-cart me-md-2"></i><span class="nav-text d-none d-md-inline">Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="products-tab" data-bs-toggle="pill" href="#products" role="tab" aria-controls="products" aria-selected="false">
                        <i class="fas fa-box me-md-2"></i><span class="nav-text d-none d-md-inline">Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="settings-tab" data-bs-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">
                        <i class="fas fa-cog me-md-2"></i><span class="nav-text d-none d-md-inline">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <main class="px-md-4 py-3">
        <div class="tab-content" id="sidebarNavContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h1>Home</h1>
                <p>Welcome to the Home section!</p>
            </div>
            <div class="tab-pane fade" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <h1>Dashboard</h1>
                <p>This is your Dashboard content.</p>
            </div>
            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <h1>Orders</h1>
                <p>View your Orders here.</p>
            </div>
            <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                <h1>Products</h1>
                <p>Manage your Products here.</p>
            </div>
            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <h1>Settings</h1>
                <p>Adjust your Settings here.</p>
            </div>
        </div>
    </main>
</div>

<?php
include_once 'includes/footer.php';
?>

