<?php 
// templates/pages/admin/dashboard.php
$page_title = trans("admin_dashboard_title"); // For admin_layout.php
require_once TEMPLATES_PATH . 
'/layouts/admin_layout.php'; 
?>

<div class="admin-stats-overview">
    <div class="stat-card">
        <h3>Total Properties</h3>
        <p>150</p> <!-- Placeholder -->
    </div>
    <div class="stat-card">
        <h3>Active Users</h3>
        <p>75</p> <!-- Placeholder -->
    </div>
    <div class="stat-card">
        <h3>Pending Approvals</h3>
        <p>5</p> <!-- Placeholder -->
    </div>
    <div class="stat-card">
        <h3>New Messages</h3>
        <p>12</p> <!-- Placeholder -->
    </div>
</div>

<section class="recent-activity">
    <h2>Recent Activity</h2>
    <ul>
        <li>User "JohnDoe" registered.</li>
        <li>Property "Luxury Villa" updated by admin.</li>
        <li>New rating submitted for "Downtown Apartment".</li>
    </ul>
</section>

<?php 
// The admin_layout.php already includes a closing </div> for admin-page-content and the main footer for the layout.
// We just need to ensure the main content of this specific page is here.
require_once TEMPLATES_PATH . 
'/layouts/footer_admin.php'; // A specific admin footer if needed, or just rely on the main one.
// For now, let's assume admin_layout.php's structure is sufficient and doesn't need a separate footer_admin.php
// The admin_layout.php should end with </div></main></div></body></html>
?>
