<?php
require './includes/auth.php';
require './includes/db_connect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>AI 07: LLMs & Reasoning</title>
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
                <h4 class="container__title--text">07. Large Language Models (LLMs) & Reasoning</h4>
                <span>Wie Text zu Mathematik wird und wie Modelle "denken" lernen.</span>
            </div>
            
            <div class="panel">
                <div class="panel-content">
                    <h3>Tokenization & Embeddings</h3>
                    <p>Computer verstehen keine Wörter. Sie verstehen Zahlen.</p>
                    <ul class="ai-list">
                        <li><strong>Tokenization:</strong> Zerlegt Text in kleine Stücke ("Haus" -> `3492`).</li>
                        <li><strong>Embeddings:</strong> Ordnet jedem Token einen Platz in einem riesigen Vektorraum zu.</li>
                    </ul>
                    
                     <div class="ai-placeholder" style="border: 2px dashed #555; padding: 2rem; text-align: center; color: #777; margin: 1rem 0;">
                        [Placeholder: Vektorraum-Clustering (3D-Wolke)]
                    </div>

                    <h3>Training & Fine-tuning</h3>
                    <div class="ai-grid">
                        <div class="ai-card">
                            <h4>Pre-training</h4>
                            <p>Das Modell liest das halbe Internet und lernt nur eins: Das nächste Wort vorherzusagen.</p>
                        </div>
                        <div class="ai-card">
                            <h4>Fine-tuning (RLHF)</h4>
                            <p>Menschen bewerten die Antworten. Das Modell lernt, hilfreich und harmlos zu sein.</p>
                        </div>
                    </div>

                    <h3>Reasoning</h3>
                    <p>Chain-of-Thought: Modelle lösen komplexe logische Probleme besser, wenn man sie zwingt, "laut zu denken" (Zwischenschritte generieren).</p>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <a href="ai_06_transformer.php"><button class="btn btn--main">&larr; Vorheriges Modul</button></a>
                <a href="ai_08_ecosystem.php"><button class="btn btn--main">Nächstes Modul: Das Ökosystem &rarr;</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
