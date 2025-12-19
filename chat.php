<?php
// chat.php

// 1. CORS erlauben (wichtig für lokales Testen)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
if (function_exists('ini_set')) { @ini_set('display_errors', '0'); }
if (function_exists('error_reporting')) { @error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); }

// 2. Eingabe empfangen
$input = json_decode(file_get_contents("php://input"), true);
$userQuestion = $input['question'] ?? '';

if (!$userQuestion) {
    echo json_encode(["error" => "Keine Frage gestellt"]);
    exit;
}

$context = [];
$ragPath = __DIR__ . '/includes/RAG/2a3921577af9d96c1b3d3038b5725ef00099ebf6.json';
if (is_file($ragPath)) {
    $decoded = json_decode(file_get_contents($ragPath) ?: '[]', true);
    if (is_array($decoded)) { $context = $decoded; }
}

// aufbau der json:
//  "praktische Erfahrungen": {
//      "Company Name": {
//          "position": "###",
//          "date": "###",
//          "description": "###",
//          "tags": "###"
//      }
//  }
$experiences = isset($context['praktische Erfahrungen']) && is_array($context['praktische Erfahrungen']) ? $context['praktische Erfahrungen'] : [];

$norm = function($s) { return mb_strtolower((string)$s, 'UTF-8'); };
$containsAny = function($text, $words) use ($norm) { $t = $norm($text); foreach ($words as $w) { if ($w !== '' && strpos($t, $norm($w)) !== false) { return true; } } return false; };
$scoreMatch = function($text, $words) use ($norm) { $t = $norm($text); $score = 0; foreach ($words as $w) { $w = $norm($w); if ($w !== '' && strpos($t, $w) !== false) { $score++; } } return $score; };

$q = (string)$userQuestion;
$aiWords = ['ki','künstliche intelligenz','ai','ml','machine learning','deep learning','neural','neuronale','pytorch','tensorflow','cuda','nerf','lidar'];
$webWords = ['web','website','wordpress','css','scss','html','javascript','js','php','sql','react'];
$teachWords = ['lehre','dozent','hochschule','kurs','creative coding','unterricht','prüfungen','student'];

$cat = 'general';
if ($containsAny($q, $aiWords)) { $cat = 'ai'; }
elseif ($containsAny($q, $webWords)) { $cat = 'web'; }
elseif ($containsAny($q, $teachWords)) { $cat = 'teach'; }

$contextItems = [];
foreach ($experiences as $company => $entry) {
    $pos = $entry['position'] ?? '';
    $date = $entry['date'] ?? '';
    $desc = $entry['description'] ?? '';
    $tags = $entry['tags'] ?? '';
    $text = $company . ' ' . $pos . ' ' . $date . ' ' . $desc . ' ' . $tags;
    $words = $cat === 'ai' ? $aiWords : ($cat === 'web' ? $webWords : ($cat === 'teach' ? $teachWords : []));
    $score = $scoreMatch($text, $words) + $scoreMatch($text, preg_split('/\s+/u', $q));
    $contextItems[] = ['company' => $company, 'position' => (string)$pos, 'date' => (string)$date, 'description' => (string)$desc, 'tags' => (string)$tags, 'score' => $score];
}

usort($contextItems, function($a, $b) { return $b['score'] <=> $a['score']; });
$limit = $cat === 'general' ? 2 : 4;
$contextItems = array_slice($contextItems, 0, $limit);

$trim = function($s, $max) { $s = (string)$s; return mb_strlen($s, 'UTF-8') > $max ? mb_substr($s, 0, $max, 'UTF-8') . '…' : $s; };

$contextString = '';
foreach ($contextItems as $it) {
    $contextString .= "Firma: {$it['company']}\n";
    $contextString .= "Position: {$it['position']}\n";
    $contextString .= "Datum: {$it['date']}\n";
    $contextString .= "Beschreibung: " . $trim($it['description'], 600) . "\n";
    $contextString .= "Tags: {$it['tags']}\n\n";
}


// 3. DEIN LEBENSLAUF / WISSEN (Hier passiert das "RAG")
// Tipp: Du kannst das später auch aus einer .txt Datei laden
// $context = "
//     Name: Patrick
//     Rolle: Bewerber als AI Engineer / Web Developer.
//     Tech Stack: PHP, SCSS, JavaScript, Python (CNNs, MNIST).
//     Stärken: Lernt schnell, pragmatisch, versteht sowohl Web als auch AI.
//     Projekt 1: Zahlenerkennung mit CNN auf MNIST Datensatz.
//     Motivation: Will KI-Anwendungen bauen, die echten Nutzen bringen.
//     Stil: Antworte höflich, professionell, aber locker. Duzen.
// ";

// 4. Der Prompt Engineering Teil
$systemPrompt = "Du bist ein KI-Assistent für Patrick. Nutze nur die relevanten Informationen aus INFOS basierend auf der Frage. Antworte kompakt und ohne irrelevante Details. Erfinde nichts.\n\nINFOS:\n" . $contextString;

// 5. Anfrage an Ollama senden (läuft lokal auf Port 11434)
$data = [
    "model" => "llama3.2",
    "stream" => false, // Wichtig: Wir wollen die ganze Antwort sofort, keinen Stream
    "messages" => [
        ["role" => "system", "content" => $systemPrompt],
        ["role" => "user", "content" => $userQuestion]
    ]
];

$ch = curl_init('http://127.0.0.1:11434/api/chat');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$curlErr = curl_error($ch);
curl_close($ch);

// 6. Antwort an dein Frontend zurückgeben
$botReply = "Fehler bei der Verbindung zur KI.";
if ($response && is_string($response)) {
    $jsonResponse = json_decode($response, true);
    if (is_array($jsonResponse) && isset($jsonResponse['message']['content'])) {
        $botReply = (string)$jsonResponse['message']['content'];
    } elseif (isset($jsonResponse['error'])) {
        $botReply = "KI-Backend Fehler: " . (string)$jsonResponse['error'];
    } else {
        $botReply = "Unerwartete Antwort vom KI-Backend.";
    }
} else if (!empty($curlErr)) {
    $botReply = "KI-Backend nicht erreichbar: " . $curlErr;
}

echo json_encode(["answer" => $botReply], JSON_UNESCAPED_UNICODE);
?>
