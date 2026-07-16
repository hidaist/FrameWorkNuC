<?php
session_start();

// Proses logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}

if (!isset($_SESSION['user_login']) || $_SESSION['user_login']['level'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #43a047;
            --primary-dark: #2e7d32;
            --primary-light: #e8f5e9;
            --accent: #66bb6a;
            --sidebar-bg: #1b5e20;
            --sidebar-hover: #2e7d32;
            --bg: #f1f5f9;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-brand .logo {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
        }
        .sidebar-brand h2 { font-size: 16px; font-weight: 600; }
        .sidebar-brand small { display: block; font-size: 10px; opacity: 0.6; }
        .sidebar-nav { flex: 1; padding: 12px 0; overflow-y: auto; }
        .sidebar-nav .nav-label { padding: 16px 20px 6px; font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.5; }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #c8e6c9;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            margin: 2px 8px;
            border-radius: 8px;
        }
        .sidebar-nav a:hover { background: var(--sidebar-hover); color: white; }
        .sidebar-nav a.active { background: var(--sidebar-hover); color: white; border-left-color: var(--accent); }
        .sidebar-nav a .icon { width: 20px; text-align: center; font-size: 16px; }
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-footer .user-card { display: flex; align-items: center; gap: 10px; }
        .sidebar-footer .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: bold;
        }
        .sidebar-footer .user-name { font-size: 13px; font-weight: 500; }
        .sidebar-footer .user-role { font-size: 11px; opacity: 0.5; }
        .sidebar-footer .logout-btn {
            margin-left: auto; color: #fca5a5; text-decoration: none;
            font-size: 13px; padding: 4px 8px; border-radius: 6px; transition: background 0.2s;
        }
        .sidebar-footer .logout-btn:hover { background: rgba(239,68,68,0.15); }
        .main-content { margin-left: 250px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: white; padding: 0 30px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 50;
        }
        .topbar .page-title { font-size: 18px; font-weight: 600; color: #1e293b; }
        .topbar .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar .topbar-right .breadcrumb { font-size: 13px; color: #94a3b8; }
        .topbar .topbar-right .breadcrumb span { color: var(--primary); }
        .content-area { padding: 30px; flex: 1; padding-bottom: 80px; }
        .app-footer {
            background: white; border-top: 1px solid #e2e8f0;
            text-align: center; padding: 14px 30px; font-size: 13px; color: #94a3b8;
        }
        .mobile-toggle { display: none; background: none; border: none; color: #475569; font-size: 24px; cursor: pointer; padding: 4px; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: block; }
            .content-area { padding: 20px 16px; }
            .topbar { padding: 0 16px; }
        }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 90; }
        .sidebar-overlay.active { display: block; }

        .welcome-box {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }
        .welcome-box h2 { color: #1b5e20; margin-bottom: 6px; font-size: 22px; }
        .welcome-box p { color: #2e7d32; font-size: 14px; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
        .badge-user { background: #e8f5e9; color: #2e7d32; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card { background: white; border-radius: 10px; padding: 20px; box-shadow: var(--card-shadow); text-align: center; }
        .card h3 { color: #555; font-size: 14px; margin-bottom: 8px; }
        .card .number { font-size: 28px; font-weight: bold; color: var(--primary); }
        .card .icon { font-size: 36px; margin-bottom: 10px; }
        .card-table { background: white; border-radius: 12px; padding: 24px; box-shadow: var(--card-shadow); border: 1px solid #e2e8f0; }
        .card-table table { width: 100%; border-collapse: collapse; }
        .card-table table th, .card-table table td { padding: 12px 14px; text-align: left; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .card-table table th { background: #f8fafc; color: #64748b; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .card-table table tbody tr:hover { background: #f8fafc; }
        .card-table table tbody tr:last-child td { border-bottom: none; }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="logo">U</div>
            <div>
                <h2>Framework</h2>
                <small>User Panel</small>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Menu</div>
            <a href="index.php" class="">
                <span class="icon">🏠</span> Beranda
            </a>
            <a href="?page=views&views=dataViews" class="">
                <span class="icon">📋</span> Data
            </a>
            <a href="#">
                <span class="icon">👤</span> Profil
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-card">
                <div class="avatar"><?php echo strtoupper(substr($_SESSION['user_login']['nama_lengkap'], 0, 1)); ?></div>
                <div>
                    <div class="user-name"><?php echo htmlspecialchars($_SESSION['user_login']['nama_lengkap']); ?></div>
                    <div class="user-role"><?php echo htmlspecialchars($_SESSION['user_login']['level']); ?></div>
                </div>
                <a href="logout.php" class="logout-btn" title="Logout">🚪</a>
            </div>
        </div>
    </aside>

    <div class="main-content">
        <header class="topbar">
            <div>
                <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>
                <span class="page-title"></span>
            </div>
            <div class="topbar-right">
                <span class="breadcrumb">Home / <span></span></span>
            </div>
        </header>

        <div class="content-area">
            
                <div class="welcome-box">
                    <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['user_login']['nama_lengkap']); ?>!</h2>
                    <p>Anda login sebagai user. Gunakan menu di samping untuk mengakses fitur yang tersedia.</p>
                    <span class="badge badge-user" style="margin-top:10px;display:inline-block;">Level: User</span>
                </div>

                <div class="cards">
                    <div class="card">
                        <div class="icon">📄</div>
                        <h3>Data Saya</h3>
                        <div class="number">5</div>
                    </div>
                    <div class="card">
                        <div class="icon">📊</div>
                        <h3>Laporan</h3>
                        <div class="number">2</div>
                    </div>
                    <div class="card">
                        <div class="icon">📅</div>
                        <h3>Aktivitas</h3>
                        <div class="number">7</div>
                    </div>
                </div>

                <div class="card-table">
                    <h3 style="margin-bottom:15px;color:#1e293b;">📋 Aktivitas Terbaru</h3>
                    <table>
                        <thead>
                            <tr><th>Tanggal</th><th>Aktivitas</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>2025-01-15</td><td>Login ke sistem</td><td>Berhasil</td></tr>
                            <tr><td>2025-01-14</td><td>Melihat data</td><td>Berhasil</td></tr>
                            <tr><td>2025-01-13</td><td>Update profil</td><td>Berhasil</td></tr>
                        </tbody>
                    </table>
                </div>
            
        </div>

    <!-- Isi konten yang di panggil dari URL -->
        <div>
            <?php include_once __DIR__ . "/../../App/Route/pages.php"; ?>
        </div>
        <footer class="app-footer">
            &copy; 2025 - Dashboard User
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            link.addEventListener('click', () => { if (window.innerWidth <= 768) toggleSidebar(); });
        });
    </script>
</body>
</html>