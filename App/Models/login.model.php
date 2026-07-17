<?php
// Fungsi untuk login
function cekLogin($koneksi, $username, $password)
{
    // Prepared Statement
    $stmt = mysqli_prepare($koneksi, "SELECT id, username, nama_lengkap, password, level FROM users WHERE username = ? LIMIT 1");

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {

        // Verifikasi Password
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }

    mysqli_stmt_close($stmt);

    return false;
}

// Fungsi cek session
function cekSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_login'])) {
        header("Location: index.php?page=views&views=login");
        exit();
    }
}

// Fungsi Logout
function logout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();

    header("Location: /../../index.php?");
    exit();
}

?>