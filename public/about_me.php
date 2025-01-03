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
   <title>Dashboard - About Me</title>
   <link rel="stylesheet" href="./style.css">
   <script src="./js/download_page.js" defer></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>

<body>
   <a href="logout.php">Abmelden</a>
   <a href="dashboard.php">Zurück</a>
   <a href="#" pdfName="about_patrick_kaserer" id="downloadPdf">Download als PDF</a>

   <div class="container_dashboard">
      <h2>Über mich</h2>
      <img src="./assets/img/me_hfu_i_building.jpg" alt="Me in the I-Building at HFU" style="width: 100%; max-width: 500px; float: left; margin-right: 20px;">
      <p style="text-align: justify;">Hey, ich bin Patrick.<br> <br> Da ich erst mit 28 Jahren angefangen habe zu studieren, bin ich ein älterer Absolvent als die meisten Studierenden. Der Vorteil ist, dass ich ganz genau weiß wo ich im Leben stehe. Erfahrungen sammeln durfte und auch weiß wie die Arbeitswelt aussieht und funktioniert. <br>
         Nachdem ich meinen Hauptschulabschluss und anschließend meine 3-Jährigen Berufsausbildung zur Fachkraft für Lagerlogistik abgeschlossen habe, habe ich mehre Jahre in der Logisik und in anderen Bereichen gearbeitet und Berufserfahrung sammeln dürfen. Die Gründe, weshalb mein erster Schulabschluss ein Hauptschulabschluss war, ist vielschichtig und zu privat um dies in dieser Weiße zu kommunizieren. Bei einem persönlichen Kennenlernen gehe ich aber geren auf diese Frage ein, da sie ausschlaggebend für meine berufliche Zukunft ist. <br> <br>
         Relativ schnell habe ich gemerkt, dass diese Arbeit nicht das ist was ich mir für meine Zukunft wünsche und sie auch nicht mehr weiter machen möchte. Was dazu führte, dass ich in eine Arbeitslosigkeit gerutscht bin, die ich heute aber nicht ohne Grund als Berufliche Neuorienteirung bezeichne. <br> <br>
         Durch meine Berufsausbildung und meinen Hauptschulabschluss konnte ich anschließend das Fachabitur nachholen und bei der Hochschule Furtwangen meinen Bachelor in Medieninformatik erfolgreich abschließend. Aktuell mache ich den Master im selben Studiengang, den ich voraussichtlich Januar bis Februar erfolgreich abschließen werden. Die Arbeit während des Studiums, z. B. im Praktikum, als Lehrbeauftragter oder auch bei studentischen Projekten, macht mir sehr viel Spaß. Hierdurch habe ich gelernt, dass ich die richtige Entscheidung getroffen habe.<br> <br> </p>

      <h2>Berufliche Interessen</h2>
      <img src="./assets/img/me_game_jam.jpg" alt="Me at work" style="width: 100%; max-width: 500px; float: right; margin-left: 20px;">
      <p style="text-align: justify;">Im laufe des Studiums und schon davor, habe ich das Interesse für mehrere Bereichen entwickelt. Hierbei gehe ich nicht auf Stellenbezeichnungen wie "Softwareentwickler" oder "Projektmanager" ein, auch die verschiedenen Programmiersprachen sind hier nicht von belangen. Hier geht es um die Bereiche die mich interessieren und wo ich zukünftig gerne arbeiten würde.</p> <br>
      <h3>Neuronale Netze</h3>
      <p style="text-align: justify;">Schon bevor ich 2018 mit dem Studium begonnen habe, hatte ich großes Interesse an dem Thema künstliche Intelligenz. Selbst betrachte ich den Begriff KI aber als Kampfwort, da der Begriff zu groß ist um in einem Wort den genauen Bereich darzustellen und nach dem ChatGPT-Hype vor alle fürs Marketing verwendet wird. Mein Interesse liegt vor allen bei neuronalen Netzen und Deep Learing. Ich sehe in diesen Bereichen die Zukunft der Entwicklung und stelle es auf eine ähnliche Stufe wie die Entwicklung des Internets. Da mich dieses Thema stark interessiert, informiere ich mich auch privat viel darüber, jedoch ist es gerade als Absolvent schwierig in diesem Bereich Berufserfahrungen zu sammeln, wenn diese nicht schon vorhanden sind. Im Laufe des Studiums habe ich an verschiedenen KI-Projekten gearbeitet. So z.B.: Ein Model welches verschieden Lebensmittel erkennt und die entsprechneden Nährwerte auf einem Augmented Reality-Tisch projiziert, ein XAI Model (Explainable AI) Model, welches visuell die Komplexität eines neuronalen Netzes aufzeigen und gleichzeitig die Blackbox begreiflicher machen soll, oder die Arbeit in meiner Masterthesis, bei dem das neuronale Netz einem Neural Radiance Fields eine fotorealistische 3D repräsentation eine echten Szene approximiert, in der sich in Echtzeit unabhängig bewegt werden kann. <br> <br></p>

      <h3>Didaktik</h3>
      <p style="text-align: justify;">Während meines Studiums hatte ich das Glück als studentische Hilfskraft Erstsemester zu unterrichten und ihnen die Welt der Programmierung beizubringen. Nach meiner Tätigkeit als studentische Hilfskraft wurde mir angeboten als Lehrbeauftragter die Verantwortung zu übernehmen und die Inhalte so zu gestalten wie ich sie für richtig empfinde. Inklusive der Prüfungsleistung.. Diese Arbeit hat mir sehr viel spaß gemacht und mit persönlich auch sehr weitergebracht. Ich habe während meine Lehre verstehen können, was es bedeutet Inhalte tatsächlich zu verstehen. Wie Menschen denken, wie Menschen geführt werden wollen und wie mit ihnen umgegangen werden muss. Ich habe verstanden, dass ein Thema nur dann verstanden wird, wenn es anderen Person erklärt werden kann die keine Erfahrung damit haben. Dies hat mich auch bei meiner Art beeinflusst wie ich mit anderen Menschen kommuniziere und meine Inhalte präsentiere. Ich sehe die Lehre als besonders spannender und wichtiger Bereich. Sowohl selbst Inhalte zu lehren, als auch an Projekten zu arbeiten die dafür gedacht sind Inhalte zu vermitteln und natürlich auch ein leben lang selbst zu lernen. </p><br>

      <h3>Angewande Wissenschaften</h3>
      <p style="text-align: justify;">Während des Masters war die Arbeit im wissenschaftlichen Kontext besonders stark ausgeprägt. Hierbei ist für mich meine eigene Weiterentwicklung das Spannende. Stillstand betrachte ich persönlich als negativ und beziehe mich hierbei auch auf den technologischen Fortschritt. Es macht mir spaß eine Idee zu nehmen oder zu enwtickeln und sich dann mit den möglichen Technologien außeinanderzusetzen die dafür geeignet sind die Idee umzusetzen. Es fordert, dass stetig mit neuen Inhalten außeinandergesetzt wird, dass der Stand der Technik immer aktuell ist und das Problem und diese Lösung immer eine besondere Betrachtung benötigt. Es stellt eine Herausforderung da deren Ausgang oft nicht einzuschätzen ist und umso mehr ist das Ergebnis am Ende dann schöner wenn Dinge entwickelt wurden, die nicht im Alltag schon zur Gewohnheit wurden.</p> <br>

      <h3>Führung und Organisation</h3>
      <p style="text-align: justify;"> Ich gehörte schon immer zu den Menschen das Große und Ganze betrachtet haben, und versucht haben nicht nur die Prozesse hinter dem Handel zu verstehen sondern diese auch zu optimieren. Ich besitze ein ausgeprägtes organisatorischen Blick und die Fähigkeit auch komplexe Prozesse einfach darzustellen. Meine Tätigkeit als Vorsitzender der Verfassten Studierendenschaft, und damit als Hauptverantwortlicher für tausende Studierenden einer Anstalt des Öffentlichen Rechts, haben mir viel Über Führung und Organisation gezeigt. Dass es nicht darum geht, alles zu wissen oder immer eine Antwort auf alle Inhalte zu haben, sondern die Fähigkeit diese Probleme eben zu lösen. Zu wissen welche Personen für welche Inhalte geeignet sind. Resourcen und Kapazitäten so einzusetzen, dass es nicht nur ein erfolgreichem sondern bestenfalls ein zu optimalem Ergebniss führt. Dabei ist ein kontinuierlicher Verbesserungsprozess und richtige Kommunikation das A und O.</p>
   </div>
</body>

</html>