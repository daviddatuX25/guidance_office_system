<?php
    session_start();
    $userId = $_SESSION['userId'] ?? null;

    if (!$userId) {
        header("Location: index.php");
        $_SESSION['login_popup'] = true; 
        $_SESSION['redirectPage'] = 'icat.php';
        exit;
    }
 
    require_once 'vendor/autoload.php';
    require_once 'server/db.php';

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
                    <a class="nav-link active d-flex align-items-center" id="dashboard-tab" data-bs-toggle="pill" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false">
                        <i class="fas fa-chart-line me-md-2"></i><span class="nav-text d-none d-md-inline">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="applicants-tab" data-bs-toggle="pill" href="#applicants" role="tab" aria-controls="applicants" aria-selected="false">
                    <i class="fa-solid fa-user-tie me-md-2"></i><span class="nav-text d-none d-md-inline">Applicants</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="exam-results-tab" data-bs-toggle="pill" href="#exam-results" role="tab" aria-controls="exam-results" aria-selected="false">
                        <i class="fa-solid fa-newspaper me-md-2"></i><span class="nav-text d-none d-md-inline">Exam Results</span>
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
            <div class="tab-pane show active fade" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <?php include_once 'icat/dashboard.php'; ?>
            </div>
            <div class="tab-pane fade" id="applicants" role="tabpanel" aria-labelledby="applicants-tab">
                <?php include_once 'icat/applicants.php'; ?>
            </div>
            <div class="tab-pane fade" id="exam-results" role="tabpanel" aria-labelledby="exam-results-tab">
                <?php include_once 'icat/exam_results.php'; ?>
            </div>
            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <?php include_once 'icat/settings.php'; ?>
            </div>
        </div>
    </main>
</div>

<?php
include_once 'includes/footer.php';
?>

