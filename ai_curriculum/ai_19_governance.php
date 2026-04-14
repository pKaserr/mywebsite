<?php
// variables:
$title = "AI Governance, Recht & Impact";
$canonical = "ai_19_governance";
$page_headline = "19. AI Governance, Recht & Impact";
$prev_link = 'ai_18_mlops.php';
$prev_text = 'MLOps & Modell-Lebenszyklus';
$next_link = 'ai_20_communication.php';
$next_text = 'Wissenschaftskommunikation & Stakeholder-Management';

ob_start();
?>

<h3 class="c1-second mt-1">Risikomanagement: Wer bremst, wenn die KI versagt?</h3>
<p>In Deutschland gibt es fünf Level des Autonomen Fahrens. Von einfachen Assistenzsystemen (Level 1) bis zum völlig freien, fahrerlosen Fahren (Level 5). Für jedes dieser Systeme gelten extrem strenge Bedingungen, Fallbacks und Sicherheitssysteme. Denn es geht hier um Menschenleben. Mit jeder weiteren Stufe legen wir die Verantwortung der Fahrt immer weiter in die Hände künstlicher Systeme.</p>

<p>Aber was passiert nun, wenn ein autonomes Fahrzeug einen Unfall verursacht? Schon ab Stufe 3 darf der Fahrer sich von der Fahrt und damit der direkten Verantwortung abwenden. Ist bei einem Crash dann der Mensch schuld, der nicht eingegriffen hat? Der Automobilhersteller? Oder der Programmierer des neuronalen Netzes?</p>

<div class="ai-card mt-1">
    <h4>Die Management-Relevanz</h4>
    <p>Genau an diesem Punkt beginnt echtes Risikomanagement. Für Unternehmen bedeutet das: Bevor ein KI-System kritische Aufgaben übernimmt, müssen die rechtliche Haftung, die Systemgrenzen (OOD - Out of Distribution) und die menschlichen Rückfallebenen geklärt sein. Wer KI in die physische Welt entlässt, ohne diese "Übergabe der Verantwortung" juristisch und technisch wasserdicht zu definieren, riskiert nicht nur Strafen, sondern das Überleben des Unternehmens.</p>
</div>
<p class="mt-1">Dieses Risikomanagement kann auf verschiedenste Arten durchgeführt werden und ist oft mit einem nicht unerheblichen Aufwand und strengen regulatorischen Bestimmungen verbunden. Dass ein autonomes Fahrzeug überhaupt auf deutschen Straßen fahren darf, ist das Ergebnis jahrelanger Forschung, Entwicklung und sehr vieler Tests (und wir sind hierzulande gerade mal bei Stufe 3). Es muss eine Vielzahl von Kriterien erfüllen, um zugelassen zu werden, und am Ende muss der Gesetzgeber den rechtlichen Spielraum festlegen.</p>

<p class="mt-1">Natürlich ist dein Gedanke jetzt sicherlich: <em>"Ich möchte gar kein eigenes Kraftfahrzeug bauen, sondern überlege nur, wie ich meine Förderanlage intelligent steuern oder die Fehlerberichte meiner Maschinen durch KI auswerten lassen kann."</em> Aber auch hier gibt es harte Anforderungen, denen du dich stellen musst. Wenn du Fehlerberichte durch eine KI analysierst und das Modell falsche Schlüsse zieht, droht bei weiteren Ausfällen nicht nur ein massiver finanzieller Schaden. Du riskierst einen Vertrauensverlust bei Mitarbeitern und Kunden, und im schlimmsten Fall kommt es zu Personenschäden. Welche Fehler bei der fehlerhaften Automatisierung von intralogistischen Förderanlagen passieren können, muss ich hier wohl nicht weiter ausführen.</p>

<hr>

<h3 class="c1-second mt-1">Die Checkliste: 5 Leitfragen für vertrauenswürdige KI</h3>
<p>Um diese Risiken zu minimieren, gibt es international anerkannte Standards. Die Expertengruppe der Europäischen Kommission hat Leitlinien für "Trustworthy AI" (Vertrauenswürdige KI) definiert. Bevor du eine KI, oder generell eine tiefgreifende Software, in deinem Unternehmen einführst, solltest du diese fünf Kernfragen klären:</p>

<div class="ai-card mt-1">
    <ul class="ai-list">
        <li><strong><span class="c2-second">Vorrang menschlichen Handelns (Human Agency & Oversight):</span></strong><br>
            Wer hat das letzte Wort? Kann ein Mensch die Entscheidungen der KI jederzeit überstimmen oder abschalten (Fallback-System), oder agiert die Maschine völlig autonom?</li>

        <li><strong><span class="c2-second">Technische Robustheit & Sicherheit (Robustness & Safety):</span></strong><br>
            Was passiert im schlimmsten Fall (Worst-Case-Szenario)? Wie reagiert das System auf völlig unbekannte Daten oder gar auf gezielte Cyberangriffe?</li>

        <li><strong><span class="c2-second">Transparenz & Erklärbarkeit (Transparency):</span></strong><br>
            Wissen die Nutzer, dass sie mit einer KI interagieren? Und können wir nachvollziehen, <em>warum</em> das Modell eine bestimmte Entscheidung getroffen hat (Stichwort: Blackbox vermeiden)?</li>

        <li><strong><span class="c2-second">Rechenschaftspflicht (Accountability):</span></strong><br>
            Wer ist juristisch und moralisch verantwortlich, wenn etwas schiefgeht? Sind die Zuständigkeiten im Unternehmen klar definiert?</li>

        <li><strong><span class="c2-second">Vielfalt & Fairness (Diversity & Non-discrimination):</span></strong><br>
            Benachteiligt das System bestimmte Gruppen von Menschen oder Kunden, weil die historischen Trainingsdaten bereits Vorurteile (Bias) enthielten? Welche Auswirkungen hat die Automatisierung auf die bestehenden Mitarbeiter?</li>
    </ul>
</div>

<hr>

<h3 class="c1-second mt-1">Der rechtliche Rahmen: Der EU AI Act</h3>
<p>Die Möglichkeiten, KI anzuwenden, sind derweil geradezu grenzenlos. Fotorealistische Bilder, generierte Szenen, geklonte Stimmen und Musikstücke. Die Menge an Daten, die benötigt wurde, um diese Fähigkeiten zu erreichen, ist gigantisch. Und das wirft eine entscheidende Frage auf: <strong>Wem gehören eigentlich die Daten, mit denen trainiert wird?</strong></p>

<p>Aktuelle Fälle sorgen für massive Kritik: KIs, die ungefragt unangemessene Bilder von Menschen (Deepfakes) erstellen. Bildgeneratoren, die Wasserzeichen von Stock-Foto-Anbietern reproduzieren und damit offensichtlich machen, dass urheberrechtlich geschütztes Material verwendet wurde. Oder Plattformen und Chatbots (wie beispielsweise auch die Systeme von Google, OpenAI und Co.), deren Nutzungsbedingungen verlangen, dass die Eingaben der User für weiteres Training verwendet werden dürfen.</p>

<div class="ai-grid-2 mt-1">
    <div class="ai-card">
        <h4>Die Antwort der EU</h4>
        <p>Als eine Union, die die Grundrechte und Interessen des Menschen in den Vordergrund stellt, hat die EU mit dem <strong>AI Act</strong> das weltweit erste Regelwerk aufgestellt, das genau diese Fragen angeht. Es kategorisiert KI nach Risikoklassen, verbietet manipulatives Social Scoring und fordert strenge Transparenz bei hochriskanten Systemen.</p>
    </div>
    <div class="ai-card">
        <h4>Was das für Unternehmen heißt</h4>
        <p>Der EU AI Act ist keine reine Formalie. Wenn ein Unternehmen heute ein KI-Produkt baut, dessen Trainingsdaten nachweislich aus Urheberrechtsverletzungen stammen, steht das gesamte Geschäftsmodell auf dem Spiel. Compliance bedeutet hier den Schutz des eigenen geistigen Eigentums und die Sicherstellung, dass die eingesetzte KI rechtmäßig operiert.</p>
    </div>
</div>

<p class="mt-1">
    Da die Daten für das Training aber das A und O sind, ist es wichtig, dir darüber im Klaren zu sein, in wie Weit du diese Verwenden kannst, oder welche Möglichkeiten du hast, um neue Daten zu generieren. Bei der Abhängigkeit von externen Datenanbietern ist es wichtig, dass du dir über die rechtlichen Rahmenbedingungen im Klaren bist. Auch die verwendung von externen KI-Systemen können zum Ausfall führen (z.B. ein System wird verboten, da es z.B. gegen die EU-Richtlinien verstößt) oder sogar schlimmeres.
</p>

<hr>

<h3 class="c1-second mt-1">Sustainability & Social Impact</h3>
<p>Weißt du eigentlich, wie viel sauberes Trinkwasser große Sprachmodelle (LLMs) benötigen, nur um die Serverfarmen während des Trainings zu kühlen? Oder wie viele Monate tausende von Hochleistungs-Grafikkarten unter Volllast rechnen müssen, um ein solches Modell zu erschaffen?</p>

<p>KI ist aktuell ein massiver Energiefresser. <strong>Aber warum eigentlich?</strong> Um ein Modell wie ChatGPT zu trainieren, muss die Mathematik Milliarden von Gewichten (Parametern) anpassen, und das für Billionen von Wörtern (Tokens), wieder und wieder, bis das Netz die Struktur unserer Sprache verstanden hat. Das sind schier unvorstellbare Mengen an Matrixmultiplikationen, die direkt in Stromverbrauch und Abwärme übersetzt werden. <br> Als Anwender solcher Technik ist es entsprechend wichtig, sich über die Auswirkungen im Klaren zu sein und das nicht nur aus rein ethischen Gründen, sondern auch aus wirtschaftlichen.</p>

<div class="ai-card--notice mt-1">
    <h4>Der gesellschaftliche Deal: Energie gegen Fortschritt</h4>
    <p>Wird das immer so bleiben? Die Forschung arbeitet bereits unter Hochdruck an effizienteren Architekturen, spezieller Hardware und deutlich kleineren Modellen, die einen Bruchteil der Energie benötigen. <br><br>
        Bis dahin stehen wir vor einer Abwägung: Auf der einen Seite die ökologischen Kosten, auf der anderen Seite eine unglaublich mächtige Erfindung. Wenn wir KI nutzen, um in der medizinischen Forschung Durchbrüche zu erzielen, den öffentlichen Sektor handlungsfähiger zu machen oder nachhaltige Technologien zu entwickeln, ist dieser Energieeinsatz gerechtfertigt. Technologie trägt immer eine Verantwortung. Ihr wahrer Wert misst sich daran, wie sie der Gesellschaft langfristig dient.</p>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>