<?php
// variables:
$title = "Der Regenschirm";
$canonical = "ai_13_umbrella";
$page_headline = "13. Der Regenschirm";
$prev_link = 'ai_dashboard';
$prev_text = 'Zurück zur Übersicht';
$next_link = 'ai_14_cinema';
$next_text = 'Nächste: Kino oder Netflix?';


if (isset($_POST['ajax_run_python_script'])) {
    $weather = isset($_POST['weather']) ? 1 : 0;
    $drive = isset($_POST['drive']) ? 1 : 0;
    $weekday = isset($_POST['weekday']) ? 1 : 0;

    $script_path = dirname(__DIR__) . '/python/umbrella.py';

    if (file_exists($script_path)) {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $command = "chcp 65001 > nul && python " . escapeshellarg($script_path) . " " . escapeshellarg($weather) . " " . escapeshellarg($drive) . " " . escapeshellarg($weekday) . " 2>&1";
        } else {
            $command = "env PYTHONIOENCODING=utf8 python3 " . escapeshellarg($script_path) . " " . escapeshellarg($weather) . " " . escapeshellarg($drive) . " " . escapeshellarg($weekday) . " 2>&1";
        }
        $output = shell_exec($command);

        echo "<div class='panel mt-1'><div class='panel-content'>";
        echo "<h3 class='c2-second'>Ergebnis der Berechnung:</h3>";
        echo "<pre>" . htmlspecialchars($output, ENT_QUOTES, 'UTF-8') . "</pre>";
        echo "</div></div>";
    } else {
        echo "<p style='color: red; margin-top: 10px;'>Fehler: umbrella.py nicht gefunden unter $script_path</p>";
    }
    exit;
}



ob_start();
?>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<!-- Content: -->
<h3 class="c1-second mt-1">Einfaches Neuronales (Netz)</h3>
<p>Hier möchte ich ein simples neuronales Netz vorstellen. Dabei orientiere ich mich am Regenschirm-Beispiel aus den vorherigen Modulen. Da Python die Standard-Programmiersprache im Bereich der Künstlichen Intelligenz ist, werde ich sie auch hier verwenden, jedoch alle Schritte genau erklären. Für komplexere Netze nutzt man heute meist Frameworks wie TensorFlow oder PyTorch, die einem viel Arbeit abnehmen. Hier möchte ich mich aber auf die reinen Grundlagen beschränken, um zu zeigen, was unter der Haube passiert. <br>
    Als erstes eine Abbildung des einzelnen Neurons</p>

<div class="ai-img-wrapper">
    <figure>
        <img src="../assets/png/umbrella_nn.png" alt="Darstellung des einelne Neurons für das Regenschirm-Beispiel.">
        <figcaption>Darstellung des einzelnen Neurons für das Regenschirm-Beispiel. Links der Input (Wolken, Auto, Wochentag), in der Mitte das Neuron und rechts das Ergebnis (benötige ich einen Regenschirm?).</figcaption>
    </figure>
</div>

<p class="mb-0">Hier dieses simple Neuron in Arbeit: Entscheide ob du den Regenschirm brauchst. Ist es bewölkt, ist es Dienstag und fährst du mit dem Auto?</p>

<form id="umbrellaForm">
    <div class="ai-user-input">
        <div>
            <input type="checkbox" id="weather" name="weather" value="1" class="checkbox">
            <label for="weather">Bewölkt</label>
        </div>

        <div>
            <input type="checkbox" id="drive" name="drive" value="1" class="checkbox">
            <label for="drive">Fahren</label>
        </div>

        <div>
            <input type="checkbox" id="weekday" name="weekday" value="1" class="checkbox">
            <label for="weekday">Wochentag</label>
        </div>
    </div>
    <button type="button" id="runPythonBtn" class="btn btn--main">Ausführen</button>
</form>

<div id="umbrellaResult"></div>

<script>
    document.getElementById('runPythonBtn').addEventListener('click', function (e) {
        e.preventDefault();
        const btn = this;
        const originalText = btn.innerText;
        btn.innerText = 'Lade...';
        btn.disabled = true;

        const formData = new FormData(document.getElementById('umbrellaForm'));
        formData.append('ajax_run_python_script', '1');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(html => {
                document.getElementById('umbrellaResult').innerHTML = html;
                btn.innerText = originalText;
                btn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('umbrellaResult').innerHTML = '<p style="color: red; margin-top: 10px;">Ein Fehler ist aufgetreten.</p>';
                btn.innerText = originalText;
                btn.disabled = false;
            });
    });
</script>


<p class="mt-1">Als erstes definieren wir eine Funktion, die die Eingaben entgegennimmt.
    x1, x2 und x3 sind hier die Eingaben die du in diesem Feld eingestellt hast.
    in diesem Beispiel ist x1 = bewölkt = 1 oder 0.
    Die Gewichte (w1, w2, w3) und der Bias ist vorgegeben. Am Schluss der Funktion wird der berechnete Wert einer Sigmoid Funktion übergeben.</p>

<pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python">def run_nn(x1, x2, x3):
    # Gewichte basierend auf dem "Regenschirm" Beispiel
    w1 = 8    # Bewölkt
    w2 = -6   # Autofahren
    bias = -2 # Persönliche Präferenz
    
    # Hier führen wir die Berechnung durch. Wie du siehst, 
    # werden die Eingaben mit den Gewichten multipliziert und addiert.
    weighted_sum = (x1 * w1) + (x2 * w2) + bias

    # Das Ergebnis dieser Berechnung geht an die Sigmoid Funktion,
    # welche unsere Aktivierungsfunktion darstellt.
    return sigmoid(weighted_sum)
</code></pre>

<p class="mt-1">
    Das hier ist die Sigmoid Funktion. Es gibt unterschiedliche Aktivierungsfunktionen (siehe <a href="ai_11_activation.php">hier</a>), die bekanntesten sind ReLU, TanH und Sigmoid.
    Die Sigmoid Funktion hat den Vorteil, dass sie die Werte auf einen Bereich zwischen 0 und 1 beschränkt. Das ist nützlich, um Wahrscheinlichkeiten darzustellen. <br>
</p>

<pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python">def sigmoid(weighted_sum):
    return 1 / (1 + math.exp(-weighted_sum))
</code></pre>
<math xmlns="http://www.w3.org/1998/Math/MathML">
        <mi>sigmoid</mi>
        <mo>(</mo>
        <mi>weighted_sum</mi>
        <mo>)</mo>
        <mo>=</mo>
        <mfrac>
            <mn>1</mn>
            <mrow>
                <mn>1</mn>
                <mo>+</mo>
                <msup>
                    <mi>e</mi>
                    <mrow>
                        <mo>-</mo>
                        <mi>weighted_sum</mi>
                    </mrow>
                </msup>
            </mrow>
        </mfrac>
    </math>


<p class="mt-1">Dies ergibt dann eine Zahl zwischen 1 und 0. Wenn das Ergebnis 0.68 ist, bedeutet das, dass es eine 68% Wahrscheinlichkeit gibt, dass du einen Regenschirm mitnehmen solltest.</p>
<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>
