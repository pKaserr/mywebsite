<?php
require '../includes/auth.php';
require '../includes/db_connect.php';

// $user_name = $_SESSION['user_name'];

// try {
//     $stmt = $pdo->prepare("SELECT job_desc, initial_appli FROM user WHERE user_name = :user_name");
//     $stmt->execute(['user_name' => $user_name]);
//     $user = $stmt->fetch(PDO::FETCH_ASSOC);
//     if ($user) {
//         $username = $user_name;
//         $job_desc = $user['job_desc'];
//         $initial_appli = $user['initial_appli'];
//     } else {
//         echo "Benutzer nicht gefunden.";
//         exit();
//     }
// } catch (PDOException $e) {
//     die("Fehler bei der Datenbankabfrage: " . $e->getMessage());
// }

?>
<!DOCTYPE html>
<html>

<head>
   <title>Dashboard - Experience</title>
   <link rel="stylesheet" href="./style.css">
   <script src="./js/accordion.js" defer></script>
   <script src="./js/download_page.js" defer></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>

<body>
   <a href="logout.php">Abmelden</a>
   <a href="dashboard.php">Zurück</a>
   <a href="#" pdfName="experience_patrick_kaserer" id="downloadPdf">Download als PDF</a>
   <div class="container_dashboard">

      <h1>Meine Erfahrungen</h1>
      <button class="accordion mb-1">Praktisches Studiensemester - dreiQbik"</button>
      <div class="panel">
         <video width="720" autoplay controls loop muted>
            <source src="./assets/videos/exp1.mp4">
            Your browser does not support the video tag.
         </video>
         <p></p>
      </div>
      <button class="accordion mb-1">Projektstudium - Website: "Blind MeetUp"</button>
      <div class="panel">
         <p></p>
      </div>
      <button class="accordion">Bachelorthesis - Implementierung eines Buchungssystems und dessen
         Algorithmus auf Basis einer Immobilienverwaltungsumgebung</button>
      <div class="panel">
         <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perferendis nesciunt quod rem temporibus vero adipisci omnis libero. Distinctio, asperiores? Corporis soluta cum et modi ullam animi ex maiores, quod culpa!
            Nemo reprehenderit saepe deserunt recusandae voluptatibus. Vero quidem corrupti, praesentium, ea recusandae culpa repellat debitis facere reiciendis iste, nihil quas velit ipsam et! Eius, quia nam. Eveniet fugit unde in.
            Cum assumenda quisquam ullam, numquam porro molestiae officia expedita nesciunt quis temporibus. Accusamus error quae aut quo recusandae vitae, distinctio est, quam sint molestias, fuga doloribus quisquam nisi dolor voluptatum!</p>
      </div>
   </div>
</body>

</html>