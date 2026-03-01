<!DOCTYPE html>
<html>

<head>
    <title>AI 03: Die Architektur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/bg_net_graph.js" defer></script>
    <script src="./js/tooltip.js" defer></script>
    <link rel="stylesheet" href="./style.css">
    <link rel="icon" type="image/png" href="./assets/favicons/favicon-96x96.png" sizes="96x96" />
</head>

<body>
    <nav>
        <div class="nav">
            <a href="index"><button class="btn btn--main btn--nav">Zurück zur Startseite</button></a>
            <a href="ai_dashboard.php"><button class="btn btn--main btn--nav">Zur Übersicht</button></a>
        </div>
    </nav>
    <main>
        <div class="container_dashboard">
            <canvas class="particleCanvas"></canvas>

            <div class="container__title">
                <h4 class="container__title--text">03. Die Architektur: Wie Schichten "denken"</h4>
                <span class="c-grey">Vom einzelnen Pixel zum erkannten Gesicht: Die Magie des Deep Learning.</span>
            </div>

            <div class="panel">
                <div class="panel-content">

                    <h3 class="c1-second mt-1">Vom Tropfen zum Ozean: Das Neuronale Netz</h3>
                    <p>Ein einzelnes Neuron (wie unser Regenschirm-Entscheider) kann nur sehr simple
                        lineare Probleme lösen. Um komplexe Aufgaben wie Bilderkennung oder Sprachverständnis zu
                        meistern, müssen wir tausende, manchmal Milliarden dieser Neuronen miteinander vernetzen. Das
                        nennt man ein <strong>Multi-Layer Perceptron (MLP)</strong> oder ganz einfach: Ein künstliches
                        neuronales Netz. <br> Diese neuronalen Netze haben unterschiedliche Schichten (Layer), die alle
                        eine bestimmte Anzahl von Neuronen haben. Diese Schichten sind für eine bessere Darstellung
                        zumeist nebeneinander angeordnet (von links nach rechts), oder untereinander (von oben nach
                        unten).</p>

                    <div class="ai-grid-3" style="margin-top: 2rem;">

                        <div class="ai-card">
                            <h4>1. Input Layer (Eingabe)</h4>
                            <p class="mt-1"><strong>Die
                                    Sinnesorgane.</strong> Hier kommen die rohen Daten an. Bei einem kleinen
                                Schwarz-Weiß-Bild von 28x28 Pixeln hätte diese Schicht exakt 784 Neuronen – eines für
                                jeden Pixelwert. Hier wird noch nicht gerechnet oder "gedacht", die Daten werden nur ins
                                Netz gespeist.</p>
                        </div>

                        <div class="ai-card">
                            <h4>2. Hidden Layer(s)</h4>
                            <p class="mt-1"><strong>Das Gehirn.</strong>
                                Hier passiert die Magie. Die Neuronen dieser Schicht(en) empfangen die Signale der
                                vorherigen Schicht, multiplizieren sie mit Gewichten, addieren den Bias und wenden die
                                Aktivierungsfunktion an. Je mehr dieser verborgenen Schichten wir hintereinander
                                stapeln, desto <strong>"tiefer" (Deep Learning)</strong> ist das Netz.</p>
                        </div>

                        <div class="ai-card">
                            <h4>3. Output Layer (Ausgabe)</h4>
                            <p class="mt-1"><strong>Die
                                    Entscheidung.</strong> Das finale Ergebnis. Soll das Netz erkennen, ob ein Bild
                                einen Hund oder eine Katze zeigt, hat diese Schicht genau zwei Neuronen. Sie geben
                                Wahrscheinlichkeiten aus, z.B. Neuron 1 (Hund): 0.85 und Neuron 2 (Katze): 0.15.</p>
                        </div>
                    </div>

                    <div
                        style="text-align: center; margin-bottom: 3rem; min-height: 180px; display: flex; align-items: center; justify-content: center;">
                        <img src="assets/png/nerf_nn.png" style="max-width: 90%; " alt="Biologisches Neuron">
                    </div>
                    <figcaption>Beispiel eines neuronalen Netzes mit 9 Layern und dense Architektur, eines <strong class="has-tooltip"
                            data-tooltip='Echtzeit 3D Visualisierung durch ein neuronales Netz, bei dem 2D Bilder als Input verwendet wurden. Mehr Infos unter "Erfahrungen -> Masterthesis"'>Neural
                            Radiance Field (NeRF).</strong><br>
                        Die Eingabe (x, y, z, φ, θ) stehen für Koordinaten und Blickrichtung im 3D-Raum. Die Ausgabe (r,
                        g, b,
                        σ) stehen für Farbe und Dichte an einer entspechenden Stelle im 3D-Raum. </figcaption>

                    <div class="ai-card--notice mt-1 until-sm-display-none">
                        <table class="c-black">
                            <tr>
                                <th>Modell</th>
                                <th><div class="c-black has-tooltip" data-tooltip='In der Welt der Neuronalen Netze sind Parameter die gewichteten Verbindungen (Weights) und die Schwellenwerte (Biases) innerhalb des Modells. Wenn wir von einem "70B Modell" sprechen, bedeutet das, dass das Modell aus 70 Milliarden Fließkommazahlen besteht, die während des Trainings optimiert wurden'>Geschätzte Parameter (Gesamt)</div></th>
                                <th>Geschätzte Layer</th>
                                <th>Architektur-Typ</th>
                            </tr>   
                            <tr>
                                <td>GPT-4 / GPT-4o</td>
                                <td>ca. 1,76 - 1,8 Billionen</td>
                                <td>ca. 120</td>
                                <td><div class="c-black has-tooltip" data-tooltip='Hier wird das Modell in spezialisierte "Experten-Blöcke" unterteilt. Ein Token wie "Code" wird an den Experten für Programmierung geschickt, ein Token wie "Liebe" an den Experten für kreatives Schreiben.'>Mixture of Experts (MoE)</div></td>
                            </tr>
                            <tr>
                                <td>Gemini 1.5 Pro</td>
                                <td>Mehrere Billionen</td>
                                <td>Unbekannt (sehr tief)</td>
                                <td>Sparse MoE</td>
                            </tr>
                            <tr>
                                <td>Gemini 1.5 Flash</td>
                                <td>ca. 8 - 10 Milliarden</td>
                                <td>ca. 24 - 32</td>
                                <td>Dense / Distilled</td>
                            </tr>
                            <tr>
                                <td>Llama 3 (70B)</td>
                                <td>70 Milliarden</td>
                                <td>80</td>
                                <td><div class="c-black has-tooltip" data-tooltip='Bei einer dense Architektur muss jeder Token jeden einzelnen Parameter des Modells passieren. Sehr kohärentes Wissen, einfach zu trainieren aber sehr rechenintensiv'>Dense (bekannt)</div></td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                    <h3 class="c1-second mt-1">Feature-Hierarchie: Wie Maschinen sehen lernen</h3>
                    <p>Warum brauchen wir mehrere verborgene Schichten (Hidden Layers)? Weil das Netz
                        ein gigantisches Problem in viele kleine, lösbare Teilprobleme zerlegen muss. Jede Schicht
                        füttert die nächste mit immer abstrakteren Informationen.</p>
                    <p>Stell dir vor, das Netz soll auf einem Foto ein Gesicht erkennen:</p>

                    <div class="ai-flex-wrap" style="margin-top: 1.5rem;">
                        <div>
                            <h4 class="c2-second">Schicht 1: Kanten</h4>
                            <p>Die ersten Neuronen schauen nur auf
                                benachbarte Pixel und erkennen einfache Hell-Dunkel-Übergänge (vertikale oder
                                horizontale Linien). Da alle Daten digital sind und ein neuronales Netz nicht wie wir
                                Farbunterschiede erkennen kann, müssen wir es die Farbunterschiede in Form von
                                Zahlenwerten zuführen. So kann ein weißer Pixel mit dem Wert 255 und ein schwarzer Pixel
                                mit dem Wert 0 dargestellt werden.</p>
                        </div>
                        <div>
                            <h4 class="c2-second">Schicht 2: Formen</h4>
                            <p>Die nächste Schicht kombiniert die
                                Kanten aus Schicht 1 zu geometrischen Formen (Kreise, Ecken, Kurven).</p>
                        </div>
                        <div>
                            <h4 class="c2-second">Schicht 3: Merkmale</h4>
                            <p>Aus den simplen Formen werden nun
                                komplexe Gesichtszüge zusammengesetzt (ein Auge, eine Nase, ein Ohr).</p>
                        </div>
                        <div>
                            <h4 class="c2-second">Schicht 4: Das Objekt</h4>
                            <p>Die letzte verborgene Schicht setzt
                                die Merkmale zusammen und erkennt das komplette Konstrukt: Ein Gesicht.</p>
                        </div>
                    </div>

                    <div class="ai-card--notice mt-1">
                        <h4>Das Blackbox-Problem</h4>
                        <p>Das Faszinierende (und für uns Entwickler oft
                            Frustrierende) daran: <strong>Niemand hat dem Netz einprogrammiert, dass es nach Augen oder
                                Nasen suchen soll!</strong> Wir haben es beim Training nur Millionen Bilder von
                            Gesichtern gegeben. Das Netz hat völlig selbstständig gelernt, dass "Augen" ein nützliches
                            mathematisches Muster sind, um die Aufgabe zu lösen.</p>
                        <p>Bei sehr tiefen Netzen mit Milliarden
                            Parametern können wir oft gar nicht mehr genau nachvollziehen, welches Neuron im Inneren
                            eigentlich auf was genau reagiert. Das System wird zur <strong>Blackbox</strong>.</p>
                        <p>Dies bedeutet nicht – wie häufig angenommen – dass
                            wir nicht wissen, was im Inneren des neuronalen Netzes berechnet wird. Es bedeutet, dass es
                            so viele Rechenoperationen gibt, dass es zu komplex ist, sie manuell nachzuvollziehen.</p>
                    </div>

                    <div>
                        <h4 class="c1-second mt-1">Die Taschenlampe im Dunkeln: XAI</h4>
                        <p>Aus diesem Grund gibt es einen Ansatz, der sich <strong>XAI (Explainable
                                AI</strong>, nicht zu verwechseln mit dem Unternehmen xAI von Elon Musk) nennt. Dieser
                            Forschungszweig versucht, die Blackbox verständlich zu machen und herauszufinden,
                            <em>warum</em> das Netz eine bestimmte Entscheidung getroffen hat.
                        </p>

                        <!-- ═══ Interaktives XAI-Modul: Regenschirm ═══ -->
                        <div id="xai-module" class="ai-card--notice mt-1">

                            <p>🔍 Interaktives XAI-Modul: Die Regenschirm-Analyse</p>
                            <p>
                                Erinnere dich an das Regenschirm-Neuron aus <a class="c1-main"
                                    href="ai_02_neuron.php">Modul 02</a>.
                                Schalte die Eingaben ein oder aus und beobachte, wie ein XAI-Algorithmus die
                                Entscheidung erklärt.
                            </p>

                            <!-- Eingabe-Toggles -->

                            <div class="xai-grid">
                                <!-- X1: bewölkt -->
                                <div class="xai-input-card active" id="xai-card-0">
                                    <span class="xai-emoji">☁️</span>
                                    <span class="xai-label">X<sub>1</sub>: Bewölkt?</span>
                                    <label class="xai-switch">
                                        <input type="checkbox" checked id="xai-toggle-0" onchange="xaiUpdate()">
                                        <span class="xai-slider"></span>
                                    </label>
                                    <span class="xai-weight">W<sub>1</sub> = +0.8</span>
                                </div>
                                <!-- X2: Dienstag -->
                                <div class="xai-input-card active" id="xai-card-1">
                                    <span class="xai-emoji">📅</span>
                                    <span class="xai-label">X<sub>2</sub>: Dienstag?</span>
                                    <label class="xai-switch">
                                        <input type="checkbox" checked id="xai-toggle-1" onchange="xaiUpdate()">
                                        <span class="xai-slider"></span>
                                    </label>
                                    <span class="xai-weight">W<sub>2</sub> = 0.0</span>
                                </div>
                                <!-- X3: Auto -->
                                <div class="xai-input-card active" id="xai-card-2">
                                    <span class="xai-emoji">🚗</span>
                                    <span class="xai-label">X<sub>3</sub>: Auto?</span>
                                    <label class="xai-switch">
                                        <input type="checkbox" checked id="xai-toggle-2" onchange="xaiUpdate()">
                                        <span class="xai-slider"></span>
                                    </label>
                                    <span class="xai-weight">W<sub>3</sub> = −0.5</span>
                                </div>
                            </div>

                            <!-- SHAP Waterfall Chart -->
                            <div class="xai-waterfall">
                                <div class="xai-bar-row" id="xai-row-0">
                                    <span class="xai-bar-label">☁️ Bewölkt</span>
                                    <div class="xai-bar-track"><span class="xai-bar-center"></span><span
                                            class="xai-bar-fill" id="xai-fill-0"></span></div>
                                    <span class="xai-bar-value" id="xai-val-0"></span>
                                </div>
                                <div class="xai-bar-row" id="xai-row-1">
                                    <span class="xai-bar-label">📅 Dienstag</span>
                                    <div class="xai-bar-track"><span class="xai-bar-center"></span><span
                                            class="xai-bar-fill" id="xai-fill-1"></span></div>
                                    <span class="xai-bar-value" id="xai-val-1"></span>
                                </div>
                                <div class="xai-bar-row" id="xai-row-2">
                                    <span class="xai-bar-label">🚗 Auto</span>
                                    <div class="xai-bar-track"><span class="xai-bar-center"></span><span
                                            class="xai-bar-fill" id="xai-fill-2"></span></div>
                                    <span class="xai-bar-value" id="xai-val-2"></span>
                                </div>
                                <div class="xai-bar-row" style="opacity:.6">
                                    <span class="xai-bar-label" style="font-style:italic">Bias</span>
                                    <div class="xai-bar-track"><span class="xai-bar-center"></span><span
                                            class="xai-bar-fill" id="xai-fill-b"></span></div>
                                    <span class="xai-bar-value" id="xai-val-b"></span>
                                </div>
                            </div>

                            <!-- Live Computation -->
                            <div class="xai-computation" id="xai-comp"></div>

                            <!-- Result -->
                            <div class="xai-result no" id="xai-result"></div>

                            <hr>

                            <p>
                                Bei der Bilderkennung (wie unserem Gesichts-Beispiel) macht XAI etwas Ähnliches
                                <em>visuell</em>:
                                Es markiert genau die Pixel im Bild farbig, die für das Netz am wichtigsten waren, um
                                das Gesicht zu erkennen.
                                Solche Visualisierungen nennt man <strong>Saliency Maps</strong> oder Heatmaps.
                            </p>
                        </div>

                        <script>
                            (function () {
                                const W = [0.8, 0.0, -0.5];
                                const BIAS = 0.1;
                                const THRESHOLD = 0.5;
                                const LABELS = ['Bewölkt', 'Dienstag', 'Auto'];
                                const SYMBOLS = ['☁️', '📅', '🚗'];

                                function getInputs() {
                                    return [0, 1, 2].map(i => document.getElementById('xai-toggle-' + i).checked ? 1 : 0);
                                }

                                window.xaiUpdate = function () {
                                    const X = getInputs();
                                    const contributions = X.map((x, i) => x * W[i]);
                                    const Z = contributions.reduce((a, b) => a + b, 0) + BIAS;
                                    const decision = Z >= THRESHOLD ? 1 : 0;

                                    // Update cards
                                    [0, 1, 2].forEach(i => {
                                        const card = document.getElementById('xai-card-' + i);
                                        card.classList.toggle('active', X[i] === 1);
                                    });

                                    // Update bars  (max range ±1 mapped to 50% width each side)
                                    const maxAbs = 1.0;
                                    [0, 1, 2].forEach(i => {
                                        const val = contributions[i];
                                        const fill = document.getElementById('xai-fill-' + i);
                                        const valEl = document.getElementById('xai-val-' + i);
                                        const pct = (Math.abs(val) / maxAbs) * 50;
                                        if (val >= 0) {
                                            fill.style.left = '50%';
                                            fill.style.width = pct + '%';
                                            fill.style.background = val === 0 ? '#adb5bd' : '#51cf66';
                                        } else {
                                            fill.style.left = (50 - pct) + '%';
                                            fill.style.width = pct + '%';
                                            fill.style.background = '#ff6b6b';
                                        }
                                        valEl.textContent = (val >= 0 ? '+' : '') + val.toFixed(1);
                                        valEl.style.color = val > 0 ? '#2b8a3e' : val < 0 ? '#c92a2a' : '#868e96';
                                    });
                                    // Bias bar
                                    (function () {
                                        const fill = document.getElementById('xai-fill-b');
                                        const valEl = document.getElementById('xai-val-b');
                                        const pct = (Math.abs(BIAS) / maxAbs) * 50;
                                        fill.style.left = BIAS >= 0 ? '50%' : (50 - pct) + '%';
                                        fill.style.width = pct + '%';
                                        fill.style.background = BIAS >= 0 ? '#74c0fc' : '#fcc419';
                                        valEl.textContent = '+' + BIAS.toFixed(1);
                                        valEl.style.color = '#1971c2';
                                    })();

                                    // Computation
                                    const comp = document.getElementById('xai-comp');
                                    const parts = X.map((x, i) => '(<span class="hl-yellow">' + x + '</span> × <span class="hl-blue">' + W[i].toFixed(1) + '</span>)').join(' + ');
                                    comp.innerHTML =
                                        '<span style="color:#868e96">// Forward Pass</span>\n' +
                                        'Z = ' + parts + ' + <span class="hl-blue">' + BIAS.toFixed(1) + '</span>\n' +
                                        'Z = <span class="hl-bold">' + Z.toFixed(1) + '</span>   →   Schwelle = ' + THRESHOLD.toFixed(1) + '   →   Ausgabe: <span class="' + (decision ? 'hl-green' : 'hl-red') + '">' + (decision ? '1 (JA ☂️)' : '0 (NEIN)') + '</span>';

                                    // Result text
                                    const res = document.getElementById('xai-result');
                                    res.className = 'xai-result ' + (decision ? 'yes' : 'no');

                                    if (decision) {
                                        const positives = contributions.map((v, i) => ({ v, i })).filter(o => o.v > 0).sort((a, b) => b.v - a.v);
                                        const mainReason = positives.length ? SYMBOLS[positives[0].i] + ' ' + LABELS[positives[0].i] : 'Bias';
                                        res.innerHTML = '<span class="xai-result-icon">☂️</span><span class="xai-result-text"><strong>Empfehlung: Regenschirm mitnehmen!</strong><br>' +
                                            'Der stärkste Faktor dafür ist: <strong>' + mainReason + '</strong> (' + contributions.filter((_, i) => positives.some(p => p.i === i)).map(v => (v >= 0 ? '+' : '') + v.toFixed(1)).join(', ') + ').</span>';
                                    } else {
                                        // Explain why NO
                                        const negatives = contributions.map((v, i) => ({ v, i })).filter(o => o.v < 0).sort((a, b) => a.v - b.v);
                                        const positives = contributions.map((v, i) => ({ v, i })).filter(o => o.v > 0).sort((a, b) => b.v - a.v);
                                        let explanation = '<span class="xai-result-icon">🌤️</span><span class="xai-result-text"><strong>Empfehlung: Kein Regenschirm nötig.</strong><br>';
                                        if (positives.length && negatives.length) {
                                            explanation += 'Obwohl <strong>' + SYMBOLS[positives[0].i] + ' ' + LABELS[positives[0].i] + '</strong> in Richtung JA zieht, gibt <strong>' + SYMBOLS[negatives[0].i] + ' ' + LABELS[negatives[0].i] + '</strong> den Ausschlag dagegen.';
                                        } else if (negatives.length) {
                                            explanation += 'Der Faktor <strong>' + SYMBOLS[negatives[0].i] + ' ' + LABELS[negatives[0].i] + '</strong> drückt das Ergebnis deutlich nach unten.';
                                        } else {
                                            explanation += 'Keiner der aktiven Faktoren liefert genügend Gewicht, um den Schwellenwert zu überschreiten.';
                                        }
                                        explanation += '</span>';
                                        res.innerHTML = explanation;
                                    }
                                };

                                // Initial render
                                xaiUpdate();
                            })();
                        </script>
                    </div>

                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <a href="ai_02_neuron.php"><button class="btn btn--main">&larr; Zurück</button></a>
                <a href="ai_04_learning.php"><button class="btn btn--main">Weiter: Wie das Netz lernt (Backpropagation)
                        &rarr;</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>