<!DOCTYPE html>
<html>

<head>
    <title>AI 08: Das Ökosystem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/tooltip.js" defer></script>
    <link rel="stylesheet" href="./style.css">
    <script src="./js/bg_net_graph.js" defer></script>
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
                <h4 class="container__title--text">08. Das Ökosystem: RAG und Agenten</h4>
                <span>Was tun, wenn das Gehirn der KI nicht mehr ausreicht?</span>
            </div>

            <div class="panel">
                <div class="panel-content">
                    <h3 class="c1-second mt-1">Einführung: Die Grenzen des reinen Geistes</h3>
                    <p>Ein Large Language Model (LLM) wie im vorherigen Kapitel beschrieben, ist wie ein
                        hochintelligenter Gelehrter, der aber in einem fensterlosen Raum eingesperrt ist. Es hat
                        tausende Bücher gelesen, aber sein Wissen endet genau an dem Tag, an dem sein Training (seine
                        "Lesezeit") abgeschlossen war. Fragt man es nach dem Wetter von heute, muss es raten – und KIs
                        raten leider so überzeugend, dass wir es oft glauben. Dieses Erfinden von Fakten nennt man
                        <strong class="has-tooltip" data-tooltip="Bezeichnet das Phänomen, wenn eine KI überzeugend klingende, aber sachlich falsche oder erfundene Informationen ausgibt.">Halluzination</strong>.</p>

                    <hr>

                    <h3 class="c1-second mt-1">Phase 1: Retrieval-Augmented Generation (RAG)</h3>
                    <p>Wie lösen wir das Problem, dass die KI nicht alles wissen kann und oft halluziniert? Wir geben
                        ihr eine Bibliothek und eine Suchmaschine! Dieses Konzept nennt sich <strong>RAG
                            (Retrieval-Augmented Generation)</strong>.</p>

                    <div class="ai-grid-2 mt-1">
                        <div class="ai-card">
                            <h4 class="c2-second">Ohne RAG (Closed-Book Prüfung)</h4>
                            <p>Die KI muss Fragen aus dem reinen Gedächtnis beantworten. Für Allgemeinwissen
                                funktioniert das gut, aber wenn man nach sehr spezifischen, internen Firmendaten oder
                                tagesaktuellen News fragt, muss sie oft kapitulieren oder erfindet etwas.</p>
                        </div>
                        <div class="ai-card">
                            <h4 class="c2-second">Mit RAG (Open-Book Prüfung)</h4>
                            <p>Bevor die KI antwortet, durchsucht ein externes System (das "Retrieval") eine Datenbank
                                oder das Internet nach relevanten Dokumenten. Diese Dokumente werden der KI quasi als
                                "Spickzettel" der Frage beigefügt. Die KI liest den Spickzettel und formuliert daraus
                                die perfekte Antwort (die "Generation").</p>
                        </div>
                    </div>

                    <div class="ai-card--notice mt-1">
                        <p><strong>Warum RAG die Geschäftswelt revolutioniert:</strong> Anstatt ein eigenes, sündhaft
                            teures LLM nur für die eigene Firma zu trainieren (was Millionen kostet), nutzt man ein
                            fertiges, schlaues Standard-Modell. Durch RAG gibt man diesem Modell bei jeder Frage einfach
                            automatisch die eigenen Firmen-PDFs und Handbücher als Lektüre mit. Die KI wird so zum
                            perfekten, allwissenden Firmen-Mitarbeiter, ohne sensible Daten auswendig lernen zu müssen.
                            <br>
                            Du fragst ChatGPT, dass es dir einen Bericht auf der Arbeit erstellen soll, oder für ein entsprechendes Unternehmen eine Bewerbung schreiben? Verwende einfach ein vortrainiertes LLM (z.B: Llama), füge dem ein RAG hinzu und am Ende muss du nur noch themenspezifische Inhalte übergeben (z.B: die das Stellenangebot oder die Fakten für den Bericht) und das LLM weiß direkt was es tun soll.</p>
                    </div>

                    <hr>

                    <h3 class="c1-second mt-1">Phase 2: Agentische Workflows (Von Denkern zu Machern)</h3>
                    <p>RAG löst das Wissensproblem. Aber die KI ist immer noch passiv. Sie redet nur. Der nächste
                        logische Evolutionsschritt ist es, der KI <strong>Hände</strong> zu geben. Wir nennen das
                        Agenten (Agents).</p>

                    <p>Ein KI-Agent ist ein LLM, das nicht nur Text generieren darf, sondern Zugriff auf
                        <strong>Werkzeuge (Tools)</strong> hat. Es wird nicht mehr nur gefragt "Was ist 524 * 389?",
                        worauf es vielleicht aus Versehen falsch rechnet (denn KIs rechnen nicht, auch Rechenaufgaben werden nur versucht vorherzusehen). Stattdessen nutzt es einen echten
                        Taschenrechner.</p>

                    <div class="bg-main2 p-1 mt-1">
                        <p><strong>Wie ein Agent arbeitet:</strong></p>
                        <ul class="ai-list mt-1">
                            <li><strong>Ziel:</strong> "Buche mir einen Flug nach Tokio für nächsten Freitag."</li>
                            <li><strong>Planung:</strong> Die KI überlegt: "Zuerst muss ich das genaue Datum
                                herausfinden. Dann muss ich eine Flug-Website aufrufen. Dann muss ich nach Tokio
                                suchen."</li>
                            <li><strong>Werkzeugnutzung:</strong> Die KI greift selbstständig auf eine Kalender-App zu,
                                liest das Datum aus, öffnet versteckt einen Browser, sucht den Flug und klickt auf
                                "Buchen".</li>
                            <li><strong>Beobachtung:</strong> Sie prüft, ob die Buchung geklappt hat, und gibt dem
                                Nutzer Bescheid.</li>
                        </ul>
                    </div>

                    <hr>

                    <h3 class="c1-second mt-1">Fazit: Das Ökosystem wächst</h3>
                    <p>Die reine Textgenerierung ist nur noch das "Gehirn" in der Mitte. Drumherum baut sich ein
                        gigantisches Ökosystem auf: Vektordatenbanken als Langzeitgedächtnis (RAG), Suchmaschinen für
                        den externen Input und digitale Werkzeuge für das aktive Handeln in der Welt. Die KI wird vom
                        simplen Chatbot zum autonomen Assistenten.</p>

                </div>
            </div>

            <div class="mt-1" style="display: flex; justify-content: space-between;">
                <a href="ai_07_llm.php"><button class="btn btn--main">&larr; Zurück</button></a>
                <a href="ai_09_xai.php"><button class="btn btn--main">Weiter: Vertrauen & Transparenz &rarr;</button></a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>