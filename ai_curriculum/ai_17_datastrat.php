<?php
// variables:
$title = "KI-Strategie & Use-Case-Evaluierung";
$page_headline = "17. KI-Strategie & Use-Case-Evaluierung";
$prev_link = 'ai_16_strategie.php';
$prev_text = 'KI-Strategie & Use-Case-Evaluierung';
$next_link = 'ai_18_mlops.php';
$next_text = 'KI-Architektur & MLOps';

ob_start();
?>

<h3 class="c1-second mt-1">Garbage In, Garbage Out</h3>
<p>Viele Unternehmen glauben, das größte Hindernis bei einem KI-Projekt sei die Auswahl des richtigen Algorithmus. Die Realität sieht anders aus: KI ist nur der Motor. Die Daten sind der Treibstoff. Wenn du verschmutzten Treibstoff in einen Motor füllst, stottert er und geht aus. In der Informatik nennen wir das <strong>"Garbage In, Garbage Out" (GIGO)</strong>.</p>
<p>Bevor die erste Zeile Code geschrieben wird, muss der Data Readiness-Grad (Datenreife) geprüft werden. Liegen die Daten unstrukturiert in verstaubten Tabellen? Sind sie voller Lücken oder Duplikate? Das bedeutet nicht zwangsläufig das Ende der Idee, aber es erzwingt eine Abwägung: Schlechte Daten können durch aufwendiges Data Cleansing formatiert und nutzbar gemacht werden. Das kann aber viel Zeit und Geld kosten. Die strategische Frage lautet also: Ist der zu erwartende Mehrwert des KI-Projekts groß genug, um ein (eventuell monatelanges) Aufräumen der Datenlandschaft zu finanzieren?</p>
<hr>

<h3 class="c1-second mt-1">Deep Dive: Data Engineering</h3>
<p>Ein KI-Projekt ist wie der sprichwörtliche Eisberg. Das fertige neuronale Netz, das Vorhersagen trifft, ist nur die sichtbare Spitze. Alles unter der Wasseroberfläche sind das <strong>Data Engineering</strong>.</p>


<div class="ai-card mt-1">
    <h4>Infrastruktur & Datenpipelines</h4>
    <p>Data Engineers bauen die notwendige Infrastruktur. Sie extrahieren Daten aus verschiedenen Silos (z. B. ERP-Systemen, Textdokumenten, Maschinensensoren), bereinigen und strukturieren sie und legen sie in einem zentralen Speicher ab, damit die Modelle effizient darauf zugreifen können.</p>
</div>
<div class="ai-card mt-1">
    <h4>Das Labeling-Problem</h4>
    <p>Viele Modelle (Supervised Learning) benötigen eine Ground Truth. Sollen beispielsweise E-Mails von Kunden klassifiziert werden (Vorsicht: Datenschutz), muss zunächst ein Mensch tausende Datensätze händisch als "Beschwerde" oder "Anfrage" markieren. Das ist oft extrem teuer und zeitaufwendig. Ein Ausweg für ungelabelte Daten bietet oft Unsupervised Learning, wie z.B. Anomaly Detection, das selbstständig Auffälligkeiten in den Datenmustern findet, jedoch ist es aufwändiger, oder kann sogar unmöglich sein, über Unsupervised Learning die gewünschte Genauigkeit zu erreichen.</p>
</div>

<div class="ai-card--notice mt-1">
    <p><strong>Labeling im Alltag</strong> <br> Hast du schon mal eine Beschwerde oder ein Anregung an ein Unternehmen geschrieben? Wie viele "Unterkategorien" hast du auswählen müssen bevor du dann am Ende auf "Sonstiges" geklickt hast oder auf ein Forum verwiesen wurdest? <br> Wusstest du, dass Googles eigenes Bot-Abwehrsystem (reCaptcha) nicht nur dazu dient, dass keine Bots mehr auf Webseiten zugreifen können (was es übrignes nicht gut macht), sondern auch um Bilder damit zu labeln? Also einem Bild eine "Unterschrift"geben: "Hier ist ein Auto" oder "Hier ist ein Fahrrad", was dann für das Training eines KI-Modells verwendet wird.</p>
</div>

<hr>

<h3 class="c1-second mt-1">Umgang mit Datenmangel: Wenn der Treibstoff fehlt</h3>
<p>Was passiert, wenn ein Use-Case strategisch brillant ist, wir aber schlichtweg nicht genug Trainingsdaten haben? Das ist in der Industrie der Normalfall. Maschinen gehen zum Glück selten kaputt. Woher also die Daten für "kaputte Maschinen" nehmen? Hier nutzt die moderne angewandte Forschung drei hocheffektive Strategien:</p>

<div class="ai-card mt-1">
    <h4>1. Transfer Learning (Wissen recyceln)</h4>
    <p>Warum das Rad neu erfinden? Wir nehmen ein riesiges, vorgefertigtes Modell (wie ein Open-Source Computer-Vision-Netz), das bereits auf Millionen von Alltagsbildern trainiert wurde. Es hat schon verstanden, was Kanten, Kontraste und Formen sind. Wir trainieren (Fine-Tuning) nur noch die letzte Schicht mit unseren wenigen, unternehmensspezifischen Bildern nach. Das spart Daten und Rechenzeit.</p>
</div>

<div class="ai-card mt-1">
    <h4>2. Data Augmentation (Daten künstlich aufblähen)</h4>
    <p>Hast du nur 1.000 Bilder von einem Bauteil? Dann mach 10.000 daraus! Durch simple Bildverarbeitung rotieren wir die Bilder minimal, spiegeln sie, verändern die Helligkeit, fügen etwas Rauschen hinzu oder schneiden Ränder ab. Für die KI ist jedes dieser leicht veränderten Bilder eine komplett neue Information, aus der sie lernen kann.</p>
</div>

<div class="ai-card mt-1">
    <h4>3. Synthetische Daten</h4>
    <p>Wenn uns echte Daten fehlen, bauen wir sie uns einfach selbst. Selbstverständlich ist auch hier immer die Frage, in wie weit sich dieser Aufwand für das Projekt rentiert, jedoch sind die Möglichkeiten hier quasi nach oben offen. Ein relativ einfaches Skript, das Daten nach einem vordefinierten Format erstellt und algorithmisch Fehler einbaut, damit eine KI lernt, wie diese Fehler auszusehen haben, ist schnell geschrieben. <br> Als Teil meiner Masterthesis musste ich Bilder von einer realen Szene erstellen um eine KI darauf zu trainieren. Wichtig waren hier vor Allem die exakten Kameraparameter (Position, Rotation, Brennweite, Auflösung, etc.). Ohne entsprechende Ausrüstung ist das kaum in der Realität umzusetzen, da es hier um Millimetergenaue Positionierung und Ausrichtung geht. Um dieses Problem zu lösen, habe ich die Welt einfach digital gebaut, dort die Kameras positioniert und das neuronale Netz darauf trainiert. Ich habe also einen digitalen Zwilling der realen Welt erschaffen. Das Ergebnis war am Ende eine bessere Bemessung der Umgebung als ein analoger Sensor liefern konnte (was, zugegeben, ebenfalls ein Mangel darstellt, wenn man einen Sensor synthetisieren möchte).</p>
</div>

<div class="ai-card--notice mt-1">
    <p><strong>Fazit:</strong> Datenstrategie ist keine lästige IT-Hausaufgabe, sondern ein harter Wettbewerbsvorteil. Algorithmen sind heute oft Open Source und für alle zugänglich. Das einzige, was ein Unternehmen wirklich einzigartig macht und vor der Konkurrenz schützt, sind saubere, exklusive und hochqualitative Daten.</p>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>