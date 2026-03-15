<?php
// variables:
$title = "Praktische Einführung";
$page_headline = "13. Praktische Einführung";
// $prev_link = 'ai_12_business';
// $prev_text = 'Zurück: Business';
$prev_link = 'ai_dashboard';
$prev_text = 'Zurück zur Übersicht';
$next_link = 'ai_dashboard';
$next_text = 'Zurück zur Übersicht';


ob_start();
?>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<!-- Content: -->
<h3 class="c1-second mt-1">Einzelnes Neuron (Regenschirm-Beispiel)</h3>
<p>Hier möchte ich ein simples neuronales Netz vorstellen. Dabei orientiere ich mich am Regenschirm-Beispiel aus den vorherigen Modulen. Da Python die Standard-Programmiersprache im Bereich der Künstlichen Intelligenz ist, werde ich sie auch hier verwenden, jedoch alle Schritte genau erklären. Für komplexere Netze nutzt man heute meist Frameworks wie TensorFlow oder PyTorch, die einem viel Arbeit abnehmen. Hier möchte ich mich aber auf die reinen Grundlagen beschränken, um zu zeigen, was unter der Haube passiert.</p>


<form method="POST">
    <div class="user-input">
        <label for="cinema">Läuft ein guter Film im Kino?</label>
        <input type="checkbox" id="cinema" name="cinema" value="1">

        <label for="netflix">Läuft ein guter Film auf Netflix?</label>
        <input type="checkbox" id="netflix" name="netflix" value="1">

        <button type="submit" name="run_python_script" class="btn btn--main">Ausführen</button>
    </div>
</form>

<?php
if (isset($_POST['run_python_script'])) {
    // Get values from POST, default to 0 if not checked
    $cinema = isset($_POST['cinema']) ? 1 : 0;
    $netflix = isset($_POST['netflix']) ? 1 : 0;

    $script_path = dirname(__DIR__) . '/python/cinema.py';

    if (file_exists($script_path)) {
        // chcp 65001 set the console to UTF-8 to handle special characters correctly on Windows
        $command = "chcp 65001 > nul && python " . escapeshellarg($script_path) . " " . escapeshellarg($cinema) . " " . escapeshellarg($netflix) . " 2>&1";
        $output = shell_exec($command);

        echo "<div class='panel mt-1'><div class='panel-content'>";
        echo "<h3 class='c2-second'>Ergebnis der Berechnung:</h3>";
        echo "<pre>" . htmlspecialchars($output, ENT_QUOTES, 'UTF-8') . "</pre>";
        echo "</div></div>";
    } else {
        echo "<p style='color: red; margin-top: 10px;'>Fehler: cinema.py nicht gefunden unter $script_path</p>";
    }
}
?>


<p class="mt-1">Als erstes definieren wir eine Funktion, die die Eingaben entgegennimmt.
    x1, x2 und x3 sind hier die Eingaben die du in diesem Feld eingestellt hast.
    in diesem Beispiel ist x1 = bewölkt = 1 oder 0.
    Die Gewichte (w1, w2, w3) und der Bias ist vorgegeben. Am Schluss der Funktion wird der berechnet Wert einer Sigmoid Funktion übergeben.</p>

<div class="code-box">
    <pre>
<span class="c-keyword">def</span> <span class="c-func">run_nn</span>(<span class="c-var">x1</span>, <span class="c-var">x2</span>, <span class="c-var">x3</span>):
    <span class="c-var">w1 </span><span class="c-operator">=</span><span class="c-number"> 0.8</span><span class="c-comment"> # Bewölkt</span>
    <span class="c-var">w2 </span><span class="c-operator">=</span><span class="c-number"> 0.0</span><span class="c-comment"> # Wochentag</span>
    <span class="c-var">w3 </span><span class="c-operator">=</span><span class="c-number"> -0.5</span><span class="c-comment"> # Fahren</span>
    <span class="c-var">bias </span><span class="c-operator">=</span><span class="c-number"> 0.1</span><span class="c-comment"> # Persönliche Präferenz</span>

    <span style="white-space: pre-wrap;" class="c-comment"># Hier führen wir die Berechnung durch. Wie du siehst, werden die Eingaben mit den Gewichten multipliziert und addiert.</span>
    <span class="c-var">weighted_sum </span><span class="c-operator">=</span><span class="c-number"> (<span class="c-var">x1</span> * <span class="c-var">w1</span>) + (<span class="c-var">x2</span> * <span class="c-var">w2</span>) + (<span class="c-var">x3</span> * <span class="c-var">w3</span>) + <span class="c-var">bias</span></span>

    <span style="white-space: pre-wrap;" class="c-comment"># Das Ergebnis dieser Berechnung geht an die Sigmoid Funktion, welche unsere Aktivierungsfunktion darstellt.</span>
    <span class="c-var">result </span><span class="c-operator">=</span><span class="c-number"> sigmoid(<span class="c-var">weighted_sum</span>)</span>
    </pre>
</div>

<p class="mt-1">
    Das hier ist die Sigmoid Funktion. Es gibt unterschiedliche Aktivierungsfunktionen, die bekanntesten sind ReLU, TanH und Sigmoid.
    Die Sigmoid Funktion hat den Vorteil, dass sie die Werte auf einen Bereich zwischen 0 und 1 beschränkt. Das ist nützlich, um Wahrscheinlichkeiten darzustellen. <br>
    Aktivierungsfunktionen sind mathematisch meist eher simpel. Die heutzutage am weitesten verbreitete Funktion heißt ReLU (Rectified Linear Unit) und sorgt schlicht dafür, dass negative Werte auf 0 gesetzt werden, während positive Werte unverändert bleiben.
</p>

<div class="code-box">
    <pre>
<span class="c-keyword">def</span> <span class="c-func">sigmoid</span>(<span class="c-var">weighted_sum</span>):
    <span class="c-keyword">return</span> <span class="c-number">1</span> / (<span class="c-number">1</span> + <span class="c-keyword">math</span>.<span class="c-func">exp</span>(-<span class="c-var">weighted_sum</span>))
    </pre>
    <span class="c-comment"># Etwas lesbarer:</span> <br>
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
</div>

<p class="mt-1">Dies ergibt dann eine Zahl zwischen 1 und 0. Wenn das Ergebnis 0.68 ist, bedeutet das, dass es eine 68% Wahrscheinlichkeit gibt, dass du einen Regenschirm mitnehmen solltest.</p>
<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>