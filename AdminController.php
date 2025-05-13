<?php
// src/Admin/AdminController.php

namespace Src\Admin;

use Src\Core\Database;
use Src\Auth\AuthController;
use Src\Property\PropertyModel;
use Src\User\UserModel;

class AdminController {
    private $db;
    private $propertyModel;
    private $userModel;

    public function __construct() {
        AuthController::requireRole("admin"); // Ensure only admins can access this controller
        $this->db = Database::getInstance()->getConnection();
        $this->propertyModel = new PropertyModel($this->db);
        $this->userModel = new UserModel($this->db);
    }

    // ========== Property Management Methods ==========

    public function listProperties(array $queryParams = []): array {
        $current_page = isset($queryParams["page"]) ? (int)$queryParams["page"] : 1;
        $limit = 10; // Properties per page for admin view
        $offset = ($current_page - 1) * $limit;
        // For admin, we might want to see all languages or a specific one for editing
        // For simplicity, let's use the default language for now in listing
        $language_code = $_SESSION["lang"] ?? DEFAULT_LANGUAGE;

        $filters = []; // Admin might have different filters
        if (!empty($queryParams["search_admin"])) {
            $filters["search_query"] = trim($queryParams["search_admin"]);
        }

        $properties = $this->propertyModel->findAll($language_code, $limit, $offset, $filters);
        $total_properties = $this->propertyModel->countAll($filters, $language_code);
        $total_pages = ceil($total_properties / $limit);

        return [
            "properties" => $properties,
            "total_pages" => $total_pages,
            "current_page" => $current_page,
            "total_properties" => $total_properties
        ];
    }

    public function showPropertyForm(int $id = null): ?array {
        if ($id) {
            // Editing existing property, fetch its data including all translations
            $property_data = $this->propertyModel->findById($id, "en"); // Get base details
            if (!$property_data) return null;
            
            $translations = $this->propertyModel->getTranslations($id);
            $property_data["translations_en"] = $translations["en"][0] ?? []; // Assuming translations are grouped by lang_code
            $property_data["translations_ar"] = $translations["ar"][0] ?? [];
            return $property_data;
        }
        return null; // For new property, form will be empty
    }

    public function saveProperty(array $post_data): bool|string {
        $property_id = isset($post_data["property_id"]) ? (int)$post_data["property_id"] : null;
        $current_admin_id = AuthController::getCurrentUserId();

        // Validate data (this should be more robust)
        if (empty($post_data["title_en"]) || empty($post_data["title_ar"]) || empty($post_data["price"])) {
            return "Required fields are missing (e.g., Title EN/AR, Price).";
        }

        $data = [
            "admin_id" => $current_admin_id,
            "status" => $post_data["status"] ?? "available",
            "price" => $post_data["price"],
            "bedrooms" => $post_data["bedrooms"] ?? null,
            "bathrooms" => $post_data["bathrooms"] ?? null,
            "area_sqft" => $post_data["area_sqft"] ?? null,
            "property_type" => $post_data["property_type"] ?? null,
            "latitude" => $post_data["latitude"] ?? null,
            "longitude" => $post_data["longitude"] ?? null,
        ];

        $translations_en = [
            "title" => $post_data["title_en"],
            "description" => $post_data["description_en"] ?? "",
            "address_line1" => $post_data["address_en"] ?? "",
            "city" => $post_data["city_en"] ?? "",
            "state_province" => $post_data["state_en"] ?? "",
            "country" => $post_data["country_en"] ?? "",
        ];
        $translations_ar = [
            "title" => $post_data["title_ar"],
            "description" => $post_data["description_ar"] ?? "",
            "address_line1" => $post_data["address_ar"] ?? "",
            "city" => $post_data["city_ar"] ?? "",
            "state_province" => $post_data["state_ar"] ?? "",
            "country" => $post_data["country_ar"] ?? "",
        ];

        if ($property_id) {
            // Update existing property
            if ($this->propertyModel->update($property_id, $data, $translations_en, $translations_ar)) {
                // Handle image uploads/updates here if any
                return true;
            }
            return "Failed to update property.";
        }
        // Create new property
        $new_property_id = $this->propertyModel->create($data, $translations_en, $translations_ar);
        if ($new_property_id) {
            // Handle image uploads here if any
            return true;
        }
        return "Failed to create property.";
    }

    public function deleteProperty(int $id): bool {
        return $this->propertyModel->delete($id);
    }

    // ========== User Management Methods ==========

    public function listUsers(array $queryParams = []): array {
        // Similar pagination and filtering as listProperties if needed
        // For now, a simple list
        // $users = $this->userModel->findAll(); // Assuming UserModel has a findAll method
        // This is a placeholder, UserModel needs a findAll method for admin
        $stmt = $this->db->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ["users" => $users]; 
    }

    public function showUserForm(int $id): ?array {
        return $this->userModel->findById($id);
    }

    public function updateUser(array $post_data): bool|string {
        $user_id = (int)$post_data["user_id"];
        $username = $post_data["username"];
        $email = $post_data["email"];
        $role = $post_data["role"]; // Ensure role is validated (e.g., only 'user' or 'admin')
        $password = $post_data["password"]; // Optional: for password change

        if (empty($username) || empty($email) || empty($role)) {
            return "Username, email, and role are required.";
        }
        if (!in_array($role, ["user", "admin"])) {
            return "Invalid role specified.";
        }

        $password_hash = null;
        if (!empty($password)) {
            if (strlen($password) < 6) {
                return "New password must be at least 6 characters long.";
            }
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        }

        // UserModel needs an update method that can also change role and password
        // For now, let's assume a more comprehensive update method in UserModel
        // $this->userModel->updateAdmin($user_id, $username, $email, $role, $password_hash);
        // Placeholder for actual update logic in UserModel
        $sql = "UPDATE users SET username = :username, email = :email, role = :role";
        if ($password_hash) {
            $sql .= ", password_hash = :password_hash";
        }
        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
        if ($password_hash) {
            $stmt->bindParam(":password_hash", $password_hash);
        }
        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Admin user update error: " . $e->getMessage());
            if (strpos($e->getMessage(), "Duplicate entry") !== false) {
                 return "Username or email already exists.";
            }
            return "Failed to update user.";
        }
    }

    public function deleteUser(int $id): bool {
        // Prevent deleting the current admin or the last admin (add more robust checks)
        if ($id === AuthController::getCurrentUserId()) {
            error_log("Admin tried to delete self.");
            return false; 
        }
        // $user = $this->userModel->findById($id);
        // if ($user && $user["role"] === "admin") { /* Add check for last admin */ }
        
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("User deletion error: " . $e->getMessage());
            return false;
        }
    }
}
?>
