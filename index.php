<?php
session_start();

// Proses logout - HARUS sebelum redirect login
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Jika sudah login dan mengakses halaman utama, redirect ke dashboard sesuai level
if (isset($_SESSION['user_login'])) {
    $level = $_SESSION['user_login']['level'];
    if ($level === 'admin') {
        header("Location: Dashboard/admin/index.php");
    } else {
        header("Location: Dashboard/user/index.php");
    }
    exit();
}

// Routing untuk proses data (submit, update, delete) via page=controls&controls=dataControl
$page = isset($_GET['page']) ? $_GET['page'] : '';
$controls = isset($_GET['controls']) ? $_GET['controls'] : '';

if ($page === 'controls' && $controls === 'dataControl') {
    include_once __DIR__ . "/Librari/inc.koneksi.php";
    include_once __DIR__ . "/App/Controls/data.control.php";
    exit();
}

// Proses login via POST dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    include_once __DIR__ . "/Librari/inc.koneksi.php";
    include_once __DIR__ . "/App/Models/login.model.php";

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
        $error = "Username atau password salah!";
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Framework</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-wrapper {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            padding: 48px 40px;
            width: 420px;
            max-width: 92%;
        }
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .logo-circle {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 24px;
            font-weight: 700;
            color: white;
        }
        .login-header h1 {
            font-size: 22px;
            color: #1e293b;
            margin-bottom: 4px;
        }
        .login-header p {
            font-size: 14px;
            color: #94a3b8;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #475569;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
            background: #f8fafc;
        }
        .form-group input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
            background: white;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.35);
        }
        .alert-error {
            background: #fef2f2;
            color: #ef4444;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 18px;
            text-align: center;
        }
        .login-info {
            margin-top: 20px;
            padding: 14px;
            background: #f1f5f9;
            border-radius: 10px;
            font-size: 12px;
            color: #64748b;
            text-align: center;
        }
        .login-info strong {
            display: block;
            margin-bottom: 4px;
            color: #475569;
        }
        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-header">
            <div class="logo-circle">F</div>
            <h1>Selamat Datang</h1>
            <p>Silakan login untuk mengakses sistem</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" name="login" class="btn-login">Masuk</button>
        </form>

        <div class="login-info">
            <strong>🔑 Akun Demo</strong>
            Admin: <strong>admin</strong> <strong>admin123</strong>
            User: <strong>user</strong>  <strong>user123</strong>
        </div>

        <div class="login-footer">
            &copy; 2025 - Framework Informasi Sederhana
        </div>
    </div>
</body>
</html>