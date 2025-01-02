<?php
require 'db_connect.php';

$user_name = $_POST['user_name'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM user WHERE user_name = :user_name");
$stmt->execute(['user_name' => $user_name]);
$user = $stmt->fetch();

if ($user && $user['passwort'] === $password) { // Für Tests, später Hashvergleich
    session_start();
    $_SESSION['logged_in'] = true;
    $_SESSION['user_name'] = $user['user_name'];
    header("Location: dashboard.php");
    exit();

} else {
    echo "Ungültige Anmeldedaten.";
}
?>
