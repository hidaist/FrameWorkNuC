# frameworkbyDMZ

Framework MVC sederhana berbasis **PHP Native** dengan struktur **Model - View - Controller (MVC)** dan sistem routing sederhana menggunakan parameter URL.

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

### 1. Clone Repository

```bash
git clone https://github.com/[username]/frameworkbyDMZ.git
cd frameworkbyDMZ
```

### 2. Letakkan di Folder Web Server

Contoh menggunakan **Laragon**:

```text
C:\laragon\www\frameworkbyDMZ
```

---

## Database

### Buat Database

```sql
CREATE DATABASE frameworkbydmz;
USE frameworkbydmz;


```

### Buat Tabel

```sql
CREATE TABLE tb_data (
    id_data VARCHAR(50) PRIMARY KEY,
    data_1  VARCHAR(100) NOT NULL,
    data_2  VARCHAR(255) DEFAULT NULL
);
```

---

## Konfigurasi Database

Edit file:

```text
Librari/inc.koneksi.php
```

Ubah konfigurasi sesuai server Anda.

```php
$host     = "localhost";
$username = "root";
$password = "";
$database = "frameworkbydmz";
```

---

## Menjalankan Aplikasi

Jika menggunakan **Laragon Virtual Host**:

```
http://frameworkbydmz.test
```

atau

```
http://localhost/frameworkbyDMZ
```

---

# Struktur Folder

```text
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
```

---

# Cara Kerja Routing

Semua request masuk melalui **index.php** kemudian diteruskan ke **Route/pages.php**.

```
Browser
      │
      ▼
 index.php
      │
      ▼
 Route/pages.php
      │
      ├──────── page=views
      │               │
      │               ▼
      │        Route/views.php
      │               │
      │               ▼
      │        Views/*.view.php
      │
      └──────── page=controls
                      │
                      ▼
             Route/controls.php
                      │
                      ▼
             Controls/*.control.php
```

---

# Dokumentasi URL Parameter

Berikut adalah daftar URL yang digunakan dalam aplikasi beserta fungsinya.

| URL | Fungsi |
|-----|---------|
| `?page=views&views=dataViews` | Menampilkan halaman data (List Data). |
| `?page=controls&controls=dataControl` | Memproses data dari form menggunakan metode **POST** (Tambah/Simpan Data). |
| `?page=controls&controls=dataControl&kdhapus=ID` | Menghapus data berdasarkan **ID**. |
| `?page=views&views=dataViews&idData=ID` | Menampilkan form dalam mode **Edit** berdasarkan **ID**. |

## Keterangan Parameter

| Parameter | Deskripsi |
|-----------|-----------|
| `page` | Menentukan jenis halaman yang akan dipanggil. |
| `views` | Menentukan file tampilan (View). |
| `controls` | Menentukan file Controller yang memproses aksi. |
| `idData` | ID data yang akan diedit. |
| `kdhapus` | ID data yang akan dihapus. |

## Contoh Penggunaan

### Menampilkan Data

```text
?page=views&views=dataViews
```

### Menyimpan Data (POST)

```text
?page=controls&controls=dataControl
```

### Mengedit Data

```text
?page=views&views=dataViews&idData=5
```

### Menghapus Data

```text
?page=controls&controls=dataControl&kdhapus=5
```

> **Catatan**
>
> - Ganti nilai `ID` dengan ID data yang sesuai.
> - URL untuk **Tambah** dan **Simpan** menggunakan endpoint yang sama (`dataControl`) dengan metode **POST**.
> - Penghapusan data dilakukan menggunakan parameter `kdhapus`.

# Alur Routing
```text
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
```

# Alur MVC

## 1. Menampilkan Data

```
Browser
      │
      ▼
View
      │
      ▼
Model
      │
      ▼
Database
```

URL

```
?page=views&views=dataViews
```

Flow

```
View
    ↓
getAllData()
    ↓
Database
```

---

## 2. Tambah Data

```
Form
    │
    ▼
Controller
    │
    ▼
tambahData()
    │
    ▼
Database
```

URL

```
?page=controls&controls=dataControl
```

---

## 3. Edit Data

Klik tombol Edit

```
?page=views&views=dataViews&idData=001
```

Flow

```
View
    ↓
getDataById()
    ↓
Form terisi
    ↓
Submit
    ↓
Controller
    ↓
updateData()
    ↓
Database
```

---

## 4. Hapus Data

```
Klik Hapus
      │
      ▼
Controller
      │
      ▼
hapusData()
      │
      ▼
Database
```

URL

```
?page=controls&controls=dataControl&kdhapus=001
```

---

# Diagram MVC

```text
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
```

---

# Konvensi Penamaan

| Jenis | Format | Contoh |
|---------|---------|---------|
| View | `modul.view.php` | `data.view.php` |
| Form | `modul.form.php` | `data.form.php` |
| Controller | `modul.control.php` | `data.control.php` |
| Model | `modul.model.php` | `data.model.php` |

---

# Menambah Modul Baru

Berikut langkah-langkah untuk menambahkan modul baru pada aplikasi. Sebagai contoh, akan dibuat modul **User**.

## 1. Membuat Model

Buat file:

```text
Models/user.model.php
```

Tambahkan fungsi yang dibutuhkan, misalnya:

```php
function getAllUser($koneksi) { ... }

function tambahUser($koneksi, ...) { ... }

function updateUser($koneksi, ...) { ... }

function hapusUser($koneksi, $id) { ... }

function getUserById($koneksi, $id) { ... }
```

---

## 2. Membuat View

Buat file:

```text
Views/user.view.php
```

File ini digunakan untuk menampilkan daftar data User.

---

## 3. Membuat Form

Buat file:

```text
Views/user.form.php
```

File ini digunakan sebagai form **Tambah** dan **Edit** User.

---

## 4. Membuat Controller

Buat file:

```text
Controls/user.control.php
```

Controller bertugas memproses:

- Tambah data
- Update data
- Hapus data

---

## 5. Menambahkan Route

### Route View

Tambahkan pada file:

```text
Route/views.php
```

```php
case 'userViews':
    include __DIR__ . '/../Views/user.view.php';
    break;
```

### Route Controller

Tambahkan pada file:

```text
Route/controls.php
```

```php
case 'userControl':
    include __DIR__ . '/../Controls/user.control.php';
    break;
```

---

## 6. Menambahkan Menu

Tambahkan menu pada file `index.php`.

```html
<a href="?page=views&views=userViews">User</a>
```

---

# Fungsi Model yang Tersedia

| Fungsi | Deskripsi |
|---------|-----------|
| `tambahData()` | Menambahkan data baru ke tabel `tb_data`. |
| `updateData()` | Mengubah data berdasarkan `id_data`. |
| `hapusData()` | Menghapus data berdasarkan `id_data`. |
| `getAllData()` | Mengambil seluruh data dari tabel. |
| `getDataById()` | Mengambil satu data berdasarkan `id_data`. |

---

## Struktur Modul

```text
Models/
└── user.model.php

Views/
├── user.view.php
└── user.form.php

Controls/
└── user.control.php

Route/
├── views.php
└── controls.php
```

---

## Alur Modul

```text
Menu
  │
  ▼
Route/views.php
  │
  ▼
user.view.php
  │
  ▼
user.form.php
  │
  ▼
Route/controls.php
  │
  ▼
user.control.php
  │
  ▼
user.model.php
  │
  ▼
Database
```

# Pengembangan

Pastikan:

- Apache atau Nginx aktif
- MySQL aktif
- Database `frameworkbydmz` sudah dibuat
- Tabel `tb_data` tersedia

---

# Roadmap

- [ ] Halaman edit terpisah
- [ ] Login & Authentication
- [ ] Middleware
- [ ] Validasi Form
- [ ] Prepared Statement
- [ ] Template Layout (Header/Footer)
- [ ] Session Guard

---

# Kontribusi

Kontribusi sangat diterima.

1. Fork repository
2. Buat branch baru

```bash
git checkout -b fitur/nama-fitur
```

3. Commit

```bash
git commit -m "Menambahkan fitur baru"
```

4. Push

```bash
git push origin fitur/nama-fitur
```

5. Buat Pull Request

---

# Lisensi

MIT License

---

# Author

**Nama Anda**

GitHub: https://github.com/username

Email: email@example.com

---

Dibuat menggunakan ❤️ **PHP Native MVC**