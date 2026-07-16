<?php
include_once __DIR__ . "/../Models/data.model.php";

$kdedit = null;
$idData = isset($_GET['idData']) ? $_GET['idData'] : '';

if (!empty($idData)) {
    $kdedit = getDataById($koneksi, $idData);
}
?>
<form method="post" action="?page=controls&controls=dataControl">
    <div class="form-group">
        <label for="idData">Kode</label>
        <input 
            type="text" 
            id="idData"
            name="idData" 
            value="<?= htmlspecialchars($kdedit['id_data'] ?? '') ?>"
            placeholder="Masukkan kode" 
            required <?= $kdedit ? 'readonly' : '' ?> >
    </div>
    
    <div class="form-group">
        <label for="data1">Nama Data</label>
        <input 
            type="text" 
            id="data1"
            name="data1" 
            value="<?= htmlspecialchars($kdedit['data_1'] ?? '') ?>"
            placeholder="Masukkan nama data" 
            required>
    </div>

    <div class="form-group">
        <label for="data2">Detail</label>
        <input 
            type="text" 
            id="data2"
            name="data2" 
            value="<?= htmlspecialchars($kdedit['data_2'] ?? '') ?>"
            placeholder="Masukkan detail" 
            required>
    </div>
        
    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:10px;">
        <button type="button" class="btn btn-secondary" onclick="closeFormModal()">Batal</button>
        <button type="submit" class="btn btn-primary" name="<?= $kdedit ? 'update' : 'submit' ?>">
            <?= $kdedit ? 'Update' : 'Simpan' ?>
        </button>
    </div>
</form>