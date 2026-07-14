<?php
if (!function_exists('assetUrl')) {
    include_once __DIR__ . '/../../../Librari/view.helper.php';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?php include __DIR__ . '/partials/head.php'; ?>
</head>
<body>
    <div class="app-layout">
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <div class="app-main">
            <?php include __DIR__ . '/partials/topbar.php'; ?>

            <main class="app-content">
                <?= $content ?>
            </main>

            <?php include __DIR__ . '/partials/footer.php'; ?>
        </div>
    </div>
</body>
</html>
