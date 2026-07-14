<?php
include_once __DIR__ . '/../../Librari/inc.session.php';
include_once __DIR__ . '/../Models/auth.model.php';

// LOGIN
if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = verifyLogin($koneksi, $username, $password);

    if ($user) {
        session_regenerate_id(true);
        $_SESSION['user_id']  = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama']     = $user['nama'];
        $_SESSION['role']     = $user['role'];

        header('Location: index.php');
        exit;
    }

    $_SESSION['login_error'] = 'Username atau password salah.';
    header('Location: ?page=views&views=loginViews');
    exit;
}

// LOGOUT
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ?page=views&views=loginViews');
    exit;
}
