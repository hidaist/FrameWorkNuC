<?php
error_reporting(error_level: 5);
//ini_set('display_errors', 1);

$page = isset($_GET['page']) ? $_GET['page'] : '';

switch ($page) {
    // Mengarah ke folder control
            case 'views':
                $file_path = __DIR__ . "/views.php"; // Tentukan file yang benar di direktorinya
                if (!file_exists($file_path)) {
                    die("File tidak ada");
                }
                include $file_path;
                break;

                case 'controls':
                    $file_path = __DIR__ . "/controls.php"; // Tentukan file yang benar di direktorinya
                    if (!file_exists($file_path)) {
                        die("File tidak ada");
                    }
                    include $file_path;
                    break;

            }
?>
