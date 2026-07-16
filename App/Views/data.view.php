<?php
include_once __DIR__. "/../Models/data.model.php";
$data = getAllData($koneksi);
?>

<div class="card-table">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <h3 style="color:#1e293b;font-size:18px;">📋 Data</h3>
        <button onclick="document.getElementById('formModal').classList.add('show');document.getElementById('formModalOverlay').classList.add('show');" 
                style="background:var(--primary);color:white;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:500;">
            + Tambah Data
        </button>
    </div>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Data</th>
                    <th>Detail</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($data) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><span class="badge badge-id"><?php echo htmlspecialchars($row['id_data']); ?></span></td>
                        <td><strong><?php echo htmlspecialchars($row['data_1']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['data_2']); ?></td>
                        <td style="text-align:center;">
                            <a href="index.php?page=controls&controls=dataControl&kdhapus=<?php echo $row['id_data']; ?>" 
                               class="btn-action btn-delete" 
                               onclick="return confirm('Hapus data ini?')">🗑 Hapus</a>
                           <a href="?page=views&views=dataViews&idData=<?php echo $row['id_data']; ?>&edit=1" 
                            class="btn-action btn-edit">
                            ✏ Edit</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align:center;padding:30px;color:#94a3b8;">Belum ada data.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div class="modal-overlay" id="formModalOverlay" onclick="closeFormModal()"></div>
<div class="modal" id="formModal">
    <div class="modal-header">
        <h3><?php echo isset($_GET['edit']) ? 'Edit Data' : 'Tambah Data Baru'; ?></h3>
        <button class="modal-close" onclick="closeFormModal()">&times;</button>
    </div>
    <div class="modal-body">
        <?php include __DIR__ . '/data.form.php'; ?>
    </div>
</div>

<?php if (isset($_GET['edit'])): ?>
<script>document.getElementById('formModal').classList.add('show');document.getElementById('formModalOverlay').classList.add('show');</script>
<?php endif; ?>

<script>
function closeFormModal() {
    document.getElementById('formModal').classList.remove('show');
    document.getElementById('formModalOverlay').classList.remove('show');
    // Hapus ?edit dari URL tanpa reload
    if (window.location.search.includes('edit=1') || window.location.search.includes('idData=')) {
        const url = new URL(window.location);
        url.searchParams.delete('edit');
        url.searchParams.delete('idData');
        window.history.replaceState({}, '', url);
    }
}
</script>