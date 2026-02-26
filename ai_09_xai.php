<?php
require './includes/auth.php';
require './includes/db_connect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>AI 09: Vertrauen & Transparenz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./style_additions.css">
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
            <div class="container__title">
                <h4 class="container__title--text">09. Vertrauen & Transparenz: XAI</h4>
                <span>Warum hat die KI so entschieden? Ein Blick in die Blackbox.</span>
            </div>
            
            <div class="panel">
                <div class="panel-content">
                    <h3>Das Blackbox-Problem</h3>
                    <p>Neuronale Netze sind oft undurchsichtige Mathe-Monster. Wir sehen den Input und den Output, aber der Weg dazwischen ist schwer nachzuvollziehen.</p>

                    <h3>Explainable AI (XAI)</h3>
                    <p>Methoden, um KI erklärbar zu machen.</p>
                    <div class="ai-card">
                        <h4>Saliency Maps</h4>
                        <p>Bei der Bilderkennung: Eine Heatmap, die zeigt, auf welche Pixel das Netz geschaut hat, um die Entscheidung zu treffen.</p>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <a href="ai_08_ecosystem.php"><button class="btn btn--main">&larr; Vorheriges Modul</button></a>
                <a href="ai_dashboard.php"><button class="btn btn--main">Zurück zur Übersicht</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
