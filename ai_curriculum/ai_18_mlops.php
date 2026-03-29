<?php
// variables:
$title = "";
$page_headline = "";
$prev_link = 'ai_17_datastrat.php';
$prev_text = 'KI-Strategie & Use-Case-Evaluierung';
$next_link = 'ai_19_ethik.php';
$next_text = 'KI-Ethik & Verantwortung';

ob_start();
?>

<h3 class="c1-second mt-1">Die Architekturentscheidung: Build vs. Buy</h3>
<p>Bevor ein System entwickelt wird, steht eine fundamentale Make-or-Buy-Entscheidung an. Muss das Unternehmen ein eigenes Modell von Grund auf trainieren, oder reicht es, ein bestehendes System anzubinden? In der Praxis gibt es hier ein klares Spektrum:</p>

<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>1. Buy (SaaS & APIs)</h4>
        <p>Nutzung fertiger Cloud-Dienste (z. B. OpenAI für Text, fertige Azure-Services für Dokumentenanalyse).<br>
            <strong>Vorteil:</strong> Extrem schnelle Integration (Time-to-Market), keine eigenen Server- oder Trainingskosten.<br>
            <strong>Nachteil:</strong> Starke Abhängigkeit vom Anbieter (Vendor Lock-in), laufende API-Kosten und oft kritisch bei strengem Datenschutz, da Daten das Haus verlassen.
        </p>
    </div>
    <div class="ai-card">
        <h4>2. Build / Adapt (Open Source & Fine-Tuning)</h4>
        <p>Lokales Hosting von Open-Source-Modellen (via Hugging Face) oder das Trainieren eigener Architekturen.<br>
            <strong>Vorteil:</strong> Volle Datenkontrolle (On-Premise möglich), keine laufenden API-Kosten und maximale Anpassbarkeit an spezifische Fachdomänen.<br>
            <strong>Nachteil:</strong> Hohe initiale Entwicklungskosten und eigener Aufwand für Server-Infrastruktur, Wartung und Backups.
        </p>
    </div>
</div>
<p class="mt-1">Strategisch gilt oft: Für allgemeine Aufgaben (Standard-Übersetzungen, simple Bildklassifizierung) wird "gekauft". Sobald die Aufgabe zur Kernkompetenz des Unternehmens gehört oder sensible Daten beinhaltet, wird selbst gehostet und adaptiert.</p>

<hr>

<h3 class="c1-second mt-1">Integration: Ein Notebook ist kein Produkt</h3>
<p>Ein funktionierendes Modell auf dem Laptop eines Data Scientists ist noch kein nutzbares System. Der eigentliche Machine-Learning-Code macht in der Regel nur einen Bruchteil des gesamten Softwareprojekts aus.</p>
<p>Das Modell muss in die bestehende IT-Landschaft integriert werden. Es benötigt sichere REST-APIs, ein Load Balancing für tausende gleichzeitige Anfragen, Fallback-Systeme (Was passiert, wenn die KI nicht antwortet?) und eine Nutzeroberfläche. KI-Entwicklung ist am Ende immer klassische Softwareentwicklung (Software Engineering).</p>

<hr>

<h3 class="c1-second mt-1">MLOps und der Modell-Lebenszyklus</h3>
<p>Klassische Software wird mit der Zeit fehlerhaft, wenn sich Betriebssysteme ändern. KI-Modelle hingegen "altern", weil sich die Realität ändert. Dieses Phänomen nennt man Data Drift oder Concept Drift.</p>

<div class="ai-card mt-1">
    <ul class="ai-list">
        <li><strong class="c2-second">Beispiel Data Drift:</strong> Ein Computer-Vision-Modell zur Qualitätskontrolle wurde im Winter trainiert. Im Sommer fällt grelles Sonnenlicht durch die Fabrikfenster. Die Eingabedaten sehen plötzlich anders aus, und die Fehlerquote des Modells steigt rasant an.</li>
        <li><strong class="c2-second">Beispiel Concept Drift:</strong> Ein Betrugserkennungsmodell für Kreditkarten verliert seine Genauigkeit, weil Kriminelle nach ein paar Monaten neue, bisher unbekannte Betrugsmethoden entwickelt haben. Die Definition von "Betrug" hat sich verschoben.</li>
    </ul>
</div>

<p class="mt-1">Das Deployment (die Inbetriebnahme) eines Modells ist daher nicht das Ende des Projekts, sondern Tag 1. Hier greift <strong>MLOps (Machine Learning Operations)</strong>. Es beschreibt die technische Infrastruktur und die Prozesse, um Modelle kontinuierlich zu überwachen und orientiert sich vom Prinzp her stark an <span class="has-tooltip" data-tooltip="DevOps ist eine Reihe von Praktiken, die darauf abzielen, die Zusammenarbeit zwischen Softwareentwicklung (Dev) und IT-Betrieb (Ops) zu verbessern, um Software schneller und zuverlässiger bereitzustellen.">DevOps</span>.</p>

<div class="ai-card mt-1">
    <ol class="ai-list">
        <li><strong class="c2-second">Monitoring:</strong> Erkennen, wenn die Vorhersagegenauigkeit (Accuracy) im laufenden Betrieb absinkt.</li>
        <li><strong class="c2-second">Data Pipeline:</strong> Kontinuierliches, automatisiertes Sammeln von neuen, aktuellen Daten aus der Produktion.</li>
        <li><strong class="c2-second">Retraining:</strong> Das automatisierte Anstoßen eines neuen Trainingslaufs, sobald das Modell einen bestimmten Qualitätsschwellenwert unterschreitet, um es an die neue Realität anzupassen.</li>
    </ol>
</div>

<div class="ai-card--notice mt-1">
    <p><strong>Fazit:</strong> KI ist kein "Fire and Forget"-System. Wer ein Budget für ein KI-Projekt freigibt, muss zwingend auch dauerhafte Ressourcen für MLOps und das Lifecycle-Management einplanen, da das Modell sonst über Monate hinweg unbemerkt wirtschaftlichen Schaden anrichten kann.</p>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>