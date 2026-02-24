<?php
require './includes/auth.php';
require './includes/db_connect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>AI: Machine Learning</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./style_additions.css">
    <link rel="icon" type="image/png" href="./assets/favicons/favicon-96x96.png" sizes="96x96" />
</head>

<body>
    <nav>
        <div class="nav">
            <a href="ai_dashboard"><button class="btn btn--main btn--nav">Zurück zu AI</button></a>
            <a href="logout"><button class="btn btn--main btn--nav">Abmelden</button></a>
        </div>
    </nav>
    <main>
        <div class="container_dashboard">
            <div class="container__title">
                <h4 class="container__title--text">Machine Learning</h4>
            </div>
            
             <div class="panel">
                <div class="panel-content">
                    <h3>Was ist Machine Learning?</h3>
                    <p>Machine Learning ist ein Teilbereich der künstlichen Intelligenz, der es Computern ermöglicht, aus Daten zu lernen, ohne explizit programmiert zu sein.</p>
                    
                    <div class="ai-card">
                        <h4>Supervised Learning (Überwachtes Lernen)</h4>
                        <p>Der Algorithmus lernt aus Beispielen (Daten mit Labels).</p>
                    </div>
                    
                     <div class="ai-card" style="margin-top: 1rem;">
                        <h4>Unsupervised Learning (Unüberwachtes Lernen)</h4>
                        <p>Der Algorithmus sucht selbstständig nach Mustern in Daten ohne Labels.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
