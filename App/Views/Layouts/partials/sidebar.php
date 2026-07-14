<?php
$activeMenu = $activeMenu ?? '';
$userName   = $_SESSION['nama'] ?? 'User';
$userRole   = $_SESSION['role'] ?? 'user';
$initials   = strtoupper(substr($userName, 0, 1));
?>

<aside class="app-sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h1>FrameworkbyDMZ</h1>
        <span>Admin Panel</span>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-nav-label">Menu Utama</div>

        <a href="index.php" class="sidebar-link <?= $activeMenu === 'dashboard' ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
            </svg>
            Dashboard
        </a>

        <a href="?page=views&views=dataViews" class="sidebar-link <?= $activeMenu === 'data' ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
            </svg>
            Kelola Data
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar"><?= htmlspecialchars($initials) ?></div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name"><?= htmlspecialchars($userName) ?></div>
                <div class="sidebar-user-role"><?= htmlspecialchars($userRole) ?></div>
            </div>
        </div>
    </div>
</aside>
