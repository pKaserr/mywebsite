<?php
require './includes/auth.php';
require './includes/db_connect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>AI 08: Das Ökosystem</title>
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
                <h4 class="container__title--text">08. Das Ökosystem: RAG und Agenten</h4>
                <span>Wie wir die Schwächen von LLMs beheben.</span>
            </div>
            
            <div class="panel">
                <div class="panel-content">
                    <h3>Retrieval Augmented Generation (RAG)</h3>
                    <p>LLMs halluzinieren und ihr Wissen ist veraltet. RAG gibt ihnen ein Buch in die Hand.</p>
                    <div class="ai-placeholder" style="border: 2px dashed #555; padding: 2rem; text-align: center; color: #777; margin: 1rem 0;">
                        [Placeholder: RAG-Ablaufplan (Flussdiagramm)]
                    </div>
                    <ul class="ai-list">
                        <li>Suche relevante Infos in einer Vektordatenbank.</li>
                        <li>Füge diese Infos der Anfrage (Prompt) hinzu.</li>
                        <li>Das LLM antwortet basierend auf den Fakten.</li>
                    </ul>

                    <h3>Agentische Workflows</h3>
                    <p>Der nächste Schritt: Die KI denkt nicht nur, sie handelt.</p>
                    <div class="ai-card">
                        <p>Wenn ein Modell Zugriff auf Tools hat (Python, Google Suche, API), kann es Aufgaben selbstständig planen und ausführen.</p>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <a href="ai_07_llm.php"><button class="btn btn--main">&larr; Vorheriges Modul</button></a>
                <a href="ai_09_xai.php"><button class="btn btn--main">Nächstes Modul: Vertrauen & XAI &rarr;</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
