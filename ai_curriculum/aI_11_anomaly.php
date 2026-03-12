<?php
// variables:
$title = "AI 11: Anomaly Detection";
$page_headline = "11. Anomaly Detection";
$prev_link = 'ai_10_nerf';
$prev_text = 'Zurück: NeRF & 3D Vision';
$next_link = 'ai_12_business';
$next_text = 'Weiter: Business';

ob_start();
?>

<!-- Content: -->
<h2>Willkommen zum Modul 11</h2>
<p>Hier steht dein eigentlicher Text...</p>

<?php
$content = ob_get_clean();

include __DIR__ . '/includes/aI_boilerplate.php';
?>