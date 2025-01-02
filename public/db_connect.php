<?php
$host = "localhost";
$dbname = "my_db";
$username = "root"; // Standardnutzer bei XAMPP
$password = ""; // Standardmäßig leer bei XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Datenbankverbindung erfolgreich!";
} catch (PDOException $e) {
    die("Verbindung fehlgeschlagen: " . $e->getMessage());
}
?>
