<?php
require './includes/auth.php';
require './includes/db_connect.php';
$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html>

<head>
   <title>Dashboard - Medieninformatik</title>
   <link rel="stylesheet" href="./style.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="./js/bg_net_graph.js" defer></script>
   <script src="./js/accordion.js" defer></script>
   <script src="./js/chat.js" defer></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
   <link rel="icon" type="image/png" href="./assets/favicons/favicon-96x96.png" sizes="96x96" />
   <link rel="icon" type="image/svg+xml" href="./assets/favicons/favicon.svg" />
   <link rel="shortcut icon" href="./assets/favicons/favicon.ico" />
   <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicons/apple-touch-icon.png" />
   <link rel="manifest" href="./assets/favicons/site.webmanifest" />
</head>

<body>
   <nav>
      <div class="nav">
         <a href="logout"><button class="btn btn--main btn--nav">Abmelden</button></a>
         <a href="dashboard"><button class="btn btn--main btn--nav">Zurück</button></a>
      </div>
   </nav>
   <main>
      <div class="container_dashboard">
         <?php if (!$is_guest) { ?>
            <div class="chatbox until-md-display-none">
               <div class="display-flex flex-justify-between">
                  <button class="chatbox__minimize" onclick="minimizeChatBox()">Einklappen</button>
                  <button class="chatbox__toggle" onclick="toggleChatboxSize()">Vergrößern</button>
               </div>
               <div class="chatbox__display">
                  <p class="chatbox__message chatbox__message--left">Hi <?php echo htmlspecialchars($user_name); ?>, ich
                     bin
                     PAi.</p>
                  <p class="chatbox__message chatbox__message--left">Ich bin hier um dir Fragen zu Patricks Person und
                     seine Bewerbung zu beantworten.</p>
               </div>
               <input type="text" class="chatbox__userInput" placeholder="Stellen Sie eine Frage">
            </div>
         <?php } ?>
         <canvas class="particleCanvas"></canvas>
         <!-- Hero Section -->
         <div class="studium-hero">
            <div class="hero-content">
               <h1 class="c2-main">Medieninformatik B.Sc. & M.Sc.</h1>
               <h2 class="c1-second">Interdisziplinäre Informatik mit Fokus auf Anwendung</h2>
               <p class="hero-description">
                  <strong>Medieninformatik</strong> ist ein interdisziplinärer Informatikstudiengang,
                  der es erlaubt, in vielen Bereichen Einblicke zu bekommen und sich auf die Gebiete zu vertiefen, für
                  die Interesse besteht.
               </p>
            </div>

            <!-- Key Message -->
            <div class="key-message">
               <div class="message-card bg-main1">
                  <h3>💻 Informatiker</h3>
                  <p>Ich betrachte meine Aufgabenbereiche nicht nur beim Erstellen von Software, sondern verstehe auch
                     die Prozesse dahinter.</p>
               </div>
            </div>
         </div>

         <!-- Study Areas Visualization -->
         <div class="study-areas">
            <h2 class="section-title">Mein Studium in drei Hauptbereichen</h2>
            <div class="areas-grid">
               <div class="area-card computer_science-card">
                  <div class="area-header">
                     <h3>Informatik</h3>
                     <span class="area-percentage">~65%</span>
                  </div>
                  <div class="area-content">
                     <ul class="skills-list">
                        <li>Mathematik & Algorithmen</li>
                        <li><strong>Programmierung & Software-Entwicklung</strong></li>
                        <li>Datenbanken & Verteilte Systeme</li>
                        <li>Kryptographie & Formale Sprache</li>
                        <li><strong>Softwaretechnik & Softwaredesign</strong></li>
                        <li>Kommunikationstechnik</li>
                        <li>Internet of Things & Webentwicklung</li>
                        <li>Programmierparadigmen</li>
                        <li><strong>Künstliche Intelligenz</strong></li>
                     </ul>
                  </div>
               </div>

               <div class="area-card media-card">
                  <div class="area-header">
                     <h3>Medien</h3>
                     <span class="area-percentage">~25%</span>
                  </div>
                  <div class="area-content">
                     <ul class="skills-list">
                        <li>Psychologie & User Experience</li>
                        <li>Recht & Computergrafik</li>
                        <li><strong>Computer Vision</strong></li>
                        <li><strong>Medienwirtschaft</strong></li>
                        <li>Interaktionsdesign</li>
                        <li>VR/AR Technologien</li>
                        <li>Gameentwicklung</li>
                        <li>Design & Medienproduktion</li>
                     </ul>
                  </div>
               </div>

               <div class="area-card economics-card">
                  <div class="area-header">
                     <h3>Wirtschaft</h3>
                     <span class="area-percentage">~10%</span>
                  </div>
                  <div class="area-content">
                     <ul class="skills-list">
                        <li>Ökonomie & Management</li>
                        <li><strong>Produktmanagement</strong></li>
                        <li>BWL & Unternehmensgründung</li>
                        <li>Marketing & Vertrieb</li>
                        <li><strong>Projektmanagement</strong></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>

         <!-- Detailed Explanation -->
         <div class="studium-details">
            <h2 class="details-title">Warum Medieninformatik?</h2>

            <div class="explanation-cards">
               <div class="explanation-card">
                  <div class="card-icon">🎯</div>
                  <h3>Anwendungsorientiert</h3>
                  <!-- <p>Während die allgemeine Informatik oft in Kernelementen der Informationsverarbeitung vertieft,
                     fokussiert sich Medieninformatik auf das <strong>Gesamtbild von Anwendungen</strong></p> -->
                  <p>Während die allgemeine Informatik die Werkzeuge bereitstellt, liegt der Fokus der Medieninformatik
                     auf dem <strong>Gesamtbild von Anwendungen</strong> der digitalen und technischen Welt.</p>
               </div>

               <div class="explanation-card">
                  <div class="card-icon">🔬</div>
                  <h3>Wissenschaftlich fundiert</h3>
                  <p>Ich entwickle nicht nur anwendungsorientiert, sondern auch <strong>wissenschaftlich</strong>.
                     Die Verbindung von Theorie und Praxis ermöglicht innovative Lösungsansätze.</p>
               </div>

               <div class="explanation-card">
                  <div class="card-icon">🌐</div>
                  <h3>Interdisziplinär</h3>
                  <p>Die Nebenbereiche Medien und Wirtschaft sind für mich relevant und spanned. Sie unterstützen dabei,
                     <strong>das große Ganze zu verstehen</strong> - vom Markt bis zum Endprodukt.
                  </p>
               </div>
            </div>

            <!-- Core Competency Statement -->
            <div class="core-statement">
               <div class="statement-content">
                  <h3 class="c1-second">Meine Kernkompetenz</h3>
                  <blockquote>
                     <div class="blockquote">
                        Ich verstehe mich als Brückenbauer zwischen angewandter Forschung und Entwicklung.
                        Meine Kernkompetenz liegt am Anfang der Konzeptionsphase: Ich bin derjenige, der die
                        grundlegende Struktur und Funktionsweise komplexer Systeme definiert. Mit einem klaren Fokus auf
                        Künstliche Intelligenz, Computer Vision und der Digitalisierung entwickle ich mit Forschergeist
                        die
                        technologische Basis dafür, wie innovative Lösungen konzipiert und realisiert werden können, um
                        zukunftsfähige Produkte zu schaffen.</div>
                  </blockquote>
               </div>
            </div>
         </div>
      </div>
   </main>
   <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>