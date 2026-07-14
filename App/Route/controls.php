<?php

$file = isset($_GET['controls']) ? $_GET['controls'] : '';

switch ($file) {
    case 'authControl':
        $file_path = __DIR__ . "/../Controls/auth.control.php";
        if (!file_exists($file_path)) {
            die("Auth control tidak ada");
        }
        include $file_path;
        break;

    case 'dataControl':
        $file_path = __DIR__ . "/../Controls/data.control.php";
        if (!file_exists($file_path)) {
            die("data control tidak ada");
        }
        include $file_path;
        break;
}
