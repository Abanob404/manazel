<?php
// templates/pages/profile.php

require_once __DIR__ . 
    '/../../src/auth.php

'; // Include auth functions

// Ensure user is logged in
if (!is_logged_in()) {
    header('Location: ' . base_url(
        '?page=login'
    ));
    exit;
}

$page_title = lang(
    'my_profile'
); // For header.php to pick up

$user_id = $_SESSION[
    'user_id'
];
$user = get_user_by_id($user_id); // This function needs to be created in auth.php

$error_message_profile = null;
$success_message_profile = null;
$error_message_password = null;
$success_message_password = null;

// Handle profile update
if ($_SERVER[
    'REQUEST_METHOD'
] === 'POST' && isset($_POST[
    'update_profile'
])) {
    $fullname = trim($_POST[
        'fullname'
    ] ?? '');
    $email = trim($_POST[
        'email'
    ] ?? '');
    $phone = trim($_POST[
        'phone'
    ] ?? '');

    if (empty($fullname) || empty($email)) {
        $error_message_profile = lang(
            'fill_required_fields'
        );
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message_profile = lang(
            'invalid_email_format'
        );
    } else {
        $update_result = update_user_profile($user_id, $fullname, $email, $phone ?: null);
        if ($update_result[
            'success'
        ]) {
            $success_message_profile = lang(
                'profile_updated_successfully'
            );
            $user = get_user_by_id($user_id); // Refresh user data
        } else {
            $error_message_profile = $update_result[
                'message'
            ];
        }
    }
}

// Handle password change
if ($_SERVER[
    'REQUEST_METHOD'
] === 'POST' && isset($_POST[
    'change_password'
])) {
    $current_password = $_POST[
        'current_password'
    ] ?? '';
    $new_password = $_POST[
        'new_password'
    ] ?? '';
    $confirm_new_password = $_POST[
        'confirm_new_password'
    ] ?? '';

    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $error_message_password = lang(
            'fill_required_fields'
        );
    } elseif (strlen($new_password) < 6) {
        $error_message_password = "Password must be at least 6 characters long."; // Add to lang
    } elseif ($new_password !== $confirm_new_password) {
        $error_message_password = lang(
            'passwords_do_not_match'
        );
    } else {
        $change_password_result = change_user_password($user_id, $current_password, $new_password);
        if ($change_password_result[
            'success'
        ]) {
            $success_message_password = lang(
                'password_changed_successfully'
            );
        } else {
            $error_message_password = $change_password_result[
                'message'
            ];
        }
    }
}

?>

<div class="container profile-page py-5">
    <h2 class="mb-4"><?php echo lang(
        'my_profile'
    ); ?></h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <?php echo lang(
                        'edit_profile'
                    ); ?>
                </div>
                <div class="card-body">
                    <?php if ($error_message_profile): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error_message_profile); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($success_message_profile): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($success_message_profile); ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo base_url(
                        '?page=profile'
                    ); ?>">
                        <div class="mb-3">
                            <label for="fullname" class="form-label"><?php echo lang(
                                'full_name'
                            ); ?></label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user[
                                'full_name'
                            ] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label"><?php echo lang(
                                'username'
                            ); ?></label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user[
                                'username'
                            ] ?? ''); ?>" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo lang(
                                'email_address'
                            ); ?></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user[
                                'email'
                            ] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label"><?php echo lang(
                                'phone_number'
                            ); ?> <small class="text-muted">(<?php echo lang(
    'optional_en_ar'
); ?>)</small></label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user[
                                'phone_number'
                            ] ?? ''); ?>">
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary"><?php echo lang(
                            'update_profile'
                        ); ?></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <?php echo lang(
                        'change_password'
                    ); ?>
                </div>
                <div class="card-body">
                    <?php if ($error_message_password): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error_message_password); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($success_message_password): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($success_message_password); ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo base_url(
                        '?page=profile'
                    ); ?>">
                        <div class="mb-3">
                            <label for="current_password" class="form-label"><?php echo lang(
                                'current_password'
                            ); ?></label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label"><?php echo lang(
                                'new_password'
                            ); ?></label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_new_password" class="form-label"><?php echo lang(
                                'confirm_new_password'
                            ); ?></label>
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                        </div>
                        <button type="submit" name="change_password" class="btn btn-primary"><?php echo lang(
                            'change_password'
                        ); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4><?php echo lang(
            'followed_properties_en_ar'
        ); // Add to lang files ?></h4>
        <p><?php echo lang(
            'coming_soon_en_ar'
        ); // Add to lang files ?></p>
        <!-- Placeholder for followed properties -->
    </div>

    <div class="mt-4">
        <h4><?php echo lang(
            'my_ratings_en_ar'
        ); // Add to lang files ?></h4>
        <p><?php echo lang(
            'coming_soon_en_ar'
        ); ?></p>
        <!-- Placeholder for user's ratings -->
    </div>

</div>

<?php
// Add new language keys to lang/en.php and lang/ar.php
/*
// lang/en.php additions:
    'followed_properties_en_ar' => 'Followed Properties',
    'my_ratings_en_ar' => 'My Ratings',
    'coming_soon_en_ar' => 'This feature is coming soon.',
    'password_min_length_en_ar' => 'Password must be at least 6 characters long.',

// lang/ar.php additions:
    'followed_properties_en_ar' => 'العقارات المتبعة',
    'my_ratings_en_ar' => 'تقييماتي',
    'coming_soon_en_ar' => 'هذه الميزة ستتوفر قريباً.',
    'password_min_length_en_ar' => 'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل.',
*/
?>

