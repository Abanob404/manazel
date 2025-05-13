# Database Schema for Manazel Real Estate Website (PHP/MySQL)

This document outlines the proposed database schema for the Manazel Real Estate website. The primary language for content will be English, with support for Arabic.

## 1. `users` Table

Stores information about registered users.

| Column Name      | Data Type        | Constraints                        | Description                                      |
|------------------|------------------|------------------------------------|--------------------------------------------------|
| `id`             | INT              | PRIMARY KEY, AUTO_INCREMENT        | Unique identifier for the user.                  |
| `username`       | VARCHAR(50)      | UNIQUE, NOT NULL                   | User's chosen username for login.                |
| `email`          | VARCHAR(100)     | UNIQUE, NOT NULL                   | User's email address.                            |
| `password_hash`  | VARCHAR(255)     | NOT NULL                           | Hashed password for security.                    |
| `full_name_en`   | VARCHAR(100)     | NULL                               | User's full name in English.                     |
| `full_name_ar`   | VARCHAR(100)     | NULL                               | User's full name in Arabic.                      |
| `profile_picture`| VARCHAR(255)     | NULL                               | Path to the user's profile picture.              |
| `phone_number`   | VARCHAR(20)      | NULL                               | User's phone number.                             |
| `preferred_lang` | VARCHAR(5)       | DEFAULT 'en'                       | User's preferred language (e.g., 'en', 'ar').    |
| `role`           | ENUM('user', 'admin') | NOT NULL, DEFAULT 'user'         | User role (e.g., regular user, administrator).   |
| `created_at`     | TIMESTAMP        | DEFAULT CURRENT_TIMESTAMP          | Timestamp of account creation.                   |
| `updated_at`     | TIMESTAMP        | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Timestamp of last profile update.                |

## 2. `properties` Table

Stores details about the real estate properties. Managed by admins.

| Column Name          | Data Type        | Constraints                        | Description                                       |
|----------------------|------------------|------------------------------------|---------------------------------------------------|
| `id`                 | INT              | PRIMARY KEY, AUTO_INCREMENT        | Unique identifier for the property.               |
| `title_en`           | VARCHAR(255)     | NOT NULL                           | Property title in English.                        |
| `title_ar`           | VARCHAR(255)     | NULL                               | Property title in Arabic.                         |
| `description_en`     | TEXT             | NOT NULL                           | Detailed description in English.                  |
| `description_ar`     | TEXT             | NULL                               | Detailed description in Arabic.                   |
| `price`              | DECIMAL(15, 2)   | NOT NULL                           | Property price.                                   |
| `currency`           | VARCHAR(10)      | DEFAULT 'USD'                      | Currency for the price (e.g., USD, AED, SAR).     |
| `property_type_en`   | VARCHAR(50)      | NULL                               | Type of property in English (e.g., Villa, Apartment).|
| `property_type_ar`   | VARCHAR(50)      | NULL                               | Type of property in Arabic.                       |
| `status_en`          | VARCHAR(50)      | NULL                               | Property status in English (e.g., For Sale, For Rent).|
| `status_ar`          | VARCHAR(50)      | NULL                               | Property status in Arabic.                        |
| `bedrooms`           | INT              | NULL                               | Number of bedrooms.                               |
| `bathrooms`          | INT              | NULL                               | Number of bathrooms.                              |
| `area_sqm`           | DECIMAL(10, 2)   | NULL                               | Property area in square meters.                   |
| `address_en`         | VARCHAR(255)     | NULL                               | Property address in English.                      |
| `address_ar`         | VARCHAR(255)     | NULL                               | Property address in Arabic.                       |
| `city_en`            | VARCHAR(100)     | NULL                               | City in English.                                  |
| `city_ar`            | VARCHAR(100)     | NULL                               | City in Arabic.                                   |
| `country_en`         | VARCHAR(100)     | NULL                               | Country in English.                               |
| `country_ar`         | VARCHAR(100)     | NULL                               | Country in Arabic.                                |
| `latitude`           | DECIMAL(10, 8)   | NULL                               | Latitude for map integration.                     |
| `longitude`          | DECIMAL(11, 8)   | NULL                               | Longitude for map integration.                    |
| `year_built`         | INT              | NULL                               | Year the property was built.                      |
| `main_image_path`    | VARCHAR(255)     | NULL                               | Path to the main featured image.                  |
| `is_featured`        | BOOLEAN          | DEFAULT FALSE                      | Whether the property is featured.                 |
| `added_by_admin_id`  | INT              | NOT NULL                           | ID of the admin who added the property.           |
| `created_at`         | TIMESTAMP        | DEFAULT CURRENT_TIMESTAMP          | Timestamp of property addition.                   |
| `updated_at`         | TIMESTAMP        | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Timestamp of last property update.                |

**Foreign Keys:**
*   `added_by_admin_id` REFERENCES `users`(`id`) ON DELETE CASCADE

## 3. `property_images` Table

Stores multiple images for each property.

| Column Name    | Data Type    | Constraints                        | Description                               |
|----------------|--------------|------------------------------------|-------------------------------------------|
| `id`           | INT          | PRIMARY KEY, AUTO_INCREMENT        | Unique identifier for the image.          |
| `property_id`  | INT          | NOT NULL                           | Foreign key referencing `properties`.`id`. |
| `image_path`   | VARCHAR(255) | NOT NULL                           | Path to the image file.                   |
| `caption_en`   | VARCHAR(255) | NULL                               | Image caption in English.                 |
| `caption_ar`   | VARCHAR(255) | NULL                               | Image caption in Arabic.                  |
| `is_primary`   | BOOLEAN      | DEFAULT FALSE                      | Indicates if this is the primary image (alternative to `main_image_path` in `properties` table or can be used in conjunction). |
| `uploaded_at`  | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP          | Timestamp of image upload.                |

**Foreign Keys:**
*   `property_id` REFERENCES `properties`(`id`) ON DELETE CASCADE

## 4. `property_features` Table (Optional - for dynamic features)

If properties have a variable set of features (e.g., Pool, Gym, Balcony), this table can manage them. Otherwise, common features can be boolean columns in the `properties` table.

| Column Name      | Data Type    | Constraints                        | Description                                      |
|------------------|--------------|------------------------------------|--------------------------------------------------|
| `id`             | INT          | PRIMARY KEY, AUTO_INCREMENT        | Unique identifier for the feature link.          |
| `property_id`    | INT          | NOT NULL                           | Foreign key referencing `properties`.`id`.        |
| `feature_name_en`| VARCHAR(100) | NOT NULL                           | Feature name in English (e.g., "Swimming Pool"). |
| `feature_name_ar`| VARCHAR(100) | NULL                               | Feature name in Arabic.                          |
| `feature_value_en`| VARCHAR(255) | NULL                               | Value of the feature in English (e.g., "Yes", "Shared"). |
| `feature_value_ar`| VARCHAR(255) | NULL                               | Value of the feature in Arabic.                  |

**Foreign Keys:**
*   `property_id` REFERENCES `properties`(`id`) ON DELETE CASCADE

## 5. `ratings` Table

Stores user ratings for properties.

| Column Name   | Data Type | Constraints                        | Description                               |
|---------------|-----------|------------------------------------|-------------------------------------------|
| `id`          | INT       | PRIMARY KEY, AUTO_INCREMENT        | Unique identifier for the rating.         |
| `property_id` | INT       | NOT NULL                           | Foreign key referencing `properties`.`id`. |
| `user_id`     | INT       | NOT NULL                           | Foreign key referencing `users`.`id`.      |
| `rating_value`| TINYINT   | NOT NULL                           | Rating value (e.g., 1 to 5 stars).        |
| `comment_en`  | TEXT      | NULL                               | Optional comment in English.              |
| `comment_ar`  | TEXT      | NULL                               | Optional comment in Arabic.               |
| `created_at`  | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP          | Timestamp of rating submission.           |

**Constraints:**
*   UNIQUE (`property_id`, `user_id`) - A user can rate a property only once.

**Foreign Keys:**
*   `property_id` REFERENCES `properties`(`id`) ON DELETE CASCADE
*   `user_id` REFERENCES `users`(`id`) ON DELETE CASCADE

## 6. `follows` (or `favorites`) Table

Stores information about users following/favoriting properties.

| Column Name   | Data Type | Constraints                        | Description                               |
|---------------|-----------|------------------------------------|-------------------------------------------|
| `id`          | INT       | PRIMARY KEY, AUTO_INCREMENT        | Unique identifier for the follow entry.   |
| `property_id` | INT       | NOT NULL                           | Foreign key referencing `properties`.`id`. |
| `user_id`     | INT       | NOT NULL                           | Foreign key referencing `users`.`id`.      |
| `created_at`  | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP          | Timestamp when the follow was created.    |

**Constraints:**
*   UNIQUE (`property_id`, `user_id`) - A user can follow a property only once.

**Foreign Keys:**
*   `property_id` REFERENCES `properties`(`id`) ON DELETE CASCADE
*   `user_id` REFERENCES `users`(`id`) ON DELETE CASCADE

## 7. `site_content` Table (Optional - for manageable text blocks)

For managing blocks of text on the website (e.g., About Us paragraphs, Service descriptions) that might need admin updates without code changes. This is an alternative to hardcoding all text in PHP files or language files if more dynamic admin control is needed.

| Column Name    | Data Type    | Constraints                        | Description                                     |
|----------------|--------------|------------------------------------|-------------------------------------------------|
| `id`           | INT          | PRIMARY KEY, AUTO_INCREMENT        | Unique identifier for the content block.        |
| `block_key`    | VARCHAR(100) | UNIQUE, NOT NULL                   | A unique key to identify the block (e.g., 'about_us_intro'). |
| `content_en`   | TEXT         | NULL                               | Content in English.                             |
| `content_ar`   | TEXT         | NULL                               | Content in Arabic.                              |
| `updated_at`   | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Timestamp of last update.                       |

## Notes on Multilingual Support:

*   Fields ending with `_en` store English content.
*   Fields ending with `_ar` store Arabic content.
*   The application logic in PHP will need to select the appropriate language field based on the user's preference or the selected site language.
*   For static text within templates (labels, button texts), language arrays or files (e.g., `lang/en.php`, `lang/ar.php`) will be used.

This schema provides a comprehensive starting point. It can be further refined during the development process as specific needs arise.
