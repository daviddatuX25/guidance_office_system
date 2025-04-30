<!-- Off-Canvas for Small Screens, Sidebar for Medium and Up -->
<div class="offcanvas offcanvas-start bg-light" data-bs-backdrop="false" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel" style="width: 250px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
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
                <a class="nav-link" id="settings-tab"  data-bs-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">
                    <i class="fas fa-cog me-2"></i><span class="nav-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Sidebar for Medium and Larger Screens -->
<div class="collapse bg-light h-100 d-none d-md-block" id="desktopSidebar" style="min-width: 150px; width: 18%;">
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