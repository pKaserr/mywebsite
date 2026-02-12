<?php
require './includes/auth.php';
require './includes/db_connect.php';

$user_name = $_SESSION['user_name'];
$is_guest = isset($_SESSION['is_guest']) && $_SESSION['is_guest'] === true;

$sql = "SELECT role FROM user WHERE user_name = :user_name";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_name', $_SESSION['user_name'], PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

try {
    $stmt = $pdo->prepare("SELECT job_desc, initial_apply FROM user WHERE user_name = :user_name");
    $stmt->execute(['user_name' => $user_name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $username = $user_name;
        $job_desc = $user['job_desc'];
        $initial_apply = $user['initial_apply'];
    } else {
        echo "Benutzer nicht gefunden.";
        exit();
    }
} catch (PDOException $e) {
    die("Fehler bei der Datenbankabfrage: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <!-- <script src="./js/language.js" defer></script> -->
    <!-- <script src="./js/dashboard.js" defer></script> -->
    <link rel="icon" type="image/png" href="./assets/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/favicons/favicon.svg" />
    <link rel="shortcut icon" href="./assets/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicons/apple-touch-icon.png" />
    <link rel="manifest" href="./assets/favicons/site.webmanifest" />
</head>

<body>
    <div class="container">
        <p>Tesfdsfsdt</p>
    </div>
    <!-- <div class="devBtn"></div> -->
    <script>
        // Handle job description variable for translations
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for language manager to be initialized
            setTimeout(() => {
                const jobElement = document.querySelector('[data-job]');
                if (jobElement && window.languageManager) {
                    const jobDesc = jobElement.getAttribute('data-job');
                    
                    // Update translation with job variable
                    const updateJobTranslation = () => {
                        const translation = window.languageManager.translate('dashboard.intro_job', { job: jobDesc });
                        jobElement.textContent = translation;
                    };
                    
                    // Initial update
                    updateJobTranslation();
                    
                    // Listen for language changes
                    document.addEventListener('languageChanged', updateJobTranslation);
                }
            }, 500);
        });
    </script>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>