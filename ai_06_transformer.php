<?php
require './includes/auth.php';
require './includes/db_connect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>AI 06: Transformer Revolution</title>
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
                <h4 class="container__title--text">06. Die Transformer-Revolution</h4>
                <span>Das Fundament der LLMs. Weg von sequenziellem Denken hin zur Parallelisierung.</span>
            </div>
            
            <div class="panel">
                <div class="panel-content">
                    <h3>Das Problem mit alten Modellen (RNNs)</h3>
                    <p>Frühere Sprachmodelle lasen Text Wort für Wort. Das war langsam und sie vergaßen den Anfang langer Sätze.</p>

                    <h3>Self-Attention</h3>
                    <p>Der Durchbruch. Das Netz betrachtet alle Wörter eines Satzes gleichzeitig und lernt, welche Wörter in Beziehung zueinander stehen.</p>
                    <blockquote class="bg-black p-2 c-white" style="border-radius: 5px; margin: 1rem 0; font-size: 1rem;">
                        "The animal didn't cross the street because <strong>it</strong> was too tired."
                    </blockquote>
                    <p>Das Netz versteht, dass sich "it" auf "animal" bezieht, nicht auf "street".</p>

                    <h3>Die Transformer-Architektur</h3>
                    <p>Besteht aus Encodern (Verstehen) und Decodern (Generieren). Moderne GPT-Modelle sind meist reine Decoder-Modelle.</p>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <a href="ai_05_vision.php"><button class="btn btn--main">&larr; Vorheriges Modul</button></a>
                <a href="ai_07_llm.php"><button class="btn btn--main">Nächstes Modul: LLMs & Reasoning &rarr;</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
