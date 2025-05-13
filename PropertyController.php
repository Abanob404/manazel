<?php
// src/Property/PropertyController.php

namespace Src\Property;

use Src\Core\Database;
use Src\Auth\AuthController; // Needed for user ID

class PropertyController {
    private $db;
    private $propertyModel;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->propertyModel = new PropertyModel($this->db);
    }

    /**
     * Displays a list of properties (for public view).
     * Handles pagination and filtering.
     */
    public function index(array $queryParams = []): array {
        $current_page = isset($queryParams["page"]) ? (int)$queryParams["page"] : 1;
        $limit = 10; // Properties per page
        $offset = ($current_page - 1) * $limit;
        $language_code = $_SESSION["lang"] ?? DEFAULT_LANGUAGE;

        // Basic filters from query params
        $filters = [];
        if (!empty($queryParams["search_query"])) {
            $filters["search_query"] = trim($queryParams["search_query"]);
        }
        if (!empty($queryParams["property_type"])) {
            $filters["property_type"] = trim($queryParams["property_type"]);
        }
        // Add more filters as needed (bedrooms, price range etc.)

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

    /**
     * Displays details for a single property (for public view).
     */
    public function show(int $id): ?array {
        $language_code = $_SESSION["lang"] ?? DEFAULT_LANGUAGE;
        $property = $this->propertyModel->findById($id, $language_code);

        if ($property) {
            $property["images"] = $this->propertyModel->getImages($id);
            $property["ratings"] = $this->propertyModel->getPropertyRatings($id);
            $property["avg_rating"] = $this->propertyModel->getAverageRating($id);
            if (AuthController::isLoggedIn()) {
                $current_user_id = AuthController::getCurrentUserId();
                $property["user_rating"] = $this->propertyModel->getUserRatingForProperty($current_user_id, $id);
                $property["is_followed_by_user"] = $this->propertyModel->isFollowing($current_user_id, $id);
            }
        }
        return $property;
    }

    public function addRating(int $property_id, int $user_id, int $rating_value, ?string $comment): bool|string {
        AuthController::requireLogin();
        if ($rating_value < 1 || $rating_value > 5) {
            return "Rating must be between 1 and 5.";
        }
        if ($this->propertyModel->addOrUpdateRating($property_id, $user_id, $rating_value, $comment)) {
            return true;
        }
        return "Failed to add rating.";
    }

    public function toggleFollow(int $property_id, int $user_id): bool|string {
        AuthController::requireLogin();
        if ($this->propertyModel->isFollowing($user_id, $property_id)) {
            if ($this->propertyModel->unfollowProperty($user_id, $property_id)) {
                return "unfollowed";
            }
            return "Failed to unfollow property.";
        }
        if ($this->propertyModel->followProperty($user_id, $property_id)) {
            return "followed";
        }
        return "Failed to follow property.";
    }
    
    // Admin-related property methods will likely be in an AdminController
    // or a dedicated AdminPropertyController to keep concerns separate.
}
?>
