$(document).ready(function() {
    // Restore last selected tab
    let lastSelected_icatNav = localStorage.getItem('lastSelected_icatNav');
    if (lastSelected_icatNav) {
        // Target both sidebarNav and sidebarNavDesktop, find nav-link with matching nav-text
        $('#sidebarNav, #sidebarNavDesktop').find('.nav-link').each(function() {
            if ($(this).find('.nav-text').text().trim() === lastSelected_icatNav) {
                $(this).tab('show'); // Activate the tab using Bootstrap
            }
        });
    }

    // Save clicked nav link to localStorage
    $('#sidebarNav, #sidebarNavDesktop').on('click', '.nav-link', function() {
        console.log("wa");
        lastSelected_icatNav = $(this).find('.nav-text').text().trim(); // Get text from .nav-text
        localStorage.setItem('lastSelected_icatNav', lastSelected_icatNav);
    });
});