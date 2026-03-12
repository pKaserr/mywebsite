<?php
// variables:
$title = "";
$page_headline = "";
$prev_link = '';
$prev_text = '';
$next_link = '';
$next_text = '';

ob_start();
?>

<!-- Content: -->
<h2>Willkommen zum Modul ##</h2>
<p>Hier steht dein eigentlicher Text...</p>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>