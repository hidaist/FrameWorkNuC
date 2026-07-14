<?php
include_once __DIR__ . '/Librari/auth.guard.php';

if (!empty($_GET['page'])) {
    if (!isPublicRoute()) {
        requireLogin();
    }
    include_once __DIR__ . '/App/Route/pages.php';
    exit;
}

requireLogin();

include_once __DIR__ . '/Librari/view.helper.php';
renderView(__DIR__ . '/App/Views/dashboard.view.php', [
    'pageTitle'  => 'Dashboard',
    'activeMenu' => 'dashboard',
]);
