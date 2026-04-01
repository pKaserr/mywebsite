<?php
// variables:
$title = "KI-Strategie & Use-Case-Evaluierung";
$page_headline = "16. KI-Strategie & Use-Case-Evaluierung";
$prev_link = 'ai_dashboard.php';
$prev_text = 'Zurück zur Übersicht';
$next_link = 'ai_17_datastrat.php';
$next_text = 'Datenstrategie & Data Engineering';

ob_start();
?>

<h3 class="c1-second mt-1">Fear Of Missing Out</h3>
<p>In der EU haben wir ein betriebswirtschaftlichen Problem: Wir scheuen Risiken. Aus gutem Grund: Hohe Standards und Personalkosten verzeihen keine teuren Flops. Wenn ein neues Projekt scheitert, schmerzt das finanziell sehr. Die logische Konsequenz? Wir optimieren lieber altbekannte Prozesse, anstatt echtes Neuland zu betreten.</p>
<h4 class="c2-second mt-1">Das KI-Paradoxon</h4>
<p>Doch beim aktuellen KI-Hype passiert etwas völlig Paradoxes. Getrieben von der Panik: <em>"Wir müssen jetzt irgendwas mit KI machen, sonst hängt uns die Konkurrenz ab!"</em>, wird diese Vorsicht plötzlich über Bord geworfen. KI gilt als Inbegriff von modernem Unternehmertum und dem Traum, Personalkosten zu senken. Dieser blinde Aktionismus führt oft zu teuren, isolierten Leuchtturm-Projekten. Sie sehen auf einer PowerPoint-Folie fantastisch aus, liefern aber am Ende keinen echten betriebswirtschaftlichen Wert.</p>

<h4 class="c2-second mt-1">Die falsche Frage: "Kann KI das?"</h4>
<p>Wenn Unternehmen über KI nachdenken, lautet die erste Frage meistens: "Kann eine KI unser Problem überhaupt lösen?" Die Antwort darauf ist fast immer "Ja". Warum? Das Universelle Approximations-Theorem (siehe <a href="./ai_12_uat.php">hier</a>) garantiert uns mathematisch, dass ein neuronales Netz quasi jedes Problem abbilden und "lösen" kann, völlig unabhängig davon, ob das wirtschaftlich auch nur im Ansatz Sinn ergibt. Die technische Machbarkeit ist also selten das Problem. Die allererste Frage, die man sich strategisch zwingend stellen muss, lautet stattdessen: "Brauchen wir hierfür überhaupt KI?" Wenn ein Prozess mit einem klassischen, regelbasierten Skript (If-Then-Else) fehlerfrei und günstig gelöst werden kann, sollte der Einsatz eines neuronalen Netzes überdacht werden.</p>

<hr>

<h3 class="c1-second mt-1">Use-Case-Evaluierung: Wo fangen wir an?</h3>
<p>Um die Nadel im Heuhaufen der möglichen KI-Projekte zu finden, bewerten wir Ideen systematisch nach zwei zentralen Achsen:</p>



<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>1. Business Value (Der Mehrwert)</h4>
        <p>Löst das Projekt ein echtes, schmerzhaftes Problem? Sparen wir dadurch signifikant Zeit oder Geld? Steigert es den Umsatz oder die Qualität? Wenn die Antwort "Es wäre halt ein cooles Gimmick" lautet, wird das Projekt gestrichen.</p>
    </div>
    <div class="ai-card">
        <h4>2. Feasibility (Die Machbarkeit)</h4>
        <p>Haben wir überhaupt die Daten, um dieses Modell zu trainieren? Ist die Datenqualität hoch genug? Dürfen wir diese Daten nutzen (Datenschutz, DSGVO)? Und haben wir das technische Know-how, um das System später in der Produktion am Leben zu halten?</p>
    </div>
</div>

<p class="mt-1"><strong>Das Ziel:</strong> Wir suchen für den Start nach den "Low Hanging Fruits". Use Cases mit hohem Business Value und hoher technischer Machbarkeit. Projekte mit hohem Wert, aber geringer Machbarkeit (z. B. vollautonome Fabriken) sind Zukunftsvisionen, keine Einstiegsprojekte.</p>

<hr>

<h3 class="c1-second mt-1">Hype vs. Realität: Der Realitätscheck</h3>
<p>Um die Machbarkeit realistisch einzuschätzen, helfen ein paar harte, aber ehrliche Faustregeln aus der angewandten Praxis:</p>

<div class="ai-card mt-1">
    <ul class="ai-list">
        <li><strong>Die 1-Sekunden-Regel:</strong> Alles, was ein Mensch mit einem kurzen Blick von unter einer Sekunde entscheiden kann (z. B. "Ist ein Kratzer auf diesem Bauteil?"), lässt sich heute sehr gut automatisieren (z.B: Computer Vision).</li>
        <li><strong>Keine Daten, keine Magie:</strong> Eine KI kann nicht aus dem Nichts Wissen erschaffen. Wenn ein Experte aus den vorliegenden Datenreihen kein Muster ableiten kann, wird es das neuronale Netz in der Regel auch nicht können.</li>
        <li><strong>Das Halluzinations-Risiko:</strong> Generative KI (wie LLMs) ist hervorragend für kreative Entwürfe oder Zusammenfassungen. Aber sie ist aufbaufährig, wenn du eine zu 100% faktisch korrekte Berechnung oder eine rechtlich bindende Auskunft ohne menschliche Kontrolle brauchst.</li>
    </ul>
</div>

<div class="ai-card--notice mt-1">
    <p><strong>Halluzinationen und wie man sie vermeidet</strong><br>Ein Large Language Modell ist hochqualifiziert Sprache zu erkennen und zu interpretieren. Die Mengen an Daten die genutzt werden um eine LLM zu trainieren ist unvorstellbar, selbst bei eher kleinen Modellen. Halluzinationen können aktuell noch nicht vollständig ausgeschlossen werden, auch wenn sie in den letzten Jahren stark zurückgegangen sind. Sie lassen sich bei faktischen Aussagen aber vermeiden. So ist die Verwendung eines RAG (Retrieval Augmented Generation), also die zu Verfügungstellung von Fakten aus einer Datenbank, ein Mittel um um Halluzinationen vorzubeugen. Es passiert dann nicht mehr, dass falsche Links, Zitate, Uhrzeiten oder Quellen genannt werden. <br> Oft ist auch die richtige Fragestellung (Prompt Engineering) entscheidend für die Qualität der Antworten und ob das Modell die eigenen Ausgaben in mehreren Schritten noch einmal überprüft (Chain of Thought oder Reasoning).</p>
</div>

<hr>

<h3 class="c1-second mt-1">Der Proof of Concept (PoC): Fail Fast, Learn Cheap</h3>
<p>Haben wir einen vielversprechenden Use Case gefunden, bauen wir nicht sofort ein millionenschweres, finales Software-Produkt. Wir starten mit einem <strong>Proof of Concept (PoC)</strong>, wie es bei der Softwareentwicklung üblich ist.</p>

<p>Ein PoC ist ein schneller, isolierter Prototyp, bei dem mit einfachen Mitteln ein Best-Case Szenarion abgebildet wird. Sein einziges Ziel ist es, eine Hypothese zu beweisen oder zu widerlegen. Zum Beispiel: <em>"Können wir mit unseren bestehenden Sensor-Daten Maschinenausfälle 24 Stunden vorhersehen?"</em></p>

<div class="ai-card--notice mt-1">
    <p><strong>Die wichtigste Regel für den PoC: KPIs definieren!</strong><br>
        Bevor die erste Zeile Code geschrieben wird, muss definiert werden, ab wann das Projekt als Erfolg gilt. Reicht eine Genauigkeit von 80% aus, um profitabel zu sein? Wenn der PoC diese Metrik nach ein paar Wochen nicht erreicht, wird das Projekt abgebrochen oder neu gedacht. So verhindert man Ressourcen-Gräber und lernt schnell und kostengünstig.</p>
</div>

<hr>
<h3 class="c1-second mt-1">Use-Case Beispiel: Fehlererkennung am Fließband</h3>
<h4 class="c2-second">Schlechtes Beispiel</h4>
<p>
<ul>
    <li><strong>Aufgabe:</strong> Zählen, wie viele Bauteile pro Stunde über das Band laufen und ob sie die richtige Länge haben. <br></li>
    <li><strong>Warum schlecht?</strong> Das kann eine einfache Lichtschranke für 50 Euro und ein primitives If-Then-Else-Skript erledigen.</li>
</ul>
</p>
<h4 class="c2-second">Gutes Beispiel</h4>
<p>
<ul>
    <li><strong>Aufgabe:</strong> Erkennen, ob die Metallbauteile winzige, unregelmäßige Kratzer auf der Oberfläche haben.</li>
    <li><strong>Warum klassische Software hier versagt?</strong> Kratzer sehen immer anders aus. Das Licht bricht mal so, mal so. Du kannst kein Skript schreiben, das alle möglichen Varianten abdeckt.</li>
    <li><strong>KI Einsatz:</strong> Ein Computer Vision Modell hat Tausende Bilder von korrekten Bauteilen gesehen und gelernt, wie der Normalzustand aussieht. Es schlägt sofort Alarm, wenn ein Bauteil visuell davon abweicht. Vorteil daran: es wird darauf trainiert, Fehler zu erkennen, die es noch nie zuvor gesehen hat und Fehler zu ignorieren, die irrelevant sind (false negatives).</li>
    <li><strong>Business Value:</strong> Massiv. Es reduziert den manuellen Kontrollaufwand, senkt die Reklamationsquote und verhindert, dass fehlerhafte Teile an den Kunden gehen. Außerdem ist es ein Sicherheitsfaktor, da nicht gewährleistet werden kann, dass der Fehler dem Kunde auffällt, bevor es zu spät ist. So ist es auch keine neue Zukunftsvision, dass KI-Getriebene Kamerassysteme an Gleisen kontrollieren ob die Räder der Züge noch intakt sind, und das in Echtzeit.</li>
    <li><strong>Feasibility:</strong> Sehr hoch. Kameras sind günstig, und in der Produktion lassen sich hervorragend Bilder für das Training sammeln.</li>
</ul>
</p>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>