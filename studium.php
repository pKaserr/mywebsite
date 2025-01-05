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
   <a href="logout"><button class="btn btn--main btn--nav">Abmelden</button></a>
   <a href="dashboard"><button class="btn btn--main btn--nav">Zurück</button></a>
   <a href="#" pdfName="experience_patrick_kaserer" id="downloadPdf"><button class="btn btn--main btn--nav">Download als PDF </button></a>
   <div class="container_dashboard">
      <h1>Medieninformatik</h1>
   </div>
</body>

</html>