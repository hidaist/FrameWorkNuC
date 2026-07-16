<?php
// Fungsi untuk login
function cekLogin($koneksi, $username, $password) {
    $username = mysqli_real_escape_string($koneksi, $username);
    
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        // Verifikasi password menggunakan password_verify
        if (password_verify($password, $data['password'])) {
            return $data;
        }
    }
    return false;
}

// Fungsi untuk cek session login
function cekSession() {
    session_start();
    if (!isset($_SESSION['user_login'])) {
        header("Location: index.php?page=views&views=login");
        exit();
    }
}

// Fungsi untuk logout
function logout() {
    session_start();
    session_destroy();
    header("Location:/../../../index.php");
    exit();
}
?>