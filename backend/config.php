<?php
/**
 * Database Configuration File
 * 
 * Update these values with your actual database credentials
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'protein_planet');

// Application Configuration
define('APP_NAME', 'Protein Planet');
define('APP_URL', 'http://localhost/protein-planet');

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Timezone
date_default_timezone_set('America/New_York');

// Error Reporting (Disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Database Connection Function
 */
function getDatabaseConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        $conn->set_charset("utf8mb4");
        return $conn;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
}

/**
 * Sanitize Input
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Check if user is admin
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

/**
 * Redirect function
 */
function redirect($url) {
    header("Location: $url");
    exit;
}
?>

