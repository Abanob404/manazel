<?php
// templates/pages/login.php

require_once __DIR__ . 
    '/../../src/auth.php

'; // Include auth functions

$page_title = lang(
    'login'
); // For header.php to pick up

$error_message = null;
$success_message = null;

// Display success message from registration if redirected
if (isset($_GET[
    'registered'
]) && isset($_SESSION[
    'success_message'
])) {
    $success_message = $_SESSION[
        'success_message'
    ];
    unset($_SESSION[
        'success_message'
    ]);
}

if ($_SERVER[
    'REQUEST_METHOD'
] === 'POST') {
    $username_or_email = trim($_POST[
        'username'
    ] ?? '');
    $password = $_POST[
        'password'
    ] ?? '';

    if (empty($username_or_email) || empty($password)) {
        $error_message = lang(
            'fill_required_fields'
        );
    } else {
        $login_result = login_user($username_or_email, $password);

        if ($login_result[
            'success'
        ]) {
            // Login successful, redirect to profile page or homepage
            // For now, let's assume a profile page will exist
            header('Location: ' . base_url(
                '?page=profile'
            ));
            exit;
        } else {
            $error_message = $login_result[
                'message'
            ];
        }
    }
}

?>

<div class="container auth-page py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center"><?php echo lang(
                        'login'
                    ); ?></h3>
                </div>
                <div class="card-body">
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($success_message): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($success_message); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo base_url(
                        '?page=login'
                    ); ?>" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label"><?php echo lang(
                                'username'
                            ); ?> <?php echo "(" . lang(
    'or_email_en_ar'
) . ")"; // Add to lang files ?></label>
                            <input type="text" class="form-control" id="username" name="username" required value="<?php echo isset($_POST[
                                'username'
                            ]) ? htmlspecialchars($_POST[
                                'username'
                            ]) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo lang(
                                'password'
                            ); ?></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><?php echo lang(
                                'login'
                            ); ?></button>
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                        <p><?php echo lang(
                            'dont_have_account'
                        ); ?> <a href="<?php echo base_url(
    '?page=register'
); ?>"><?php echo lang(
    'register'
); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auth-page .card {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
}
.auth-page .card-header {
    background-color: #f8f9fa;
    border-bottom: none;
    padding-top: 1.5rem;
    padding-bottom: 1.5rem;
}
</style>

<?php 
// Add to lang files:
// 'or_email_en_ar' => 'or Email',
// 'or_email_en_ar' => 'أو البريد الإلكتروني',
?>

