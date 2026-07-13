<?php
//include __DIR__. "../../../cek_login.php";
//include "../session_admin.php";

$file = isset($_GET['controls']) ? $_GET['controls'] : '';

switch ($file) {
    case 'dataControl':
                        $file_path = __DIR__ . "/../Controls/data.control.php";
                        if (!file_exists($file_path)) {
                            die("data views tidak ada");
                        }
                        include $file_path;
                        break;

}
?>
