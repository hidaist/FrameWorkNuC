<?php
include_once __DIR__ . '/../Models/data.model.php';
$data = getAllData($koneksi);
?>

<div class="page-header">
    <h2>Kelola Data</h2>
    <p>Tambah, edit, atau hapus data melalui form dan tabel di bawah.</p>
</div>

<?php include __DIR__ . '/data.form.php'; ?>

<div class="data-table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Data</th>
                <th>Detail</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($data) === 0): ?>
                <tr>
                    <td colspan="4" style="text-align:center;color:var(--text-secondary);padding:32px;">
                        Belum ada data. Silakan tambahkan melalui form di atas.
                    </td>
                </tr>
            <?php else: ?>
                <?php while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_data']) ?></td>
                        <td><?= htmlspecialchars($row['data_1']) ?></td>
                        <td><?= htmlspecialchars($row['data_2']) ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="?page=views&views=dataViews&idData=<?= urlencode($row['id_data']) ?>" class="btn-edit">Edit</a>
                                <a href="?page=controls&controls=dataControl&kdhapus=<?= urlencode($row['id_data']) ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
