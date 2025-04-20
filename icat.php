<?php

require_once './verify.php';
// require_once 'vendor/autoload.php';
require_once 'server/db.php';

include_once 'includes/header.php';
$nav_icat = "active";
include_once 'includes/navbar.php';
?>

<div class="d-flex flex-wrap w-100">
    <!-- Off-Canvas for Small Screens, Sidebar for Medium and Up -->
    <div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel" style="width: 250px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-3">
            <ul class="nav nav-pills flex-column mb-auto" id="sidebarNav" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="dashboard-tab" data-bs-toggle="pill" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">
                        <i class="fas fa-chart-line me-2"></i><span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="applicants-tab" data-bs-toggle="pill" href="#applicants" role="tab" aria-controls="applicants" aria-selected="false">
                        <i class="fa-solid fa-user-tie me-2"></i><span class="nav-text">Applicants</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="examResults-tab" data-bs-toggle="pill" href="#examResults" role="tab" aria-controls="examResults" aria-selected="false">
                        <i class="fa-solid fa-newspaper me-2"></i><span class="nav-text">Exam Results</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="settings-tab" data-bs-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">
                        <i class="fas fa-cog me-2"></i><span class="nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

   <!-- Sidebar for Medium and Larger Screens -->
   <div class="bg-light h-100 d-none d-md-block collapse" id="desktopSidebar" style="min-width: 150px; width: 18%;">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light h-100">
            <ul class="nav nav-pills flex-column mb-auto" id="sidebarNavDesktop" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active d-flex align-items-center" id="dashboard-tab-desktop" data-bs-toggle="pill" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">
                        <i class="fas fa-chart-line me-md-2"></i><span class="nav-text d-none d-md-inline">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="applicants-tab-desktop" data-bs-toggle="pill" href="#applicants" role="tab" aria-controls="applicants" aria-selected="false">
                        <i class="fa-solid fa-user-tie me-md-2"></i><span class="nav-text d-none d-md-inline">Applicants</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="examResults-tab-desktop" data-bs-toggle="pill" href="#examResults" role="tab" aria-controls="examResults" aria-selected="false">
                        <i class="fa-solid fa-newspaper me-md-2"></i><span class="nav-text d-none d-md-inline">Exam Results</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="settings-tab-desktop" data-bs-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">
                        <i class="fas fa-cog me-md-2"></i><span class="nav-text d-none d-md-inline">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <button class="btn btn-primary d-none d-md-block position-absolute top-0 start-0 m-3" type="button" data-bs-toggle="collapse" data-bs-target="#desktopSidebar" aria-expanded="true" aria-controls="desktopSidebar">
            <i class="fas fa-bars"></i>
    </button>
    <!-- Main Content -->
    <main class="px-md-4 py-3 flex-grow-1 " style="width: 80%; height:100%">
        <!-- Off-Canvas Toggle Button for Small Screens -->
        <button class="btn btn-primary d-block d-md-none position-absolute top-0 start-0 m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
            <i class="fas fa-bars"></i>
        </button>
    

        <div class="tab-content" id="sidebarNavContent">
            <div class="p-3 tab-pane show active fade" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <?php include_once 'pages/icat/dashboard.php'; ?>
            </div>
            <div class="p-3 tab-pane fade" id="applicants" role="tabpanel" aria-labelledby="applicants-tab">
                <?php include_once 'pages/icat/applicants.php'; ?>
            </div>
            <div class="p-3 tab-pane fade" id="examResults" role="tabpanel" aria-labelledby="examResults-tab">
                <?php include_once 'pages/icat/exam_results.php'; ?>
            </div>
            <div class="p-3 tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <?php include_once 'pages/icat/settings.php'; ?>
            </div>
        </div>
    </main>
</div>


<!-- Load Subpage JScripts -->
 <script src="./src/js/icat/main.js"></script>
 <script src="./src/js/icat/applicant.js"></script>

<?php
include_once 'includes/footer.php';
?>