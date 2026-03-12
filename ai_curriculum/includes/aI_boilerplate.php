<!DOCTYPE html>
<html>
<?php $i_title = $title; ?>
<?php include __DIR__ . '/ai_head.php'; ?>

<body>
    <?php include __DIR__ . '/ai_nav.php'; ?>
    <main>
        <div class="container_dashboard">
            <canvas class="particleCanvas"></canvas>
            <div class="container__title">
                <h4 class="container__title--text"><?php echo $page_headline; ?></h4>
            </div>

            <div class="panel">
                <div class="panel-content">
                    <?php echo $content; ?>
                </div>
            </div>
            <?php
            $i_prev_link = $prev_link;
            $i_prev_text = $prev_text;
            $i_next_link = $next_link;
            $i_next_text = $next_text;
            include __DIR__ . '/ai_pagination.php';
            ?>
        </div>
    </main>
    <?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
</body>

</html>