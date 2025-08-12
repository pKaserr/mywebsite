<?php
/**
 * Lightweight diagnostics endpoint to determine absolute paths and logging capability on shared hosting.
 * Protected by a simple token in query string to avoid exposing details publicly.
 *
 * Usage: /whereami.php?token=SET_A_SECRET
 */

// Configure a simple access token to prevent accidental exposure
$token = 'SET_A_SECRET'; // CHANGE THIS BEFORE USING

if (!isset($_GET['token']) || !hash_equals($token, (string)$_GET['token'])) {
    http_response_code(404);
    exit;
}

header('Content-Type: text/plain; charset=UTF-8');

/**
 * Print a line in a consistent format
 *
 * @param string $label Descriptive label
 * @param string $value Value to print
 * @return void
 */
function line(string $label, string $value): void {
    echo $label . ': ' . $value . "\n";
}

$docroot = isset($_SERVER['DOCUMENT_ROOT']) ? (string)$_SERVER['DOCUMENT_ROOT'] : '';
$dir = __DIR__;
$logsDir = $dir . '/logging';
$logsDirReal = (string)@realpath($logsDir);
$iniLogErrors = (string)ini_get('log_errors');
$iniErrorLog = (string)ini_get('error_log');

echo "=== PATHS ===\n";
line('DOCUMENT_ROOT', $docroot ?: '(empty)');
line('__DIR__', $dir);
line('realpath(__DIR__/logging)', $logsDirReal ?: '(not resolvable)');
echo "\n";

echo "=== PERMISSIONS ===\n";
line('is_dir(logging)', is_dir($logsDir) ? 'yes' : 'no');
line('is_writable(logging)', is_writable($logsDir) ? 'yes' : 'no');
if (is_dir($logsDir)) {
    $testFile = $logsDir . '/whereami_write_test.txt';
    $writeOk = @file_put_contents($testFile, 'write-test ' . date('c') . "\n", FILE_APPEND | LOCK_EX);
    line('file_put_contents(logging/whereami_write_test.txt)', $writeOk !== false ? 'ok' : 'fail');
}
echo "\n";

echo "=== INI ===\n";
line('log_errors', $iniLogErrors !== '' ? $iniLogErrors : '(empty)');
line('error_log', $iniErrorLog !== '' ? $iniErrorLog : '(empty)');
echo "\n";

echo "=== ERROR_LOG TEST ===\n";
$err = error_log('whereami.php test line @ ' . date('c'));
line('error_log()', $err ? 'reported true' : 'reported false');
echo "\n";

echo "=== NEXT STEPS ===\n";
echo "1) Setze in .user.ini: error_log=<ABSOLUTER_PFAD_ZU>/logging/php_errors.log\n";
echo "   (Nutze den oben angezeigten DOCUMENT_ROOT oder __DIR__ als Basis)\n";
echo "2) Warte einige Minuten (INI Cache), dann erneut Formular testen.\n";
echo "3) Lösche whereami.php wieder.\n";

exit;
?>


