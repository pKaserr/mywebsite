<?php
// variables:
$title = "AI 11: Aktivierungsfunktionen";
$page_headline = "11. Aktivierungsfunktionen";
$prev_link = 'ai_10_nerf';
$prev_text = 'Zurück: NeRF & 3D Vision';
$next_link = 'ai_12_uat';
$next_text = 'Weiter: Universeller Approximations Theorem';

ob_start();
?>

<h3 class="c1-second mt-1">Das Problem der geraden Linie</h3>
<p>Erinnern wir uns kurz an das Innere eines Neurons. Es nimmt Eingaben, multipliziert sie mit Gewichten und addiert einen Bias. Mathematisch gesehen ist das eine simple lineare Gleichung ($y = mx + b$). Das Problem dabei: Egal wie viele solcher Neuronen du hintereinander hängst, wenn du nur multiplizierst und addierst ist ein Neuron genauso mächtig wie Milliarden Neuronen, da das Ergebnis dasselbe ist: Eine starre, gerade Linie.</p>
<p>Die echte Welt ist aber nicht linear. Stell dir ein Koordinatensystem vor, bei dem in der Mitte ein roter Haufen Punkte (Katzen) liegt, der kreisförmig von blauen Dreiecken (Hunden) umringt ist. Wenn du nun versuchst, die Hunde von den Katzen mit einem geraden Lineal zu trennen, scheiterst du. Du durchschneidest immer beide Gruppen. Um die Daten sauber zu trennen, musst du das Lineal verbiegen können, du brauchst Kurven, Kanten und Kreise. <br> Die Welt der neuronalen Netze ist multidimensional. Ein large Language Model wie ChatGPT oder Gemini hat tausende Dimensionen um Sprache zu verstehen, da jedes Wort unterschiedliche Bedeutungen haben kann. Eine gerade Linie kann das nicht abbilden. Auch beim erkennen von Mustern in einem Bild ist sowas sehr wichtig.</p>


<hr>

<h3 class="c1-second mt-1">Die Lösung: Der Knick</h3>
<p>Genau hier kommt die <strong>Aktivierungsfunktion</strong> ins Spiel. Sie sitzt ganz am Ausgang jedes Neurons und agiert wie ein Filter oder Türsteher. Sie entscheidet: <em>"Darf dieses Signal weitergegeben werden? Und wenn ja, in welcher Form?"</em></p>
<p>Indem diese Funktion das Signal ab einer bestimmten Schwelle abschneidet, staucht oder abknickt, bricht sie die starre, gerade Linie auf. Sie bringt die sogenannte <strong>Nicht-Linearität</strong> ins Netz. Erst durch diese gezielten "Knicke" wird die KI fähig, ihre Linien wie ein Lasso um die komplexesten Datenpunkte zu werfen.</p>

<div class="ai-img-wrapper mt-1 mb-1">
    <figure style="margin: 0;">
        <img src="../assets/png/activation_vs_linear.png" style="max-width: 50%;" alt="Vergleich: Lineare vs. Nicht-lineare Aktivierungsfunktion">
        <figcaption>Vergleich: Lineare vs. Nicht-lineare Aktivierungsfunktion. Links die lineare Funktion, die nur gerade Linien zeichnen kann. Damit ist es schwierig, komplexe Formen abzubilden und unterschiedliche Muster voneinander zu trennen. Rechts die nicht-lineare Funktion, die Kurven und komplexe Formen abbilden kann.</figcaption>
    </figure>
</div>


<hr>

<h3 class="c1-second mt-1">Die 3 wichtigsten Aktivierungsfunktionen</h3>
<p>Es gibt viele verschiedene mathematische Scharniere, aber diese drei haben die Geschichte der KI maßgeblich geprägt:</p>

<div class="ai-card mt-1">
    <h4>1. Sigmoid (Der weiche Dimmer)</h4>
    <p>Der Klassiker aus den frühen Tagen der KI: Sigmoid. Diese Funktion hat die Form eines weich geschwungenen "S". Egal, wie groß oder extrem im Minus die Zahl ist, die aus dem Neuron kommt, Sigmoid quetscht sie in einen Bereich <strong>zwischen 0 und 1</strong>. Das ist perfekt für Wahrscheinlichkeiten, führt bei sehr tiefen Netzen aber dazu, dass die Signale "verschwinden" (<span class="has-tooltip" data-tooltip="Beim Backpropagation werden die Fehler zurückpropagiert, um die Gewichte anzupassen. Wenn die Gradienten sehr klein sind, werden die Gewichte kaum angepasst und das Netz lernt nicht mehr. Nutzung von Aktivierungsfunktionen wie Sigmoid oder Tanh, deren Ableitungen kleine Werte liefern, die durch Kettenregel-Multiplikation in tiefen Netzwerken gegen Null konvergieren.">Vanishing Gradient</span>).</p>
    <p class="mt-1 mb-0 text-align-center">$\sigma(x) = \frac{1}{1 + e^{-x}}$</p>
    <div class="ai-img-wrapper mt-0 mb-1">
        <figure sclass="m-0">
            <img src="../assets/svg/Sigmoid.svg" style="max-width: 50%;" alt="Beispiel eines Graphen der Sigmoid Funktion.">
            <figcaption>Beispiel eines Graphen der Sigmoid Funktion. Zwischen 0 und 1.</figcaption>
        </figure>
    </div>
    <p class="mb-0">Als Python Code:</p>
    <pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python">def sigmoid(x):
    return 1 / (1 + math.exp(-x))
</code></pre>
</div>

<div class="ai-card mt-1">
    <h4>2. Tanh (Der ausbalancierte Bruder)</h4>
    <p>Der <em>Tangens Hyperbolicus</em> sieht fast genauso aus wie die Sigmoid-Funktion (auch ein S-Bogen), aber mit einem entscheidenden Unterschied: Er quetscht die Zahlen nicht zwischen 0 und 1, sondern <strong>zwischen -1 und 1</strong>. Dadurch ist der Nullpunkt exakt in der Mitte (Zero-Centered). Das macht es für das Netz beim Lernen (Gradient Descent) mathematisch einfacher und effizienter, die Gewichte anzupassen.</p>
    <p class="mt-1 mb-0 text-align-center">$\tanh(x) = \frac{e^x - e^{-x}}{e^x + e^{-x}}$</p>

    <div class="ai-img-wrapper mt-0 mb-1">
        <figure sclass="m-0">
            <img src="../assets/svg/Hyperbolic_Tangent.svg" style="max-width: 50%;" alt="Beispiel eines Graphen der Tanh Funktion.">
            <figcaption>Beispiel eines Graphen der Tanh Funktion. Zwischen -1 und 1.</figcaption>
        </figure>
    </div>
    <p class="mb-0">Als Python Code:</p>
    <pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python"># tanh ist in numpy integriert
import numpy as np

return np.tanh(x)
</code></pre>
    <pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python"># oder:
def tanh(x):
    return (math.exp(x) - math.exp(-x)) / (math.exp(x) + math.exp(-x))
</code></pre>
</div>

<div class="ai-card my-1">
    <h4>3. ReLU (Der revolutionäre Lichtschalter)</h4>
    <p>ReLU (Rectified Linear Unit) ist heute der Industriestandard. Wenn das Ergebnis negativ ist, wird es auf 0 gesetzt. Ist es positiv, wird es exakt so weitergegeben. That's it. <br> </p>
    <p class="mt-1 text-align-center">$f(x) = \max(0, x)$</p>

    <div class="ai-img-wrapper mt-0 mb-1">
        <figure sclass="m-0">
            <img src="../assets/svg/Relu.svg" style="max-width: 50%;" alt="Beispiel eines Graphen der ReLU Funktion.">
            <figcaption>Beispiel eines Graphen der ReLU Funktion. Alles unter 0 wird auf 0 gesetzt.</figcaption>
        </figure>
    </div>
    <p class="mb-0">Als Python Code:</p>
    <pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python">def relu(x):
    return max(0, x)
</code></pre>
</div>
<p> Aber wie können gerade Striche komplexe Kurven abbilden? Durch die Masse von unzähligen Neuronen, welches jedes sein eigenes Verständnis eines Signals hat und von sich aus entscheidet, ob es weitergegeben wird oder nicht. Eine einzige ReLU-Funktion erzeugt nur einen scharfen Knick. Aber wenn ein Netz Tausende Neuronen hat, addiert es Tausende dieser kleinen Knicke an unterschiedlichen Stellen auf. So formt das Netz aus extrem vielen winzigen, geraden Stücken eine makellos weiche, komplexe Kurve (wie ein Kreis, der aus vielen kleinen Klembausteinen gebaut wird, oder ganz viele Polygone in einem Computerspiel, dass zu einem Charakter wird). Das erfordert kaum Rechenleistung und funktioniert sehr gut.</p>


<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>