<?php
/**
 * PDO MySQL connection using environment variables (.env)
 * Loads .env from project root and establishes a robust PDO connection
 */

require __DIR__ . '/../vendor/autoload.php';
// require_once __DIR__ . '/error_handler.php'; // Optionally enable custom error handler

use Dotenv\Dotenv;

// Load .env from includes directory (same directory as this file)
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];

// Build DSN similar to IONOS example but with port and charset for reliability
$dsn = "mysql:host={$host};port=3306;dbname={$dbname};charset=utf8mb4";

// Recommended PDO options
$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $pdoOptions);
} catch (PDOException $e) {
    // Log the database connection error using standard PHP error log
    error_log("Database connection failed: " . $e->getMessage());

    // Redirect to error page instead of showing raw error
    header("Location: /error.php?type=500");
    exit();
}
