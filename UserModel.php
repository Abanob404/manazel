<?php
// src/User/UserModel.php

namespace Src\User;

use PDO;

class UserModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id, username, email, role, created_at FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function findByUsername(string $username): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function findByUsernameOrEmail(string $usernameOrEmail): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :usernameOrEmail OR email = :usernameOrEmail");
        $stmt->bindParam(":usernameOrEmail", $usernameOrEmail);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function create(string $username, string $email, string $password_hash, string $role = "user"): bool {
        $sql = "INSERT INTO users (username, email, password_hash, role) VALUES (:username, :email, :password_hash, :role)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password_hash", $password_hash);
        $stmt->bindParam(":role", $role);

        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Log error $e->getMessage();
            error_log("User creation error: " . $e->getMessage());
            return false;
        }
    }

    public function updateProfile(int $id, string $username, string $email, ?string $password_hash = null): bool {
        // Check if new username or email is already taken by another user
        $currentUser = $this->findById($id);
        if (!$currentUser) return false;

        if ($currentUser["username"] !== $username) {
            if ($this->findByUsername($username)) {
                // Username already taken by someone else
                error_log("Update profile error: Username '{$username}' already taken.");
                return false; 
            }
        }
        if ($currentUser["email"] !== $email) {
            if ($this->findByEmail($email)) {
                // Email already taken by someone else
                error_log("Update profile error: Email '{$email}' already taken.");
                return false;
            }
        }

        if ($password_hash) {
            $sql = "UPDATE users SET username = :username, email = :email, password_hash = :password_hash, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        } else {
            $sql = "UPDATE users SET username = :username, email = :email, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        if ($password_hash) {
            $stmt->bindParam(":password_hash", $password_hash);
        }

        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("User profile update error: " . $e->getMessage());
            return false;
        }
    }
    
    // public function updateLastLogin(int $id): bool {
    //     $stmt = $this->db->prepare("UPDATE users SET last_login_at = CURRENT_TIMESTAMP WHERE id = :id");
    //     $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    //     return $stmt->execute();
    // }
}
?>
