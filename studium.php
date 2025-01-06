<?php
require './includes/auth.php';

?>
<!DOCTYPE html>
<html>

<head>
   <title>Dashboard - Medieninformatik</title>
   <link rel="stylesheet" href="./style.css">
   <script src="./js/accordion.js" defer></script>
   <script src="./js/download_page.js" defer></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>

<body>
   <div class="nav">
      <a href="logout"><button class="btn btn--main btn--nav">Abmelden</button></a>
      <a href="dashboard"><button class="btn btn--main btn--nav">Zurück</button></a>
      <a href="#" pdfName="experience_patrick_kaserer" id="downloadPdf"><button class="btn btn--main btn--nav">Download als PDF </button></a>
   </div>
   <div class="container_dashboard">
      <h1>Medieninformatik</h1>
      <div class="container_dashboard">
         <img src="./assets/img/mi.png" width="100%" alt="illustrated image of computer science" class="mi__img--first">
         <p class="mb-2" style="text-align: justify;">Medieninformatik ist ein interdisziplinärer Informatikstudiengang, welcher es Erlaubt in Viele Bereiche einen Einblick zu bekommen aber sich ebenfalls in Bereiche von Interesse zu vertiefen. <br>
            Die Schwerpunkt der Studiengänge (Bachelor und Master) lagen in den Bereichen Informatik, Medien und Wirtschaft.</p>
         <img src="./assets/img/mi2.png" width="75%" alt="illustrated image of computer science" class="mi__img--second">
      </div>
   </div>
</body>

</html>