<?php
include_once __DIR__ . "/../../Librari/inc.koneksi.php";
include_once __DIR__ . "/../Models/login.model.php";

session_start();

// Proses Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = cekLogin($koneksi, $username, $password);

    if ($user) {
        $_SESSION['user_login'] = [
            'id'           => $user['id'],
            'username'     => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'level'        => $user['level']
        ];

        // Redirect sesuai level user
        if ($user['level'] === 'admin') {
            $redirect = 'Dashboard/admin/index.php';
        } else {
            $redirect = 'Dashboard/user/index.php';
        }

        echo "<script>
            alert('Login berhasil! Selamat datang, " . $user['nama_lengkap'] . "');
            document.location='" . $redirect . "';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Username atau password salah!');
            document.location='index.php?page=views&views=login';
        </script>";
        exit();
    }
}

// Proses Logout
if (isset($_GET['logout'])) {
    logout();
}
?>