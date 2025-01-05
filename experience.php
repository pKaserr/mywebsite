<?php
require './includes/auth.php';

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
   <a href="logout.php"><button class="btn btn--main btn--nav">Abmelden</button></a>
   <a href="dashboard"><button class="btn btn--main btn--nav">Zurück </button></a>

   <a href="#" pdfName="experience_patrick_kaserer" id="downloadPdf"><button class="btn btn--main btn--nav">Download als PDF </button></a>
   <div class="container_dashboard">
      <h1>Erfahrungen</h1>

      <button class="accordion">Hochschullehre</button>
      <div class="panel">
         <p style="text-align: justify;"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime delectus voluptatum, repellendus nihil sunt quasi magnam. Alias ipsum libero tempora, at exercitationem laboriosam illum nostrum voluptatibus. Quos nobis repellendus obcaecati.
            Minima, unde. Consequatur expedita odio possimus architecto. Ab, quisquam. Cum, dolores. Cum voluptates laboriosam minima perspiciatis ullam esse adipisci praesentium unde eligendi earum. Fugiat, aperiam non. Neque, doloribus temporibus! Harum.
            Voluptates sit autem nam amet hic error ad vero culpa vitae dolorem quia dolor non sunt harum, ut perferendis quae ipsa, porro adipisci fugit. Quia eligendi placeat quae labore nam?</p>
         <video class="ml-2" style="clear:right; float: right" width="480" autoplay controls loop muted>
            <source src="./assets/videos/teaching.mp4">
            Your browser does not support the video tag.
         </video>
         <p style="text-align: justify;"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime delectus voluptatum, repellendus nihil sunt quasi magnam. Alias ipsum libero tempora, at exercitationem laboriosam illum nostrum voluptatibus. Quos nobis repellendus obcaecati.
            Minima, unde. Consequatur expedita odio possimus architecto. Ab, quisquam. Cum, dolores. Cum voluptates laboriosam minima perspiciatis ullam esse adipisci praesentium unde eligendi earum. Fugiat, aperiam non. Neque, doloribus temporibus! Harum.
            Voluptates sit autem nam amet hic error ad vero culpa vitae dolorem quia dolor non sunt harum, ut perferendis quae ipsa, porro adipisci fugit. Quia eligendi placeat quae labore nam?</p>
      </div>


      <button class="accordion">Forschungsprojekt - Tangible AR</button>
      <div class="panel">

         <video class="mr-2" style="clear:left; float: left" width="480  " controls>
            <source src="./assets/videos/TAR.mp4">
            Your browser does not support the video tag.
         </video>

         <p style="text-align: justify;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, adipisci beatae optio nulla sit incidunt atque dolorum, nemo, vitae aliquam tempore? Ratione sed voluptas modi sequi porro in enim ipsum?
            Accusantium ipsum expedita rerum maxime quis nisi dignissimos adipisci exercitationem aliquam quo, tenetur provident ratione alias fugiat numquam cupiditate nesciunt molestiae, magnam illum! Quas recusandae exercitationem perferendis? Ullam, eius omnis?
            Magnam soluta, sequi impedit quae aliquid, voluptates non minus beatae porro eos architecto unde praesentium, eum cupiditate? Ea, consequatur officia possimus totam aspernatur reprehenderit ex dicta, repudiandae provident sint amet!
            Culpa magnam cupiditate, necessitatibus similique harum ab eius aliquid eos recusandae quaerat quae dolores maxime quam rem reiciendis ex cum earum. Eligendi quam iste cum. Impedit unde autem vitae praesentium.
      </div>


      <button class="accordion">Masterthesis - Synthesized Sensor Data from Neural Radiance Fields</button>
      <div class="panel">

         <video class="ml-2" style="clear:right; float: right" width="480  " controls>
            <source src="./assets/videos/TAR.mp4">
            Your browser does not support the video tag.
         </video>

         <p style="text-align: justify;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, adipisci beatae optio nulla sit incidunt atque dolorum, nemo, vitae aliquam tempore? Ratione sed voluptas modi sequi porro in enim ipsum?
            Accusantium ipsum expedita rerum maxime quis nisi dignissimos adipisci exercitationem aliquam quo, tenetur provident ratione alias fugiat numquam cupiditate nesciunt molestiae, magnam illum! Quas recusandae exercitationem perferendis? Ullam, eius omnis?
            Magnam soluta, sequi impedit quae aliquid, voluptates non minus beatae porro eos architecto unde praesentium, eum cupiditate? Ea, consequatur officia possimus totam aspernatur reprehenderit ex dicta, repudiandae provident sint amet!
            Culpa magnam cupiditate, necessitatibus similique harum ab eius aliquid eos recusandae quaerat quae dolores maxime quam rem reiciendis ex cum earum. Eligendi quam iste cum. Impedit unde autem vitae praesentium.
      </div>


      <button class="accordion">Praktisches Studiensemester - dreiQbik</button>
      <div class="panel">
         <p style="text-align: justify;"> Während des Bachelors absolvierte ich mein praktisches Studiensemester bei der Webagentur dreiQbik Karlsruhe. Schwerpunkt war die Fullstack-Entwicklung von indviduellen Webanwendungen für Unternehmen. Der USP war die Verwendung von CMS "WordPress" als Backend, auf dem die individuelle Webanwendung entwickelt wurde. Hierbei wurde WordPress nicht verwendet, um die Anwendung über das CMS wie einen Baukasten zu füllen, sondern WordPress diente als Backend, auf dem die individuelle Webanwendung entwickelt wurde. Der Kunde konnte anschließend mit für ihn entwickelten Custom-Fields die Inhalte selbst befüllen. <br> Während des Praktikums von sechs Monaten wurde ich in allen Prozessen der Entwicklung mit einbezogen und gefordert. Von der Kundenakquise, Kundengespräche, Projektmanagement, Back- und Frontendentwicklung bis zu Deployment der entsprechenden Software.</p>

         <video class="mr-2" style="clear:left; float: left" width="720" autoplay controls loop muted>
            <source src="./assets/videos/exp1.mp4">
            Your browser does not support the video tag.
         </video>

         <p style="text-align: justify;">Während des Praktikums von sechs Monaten wurde ich in allen Prozessen der Entwicklung mit einbezogen und gefordert. Von der Kundenakquise, Kundengespräche, Projektmanagement, Back- und Frontendentwicklung bis zu Deployment der entsprechenden Software. Bei einem Relaunch einer Website von GoSilico haben ein weiterer Praktikant und ich den Großteil der Prozesse übernommen. Neben den Standardtools der Fullstack-Webentwicklung durfte ich hier viele Kenntnisse der Softwareentwicklung kennenlernen. Ich wurde aktiv in alle Prozesse integriert und konnte auch Erfahrungen im Management und der Organisation sammeln. Im Video ein Ausschnitt der Präsentation ohne Ton, bei der die GoSilico-Webapp vorgestellt wurde.</p>
      </div>


      <button class="accordion">Projektstudium - Website: "Blind MeetUp"</button>
      <div class="panel">
         <p style="text-align: justify;">Die Hochschule Furtwangen ist als Hochschule für angewandte Wissenschaften eine praktisch orientierte Hochschule. Alle Studiengänge in der Fakultät mussten ein Projektstudium absolvieren, was sich über zwei Semester zieht. Hierbei geht es darum, die gelernten Inhalte in einem eigenen, von den Studierenden entwickelten Projekt unter Beweis zu stellen. In einem 6-köpfigen Team wurde hier die eigens konzipierte Webanwendung "Blind MeetUp" entwickelt. Die Idee dahinter war, eine Plattform für Studierende der Hochschule anzubieten, bei der sich die Studierenden anonym zu zweit oder in Gruppen treffen können.</p>

         <video class="ml-2" style="clear:right; float: right" width="720" controls>
            <source src="./assets/videos/ImageVideo_Final.mp4">
            Your browser does not support the video tag.
         </video>
         <p style="text-align: justify;">Im Projekt war ich für die Entwicklung der Anwendung und mit einem weiteren Komilitonen für das Projektmanagement mit Scrum verantwortlich. Auch wenn das Projekt durch einen Professor unterstützt wurde, oblag die Verantwortung für die Idee, das Konzept, Marketing, Entwicklung und Deployment den Studierenden. Durch die Coronapandemie wurde das Projekt leider nie released. Das Promotionvideo für die Webanwendung ist im Video zu sehen.</p>
      </div>


      <button class="accordion">Bachelorthesis - Implementierung eines Buchungssystems und dessen
         Algorithmus auf Basis einer Immobilienverwaltungsumgebung</button>
      <div class="panel">
         <p style="text-align: justify;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, adipisci beatae optio nulla sit incidunt atque dolorum, nemo, vitae aliquam tempore? Ratione sed voluptas modi sequi porro in enim ipsum?
            Accusantium ipsum expedita rerum maxime quis nisi dignissimos adipisci exercitationem aliquam quo, tenetur provident ratione alias fugiat numquam cupiditate nesciunt molestiae, magnam illum! Quas recusandae exercitationem perferendis? Ullam, eius omnis?
            Magnam soluta, sequi impedit quae aliquid, voluptates non minus beatae porro eos architecto unde praesentium, eum cupiditate? Ea, consequatur officia possimus totam aspernatur reprehenderit ex dicta, repudiandae provident sint amet!
            Culpa magnam cupiditate, necessitatibus similique harum ab eius aliquid eos recusandae quaerat quae dolores maxime quam rem reiciendis ex cum earum. Eligendi quam iste cum. Impedit unde autem vitae praesentium.
      </div>

   </div>
</body>

</html>