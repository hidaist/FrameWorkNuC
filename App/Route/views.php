<?php

$file = isset($_GET['views']) ? $_GET['views'] : '';

switch ($file) {
    case 'loginViews':
        $file_path = __DIR__ . '/../Views/login.view.php';
        if (!file_exists($file_path)) {
            die('Login view tidak ada');
        }
        include $file_path;
        break;

    case 'dataViews':
        include_once __DIR__ . '/../../Librari/view.helper.php';
        renderView(__DIR__ . '/../Views/data.view.php', [
            'pageTitle'  => 'Kelola Data',
            'activeMenu' => 'data',
        ]);
        break;
}
