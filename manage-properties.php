<?php 
// templates/pages/admin/manage-properties.php
$page_title = trans("nav_manage_properties"); // For admin_layout.php
require_once TEMPLATES_PATH . 
'/layouts/admin_layout.php'; 

// Simulate fetching properties - replace with actual database query and pagination
$properties = [
    ["id" => 1, "title_en" => "Beachfront Condo", "title_ar" => "شقة على الشاطئ", "status" => "available", "price" => 750000, "date_listed" => "2023-01-10"],
    ["id" => 2, "title_en" => "Suburban House", "title_ar" => "منزل بالضواحي", "status" => "sold", "price" => 550000, "date_listed" => "2023-02-05"],
    ["id" => 3, "title_en" => "Downtown Apartment", "title_ar" => "شقة بوسط المدينة", "status" => "available", "price" => 920000, "date_listed" => "2023-03-15"],
    ["id" => 4, "title_en" => "Luxury Villa with Sea View", "title_ar" => "فيلا فاخرة بإطلالة على البحر", "status" => "available", "price" => 2300000, "date_listed" => "2023-04-20"],
];

?>

<div class="admin-actions">
    <a href="#" class="btn btn-primary"><?php echo trans("add_new_property"); ?></a> <!-- Link to add new property form -->
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th><?php echo trans("property_title_label"); ?> (EN)</th>
            <th><?php echo trans("property_title_label"); ?> (AR)</th>
            <th>Status</th>
            <th><?php echo trans("price"); ?></th>
            <th>Date Listed</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($properties)): ?>
            <?php foreach ($properties as $property): ?>
                <tr>
                    <td><?php echo $property["id"]; ?></td>
                    <td><?php echo e($property["title_en"]); ?></td>
                    <td><?php echo e($property["title_ar"]); ?></td>
                    <td><span class="status-<?php echo e($property["status"]); ?>"><?php echo e(ucfirst($property["status"])); ?></span></td>
                    <td>$<?php echo number_format($property["price"]); ?></td>
                    <td><?php echo $property["date_listed"]; ?></td>
                    <td class="actions">
                        <a href="#" class="btn btn-sm btn-edit">Edit</a> <!-- Link to edit property form -->
                        <a href="#" class="btn btn-sm btn-delete" onclick="return confirm(\'Are you sure you want to delete this property?\');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No properties found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Basic Pagination Placeholder -->
<nav class="pagination admin-pagination">
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">Next &raquo;</a>
</nav>

<?php 
// The admin_layout.php includes the closing tags for the page structure.
require_once TEMPLATES_PATH . 
'/layouts/footer_admin.php'; // Assuming a specific admin footer or rely on the main one in admin_layout
?>
