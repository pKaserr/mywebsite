<?php
// variables:
$title = "Die Transformer-Revolution";
$page_headline = "06. Die Transformer-Revolution";
$prev_link = 'ai_05_vision.php';
$prev_text = 'Zurück: Computer Vision';
$next_link = 'ai_07_llm.php';
$next_text = 'Weiter: LLMs & Reasoning';
ob_start();
?>


<h3 class="c1-second mt-1">Einführung: Sprache ist Zeit, nicht Raum</h3>
<p>In Modul 05 haben wir gelernt, wie KI Bilder verarbeitet. Ein Bild ist statisch. Alle Pixel sind gleichzeitig da. Sprache hingegen ist dynamisch und sequenziell. Ein Satz entfaltet seine Bedeutung erst über die Zeit, Wort für Wort.</p>
<p>Für lange Zeit war das die größte Hürde der Künstlichen Intelligenz. Wie bringt man einem neuronalen Netz bei, sich den Anfang eines langen Satzes zu merken, wenn es am Ende angekommen ist?</p>

<hr>

<h3 class="c1-second mt-1">Phase 1: Das Problem der Rekursion (RNNs)</h3>
<p>Vor dem Jahr 2017 nutzte man für Text sogenannte <strong>Recurrent Neural Networks (RNNs)</strong>. "Recurrent" bedeutet rückläufig oder wiederkehrend. Das Netz las einen Satz exakt so wie wir Menschen: Wort für Wort, von links nach rechts.</p>

<div class="ai-card mt-1">
    <h4>Der Flaschenhals der alten Netze</h4>
    <p>Wenn ein RNN das fünfte Wort eines Satzes verarbeitete, musste es warten, bis die Berechnungen für die ersten vier Wörter abgeschlossen waren. Es baute eine Art internes Gedächtnis auf, das es von Schritt zu Schritt weiterreichte (die Rekursion).</p>
    <p>Das führte zu zwei massiven Problemen:</p>
    <ul class="ai-list mt-1">
        <li><strong>Das Vergessen:</strong> Bei sehr langen Texten "verblasste" die Information der ersten Wörter. Wenn auf Seite 1 stand, dass der Protagonist "Thomas" heißt, wusste das Netz auf Seite 3 oft schon nicht mehr, auf wen sich das Wort "er" bezog.</li>
        <li><strong>Der Rechen-Stau:</strong> Moderne Grafikkarten (GPUs) sind unglaublich schnell, weil sie Tausende Rechnungen <em>gleichzeitig</em> (parallel) ausführen. Ein RNN zwingt die GPU aber zum Warten. Schritt 2 kann erst starten, wenn Schritt 1 fertig ist. Das Training dauerte ewig.</li>
    </ul>
</div>

<hr>

<h3 class="c1-second mt-1">Phase 2: Der Paradigmenwechsel (Attention Is All You Need)</h3>
<p>Im Jahr 2017 veröffentlichten Forscher von Google ein Paper, das die KI-Welt für immer veränderte. Der Titel: <em>"Attention Is All You Need"</em>. Sie warfen die Rekursion komplett über Bord und erfanden die <strong>Transformer-Architektur</strong>.</p>

<div class="ai-card--notice mt-1">
    <p><strong>Die geniale Idee:</strong> Ein Transformer liest nicht mehr Wort für Wort von links nach rechts. Er nimmt den <em>gesamten</em> Satz (oder sogar ganze Buchseiten) und wirft ihn auf einen Schlag, komplett gleichzeitig, in das neuronale Netz. Der Rechen-Stau war gelöst, die GPUs konnten ihre volle parallele Power ausspielen. Dies ist der einzige Grund, warum Modelle wie ChatGPT heute mit Milliarden von Texten in Rekordzeit trainiert werden können.</p>
</div>

<hr>

<h3 class="c1-second mt-1">Phase 3: Self-Attention (Wer gehört zu wem?)</h3>
<p>Wenn das Netz nun alle Wörter gleichzeitig anschaut, woher weiß es dann noch, welches Wort zu welchem gehört? Die Lösung ist der sogenannte <strong>Self-Attention Mechanismus (Selbst-Aufmerksamkeit)</strong>.</p>

<p>Wörter haben selten eine feste Bedeutung. Ihre Bedeutung entsteht erst durch ihre Nachbarn. Betrachten wir diesen berühmten Beispielsatz:</p>

<div class="bg-main2 p-1 mt-1">
    <p><em>"Das Tier überquerte die Straße nicht, weil <strong>es</strong> zu müde war."</em></p>
</div>

<p class="mt-1">Worauf bezieht sich das Wort <strong>"es"</strong>? Auf das Tier oder auf die Straße? Für uns Menschen ist das logisch klar (die Straße kann nicht müde sein). Aber woher weiß die KI das?</p>

<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>Wie Self-Attention rechnet</h4>
        <p>Das Netz nimmt jedes einzelne Wort im Satz und fragt jedes andere Wort im selben Satz: <em>"Wie stark hängst du inhaltlich mit mir zusammen?"</em></p>
        <p>Mathematisch geschieht das wieder durch Matrizen und Gewichte. Wenn das Modell beim Wort <strong>"es"</strong> ankommt, berechnet es die Aufmerksamkeit (Attention-Scores) zu allen anderen Wörtern.</p>
    </div>

    <div class="ai-card">
        <h4>Das Ergebnis</h4>
        <p>Das Netz lernt durch Backpropagation, dass die Eigenschaft "müde" stark mit Lebewesen ("Tier") und schwach mit Asphalt ("Straße") korreliert. Die mathematische Verbindung (der Attention-Score) zwischen "es" und "Tier" leuchtet stark auf, die Verbindung zu "Straße" bleibt dunkel.</p>
    </div>
</div>

<hr>

<h3 class="c1-second mt-1">Phase 4: Der Kontext ist König</h3>
<p>Durch Self-Attention bekommt jedes Wort ein tiefes Verständnis für seinen Kontext. Wenn du das Wort "Bank" in das Netz gibst, weiß es erst einmal nicht, ob es sich um ein Geldinstitut oder eine Sitzgelegenheit handelt.</p>

<p>Aber weil der Transformer alle Wörter des Satzes <em>gleichzeitig</em> durch den Self-Attention-Mechanismus jagt, "färben" die Nachbarwörter auf das Wort ab. Steht "Bank" neben Wörtern wie "Park", "sitzen" und "Holz", verändert sich die mathematische Repräsentation (die Zahlenwerte) des Wortes "Bank" sofort in eine völlig andere Richtung, als wenn dort "Geld", "Konto" und "Zinsen" stehen würde.</p>

<div class="ai-card--notice mt-1">
    <p><strong>Fazit:</strong> Die Transformer-Architektur hat der KI beigebracht, Texte nicht mehr als starre Perlenkette zu betrachten, sondern als ein dichtes Netz aus Beziehungen. Jedes Wort weiß zu jedem Zeitpunkt, welche anderen Wörter im Text für seine eigene Bedeutung gerade am wichtigsten sind.</p>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>