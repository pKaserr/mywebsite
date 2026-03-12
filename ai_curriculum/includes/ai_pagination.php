<?php
/**
 * Navigation für die AI-Module
 * Erwartet: $next_link und $next_text
 * Optional: $prev_link und $prev_text (Standard ist die Übersicht)
 */
$prev_link = $prev_link ?? 'ai_dashboard.php';
$prev_text = $prev_text ?? 'Zurück zur Übersicht';
?>

<div style="display: flex; justify-content: space-between; margin-top: 2rem;">
    <a href="<?php echo $prev_link; ?>">
        <button class="btn btn--main">&larr;
            <?php echo $prev_text; ?>
        </button>
    </a>

    <?php if (isset($next_link)): ?>
        <a href="<?php echo $next_link; ?>">
            <button class="btn btn--main">
                <?php echo $next_text; ?> &rarr;
            </button>
        </a>
    <?php endif; ?>
</div>