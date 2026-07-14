<?php

/**
 * Base URL aplikasi (mendukung subfolder Laragon).
 */
function baseUrl(): string
{
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    return rtrim($scriptDir, '/');
}

/**
 * URL untuk file asset publik.
 */
function assetUrl(string $path): string
{
    return baseUrl() . '/' . ltrim($path, '/');
}

/**
 * Render view dengan layout wrapper.
 *
 * @param string $viewPath Path absolut ke file view konten
 * @param array  $data     Variabel yang tersedia di view & layout
 * @param string $layout   Nama file layout di App/Views/layouts/
 */
function renderView(string $viewPath, array $data = [], string $layout = 'app.layout.php'): void
{
    extract($data, EXTR_SKIP);

    ob_start();
    include $viewPath;
    $content = ob_get_clean();

    $layoutPath = __DIR__ . '/../App/Views/layouts/' . $layout;

    if (!file_exists($layoutPath)) {
        echo $content;
        return;
    }

    include $layoutPath;
}
