<?php
require './includes/db_connect.php';

// TEMPORÄRE STILLE DEBUG-LOGS - nur in error.log, keine Ausgabe auf Seite
error_log("=== LOGIN ATTEMPT START ===");

// Session-Management mit sicheren Cookie-Parametern
// Use secure cookies only when HTTPS is active (local XAMPP is usually HTTP)
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
session_set_cookie_params([
    'httponly' => true,
    'secure' => $isHttps,
    'samesite' => 'Strict'
]);
session_start();

// Eingaben prüfen und bereinigen
error_log("Request method: " . $_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST request detected");
    error_log("POST data keys: " . implode(', ', array_keys($_POST)));
    error_log("Session CSRF token exists: " . (isset($_SESSION["csrf_token"]) ? 'YES' : 'NO'));
    error_log("POST CSRF token exists: " . (isset($_POST["csrf_token"]) ? 'YES' : 'NO'));
    
    if (!isset($_POST["csrf_token"]) || !isset($_SESSION["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])) {
        error_log("CSRF token validation FAILED");
        header("Location: error.php?error=invalid_token");
        exit();
    }
    error_log("CSRF token validation PASSED");
    // Benutzername und Passwort aus POST abrufen und validieren
    $user_name = trim($_POST['user_name']);
    $password = $_POST['password'];
    error_log("Username: '$user_name', Password length: " . strlen($password));

    // Überprüfen, ob die Eingaben nicht leer sind
    if (empty($user_name) || empty($password)) {
        error_log("Empty username or password detected");
        header("Location: error.php?error=missing_data");
        exit();
    }
    error_log("Username and password validation passed");

    try {
        error_log("Attempting database query for user: $user_name");
        // Benutzer aus der Datenbank abrufen
        $stmt = $pdo->prepare("SELECT * FROM user WHERE user_name = :user_name");
        $stmt->execute(['user_name' => $user_name]);
        $user = $stmt->fetch();
        
        if ($user) {
            error_log("User found in database: " . $user['user_name']);
            error_log("Stored password hash exists: " . (!empty($user['passwort']) ? 'YES' : 'NO'));
        } else {
            error_log("User NOT found in database");
        }

        // Benutzername und Passwort überprüfen
        if ($user && password_verify($password, $user['passwort'])) {
            error_log("Password verification SUCCESS - redirecting to dashboard");
            // Login erfolgreich, Session-Daten setzen
            $_SESSION['logged_in'] = true;
            $_SESSION['user_name'] = $user['user_name'];
            header("Location: dashboard.php");
            exit();
        } else {
            if ($user) {
                error_log("Password verification FAILED for existing user");
            }
            error_log("Login failed - redirecting to error page");
            // Ungültige Login-Daten
            header("Location: error.php?error=invalid_credentials");
            exit();
        }
    } catch (PDOException $e) {
        // Fehler bei der Datenbankabfrage
        error_log("Login-Fehler: " . $e->getMessage());
        header("Location: error.php?error=database_error");
        exit();
    }
} else {
    // Kein POST-Request
    error_log("No POST request - method was: " . $_SERVER['REQUEST_METHOD']);
    header("Location: error.php?error=invalid_request");
    exit();
}

error_log("=== LOGIN ATTEMPT END ===");
