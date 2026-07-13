<?php
include_once __DIR__ . "/../Models/data.model.php";

$kdedit = null;

if (isset($_GET['idData'])) {
    $idData = $_GET['idData'];
    $kdedit = getDataById($koneksi, $idData);
}
?>
<form method="post" action="?page=controls&controls=dataControl">
    <input 
        type="text" 
        name="idData" 
        value="<?= $kdedit['id_data'] ?? '' ?>"
        placeholder="Kode" 
        required <?= $kdedit ? 'readonly' : '' ?> >
    
    <input 
        type="text" 
        name="data1" 
        value="<?= $kdedit['data_1'] ?? '' ?>"
        placeholder="Nama" 
        required>

    <input 
        type="text" 
        name="data2" 
        value="<?= $kdedit['data_2'] ?? '' ?>"
        placeholder="Detail" 
        required>
        
    <button type="submit" name="<?= $kdedit ? 'update' : 'submit' ?>">
        <?= $kdedit ? 'Update' : 'Submit' ?>
    </button>
</form>