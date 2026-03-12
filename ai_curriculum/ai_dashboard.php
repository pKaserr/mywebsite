<!DOCTYPE html>
<html>

<head>
    <title>AI Curriculum</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bg_net_graph.js" defer></script>
    <link rel="icon" type="image/png" href="../assets/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assets/favicons/favicon.svg" />
    <link rel="shortcut icon" href="../assets/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicons/apple-touch-icon.png" />
    <link rel="manifest" href="../assets/favicons/site.webmanifest" />
</head>

<body>
    <nav>
        <div class="nav">
            <a href="../index.php"><button class="btn btn--main btn--nav">Zurück zur Startseite</button></a>
        </div>
    </nav>
    <main>
        <div class="container_dashboard">
            <canvas class="particleCanvas"></canvas>
            <div class="container__title">
                <h2 class="container__title--text mb-1">AI Curriculum</h2>
                <p>Von der Logik zur künstlichen Intuition. Ein strukturierter Weg durch die Welt der KI.<br>
                    Hier folgen Schritt für Schritt verschiedene Module, die Ihnen helfen, die Grundlagen der KI zu <br>
                    erlernen. Außerdem sollen Tutorials folgen, die bei der Implementierung von KI-Modellen helfen. <br>
                    Die Website befindet sich noch im Aufbau.</p>
            </div>
            <h3>Basis Module</h3>
            <div class="boxWrapper mb-4">
                <div class="ai-grid-container">
                    <a href="./ai_01_big_picture.php" class="ai-module-card">

                        <span class="ai-module-number">01</span>
                        <span class="ai-module-title">Das Big Picture</span>
                        <span class="ai-module-desc">Ordnung im Begriffs-Dschungel. KI vs. ML vs. DL.</span>
                    </a>

                    <a href="./ai_02_neuron.php" class="ai-module-card">

                        <span class="ai-module-number">02</span>
                        <span class="ai-module-title">Das Atom des Netzes</span>
                        <span class="ai-module-desc">Vom Gehirn zur Matrix. Neuron, Perzeptron & Aktivierung.</span>
                    </a>

                    <a href="./ai_03_architecture.php" class="ai-module-card">

                        <span class="ai-module-number">03</span>
                        <span class="ai-module-title">Die Architektur</span>
                        <span class="ai-module-desc">Wie Schichten "denken". MLP & Feature-Hierarchien.</span>
                    </a>

                    <a href="./ai_04_learning.php" class="ai-module-card">

                        <span class="ai-module-number">04</span>
                        <span class="ai-module-title">Der Lernprozess</span>
                        <span class="ai-module-desc">Backpropagation, Loss Functions & Gradient Descent, Reinforcement Learning, Supervised Learning, Unsupervised Learning</span>
                    </a>

                    <a href="./ai_05_vision.php" class="ai-module-card">

                        <span class="ai-module-number">05</span>
                        <span class="ai-module-title">Computer Vision</span>
                        <span class="ai-module-desc">Wie Maschinen sehen und Bilder generieren. CNNs & Gesichtserkennung. Bildgenerierung mit Diffusion Models.</span>
                    </a>

                    <a href="./ai_06_transformer.php" class="ai-module-card">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>AI Curriculum
                        <span class="ai-module-number">06</span>
                        <span class="ai-module-title">Transformer Revolution</span>
                        <span class="ai-module-desc">Self-Attention & das Ende der Rekursion.</span>
                    </a>

                    <a href="./ai_07_llm.php" class="ai-module-card">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>
                        <span class="ai-module-number">07</span>
                        <span class="ai-module-title">LLMs & Reasoning</span>
                        <span class="ai-module-desc">Embeddings, Training & Chain-of-Thought.</span>
                    </a>

                    <a href="./ai_08_ecosystem.php" class="ai-module-card">

                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">08</span>
                        <span class="ai-module-title">Das Ökosystem</span>
                        <span class="ai-module-desc">RAG & Agentische Workflows.</span>
                    </a>

                    <a href="./ai_09_xai" class="ai-module-card">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">09</span>
                        <span class="ai-module-title">Vertrauen & XAI</span>
                        <span class="ai-module-desc">Explainable AI & Saliency Maps.</span>
                    </a>

                    <a href="./ai_10_nerf" class="ai-module-card">
                        <span class="wip-banner">In Arbeit ...</span>

                        <span class="ai-module-number">10</span>
                        <span class="ai-module-title">NeRF & 3D Vision</span>
                        <span class="ai-module-desc">NeRF & 3D Vision.</span>
                    </a>

                    <a href="./aI_11_anomaly.php" class="ai-module-card ai-module-card--disabled">
                        <span class="wip-banner">In Planung ...</span>

                        <span class="ai-module-number">11</span>
                        <span class="ai-module-title">Anomaly Detection</span>
                        <span class="ai-module-desc">Anomaly Detection.</span>
                    </a>

                    <a href="./ai_12_practice" class="ai-module-card ai-module-card--disabled">
                        <span class="wip-banner">In Planung ...</span>

                        <span class="ai-module-number">12</span>
                        <span class="ai-module-title">KI in der Praxis</span>
                        <span class="ai-module-desc">KI in der Praxis.</span>
                    </a>
                </div>
            </div>

            <h3>Praktische Einführung</h3>
            <div class="boxWrapper mb-2">
                <div class="ai-grid-container">
                    <a href="./ai_13_simple_nn" class="ai-module-card">
                        <span class="wip-banner">In Arbeit ...</span>
                        <span class="ai-module-number">13</span>
                        <span class="ai-module-title">Beispie: Simples Neuronales Netz</span>
                        <span class="ai-module-desc">Simples Neuronales Netz.</span>
                    </a>

                    <a href="./ai_14_complex_nn" class="ai-module-card ai-module-card--disabled">
                        <span class="wip-banner">In Planung ...</span>
                        <span class="ai-module-number">14</span>
                        <span class="ai-module-title">Beispiel: Komplexeres Neuronales Netz</span>
                        <span class="ai-module-desc">Komplexeres Neuronales Netz.</span>
                    </a>

                    <a href="./ai_15_cloud_nn" class="ai-module-card ai-module-card--disabled">
                        <span class="wip-banner">In Planung ...</span>
                        <span class="ai-module-number">15</span>
                        <span class="ai-module-title">Beispiel: Cloud</span>
                        <span class="ai-module-desc">Cloud.</span>
                    </a>
                </div>
            </div>
    </main>
    <?php include dirname(__DIR__) . '/includes/footer.php'; ?>
</body>

</html>