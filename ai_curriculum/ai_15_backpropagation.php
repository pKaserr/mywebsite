<?php
// variables:
$title = "Praktische Einführung";
$page_headline = "15. Backpropagation";
// $prev_link = 'ai_12_business';
// $prev_text = 'Zurück: Business';
$prev_link = 'ai_14_cinema';
$prev_text = 'Zurück: Kino oder Netflix';
$next_link = 'ai_dashboard';
$next_text = 'Zurück zur Übersicht';


if (isset($_POST['ajax_run_python_script'])) {
    $cinema = isset($_POST['cinema']) ? 1 : 0;
    $netflix = isset($_POST['netflix']) ? 1 : 0;
    $epochs = isset($_POST['epochs']) ? intval($_POST['epochs']) : 10000;

    $script_path = dirname(__DIR__) . '/python/backpropagation.py';

    if (file_exists($script_path)) {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows CMD kann UTF-8 zerlegen. Wir erzwingen UTF8 für Python via Env-Var ohne hintere Leerzeichen!
            $command = "set PYTHONIOENCODING=utf8&& set PYTHONUTF8=1&& chcp 65001 > nul && python " . escapeshellarg($script_path) . " " . escapeshellarg($cinema) . " " . escapeshellarg($netflix) . " " . escapeshellarg($epochs) . " 2>&1";
        } else {
            $command = "env PYTHONIOENCODING=utf8 python3 " . escapeshellarg($script_path) . " " . escapeshellarg($cinema) . " " . escapeshellarg($netflix) . " " . escapeshellarg($epochs) . " 2>&1";
        }
        $output = shell_exec($command);

        // Fallback: Falls Windows hartnäckig bleibt, erzwingen wir eine Umwandlung nach UTF-8
        if (!mb_check_encoding($output, 'UTF-8')) {
            $output = mb_convert_encoding($output, 'UTF-8', 'CP850'); // 'CP850' ist standard Windows-CMD Codepage
        }

        echo "<div class='panel mt-1'><div class='panel-content'>";
        echo "<h3 class='c2-second'>Ergebnis des Trainings:</h3>";
        // ENT_SUBSTITUTE verhindert aktiv, dass der komplette String gelöscht wird, falls verbotene Byte-Sequenzen vorhanden sind!
        echo "<pre class='ai-terminal'>" . htmlspecialchars($output, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</pre>";
        echo "</div></div>";
    } else {
        echo "<p style='color: red; margin-top: 10px;'>Fehler: backpropagation.py nicht gefunden unter $script_path</p>";
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
<h3 class="c1-second mt-1">Lernen durch Fehler (Backpropagation)</h3>
<p>Im vorherigen Beispiel haben wir die Gewichte für das neuronale Netz manuell vorgegeben. In der Realität "lernen" neuronale Netze diese Gewichte jedoch selbst. Dieser Prozess wird <strong>Backpropagation</strong> genannt.</p>
<p>Das Netz startet mit zufälligen Gewichten und berechnet ein Ergebnis (Forward-Pass). Danach wird berechnet, wie weit das Ergebnis vom gewünschten Ziel abweicht (der sogenannte Fehler oder Loss). Dieser Fehler wird dann "rückwärts" durch das Netz propagiert, um die Gewichte so anzupassen, dass der Fehler beim nächsten Durchlauf etwas kleiner wird.</p>
<p>Unser Kino/Netflix Beispiel lässt sich als klassisches <strong>XOR-Problem</strong> (Exklusives Oder) darstellen:
<ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 20px;">
    <li>Weder Kino noch Netflix (Ziel-Ausgabe: 0)</li>
    <li>Nur Kino (Ziel-Ausgabe: 1)</li>
    <li>Nur Netflix (Ziel-Ausgabe: 1)</li>
    <li>Kino und Netflix gleichzeitig (Ziel-Ausgabe: 0)</li>
</ul>

<div class="ai-img-wrapper">
    <figure>
        <img src="../assets/png/backpropagation_nn.png" alt="Darstellung des neuronalen Netzes inklusive Backpropagation.">
        <figcaption>Wir haben zwei Inputs: Kino oder Netflix. Unser Hidden-Layer und Output-Layer verändern stetig die Gewichte (Gewichtsanpassung durch Fehlervergleiche), bis es erfolgreich gelernt hat.</figcaption>
    </figure>
</div>
</p>
<h3 class="c1-second mt-1">Wie funktionier die "Schuldzuweisung"?</h3>
<p class="mb-1">Stell dir vor, du bist der Chef in einem Unternehmen (die Fehlerberechnung) und das Ergebnis deines Teams war nicht sonderlich gut. Du willst jetzt wissen, wem du das Gehalt (die Gewichte) kürzen musst oder welches Gehalt du sogar erhöhen musst.
    Die mathematische "Schuld" eines Gewichts setzt sich aus drei Faktoren zusammen, die einfach miteinander multipliziert werden: $Schuld = Fehler * Ableitung * Input$. Gehen wir also der Reihe nach durch.</p>
<h4 class="c2-second">1. Der Fehler (Wie groß ist das Problem?)</h4>
<p class="mb-1">Das ist einfach auszurechnen. Wir berechnen einfach die Differenz zwischen dem gewünschten Ergebnis und dem tatsächlichen Ergebnis ($Fehler = Gewünschtes Ergebnis - Tatsächliches Ergebnis$). Damit wissen wir, wie viel Mist dein Team insgesamt gebaut hat.</p>
<h4 class="c2-second">2. Der Input (Wer hat das stärkste Signal gesendet?)</h4>
<p class="mb-1">Angenommen, der Output (ein Neuron) hat die falsche Entscheidung getroffen. Es bekam Signale von einem Hidden-Layer davor (zwei Neuronen <span class="c-var">h1</span> und <span class="c-func">h2</span>). <br> <span class="c-var">h1</span> hat eine 0.99 und <span class="c-func">h2</span> hat eine 0.01 gesendet. Logische Konsequenz? <span class="c-var">h1</span> hat ein deutlich höheres Gewicht als <span class="c-func">h2</span> und trägt somit mehr Schuld an der Fehlentscheidung.</p>
<h4 class="c2-second">3. Die Ableitung</h4>
<p>Wir erinnern uns an die Schule und der Kurvendiskussion. Was kann mit einer Ableitung berechet werden? Der Nullpunkt einer Funktion. Problem ist, dass das Netz nicht die komplette Kurve im Ganzen kennt. Wir stehen also Blind auf dem Berg und wollen ins Tal. Du tastest dich mit den Füßen ab und suchst die Steigung, und genau das ist die Ableitung. Ist die Ableitung positiv, weißt du, dass du einen anderen Weg einschlagen musst, ist sie negativ, musst du weiter in diese Richtung. <br> In einem neuronalen Netz ist es jedoch keine einfach Funktion wie: $f(x) = x^{2}$, sondern eine verschachtelte Funktion, die aus mehreren Funktionen besteht. Um jetzt herauszufinden, wie sich der Fehler ändert, wenn wir ganz unten am Rad des Gewichts drehen, müssen wir uns durch diese Schichten nach außen vorarbeiten. Erinnerst du dich an die Kettenregel aus der Kurvendiskussion ("Innere Ableitung mal äußere Ableitung")?
    Genau das machen wir bei der Backpropagation. Wir multiplizieren die Ableitungen der einzelnen Schichten miteinander: $$\text{Gesamte Steigung} = (\text{Ableitung Fehler}) \cdot (\text{Ableitung Sigmoid}) \cdot (\text{Ableitung Summe})$$</p>

<h4 class="c2-second">4. Das Anpassen der Gewichte</h4>
<p class="mb-1">Nun haben wir die Schuldigen identifiziert und wissen, wie stark sie ins Gewicht fallen. Jetzt müssen wir nur noch die Gewichte anpassen. Wir multiplizieren die Schuld mit der Lernrate und ziehen sie vom Gewicht ab. So verringern wir den Fehler Schritt für Schritt, in ganz vielen Durchläufen (Epochen).</p>
<p>Probiere es hier aus und beobachte im "Live-Feed", wie sich der Fehler über die Epochen (Trainingsdurchläufe) verringert:</p>

<form id="backpropagationForm">
    <div class="ai-user-input">
        <div>
            <input type="checkbox" id="cinema" name="cinema" value="1" class="checkbox">
            <label for="cinema">Ins Kino gehen</label>
        </div>

        <div>
            <input type="checkbox" id="netflix" name="netflix" value="1" class="checkbox">
            <label for="netflix">Netflix schauen</label>
        </div>

        <div style="margin-top: 5px;">
            <label for="epochs" style="margin-bottom: 5px; font-weight: bold; margin-right: 10px;">Epochen (Training):</label>
            <select id="epochs" name="epochs" class="input" style="padding: 5px; border-radius: 5px; background: white; color: black; border: 1px solid #ccc; max-width: 200px;">
                <option value="1000">1.000</option>
                <option value="5000">5.000</option>
                <option value="10000" selected>10.000 (Standard)</option>
                <option value="50000">50.000 (Lang)</option>
            </select>
        </div>
    </div>
    <button type="button" id="runPythonBtn" class="btn btn--main mt-1">Training starten & Ausführen</button>
</form>

<div id="backpropagationResult"></div>

<script>
    document.getElementById('runPythonBtn').addEventListener('click', function (e) {
        e.preventDefault();
        const btn = this;
        const originalText = btn.innerText;
        btn.innerText = 'Trainiere Modell...';
        btn.disabled = true;

        const formData = new FormData(document.getElementById('backpropagationForm'));
        formData.append('ajax_run_python_script', '1');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(html => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const terminal = tempDiv.querySelector('.ai-terminal');

                if (terminal) {
                    const fullText = terminal.textContent;
                    terminal.textContent = ''; // Clear text for animation

                    document.getElementById('backpropagationResult').innerHTML = '';
                    document.getElementById('backpropagationResult').appendChild(tempDiv);

                    const actualTerminal = document.querySelector('.ai-terminal');
                    const lines = fullText.split('\n');
                    let currentLine = 0;

                    function printNextLine() {
                        if (currentLine < lines.length) {
                            actualTerminal.textContent += lines[currentLine] + '\n';
                            actualTerminal.scrollTop = actualTerminal.scrollHeight; // Auto-scroll
                            currentLine++;
                            // 120ms timeout pro Zeile lässt das Training cool und lesbar aussehen!
                            setTimeout(printNextLine, 120);
                        } else {
                            btn.innerText = originalText;
                            btn.disabled = false;
                        }
                    }
                    printNextLine();
                } else {
                    document.getElementById('backpropagationResult').innerHTML = html;
                    btn.innerText = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('backpropagationResult').innerHTML = '<p style="color: red; margin-top: 10px;">Ein Fehler ist aufgetreten.</p>';
                btn.innerText = originalText;
                btn.disabled = false;
            });
    });
</script>

<p class="mt-1">Unten siehst du gesamten Code der Trainingsfunktion in Python. Die Gewichte und Biases werden hier zufällig mit <code>random.uniform(-1, 1)</code> initialisiert (also eine zufällige Kommazahl zwischen -1 und 1).
    Die Funktion <code>train_nn</code> iteriert über die gewünschte Anzahl an Epochen. Jede Epoche führt genau drei Schritte aus:</p>

<pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python">def train_nn(epochs=10000, learning_rate=0.5):
    # Zufällige Start-Gewichte und Biases (zwischen -1 und 1)
    w1 = [[random.uniform(-1, 1), random.uniform(-1, 1)],
          [random.uniform(-1, 1), random.uniform(-1, 1)]]
    b1 = [random.uniform(-1, 1), random.uniform(-1, 1)]
    
    w2 = [random.uniform(-1, 1), random.uniform(-1, 1)]
    b2 = random.uniform(-1, 1)

    # Unsere Trainingsdaten (Das XOR-Problem als Beispiel)
    # Format: (Inputs, Gewünschter_Output)
    # [Kino, Netflix], Output
    training_data = [
        ([0, 0], 0), # Weder Kino noch Netflix -> 0
        ([0, 1], 1), # Nur Netflix -> 1
        ([1, 0], 1), # Nur Kino -> 1
        ([1, 1], 0)  # Beides geht nicht -> 0
    ]

    # Iteriere über die Epochen
    for epoch in range(epochs):
        total_error = 0
        for x, y_true in training_data:
            
            # ==========================================
            # 1. FORWARD PASS
            # ==========================================
            # Berechnung wie in den beiden vorherigen Lektionen
            h1 = x[0]*w1[0][0] + x[1]*w1[1][0] + b1[0]
            h2 = x[0]*w1[0][1] + x[1]*w1[1][1] + b1[1]

            a1 = sigmoid(h1)
            a2 = sigmoid(h2)

            z_out = a1*w2[0] + a2*w2[1] + b2
            output = sigmoid(z_out)

            # ==========================================
            # 2. BACKWARD PASS (Der Fehler)
            # ==========================================
            # Wie weit lagen wir daneben?
            error = output - y_true 
            total_error += abs(error)
            
            # Die "Schuld" des Output-Layers am Fehler
            d_output = error * sigmoid_derivative(output)

            # Den Fehler an das Hidden Layer "zurückschieben" (Backpropagation)
            error_h1 = d_output * w2[0]
            error_h2 = d_output * w2[1]

            # Die "Schuld" der Hidden-Neuronen
            d_h1 = error_h1 * sigmoid_derivative(a1)
            d_h2 = error_h2 * sigmoid_derivative(a2)

            # ==========================================
            # 3. GEWICHTE UPDATEN (Gradient Descent)
            # ==========================================
            
            # Update Layer 2 (Output Layer)
            w2[0] -= learning_rate * d_output * a1
            w2[1] -= learning_rate * d_output * a2
            b2    -= learning_rate * d_output

            # Update Layer 1 (Hidden Layer)
            w1[0][0] -= learning_rate * d_h1 * x[0]
            w1[1][0] -= learning_rate * d_h1 * x[1]
            w1[0][1] -= learning_rate * d_h2 * x[0]
            w1[1][1] -= learning_rate * d_h2 * x[1]
            b1[0]    -= learning_rate * d_h1
            b1[1]    -= learning_rate * d_h2
</code></pre>

<p>Zuzüglich gibt es hier noch weitere Funktionen wie die Sigmoid und die Sigmoid Ableitung:</p>

<pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python">def sigmoid(x):
    return 1 / (1 + math.exp(-x))

def sigmoid_derivative(output):
    return output * (1.0 - output)
</code></pre>

<p class="mt-1">Nachdem das Netzwerk komplett trainiert wurde (alle Epochen durchlaufen sind), führen wir einen gewöhnlichen Forward-Pass mit deinen persönlichen Eingaben aus. Das nennt sich <strong>Inferenz</strong>. Das Resultat siehst du im grünen Terminalfenster über diesem Text!</p>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>