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

Struktur folder frameworkbyDMZ menggunakan konsep **MVC (Model - View - Controller)** dengan pemisahan antara aplikasi (`App`) dan library pendukung (`Librari`).

```text
frameworkbyDMZ/
│
├── index.php                    # Entry point aplikasi
│
├── App/                         # Folder utama aplikasi
│   │
│   ├── Auth/                    # Authentication & Authorization
│   │   ├── AuthController.php   # Proses login, logout
│   │   ├── AuthModel.php        # Query user dan autentikasi
│   │   ├── Session.php          # Pengelolaan session
│   │   ├── Token.php            # Token API (opsional)
│   │   └── Middleware.php       # Cek login dan hak akses
│   │
│   ├── Controls/                # Controller aplikasi
│   │   └── data.control.php     # Proses CRUD data
│   │
│   ├── Models/                  # Model akses database
│   │   └── data.model.php       # Fungsi query tabel tb_data
│   │
│   ├── Views/                   # Tampilan aplikasi
│   │   │
│   │   ├── auth/
│   │   │   └── login.view.php   # Halaman login
│   │   │
│   │   ├── dashboard/
│   │   │   └── dashboard.view.php
│   │   │
│   │   ├── data.view.php        # Halaman list data
│   │   └── data.form.php        # Form tambah & edit
│   │
│   └── Route/                   # Sistem routing aplikasi
│       ├── pages.php            # Router utama (?page=...)
│       ├── views.php            # Router tampilan
│       └── controls.php         # Router controller
│
├── Librari/                     # Library dan konfigurasi umum
│   │
│   ├── inc.koneksi.php          # Konfigurasi koneksi database
│   ├── helper.php               # Fungsi bantuan
│   └── response.php             # Response JSON API
│
├── Assets/                      # File pendukung frontend
│   ├── css/
│   ├── js/
│   └── images/
│
└── README.md
```
```
MVC + Routing + Authentication
```

Pembagian fungsi:

| Folder | Fungsi |
|--------|--------|
| `App/Auth` | Menangani login, logout, session, token, dan hak akses |
| `App/Controls` | Menangani proses bisnis aplikasi |
| `App/Models` | Menangani komunikasi dengan database |
| `App/Views` | Menampilkan halaman HTML/PHP |
| `App/Route` | Mengatur jalur request aplikasi |
| `Librari` | Menyimpan fungsi umum dan konfigurasi |

---

# Cara Kerja Routing

Semua request masuk melalui **index.php** kemudian diteruskan ke **Route/pages.php**.

Browser
   │
   ▼
index.php
   │
   ▼
App/Route/pages.php
   │
   │
   ├── page=views
   │       │
   │       ▼
   │   App/Route/views.php
   │       │
   │       ▼
   │   App/Views/
   │
   │
   └── page=controls
           │
           ▼
       App/Route/controls.php
           │
           ▼
       App/Controls/
           │
           ▼
       App/Models/
           │
           ▼
       Database
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
App/Route/pages.php        ← baca ?page=
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

Flow:

```
Browser
    │
    ▼
Route/views.php
    │
    ▼
Views/data.view.php
    │
    ▼
Models/data.model.php
    │
    ▼
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
App/Models/user.model.php
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
App/Views/user.view.php
```

File ini digunakan untuk menampilkan daftar data User.

---

## 3. Membuat Form

Buat file:

```text
App/Views/user.form.php
```

File ini digunakan sebagai form **Tambah** dan **Edit** User.

---

## 4. Membuat Controller

Buat file:

```text
App/Controls/user.control.php
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
AppRoute/views.php
```

```php
case 'userViews':
    include __DIR__ . '/../Views/user.view.php';
    break;
```

### Route Controller

Tambahkan pada file:

```text
App/Route/controls.php
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

# Konvensi Penamaan

| Jenis | Lokasi | Format | Contoh |
|------|--------|--------|--------|
| View | `App/Views` | modul.view.php | data.view.php |
| Form | `App/Views` | modul.form.php | data.form.php |
| Controller | `App/Controls` | modul.control.php | data.control.php |
| Model | `App/Models` | modul.model.php | data.model.php |
| Auth | `App/Auth` | NamaClass.php | AuthController.php |

---

# Fungsi Model Dasar

| Fungsi | Deskripsi |
|--------|-----------|
| `tambahData()` | Menambah data baru |
| `updateData()` | Mengubah data berdasarkan ID |
| `hapusData()` | Menghapus data berdasarkan ID |
| `getAllData()` | Mengambil semua data |
| `getDataById()` | Mengambil data berdasarkan ID |



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