<head>
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="stylesheet" href="../style.css">
    <link href="../code.css" rel="stylesheet" />
    <link rel="stylesheet" href="../katex.css">
    <script src="../js/bg_net_graph.js" defer></script>
    <script src="../js/tooltip.js" defer></script>
    <script src="../js/code.js" defer></script>
    <script src="../js/accordion.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js" defer></script>
    <script src="../js/katex.js" defer></script>
    <script src="../js/auto_render.js" onload="renderMathInElement(document.body);" defer></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Wir rufen die Funktion aus der min.js auf und übergeben unser eigenes Regelwerk
            renderMathInElement(document.body, {
                delimiters: [
                    { left: "$$", right: "$$", display: true },  // Für zentrierte Blöcke
                    { left: "$", right: "$", display: false },   // Das hier aktiviert dein Inline-Mathe!
                    { left: "\\(", right: "\\)", display: false },
                    { left: "\\[", right: "\\]", display: true }
                ],
                throwOnError: false
            });
        });
    </script>
</head>