<?php
include_once __DIR__. "/../../Librari/inc.koneksi.php";

// Add data ke database
function tambahData($koneksi, $idData, $data1, $data2) {
    $sql = "INSERT INTO tb_data SET 
                id_data         = '$idData',
                data_1          = '$data1',
                data_2          = '$data2'";
    return mysqli_query($koneksi, $sql);
}

// Update data ke database
function updateData($koneksi, $idData, $data1, $data2) {
    $sql = "UPDATE tb_data SET 
                data_1          = '$data1',
                data_2          = '$data2'
            WHERE id_data       = '$idData'";
    return mysqli_query($koneksi, $sql);
}

//Hapus data di database
function hapusData($koneksi, $kdhapus) {
    $sql = "DELETE FROM tb_data WHERE id_data = '$kdhapus'";
    return mysqli_query($koneksi, $sql);
}

// ambil semua data 
function getAllData($koneksi) {
    $sql = "SELECT * FROM tb_data ORDER BY id_data";
    return mysqli_query($koneksi,$sql);
}


// get data by id/kode id
function getDataById($koneksi, $idData) {
    $sql = "SELECT * FROM tb_data WHERE id_data = '$idData'";
    $query = mysqli_query($koneksi, $sql);
    return mysqli_fetch_assoc($query);
}
?>
