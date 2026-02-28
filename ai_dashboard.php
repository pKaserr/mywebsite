<!DOCTYPE html>
<html>

<head>
    <title>AI Curriculum</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="./js/bg_net_graph.js" defer></script>
    <link rel="icon" type="image/png" href="./assets/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/favicons/favicon.svg" />
    <link rel="shortcut icon" href="./assets/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicons/apple-touch-icon.png" />
    <link rel="manifest" href="./assets/favicons/site.webmanifest" />
</head>

<body>
    <nav>
        <div class="nav">
            <a href="index"><button class="btn btn--main btn--nav">Zurück zur Startseite</button></a>
        </div>
    </nav>
    <main>
        <div class="container_dashboard">
            <canvas class="particleCanvas"></canvas>
            <div class="container__title">
                <h4 class="container__title--text">AI Curriculum</h4>
                <span>Von der Logik zur künstlichen Intuition. Ein strukturierter Weg durch die Welt der KI.</span><br>
                <span> Hier folgen Schritt für Schritt verschiedene Module, die Ihnen helfen, die Grundlagen der KI zu
                    erlernen.</span>
                <span> Außerdem sollen Tutorials folgen, die bei der Implementierung von KI-Modellen helfen.</span>
            </div>

            <div class="boxWrapper mb-2">
                <div class="ai-grid-container">
                    <a href="ai_01_big_picture.php" class="ai-module-card">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">01</span>
                        <span class="ai-module-title">Das Big Picture</span>
                        <span class="ai-module-desc">Ordnung im Begriffs-Dschungel. KI vs. ML vs. DL.</span>
                    </a>

                    <a href="ai_02_neuron.php" class="ai-module-card">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">02</span>
                        <span class="ai-module-title">Das Atom des Netzes</span>
                        <span class="ai-module-desc">Vom Gehirn zur Matrix. Neuron, Perzeptron & Aktivierung.</span>
                    </a>

                    <a href="ai_03_architecture.php" class="ai-module-card">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">03</span>
                        <span class="ai-module-title">Die Architektur</span>
                        <span class="ai-module-desc">Wie Schichten "denken". MLP & Feature-Hierarchien.</span>
                    </a>

                    <a href="ai_04_learning.php" class="ai-module-card">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">04</span>
                        <span class="ai-module-title">Der Lernprozess</span>
                        <span class="ai-module-desc">Backpropagation, Loss Functions & Gradient Descent.</span>
                    </a>

                    <a href="ai_05_vision.php" class="ai-module-card">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">05</span>
                        <span class="ai-module-title">Computer Vision</span>
                        <span class="ai-module-desc">Wie Maschinen sehen. CNNs & Gesichtserkennung.</span>
                    </a>

                    <a href="ai_06_transformer.php" class="ai-module-card">
                        <span class="wip-banner">In Arbeit ...</span>
                        <span class="ai-module-number">06</span>
                        <span class="ai-module-title">Transformer Revolution</span>
                        <span class="ai-module-desc">Self-Attention & das Ende der Rekursion.</span>
                    </a>

                    <a href="ai_07_llm.php" class="ai-module-card">
                        <span class="wip-banner">In Arbeit ...</span>
                        <span class="ai-module-number">07</span>
                        <span class="ai-module-title">LLMs & Reasoning</span>
                        <span class="ai-module-desc">Embeddings, Training & Chain-of-Thought.</span>
                    </a>

                    <a href="ai_08_ecosystem.php" class="ai-module-card">

                        <span class="wip-banner">In Arbeit ...</span>

                        <span class="ai-module-number">08</span>
                        <span class="ai-module-title">Das Ökosystem</span>
                        <span class="ai-module-desc">RAG & Agentische Workflows.</span>
                    </a>

                    <a href="ai_09_xai" class="ai-module-card">
                        <span class="wip-banner">In Arbeit ...</span>

                        <span class="ai-module-number">09</span>
                        <span class="ai-module-title">Vertrauen & XAI</span>
                        <span class="ai-module-desc">Explainable AI & Saliency Maps.</span>
                    </a>
                </div>
            </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>