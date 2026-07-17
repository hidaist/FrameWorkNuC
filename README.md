# FrameworkByDMZ

> Framework PHP native sederhana dengan arsitektur **MVC (Model-View-Controller)** yang ringan, tanpa dependency eksternal, dan mudah dipahami oleh manusia maupun AI.

---

## 📌 Daftar Isi

- [Tentang Framework](#tentang-framework)
- [Tech Stack](#tech-stack)
- [Struktur Direktori](#struktur-direktori)
- [Cara Kerja (Request Flow)](#cara-kerja-request-flow)
- [Routing](#routing)
- [Model](#model)
- [View](#view)
- [Controller](#controller)
- [Database](#database)
- [Authentication & Session](#authentication--session)
- [Dashboard](#dashboard)
- [Cara Instalasi](#cara-instalasi)
- [Akun Demo](#akun-demo)
- [Cara Menambah Fitur Baru](#cara-menambah-fitur-baru)
- [Catatan untuk AI / Developer](#catatan-untuk-ai--developer)

---

## Tentang Framework

FrameworkByDMZ adalah kerangka kerja aplikasi web berbasis PHP murni (native) yang mengimplementasikan pola **MVC** secara sederhana. Tidak menggunakan Composer, tidak ada library pihak ketiga, dan tidak membutuhkan build step. Semua logika dijalankan melalui satu entry point (`index.php`) dengan sistem routing berbasis query string (`?page=...`).

Cocok untuk:
- Pembelajaran dasar MVC dengan PHP native
- Aplikasi CRUD sederhana
- Prototipe cepat dengan Laragon

---

## Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Bahasa | PHP (Native, tanpa framework eksternal) |
| Arsitektur | Model-View-Controller (MVC) |
| Database | MySQL / MariaDB (via `mysqli`) |
| Web Server | Apache / Nginx (diuji dengan Laragon) |
| Frontend | HTML + CSS inline, JavaScript vanilla |
| Auth | PHP Session + `password_hash` / `password_verify` |

---

## Struktur Direktori

```
frameworkold/
├── index.php                  # Entry point & halaman login utama
├── .htaccess                  # Rewrite rule (Apache)
├── CLAUDE.md                  # Konteks project untuk AI (Claude)
├── API/                       # (Kosong) Tempat menaruh endpoint API
├── App/                       # Inti aplikasi (MVC)
│   ├── Controls/              # Controllers (logika proses)
│   │   ├── login.control.php
│   │   └── data.control.php
│   ├── Models/               # Models (akses database)
│   │   ├── login.model.php
│   │   └── data.model.php
│   ├── Route/                # Router (pemetaan URL ke file)
│   │   ├── pages.php         # Dispatcher utama (?page=)
│   │   ├── controls.php      # Router ke controller
│   │   └── views.php         # Router ke view
│   └── Views/                # Views (tampilan HTML)
│       ├── login.view.php
│       ├── data.view.php
│       └── data.form.php
├── Dashboard/                 # Panel siap pakai (bukan MVC murni)
│   ├── admin/
│   │   ├── index.php
│   │   └── logout.php
│   └── user/
│       ├── index.php
│       └── logout.php
├── Database/
│   └── Schema.sql            # Struktur database (import ke MySQL)
└── Librari/
    └── inc.koneksi.php       # Koneksi database (mysqli)
```

---

## Cara Kerja (Request Flow)

Alur standar aplikasi:

```
Browser
  │
  ▼
index.php  ──(session_start + include Route/pages.php)
  │
  ▼
App/Route/pages.php  ── baca ?page=views  ATAU  ?page=controls
  │
  ├── page=views    → Route/views.php   → App/Views/*.view.php
  │
  └── page=controls → Route/controls.php → App/Controls/*.control.php
                                              │
                                              ├── include Model
                                              ├── proses data (INSERT/UPDATE/DELETE)
                                              └── redirect / include View
```

**Contoh URL:**
- `index.php?page=views&views=dataViews` → menampilkan tabel data
- `index.php?page=controls&controls=loginControl` → memproses login (POST)
- `index.php?page=controls&controls=dataControl&kdhapus=ABC` → hapus data

---

## Alur Lengkap (Sequence Diagram)

Berikut adalah urutan interaksi antar komponen untuk 3 skenario utama agar alur mudah dipahami manusia maupun AI.

### 1. Alur Login (User → Dashboard)

```
[Browser]                [index.php]          [Route/pages.php]      [controls.php]        [login.model.php]      [DB / users]        [Dashboard]
   |                        |                       |                     |                      |                     |                  |
   |-- POST login --------->|                       |                     |                      |                     |                  |
   |   (username,pass)      |-- include ----------->|                     |                      |                     |                  |
   |                        |                       |-- ?page=controls -->|                      |                     |                  |
   |                        |                       |                     |-- include ---------->|                     |                  |
   |                        |                       |                     |                      |-- cekLogin() ------>|                  |
   |                        |                       |                     |                      |   SELECT + verify   |-- cek ----------->|
   |                        |                       |                     |                      |<-- user / false -----|<-- row -----------|
   |                        |                       |                     |<-- $user ------------|                      |                  |
   |                        |                       |                     |-- set $_SESSION -----|                      |                  |
   |                        |                       |                     |   ['user_login']     |                      |                  |
   |                        |                       |                     |-- session_regenerate |                      |                  |
   |<--------------------------- header Location (redirect) ------------------------------------|                      |                  |
   |-- GET Dashboard/admin/-->| (level=admin)       |                     |                      |                      |                  |
   |                        |                       |                     |                      |                      |-- cek level ----->|
   |<-- Tampilkan layout + include Route/pages.php --------------------------------------------|                      |                  |
```

**Langkah demi langkah:**
1. User mengisi form di `index.php` (atau `login.view.php`) lalu submit POST ke `?page=controls&controls=loginControl`.
2. `index.php` memanggil `App/Route/pages.php` → router membaca `?page=controls` → memuat `controls.php`.
3. `controls.php` membaca `?controls=loginControl` → memuat `App/Controls/login.control.php`.
4. Controller meng-include `login.model.php` + `inc.koneksi.php`, lalu memanggil `cekLogin()`.
5. Model menjalankan prepared statement ke tabel `users`, memverifikasi password dengan `password_verify()`.
6. Jika cocok → controller menyimpan data ke `$_SESSION['user_login']`, regenerate session id, lalu `header("Location: Dashboard/admin|user/index.php")`.
7. Dashboard memeriksa `level` di session; jika sesuai, menampilkan layout dan meng-include `Route/pages.php` untuk konten dinamis.

---

### 2. Alur Tampil Data (CRUD - Read)

```
[Browser]           [Dashboard/admin/index.php]   [Route/pages.php]    [views.php]         [data.view.php]      [data.model.php]      [DB / tb_data]
   |                         |                           |                  |                    |                     |                     |
   |-- ?page=views --------->|                           |                  |                    |                     |                     |
   |   &views=dataViews      |-- include Route/pages.php>|                  |                    |                     |                     |
   |                         |                           |-- ?page=views -->|                    |                     |                     |
   |                         |                           |                  |-- ?views=dataViews>|                     |                     |
   |                         |                           |                  |                    |-- include --------->|                     |
   |                         |                           |                  |                    |-- getAllData() ---->|                     |
   |                         |                           |                  |                    |                     |-- SELECT * -------->|
   |                         |                           |                  |                    |<-- mysqli_result ---|<-- rows ------------|
   |                         |                           |                  |<-- render tabel ---|                     |                     |
   |<-- HTML tabel + tombol Tambah/Edit/Hapus ------------------------------------------------|                     |                     |
```

**Langkah demi langkah:**
1. Dashboard meng-include `Route/pages.php`; router membaca `?page=views` → `views.php` → `?views=dataViews` → `data.view.php`.
2. View meng-include `data.model.php` lalu memanggil `getAllData($koneksi)`.
3. Model mengeksekusi `SELECT * FROM tb_data ORDER BY id_data`.
4. View melakukan `while (mysqli_fetch_assoc())` untuk merender baris tabel beserta tombol aksi.

---

### 3. Alur Simpan / Hapus Data (CRUD - Create / Delete)

```
[Browser]           [data.view.php]      [Route/pages.php]   [controls.php]       [data.control.php]    [data.model.php]      [DB / tb_data]
   |                       |                    |                  |                    |                     |                     |
   |-- POST submit ------->| (form modal)       |                  |                    |                     |                     |
   |   (idData,data1,data2)|                    |-- ?page=controls>|                    |                     |                     |
   |                       |                    |                  |-- ?controls= ----->|                     |                     |
   |                       |                    |                  |   dataControl     |-- include model --->|                     |
   |                       |                    |                  |                    |-- tambahData() ---->|                     |
   |                       |                    |                  |                    |                     |-- INSERT ----------->|
   |                       |                    |                  |                    |<-- true ------------|<-- ok ---------------|
   |<-- JS redirect --------------------------------------------------------------|  document.location    |                     |
   |   ?page=views&views=dataViews                                              |  ='...dataViews'      |                     |
   |                       |                    |                  |  (untuk hapus: GET kdhapus → hapusData() → DELETE)                     |
```

**Langkah demi langkah:**
1. User mengisi form di modal (`data.form.php`) lalu submit POST ke `?page=controls&controls=dataControl`.
2. Controller membaca `POST['submit']` → escape input → panggil `tambahData()`.
3. Model mengeksekusi `INSERT INTO tb_data`.
4. Controller mencetak pesan & melakukan redirect via JavaScript ke `?page=views&views=dataViews` sehingga data baru tampil.
5. **Hapus:** link `?page=controls&controls=dataControl&kdhapus=ID` → controller panggil `hapusData()` → `DELETE FROM tb_data WHERE id_data=ID`.

---

### Ringkasan Aturan Routing (Quick Reference)

| Aksi | URL yang dipanggil | Komponen yang aktif |
|------|-------------------|---------------------|
| Lihat login | `index.php` | `index.php` (form inline) |
| Proses login | `index.php?page=controls&controls=loginControl` | `login.control.php` → `login.model.php` |
| Logout | `Dashboard/.../logout.php?logout` | `logout()` di model |
| Lihat data | `?page=views&views=dataViews` | `data.view.php` → `data.model.php` |
| Tambah data | POST `?page=controls&controls=dataControl` (`submit`) | `data.control.php` → `tambahData()` |
| Edit data | `?page=views&views=dataViews&idData=ID&edit=1` | `data.form.php` (mode edit) |
| Update data | POST `?page=controls&controls=dataControl` (`update`) | `data.control.php` → `updateData()` |
| Hapus data | `?page=controls&controls=dataControl&kdhapus=ID` | `data.control.php` → `hapusData()` |

---

## Routing

Routing dilakukan secara berurutan melalui 3 file di `App/Route/`:

### 1. `pages.php` (Dispatcher Utama)
Membaca parameter `?page=` dan menyerahkan ke router berikutnya.

| Nilai `?page=` | File yang dimuat |
|----------------|------------------|
| `views` | `Route/views.php` |
| `controls` | `Route/controls.php` |

### 2. `views.php` (View Router)
Membaca parameter `?views=`:

| Nilai `?views=` | File View |
|-----------------|-----------|
| `dataViews` | `App/Views/data.view.php` |
| `login` | `App/Views/login.view.php` |

### 3. `controls.php` (Controller Router)
Membaca parameter `?controls=`:

| Nilai `?controls=` | File Controller |
|--------------------|-----------------|
| `dataControl` | `App/Controls/data.control.php` |
| `loginControl` | `App/Controls/login.control.php` |

> **Catatan:** Setiap router menggunakan `switch` dan melakukan pengecekan `file_exists()` sebelum `include`. Jika file tidak ditemukan, akan mencetak pesan error dan berhenti.

---

## Model

File di `App/Models/` berisi fungsi-fungsi yang berinteraksi langsung dengan database menggunakan `mysqli`.

### `login.model.php`
| Fungsi | Keterangan |
|--------|------------|
| `cekLogin($koneksi, $username, $password)` | Verifikasi user via prepared statement + `password_verify()`. Mengembalikan array user atau `false`. |
| `cekSession()` | Cek apakah session login ada; jika tidak, redirect ke login. |
| `logout()` | Hancurkan session + cookie, lalu redirect. |

### `data.model.php`
| Fungsi | Keterangan |
|--------|------------|
| `tambahData($koneksi, $idData, $data1, $data2)` | INSERT ke `tb_data`. |
| `updateData($koneksi, $idData, $data1, $data2)` | UPDATE `tb_data` by `id_data`. |
| `hapusData($koneksi, $kdhapus)` | DELETE `tb_data` by `id_data`. |
| `getAllData($koneksi)` | SELECT semua data, ORDER BY `id_data`. |
| `getDataById($koneksi, $idData)` | SELECT satu baris by `id_data`. |

> **⚠️ Perhatian keamanan:** Fungsi di `data.model.php` menggunakan string interpolation langsung ke SQL (`"INSERT ... '$idData'"`). Meskipun input sudah di-escape di controller dengan `mysqli_real_escape_string`, sebaiknya gunakan *prepared statement* seperti pada `login.model.php` untuk konsistensi keamanan.

---

## View

File di `App/Views/` mencampur HTML dan PHP (template sederhana).

| File | Isi |
|------|-----|
| `login.view.php` | Halaman login mandiri (form POST ke `loginControl`). |
| `data.view.php` | Tabel data + modal form (include `data.form.php`). Menampilkan tombol Tambah/Edit/Hapus. |
| `data.form.php` | Form input data. Jika `?idData=` ada, mode edit (field `idData` readonly). |

View menggunakan CSS variable (`--primary`, `--accent`, dll) yang didefinisikan di Dashboard.

---

## Controller

File di `App/Controls/` menangani logika proses (biasanya merespons POST/GET lalu redirect).

### `login.control.php`
- Jika `POST['login']` → panggil `cekLogin()`, set `$_SESSION['user_login']`, lalu redirect ke `Dashboard/admin/` atau `Dashboard/user/` berdasarkan `level`.
- Jika `GET['logout']` → panggil `logout()`.
- Mencegah *session fixation* dengan `session_regenerate_id(true)`.

### `data.control.php`
Menangani aksi CRUD berdasarkan parameter:
- `POST['submit']` → `tambahData()`
- `POST['update']` → `updateData()`
- `GET['kdhapus']` → `hapusData()`
- `GET['kdedit']` → ambil data lalu `include data.form.php`

Setelah sukses, controller melakukan redirect via JavaScript (`document.location=...`) kembali ke view.

---

## Database

Konfigurasi database ada di `Librari/inc.koneksi.php`:

```php
$host     = "localhost";
$username = "root";
$password = "";
$database = "frameworkbydmz";
```

Import struktur tabel dari `Database/Schema.sql`. Tabel yang dibuat:

| Tabel | Keterangan |
|-------|------------|
| `tb_data` | Menyimpan data CRUD (`id_data`, `data_1`, `data_2`). |
| `users` | Digunakan oleh `login.model.php` (`id`, `username`, `password`, `nama_lengkap`, `level`). |
| `tb_user` | Tabel alternatif (legacy), belum dipakai aktif. |

> **Penting:** Password di tabel `users` harus di-hash dengan `password_hash()` karena `cekLogin()` menggunakan `password_verify()`.

---

## Authentication & Session

- Session disimpan di `$_SESSION['user_login']` dengan struktur:
  ```php
  [
    'id'           => ...,
    'username'     => ...,
    'nama_lengkap' => ...,
    'level'        => 'admin' | 'user'
  ]
  ```
- `level` menentukan ke mana user diarahkan setelah login (admin → `Dashboard/admin/`, user → `Dashboard/user/`).
- Dashboard melakukan pengecekan `level` di bagian atas file sebelum menampilkan konten.

---

## Dashboard

Folder `Dashboard/` berisi panel admin & user yang **tidak** melalui router MVC — mereka adalah halaman PHP mandiri yang meng-`include` `App/Route/pages.php` untuk menampilkan konten dinamis di dalam layoutnya.

| File | Fungsi |
|------|--------|
| `Dashboard/admin/index.php` | Layout admin (sidebar ungu), include router, cek level `admin`. |
| `Dashboard/user/index.php` | Layout user (sidebar hijau), include router, cek level `user`. |
| `Dashboard/admin/logout.php` | Hancurkan session, kembali ke `index.php`. |
| `Dashboard/user/logout.php` | Sama untuk user. |

---

## Cara Instalasi

1. **Letakkan project** di folder web server (mis. Laragon: `C:\laragon\www\frameworkold`).
2. **Buat database** MySQL bernama `frameworkbydmz`.
3. **Import skema**:
   ```bash
   mysql -u root frameworkbydmz < Database/Schema.sql
   ```
4. **Buat user demo** (password di-hash):
   ```sql
   INSERT INTO users (username, password, nama_lengkap, level)
   VALUES ('admin', PASSWORD_HASH('admin123', PASSWORD_DEFAULT), 'Administrator', 'admin'),
          ('user',  PASSWORD_HASH('user123',  PASSWORD_DEFAULT), 'User Biasa', 'user');
   ```
5. **Sesuaikan koneksi** di `Librari/inc.koneksi.php` jika perlu.
6. **Akses** via browser: `http://frameworkold.test` (atau `http://localhost/frameworkold`).

---

## Akun Demo

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| User | `user` | `user123` |

---

## Cara Menambah Fitur Baru

**1. Tambah View baru**
- Buat `App/Views/xxx.view.php`.
- Daftarkan di `App/Route/views.php` dengan case `?views=xxxView`.

**2. Tambah Controller baru**
- Buat `App/Controls/xxx.control.php`.
- Daftarkan di `App/Route/controls.php` dengan case `?controls=xxxControl`.

**3. Tambah Model/Query baru**
- Tambah fungsi di `App/Models/xxx.model.php` (atau buat file baru & `include` di controller).
- Gunakan prepared statement untuk keamanan.

**4. Hubungkan dari Dashboard**
- Tambah link menu di `Dashboard/admin/index.php` atau `Dashboard/user/index.php` mengarah ke `?page=views&views=xxxView`.

---

## Catatan untuk AI / Developer

Panduan ini ditujukan agar AI (seperti Claude/Cline) atau manusia dapat memodifikasi framework dengan aman:

1. **Entry point tunggal** adalah `index.php`. Jangan buat file PHP yang diakses langsung tanpa lewat router kecuali di `Dashboard/`.
2. **Konvensi penamaan:**
   - Controller file: `*.control.php`, dipanggil via `?controls=...Control`
   - View file: `*.view.php`, dipanggil via `?views=...View`
   - Model file: `*.model.php`, berisi fungsi `snake_case`
3. **Jangan hapus** `session_start()` di `index.php` — dibutuhkan oleh seluruh flow.
4. **Keamanan:** Ganti query string interpolation di `data.model.php` dengan prepared statement agar konsisten dengan `login.model.php`.
5. **`.htaccess`** mengarahkan semua request tidak-file ke `index.php?url=$1`, namun routing aktif menggunakan query string `?page=` (bukan `url`).
6. **`CLAUDE.md`** sudah berisi ringkasan singkat untuk AI — selalu sinkronkan jika struktur berubah.
7. **`API/`** saat ini kosong; bisa dijadikan tempat endpoint JSON (mis. `API/users.php`) di masa depan.

---

## Lisensi

Project ini bebas digunakan untuk pembelajaran dan pengembangan.