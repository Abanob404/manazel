<?php
// src/Property/PropertyModel.php

namespace Src\Property;

use PDO;

class PropertyModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Creates a new property and its translations.
     */
    public function create(array $data, array $translations_en, array $translations_ar): int|false {
        $this->db->beginTransaction();
        try {
            // Insert into properties table
            $sql_prop = "INSERT INTO properties (admin_id, status) VALUES (:admin_id, :status)";
            $stmt_prop = $this->db->prepare($sql_prop);
            $stmt_prop->bindParam(":admin_id", $data["admin_id"], PDO::PARAM_INT);
            $stmt_prop->bindParam(":status", $data["status"]);
            $stmt_prop->execute();
            $property_id = (int)$this->db->lastInsertId();

            if (!$property_id) {
                $this->db->rollBack();
                return false;
            }

            // Insert into property_details table
            $sql_details = "INSERT INTO property_details (property_id, price, bedrooms, bathrooms, area_sqft, property_type, latitude, longitude) 
                            VALUES (:property_id, :price, :bedrooms, :bathrooms, :area_sqft, :property_type, :latitude, :longitude)";
            $stmt_details = $this->db->prepare($sql_details);
            $stmt_details->bindParam(":property_id", $property_id, PDO::PARAM_INT);
            $stmt_details->bindParam(":price", $data["price"]);
            $stmt_details->bindParam(":bedrooms", $data["bedrooms"], PDO::PARAM_INT);
            $stmt_details->bindParam(":bathrooms", $data["bathrooms"], PDO::PARAM_INT);
            $stmt_details->bindParam(":area_sqft", $data["area_sqft"]);
            $stmt_details->bindParam(":property_type", $data["property_type"]);
            $stmt_details->bindParam(":latitude", $data["latitude"]);
            $stmt_details->bindParam(":longitude", $data["longitude"]);
            $stmt_details->execute();

            // Insert English translations
            $this->insertOrUpdateTranslation($property_id, "en", $translations_en);
            // Insert Arabic translations
            $this->insertOrUpdateTranslation($property_id, "ar", $translations_ar);

            $this->db->commit();
            return $property_id;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            error_log("Property creation error: " . $e->getMessage());
            return false;
        }
    }

    private function insertOrUpdateTranslation(int $property_id, string $lang_code, array $translation_data): bool {
        $sql = "INSERT INTO property_translations (property_id, language_code, title, description, address_line1, city, state_province, country)
                VALUES (:property_id, :language_code, :title, :description, :address_line1, :city, :state_province, :country)
                ON DUPLICATE KEY UPDATE 
                title = VALUES(title), description = VALUES(description), address_line1 = VALUES(address_line1), 
                city = VALUES(city), state_province = VALUES(state_province), country = VALUES(country)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":property_id", $property_id, PDO::PARAM_INT);
        $stmt->bindParam(":language_code", $lang_code);
        $stmt->bindParam(":title", $translation_data["title"]);
        $stmt->bindParam(":description", $translation_data["description"]);
        $stmt->bindParam(":address_line1", $translation_data["address_line1"]);
        $stmt->bindParam(":city", $translation_data["city"]);
        $stmt->bindParam(":state_province", $translation_data["state_province"]);
        $stmt->bindParam(":country", $translation_data["country"]);
        return $stmt->execute();
    }

    /**
     * Finds a property by its ID, including its details and translations for a specific language.
     */
    public function findById(int $id, string $language_code = DEFAULT_LANGUAGE): ?array {
        $sql = "SELECT p.*, pd.*, pt.title, pt.description, pt.address_line1, pt.city, pt.state_province, pt.country 
                FROM properties p
                JOIN property_details pd ON p.id = pd.property_id
                LEFT JOIN property_translations pt ON p.id = pt.property_id AND pt.language_code = :language_code
                WHERE p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":language_code", $language_code);
        $stmt->execute();
        $property = $stmt->fetch(PDO::FETCH_ASSOC);
        return $property ?: null;
    }
    
    /**
     * Gets all translations for a property.
     */
    public function getTranslations(int $property_id): array {
        $stmt = $this->db->prepare("SELECT language_code, title, description, address_line1, city, state_province, country FROM property_translations WHERE property_id = :property_id");
        $stmt->bindParam(":property_id", $property_id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $translations = [];
        foreach ($results as $row) {
            $translations[$row["language_code"]] = $row;
        }
        return $translations;
    }


    /**
     * Updates an existing property and its translations.
     */
    public function update(int $id, array $data, array $translations_en, array $translations_ar): bool {
        $this->db->beginTransaction();
        try {
            // Update properties table
            $sql_prop = "UPDATE properties SET admin_id = :admin_id, status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
            $stmt_prop = $this->db->prepare($sql_prop);
            $stmt_prop->bindParam(":admin_id", $data["admin_id"], PDO::PARAM_INT);
            $stmt_prop->bindParam(":status", $data["status"]);
            $stmt_prop->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt_prop->execute();

            // Update property_details table
            $sql_details = "UPDATE property_details SET price = :price, bedrooms = :bedrooms, bathrooms = :bathrooms, 
                            area_sqft = :area_sqft, property_type = :property_type, latitude = :latitude, longitude = :longitude
                            WHERE property_id = :id";
            $stmt_details = $this->db->prepare($sql_details);
            $stmt_details->bindParam(":price", $data["price"]);
            $stmt_details->bindParam(":bedrooms", $data["bedrooms"], PDO::PARAM_INT);
            $stmt_details->bindParam(":bathrooms", $data["bathrooms"], PDO::PARAM_INT);
            $stmt_details->bindParam(":area_sqft", $data["area_sqft"]);
            $stmt_details->bindParam(":property_type", $data["property_type"]);
            $stmt_details->bindParam(":latitude", $data["latitude"]);
            $stmt_details->bindParam(":longitude", $data["longitude"]);
            $stmt_details->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt_details->execute();

            // Update/Insert English translations
            $this->insertOrUpdateTranslation($id, "en", $translations_en);
            // Update/Insert Arabic translations
            $this->insertOrUpdateTranslation($id, "ar", $translations_ar);

            $this->db->commit();
            return true;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            error_log("Property update error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes a property by its ID.
     * Related records in property_details, property_translations, property_images, ratings, follows will be deleted by CASCADE.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM properties WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Property deletion error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Finds all properties with pagination and optional filters.
     */
    public function findAll(string $language_code = DEFAULT_LANGUAGE, int $limit = 10, int $offset = 0, array $filters = []): array {
        $sql = "SELECT p.id, p.status, pd.price, pd.bedrooms, pd.bathrooms, pd.area_sqft, pd.property_type, 
                       pt.title, pt.city, pt.country, 
                       (SELECT image_url FROM property_images pi WHERE pi.property_id = p.id AND pi.is_primary = 1 LIMIT 1) as primary_image_url
                FROM properties p
                JOIN property_details pd ON p.id = pd.property_id
                LEFT JOIN property_translations pt ON p.id = pt.property_id AND pt.language_code = :language_code";
        
        $where_clauses = [];
        $params = [":language_code" => $language_code];

        if (!empty($filters["search_query"])) {
            $where_clauses[] = "(pt.title LIKE :search_query OR pt.description LIKE :search_query OR pt.address_line1 LIKE :search_query OR pt.city LIKE :search_query)";
            $params[":search_query"] = "%" . $filters["search_query"] . "%";
        }
        if (!empty($filters["property_type"])) {
            $where_clauses[] = "pd.property_type = :property_type";
            $params[":property_type"] = $filters["property_type"];
        }
        // Add more filters (bedrooms, price range etc.) here

        if (!empty($where_clauses)) {
            $sql .= " WHERE " . implode(" AND ", $where_clauses);
        }

        $sql .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
        $params[":limit"] = $limit;
        $params[":offset"] = $offset;

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => &$val) {
            if ($key === ":limit" || $key === ":offset" || $key === ":language_code") {
                 $stmt->bindParam($key, $val, ($key === ":language_code" ? PDO::PARAM_STR : PDO::PARAM_INT));
            } else {
                 $stmt->bindParam($key, $val);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(array $filters = [], string $language_code = DEFAULT_LANGUAGE): int {
        $sql = "SELECT COUNT(p.id) 
                FROM properties p
                JOIN property_details pd ON p.id = pd.property_id
                LEFT JOIN property_translations pt ON p.id = pt.property_id AND pt.language_code = :language_code";

        $where_clauses = [];
        $params = [":language_code" => $language_code];

        if (!empty($filters["search_query"])) {
            $where_clauses[] = "(pt.title LIKE :search_query OR pt.description LIKE :search_query OR pt.address_line1 LIKE :search_query OR pt.city LIKE :search_query)";
            $params[":search_query"] = "%" . $filters["search_query"] . "%";
        }
        if (!empty($filters["property_type"])) {
            $where_clauses[] = "pd.property_type = :property_type";
            $params[":property_type"] = $filters["property_type"];
        }
        // Add more filters here

        if (!empty($where_clauses)) {
            $sql .= " WHERE " . implode(" AND ", $where_clauses);
        }
        
        $stmt = $this->db->prepare($sql);
         foreach ($params as $key => &$val) {
            if ($key === ":language_code") {
                $stmt->bindParam($key, $val, PDO::PARAM_STR);
            } else {
                $stmt->bindParam($key, $val);
            }
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    
    // Methods for property images
    public function addImage(int $property_id, string $image_url, string $alt_text_en = null, string $alt_text_ar = null, bool $is_primary = false, int $sort_order = 0): bool {
        $sql = "INSERT INTO property_images (property_id, image_url, alt_text_en, alt_text_ar, is_primary, sort_order) 
                VALUES (:property_id, :image_url, :alt_text_en, :alt_text_ar, :is_primary, :sort_order)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":property_id", $property_id, PDO::PARAM_INT);
        $stmt->bindParam(":image_url", $image_url);
        $stmt->bindParam(":alt_text_en", $alt_text_en);
        $stmt->bindParam(":alt_text_ar", $alt_text_ar);
        $stmt->bindParam(":is_primary", $is_primary, PDO::PARAM_BOOL);
        $stmt->bindParam(":sort_order", $sort_order, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getImages(int $property_id): array {
        $stmt = $this->db->prepare("SELECT * FROM property_images WHERE property_id = :property_id ORDER BY sort_order ASC, is_primary DESC");
        $stmt->bindParam(":property_id", $property_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteImage(int $image_id): bool {
        $stmt = $this->db->prepare("DELETE FROM property_images WHERE id = :id");
        $stmt->bindParam(":id", $image_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function setPrimaryImage(int $property_id, int $image_id): bool {
        $this->db->beginTransaction();
        try {
            // Set all other images for this property to not primary
            $stmt_reset = $this->db->prepare("UPDATE property_images SET is_primary = 0 WHERE property_id = :property_id");
            $stmt_reset->bindParam(":property_id", $property_id, PDO::PARAM_INT);
            $stmt_reset->execute();

            // Set the specified image to primary
            $stmt_set = $this->db->prepare("UPDATE property_images SET is_primary = 1 WHERE id = :image_id AND property_id = :property_id");
            $stmt_set->bindParam(":image_id", $image_id, PDO::PARAM_INT);
            $stmt_set->bindParam(":property_id", $property_id, PDO::PARAM_INT);
            $stmt_set->execute();

            $this->db->commit();
            return true;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            error_log("Set primary image error: " . $e->getMessage());
            return false;
        }
    }

    // ========== Rating Methods ==========
    public function addOrUpdateRating(int $property_id, int $user_id, int $rating_value, ?string $comment = null): bool {
        $sql = "INSERT INTO ratings (property_id, user_id, rating_value, comment) 
                VALUES (:property_id, :user_id, :rating_value, :comment)
                ON DUPLICATE KEY UPDATE rating_value = VALUES(rating_value), comment = VALUES(comment), created_at = CURRENT_TIMESTAMP";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":property_id", $property_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":rating_value", $rating_value, PDO::PARAM_INT);
        $stmt->bindParam(":comment", $comment);
        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Add/Update rating error: " . $e->getMessage());
            return false;
        }
    }

    public function getPropertyRatings(int $property_id): array {
        $sql = "SELECT r.*, u.username FROM ratings r JOIN users u ON r.user_id = u.id WHERE r.property_id = :property_id ORDER BY r.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":property_id", $property_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverageRating(int $property_id): ?float {
        $sql = "SELECT AVG(rating_value) as avg_rating FROM ratings WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":property_id", $property_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

(Content truncated due to size limit. Use line ranges to read in chunks)