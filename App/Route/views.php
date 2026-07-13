<?php
//include __DIR__. "../../../cek_login.php";
//include "../session_admin.php";

$file = isset($_GET['views']) ? $_GET['views'] : '';

switch ($file) {
    case 'dataViews':
                        $file_path = __DIR__ . "/../Views/data.view.php";
                        if (!file_exists($file_path)) {
                            die("data views tidak ada");
                        }
                        include $file_path;
                        break;

}
?>
