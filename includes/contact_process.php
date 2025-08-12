<?php
/**
 * Contact form processing script
 * Handles form submissions from the footer contact form
 */

require_once __DIR__ . '/bootstrap.php';
session_start();
// Start output buffering to avoid 'headers already sent' issues on shared hosting
if (function_exists('ob_start')) { @ob_start(); }

error_log("Contact form: entered contact_process.php");
if (function_exists('app_log')) { app_log('contact_process: entered'); }
// Ensure a writable logs directory and robust runtime error logging on shared hosting
$__logsDir = __DIR__ . '/../logging';
if (!is_dir($__logsDir)) {
    @mkdir($__logsDir, 0775, true);
}

// Optional: load Composer autoloader if available (for PHPMailer/Dotenv)
$__autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (file_exists($__autoloadPath)) {
    require_once $__autoloadPath;
}
// Optional: load .env from includes for SMTP credentials if available
if (class_exists('Dotenv\\Dotenv') && file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Configuration
$config = [
    'recipient_email' => 'patrick.kaserer@gmail.com',
    'subject_prefix' => 'Kontakt von Website: ',
    'success_message' => 'Vielen Dank für Ihre Nachricht! Ich werde mich bald bei Ihnen melden.',
    'error_message' => 'Es gab einen Fehler beim Senden Ihrer Nachricht. Bitte versuchen Sie es später erneut.',
    'validation_errors' => [
        'name' => 'Bitte geben Sie einen gültigen Namen ein.',
        'email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
        'message' => 'Bitte geben Sie eine Nachricht ein.'
    ]
];

// Helper functions
/**
 * Sanitize input data
 * @param string $data Input data to sanitize
 * @return string Sanitized data
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email address
 * @param string $email Email to validate
 * @return bool True if valid
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Simple spam detection
 * @param array $data Form data
 * @return bool True if likely spam
 */
function isLikelySpam($data) {
    // Check for common spam patterns
    $spamWords = ['viagra', 'casino', 'loan', 'bitcoin', 'crypto'];
    $text = strtolower($data['name'] . ' ' . $data['message']);
    
    foreach ($spamWords as $word) {
        if (strpos($text, $word) !== false) {
            return true;
        }
    }
    
    // Check for excessive links
    $linkCount = preg_match_all('/https?:\/\//', $data['message']);
    if ($linkCount > 2) {
        return true;
    }
    
    return false;
}

// Initialize response
$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

// Safe redirect helper with fallbacks if headers were already sent
if (!function_exists('safeRedirect')) {
    /**
     * Perform a redirect safely, with HTML/JS fallback if headers are already sent.
     * @param string $url Destination URL
     * @return void
     */
    function safeRedirect(string $url): void {
        $finalUrl = $url;
        if (!headers_sent()) {
            header('Location: ' . $finalUrl, true, 303);
            if (function_exists('ob_get_level')) {
                while (ob_get_level() > 0) { @ob_end_clean(); }
            }
            exit;
        }
        echo '<meta http-equiv="refresh" content="0;url=' . htmlspecialchars($finalUrl, ENT_QUOTES, 'UTF-8') . '">';
        echo '<script>window.location.replace(' . json_encode($finalUrl) . ');</script>';
        exit;
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Marker to verify script execution and POST handling
        error_log('Contact form: entered POST branch');
        if (function_exists('app_log')) { app_log('contact_process: POST branch'); }
        // Get and sanitize form data
        $name = sanitizeInput($_POST['name'] ?? '');
        $email = sanitizeInput($_POST['email'] ?? '');
        $message = sanitizeInput($_POST['message'] ?? '');
        
        // Validation
        $errors = [];
        
        if (empty($name) || strlen($name) < 2) {
            $errors['name'] = $config['validation_errors']['name'];
        }
        
        if (empty($email) || !validateEmail($email)) {
            $errors['email'] = $config['validation_errors']['email'];
        }
        
        if (empty($message) || strlen($message) < 10) {
            $errors['message'] = $config['validation_errors']['message'];
        }
        
        // Check for spam
        if (isLikelySpam(['name' => $name, 'message' => $message])) {
            $errors['spam'] = 'Ihre Nachricht wurde als Spam erkannt.';
        }
        
        if (!empty($errors)) {
            $response['errors'] = $errors;
            $response['message'] = 'Bitte korrigieren Sie die folgenden Fehler:';
        } else {
            // Prepare email
            $subject = $config['subject_prefix'] . $name;
            $emailBody = "Neue Kontaktanfrage von der Website:\n\n";
            $emailBody .= "Name: $name\n";
            $emailBody .= "E-Mail: $email\n";
            $emailBody .= "Nachricht:\n$message\n\n";
            $emailBody .= "---\n";
            $emailBody .= "Gesendet am: " . date('d.m.Y H:i:s') . "\n";
            $emailBody .= "IP-Adresse: " . ($_SERVER['REMOTE_ADDR'] ?? 'Unbekannt') . "\n";
            
            // Email headers (use domain-based sender to satisfy SPF/DMARC)
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $domain = preg_replace('/^www\./', '', $host);
            $fromAddress = "no-reply@{$domain}";

            // Guard against header injection in user-supplied email
            $safeReplyTo = preg_replace("/\r|\n/", '', $email);

            $headers = [
                'From' => $fromAddress,
                'Reply-To' => $safeReplyTo,
                'X-Mailer' => 'PHP/' . phpversion(),
                'Content-Type' => 'text/plain; charset=UTF-8'
            ];
            
            $headerString = '';
            foreach ($headers as $key => $value) {
                $headerString .= "$key: $value\r\n";
            }
            
            // Attempt to send email via SMTP (PHPMailer) if configured; otherwise fallback to mail()
            $mailSent = false;
            $sendError = '';
            $sendVia = 'mail()';

            $smtpHost = $_ENV['SMTP_HOST'] ?? '';
            $smtpPort = (int)($_ENV['SMTP_PORT'] ?? 0);
            $smtpUser = $_ENV['SMTP_USER'] ?? '';
            $smtpPass = $_ENV['SMTP_PASS'] ?? '';
            $smtpSecure = strtolower($_ENV['SMTP_SECURE'] ?? ''); // ssl|tls|''
            $smtpFrom = $_ENV['SMTP_FROM'] ?? $fromAddress;

            if (class_exists('PHPMailer\\PHPMailer\\PHPMailer') && $smtpHost && $smtpUser && $smtpPass) {
                try {
                    $mailer = new PHPMailer\PHPMailer\PHPMailer(true);
                    $mailer->CharSet = 'UTF-8';
                    $mailer->isSMTP();
                    $mailer->Host = $smtpHost;
                    $mailer->SMTPAuth = true;
                    $mailer->Username = $smtpUser;
                    $mailer->Password = $smtpPass;
                    if ($smtpPort > 0) { $mailer->Port = $smtpPort; }
                    if ($smtpSecure === 'ssl') {
                        $mailer->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                    } elseif ($smtpSecure === 'tls') {
                        $mailer->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    }
                    // Capture SMTP debug output into log
                    $smtpDebugBuffer = '';
                    $mailer->SMTPDebug = 2; // client + server messages
                    $mailer->Debugoutput = function($str) use (&$smtpDebugBuffer) {
                        $smtpDebugBuffer .= $str . "\n";
                    };
                    // Ensure proper envelope sender (Return-Path)
                    $mailer->Sender = $smtpFrom;
                    $mailer->setFrom($smtpFrom, 'Website Kontaktformular');
                    $mailer->addAddress($config['recipient_email']);
                    if (validateEmail($safeReplyTo)) {
                        $mailer->addReplyTo($safeReplyTo, $name);
                    }
                    $mailer->Subject = $subject;
                    $mailer->Body = $emailBody;
                    $mailer->AltBody = $emailBody;
                    if (function_exists('app_log')) { app_log('contact_process: recipient=' . $config['recipient_email'] . ', from=' . $smtpFrom); }
                    $mailSent = $mailer->send();
                    $sendVia = 'PHPMailer SMTP';
                } catch (Throwable $e) {
                    $sendError = 'PHPMailer: ' . $e->getMessage();
                }
            }

            if (!$mailSent) {
                // Fallback to native mail() with envelope sender
                $additionalParams = "-f {$fromAddress}"; // improves deliverability on IONOS
                $mailSent = @mail($config['recipient_email'], $subject, $emailBody, $headerString, $additionalParams);
                $sendVia = $mailSent ? 'mail()' : $sendVia;
                if (!$mailSent && !$sendError) {
                    $sendError = 'mail() returned false';
                }
            }

            // Build a diagnostic log entry regardless of mail outcome
            $logEntry  = "\n=== CONTACT FORM SUBMISSION ===\n";
            $logEntry .= "Time: " . date('Y-m-d H:i:s') . "\n";
            $logEntry .= "Subject: $subject\n";
            $logEntry .= "From: $fromAddress\n";
            $logEntry .= "Reply-To: $safeReplyTo\n";
            $logEntry .= "Recipient: " . $config['recipient_email'] . "\n";
            $logEntry .= "Mailer: $sendVia\n";
            $logEntry .= "Mail result: " . ($mailSent ? 'SUCCESS' : 'FAIL') . "\n";
            if (!$mailSent && $sendError) {
                $logEntry .= "Error: $sendError\n";
            } elseif (!$mailSent && !($smtpHost && $smtpUser && $smtpPass)) {
                $logEntry .= "Error: SMTP not configured (missing env: SMTP_HOST/USER/PASS)\n";
            }
            $logEntry .= "Email Body:\n$emailBody\n";
            if (isset($smtpDebugBuffer) && $smtpDebugBuffer) {
                $logEntry .= "SMTP Debug:\n" . $smtpDebugBuffer . "\n";
            }
            $logEntry .= "===========================\n";

            $logFilePath = __DIR__ . '/../logging/contact_submissions.log';
            if (!is_dir(dirname($logFilePath))) { @mkdir(dirname($logFilePath), 0775, true); }
            @file_put_contents($logFilePath, $logEntry, FILE_APPEND | LOCK_EX);
            if (function_exists('app_log')) { app_log('contact_process: wrote contact_submissions.log'); }

            if ($mailSent) {
                $response['success'] = true;
                $response['message'] = $config['success_message'];
                error_log("Contact form: send SUCCESS via $sendVia for $safeReplyTo ($name)");
                if (function_exists('app_log')) { app_log('contact_process: mail SUCCESS'); }
            } else {
                $response['success'] = false;
                $response['message'] = $config['error_message'];
                error_log("Contact form: send FAILED via $sendVia for $safeReplyTo ($name)" . ($sendError ? (" - " . $sendError) : ''));
                if (function_exists('app_log')) { app_log('contact_process: mail FAILED ' . ($sendError ?: '')); }
            }
        }
    } catch (Exception $e) {
        $response['message'] = $config['error_message'];
        error_log("Contact form error: " . $e->getMessage());
    }
} else {
    // Not a POST request
    $response['message'] = 'Ungültige Anfrage.';
}

// Return response
if (isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    // AJAX request - return JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Regular form submission - redirect back with message
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['contact_response'] = $response;
    
    $referrer = $_SERVER['HTTP_REFERER'] ?? '../index.php';
    if (function_exists('app_log')) { app_log('contact_process: redirecting to ' . $referrer); }
    error_log('Contact form: redirect ' . $referrer);
    safeRedirect($referrer);
}
// Should never reach here due to safeRedirect/exit above
error_log('Exit: Should never reach here due to safeRedirect/exit above');
exit;
?>
