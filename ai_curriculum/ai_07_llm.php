<?php
// variables:
$title = "LLMs & Reasoning";
$page_headline = "07. LLMs & Reasoning";
$prev_link = 'ai_06_transformer.php';
$prev_text = 'Zurück: Transformer';
$next_link = 'ai_08_ecosystem.php';
$next_text = 'Weiter: Das Ökosystem';
ob_start();
?>


<h3 class="c1-second mt-1">Einführung: Text in Zahlen verwandeln</h3>
<p>Computer sind faszinierend, haben aber einen entscheidenden Fehler: Sie verstehen keine Wörter.
    Wenn Sie einem Computer das Wort "Apfel" geben, sieht es nichts als unverständliche Zeichen.
    Computer verstehen nur eines: Zahlen. Wie also bringt man einer Maschine das Lesen bei? <br>
    Wenn du einen Prompt eingibst (ein Prompt ist ein Text, der das Modell anweist, was es tun
    soll), durchläuft dein Satz einen streng mathematischen Prozess, bevor
    das Modell überhaupt zu "denken" beginnt.</p>
<hr>

<h3 class="c1-second mt-1">Phase 1: Tokenization (Die Zerstückelung)</h3>
<p>Damit ein Modell wie ChatGPT Sprache verstehen kann, muss der Text zuerst zerkleinert werden.
    Dieser Prozess nennt sich <strong>Tokenization</strong>. Ein "Token" ist einfach ein Stückchen
    Text. Das kann ein ganzes Wort sein ("Haus"), eine Silbe ("un-") oder manchmal nur ein einzelner
    Buchstabe.</p>

<div class="ai-card mt-1">
    <h4>Beispiel: Das Puzzlespiel</h4>
    <p>Betrachten wir den Satz: <em>"Ich liebe künstliche Intelligenz."</em></p>
    <p>Der Tokenizer zerschneidet diesen Satz und weist jedem Stück eine eindeutige ID (Zahl) zu.
        Zum Beispiel:</p>
    <div class="code-box">
        <ul class="ai-list mt-1">
            <span class="c-string">"Ich"</span> &rarr; <span class="c-keyword"> Token-ID:
            </span> <span class="c-number">832</span><br>
            <span class="c-string">" liebe"</span> &rarr; <span class="c-keyword"> Token-ID:
            </span> <span class="c-number">4192</span> <span class="c-comment">// Man beachte
                die Leerzeichen</span><br>
            <span class="c-string">" künst"</span> &rarr; <span class="c-keyword"> Token-ID:
            </span> <span class="c-number">102</span><br>
            <span class="c-string">"liche"</span> &rarr; <span class="c-keyword"> Token-ID:
            </span> <span class="c-number">55</span><br>
            <span class="c-string">" Intelligenz"</span> &rarr; <span class="c-keyword">
                Token-ID: </span> <span class="c-number">9841</span>
        </ul>
    </div>
    <p class="mt-1">Für den Computer ist der Satz nun keine Sprache mehr, sondern nur noch eine
        trockene Zahlenreihe:</p>
    <div class="code-box">
        <p> [<span class="c-number">832</span>, <span class="c-number">4192</span>, <span class="c-number">102</span>, <span class="c-number">55</span>, <span class="c-number">9841</span>] </p>
    </div>
</div>

<hr>

<h3 class="c1-second mt-1">Phase 2: Embeddings (Die Landkarte der Bedeutung)</h3>
<p>Jetzt hat das Modell Zahlen, aber es weiß immer noch nicht, was sie <em>bedeuten</em>. Hier kommt
    die wahre Magie der modernen KI ins Spiel: <strong>Embeddings</strong>. Statt Wörter einfach nur
    zu nummerieren, bekommen sie Koordinaten auf einer gigantischen Landkarte (einem abstrakten
    mathematischen Vektorraum mit oft tausenden Dimensionen).</p>
<div class="code-box">
    <p> Token: <span class="c-keyword">" Intelligenz"</span> -> [<span class="c-number">0.0124</span>, <span class="c-number">-0.0541</span>, <span class="c-number">0.2310</span>, <span class="c-number">-0.1102</span>, <span class="c-number">...</span>,] <span class="c-comment">// insgesamt 4096 Werte für aktuelle Modelle</span>
    </p>
</div>
<p>Die Mehrdimensionalität, was für den Menschen nicht mehr vorstellbar ist, kommt daher, dass jedes
    Wort sehr viele unterschiedliche Nuancen hat. So kann eine Bank ein Kreditinstitut, aber auch
    eine Sitzgelegenheit sein. Um das zu verstehen, werden große LLMs monatelang darauf trainiert.
</p>
<div class="ai-card--notice mt-1">
    <p><strong>Die Bedeutungskarte:</strong> Stellen Sie sich eine Stadtkarte vor. Alle Bäckereien
        liegen nah beieinander, während Auto-Werkstätten in einem ganz anderen Viertel sind. Genau
        das macht die KI mit Wörtern: "Hund" und "Katze" bekommen Koordinaten, die sehr nah
        beieinander liegen, weil es beides Haustiere sind. Das Wort "Auto" hingegen wird meilenweit
        entfernt platziert.</p>
    <p class="mt-1">Dadurch fängt das Modell an, Konzepte zu "verstehen". Es weiß nicht, was ein
        Hund emotional <em>ist</em>, aber es weiß mathematisch ganz genau, in welcher Nachbarschaft
        der Bedeutungen es wohnt.</p>
</div>

<hr>

<h3 class="c1-second mt-1">Phase 3: Pre-Training (Das halbe Internet lesen)</h3>
<p>Wie wird das Modell nun auf dieser Basis schlau? Durch brutale Mengen an Daten. Im sogenannten
    <strong>Pre-Training</strong> (Vortraining) bekommt das Modell Millionen von Büchern, Artikeln
    und Websites "zu lesen". Es hat dabei nur eine einzige, fast schon beängstigend simple Aufgabe:
</p>
<p class="c1-second mt-1" style="font-size: 1.2rem; text-align: center;"><strong>Errate, welches
        Wort als nächstes kommt!</strong></p>

<div class="bg-main2 p-1 mt-1">
    <p>Wenn das Modell den Satz liest: <em>"Der Himmel ist blau, und das Gras ist..."</em>, rechnet
        es fieberhaft alle Wahrscheinlichkeiten aus und tippt basierend auf seiner "Weltkarte" am
        Ende auf "...grün".</p>
</div>
<p class="mt-1">Es macht das nicht einmal, sondern Milliarden Mal. Dadurch lernt das Modell aus
    reinem Kontext nicht nur Grammatik und Faktenwissen, sondern ein extrem tiefes Musterverständnis
    für die Struktur unserer Welt.</p>

<hr>

<h3 class="c1-second mt-1">Phase 4: Fine-Tuning (Von der Bibliothek zum Assistenten)</h3>
<p>Nach dem Pre-Training ist das Modell vollgepackt mit Wissen wie ein riesiges Archiv, aber es
    plappert unkontrolliert drauflos. Es versucht nur, Texte fortzusetzen. Fragen würde es
    vielleicht aus Reflex einfach mit einer Gegenfrage beantworten.</p>

<p>Hier kommt das <strong>Fine-Tuning</strong> ins Spiel, oft mit einer Methode namens <em>RLHF
        (Reinforcement Learning from Human Feedback)</em>.</p>
<div class="ai-card mt-1">
    <p>Menschen stellen dem Modell Fragen, das Modell gibt mehrere Antworten, und die menschlichen
        Trainer bewerten: "Antwort A war sehr hilfreich, Antwort B war unhöflich." So lernt das
        Modell durch Belohnung und Bestrafung (ähnlich wie bei einer Hundeerziehung), sich wie ein
        höflicher, hilfsbereiter Assistent zu verhalten, anstatt nur Wikipedia-Artikel zu imitieren.
    </p>
</div>

<hr>

<h3 class="c1-second mt-1">Phase 5: Reasoning (Das Modell "denkt" laut)</h3>
<p>Die neueste Entwicklung in der Welt der LLMs nennt sich <strong>Reasoning</strong>
    (Schlussfolgern) durch "Chain-of-Thought" (Gedankenkette). Normalerweise platzte ein LLM sofort
    mit der erstbesten Antwort heraus. Bei komplexen Mathe- oder Logikaufgaben führte das oft zu
    peinlichen Aussetzern.</p>

<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>Ohne Reasoning</h4>
        <p>Das Modell muss die Lösung für eine komplexe Textaufgabe in einem einzigen Schritt, oft
            im Bruchteil einer Sekunde, "erraten". Das geht häufig schief, da ihm die Zeit für
            Zwischenschritte fehlt.</p>
    </div>
    <div class="ai-card">
        <h4>Mit Reasoning (Chain-of-Thought)</h4>
        <p>Man zwingt das Modell, "laut zu denken". Es generiert erst verborgene interne Textblöcke
            (Zwischenschritte), zerlegt und analysiert das Problem Schritt für Schritt, plant den
            Weg und erzeugt <em>dann erst</em> die finale Antwort. Genau wie wir Menschen ein
            schwieriges Problem erst auf einem Schmierblatt lösen, bevor wir das Ergebnis sicher
            präsentieren.</p>
    </div>
</div>


<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>