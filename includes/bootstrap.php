<?php
/**
 * Application bootstrap for consistent runtime configuration.
 * Unifies error logging to the project's logging directory across environments.
 */

// Determine project root (one level above this file)
$projectRoot = dirname(__DIR__);
$logsDir = $projectRoot . DIRECTORY_SEPARATOR . 'logging';

// Ensure logs directory exists
if (!is_dir($logsDir)) {
    @mkdir($logsDir, 0775, true);
}
@chmod($logsDir, 0775);

// Expose logging paths to the rest of the app
if (!defined('APP_LOG_DIR')) {
    define('APP_LOG_DIR', $logsDir);
}
if (!defined('APP_LOG_FILE')) {
    define('APP_LOG_FILE', APP_LOG_DIR . DIRECTORY_SEPARATOR . 'app.log');
}

// Choose the best writable log target
$targetLogFile = $logsDir . DIRECTORY_SEPARATOR . 'php_errors.log';
$finalLogFile = $targetLogFile;

// Try to ensure the log file exists and is writable
$testWriteOk = false;
if (is_dir($logsDir) && is_writable($logsDir)) {
    $testWriteOk = @file_put_contents($targetLogFile, "\n", FILE_APPEND | LOCK_EX) !== false;
}

// Fallback to document root if logging/ is not writable (ensures we don't lose logging on live)
if (!$testWriteOk) {
    $docroot = isset($_SERVER['DOCUMENT_ROOT']) ? (string)$_SERVER['DOCUMENT_ROOT'] : $projectRoot;
    $fallbackFile = rtrim($docroot, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'php_error_log';
    // Best effort create/fallback
    @file_put_contents($fallbackFile, "\n", FILE_APPEND | LOCK_EX);
    $finalLogFile = $fallbackFile;
}

// Route PHP error logging (runtime) to the resolved target
@ini_set('log_errors', '1');
@ini_set('error_log', $finalLogFile);

// If host blocks setting error_log, ensure we still have our own app-level log
@file_put_contents(APP_LOG_FILE, '[' . date('c') . "] bootstrap initialized\n", FILE_APPEND | LOCK_EX);
// Also mirror a bootstrap marker via error_log for environments that route to provider logs
@error_log('bootstrap initialized');

// Enable enhanced error handling (writes into logging/error.log with fallback)
require_once __DIR__ . '/error_handler.php';

if (!function_exists('app_log')) {
    /**
     * Lightweight application logger that writes regardless of PHP error_log settings.
     * @param string $message Message to write
     * @return void
     */
    function app_log(string $message): void {
        $line = sprintf('[%s] %s %s%s',
            date('Y-m-d H:i:s'),
            $_SERVER['REQUEST_METHOD'] ?? 'CLI',
            $_SERVER['REQUEST_URI'] ?? '',
            PHP_EOL
        );
        @file_put_contents(APP_LOG_FILE, $line . $message . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

// Optional: set default timezone if not configured by php.ini
if (!ini_get('date.timezone')) {
    @date_default_timezone_set('Europe/Berlin');
}

// Emit a lightweight marker once per request when needed by callers
// error_log('bootstrap initialized');

?>


