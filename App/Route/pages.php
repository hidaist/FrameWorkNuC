<?php
error_reporting(error_level: 5);

include_once __DIR__ . '/../../Librari/auth.guard.php';

$page = isset($_GET['page']) ? $_GET['page'] : '';

if (!isPublicRoute()) {
    requireLogin();
}

switch ($page) {
    case 'views':
        $file_path = __DIR__ . "/views.php";
        if (!file_exists($file_path)) {
            die("File tidak ada");
        }
        include $file_path;
        break;

    case 'controls':
        $file_path = __DIR__ . "/controls.php";
        if (!file_exists($file_path)) {
            die("File tidak ada");
        }
        include $file_path;
        break;
}
