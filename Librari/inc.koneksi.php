<?php
// Konfigurasi Database
$host = "localhost";
$username = "root";
$password = "";
$database = "frameworkbydmz"; 

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset utf8 untuk mendukung karakter Indonesia
mysqli_set_charset($koneksi, "utf8");
?>