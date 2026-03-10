<?php
session_start();
require './includes/db_connect.php';
require './vendor/autoload.php';

use Google\Authenticator\GoogleAuthenticator;

if (!isset($_SESSION['pending_2fa_user_id']) || !isset($_SESSION['pending_2fa_user_name'])) {
    header('Location: index.php');
    exit();
}

// Fetch the secret from database
try {
    $stmt = $pdo->prepare("SELECT `two_factor_secret` FROM `user` WHERE `user_id` = :id");
    $stmt->execute(['id' => $_SESSION['pending_2fa_user_id']]);
    $user = $stmt->fetch();
    if (!$user || empty($user['two_factor_secret'])) {
        // Fallback if secret is missing but they are somehow here
        header('Location: 2fa_setup.php');
        exit();
    }
    $secret = $user['two_factor_secret'];
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

$ga = new GoogleAuthenticator();
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';
    if ($ga->checkCode($secret, $code)) {
        // Verifiziert - Einloggen
        $_SESSION['logged_in'] = true;
        $_SESSION['user_name'] = $_SESSION['pending_2fa_user_name'];
        // Note: file_hash isn't in pending_2fa session by default, but the main code didn't strictly require it
        // Or we could fetch user data again if needed.
        
        // Clean up
        unset($_SESSION['pending_2fa_user_id']);
        unset($_SESSION['pending_2fa_user_name']);

        header('Location: dashboard.php');
        exit();
    } else {
        $error_msg = "Falscher Code. Bitte erneut versuchen.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>2FA Verification</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <main>
        <canvas class="particleCanvas"></canvas>
        <div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh;">
            <div class="lp_name" style="text-align: center; background: rgba(0,0,0,0.7); padding: 40px; border-radius: 10px;">
                <h1 style="color: white; margin-bottom: 20px;">Zwei-Faktor-Authentifizierung</h1>
                <p style="color: white; margin-bottom: 20px;">Bitte gib den 6-stelligen Code aus deiner Google Authenticator App ein.</p>
                
                <?php if ($error_msg): ?>
                    <p style="color: red; margin-bottom: 15px;"><?php echo htmlspecialchars($error_msg); ?></p>
                <?php endif; ?>

                <form class="display-flex flex-column login" action="2fa_verify.php" method="POST" style="align-items: center;">
                    <div class="login--input" style="margin-bottom: 15px;">
                        <input type="text" placeholder="123456" id="code" name="code" required style="text-align: center; font-size: 1.2rem; letter-spacing: 2px;">
                    </div>
                    <button class="button_form btn--lp" type="submit">Verifizieren</button>
                    <a href="index.php" style="color: white; margin-top: 15px; text-decoration: underline;">Abbrechen / Zurück zum Login</a>
                </form>
            </div>
        </div>
    </main>
    <script defer src="./js/bg_net_graph.js"></script>
</body>
</html>
