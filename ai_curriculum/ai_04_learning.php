<?php
// variables:
$title = "AI 04: Der Lernprozess";
$page_headline = "03. Die Architektur: Wie Schichten 'denken'";
$prev_link = 'ai_03_architecture';
$prev_text = 'Zurück: Die Architektur';
$next_link = 'ai_05_vision';
$next_text = 'Weiter: Computer Vision';

ob_start();
?>
<p>Machinelles Lernen beruht auf drei Säulen: Supervised Learning, Unsupervised Learning und
    Reinforcement Learning, welche ich im folgenden Kapitel vorstellen werde.
    Hier geht es direkt zu anderen Säulen:</p>
<ul class="ai-list">
    <li><a href="ai_04_learning.php#rl">Reinforcement Learning</a></li>
    <li><a href="ai_04_learning.php#ul">Unsupervised Learning</a></li>
</ul>


<!-- Supervised Learning -->


<h2 class="c1-second mt-1" id="sl">Supervised Learning</h2>
<p>Beim Supervised Learning, lernt die KI anhand von Beispielen, die mit der
    richtigen Lösung versehen sind. Die KI wird also an die Hand genommen. Je nachdem wie die KI
    eine Entscheidung trifft, wird es mit einem richtigen Beispiel verglichen (Ground Truth) und die
    KI entsprechend angepasst.</p>
<h3 class="c1-second mt-1">Phase 1: Das Netz rät wild drauflos</h3>
<p>Bevor eine KI schlau ist, ist sie extrem dumm. Wenn wir ein neuronales Netz zum
    allerersten Mal starten, werden alle Gewichte (W) und der Bias (b) mit zufälligen
    Zahlen gefüllt.</p>
<p>Geben wir unserem Regenschirm-Netz nun die Info "Es ist bewölkt
    (X<sub>1</sub>=1)", rechnet das Netz mit seinen zufälligen Gewichten vielleicht aus:
    <em>"Wahrscheinlichkeit für Regen: 10% (0.1)"</em>. Du gehst ohne Schirm raus – und wirst
    klatschnass. Das Netz lag komplett falsch.
</p>

<hr>

<h3 class="c1-second mt-1">Phase 2: Wie falsch lagen wir? (Die Loss Function)</h3>
<p>Um zu lernen, müssen wir den Fehler erst einmal mathematisch messen. Das macht
    die <strong>Loss Function (Verlustfunktion)</strong>.</p>

<div class="ai-card mt-1">
    <ul class="ai-list">
        <li><strong>Die Vorhersage (Prediction):</strong> 0.1 (Nein, kein Schirm)</li>
        <li><strong>Die Realität (Ground Truth):</strong> 1.0 (Es hat geregnet, du bist nass!)</li>
        <li><strong>Der Fehler (Loss):</strong> Die Differenz zwischen Realität und Vorhersage. Das
            Netz berechnet: <em>"Verdammt, ich war extrem weit weg von der Wahrheit."</em></li>
    </ul>
</div>
<p class="mt-1">Das absolute Ziel jedes Machine
    Learning Modells ist simpel: Reduziere den Loss so stark wie möglich (am besten 0).
</p>

<hr>

<h3 class="c1-second mt-1">Phase 3: Der Weg ins Tal (Gradient Descent)</h3>
<p>Stell dir den Fehler (Loss) als ein riesiges Gebirge vor. Ganz oben auf dem Berg
    ist der Fehler gigantisch. Unten im Tal ist der Fehler null (perfekte Vorhersage). Das Netz
    steht nun blind im Nebel auf diesem Berg und will ins Tal (das bedeutet, dasss das Netz lernen möchte. Also die Gewichte einer Entscheidung anpassen). Spingst es zu weit (die Learning
    Rate ist zu hoch), landest du hinter dem niedgrigsten Tal. Spingst es zu kurz, bleibst du davor
    stecken.</p>
<div class="ai-img-wrapper mt-1">
    <img src="../assets/png/gradient_descent.png" style="max-width: 90%; " alt="Gradient Descent">
</div>

<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>Der Gradient (Die Steigung)</h4>
        <p>Das Netz tastet mit dem Fuß
            den Boden ab und fragt die Mathematik (die Ableitung): <em>"In welche Richtung geht es
                hier am steilsten bergab?"</em></p>
    </div>
    <div class="ai-card">
        <h4>Learning Rate (Die Schrittweite)</h4>
        <p>Ein Parameter, der angibt,
            wie groß der Schritt ist, den das Netz in diese Richtung macht (wie stark die Gewichte
            angepasst werden). Zu groß: Wir springen
            über das Tal hinweg (überspringen den optimalen Wert). Zu klein: Wir brauchen ewig, um
            anzukommen.</p>
    </div>
</div>

<hr>

<h3 class="c1-second mt-1">Phase 4: Die Schuldzuweisung (Backpropagation)</h3>
<p>Jetzt kommt der wichtigste Algorithmus der gesamten KI-Geschichte. Wir wissen,
    dass wir falsch lagen. Aber wir haben Tausende Gewichte im Netz. Welches Gewicht war schuld an
    der falschen Entscheidung?</p>
<p>Hier kommt die sogenannte <strong>Kettenregel (Chain Rule)</strong> aus der
    Kurvendiskussion zum Einsatz, die wir hier aber "Schuldzuweisung" nennen:</p>

<div class="ai-card mt-1">
    <p>Rückwärts durch das Netz (Backward Pass)</p>
    <ol class="ai-list mt-1">
        <li>Der <strong>Loss (Fehler)</strong> schreit das
            Output-Neuron an: <br><em>"Warum hast du nur 0.1 ausgegeben? Es hat geregnet!"</em></li>
        <li class="mt-1">Das <strong>Output-Neuron</strong> blickt auf die
            eingehenden Gewichte und sagt: <br><em>"Gewicht W<sub>1</sub> (Bewölkung) hat mir
                gesagt, Bewölkung sei unwichtig! Und Gewicht W<sub>2</sub> (Dienstag) meinte,
                Dienstag wäre ein Garant für Sonne!"</em></li>
        <li class="mt-1"><strong>Die Korrektur (Update):</strong> Der Optimizer (der
            Mechaniker des Netzes) schnappt sich die Gewichte und passt sie minimal an:<br>
            <span class="c-string">W<sub>1</sub></span> (Bewölkung) wird
            <strong>erhöht</strong>.<br>
            <span class="c-string">W<sub>2</sub></span> (Dienstag) wird <strong>verringert</strong>.
        </li>
    </ol>
</div>

<div class="ai-card--notice mt-1">
    <p><strong>Das ist der gesamte Zauber:</strong> Forward Pass
        (Vorhersagen) &rarr; Loss berechnen (Fehler messen) &rarr; Backpropagation (Schuld
        verteilen) &rarr; Gradient Descent (Gewichte minimal anpassen). <br><br>Diesen Zyklus
        wiederholt das Netz bei Millionen von Durchläufen (Epochen), bis die Vorhersagen extrem nah an
        der Realität (Ground Truth) liegen. <strong>Das Netz hat gelernt.</strong></p>
</div>
<hr id="rl">


<!-- Reinforcement Learning -->


<h2 class="c1-second mt-3">Reinforcement Learning</h2>
<h3 class="c1-second mt-1">Lernen ohne Musterlösung (Reinforcement
    Learning)</h3>
<p>Die bisherigen Phasen beschreiben das sogenannte <strong>Supervised
        Learning</strong> (Überwachtes Lernen). Wir hatten immer eine klare "Ground Truth" (wir
    wussten exakt, ob es geregnet hat oder nicht). Aber was passiert bei komplexeren Aufgaben, für
    die es keine eindeutige mathematische Musterlösung gibt? Etwa beim Schachspielen oder beim
    Führen eines guten Gesprächs?</p>
<p>Hier greift das <strong>Reinforcement Learning (Bestärkendes
        Lernen)</strong>, eine weitere Hauptsäule des Machine Learning. Das Prinzip ähnelt der
    Hundeerziehung: Das Netz probiert Aktionen aus und bekommt dafür entweder ein Leckerli oder
    einen Tadel. <br> Anstatt den Fehler
    durch eine Loss-Function zu berechnen, bekommt die KI Punkte. +1 für einen guten Zug, -1
    für einen Fehler. Das Ziel des Netzes: <em>"Maximiere die Gesamtbelohnung!"</em>
</p>


<hr>
<h3 class="c1-second mt-1">Der LLM-Turbo: RLHF (Reinforcement Learning from
    Human Feedback)</h3>
<p>Moderne KIs wie ChatGPT kombinieren das tiefe Wissen von neuronalen Netzen
    (Deep Learning) mit dieser Belohnungs-Taktik. Warum? Weil Sprache subjektiv ist. Ein Text kann
    grammatikalisch perfekt (Loss = 0), aber trotzdem unfreundlich oder nutzlos sein.</p>

<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>Schritt 1: Der Mensch bewertet</h4>
        <p>Das Modell generiert drei verschiedene Antworten auf eine
            Frage. Ein echter Mensch liest sie und sortiert sie nach Qualität (Platz 1, 2 und 3).
            Das Modell lernt: <em>"Aha, die Menschen bevorzugen höfliche und präzise
                Antworten."</em></p>
    </div>
    <div class="ai-card">
        <h4>Schritt 2: Die KI belohnt sich selbst</h4>
        <p>Aus den menschlichen Bewertungen wird ein separates
            <strong>Reward Model</strong> trainiert. Dieses agiert fortan als automatischer Lehrer.
            Es simuliert den menschlichen Geschmack und verteilt die Punkte, während das Hauptnetz
            Millionen von Texten übt.
        </p>
    </div>
</div>

<div class="ai-card--notice mt-1">
    <p><strong>Zusammenfassung des Lernens:</strong> Ein Modell lernt Regeln
        stur auswendig durch <strong>Supervised Learning</strong> (Loss minimieren). Den wirklichen
        Feinschliff, um sich wie ein hilfreicher Assistent zu verhalten, bekommt es aber erst durch
        das Feedback und die Belohnungen des <strong>RLHF</strong>.</p>
</div>
<hr id="ul">


<!-- Unsupervised Learning -->


<h2 class="c1-second mt-3">Unsupervised Learning</h2>
<h3 class="c1-second mt-1">Finde die versteckten Muster (Unsupervised
    Learning)</h3>
<p>Bisher hatten wir immer einen Lehrer: Ob es nun der <strong>Ground Truth</strong> oder der
    <strong>Reward</strong> war, der dem Netz genau gesagt hat, was richtig und was falsch ist. Aber
    was, wenn wir die Antworten selbst nicht kennen?
</p>
<p>Hier betritt das <strong>Unsupervised Learning (Unüberwachtes
        Lernen)</strong> die Bühne. Stell dir vor, du kippst dem neuronalen Netz Millionen von
    rohen, unbeschrifteten Sensordaten oder Bildern vor die Füße. Es gibt keine Labels, keine
    Kategorien, keine Vorgaben. Die Aufgabe der KI lautet schlicht: <em>"Finde Struktur in diesem
        Chaos."</em></p>

<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>Clustering (Gruppenbildung)</h4>
        <p>Das Netz sortiert Datenpunkte, die sich mathematisch ähnlich
            sind, in Haufen (Cluster). Ohne zu wissen, was "Hunde" oder "Katzen" sind, erkennt das
            Netz auf Tausenden Fotos, dass es zwei grundlegend verschiedene Arten von Tieren gibt,
            und trennt sie sauber voneinander.</p>
    </div>
    <div class="ai-card">
        <h4>Anomaly Detection (Ausreißer finden)</h4>
        <p>Die KI lernt den "Normalzustand" eines Datensatzes auswendig.
            Taucht nun ein Bild oder ein Sensorwert auf, der völlig aus dem Raster fällt, schlägt
            sie Alarm. Das ist in der Industrie extrem wertvoll, etwa um Kratzer auf Bauteilen oder
            fehlerhafte Sensoren zu erkennen, ohne vorher jeden denkbaren Fehler gesehen zu haben.
        </p>
    </div>
</div>

<div class="ai-img-wrapper mt-1 display-flex flex-column text-align-left">
    <img src="../assets/png/clustering.png" style="max-width: 90%; " alt="Clustering">
    <figure>Beispiel eines Clusters. Hier werden gleiche Farbe, Anzahl und Formen zusammengelegt.
        Beim Unsupervised Learning werden solche Cluster gefunden. Diese können viele Dimensionen
        haben. Ein Hund hat somit nicht nur den eigenen Cluster "Hund" sondern auch Rasse, Tier,
        Alter, Größe, Farbe und sehr viele mehr. Jede Katze gehört somit ebenfalls zum Cluster Tier.</figure>
</div>

<div class="ai-card--notice mt-1">
    <p><strong>Der Loss beim Unsupervised Learning:</strong> Da es keine
        Ground Truth gibt, misst die Loss Function hier keinen direkten "Vorhersagefehler".
        Stattdessen belohnt sie das Netz dafür, wenn Datenpunkte innerhalb eines Clusters möglichst
        nah beieinanderliegen und die verschiedenen Cluster möglichst weit voneinander entfernt
        sind.</p>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>