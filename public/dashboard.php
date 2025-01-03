<?php
require '../includes/auth.php';
require '../includes/db_connect.php';

$user_name = $_SESSION['user_name'];

try {
    $stmt = $pdo->prepare("SELECT job_desc, initial_appli FROM user WHERE user_name = :user_name");
    $stmt->execute(['user_name' => $user_name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $username = $user_name;
        $job_desc = $user['job_desc'];
        $initial_appli = $user['initial_appli'];
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
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <a href="logout.php">Abmelden</a>
    <div class="container_dashboard">

        <h1>Willkommen im Dashboard, <?= htmlspecialchars($username) ?></h1>
        <p>Schön, dass Sie hier her gefunden haben und <?php if ($initial_appli) { ?>
                meine Initiativbewerbung bei Ihnen in Betracht ziehen.
            <?php } else { ?>
                meine Bewerbung als <?= htmlentities($job_desc) ?> in Betracht ziehen.</p> <?php } ?>
    <p class="mb-3">Unten finden Sie weitere Informationen über mich und die Bewerbungsunterlagen sowie Zeugnisse und Empfehlungen als einzelnen Dokumente.</p>
    <!-- go to about me -->
    <a href="about_me.php">Über mich und meine Interessen</a>

    <!-- go to documents -->
    <a href="documents.php">Dokumente</a>
    
    <!-- go to my experience -->
    <a href="experience.php">Erfahrungen</a>

    </div>
</body>

</html>