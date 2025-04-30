<?php

require_once 'server/verify.php';
// require_once 'vendor/autoload.php';
require_once 'server/db.php';
$db = new Database();
include_once 'includes/header.php';
$nav_icat = "active";
include_once 'includes/navbar.php';
?>

<div class="d-flex flex-wrap w-100">
    <?php include_once 'includes/icat_sidebar.php'; ?>
    <!-- Main Content -->
    <main class="px-md-4 py-3 flex-grow-1 " style="width: 80%; height:100%">
        <div class="tab-content " id="sidebarNavContent">
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