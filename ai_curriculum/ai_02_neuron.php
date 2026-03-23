<?php
// variables:
$title = "AI 02: Das Neuron";
$page_headline = "02. Das Neuron: Die kleinste Einheit der KI";
$prev_link = 'ai_01_big_picture';
$prev_text = 'Zurück: Das Big Picture';
$next_link = 'ai_03_architecture';
$next_text = 'Weiter: Die Architektur';

ob_start();
?>


<h3 class="c1-second mt-1">Die Analogie: Bio vs. Tech</h3>
<p>Ein einzelnes Neuron ist nicht "intelligent". Es ist ein einfacher Schalter. Aber Milliarden
    davon, die miteinander kommunizieren, erzeugen komplexe Intelligenz. In der Informatik bauen wir
    mit Hilfe der Mathematik diesen Schalter nach.</p>

<div class="ai-grid-2" style="margin-top: 2rem;">

    <div class="ai-card">
        <div style="text-align: center; margin-bottom: 3rem; min-height: 180px; display: flex; align-items: center; justify-content: center;">
            <img src="../assets/png/bnn.png" style="max-width: 90%; " alt="Biologisches Neuron">
        </div>

        <h4>Das biologische Vorbild</h4>
        <ul class="ai-list" style="margin-top: 1rem;">
            <li><strong>Dendriten (Blaue Verästelungen):</strong> Die "Antennen". Sie empfangen
                elektrische Impulse von anderen vorgeschalteten Zellen.</li>
            <li><strong>Soma (Oranger Zellkörper):</strong> Der Rechner. Er sammelt und summiert die
                eingehenden Spannungen auf.</li>
            <li><strong>Axon (Pinker Strang):</strong> Das Kabel. Wenn die summierte Spannung im
                Zellkörper hoch genug ist, feuert das Neuron ein elektrisches Signal an die nächste
                Zelle ab.</li>
        </ul>
    </div>

    <div class="ai-card">
        <div style="text-align: center; margin-bottom: 1.5rem; min-height: 180px; display: flex; align-items: center; justify-content: center;">
            <img src="../assets/png/ann.png" style="max-width: 90%; " alt="Künstliches Neuron (Perzeptron)">
        </div>

        <h4>Das künstliche Neuron (Perzeptron)</h4>
        <ul class="ai-list" style="margin-top: 1rem;">
            <li><strong>Inputs (X):</strong> Die Eingabedaten (z.B. Pixel eines Bildes). Entspricht
                den Dendriten.</li>
            <li><strong>Gewichte (W):</strong> Die "Wichtigkeit" der Inputs. Das ist der Teil, den
                die KI beim Training <em>lernt</em> und anpasst!</li>
            <li><strong>Summe (Σ) & Bias (b):</strong> Alle Inputs werden mit ihren Gewichten
                multipliziert und summiert (Oranger Kreis). Der Bias ist ein Basiswert, der das
                Ergebnis verschiebt.</li>
            <li><strong>Aktivierungsfunktion (φ):</strong> Der Schwellenwert (Pinker Kreis). Sie
                entscheidet mathematisch, ob und wie stark das Signal weitergegeben wird.</li>
        </ul>
    </div>
</div>

<hr>

<h3 class="c1-second mt-1">Der Entscheidungsmoment: Die Formel des "Denkens"</h3>
<p>Im Gehirn feuert ein Neuron oder es feuert nicht. Im künstlichen Netz regelt das die
    <strong>Aktivierungsfunktion</strong>. Ohne sie wäre das gesamte neuronale Netz nur eine
    langweilige lineare Gleichung und könnte keine komplexen Probleme lösen. Ich gehe im Modul 11
    genauer auf die verschiedenen Aktivierungsfunktionen ein, aber falls du ungeduldig bist, dann klicke <a href="./ai_11_activation.php">hier</a>.
</p>

<div class="code-box">
    <span class="c-comment">// Der "Forward Pass" eines einzelnen Neurons</span><br>
    <span class="c-var">summe</span> <span class="c-keyword">=</span> (<span class="c-var">X1</span>
    <span class="c-keyword">*</span> <span class="c-var">W1</span>) <span class="c-keyword">+</span>
    (<span class="c-var">X2</span> <span class="c-keyword">*</span> <span class="c-var">W2</span>)
    <span class="c-keyword">+</span> ... <span class="c-keyword">+</span> <span class="c-var">Bias</span>;<br>
    <span class="c-var">output</span> <span class="c-keyword">=</span> <span class="c-func">Aktivierungsfunktion</span>(<span class="c-var">summe</span>);
</div>

<div>
    <h4 class="c1-second mt-1">Was passiert da genau? Das Regenschirm-Beispiel</h4>

    <p>Ein Neuron gibt am Ende einen Zahlenwert aus. Sehr oft bewegt sich dieser Wert zwischen 0 und
        1 (nicht immer, es hängt davon ab was genau du berechnen möchtest). Eine <strong>1</strong>
        kann dabei für "Ja" (oder 100%) stehen und eine <strong>0</strong> für "Nein" (0%). Wenn das
        künstliche Neuron am Ende eine <strong>0.8</strong> ausgibt, bedeutet das also: Zu 80% True
        (Wahr).</p>

    <p>Nun stelle dir vor, dass du berechnen möchtest, ob du heute einen Regenschirm mitnimmst. Das
        Neuron sammelt dafür verschiedene Informationen (Inputs) und bewertet diese mit einer
        Wichtigkeit (Gewichten).</p>

    <ul class="ai-list">
        <li>
            <strong>Deine Eingabe (Input) <span class="c-var">X<sub>1</sub></span></strong> ist: <em>"Ist es draußen
                bewölkt?"</em> <br>
            Du schaust aus dem Fenster und sagst "Ja". Der Wert für <span class="c-var">X<sub>1</sub></span> ist also
            <strong>1</strong>.<br>
            Das <strong>Gewicht <span class="c-string">W<sub>1</sub></span></strong> für diese Information ist hoch, z.B.
            <strong>0.8</strong>, denn dunkle Wolken sind ein starkes Indiz für Regen.
        </li>
        <li class="mt-1">
            <strong>Deine Eingabe <span class="c-var">X<sub>2</sub></span></strong> ist: <em>"Ist heute Dienstag?"</em> <br>
            Es ist Dienstag, also ist der Wert für <span class="c-var">X<sub>2</sub></span> ebenfalls <strong>1</strong>.<br>
            Das <strong>Gewicht <span class="c-string">W<sub>2</sub></span></strong> ist hier aber <strong>0.0</strong>. Dem
            Wetter ist der Wochentag völlig egal, diese Information hat absolut null Relevanz für
            deine Entscheidung.
        </li>
        <li class="mt-1">
            <strong>Deine Eingabe <span class="c-var">X<sub>3</sub></span></strong> ist: <em>"Fahre ich mit dem Auto zur
                Arbeit?"</em> <br>
            Du fährst Auto, also <span class="c-var">X<sub>3</sub></span> = <strong>1</strong>.<br>
            Das <strong>Gewicht <span class="c-string">W<sub>3</sub></span></strong> ist hier negativ, z.B. <strong>-0.5</strong>.
            Wenn du geschützt in einem trockenen Auto sitzt, sinkt die Wahrscheinlichkeit drastisch,
            dass du einen Schirm brauchst.
        </li>
        <li class="mt-1">
            <strong>Der Bias <span class="c-return">(b)</span></strong> ist ein konstanter Wert, der dem Ergebnis immer
            hinzugefügt wird. Er repräsentiert die Grundwahrscheinlichkeit, dass das Neuron feuert,
            unabhängig von den Eingaben. In unserem Beispiel könnte ein positiver Bias bedeuten,
            dass du generell eher dazu neigst, einen Regenschirm mitzunehmen, auch wenn die
            Beweislage nicht eindeutig ist.
        </li>
    </ul>

    <div class="ai-card--notice">
        <div class="code-box">
            <span class="c-comment">// Die Berechnung im Neuron (Summe)</span><br>
            Z = (<span class="c-var">X<sub>1</sub></span> * <span class="c-string">W<sub>1</sub></span>) + (<span class="c-var">X<sub>2</sub></span> * <span class="c-string">W<sub>2</sub></span>) + (<span class="c-var">X<sub>3</sub></span> *
            <span class="c-string">W<sub>3</sub></span>) + <span class="c-return">b</span> <br>
            Z = (<span class="c-var">1</span> * <span class="c-string">0.8</span>) + (<span class="c-var">1</span> * <span class="c-string">0.0</span>) + (<span class="c-var">1</span> *
            <span class="c-string">-0.5</span>) + <span class="c-return">0.1</span> <br>
            Z = 0.4
        </div>
        <p class="mt-1">
            <strong>Das Fazit:</strong> Die <em>Aktivierungsfunktion</em> wandelt diesen Wert in
            eine Wahrscheinlichkeit zwischen 0 und 1 um. Wenn dein persönlicher Schwellenwert bei
            0.5 liegt, reicht die 0.4 nicht aus. Das Neuron "feuert" nicht, die finale Ausgabe ist 0
            (Nein). Du lässt den Regenschirm zu Hause!
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>