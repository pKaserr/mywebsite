<!DOCTYPE html>
<html>

<head>
    <title>AI 05: Computer Vision</title>
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
                <h4>05. Computer Vision: Wie Maschinen sehen</h4>
                <span class="c-grey">Von blinden Zahlenreihen zum visuellen Verständnis.</span>
            </div>

            <div class="panel">
                <div class="panel-content">

                    <h3 class="c1-second mt-1">Einführung: Warum Kameras "blind" sind</h3>
                    <p>Wenn du aus dem Fenster schaust und einen Baum siehst, verarbeitet dein biologisches Gehirn
                        blitzschnell Formen, Farben, Tiefe und Kontext. Du <em>verstehst</em>, dass es ein Baum ist.</p>
                    <p>Eine Kamera hingegen versteht gar nichts. Sie hat keine Augen und kein biologisches Gehirn. Ein
                        Kamera-Sensor misst lediglich, wie viel Licht an einer bestimmten Stelle auftrifft. Für einen
                        Computer ist ein Bild keine Landschaft, sondern eine gigantische Excel-Tabelle voller Zahlen.
                    </p>

                    <div class="ai-card mt-1">
                        <h4 class="c2-second">Das RGB-Raster: Die Sprache der Bilder</h4>
                        <p>Jedes Bild auf einem Bildschirm besteht aus winzigen Leuchtpunkten, den
                            <strong>Pixeln</strong>. Jeder Pixel misst die Helligkeit der drei Grundfarben:
                            <strong>R</strong>ot, <strong>G</strong>rün und <strong>B</strong>lau (RGB).
                        </p>
                        <p>Die Helligkeit wird in Zahlen von 0 (aus/schwarz) bis 255 (volle Leuchtkraft) gemessen. Wenn
                            der Computer also einen gelben Tennisball "ansieht", sieht er keine Kugel. Er sieht an
                            dieser Stelle nur die Werte: Rot 255, Grün 255, Blau 0.</p>
                    </div>

                    <div class="ai-img-wrapper mt-1">
                        <img style="max-width: 100%;" src="./assets/png/pixel_rgb.png" alt="">
                    </div>

                    <div class="ai-grid-2 mt-1">
                        <div class="ai-card">
                            <h4>Wofür benötigen wir Computer Vision?</h4>
                            <ul class="ai-list mt-1">
                                <li><strong>Industrie & Robotik:</strong> <em>Anomaly Detection</em> am Fließband –
                                    defekte Bauteile oder Kratzer werden in Millisekunden anhand der Pixelwerte erkannt.
                                </li>
                                <li><strong>Medizin:</strong> KI analysiert Röntgenbilder, um winzige
                                    Gewebeveränderungen präziser zu finden als das menschliche Auge.</li>
                                <li><strong>Autonomes Fahren:</strong> Die lebensrettende Unterscheidung: Sind die
                                    Zahlen vor dem Auto ein Schatten oder ein Fußgänger?</li>
                            </ul>
                        </div>
                        <div class="ai-card">
                            <h4>Warum reicht klassisches Programmieren nicht?</h4>
                            <p>Früher versuchte man dem Computer Regeln zu geben: <em>"Wenn in der Mitte viel rote Pixel
                                    sind, ist es ein Stoppschild."</em> Aber was, wenn das Schild im Schatten liegt?
                                Oder halb von Schnee verdeckt ist? Die Zahlen ändern sich komplett, die harten Regeln
                                versagen. Die KI hingegen <em>lernt</em> das Muster eines Stoppschilds aus Beispielen,
                                unabhängig vom perfekten Licht.</p>
                        </div>
                    </div>

                    <hr>

                    <h3 class="c1-second mt-1">Phase 1: Das Problem mit unseren bisherigen Netzen</h3>
                    <p>In Modul 02 und 03 haben wir gelernt, wie ein Netz rechnet: (X<sub>1</sub> * W<sub>1</sub>) +
                        (X<sub>2</sub> * W<sub>2</sub>) + ... <br>
                        Das Netz erwartet seine Eingaben als eine einfache, lange Reihe (eine <strong>Liste</strong>).
                        X<sub>1</sub> war Bewölkung, X<sub>2</sub> war der Wochentag.</p>

                    <p>Nehmen wir nun ein winziges Bild von nur 10x10 Pixeln. Das sind insgesamt 100 Pixel. Um diese an
                        unser bisheriges Netz zu übergeben, müssen wir das Raster zerschneiden und alle 100 Pixel in
                        eine extrem lange Schlange stellen (X<sub>1</sub> bis X<sub>100</sub>).</p>

                    <div class="ai-card--notice mt-1">
                        <p><strong>Der fatale Fehler:</strong> Wenn wir ein Bild in eine lange Schlange zerreißen,
                            zerstören wir die Nachbarschaft! Das Pixel der Nasenspitze liegt plötzlich extrem weit weg
                            vom Pixel des Auges. Das Netz verliert das räumliche Verständnis. Ein Auge ist aber nur ein
                            Auge, weil die Pixel <em>nebeneinander</em> in einem Quadrat angeordnet sind. Ein normales
                            Netz versteht "Oben", "Unten", "Links" und "Rechts" nicht.</p>
                    </div>

                    <h3 class="c1-second mt-1">Phase 2: Die Schablone (Filter & Feature Map)</h3>
                    <p>Um Bilder zu verstehen, erfinden wir eine neue Architektur: Das <strong>Convolutional Neural
                            Network (CNN)</strong>. Ein CNN lässt das 2D-Raster intakt. Statt jedes Pixel einzeln und
                        isoliert zu betrachten, nutzt das Netz eine Art "mathematische Schablone", die das Bild
                        systematisch abtastet. Diese Schablone nennen wir <strong>Filter (oder Kernel)</strong>.</p>


                    <p class="mt-1">Aber was genau passiert hier beim Abtasten? Lass uns das Konzept in drei logische
                        Schritte zerlegen und an das anknüpfen, was wir in Modul 02 gelernt haben:</p>

                    <div>
                        <h4 class="c2-second">1. Woraus besteht der Filter? (Die Gewichte)</h4>
                        <p>Erinnerst du dich an die Gewichte (W) aus Modul 02? Beim Regenschirm-Beispiel hatten wir
                            Zahlen wie 0.8 oder -0.5, die bestimmt haben, wie wichtig eine Information ist, z.B. ob es
                            dunke Wolken gibt oder es Dienstag ist.</p>
                        <p>Ein Filter in der Bilderkennung ist im Grunde nichts anderes als <strong>ein winziges
                                3x3-Raster voller Gewichte</strong>. Diese 9 Zahlenwerte in dem Raster sind
                            <em>keine</em> Pixel! Es sind mathematische Parameter (z.B. 1.2, -0.8, 0.5), die das Netz
                            beim Training selbstständig anpasst und lernt.
                        </p>

                        <hr class="mt-1 mb-1">

                        <h4 class="c2-second">2. Was macht der Filter? (Die Faltung)</h4>
                        Stell dir diesen 3x3-Filter nun wie eine kleine, durchsichtige Folie vor, auf der diese 9
                        Gewichte stehen. Das Originalbild darunter ist ein riesiges Raster aus Pixelwerten. Also ein
                        Bild.</p>
                        <p>Wir legen nun unsere winzige 3x3-Folie exakt auf die oberste linke Ecke des Bildes. Jetzt
                            verdecken die 9 Gewichte der Folie exakt 9 Pixel des Bildes. Nun rechnet das Netz Paar für
                            Paar:</p>
                        <ul class="ai-list mt-1">
                            <li>(Pixelwert oben links) <strong>*</strong> (Filter-Gewicht oben links)</li>
                            <li>(Pixelwert Mitte) <strong>*</strong> (Filter-Gewicht Mitte)</li>
                            <li>... das passiert für alle 9 Felder, die exakt übereinanderliegen.</li>
                        </ul>
                        <div class="ai-img-wrapper mb-2">
                            <img src="assets/png/filtering1.png" style="max-width: 50%;"
                                alt="Visualisierung der Faltung eines Filters über ein Bild">
                        </div>
                        <p class="mt-1">Am Ende werden diese 9 Ergebnisse zu einer einzigen Summe addiert. Das Netz
                            berechnet so mathematisch, wie stark dieser kleine 3x3-Bildausschnitt zu dem Muster passt,
                            das in den Gewichten des Filters gespeichert ist.</p>

                        <hr class="mt-1 mb-1">

                        <h4 class="c2-second">3. Was ist das Ergebnis? (Die Feature Map)</h4>
                        <p>Die ausgerechnete Summe (ein einzelner Zahlenwert) wird nun in ein komplett neues, anfangs
                            leeres Raster geschrieben. Danach schieben wir unsere Filter-Folie einen Pixel weiter nach
                            rechts und die Rechnung beginnt von vorn. </p>
                        <div class="ai-img-wrapper mb-2">
                            <img src="assets/png/filtering_cnn.png" style="max-width: 90%;"
                                alt="Visualisierung der Faltung eines Filters über ein Bild">
                        </div>
                        <p>Wenn die Folie das gesamte Bild abgetastet hat, ist das neue Raster gefüllt. Dieses neue
                            Raster nennen wir die <strong>Feature Map (Aktivierungsmatrix)</strong>. Sie ist eine
                            gefilterte Version des Originalbildes. Ein sehr hoher Zahlenwert in dieser Map bedeutet:
                            <em>"Aha! Genau an dieser Stelle im Bild habe ich das Muster gefunden, nach dem mein Filter
                                gesucht hat!"</em>
                        </p>
                    </div>
                    <hr>

                    <h3 class="c1-second mt-1">Phase 3: Was wird erkannt? (Hierarchische Merkmalsextraktion)</h3>
                    <p>Ein CNN nutzt nicht nur einen einzigen Filter, sondern hunderte gleichzeitig. Was genau diese
                        Filter suchen, hängt davon ab, wie tief wir uns im Netz befinden. Das Netz lernt Merkmale in
                        einer strikten Hierarchie:</p>


                    <div class="ai-card">
                        <h4>Frühe Schichten (Early Layers)</h4>
                        <p>Hier schauen die Filter direkt auf die originalen Bildpixel. Sie lernen, als einfache
                            Kantendetektoren (horizontal, vertikal, diagonal) zu fungieren oder simple Farbverläufe zu
                            erkennen. Diese Filter ähneln oft stark den klassischen <em>Gabor-Filtern</em> aus der
                            traditionellen Bildverarbeitung.</p>
                    </div>

                    <div class="ai-card mt-1">
                        <h4>Mittlere Schichten (Middle Layers)</h4>
                        <p>Jetzt wird es spannend: Diese Schichten schauen <em>nicht</em> mehr auf die rohen Bildpixel!
                            Sie gleiten stattdessen über die <strong>Feature Maps der vorherigen Schicht</strong>. Sie
                            kombinieren die Basis-Kanten zu komplexeren Mustern, Texturen und geometrischen Grundformen
                            (z. B. Kreise, Gitter, Ecken).</p>
                    </div>

                    <div class="ai-card mt-1">
                        <h4>Tiefe Schichten (Deep Layers)</h4>
                        <p>Ganz hinten im Netz werden die gefundenen Muster zu hochkomplexen, semantischen
                            Repräsentationen zusammengefügt. Das Netz erkennt jetzt Objekte oder Objektteile (z. B. ein
                            Rad, ein Auge, ein Gesicht oder Schriftzüge). Aus blinden RGB-Pixeln hat das Netz
                            schrittweise ein abstraktes visuelles Verständnis aufgebaut.</p>
                    </div>

                    <h3 class="c1-second mt-1">Phase 4: Der Ausblick in die dritte Dimension</h3>
                    <p>Klassische CNNs haben die Welt der 2D-Pixelraster revolutioniert. Doch die reale Welt ist nicht
                        flach.</p>

                    <div class="ai-card--notice mt-1">
                        <p><strong>Die nächste Grenze der KI:</strong> Moderne Computer Vision verlässt zunehmend den
                            2D-Raum. Mit Methoden wie dem <strong>volumetrischen Rendering</strong> und <strong>Neural
                                Radiance Fields (NeRFs)</strong> lernt die KI, aus mehreren flachen Bildern komplette,
                            synthetische 3D-Welten zu rekonstruieren. Das System lernt nicht nur, wie ein Objekt
                            aussieht, sondern wie Licht durch einen physischen Raum fällt. KI und klassische Sensorik
                            verschmelzen.</p>
                    </div>

                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <a href="ai_04_learning.php"><button class="btn btn--main">&larr; Zurück</button></a>
                <a href="ai_06_transformer.php"><button class="btn btn--main">Weiter: Transformer &rarr;</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>