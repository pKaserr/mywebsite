<!DOCTYPE html>
<html>

<head>
    <title>AI 01: Das Big Picture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/bg_net_graph.js" defer></script>
    <script src="./js/tooltip.js" defer></script>
    <script src="./js/accordion.js" defer></script>
    <link rel="stylesheet" href="./style.css">
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
                <h4 class="container__title--text">01. Einführung: Was zum Teufel ist eigentlich KI?</h4>
            </div>

            <div class="panel">
                <div class="panel-content">
                    <h3 class="c1-second">Der Hype: Warum jetzt?</h3>
                    <p>Künstliche Intelligenz ist keine neue Erfindung. Die Ideen gibt es seit den 1950ern. Im Jahr
                        2022 (mit dem Release von ChatGPT) hat sich jedoch etwas fundamental verändert. KI ist aus den
                        Forschungslaboren direkt in unseren Alltag geplatzt.</p>
                    <p>Der Begriff "KI" wird oft pauschal und unspezifisch verwendet. Lass uns aufräumen.</p>

                    <hr>

                    <h3 class="c1-second mt-1">Die zwei Gesichter der "KI"</h3>
                    <p>Wenn Gamer von "KI" sprechen, meinen sie oft etwas ganz anderes als Datenwissenschaftler.</p>

                    <div class="ai-grid-2 mt-1">

                        <div class="ai-card">
                            <h4 class="c2-second">A. Die "programmierte" Intelligenz (Symbolische KI)</h4>
                            <p><em>Beispiel: Der Gegner in einem Game oder ein Schachcomputer.</em></p>
                            <p>Hier hat ein Programmierer exakte Regeln geschrieben. Das System "denkt" nicht, es
                                arbeitet eine Checkliste ab.</p>
                            <div class="code-box">
                                <p> <span class="c-exec">WENN</span> <span
                                        class="c-keyword">Spieler_in_Sichtweite</span>:<br>
                                    &nbsp;&nbsp;DANN <span class="c-func">Reagiere</span>()<br>
                                    <span class="c-exec">SONST</span>:<br>
                                    <span class="c-exec">&nbsp;&nbsp;</span><span class="c-func">Patrouilliere</span>()
                                </p>
                            </div>
                            <p><strong>Vorteil:</strong>
                                Vorhersehbar.<br><strong>Nachteil:</strong> Kann nichts Neues lernen. Wenn etwas
                                passiert, das nicht im Code steht, stürzt es ab oder macht etwas unpassendes, was als
                                Fallback programmiert wurde (z.B: wenn du nicht weiß was du tun sollst, bleib stehen).
                            </p>
                        </div>

                        <div class="ai-card">
                            <h4 class="c2-second">B. Die "lernende" Intelligenz (Machine Learning)</h4>
                            <p><em>Beispiel: ChatGPT, Gesichtserkennung, Netflix-Empfehlungen.</em></p>
                            <p>Hier schreibt niemand Regeln. Wir geben dem System nur Daten (z.B. 10.000 Bilder von
                                Hunden) und sagen: "Finde selbst heraus, was Hunde ausmacht."</p>
                            <div class="bg-main2">
                                <!-- richtige Farben verwenden, orientieren an index.php            -->
                                <p><span class="c-keyword">Input:</span> 10.000 Bilder<br>
                                    <span class="c-keyword">Aufgabe:</span> Minimiere Fehler (reduziere beim Training
                                    die Abweichung
                                    zum originalen Bild)<br>
                                    <span class="c-keyword">Ergebnis:</span> System erkennt Muster (Ohren, Fell)
                            </div>
                            <p><strong>Vorteil:</strong> Kann komplexe Probleme lösen
                                (Sprache, Bilder).<br><strong>Nachteil:</strong> Wir wissen oft nicht genau,
                                <em>wie</em> es zur Lösung kommt (Blackbox), da sehr viele Rechnungen stattfinden, dass
                                es zu komplex wird.
                            </p>
                        </div>
                    </div>
                    <button class="accordion accordion--bg mt-1 p-1 mb-0">Kleine Funfact über Spiele-KI (Aufklappen)</button>
                    <div class="panel">
                        <p>Die meisten Computergegener in Computerspielen sind nicht deswegen so dämlich, weil
                            sie nicht besser programmiert werden können, sondern weil es ein Teil der User Experience
                            ist. Zu schwierige Gegner demotivieren. Außerdem gibt es dem Spieler unterbewusst ein Gefühl
                            der Überlegenheit. <br> So sind Computergegner nicht nur strunzdoof, sondern verhalten sich
                            bewusst unrealistisch. Es ist für Elitesoldaten und Bösewichte für gewöhnlich nicht normal,
                            dass sie ständig laut schreien, was sie nun exakt machen (flankiere von rechts), wo sie sich
                            befinden und ob sie gerade auf Fußspuren gestoßen sind, obwohl sie alleine sind: <br><a
                                href="https://www.youtube.com/watch?v=v0uLfJrSpvY" target="_blank"><em>Hä,
                                    Fußspuren?</em></a></p>
                    </div>
                    <hr>

                    <h3 class="c1-second mt-1">Begriffsdefinition</h3>
                    <p>Als erstes die Begrifflichkeiten, diese Begriffe sind ineinander verschachtelt. Wie eine
                        Matroschka-Puppe.</p>
                    <ul class="ai-list">
                        <li>
                            <strong>Künstliche Intelligenz (KI / AI):</strong>
                            Der große Überbegriff. Alles, was maschinell "schlau" wirkt. Egal ob fest programmiert
                            (Schach, Games) oder gelernt.
                        </li>
                        <li>
                            <strong>Machine Learning (Maschinelles Lernen - ML):</strong>
                            Der Teil der KI, der <em>lernt</em>. Algorithmen, die durch Erfahrung (Daten) besser
                            werden, ohne dass man jede Regel händisch ändert.
                        </li>
                        <li>
                            <strong>Deep Learning (Tiefes Lernen - DL):</strong>
                            Ein spezieller Teil von ML. Hier nutzen wir <strong>künstliche neuronale Netze</strong>
                            (inspiriert vom Gehirn), um riesige Datenmengen zu verarbeiten. Das ist die Technologie
                            hinter dem aktuellen Hype (LLMs, Bildgeneratoren).
                        </li>
                    </ul>

                    <img src="assets/png/ai_ml_dl.png" style="width: 30%;" alt="">

                    <h3 class="c1-second mt-1">Was ist ein "Sprachmodell" (LLM)?</h3>
                    <p>Wenn heute alle von KI reden, meinen sie meistens <strong>Large Language Models (LLMs)</strong>
                        wie <span class="has-tooltip"
                            data-tooltip='GPT wie ChatGPT steht für "generative pre-trained transformer" also soviel wie "Generativer vortrainierter Transformer". Was ein Transformer ist, erkläre ich im Modul 06: Transformer Revolution'>GPT</span>.
                    </p>
                    <div class="ai-card--notice">
                        <p>Ein LLM ist im Grunde ein sehr guter
                            <strong>"Nächstes-Wort-Vorhersager"</strong>. Es hat
                            gigantische Mengen Text gelesen und statistisch gelernt, welches Wort am wahrscheinlichsten
                            auf das vorherige folgt, im Bezug auf den Kontext.
                        </p>
                        <p>Es "weiß" nicht wirklich, was ein Tisch ist. Aber es hat in Milliarden Texten
                            gelernt, wie
                            das Wort "Tisch" im Kontext von "Stuhl", "Essen" und "Holz" verwendet wird.</p>
                    </div>
                    <div class="mt-1 ai-card">
                        <h4 class="c1-second">Unter der Haube: Ein Blick in die Zukunft</h4>
                        <p>Wie aus Wörtern reine Mathematik wird (Tokenisierung & Embeddings) und wieso die KI plötzlich
                            den Kontext eines ganzen Buches verstehen kann (Attention-Mechanismus), ist eine der
                            spannendsten technischen Entwicklungen der letzten Jahre.</p>
                        <p>Da dies aber ein tieferes Eintauchen erfordert, schauen wir uns diese exakte Mechanik
                            entspannt in <strong>Modul 06 (Transformer-Architektur)</strong> und <strong>Modul 07
                                (LLMs)</strong> an.</p>
                    </div>

                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <div></div> <a href="ai_02_neuron.php"><button class="btn btn--main">Weiter: Wie lernt die Maschine?
                        &rarr;</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>