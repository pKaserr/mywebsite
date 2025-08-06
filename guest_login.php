<?php
require './includes/db_connect.php';

/**
 * Guest login functionality
 * Creates a guest session without password requirements
 */

// Session-Management mit sicheren Cookie-Parametern
session_set_cookie_params([
    'httponly' => true,
    'secure' => true, // Aktivieren, wenn HTTPS verwendet wird
    'samesite' => 'Strict'
]);
session_start();

try {
    // Check if guest user exists in database
    $stmt = $pdo->prepare("SELECT * FROM user WHERE user_name = 'guest' AND role = 'guest'");
    $stmt->execute();
    $guest_user = $stmt->fetch();

    if ($guest_user) {
        // Guest login successful, set session data
        $_SESSION['logged_in'] = true;
        $_SESSION['user_name'] = 'guest';
        $_SESSION['is_guest'] = true;
        
        header("Location: dashboard.php");
        exit();
    } else {
        // Guest user not found in database
        header("Location: error.php?error=guest_not_available");
        exit();
    }
} catch (PDOException $e) {
    // Database error
    error_log("Guest login error: " . $e->getMessage());
    header("Location: error.php?error=database_error");
    exit();
}
?>