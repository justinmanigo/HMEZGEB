// If #app-sidebar has toggled class, then show #logo-toggled and hide #logo.
// Otherwise, show #logo and hide #logo-toggled.
// Shall update when page size is changed.
// or when #sidebar-toggle is clicked.
$(document).on('click', '#sidebarToggle', function() {
    console.log('sidebarToggle clicked');
    toggleSidebarLogo();
});

$(window).on('resize', function() {
    console.log("resized");
    toggleSidebarLogo();
});

toggleSidebarLogo();

function toggleSidebarLogo()
{
    if ($('body').hasClass('sidebar-toggled')) {
        $('#logo-toggled').attr('style', 'display: flex !important');
        $('#logo').attr('style', 'display: none !important');
    } else {
        $('#logo-toggled').attr('style', 'display: none !important');
        $('#logo').attr('style', 'display: flex !important');
    }
}
