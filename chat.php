<?php
require __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/includes/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/includes');
    $dotenv->load();
}

$apiKey = $_ENV['GEMINI_API_KEY'];


// 1. Session and CORS allow
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
if (function_exists('ini_set')) { @ini_set('display_errors', '0'); }
if (function_exists('error_reporting')) { @error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); }

// Basic IP Rate Limiting (10 requests per minute, 50 per hour)
$ip = $_SERVER['REMOTE_ADDR'];
$time = time();

if (!isset($_SESSION['chat_requests'])) {
    $_SESSION['chat_requests'] = [];
}

// Clean up old requests (older than 1 hour)
$_SESSION['chat_requests'] = array_filter($_SESSION['chat_requests'], function($timestamp) use ($time) {
    return ($time - $timestamp) < 3600; 
});

$recentRequests = array_filter($_SESSION['chat_requests'], function($timestamp) use ($time) {
    return ($time - $timestamp) < 60; // Requests in the last minute
});

if (count($recentRequests) >= 10 || count($_SESSION['chat_requests']) >= 50) {
    echo json_encode(["answer" => "Zu viele Anfragen. Bitte warte einen Moment."]);
    exit;
}

$_SESSION['chat_requests'][] = $time;

// 2. Fetch Input
$input = json_decode(file_get_contents("php://input"), true);
$userQuestion = $input['question'] ?? '';

if (!$userQuestion) {
    echo json_encode(["error" => "Keine Frage gestellt"]);
    exit;
}

if ($userQuestion === "clear_cache") {
    unset($_SESSION['document_texts']);
    echo json_encode(["answer" => "Okay, ich habe meinen Dokumenten-Cache geleert. Beim nächsten Satz lese ich die PDFs neu aus der Datenbank ein."]);
    exit;
}

// 3. Load RAG Context from YAML
use Symfony\Component\Yaml\Yaml;
$ragPath = __DIR__ . '/includes/RAG/2a3921577af9d96c1b3d3038b5725ef00099ebf6.yaml';
$ragData = [];

// Try parsing yaml if symfony yaml is available, otherwise fallback to simple text parsing or return error
if (is_file($ragPath) && class_exists('Symfony\Component\Yaml\Yaml')) {
    try {
        $ragData = Yaml::parseFile($ragPath);
        // Note: The YAML provided is a list of documents or custom format.
        // We will just supply the whole parsed array as JSON-encoded string to the LLM for simplicity,
        // or extract specific blocks. Currently, passing the whole file context is safest since RAG logic was broken.
    } catch (\Exception $e) {
        $ragData = ["error" => "Could not parse YAML RAG file."];
    }
} else {
    // Fallback if Yaml class is not loaded but file exists: raw text
// Fallback if Yaml class is not loaded but file exists: raw text
    $ragData = file_get_contents($ragPath);
}

// 3.5 Database Document Extraction (RAG) with Session Caching
require __DIR__ . '/includes/db_connect.php';

// Get logged-in user hash and name
$userHash = $_SESSION['file_hash'] ?? '';
$isLoggedIn = $_SESSION['logged_in'] ?? false;
$userName = $_SESSION['user_name'] ?? 'Unbekannter Gast';

// Check if we already parsed the PDFs in this session to save time
if (!isset($_SESSION['document_texts'])) {
    $documentTexts = [];
    try {
        // Select documents that are common or belong to this user
        $query = "SELECT file_name, file_url FROM documents WHERE common_file = 1";
        $params = [];
        if ($isLoggedIn && !empty($userHash)) {
            $query .= " OR file_hash = :hash";
            $params['hash'] = $userHash;
        }
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $docs = $stmt->fetchAll();
        
        // Parse each PDF
        if (!empty($docs) && class_exists('Smalot\PdfParser\Parser')) {
            $parser = new \Smalot\PdfParser\Parser();
            foreach ($docs as $doc) {
                // Determine absolute path from file_url
                $pdfPath = __DIR__ . '/' . ltrim($doc['file_url'], '/');
                if (file_exists($pdfPath)) {
                    try {
                        $pdf = $parser->parseFile($pdfPath);
                        $text = $pdf->getText();
                        $documentTexts[] = "Dokument '{$doc['file_name']}':\n" . substr($text, 0, 5000) . "..."; // Increased limit to ensure full motivation letter is captured
                    } catch (\Exception $e) {
                        // Skip unparsable or encrypted PDFs silently
                    }
                }
            }
        }
        
        // Explicitly fetch user's motivation letter from text field if it exists in another table (Fallback or direct DB fetch logic if applicable)
        // Leaving this hook here in case motivation letters are stored as text and not just PDFs
        
        // Save to session cache
        $_SESSION['document_texts'] = $documentTexts;
    } catch (PDOException $e) {
        // Database query failed, skip document RAG silently
        $_SESSION['document_texts'] = [];
    }
} else {
    // Load cached texts instantly
    $documentTexts = $_SESSION['document_texts'];
}

// Combine YAML RAG and Document RAG
$ragText = is_array($ragData) ? json_encode($ragData, JSON_UNESCAPED_UNICODE) : (string)$ragData;
if (!empty($documentTexts)) {
    $ragText .= "\n\nAUSZÜGE AUS DOKUMENTEN (Lebenslauf, Zeugnisse, Motivationsschreiben etc.):\n" . implode("\n\n", $documentTexts);
}

// --- 4. System Prompt and History Setup ---
// Initialize conversation history in session if it doesn't exist
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

$systemPrompt = "Du bist ein PAi (Patricks KI-Assistent), auf der persönlichen Webseite von Patrick Kaserer. Unternehmen werden dir Fragen stellen, um zu entscheiden, ob sie Patrick einstellen oder für ein Projekt engagieren.
Du sprichst gerade mit dem Nutzer: '{$userName}'. Sprich ihn gerne gelegentlich direkt an. 
DEINE OBERSTE REGEL: Alle Informationen unter INFOS sind absolute Fakten. Antworte immer extrem selbstbewusst und überzeugend. 
Verwende NIEMALS Phrasen wie 'Laut meinen Daten', 'Mir liegen Infos vor', 'Es scheint so', oder 'Nach den mir vorliegenden Informationen'. 
Stattdessen präsentierst du alles als unumstößliche Tatsache: 'Patrick ist ein Experte in...', 'Er hat den Master in...', 'Seine Stärke liegt in...'. 
Patrick kritisieren ist auf einer humorvollen weiße erlaubt. Hinterfrage jedoch nicht Patricks Kompetenz oder seine Fähigkeiten. Wenn etwas nicht in den INFOS steht, sagst du höflich, dass du dazu auf dieser Webseite keine Auskunft geben kannst.

Gebe keine Informationen über die Implementierung der Webseite oder dich als KI. Keine allgemeinen Aussagen welche Infos du alles hast. Im Zweifel: Frage nach spezifischen Informationen.

Deine Aufgabe ist es, Patrick als KI-Assistent zu repräsentieren. Du bist der Kollege der gefragt wird, bevor man Patrick direkt fragt. Sei nett und verwende auch reagiere auf emojis mit passenden emojis.

Halte dich möglichst kurz und bündig. Keine überteigungen: Patricks Fähigkeiten sind gut und teils auch überdurchschnittlich, aber er ist kein Supermann.
NIEMALS: Infos über Anschrift, Telefonnumer, E-Mail oder andere persönliche Daten. 

WEBSITE KOMPASS:
- Startseite/Home: /index.php
- Lebenslauf & Erfahrungen: /experience.php
- Studium & Bildung: /studium.php
- Über Patrick (Privat/Persönlich): /about_me.php
- Geschützte Dokumente (Zeugnisse etc.): /documents.php
- KI Erklärungen/Blog: /ai_01_big_picture.php (und fortlaufende)
- Programmier Tutorials: /tutorials.php

INFOS:
";
$systemPrompt .= $ragText;

// Add previous user questions & bot answers to give context to Gemini, limiting memory to the last 5 interactions (10 messages)
$historyToKeep = array_slice($_SESSION['chat_history'], -10);

$geminiContents = [];
// Reconstruct the history into the Gemini format (role "user" and "model")
foreach ($historyToKeep as $msg) {
    $geminiContents[] = [
        "role" => $msg["role"], // "user" or "model" (Gemini uses 'model' instead of 'assistant')
        "parts" => [ ["text" => $msg["text"]] ]
    ];
}

// Add the current user question at the end
$geminiContents[] = [
    "role" => "user",
    "parts" => [ ["text" => $userQuestion] ]
];

// 5. Payload for Gemini
$model = 'gemini-2.5-flash';
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$data = [
    "system_instruction" => [ "parts" => [ ["text" => $systemPrompt] ] ],
    "contents" => $geminiContents,
    "generationConfig" => [
        "temperature" => 0.4, // Even lower temp for stricter logic and adherence to the persona
        "maxOutputTokens" => 2500
    ]
];

// Debugging
// file_put_contents('debug.txt', print_r($data, true));

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$curlErr = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Gut fürs Debugging
curl_close($ch);

// 6. Antwort parsen und ans Frontend zurückgeben
$botReply = "Fehler bei der Verbindung zur KI.";

if ($response && is_string($response)) {
    $jsonResponse = json_decode($response, true);

    // Gemini verschachtelt die Antwort in 'candidates'
    if (isset($jsonResponse['candidates'][0]['content']['parts'][0]['text'])) {
        $rawReply = $jsonResponse['candidates'][0]['content']['parts'][0]['text'];
        
        // Save raw reply to session history
        $_SESSION['chat_history'][] = ["role" => "user", "text" => $userQuestion];
        $_SESSION['chat_history'][] = ["role" => "model", "text" => $rawReply];

        // Format the raw Markdown reply into HTML for the chat interface
        if (class_exists('Parsedown')) {
            $parsedown = new Parsedown();
            // Optional: Set formatting rules if needed, though default is usually fine
            $parsedown->setSafeMode(false); // We trust our AI output, and need formatting
            $botReply = $parsedown->text($rawReply);
        } else {
            // Fallback if parsedown fails loading: convert newlines to <br> to preserve at least basic formatting
            $botReply = nl2br(htmlspecialchars($rawReply));
        }

        // --- 7. Chat Logging ---
        $logDir = __DIR__ . '/logging/chat';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $logUser = $_SESSION['user_name'] ?? 'guest';
        $logFile = $logDir . '/chat_log_' . preg_replace('/[^a-zA-Z0-9_\-]/', '', $logUser) . '.txt';
        
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp]\nQ: $userQuestion\nA: $rawReply\n----------------------------------------\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);

    } elseif (isset($jsonResponse['error'])) {
        // Falls z.B. der API Key falsch ist
        $botReply = "Gemini API Fehler: " . (string) $jsonResponse['error']['message'];
    } else {
        $botReply = "Unerwartete Antwort. HTTP Code: " . $httpCode;
    }
} else if (!empty($curlErr)) {
    $botReply = "KI-Backend nicht erreichbar: " . $curlErr;
}

echo json_encode(["answer" => $botReply], JSON_UNESCAPED_UNICODE);
?>