<?php
/**
 * Contact form processing script
 * Handles form submissions from the footer contact form
 */

session_start();

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

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
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
            
            // Email headers
            $headers = [
                'From' => $email,
                'Reply-To' => $email,
                'X-Mailer' => 'PHP/' . phpversion(),
                'Content-Type' => 'text/plain; charset=UTF-8'
            ];
            
            $headerString = '';
            foreach ($headers as $key => $value) {
                $headerString .= "$key: $value\r\n";
            }
            
            // Send email
            if (mail($config['recipient_email'], $subject, $emailBody, $headerString)) {
                $response['success'] = true;
                $response['message'] = $config['success_message'];
                
                // Log successful submission (optional)
                error_log("Contact form submission from: $email ($name)");
            } else {
                $response['message'] = $config['error_message'];
                error_log("Failed to send contact form email from: $email");
            }

            // // For XAMPP testing: Log instead of sending email
            // $logEntry = "\n=== CONTACT FORM SUBMISSION ===\n";
            // $logEntry .= "Time: " . date('Y-m-d H:i:s') . "\n";
            // $logEntry .= "Subject: $subject\n";
            // $logEntry .= "Email Body:\n$emailBody\n";
            // $logEntry .= "===========================\n";
            
            // Write to log file
            file_put_contents(__DIR__ . '/../logs/contact_submissions.log', $logEntry, FILE_APPEND | LOCK_EX);
            
            // For testing: Always succeed
            $response['success'] = true;
            $response['message'] = $config['success_message'] . " (Testmodus: Nachricht wurde in logs/contact_submissions.log gespeichert)";
            
            // Also log to error log
            error_log("Contact form submission from: $email ($name) - saved to contact_submissions.log");
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
    session_start();
    $_SESSION['contact_response'] = $response;
    
    $referrer = $_SERVER['HTTP_REFERER'] ?? '../index.php';
    header("Location: $referrer");
}

exit;
?>
