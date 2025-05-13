<?php
// src/Auth/AuthController.php

namespace Src\Auth;

use Src\Core\Database;
use Src\User\UserModel;

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    public function register(string $username, string $email, string $password): bool|string {
        // Validate input (basic validation, can be expanded)
        if (empty($username) || empty($email) || empty($password)) {
            return "All fields are required.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }
        if (strlen($password) < 6) {
            return "Password must be at least 6 characters long.";
        }

        // Check if username or email already exists
        if ($this->userModel->findByUsername($username)) {
            return "Username already taken.";
        }
        if ($this->userModel->findByEmail($email)) {
            return "Email already registered.";
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Attempt to create user
        if ($this->userModel->create($username, $email, $hashed_password)) {
            return true;
        }
        return "Registration failed. Please try again.";
    }

    public function login(string $usernameOrEmail, string $password): bool|string {
        if (empty($usernameOrEmail) || empty($password)) {
            return "Username/Email and password are required.";
        }

        $user = $this->userModel->findByUsernameOrEmail($usernameOrEmail);

        if ($user && password_verify($password, $user["password_hash"])) {
            // Password is correct, set up session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["user_role"] = $user["role"]; // Store role for authorization
            
            // Update last login (optional)
            // $this->userModel->updateLastLogin($user["id"]);
            
            return true;
        }
        return "Invalid username/email or password.";
    }

    public function logout(): void {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = []; // Clear all session variables
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), 
", time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function isLoggedIn(): bool {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION["user_id"]);
    }

    public static function getCurrentUserId(): ?int {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION["user_id"] ?? null;
    }
    
    public static function getCurrentUserRole(): ?string {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION["user_role"] ?? null;
    }

    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header("Location: " . SITE_URL . "/login?redirect=" . urlencode($_SERVER["REQUEST_URI"]));
            exit;
        }
    }

    public static function requireRole(string $role): void {
        self::requireLogin();
        if (self::getCurrentUserRole() !== $role) {
            // Redirect to a generic error page or homepage
            // For simplicity, redirecting to profile or home
            http_response_code(403); // Forbidden
            // You might want to include a template for 403 errors
            echo "<h1>403 Forbidden</h1><p>You do not have permission to access this page.</p>";
            echo "<a href='" . SITE_URL . "/profile'>Go to Profile</a> or <a href='" . SITE_URL . "/'>Go Home</a>";
            exit;
        }
    }
}
?>
