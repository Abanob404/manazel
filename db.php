<?php
// includes/db.php

require_once __DIR__ . 
    '/../config/config.php
';

$conn = null;

try {
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASSWORD
    );
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // In a real application, you would log this error and show a user-friendly message
    // For development, we can echo the error, but this should be removed for production
    error_log(
        "Connection failed: " . $e->getMessage()
    );
    // Display a generic error message to the user or redirect to an error page
    // For now, let's just die with a simple message if DB connection fails, as the site is unusable without it.
    die(
        "Database connection failed. Please check server logs or contact support."
    );
}

/**
 * Function to get the database connection.
 * @return PDO|null The PDO connection object or null if connection failed.
 */
function get_db_connection() {
    global $conn;
    return $conn;
}

// You might want to close the connection when the script ends, though PHP usually handles this.
// register_shutdown_function(function() use ($conn) {
//     if ($conn) {
//         $conn = null;
//     }
// });

?>

