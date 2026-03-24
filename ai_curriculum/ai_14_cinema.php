<?php
// variables:
$title = "Praktische Einführung";
$page_headline = "14. Kino oder Netflix?";
// $prev_link = 'ai_12_business';
// $prev_text = 'Zurück: Business';
$prev_link = 'ai_13_umbrella';
$prev_text = 'Zurück: Der Regenschirm';
$next_link = 'ai_dashboard';
$next_text = 'Zurück zur Übersicht';


if (isset($_POST['ajax_run_python_script'])) {
    $cinema = isset($_POST['cinema']) ? 1 : 0;
    $netflix = isset($_POST['netflix']) ? 1 : 0;

    $script_path = dirname(__DIR__) . '/python/cinema.py';

    if (file_exists($script_path)) {
        $command = "chcp 65001 > nul && python " . escapeshellarg($script_path) . " " . escapeshellarg($cinema) . " " . escapeshellarg($netflix) . " 2>&1";
        $output = shell_exec($command);

        echo "<div class='panel mt-1'><div class='panel-content'>";
        echo "<h3 class='c2-second'>Ergebnis der Berechnung:</h3>";
        echo "<pre>" . htmlspecialchars($output, ENT_QUOTES, 'UTF-8') . "</pre>";
        echo "</div></div>";
    } else {
        echo "<p style='color: red; margin-top: 10px;'>Fehler: cinema.py nicht gefunden unter $script_path</p>";
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
<h3 class="c1-second mt-1">Einzelnes Neuron (Regenschirm-Beispiel)</h3>
<p>In diesem Beispiel nun ein etwas komplexeres Beispielt mit einem Hidden-Layer und mehreren Neuronen. Wir wollen wissen, ob wir lieber ins Kino gehen oder Zuhause eine Serie schauen. Hier das Neuronale Netz:</p>

<div class="ai-img-wrapper">
    <figure>
        <img src="../assets/png/cinema_nn.png" alt="Darstellung des einelne Neurons für das Regenschirm-Beispiel.">
        <figcaption>Wir haben zwei Inputs: Kino oder Netflix. Außerdem einen Hidden-Layer mit zwie Neuronen und eine Output-Layer, ebenfalls zwei Neuronen.</figcaption>
    </figure>
</div>

<form id="cinemaForm">
    <div class="ai-user-input">
        <div>
            <input type="checkbox" id="cinema" name="cinema" value="1" class="checkbox">
            <label for="cinema">Ins Kino gehen</label>
        </div>

        <div>
            <input type="checkbox" id="netflix" name="netflix" value="1" class="checkbox">
            <label for="netflix">Netflix schauen</label>
        </div>
    </div>
    <button type="button" id="runPythonBtn" class="btn btn--main">Ausführen</button>
</form>

<div id="cinemaResult"></div>

<script>
    document.getElementById('runPythonBtn').addEventListener('click', function (e) {
        e.preventDefault();
        const btn = this;
        const originalText = btn.innerText;
        btn.innerText = 'Lade...';
        btn.disabled = true;

        const formData = new FormData(document.getElementById('cinemaForm'));
        formData.append('ajax_run_python_script', '1');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(html => {
                document.getElementById('cinemaResult').innerHTML = html;
                btn.innerText = originalText;
                btn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('cinemaResult').innerHTML = '<p style="color: red; margin-top: 10px;">Ein Fehler ist aufgetreten.</p>';
                btn.innerText = originalText;
                btn.disabled = false;
            });
    });
</script>


<p class="mt-1">Als erstes definieren wir eine Funktion, die die Eingaben entgegennimmt.
    x1 und x2 sind hier die Eingaben die du in diesem Feld eingestellt hast.
    WIe zu sehen, werden hier für die Multiplikationen der Gewichte Matrizen verwendet. Matrizenmultiplikationen sind für GPUs sehr gut geeignet. Außerdem ist es übersichtlicher. <br> In diesem Beispiel sind die Matrizen verschachtelte Listen. Wenn wir uns w1 anschauen, dann sehen wir zwei Listen: [10.0, -10.0] und [-10.0, 10.0] welche wiederum in einer Liste zusammengefasst sind. Dies ist wichtig zu verstehen um die Multiplikationen der Matrizen zu verstehen. <br> Wenn du dir die Multiplikation anschaust (x1 * w1[0][0]) dann steht w1[0][0] für das erste Element der ersten Liste. Hier eine Darstellung der Notation:</p>

<div class="ai-img-wrapper ai-img-wrapper--small">
    <figure>
        <img src="../assets/png/matrix.png" alt="Darstellung des einelne Neurons für das Regenschirm-Beispiel.">
        <figcaption>Wir sehen <span style="color: #47D45A;">W<sub>1</sub></span> welches für die komplette Matrix steht. Innerhalb von <span style="color: #47D45A;">W<sub>1</sub></span> haben wir zwei Listen. Zugriff auf die erste (obere) Liste wird durch den sogenannten Index 0 erreicht (in der IT beginnt eine Liste für gewönlich mit 0 und nicht mit 1). Somit ist die erste Liste erreichbar mit <span style="color: #FFFF00;">W<sub>1</sub>[0]</span> und die zweite Liste mit <span style="color: #0F9ED5;">W<sub>1</sub>[1]</span>. Der erste Index bezog sich auf die Inhalte der äußeren Liste, also auf <span style="color: #47D45A;">W<sub>1</sub></span>. Um nun auf die Inhalte der inneren Liste zugreifen zu können, benötigen wir den Index dieser Liste. Somit ist das erste (linke) Element der ersten (oberen) Liste erreichbar mit <span style="color: #E97132;">W<sub>1</sub>[0][0]</span> und das zweite (rechte) Element der zweiten (unteren) Liste mit <span style="color: #E59EDD;">W<sub>1</sub>[1][1]</span>.</figcaption>
    </figure>
</div>

<pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python">def run_nn(x1, x2):
    # --- Gewichte (weights) ---
    w1 = [[ 10.0, -10.0],  # Erster Layer (Hidden Layer)
          [-10.0,  10.0]]
          
    w2 = [[ 10.0, -10.0],  # Zweiter Layer (Output Layer)
          [-10.0,  10.0]] 
          
    bias = [-5.0, -5.0]
    bias2 = [-5.0, -5.0]
    
    # --- Berechnnung der Schicht 1 (Hidden Layer) ---
    hidden_layer_calc_1 = (x1 * w1[0][0]) + (x2 * w1[0][1]) + bias[0]
    hidden_layer_calc_2 = (x1 * w1[1][0]) + (x2 * w1[1][1]) + bias[1]

    hidden_layer_activating_1 = sigmoid(hidden_layer_calc_1)
    hidden_layer_activating_2 = sigmoid(hidden_layer_calc_2)

    # --- Berechnung Schicht 2 (Output Layer) ---
    output_layer_calc_1 = (hidden_layer_activating_1 * w2[0][0]) + (hidden_layer_activating_2 * w2[0][1]) + bias2[0]
    output_layer_calc_2 = (hidden_layer_activating_1 * w2[1][0]) + (hidden_layer_activating_2 * w2[1][1]) + bias2[1]

    output_layer_activating_1 = sigmoid(output_layer_calc_1)
    output_layer_activating_2 = sigmoid(output_layer_calc_2)

    return hidden_layer_calc_1, hidden_layer_calc_2, hidden_layer_activating_1, hidden_layer_activating_2, output_layer_activating_1, output_layer_activating_2, output_layer_calc_1, output_layer_calc_2
</code></pre>

<p class="mt-1">
    Hier ebenbfalls die Sigmoid Funktion als Aktivierungsfunktion:
</p>

<pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python">def sigmoid(weighted_sum):
    return 1 / (1 + math.exp(-weighted_sum))
</code></pre>

<p class="mt-1">Diese Beispiel ist sehr ähnlich zum ersten Beispiel nur mit einem Hidden-Layer und somit mehr Berechnungen. In diesen beiden Beispielen fand noch kein Training, ein Backpropagation statt. Die Gewichte wurden von mir festgelegt. Jedoch zeigt es den Kernaufbau eines neuronalen Netzes.</p>
<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>