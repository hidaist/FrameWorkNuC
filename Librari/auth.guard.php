<?php
include_once __DIR__ . '/inc.session.php';

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function isPublicRoute(): bool
{
    $page = $_GET['page'] ?? '';
    $publicRoutes = [
        'views'    => ['loginViews'],
        'controls' => ['authControl'],
    ];
    $subPage = $_GET[$page] ?? '';

    return isset($publicRoutes[$page]) && in_array($subPage, $publicRoutes[$page]);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: ?page=views&views=loginViews');
        exit;
    }
}

function redirectIfLoggedIn(): void
{
    if (isLoggedIn()) {
        header('Location: index.php');
        exit;
    }
}
