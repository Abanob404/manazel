<?php 
// templates/pages/admin/manage-users.php
$page_title = trans("nav_manage_users"); // For admin_layout.php
require_once TEMPLATES_PATH . 
'/layouts/admin_layout.php'; 

// Simulate fetching users - replace with actual database query and pagination
$users = [
    ["id" => 1, "username" => "adminuser", "email" => "admin@example.com", "role" => "admin", "registration_date" => "2023-01-01"],
    ["id" => 2, "username" => "johndoe", "email" => "john.doe@example.com", "role" => "user", "registration_date" => "2023-02-15"],
    ["id" => 3, "username" => "janedoe", "email" => "jane.doe@example.com", "role" => "user", "registration_date" => "2023-03-20"],
    ["id" => 4, "username" => "testuser1", "email" => "test1@example.com", "role" => "user", "registration_date" => "2023-04-10"],
];

?>

<div class="admin-actions">
    <!-- <a href="#" class="btn btn-primary">Add New User</a> Link to add new user form (optional) -->
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th><?php echo trans("username"); ?></th>
            <th><?php echo trans("email"); ?></th>
            <th>Role</th>
            <th>Registration Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user["id"]; ?></td>
                    <td><?php echo e($user["username"]); ?></td>
                    <td><?php echo e($user["email"]); ?></td>
                    <td><?php echo e(ucfirst($user["role"])); ?></td>
                    <td><?php echo $user["registration_date"]; ?></td>
                    <td class="actions">
                        <a href="#" class="btn btn-sm btn-edit">Edit</a> <!-- Link to edit user form -->
                        <?php if ($user["role"] !== "admin"): // Prevent deleting admin through this simple interface ?>
                            <a href="#" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No users found.</td>
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
require_once TEMPLATES_PATH . 
'/layouts/footer_admin.php'; 
?>
