<?php
require './includes/auth.php';
require './includes/db_connect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>AI 05: Computer Vision</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./style_additions.css">
    <link rel="icon" type="image/png" href="./assets/favicons/favicon-96x96.png" sizes="96x96" />
</head>

<body>
    <nav>
        <div class="nav">
             <a href="ai_dashboard.php"><button class="btn btn--main btn--nav">Zurück zur Übersicht</button></a>
            <a href="logout"><button class="btn btn--main btn--nav">Abmelden</button></a>
        </div>
    </nav>
    <main>
        <div class="container_dashboard">
            <div class="container__title">
                <h4 class="container__title--text">05. Computer Vision</h4>
                <span>Wie Maschinen sehen. Ein tieferer Einblick in CNNs.</span>
            </div>
            
            <div class="panel">
                <div class="panel-content">
                    <h3>Convolutional Neural Networks (CNNs)</h3>
                    <p>Spezielle Netze für Bilddaten. Statt jedes Pixel einzeln zu betrachten, schieben sie kleine "Filter" (Kernel) über das Bild, um Muster zu finden.</p>
                    
                    <div class="ai-placeholder" style="border: 2px dashed #555; padding: 2rem; text-align: center; color: #777; margin: 1rem 0;">
                        [Placeholder: CNN-Filter-Visualisierung]
                    </div>

                    <h3>Gesichtserkennung</h3>
                    <p>Der Weg von Pixeln zu Vektoren (Embeddings). Das Netz lernt, ein Gesicht in einen Zahlenstrahl (Vektorraum) zu verwandeln. Ähnliche Gesichter liegen in diesem Raum nah beieinander.</p>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <a href="ai_04_learning.php"><button class="btn btn--main">&larr; Vorheriges Modul</button></a>
                <a href="ai_06_transformer.php"><button class="btn btn--main">Nächstes Modul: Transformer &rarr;</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
