<?php
include_once __DIR__. "/../Models/data.model.php";
$data       = getAllData($koneksi);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Data</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        td, th { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
<h2>Data Data</h2>
<?php include 'data.form.php'; ?>
<table>
<tr><th>Kode</th><th>Nama Data</th><th>Detail</th><th>Aksi</th></tr>
<?php while ($row = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?php echo $row['id_data']; ?></td>
    <td><?php echo $row['data_1']; ?></td>
    <td><?php echo $row['data_2']; ?></td>
    <td>
        <a href="?page=controls&controls=dataControl&kdhapus=<?php echo $row['id_data']; ?>">Hapus</a>
        <a href="?page=views&views=dataViews&idData=<?php echo $row['id_data']; ?>">Edit</a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
