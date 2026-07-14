<?php
include_once __DIR__ . '/../../Librari/inc.koneksi.php';

$userName = $_SESSION['nama'] ?? 'Admin';
$userRole = $_SESSION['role'] ?? 'user';

$totalData = 0;
$result = @mysqli_query($koneksi, 'SELECT COUNT(*) AS total FROM tb_data');
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalData = (int) ($row['total'] ?? 0);
}

$greeting = 'Selamat datang';
$hour = (int) date('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = 'Selamat pagi';
} elseif ($hour >= 12 && $hour < 17) {
    $greeting = 'Selamat siang';
} elseif ($hour >= 17 && $hour < 21) {
    $greeting = 'Selamat sore';
} else {
    $greeting = 'Selamat malam';
}
?>

<div class="welcome-banner">
    <h2><?= htmlspecialchars($greeting) ?>, <?= htmlspecialchars($userName) ?>!</h2>
    <p>Anda login sebagai <strong><?= htmlspecialchars($userRole) ?></strong>. Kelola data dan pantau ringkasan sistem dari dashboard ini.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon indigo">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                </svg>
            </div>
        </div>
        <div class="stat-card-value"><?= $totalData ?></div>
        <div class="stat-card-label">Total Data</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon green">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <polyline points="16 11 18 13 22 9"/>
                </svg>
            </div>
        </div>
        <div class="stat-card-value">1</div>
        <div class="stat-card-label">Pengguna Aktif</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon amber">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
        </div>
        <div class="stat-card-value"><?= date('d M') ?></div>
        <div class="stat-card-label">Hari Ini</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon red">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card-value">Aktif</div>
        <div class="stat-card-label">Status Sistem</div>
    </div>
</div>

<div class="content-grid">
    <div class="panel">
        <div class="panel-header">
            <h3>Aksi Cepat</h3>
        </div>
        <div class="panel-body">
            <div class="quick-actions">
                <a href="?page=views&views=dataViews" class="quick-action">
                    <div class="quick-action-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                    <div class="quick-action-text">
                        <strong>Tambah Data Baru</strong>
                        <span>Buka halaman kelola data</span>
                    </div>
                </a>

                <a href="?page=views&views=dataViews" class="quick-action">
                    <div class="quick-action-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </div>
                    <div class="quick-action-text">
                        <strong>Kelola Data</strong>
                        <span>Lihat, edit, dan hapus data</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Informasi Akun</h3>
        </div>
        <div class="panel-body">
            <ul class="info-list">
                <li>
                    <span class="label">Nama</span>
                    <span class="value"><?= htmlspecialchars($userName) ?></span>
                </li>
                <li>
                    <span class="label">Username</span>
                    <span class="value"><?= htmlspecialchars($_SESSION['username'] ?? '-') ?></span>
                </li>
                <li>
                    <span class="label">Role</span>
                    <span class="value"><?= htmlspecialchars($userRole) ?></span>
                </li>
                <li>
                    <span class="label">Login Terakhir</span>
                    <span class="value"><?= date('d M Y, H:i') ?></span>
                </li>
            </ul>
        </div>
    </div>
</div>
