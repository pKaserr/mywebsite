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
            
            <div class="ai-search">
                <input type="text" id="ai-module-search" class="ai-search__input" placeholder="Module nach Stichwörtern durchsuchen (z.B. CNN, LLM, Neuron)...">
            </div>

            <h3>Basis Module</h3>
            <div class="boxWrapper mb-4">
                <div class="ai-grid-container">
                    <a href="./ai_01_big_picture.php" class="ai-module-card" data-tags="grundlagen, big picture, ki, ai, künstliche intelligenz, machine learning, deep learning">

                        <span class="ai-module-number">01</span>
                        <span class="ai-module-title">Das Big Picture</span>
                        <span class="ai-module-desc">Ordnung im Begriffs-Dschungel. KI vs. ML vs. DL.</span>
                    </a>

                    <a href="./ai_02_neuron.php" class="ai-module-card" data-tags="neuron, perzeptron, aktivierungsfunktion, matrix, gehirn, grundlagen">

                        <span class="ai-module-number">02</span>
                        <span class="ai-module-title">Das Atom des Netzes</span>
                        <span class="ai-module-desc">Vom Gehirn zur Matrix. Neuron, Perzeptron & Aktivierung.</span>
                    </a>

                    <a href="./ai_03_architecture.php" class="ai-module-card" data-tags="architektur, layers, schichten, mlp, multi layer perceptron, feature, hierarchien">

                        <span class="ai-module-number">03</span>
                        <span class="ai-module-title">Die Architektur</span>
                        <span class="ai-module-desc">Wie Schichten "denken". MLP & Feature-Hierarchien.</span>
                    </a>

                    <a href="./ai_04_learning.php" class="ai-module-card" data-tags="lernen, learning, backpropagation, loss function, gradient descent, reinforcement learning, supervised learning, unsupervised learning">

                        <span class="ai-module-number">04</span>
                        <span class="ai-module-title">Der Lernprozess</span>
                        <span class="ai-module-desc">Backpropagation, Loss Functions & Gradient Descent, Reinforcement Learning, Supervised Learning, Unsupervised Learning</span>
                    </a>

                    <a href="./ai_05_vision.php" class="ai-module-card" data-tags="computer vision, bilderkennung, generierung, bildgenerierung, cnn, convolutional, gesichtserkennung, diffusion models">

                        <span class="ai-module-number">05</span>
                        <span class="ai-module-title">Computer Vision</span>
                        <span class="ai-module-desc">Wie Maschinen sehen und Bilder generieren. CNNs & Gesichtserkennung. Bildgenerierung mit Diffusion Models.</span>
                    </a>

                    <a href="./ai_06_transformer.php" class="ai-module-card" data-tags="transformer, self-attention, attention, rekursion, nlp">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>
                        <span class="ai-module-number">06</span>
                        <span class="ai-module-title">Transformer Revolution</span>
                        <span class="ai-module-desc">Self-Attention & das Ende der Rekursion.</span>
                    </a>

                    <a href="./ai_07_llm.php" class="ai-module-card" data-tags="llm, large language models, reasoning, embeddings, training, chain-of-thought, nlp, textgenerierung">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>
                        <span class="ai-module-number">07</span>
                        <span class="ai-module-title">LLMs & Reasoning</span>
                        <span class="ai-module-desc">Embeddings, Training & Chain-of-Thought.</span>
                    </a>

                    <a href="./ai_08_ecosystem.php" class="ai-module-card" data-tags="ökosystem, ecosystem, rag, retrieval augmented generation, agenten, agentische workflows">

                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">08</span>
                        <span class="ai-module-title">Das Ökosystem</span>
                        <span class="ai-module-desc">RAG & Agentische Workflows.</span>
                    </a>

                    <a href="./ai_09_xai" class="ai-module-card" data-tags="xai, explainable ai, vertrauen, saliency maps, erklärbarkeit, transparenz">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">09</span>
                        <span class="ai-module-title">Vertrauen & XAI</span>
                        <span class="ai-module-desc">Explainable AI & Saliency Maps.</span>
                    </a>

                    <a href="./ai_10_nerf" class="ai-module-card" data-tags="nerf, 3d, vision, rendering, generierung">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">10</span>
                        <span class="ai-module-title">NeRF & 3D Vision</span>
                        <span class="ai-module-desc">NeRF & 3D Vision.</span>
                    </a>

                    <a href="./aI_11_activation.php" class="ai-module-card" data-tags="aktivierungsfunktionen, relu, sigmoid, tanh">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">11</span>
                        <span class="ai-module-title">Aktivierungsfunktionen</span>
                        <span class="ai-module-desc">Aktivierungsfunktionen, ReLU, Sigmoid, Tanh</span>
                    </a>

                    <a href="./ai_12_uat" class="ai-module-card" data-tags="uat, universal approximation theorem, theorie, mathematik">
                        <span class="wip-banner wip-banner--preview">Preview ...</span>

                        <span class="ai-module-number">12</span>
                        <span class="ai-module-title">Universal Approximation Theorem</span>
                        <span class="ai-module-desc">Universal Approximation Theorem</span>
                    </a>
                </div>
            </div>

            <h3 class="pt-3">Praktische Einführung</h3>
            <p>In diesem Teil möchte ich die Implementation durch praktische Beispiele demonstrieren. Von einem einfachen Neuron ohne die verwendung von Frameworks (PyTorch oder TensorFlow) bis hin zu komplexeren Architekturen und Modellen.</p>
            <div class="boxWrapper mb-2">
                <div class="ai-grid-container">
                    <a href="./ai_13_umbrella" class="ai-module-card" data-tags="regenschirm, neuron, praxis, implementierung, programmierung, no framework">
                        <span class="wip-banner">In Arbeit ...</span>
                        <span class="ai-module-number">13</span>
                        <span class="ai-module-title">Der Regenschirm</span>
                        <span class="ai-module-desc">Ein einziges Neuron (ohne Frameworks). Was passiert hier eigentlich?</span>
                    </a>

                    <a href="./ai_14_cinema.php" class="ai-module-card" data-tags="kino, couch, hidden layer, neuron, netz, praxis, implementierung, programmierung">
                        <span class="wip-banner">In Arbeit ...</span>
                        <span class="ai-module-number">14</span>
                        <span class="ai-module-title">Kino oder Couch?</span>
                        <span class="ai-module-desc">Der erste Hidden-Layer mit mehreren Neuronen.</span>
                    </a>

                    <a href="" class="ai-module-card ai-module-card--disabled" data-tags="backpropagation, praxis, implementierung, programmierung, mathe, gradient">
                        <span class="wip-banner">In Planung ...</span>
                        <span class="ai-module-number">15</span>
                        <span class="ai-module-title">Backpropagation</span>
                        <span class="ai-module-desc">Backpropagation</span>
                    </a>
                </div>
            </div>

            <script>
                /**
                 * Filter AI modules based on search input keywords
                 */
                document.addEventListener('DOMContentLoaded', function () {
                    const searchInput = document.getElementById('ai-module-search');
                    if (!searchInput) return;

                    searchInput.addEventListener('input', function () {
                        const query = this.value.toLowerCase().trim();
                        const cards = document.querySelectorAll('.ai-module-card');

                        cards.forEach(card => {
                            const title = card.querySelector('.ai-module-title')?.textContent.toLowerCase() || '';
                            const desc = card.querySelector('.ai-module-desc')?.textContent.toLowerCase() || '';
                            const tags = card.getAttribute('data-tags') ? card.getAttribute('data-tags').toLowerCase() : '';

                            if (title.includes(query) || desc.includes(query) || tags.includes(query)) {
                                card.style.display = 'flex'; // ai-module-card uses display: flex
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });
            </script>
    </main>
    <?php include dirname(__DIR__) . '/includes/footer.php'; ?>
</body>

</html>