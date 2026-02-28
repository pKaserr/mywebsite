<!DOCTYPE html>
<html>

<head>
    <title>AI 04: Der Lernprozess</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="./js/bg_net_graph.js" defer></script>
    <link rel="icon" type="image/png" href="./assets/favicons/favicon-96x96.png" sizes="96x96" />
</head>

<body>
    <nav>
        <div class="nav">
            <a href="index"><button class="btn btn--main btn--nav">Zurück zur Startseite</button></a>
            <a href="ai_dashboard.php"><button class="btn btn--main btn--nav">Zur Übersicht</button></a>
        </div>
    </nav>
    <main>
        <div class="container_dashboard">
            <canvas class="particleCanvas"></canvas>

            <div class="container__title">
                <h4>04. Der Lernprozess: Aus Fehlern wird man klug</h4>
                <span class="c-grey">Loss Function, Gradient Descent und Backpropagation</span>
            </div>

            <div class="panel">
                <div class="panel-content">

                    <h3 class="c1-second mt-1">Phase 1: Das Netz rät wild drauflos</h3>
                    <p>Bevor eine KI schlau ist, ist sie extrem dumm. Wenn wir ein neuronales Netz zum
                        allerersten Mal starten, werden alle Gewichte (W) und der Bias (b) mit völlig <strong>zufälligen
                            Zahlen</strong> gefüllt.</p>
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
                        Learning Modells ist simpel: <strong>Mache den Loss so klein wie möglich (am besten 0).</strong>
                    </p>

                    <hr>

                    <h3 class="c1-second mt-1">Phase 3: Der Weg ins Tal (Gradient Descent)</h3>
                    <p>Stell dir den Fehler (Loss) als ein riesiges Gebirge vor. Ganz oben auf dem Berg
                        ist der Fehler gigantisch. Unten im Tal ist der Fehler null (perfekte Vorhersage). Das Netz
                        steht nun blind im Nebel auf diesem Berg und will ins Tal. Spingst du zu weit (die Learning
                        Rate ist zu hoch), landest du hinter dem niedgrigsten Tal. Spingst du zu wenig, steckst du davor
                        fest.</p>
                    <div class="ai-img-wrapper mt-1">
                        <img src="assets/png/gradient_descent.png" style="max-width: 90%; " alt="Gradient Descent">
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
                                wie groß der Schritt ist, den das Netz in diese Richtung macht. Zu groß: Wir springen
                                über das Tal hinweg. Zu klein: Wir brauchen ewig, um anzukommen.</p>
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
                            wiederholt das Netz bei Millionen von Bildern (Epochen), bis die Vorhersagen extrem nah an
                            der Realität (Ground Truth) liegen. <strong>Das Netz hat gelernt.</strong></p>
                    </div>

                </div>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <a href="ai_03_architecture.php"><button class="btn btn--main">&larr; Zurück</button></a>
                <a href="ai_05_vision.php"><button class="btn btn--main">Weiter: Computer Vision &rarr;</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>