<?php
// variables:
$title = "Neural Radiance Fields (NeRF)";
$page_headline = "10. Neural Radiance Fields (NeRF)";
$prev_link = 'ai_09_xai.php';
$prev_text = 'Zurück: Vertrauen & Transparenz';
// $next_link = 'ai_11_anomaly.php';
// $next_text = 'Weiter: Anomaly Detection';
$next_link = 'ai_dashboard';
$next_text = 'Zurück zur Übersicht';
ob_start();
?>
<h3 class="c1-second mt-1">Einleitung: Die Illusion von KI-Videos vs.
    echte 3D-Räume</h3>
<p>Wenn wir heute atemberaubende, KI-generierte Videos sehen, wirken
    diese extrem räumlich. Doch das ist eine Illusion. Diese Videos sind letztlich nur sehr viele
    flache 2D-Bilder, die schnell hintereinander abgespielt werden. Man kann das Video nicht
    pausieren und virtuell um das generierte Objekt herumgehen. Es ist und bleibt eine flache
    Leinwand.</p>
<p>Wollen wir jedoch KIs für Robotik, autonomes Fahren oder Virtual
    Reality nutzen, brauchen wir <strong>echtes 3D</strong>. Das klassische Problem dabei: Wie
    speichert man einen 3D-Raum? Bisher nutzte man riesige Listen von Polygonen (Dreiecken) oder
    winzigen 3D-Pixeln (Voxeln). Das frisst enorm viel Speicherplatz und Rechenleistung. Hier kommt
    ein genialer neuer Ansatz ins Spiel: <strong>NeRF (Neural Radiance Fields)</strong>. Anstatt den
    Raum als riesige Liste von Punkten abzuspeichern, nutzt NeRF ein künstliches neuronales Netz.
    Das Netz <em>merkt</em> sich den Raum in seinen Gewichten. Es ist klein, aber enthält die gesamte visuelle Information einer 3D-Szene.</p>

<div class="text-align-center">
    <video class="ml-2 mb-2" style="width: 75%;" controls>
        <source src="./../assets/videos/zip_nerf_2023.mp4">
        Your browser does not support the video tag.
    </video>
</div>
<p>Bei diesem Video handelt es sich nicht um einen Film, der gedeht wurde mit einer Kamera. Es handelt sich um ein Neuronales Netz, dass die Informationen des Ausschnitts (RGB) im Bezug auf die Perspektive berechnet. <br> <cite> (ZIP-NeRF: Jonathan T. Barron and Ben Mildenhall and Dor Verbin and Pratul P. Srinivasan and Peter Hedman, 2023, https://jonbarron.info/zipnerf/)</cite></p>

<hr>

<h3 class="c1-second mt-1">Das Prinzip: Die Wohnung im neuronalen Netz
</h3>
<p>Stell dir vor, du gehst durch deine Wohnung und machst 50 Fotos aus
    verschiedenen Winkeln. Du gibst der KI diese 2D-Fotos und sagst ihr bei jedem Bild genau, wo du
    standest und in welche Richtung die Kamera zeigte. Die Aufgabe des neuronalen Netzes ist es nun,
    die 3D-Umgebung daraus zu rekonstruieren.</p>
<p>Das Netz lernt dabei für jeden erdenklichen Punkt im Raum (X, Y, Z
    Koordinaten) und für jeden Betrachtungswinkel exakt zwei Dinge:</p>
<div class="ai-card mt-1">
    <ul class="ai-list">
        <li><strong>Farbe (RGB):</strong> Welche Farbe hat
            dieser Punkt im Raum, wenn ich aus einer bestimmten Richtung darauf schaue? (Wichtig für
            Spiegelungen!).</li>
        <li><strong>Dichte (Density):</strong> Befindet sich an
            diesem Punkt massive Materie (wie eine Tischkante) oder einfach nur leere Luft?</li>
    </ul>
</div>
<p class="mt-1">Stelle dir das wie einen virtuellen Laserstrahl vor. Du hast eine feste Ausgangsposition im 3D-Raum,
    definiert durch die Koordinaten x, y und z (wo stehst du?). Von dieser Position aus hast du eine genaue Blickrichtung,
    definiert durch die Winkel θ (Theta) und φ (Phi) (wohin schaust du?). Aus diesen beiden Informationen entsteht ein
    mathematischer Lichtstrahl (Ray), der präzise in die Szene hineingeschossen wird. Wie das aussieht, zeigt die folgende Abbildung:</p>

<div class="ai-img-wrapper--multiple mt-1">
    <figure style="margin: 0;">
        <img src="../assets/png/nerf_loc.png" style="max-width: 100%;" alt="Ausgangsposition im 3D-Raum">
        <figcaption>Beispiel einer lokalen Position im 3D-Raum mit <nobr>x, y und z...</nobr>
        </figcaption>
    </figure>
    <figure style="margin: 0;">
        <img src="../assets/png/nerf_pose.png" style="max-width: 100%;" alt="Blickrichtung">
        <figcaption>...und einer Blickrichtung mit den Winkeln θ und φ...</figcaption>
    </figure>
    <figure style="margin: 0;">
        <img src="../assets/png/nerf_ray.png" style="max-width: 100%;" alt="Lichtstrahl">
        <figcaption>...was zusammen einen Lichtstrahl (Ray) definiert.</figcaption>
    </figure>
</div>

<p class="mt-1">Entlang dieses Lichtstrahls messen wir nun in regelmäßigen Abständen (der sogenannten Abtastrate oder <em>Sampling Rate</em>),
    was sich an den jeweiligen Punkten befindet. Wir fragen das System: Welche Farbe (RGB) herrscht hier und befindet sich an dieser Stelle feste Materie (Density)?
    Genau diese Informationen – Position, Richtung, Farbe und Dichte – sind es, die das neuronale Netz lernt und speichert.</p>

<hr>

<h3 class="c1-second mt-1">Das mathematische Hindernis</h3>
<p>Erinnern wir uns an Kapitel 04 (Learning). Damit ein Netz lernen kann, tiefste Stelle finden?) und Backpropagation. Diese Algorithmen benötigen zwingend die mathematische Ableitung. Die Mathematik muss fließend und
    stufenlos(differenzierbar) sein.</p>
<p>Wenn wir unsere Welt aus harten, festen 3D-Pixeln bauen würden,
    hätten wir ein Problem: Ein Pixel ist entweder "da" oder "nicht da". Das erzeugt mathematische
    Klippen, an denen die Ableitung scheitert. Die KI wüsste nicht, in welche Richtung sie ihre Gewichte anpassen soll. Wir brauchen einen weicheren Ansatz. Die Lösung dafür kommt aus der
    Medizin und Computergrafik.</p>

<button class="accordion accordion--bg mt-1 p-1 mb-0">Exkurs: Volumetrisches Rendering in der Medizin (Aufklappen)</button>
<div class="panel">
    <p>In der Medizin wird volumetrisches Rendering schon lange genutzt, um ins Innere des menschlichen Körpers zu blicken, zum Beispiel in das Gehirn. Das Gewebe besteht aus Masse unterschiedlicher Dichte. Wenn ein CT-Scanner einen Röntgenstrahl durch den Kopf schießt, nimmt die Intensität des Strahls an den Stellen ab, wo er auf Masse trifft.</p>
    <p class="mt-1"><strong>Das Problem:</strong> Der Scanner misst nur das Endresultat auf der anderen Seite. Er weiß nicht, an welcher genauen Stelle im Kopf der Strahl wie stark blockiert wurde. Wir kennen lediglich die Start-Intensität und messen die Rest-Intensität am Ende.</p>

    <p class="mt-1">Stellen wir uns das Gehirn zur Vereinfachung als ein Raster aus Zahlen vor (wie ein 3D-Gitter). An jeder Stelle, an der sich viel Masse befindet, ist der Zahlenwert höher. Wenn wir nun einen Strahl durch deinen Schädel schießen, und dieser Strahl hat am Anfang einen Wert von 10 und am Ende einen Wert von 5, wissen wir: Er hat auf seinem Weg Masse im Wert von 5 durchdrungen.</p>
    <p class="mt-1">Indem wir diese Strahlen nun aus ganz vielen verschiedenen Winkeln durch das Raster schießen und die Verluste kreuz und quer miteinander verrechnen, können wir mathematisch genau auflösen, welches Kästchen welchen Wert haben muss.</p>

    <p class="mt-1">Anbei ein kurzer Ausschnitt aus einer meiner Vorlesungen, in dem diese Methode veranschaulicht wird:</p>

    <div class="text-align-center">
        <video class="ml-2 mb-2 mt-1" style="clear:right; width: 75%;" controls>
            <source src="./../assets/videos/Vorlesung_nerf_cut.mp4">
            Dein Browser unterstützt das Video-Tag nicht.
        </video>
    </div>
    <p>Durch dieses clevere Verrechnen erhalten wir schichtweise eine exakte 3D-Darstellung der Dichte, und machen das Innere des Gehirns sichtbar.</p>
</div>


<hr>

<h3 class="c1-second mt-1">Die Lösung: Volumetrisches Rendering</h3>
<p>Beim <strong>volumetrischen Rendering</strong> behandeln wir die Welt
    nicht als leeren Raum mit harten Objekten, sondern eher wie ein Aquarium voller Nebel, der mal
    extrem dicht (ein Tisch) und mal extrem dünn (die Luft) ist. Ähnliche Verfahren kennen wir aus
    dem CT oder MRT im Krankenhaus.</p>

<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>Strahlen schießen (Ray Casting)</h4>
        <p>Um zu berechnen, was eine Kamera sieht, schießen wir
            für jeden einzelnen Pixel des Zielbildes einen mathematischen "Sichtstrahl" in die Szene
            hinein.</p>
    </div>
    <div class="ai-card">
        <h4>Farbe aufsammeln</h4>
        <p>Während der Strahl durch den Raum wandert, fragt er
            das neuronale Netz an vielen kleinen Punkten entlang seines Weges: <em>"Wie dicht ist es
                hier und welche Farbe strahlt es ab?"</em></p>
    </div>
</div>
<p class="mt-1">Der Strahl sammelt die Farbwerte auf seiner Reise ein.
    Trifft er auf eine hohe Dichte (z. B. eine Wand), wird der Strahl "blockiert" und die Farbe
    dahinter zählt nicht mehr. Am Ende wird alles zu einem einzigen finalen Farbwert für unseren
    2D-Pixel zusammengerechnet. Weil dieser ganze Vorgang völlig fließend ist, kann die Mathematik
    den Fehler exakt berechnen und das Netz trainieren.</p>


<hr>

<h3 class="c1-second mt-1">Wofür nutzen wir NeRFs?</h3>
<p>NeRFs revolutionieren aktuell unzählige Bereiche, weil wir plötzlich
    echte räumliche Intelligenz aus simplen 2D-Bildern gewinnen:</p>
<div class="ai-card mt-1">
    <ul class="ai-list">
        <li><strong>Fotorealistisches VR & AR:</strong>
            Komplette Umgebungen lassen sich digital begehen, inklusive echter Spiegelungen auf
            Fenstern.</li>
        <li><strong>Synthetische Sensordaten (LiDAR):</strong>
            Wenn das Netz die exakte Dichte eines Raumes verstanden hat, können wir nicht nur
            Kameras, sondern auch Laser-Scanner (LiDAR) simulieren. Wir schießen virtuelle Laser in
            das NeRF und messen, wo sie abprallen. So können wir Millionen Trainingsdaten für
            selbstfahrende Autos in Simulationen generieren, ohne dass ein echtes Auto auf die
            Straße muss.</li>
        <li><strong>E-Commerce & Film:</strong> Produkte oder
            Filmsets können mit dem Smartphone abgefilmt und nachträglich aus jedem beliebigen
            Winkel perfekt gerendert werden.</li>
    </ul>
</div>

<div class="text-align-center">
    <video class="ml-2 mb-2 mt-1" style="clear:right; width: 75%;" controls>
        <source src="./../assets/videos/nerf_cloud_point.mp4">
        Dein Browser unterstützt das Video-Tag nicht.
    </video>
</div>
<p>Das Video zeigt ein selbsterstelltes NeRF, das zu eine Punktwolke wird. Dies war Teil meiner Masterthesis. Die Punktwolke wurde innerhalb des NeRFs erstellt, nicht davor.
</p>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>