<?php
require_once 'config/database.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create database connection
$database = new Database();
$conn = $database->getConnection();

// New password to set
$new_password = "admin123"; // You can change this password
$hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

// Update admin user password
$query = "UPDATE users SET password = ? WHERE username = 'admin' OR email = 'admin@platia.com'";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $hashed_password);

if ($stmt->execute()) {
    echo "Password has been reset successfully!\n";
    echo "New login credentials:\n";
    echo "Username: admin\n";
    echo "Password: " . $new_password . "\n";
} else {
    echo "Failed to reset password.\n";
    echo "Error: " . print_r($stmt->errorInfo(), true);
}
?>