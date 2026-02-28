<!DOCTYPE html>
<html>

<head>
    <title>AI 09: Vertrauen & Transparenz</title>
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
                <h4 class="container__title--text">09. Vertrauen & Transparenz: XAI</h4>
                <span>Warum hat die KI so entschieden? Ein Blick in die Blackbox.</span>
            </div>
            
            <div class="panel">
                <div class="panel-content">
                    <h3 class="c1-second mt-1">Einführung: Das Blackbox-Problem</h3>
                    <p>Stellen Sie sich vor, Sie gehen zum Arzt und er sagt: "Sie müssen sofort operiert werden." Sie fragen: "Warum?" Und der Arzt antwortet: "Das weiß ich nicht, mein Bauchgefühl sagt das." Würden Sie der OP zustimmen? Wahrscheinlich nicht.</p>
                    
                    <p>Genau an diesem Punkt stehen wir heute oft mit Künstlicher Intelligenz. Moderne Neuronale Netze sind unglaublich gut, aber sie sind eine <strong>Blackbox</strong>. Wir geben Daten auf der einen Seite hinein (Symptome) und bekommen ein Ergebnis auf der anderen Seite heraus ("Krankheit X"). Aber aufgrund der Milliarden von Parametern (Gewichten) dazwischen, versteht selbst der Programmierer der KI oft nicht genau, <em>wie</em> sie zu diesem Schluss gekommen ist.</p>

                    <div class="ai-card--notice mt-1">
                        <p>Das ist ein riesiges Problem für Bereiche wie Medizin, Justiz (Wer wird auf Bewährung entlassen?) oder Finanzen (Wer bekommt einen Kredit?). Wenn eine KI über Menschenleben oder Existenzen entscheidet, haben wir ein ethisches und rechtliches Recht auf eine Erklärung ("Right to Explanation").</p>
                    </div>
                    
                    <hr>

                    <h3 class="c1-second mt-1">Die Lösung: Explainable AI (XAI)</h3>
                    <p>Hier kommt das Forschungsfeld der <strong>Explainable AI (Erklärbare KI)</strong>, kurz XAI, ins Spiel. Das Ziel von XAI ist es, Werkzeuge zu entwickeln, die den schwarzen Kasten transparent machen. Wir wollen nicht nur richtige Antworten, wir wollen stichhaltige, menschlich nachvollziehbare Begründungen.</p>

                    <hr>

                    <h3 class="c1-second mt-1">Methode 1: Saliency Maps (Worauf schaut die KI?)</h3>
                    <p>Eine der bekanntesten XAI-Methoden bei der Bilderkennung sind sogenannte <strong>Saliency Maps</strong> (Aufmerksamkeitskarten).</p>
                    
                    <div class="ai-grid-2 mt-1">
                        <div class="ai-card">
                            <h4>Das Problem</h4>
                            <p>Eine KI bekommt das Röntgenbild einer Lunge und sagt: "Krebs." Wir wissen aber nicht, ob die KI wirklich den Tumor gesehen hat, oder ob sie wegen eines Wasserflecks auf der Linse des Röntgengeräts aus Versehen fälschlicherweise Alarm schlägt.</p>
                        </div>
                        <div class="ai-card">
                            <h4>Die XAI-Lösung</h4>
                            <p>Die Saliency Map berechnet im Nachhinein rückwärts, welche Pixel für die finale Entscheidung wie wichtig waren, und legt eine farbige Heatmap (Wärmebild) über das Originalbild. Sie färbt genau die Pixel rot ein, die für die Entscheidung "Krebs" am wichtigsten waren. Damit kann ein Arzt sehen, auf was die KI geschaut hat und entscheiden ob die Entscheidung richtig oder falsch liegt.</p>
                        </div>
                    </div>

                    <hr>

                    <h3 class="c1-second mt-1">Methode 2: Feature Attribution im Text</h3>
                    <p>Auch bei Texten oder Tabellendaten will man wissen, welcher Faktor den Ausschlag gab. Wenn eine KI einem Bewerber den Job verweigert, können Algorithmen aufschlüsseln: "Die Ablehnung erfolgte zu 40% wegen mangelnder Berufserfahrung, zu 30% wegen der falschen Programmiersprache und zu 30% wegen eines fehlenden Abschlusses."</p>

                    <p>Diese Transparenz erlaubt es Unternehmen, ihre KIs auf unfaire Vorurteile (Bias), wie etwa Rassismus oder Sexismus, zu prüfen und systematisch zu korrigieren.</p>

                    <hr>

                    <h3 class="c1-second mt-1">Fazit: Vertrauen ist die Währung der Zukunft</h3>
                    <p>Eine KI, die immer recht hat, aber niemandem erklären kann warum, wird in kritischen Systemen niemals akzeptiert werden. Explainable AI ist der Schlüssel, um Maschinen nicht nur als magische Orakel, sondern als überprüfbare, vertrauenswürdige Werkzeuge in unsicheren Zeiten einzusetzen.</p>

                </div>
            </div>

            <div class="mt-1" style="display: flex; justify-content: space-between;">
                <a href="ai_08_ecosystem.php"><button class="btn btn--main">&larr; Zurück</button></a>
                <a href="ai_dashboard.php"><button class="btn btn--main">Zurück zur Übersicht</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
