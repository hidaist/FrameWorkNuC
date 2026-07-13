<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Sederhana</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #1e88e5;
      color: white;
      padding: 20px 0;
      text-align: center;
    }

    nav {
      background-color: #1565c0;
      display: flex;
      justify-content: center;
    }

    nav a {
      color: white;
      text-decoration: none;
      padding: 14px 20px;
      display: block;
    }

    nav a:hover {
      background-color: #0d47a1;
    }

    .container {
      max-width: 900px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-align: center;
    }

    h1 {
      color: #333;
    }

    p {
      color: #555;
      line-height: 1.6;
    }

    footer {
      background-color: #1e88e5;
      color: white;
      text-align: center;
      padding: 10px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>
<body>
  <header>
    <h1>Selamat Datang di Halaman Home</h1>
  </header>

  <nav>
    <a href="#">Home</a>
    <a href="#">Profil</a>
    <a href="?page=views&views=dataViews">Data</a>
  </nav>

  <div class="container">
    <h2>Halo, Admin!</h2>
    <p>Selamat datang di sistem sederhana Anda. Gunakan menu di atas untuk mengelola data, melihat laporan, atau memperbarui informasi.</p>
  </div>

<div class="content">
<?php 
include_once __DIR__ . "/Route/pages.php";
?>
</div>

  <footer>
    &copy; 2025 - Sistem Informasi Sederhana
  </footer>
</body>
</html>
