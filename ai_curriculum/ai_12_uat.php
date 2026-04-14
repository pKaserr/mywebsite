<?php
// variables:
$title = "Universelle Approximations Theorem";
$canonical = "ai_12_uat";
$page_headline = "12. Universeller Approximations Theorem";
$prev_link = 'ai_11_activation.php';
$prev_text = 'Aktivierungsfunktionen';
$next_link = 'ai_epilog.php';
$next_text = 'Epilog: Die KI-Blase';

ob_start();
?>

<h3 class="c1-second mt-1">Alles in unserem Universum ist eine Funktion</h3>
<p>Wenn wir das Wort "Funktion" hören, denken wir meist an Schulmathematik und Kurven in Graphen. Aber in der Informatik ist eine Funktion einfach nur eine magische Box: Du wirfst vorne etwas hinein (Input <i>X</i>) und hinten kommt ein Ergebnis heraus (Output <i>Y</i>). Ganz egal wie komplex das innere dieser Box ist, wichtig ist nur: Gleicher Input und gleicher Output.</p>
<div class="ai-card mt-1">
    <h3>Beispiele aus dem Alltag:</h3>
    <ul class="ai-list">
        <li><strong>Medizin:</strong> Input: Röntgenbild &rarr; Output: "Gesund" oder "Krank".</li>
        <li><strong>Sprache:</strong> Input: "verschlüsselte Nachricht" &rarr; Output: "Verständliche Information".</li>
        <li><strong>Autonomes Fahren:</strong> Input: Videobild der Straße &rarr; Output: "Lenkrad um 15 Grad nach links drehen".</li>
    </ul>
</div>
<p class="mt-1">Hinter jedem dieser Probleme steckt eine Regel, die Input in Output übersetzt und genau diese Regel ist, mathematisch gesehen, eine Funktion. Solange es irgendeinen Zusammenhang zwischen Input und Output gibt, existiert irgendwo im mathematischen Raum eine Funktion, die diesen Zusammenhang beschreibt, auch wenn wir sie nicht kennen.</p>


<hr>

<h3 class="c1-second mt-1">Die Annährung der Realität</h3>
<p>Warum investieren Firmen Milliarden in künstliche neuronale Netze? Weil sie sich auf ein fundamentales Prinzip stützen: Das <strong>Universelle Approximations-Theorem (UAT)</strong>.</p>

<div class="ai-card mt-1">
    <h4>Was das Theorem genau besagt:</h4>
    <p>Ein neuronales Netz kann sich jeder beliebigen, <span class="has-tooltip" data-tooltip="Vereinfacht gesagt: Die Funktion macht keine plötzlichen, unendlichen Sprünge.">stetigen</span> Funktion der echten Welt beliebig genau <strong>annähern</strong> (sie approximieren), vorausgesetzt, es verfügt über <strong>mindestens eine versteckte Schicht</strong> (Hidden Layer) mit genügend Neuronen und nutzt eine nicht-lineare Aktivierungsfunktion.</p>
</div>

<p class="mt-1">Es geht hier nicht um eine absolut fehlerfreie, perfekte 1 zu 1 Kopie der Realität. "Approximieren" bedeutet, dass das Netz der echten Funktion so unfassbar nahe kommt, dass der winzige Restfehler für uns in der Praxis keine Rolle mehr spielt.</p>
<p class="mt-1">Erinnerst du dich an die ReLU-Funktion aus dem vorherigen Kapitel? Ein einzelnes Neuron in der versteckten Schicht erzeugt nur einen simplen Knick. Aber wenn du abertausende dieser kleinen Knicke kombinierst, kannst du damit die Umrisse jedes noch so komplexen Problems lückenlos nachzeichnen. Das Netz formt seine Mathematik so lange, bis sie sich wie eine passgenaue Schablone an unsere Realität anschmiegt. Man kann sich das vorstellen wie ein Polygon, das einen Kreis approximiert: Mit wenigen Ecken ist es noch grob, mit sehr vielen Ecken wird es nahezu perfekt rund.</p>

<hr>

<h3 class="c1-second mt-1">Der Haken an der Sache: Theorie vs. Realität</h3>
<p>Wenn das wahr ist, warum haben wir dann noch keine allwissende Super-KI, die jedes Problem der Menschheit löst? Hier kommt die Realität ins Spiel, die uns auf den Boden der Tatsachen zurückholt:</p>

<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>Die Garantie zur Existenz</h4>
        <p>Das Theorem beweist lediglich, dass die perfekte Anordnung von Gewichten für dein Problem <strong>existiert</strong>. Es ist wie die Gewissheit, dass irgendwo im Pazifik eine Kiste Gold liegt. Wir wissen also: Die Lösung gibt es, aber das hilft uns noch nicht, sie auch zu finden.</p>
    </div>
    <div class="ai-card">
        <h4>Das Finden ist das Problem</h4>
        <p>Das Theorem sagt uns leider <strong>nicht</strong>, wie wir diese Kiste finden. Das Anpassen von Milliarden Gewichten (Training) dauert ewig, verschlingt unfassbare Mengen an Strom, benötigt riesige Datensätze und bleibt oft im falschen Tal stecken.</p>
    </div>
</div>

<div class="ai-card--notice mt-1">
    <p><strong>Der Kreis schließt sich:</strong> Wir wissen nun, dass künstliche Intelligenz keine Magie und kein lebendiges Gehirn ist. Sie ist die brillanteste mathematische Schablone, die die Menschheit je erfunden hat. Gib ihr genug Beispiele (Daten) und genug Zeit (Training), und sie verbiegt ihre Milliarden kleinen Knicke so lange, bis sie die Form unserer Realität perfekt nachahmt.</p>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>