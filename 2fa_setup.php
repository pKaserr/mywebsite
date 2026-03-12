<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require './includes/db_connect.php';
require './vendor/autoload.php';

use Google\Authenticator\GoogleAuthenticator;

if (!isset($_SESSION['pending_2fa_user_id']) || !isset($_SESSION['pending_2fa_user_name'])) {
    header('Location: index.php');
    exit();
}

$ga = new GoogleAuthenticator();

// Generate a new secret if we don't have one in the session yet
if (empty($_SESSION['temp_2fa_secret'])) {
    $_SESSION['temp_2fa_secret'] = $ga->generateSecret();
}
$secret = $_SESSION['temp_2fa_secret'];
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';
    if ($ga->checkCode($secret, $code)) {
        // Build the update query
        try {
            $stmt = $pdo->prepare("UPDATE `user` SET `two_factor_secret` = :secret WHERE `user_id` = :id");
            $stmt->execute([
                'secret' => $secret,
                'id' => $_SESSION['pending_2fa_user_id']
            ]);

            // Finalize login
            $_SESSION['logged_in'] = true;
            $_SESSION['user_name'] = $_SESSION['pending_2fa_user_name'];

            // Clean up 2FA session variables
            unset($_SESSION['temp_2fa_secret']);
            unset($_SESSION['pending_2fa_user_id']);
            unset($_SESSION['pending_2fa_user_name']);

            header('Location: dashboard.php');
            exit();
        } catch (PDOException $e) {
            $error_msg = "Database error: " . $e->getMessage();
        }
    } else {
        $error_msg = "Invalid code. Please try again.";
    }
}
// Generate QR Code URL
$otpauthString = "otpauth://totp/" . rawurlencode('Patrick Kaserer') . ":" . rawurlencode($_SESSION['pending_2fa_user_name']) . "?secret=" . $secret . "&issuer=" . rawurlencode('Patrick Kaserer');
// Using Google Charts API to generate the QR code image
// QuickChart API als direkter Ersatz für Google
$qrCodeImage = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&ecc=M&data=" . rawurlencode($otpauthString);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>2FA Setup</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <main>
        <canvas class="particleCanvas"></canvas>
        <div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh;">
            <div class="lp_name" style="text-align: center; background: rgba(0,0,0,0.7); padding: 40px; border-radius: 10px;">
                <h1 style="color: white; margin-bottom: 20px;">2FA Einrichtung</h1>
                <p>Debug URL: <?php echo htmlspecialchars($qrCodeImage); ?></p>
                <p style="color: white; margin-bottom: 20px;">Bitte die Google Authenticator App herunterladen und
                    diesen QR-Code scannen:</p>
                <img src="<?php echo $qrCodeImage; ?>" alt="QR Code" style="margin-bottom: 20px; border: 5px solid white; border-radius: 5px;" />
                <p style="color: white; margin-bottom: 20px;">Oder gib den Key manuell ein:
                    <strong><?php echo $secret; ?></strong>
                </p>

                <?php if ($error_msg): ?>
                    <p style="color: red; margin-bottom: 15px;"><?php echo htmlspecialchars($error_msg); ?></p>
                <?php endif; ?>

                <form class="display-flex flex-column login" action="2fa_setup.php" method="POST" style="align-items: center;">
                    <div class="login--input" style="margin-bottom: 15px;">
                        <label for="code" style="color: white;">6-stelliger Code</label>
                        <input type="text" placeholder="123456" id="code" name="code" required style="text-align: center; font-size: 1.2rem; letter-spacing: 2px;">
                    </div>
                    <button class="button_form btn--lp" type="submit">Verifizieren & Einloggen</button>
                    <a href="index.php" style="color: white; margin-top: 15px; text-decoration: underline;">Zurück zum
                        Login</a>
                </form>
            </div>
        </div>
    </main>
    <script defer src="./js/bg_net_graph.js"></script>
</body>

</html>