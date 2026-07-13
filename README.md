# FrameworkbyDMZ

Framework PHP native berbasis **Model-View-Controller (MVC)** yang ringan dan mudah dipelajari. Cocok untuk proyek kecil, pembelajaran MVC, atau dasar pengembangan sistem informasi sederhana.

Dibangun tanpa dependency eksternal — cukup PHP, MySQL, dan web server (Laragon/XAMPP).

---

## Fitur

- Arsitektur **MVC** yang jelas dan terpisah
- **Routing berbasis query string** (`?page=...`)
- CRUD data sederhana (Create, Read, Update, Delete)
- Form reusable — satu file form untuk tambah & edit
- Koneksi database terpusat
- Ringan, tanpa Composer atau framework pihak ketiga

---

## Tech Stack

| Komponen      | Teknologi                    |
|---------------|------------------------------|
| Bahasa        | PHP (Native)                 |
| Database      | MySQL / MariaDB              |
| Arsitektur    | MVC (Custom)                 |
| Web Server    | Apache / Nginx (via Laragon) |
| Koneksi DB    | MySQLi                       |

---

## Persyaratan

- PHP 8.0 atau lebih baru
- MySQL / MariaDB
- Apache atau Nginx
- [Laragon](https://laragon.org/) (disarankan) atau XAMPP

---

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/[username]/frameworkbyDMZ.git
cd frameworkbyDMZ

2. Letakkan di folder web server
Contoh di Laragon:

C:\laragon\www\frameworkbyDMZ
3. Buat database
Buat database baru di phpMyAdmin atau MySQL CLI:

CREATE DATABASE frameworkbydmz;
USE frameworkbydmz;
CREATE TABLE tb_data (
    id_data VARCHAR(50) PRIMARY KEY,
    data_1  VARCHAR(100) NOT NULL,
    data_2  VARCHAR(255) DEFAULT NULL
);
4. Konfigurasi koneksi database
Edit file Librari/inc.koneksi.php:

$host     = "localhost";
$username = "root";
$password = "";
$database = "frameworkbydmz";
5. Jalankan aplikasi
Buka di browser:

http://frameworkbydmz.test
atau:

http://localhost/frameworkbyDMZ
Struktur Folder
frameworkbyDMZ/
│
├── index.php              # Entry point & layout utama
│
├── Route/                 # Sistem routing
│   ├── pages.php          # Router utama (?page=...)
│   ├── views.php          # Router tampilan (?views=...)
│   └── controls.php       # Router controller (?controls=...)
│
├── Views/                 # Tampilan (HTML/PHP)
│   ├── data.view.php      # Halaman list data
│   └── data.form.php      # Form tambah & edit (partial)
│
├── Controls/              # Controller (logika proses)
│   └── data.control.php   # Proses CRUD data
│
├── Models/                # Model (akses database)
│   └── data.model.php     # Fungsi query tb_data
│
└── Librari/               # Library & utilitas
    └── inc.koneksi.php    # Konfigurasi koneksi database
Cara Kerja Routing
Semua request masuk melalui index.php, lalu diteruskan ke Route/pages.php.

Format URL
?page=[tipe]&[parameter]=[nilai]
Tipe halaman
URL	Fungsi
?page=views&views=dataViews
Tampilkan halaman data
?page=controls&controls=dataControl
Proses form (POST)
?page=controls&controls=dataControl&kdhapus=ID
Hapus data
?page=views&views=dataViews&idData=ID
Mode edit form
Alur routing
Browser
   │
   ▼
index.php
   │
   ▼
Route/pages.php        ← baca ?page=
   │
   ├── page=views  ──► Route/views.php   ← baca ?views=
   │
   └── page=controls ──► Route/controls.php ← baca ?controls=
Alur MVC (Contoh Modul Data)
1. Tampilkan data (View)
?page=views&views=dataViews
  → Route/views.php
  → Views/data.view.php
  → Models/data.model.php (getAllData)
2. Tambah data (View → Control → Model)
Form Submit (POST)
  → ?page=controls&controls=dataControl
  → Controls/data.control.php
  → Models/data.model.php (tambahData)
  → Redirect ke halaman data
3. Edit data (View → Control → Model)
Klik Edit (?page=views&views=dataViews&idData=001)
  → Views/data.form.php (mode edit, field terisi)
  → Submit Update (POST)
  → Controls/data.control.php
  → Models/data.model.php (updateData)
  → Redirect ke halaman data
4. Hapus data (View → Control → Model)
Klik Hapus (?page=controls&controls=dataControl&kdhapus=001)
  → Controls/data.control.php
  → Models/data.model.php (hapusData)
  → Redirect ke halaman data
Diagram Alur
┌─────────────┐     GET      ┌──────────────┐     include     ┌─────────────┐
│   Browser   │ ──────────►  │  Route/      │ ──────────────► │   Views/    │
│             │              │  views.php   │                 │ data.view   │
└─────────────┘              └──────────────┘                 └──────┬──────┘
       │                                                             │
       │ POST (submit/update)                                        │ include
       ▼                                                             ▼
┌─────────────┐              ┌──────────────┐                 ┌─────────────┐
│   Browser   │ ──────────►  │  Route/      │ ──────────────► │   Views/    │
│             │              │  controls.php│                 │ data.form   │
└─────────────┘              └──────┬───────┘                 └─────────────┘
                                    │
                                    ▼
                             ┌──────────────┐     query       ┌─────────────┐
                             │  Controls/   │ ──────────────► │   Models/   │
                             │ data.control │                 │ data.model  │
                             └──────────────┘                 └──────┬──────┘
                                                                      │
                                                                      ▼
                                                               ┌─────────────┐
                                                               │   MySQL     │
                                                               │  tb_data    │
                                                               └─────────────┘
Konvensi Penamaan File
Jenis File	Format	Contoh
View (halaman)
[modul].view.php
data.view.php
View (form)
[modul].form.php
data.form.php
Controller
[modul].control.php
data.control.php
Model
[modul].model.php
data.model.php
Menambah Modul Baru
Contoh menambah modul User:

1. Model — Models/user.model.php
function getAllUser($koneksi) { ... }
function tambahUser($koneksi, ...) { ... }
2. View — Views/user.view.php
Tampilan halaman list user.

3. Form — Views/user.form.php
Form tambah/edit user.

4. Controller — Controls/user.control.php
Proses submit, update, dan hapus.

5. Route — tambahkan case di Route/views.php dan Route/controls.php
// Route/views.php
case 'userViews':
    include __DIR__ . "/../Views/user.view.php";
    break;
// Route/controls.php
case 'userControl':
    include __DIR__ . "/../Controls/user.control.php";
    break;
6. Menu — tambahkan link di index.php
<a href="?page=views&views=userViews">User</a>
Fungsi Model yang Tersedia
Fungsi	Deskripsi
tambahData()
Menambah data baru ke tb_data
updateData()
Mengubah data berdasarkan id_data
hapusData()
Menghapus data berdasarkan id_data
getAllData()
Mengambil semua data
getDataById()
Mengambil satu data berdasarkan ID
Pengembangan
Jalankan via Laragon Virtual Host:

http://frameworkbydmz.test
Pastikan:

Apache/Nginx aktif
MySQL aktif
Database frameworkbydmz sudah dibuat
Tabel tb_data sudah ada
Roadmap
 Route form terpisah untuk halaman edit
 Sistem autentikasi / login
 Validasi input yang lebih ketat
 Prepared statement (keamanan SQL)
 Template layout terpisah (header/footer)
 Middleware / session guard
Kontribusi
Kontribusi sangat diterima! Silakan:

Fork repository ini
Buat branch fitur (git checkout -b fitur/nama-fitur)
Commit perubahan (git commit -m 'Tambah fitur X')
Push ke branch (git push origin fitur/nama-fitur)
Buat Pull Request
Lisensi
[Lisensi Anda di sini — contoh: MIT License]

Author
[Nama Anda]

GitHub: @username
Email: [email@example.com]
Dibuat dengan ❤️ menggunakan PHP Native MVC

```