<?php
// src/property_interactions.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/language.php';
require_once __DIR__ . '/auth.php'; // For is_logged_in() and get_current_user_id()

/**
 * Add or update a rating for a property by a user.
 *
 * @param int $user_id
 * @param int $property_id
 * @param int $rating_value (1-5)
 * @param string|null $comment_en
 * @param string|null $comment_ar
 * @return array ['success' => bool, 'message' => string]
 */
function add_or_update_rating(int $user_id, int $property_id, int $rating_value, ?string $comment_en = null, ?string $comment_ar = null): array {
    if (!is_logged_in() || $user_id !== get_current_user_id()) {
        return ['success' => false, 'message' => lang('login_required_en_ar')];
    }

    if ($rating_value < 1 || $rating_value > 5) {
        return ['success' => false, 'message' => lang('invalid_rating_value_en_ar')]; // Add to lang files
    }

    $conn = get_db_connection();
    try {
        // Check if rating already exists
        $stmt_check = $conn->prepare("SELECT id FROM ratings WHERE user_id = :user_id AND property_id = :property_id");
        $stmt_check->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_check->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt_check->execute();
        $existing_rating = $stmt_check->fetch();

        if ($existing_rating) {
            // Update existing rating
            $stmt = $conn->prepare("UPDATE ratings SET rating_value = :rating_value, comment_en = :comment_en, comment_ar = :comment_ar, created_at = CURRENT_TIMESTAMP WHERE id = :rating_id");
            $stmt->bindParam(':rating_id', $existing_rating['id'], PDO::PARAM_INT);
        } else {
            // Insert new rating
            $stmt = $conn->prepare("INSERT INTO ratings (user_id, property_id, rating_value, comment_en, comment_ar) VALUES (:user_id, :property_id, :rating_value, :comment_en, :comment_ar)");
        }

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->bindParam(':rating_value', $rating_value, PDO::PARAM_INT);
        $stmt->bindParam(':comment_en', $comment_en);
        $stmt->bindParam(':comment_ar', $comment_ar);
        $stmt->execute();

        return ['success' => true, 'message' => lang('rating_submitted_successfully_en_ar')]; // Add to lang files

    } catch (PDOException $e) {
        error_log("Error adding/updating rating: " . $e->getMessage());
        return ['success' => false, 'message' => lang('error_generic_message')];
    }
}

/**
 * Get the average rating for a property.
 *
 * @param int $property_id
 * @return float|null Average rating or null if no ratings or error.
 */
function get_average_rating(int $property_id): ?float {
    $conn = get_db_connection();
    try {
        $stmt = $conn->prepare("SELECT AVG(rating_value) as avg_rating FROM ratings WHERE property_id = :property_id");
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['avg_rating'] !== null ? (float)$result['avg_rating'] : null;
    } catch (PDOException $e) {
        error_log("Error fetching average rating: " . $e->getMessage());
        return null;
    }
}

/**
 * Get a user's rating for a specific property.
 *
 * @param int $user_id
 * @param int $property_id
 * @return array|null Rating data or null if not rated or error.
 */
function get_user_rating_for_property(int $user_id, int $property_id): ?array {
    $conn = get_db_connection();
    try {
        $stmt = $conn->prepare("SELECT rating_value, comment_en, comment_ar FROM ratings WHERE user_id = :user_id AND property_id = :property_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();
        $rating = $stmt->fetch(PDO::FETCH_ASSOC);
        return $rating ?: null;
    } catch (PDOException $e) {
        error_log("Error fetching user rating: " . $e->getMessage());
        return null;
    }
}


/**
 * Follow a property.
 *
 * @param int $user_id
 * @param int $property_id
 * @return array ['success' => bool, 'message' => string]
 */
function follow_property(int $user_id, int $property_id): array {
    if (!is_logged_in() || $user_id !== get_current_user_id()) {
        return ['success' => false, 'message' => lang('login_required_en_ar')];
    }

    $conn = get_db_connection();
    try {
        // Check if already following
        $stmt_check = $conn->prepare("SELECT id FROM follows WHERE user_id = :user_id AND property_id = :property_id");
        $stmt_check->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_check->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt_check->execute();
        if ($stmt_check->fetch()) {
            return ['success' => false, 'message' => lang('already_following_property_en_ar')]; // Add to lang files
        }

        $stmt = $conn->prepare("INSERT INTO follows (user_id, property_id) VALUES (:user_id, :property_id)");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();

        return ['success' => true, 'message' => lang('property_followed_successfully_en_ar')]; // Add to lang files

    } catch (PDOException $e) {
        error_log("Error following property: " . $e->getMessage());
        return ['success' => false, 'message' => lang('error_generic_message')];
    }
}

/**
 * Unfollow a property.
 *
 * @param int $user_id
 * @param int $property_id
 * @return array ['success' => bool, 'message' => string]
 */
function unfollow_property(int $user_id, int $property_id): array {
    if (!is_logged_in() || $user_id !== get_current_user_id()) {
        return ['success' => false, 'message' => lang('login_required_en_ar')];
    }

    $conn = get_db_connection();
    try {
        $stmt = $conn->prepare("DELETE FROM follows WHERE user_id = :user_id AND property_id = :property_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => lang('property_unfollowed_successfully_en_ar')]; // Add to lang files
        } else {
            return ['success' => false, 'message' => lang('not_following_property_en_ar')]; // Add to lang files
        }

    } catch (PDOException $e) {
        error_log("Error unfollowing property: " . $e->getMessage());
        return ['success' => false, 'message' => lang('error_generic_message')];
    }
}

/**
 * Check if a user is following a property.
 *
 * @param int $user_id
 * @param int $property_id
 * @return bool
 */
function is_following_property(int $user_id, int $property_id): bool {
    if (!is_logged_in()) {
        return false;
    }
    $conn = get_db_connection();
    try {
        $stmt = $conn->prepare("SELECT id FROM follows WHERE user_id = :user_id AND property_id = :property_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch() !== false;
    } catch (PDOException $e) {
        error_log("Error checking if following property: " . $e->getMessage());
        return false;
    }
}

/**
 * Get a list of properties followed by a user.
 *
 * @param int $user_id
 * @return array List of followed property IDs or an empty array.
 */
function get_followed_properties(int $user_id): array {
    if (!is_logged_in() || $user_id !== get_current_user_id()) {
        return [];
    }
    $conn = get_db_connection();
    try {
        // This query needs to join with the properties table to get details.
        // For now, returning IDs, will enhance later if full property objects are needed directly here.
        $stmt = $conn->prepare("SELECT p.id, p.title_en, p.title_ar, p.main_image_path FROM properties p JOIN follows f ON p.id = f.property_id WHERE f.user_id = :user_id ORDER BY f.created_at DESC");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching followed properties: " . $e->getMessage());
        return [];
    }
}

/**
 * Get a list of ratings submitted by a user.
 *
 * @param int $user_id
 * @return array List of user's ratings with property details.
 */
function get_user_ratings(int $user_id): array {
    if (!is_logged_in() || $user_id !== get_current_user_id()) {
        return [];
    }
    $conn = get_db_connection();
    try {
        $stmt = $conn->prepare("SELECT r.rating_value, r.comment_en, r.comment_ar, r.created_at as rating_date, p.id as property_id, p.title_en, p.title_ar, p.main_image_path FROM ratings r JOIN properties p ON r.property_id = p.id WHERE r.user_id = :user_id ORDER BY r.created_at DESC");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching user ratings: " . $e->getMessage());
        return [];
    }
}

?>
