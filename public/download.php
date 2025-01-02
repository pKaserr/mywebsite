<?php
session_start();

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: index.php");
    exit();
}

// Whitelist erlaubter Dateien
$allowedFiles = [
    'ddskjIJJjkfji565awd' => __DIR__ . '/downloads/protected/basic/Lebenslauf_patrick_kaserer.pdf',
    '5wek353kkkj3ak4das5' => __DIR__ . '/protected/Motivationsschreiben.pdf',
];

// Datei aus dem Parameter "file" erhalten
if (isset($_GET['file']) && array_key_exists($_GET['file'], $allowedFiles)) {
    $filePath = $allowedFiles[$_GET['file']];
    $fileName = basename($filePath);

    // Prüfen, ob die Datei existiert
    if (file_exists($filePath)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit();
    } else {
        echo "Datei nicht gefunden.";
        exit();
    }
} else {
    echo "Ungültige Anfrage.";
    exit();
}
