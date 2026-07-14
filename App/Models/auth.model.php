<?php
include_once __DIR__ . '/../../Librari/inc.koneksi.php';

function getUserByUsername($koneksi, string $username)
{
    $username = mysqli_real_escape_string($koneksi, $username);
    $sql = "SELECT * FROM tb_user WHERE username = '$username' LIMIT 1";
    $query = mysqli_query($koneksi, $sql);
    return mysqli_fetch_assoc($query);
}

function verifyLogin($koneksi, string $username, string $password): ?array
{
    $user = getUserByUsername($koneksi, $username);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return null;
}
