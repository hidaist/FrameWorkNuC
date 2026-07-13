<?php
include_once  __DIR__ . "/../Librari/inc.koneksi.php";
include_once __DIR__ . "/../Models/data.model.php"; // file berisi data model function

// SUBMIT
if (isset($_POST['submit'])) {
    $idData     = mysqli_real_escape_string($koneksi, $_POST['idData']);
    $data1      = mysqli_real_escape_string($koneksi, $_POST['data1']);
    $data2      = mysqli_real_escape_string($koneksi, $_POST['data2']);

    if (tambahData($koneksi, $idData, $data1, $data2)) {
        echo "<font color='red'>Berhasil disimpan.</font>";
        echo "<script>document.location='?page=views&views=dataViews&blok1=true';</script>";
        exit;
    } else {
        die('Gagal: ' . mysqli_error($koneksi));
    }
}

// UPDATE
if (isset($_POST['update'])) {
    $idData     = mysqli_real_escape_string($koneksi, $_POST['idData']);
    $data1      = mysqli_real_escape_string($koneksi, $_POST['data1']);
    $data2      = mysqli_real_escape_string($koneksi, $_POST['data2']);

    if (updateData($koneksi, $idData, $data1, $data2)) {
        echo "<font color='red'>Berhasil diupdate.</font>";
        echo "<script>document.location='?page=views&views=dataViews&blok1=true';</script>";
        exit;
    } else {
        die('Gagal: ' . mysqli_error($koneksi));
    }
}

// HAPUS
if (!empty($_GET['kdhapus'])) {
    if (hapusData($koneksi, $_GET['kdhapus'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="badge badge-pill badge-danger">Success</span> Data berhasil dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>'
        ;
        echo "<script>document.location='?page=views&views=dataViews&blok1=false';</script>";
    } else {
        die('Gagal hapus: ' . mysqli_error($koneksi));
    }
}

// edit
if (isset($_GET['kdedit'])) {
    $idData = $_GET['kdedit'];
    $dataEdit = getDataById($koneksi, $idData);
    include '../views/data.form.php';
    exit();
}



//include "../Views/data.view.php";
?>
