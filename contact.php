<?php
/**
 * Public contact form endpoint
 * Delegates processing to the internal handler in includes/contact_process.php
 */

// require __DIR__ . '/includes/bootstrap.php';
// if (function_exists('app_log')) { app_log('contact.php reached'); }

// error_log("Contact form: entered contact.php");
// if (function_exists('app_log')) { app_log('contact.php: error_log emitted'); }
require __DIR__ . '/includes/contact_process.php';

// Script end is handled by the included file
?>
