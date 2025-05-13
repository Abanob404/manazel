<?php
// src/auth.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . 
    '/../includes/db.php

';
require_once __DIR__ . 
    '/../includes/language.php

'; // For lang() function access

/**
 * Check if a user is logged in.
 *
 * @return bool True if logged in, false otherwise.
 */
function is_logged_in(): bool {
    return isset($_SESSION[
        'user_id'
    ]);
}

/**
 * Get the current logged-in user's ID.
 *
 * @return int|null User ID if logged in, null otherwise.
 */
function get_current_user_id(): ?int {
    return $_SESSION[
        'user_id'
    ] ?? null;
}

/**
 * Get user data by ID.
 *
 * @param int $user_id
 * @return array|null User data as an associative array, or null if not found or error.
 */
function get_user_by_id(int $user_id): ?array {
    $conn = get_db_connection();
    try {
        $stmt = $conn->prepare(
            "SELECT id, username, full_name, email, phone_number, role, created_at FROM users WHERE id = :user_id"
        );
        $stmt->bindParam(
            ':user_id',
            $user_id,
            PDO::PARAM_INT
        );
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    } catch (PDOException $e) {
        error_log(
            "Error fetching user by ID: " . $e->getMessage()
        );
        return null;
    }
}

/**
 * Get the current logged-in user's data.
 *
 * @return array|null User data as an associative array if logged in, null otherwise.
 */
function get_current_user(): ?array {
    $user_id = get_current_user_id();
    if (!$user_id) {
        return null;
    }
    return get_user_by_id($user_id);
}

/**
 * Attempt to register a new user.
 *
 * @param string $fullname
 * @param string $username
 * @param string $email
 * @param string $password
 * @param string|null $phone
 * @return array ['success' => bool, 'message' => string, 'user_id' => int|null]
 */
function register_user(string $fullname, string $username, string $email, string $password, ?string $phone = null): array {
    $conn = get_db_connection();

    // Check if username or email already exists
    try {
        $stmt_check = $conn->prepare(
            "SELECT id, username, email FROM users WHERE username = :username OR email = :email LIMIT 1"
        );
        $stmt_check->bindParam(
            ':username',
            $username
        );
        $stmt_check->bindParam(
            ':email',
            $email
        );
        $stmt_check->execute();
        $existing_user = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($existing_user) {
            if ($existing_user[
                'username'
            ] === $username) {
                return [
                    'success' => false,
                    'message' => lang(
                        'username_already_exists'
                    ),
                    'user_id' => null
                ];
            }
            if ($existing_user[
                'email'
            ] === $email) {
                return [
                    'success' => false,
                    'message' => lang(
                        'email_already_exists'
                    ),
                    'user_id' => null
                ];
            }
        }
    } catch (PDOException $e) {
        error_log(
            "Error checking existing user: " . $e->getMessage()
        );
        return [
            'success' => false,
            'message' => lang(
                'error_generic_message'
            ),
            'user_id' => null
        ];
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    try {
        $stmt = $conn->prepare(
            "INSERT INTO users (full_name, username, email, password_hash, phone_number) VALUES (:fullname, :username, :email, :password_hash, :phone)"
        );
        $stmt->bindParam(
            ':fullname',
            $fullname
        );
        $stmt->bindParam(
            ':username',
            $username
        );
        $stmt->bindParam(
            ':email',
            $email
        );
        $stmt->bindParam(
            ':password_hash',
            $hashed_password
        );
        $stmt->bindParam(
            ':phone',
            $phone
        );
        
        $stmt->execute();
        $user_id = $conn->lastInsertId();

        return [
            'success' => true,
            'message' => lang(
                'registration_successful'
            ),
            'user_id' => (int)$user_id
        ];

    } catch (PDOException $e) {
        error_log(
            "Error registering user: " . $e->getMessage()
        );
        return [
            'success' => false,
            'message' => lang(
                'error_generic_message'
            ),
            'user_id' => null
        ];
    }
}

/**
 * Attempt to log in a user.
 *
 * @param string $username_or_email
 * @param string $password
 * @return array ['success' => bool, 'message' => string]
 */
function login_user(string $username_or_email, string $password): array {
    $conn = get_db_connection();
    try {
        $stmt = $conn->prepare(
            "SELECT id, username, password_hash FROM users WHERE username = :username_or_email OR email = :username_or_email"
        );
        $stmt->bindParam(
            ':username_or_email',
            $username_or_email
        );
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user[
            'password_hash'
        ])) {
            $_SESSION[
                'user_id'
            ] = (int)$user[
                'id'
            ];
            $_SESSION[
                'username'
            ] = $user[
                'username'
            ];
            return [
                'success' => true,
                'message' => lang(
                    'login_successful'
                )
            ];
        } else {
            return [
                'success' => false,
                'message' => lang(
                    'incorrect_login'
                )
            ];
        }
    } catch (PDOException $e) {
        error_log(
            "Error logging in user: " . $e->getMessage()
        );
        return [
            'success' => false,
            'message' => lang(
                'error_generic_message'
            )
        ];
    }
}

/**
 * Log out the current user.
 */
function logout_user(): void {
    session_unset();
    session_destroy();
    header('Location: ' . base_url(
        '?page=login&loggedout=true'
    )); // Redirect to login page after logout
    exit;
}

/**
 * Update user profile information.
 *
 * @param int $user_id
 * @param string $fullname
 * @param string $email
 * @param string|null $phone
 * @return array ['success' => bool, 'message' => string]
 */
function update_user_profile(int $user_id, string $fullname, string $email, ?string $phone = null): array {
    $conn = get_db_connection();

    // Check if email is being changed and if the new email already exists for another user
    try {
        $stmt_check_email = $conn->prepare(
            "SELECT id FROM users WHERE email = :email AND id != :user_id"
        );
        $stmt_check_email->bindParam(
            ':email',
            $email
        );
        $stmt_check_email->bindParam(
            ':user_id',
            $user_id,
            PDO::PARAM_INT
        );
        $stmt_check_email->execute();
        if ($stmt_check_email->fetch()) {
            return [
                'success' => false,
                'message' => lang(
                    'email_already_exists'
                )
            ];
        }
    } catch (PDOException $e) {
        error_log(
            "Error checking email for profile update: " . $e->getMessage()
        );
        return [
            'success' => false,
            'message' => lang(
                'error_generic_message'
            )
        ];
    }

    try {
        $stmt = $conn->prepare(
            "UPDATE users SET full_name = :fullname, email = :email, phone_number = :phone WHERE id = :user_id"
        );
        $stmt->bindParam(
            ':fullname',
            $fullname
        );
        $stmt->bindParam(
            ':email',
            $email
        );
        $stmt->bindParam(
            ':phone',
            $phone
        );
        $stmt->bindParam(
            ':user_id',
            $user_id,
            PDO::PARAM_INT
        );
        $stmt->execute();

        return [
            'success' => true,
            'message' => lang(
                'profile_updated_successfully'
            )
        ];
    } catch (PDOException $e) {
        error_log(
            "Error updating user profile: " . $e->getMessage()
        );
        return [
            'success' => false,
            'message' => lang(
                'error_generic_message'
            )
        ];
    }
}

/**
 * Change user password.
 *
 * @param int $user_id
 * @param string $current_password
 * @param string $new_password
 * @return array ['success' => bool, 'message' => string]
 */
function change_user_password(int $user_id, string $current_password, string $new_password): array {
    $conn = get_db_connection();
    try {
        $stmt_check = $conn->prepare(
            "SELECT password_hash FROM users WHERE id = :user_id"
        );
        $stmt_check->bindParam(
            ':user_id',
            $user_id,
            PDO::PARAM_INT
        );
        $stmt_check->execute();
        $user = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($current_password, $user[
            'password_hash'
        ])) {
            return [
                'success' => false,
                'message' => lang(
                    'incorrect_current_password_en_ar' // Add to lang files
                )
            ];
        }

        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt_update = $conn->prepare(
            "UPDATE users SET password_hash = :new_password_hash WHERE id = :user_id"
        );
        $stmt_update->bindParam(
            ':new_password_hash',
            $new_hashed_password
        );
        $stmt_update->bindParam(
            ':user_id',
            $user_id,
            PDO::PARAM_INT
        );
        $stmt_update->execute();

        return [
            'success' => true,
            'message' => lang(
                'password_changed_successfully'
            )
        ];

    } catch (PDOException $e) {
        error_log(
            "Error changing password: " . $e->getMessage()
        );
        return [
            'success' => false,
            'message' => lang(
                'error_generic_message'
            )
        ];
    }
}

?>

