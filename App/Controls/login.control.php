<?php
include_once __DIR__ . "/../../Librari/inc.koneksi.php";
include_once __DIR__ . "/../Models/login.model.php";

session_start();

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $user = cekLogin($koneksi, $username, $password);

    if ($user) {

        // Mencegah Session Fixation
        session_regenerate_id(true);

        $_SESSION['user_login'] = [
            'id'           => $user['id'],
            'username'     => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'level'        => $user['level']
        ];

        // Redirect sesuai level
        if ($user['level'] === 'admin') {
            header("Location: Dashboard/admin/index.php");
        } else {
            header("Location: Dashboard/user/index.php");
        }

        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

// Logout
if (isset($_GET['logout'])) {
    logout();
}
?>