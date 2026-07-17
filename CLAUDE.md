# FrameworkByDMZ - Project Context

Panduan konteks project ini ditujukan agar AI (Claude/Cline) dan developer manusia dapat memahami, menjelajahi, dan memodifikasi framework dengan cepat dan aman.

## Tech Stack
- **Bahasa:** PHP (Native / Custom MVC Framework) — tanpa Composer, tanpa library eksternal.
- **Arsitektur:** Model-View-Controller (MVC) sederhana berbasis query string.
- **Database:** MySQL / MariaDB via ekstensi `mysqli`.
- **Server Environment:** Laragon (Apache/Nginx, MySQL). Diuji di Windows 10.
- **Frontend:** HTML + CSS inline, JavaScript vanilla (modal, sidebar toggle).
- **Authentication:** PHP Session + `password_hash()` / `password_verify()`.

## Entry Point
- `index.php` adalah satu-satunya pintu masuk utama.
  - Memanggil `session_start()` di baris atas.
  - Meng-include `App/Route/pages.php` sebagai dispatcher.
  - Berisi juga halaman login inline (form POST ke `?page=controls&controls=loginControl`).

## Core Directories
- **Controllers:** `App/Controls/` (file `*.control.php`)
- **Models:** `App/Models/` (file `*.model.php`)
- **Views:** `App/Views/` (file `*.view.php`, `*.form.php`)
- **Routing:** `App/Route/` (`pages.php`, `controls.php`, `views.php`)
- **Custom Libraries:** `Librari/` (`inc.koneksi.php` = koneksi DB)
- **Dashboard (panel siap pakai):** `Dashboard/admin/`, `Dashboard/user/`
- **Database Schema:** `Database/Schema.sql`
- **API (kosong):** `API/`

## Routing (Query String Based)
Routing berjenjang melalui 3 file di `App/Route/`:

1. `pages.php` — membaca `?page=`:
   - `views`    → muat `views.php`
   - `controls` → muat `controls.php`
2. `views.php` — membaca `?views=`:
   - `dataViews` → `App/Views/data.view.php`
   - `login`     → `App/Views/login.view.php`
3. `controls.php` — membaca `?controls=`:
   - `dataControl` → `App/Controls/data.control.php`
   - `loginControl` → `App/Controls/login.control.php`

Setiap router menggunakan `switch` + `file_exists()` sebelum `include`. Jika file tidak ada → `die("...")`.

> Catatan: `.htaccess` mengarahkan request tidak-file ke `index.php?url=$1`, namun routing AKTIF menggunakan `?page=` (bukan `url`).

## Models (App/Models/)
- `login.model.php`:
  - `cekLogin($koneksi, $username, $password)` — prepared statement + `password_verify()` ke tabel `users`.
  - `cekSession()` — redirect ke login jika session kosong.
  - `logout()` — hancurkan session + cookie, lalu redirect.
- `data.model.php`:
  - `tambahData()`, `updateData()`, `hapusData()` — manipulasi `tb_data` (menggunakan string interpolation; input di-escape di controller).
  - `getAllData()` — `SELECT * FROM tb_data ORDER BY id_data`.
  - `getDataById()` — ambil 1 baris by `id_data`.

## Controllers (App/Controls/)
- `login.control.php`:
  - `POST['login']` → `cekLogin()` → set `$_SESSION['user_login']` → `session_regenerate_id(true)` → redirect ke `Dashboard/admin/` atau `Dashboard/user/` berdasar `level`.
  - `GET['logout']` → `logout()`.
- `data.control.php`:
  - `POST['submit']` → `tambahData()`
  - `POST['update']` → `updateData()`
  - `GET['kdhapus']` → `hapusData()`
  - `GET['kdedit']` → `getDataById()` lalu `include data.form.php`
  - Setelah sukses → redirect via JavaScript `document.location='?page=views&views=dataViews'`.

## Views (App/Views/)
- `login.view.php` — halaman login mandiri.
- `data.view.php` — tabel data + modal form (include `data.form.php`), tombol Tambah/Edit/Hapus.
- `data.form.php` — form input; mode edit jika `?idData=` ada (field `idData` readonly).

## Database
- Konfigurasi: `Librari/inc.koneksi.php` (`host=localhost`, `user=root`, `pass=`, `db=frameworkbydmz`).
- Skema: import `Database/Schema.sql`.
- Tabel:
  - `tb_data` (`id_data`, `data_1`, `data_2`) — data CRUD.
  - `users` (`id`, `username`, `password`, `nama_lengkap`, `level`) — dipakai `login.model.php`. Password HARUS di-hash (`password_hash()`).
  - `tb_user` — tabel legacy alternatif, belum dipakai aktif.

## Authentication & Session
- Session key: `$_SESSION['user_login']` = `['id', 'username', 'nama_lengkap', 'level']`.
- `level` menentukan redirect & akses Dashboard (`admin` → `Dashboard/admin/`, `user` → `Dashboard/user/`).
- Dashboard mengecek `level` di bagian atas file sebelum render konten.

## Dashboard (Dashboard/)
Panel PHP mandiri (bukan lewat router MVC murni) yang meng-include `App/Route/pages.php` untuk konten dinamis:
- `Dashboard/admin/index.php` — layout admin (sidebar ungu), cek level `admin`.
- `Dashboard/user/index.php` — layout user (sidebar hijau), cek level `user`.
- `Dashboard/admin/logout.php`, `Dashboard/user/logout.php` — destroy session → `index.php`.

## Build & Development Commands
- Serve: Jalankan via Laragon Virtual Host, mis. `http://frameworkold.test` (atau `http://localhost/frameworkold`).
- Import DB: `mysql -u root frameworkbydmz < Database/Schema.sql`
- Tidak ada build step, composer, atau dependency eksternal.

## Akun Demo
- Admin: `admin` / `admin123`
- User:  `user`  / `user123`

## Konvensi & Aturan Penting (untuk AI/Developer)
1. Jangan hapus `session_start()` di `index.php` — dibutuhkan seluruh flow.
2. Penamaan: Controller `*.control.php` (`?controls=...Control`), View `*.view.php` (`?views=...View`), Model `*.model.php` (fungsi `snake_case`).
3. Untuk fitur baru: buat file di `App/`, daftarkan case di router terkait, lalu hubungkan dari Dashboard.
4. Keamanan: ganti string interpolation di `data.model.php` dengan prepared statement agar konsisten dengan `login.model.php`.
5. `API/` masih kosong — bisa dijadikan endpoint JSON di masa depan.
6. Selalu sinkronkan dokumentasi (`README.md`) jika struktur berubah.