<?php
// templates/pages/register.php

require_once __DIR__ . 
    '/../../src/auth.php
'; // Include auth functions

$page_title = lang(
    'register'
); // For header.php to pick up

$error_message = null;
$success_message = null;

if ($_SERVER[
    'REQUEST_METHOD'
] === 'POST') {
    $fullname = trim($_POST[
        'fullname'
    ] ?? '');
    $username = trim($_POST[
        'username'
    ] ?? '');
    $email = trim($_POST[
        'email'
    ] ?? '');
    $phone = trim($_POST[
        'phone'
    ] ?? '');
    $password = $_POST[
        'password'
    ] ?? '';
    $confirm_password = $_POST[
        'confirm_password'
    ] ?? '';

    // Basic Validation
    if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = lang(
            'fill_required_fields'
        );
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error_message = "Username must be between 3 and 50 characters."; // Consider adding to lang files
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long."; // Consider adding to lang files
    } elseif ($password !== $confirm_password) {
        $error_message = lang(
            'passwords_do_not_match'
        );
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = lang(
            'invalid_email_format'
        );
    } else {
        // Attempt to register the user
        $registration_result = register_user($fullname, $username, $email, $password, $phone ?: null);

        if ($registration_result[
            'success'
        ]) {
            // Registration successful, redirect to login page with a success message
            // Or set a success message and clear form fields
            $_SESSION[
                'success_message'
            ] = lang(
                'registration_successful'
            ) . " " . lang(
                'login_now_prompt_en_ar'
            );
            header('Location: ' . base_url(
                '?page=login&registered=true'
            ));
            exit;
        } else {
            // Registration failed, display error message
            $error_message = $registration_result[
                'message'
            ];
        }
    }
}

?>

<div class="container auth-page py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center"><?php echo lang(
                        'register'
                    ); ?></h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION[
                        'error_message'
                    ])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($_SESSION[
                                'error_message'
                            ]); unset($_SESSION[
                                'error_message'
                            ]); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($success_message): // This might not be shown if redirecting on success ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($success_message); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo base_url(
                        '?page=register'
                    ); ?>" method="POST">
                        <div class="mb-3">
                            <label for="fullname" class="form-label"><?php echo lang(
                                'full_name'
                            ); ?></label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required value="<?php echo isset($_POST[
                                'fullname'
                            ]) ? htmlspecialchars($_POST[
                                'fullname'
                            ]) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label"><?php echo lang(
                                'username'
                            ); ?></label>
                            <input type="text" class="form-control" id="username" name="username" required value="<?php echo isset($_POST[
                                'username'
                            ]) ? htmlspecialchars($_POST[
                                'username'
                            ]) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo lang(
                                'email_address'
                            ); ?></label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_POST[
                                'email'
                            ]) ? htmlspecialchars($_POST[
                                'email'
                            ]) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label"><?php echo lang(
                                'phone_number'
                            ); ?> <small class="text-muted">(<?php echo lang(
    'optional_en_ar'
); ?>)</small></label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST[
                                'phone'
                            ]) ? htmlspecialchars($_POST[
                                'phone'
                            ]) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo lang(
                                'password'
                            ); ?></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label"><?php echo lang(
                                'confirm_password'
                            ); ?></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><?php echo lang(
                                'register'
                            ); ?></button>
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                        <p><?php echo lang(
                            'already_have_account'
                        ); ?> <a href="<?php echo base_url(
    '?page=login'
); ?>"><?php echo lang(
    'login'
); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

