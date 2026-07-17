# PROMPT UNTUK AI — Membangun Aplikasi dengan FrameworkByDMZ

Salin seluruh isi file ini dan berikan ke AI (Claude, Cline, ChatGPT, dsb) setiap kali Anda ingin membuat aplikasi baru di atas framework ini. Ganti bagian **[DESKRIPSI APLIKASI ANDA]** dengan kebutuhan spesifik Anda.

---

## INSTRUKSI UNTUK AI

Kamu adalah developer ahli PHP yang akan membangun sebuah aplikasi web di atas **FrameworkByDMZ** — sebuah framework PHP native (tanpa Composer/library eksternal) dengan arsitektur MVC sederhana berbasis query string.

### Konteks Framework (WAJIB PATUHI)

**Entry Point:** `index.php` memanggil `session_start()` lalu meng-include `App/Route/pages.php` sebagai dispatcher. Jangan buat file PHP yang diakses langsung tanpa lewat router (kecuali di `Dashboard/`).

**Routing berjenjang (baca `?page=` lalu `?views=` / `?controls=`):**
1. `App/Route/pages.php` → `?page=views` muat `views.php`, `?page=controls` muat `controls.php`.
2. `App/Route/views.php` → `?views=NAMAView` muat `App/Views/NAMA.view.php`.
3. `App/Route/controls.php` → `?controls=NAMAControl` muat `App/Controls/NAMA.control.php`.

**Struktur direktori:**
- `App/Controls/` → controller (`*.control.php`)
- `App/Models/`   → model (`*.model.php`, fungsi `snake_case`)
- `App/Views/`    → view/tampilan (`*.view.php`, `*.form.php`)
- `App/Route/`    → router (`pages.php`, `views.php`, `controls.php`)
- `Librari/inc.koneksi.php` → koneksi DB (`$koneksi`, db `frameworkbydmz`)
- `Dashboard/admin/` & `Dashboard/user/` → panel siap pakai (include `App/Route/pages.php`)
- `Database/Schema.sql` → struktur tabel

**Alur standar (Request Flow):**
```
Browser → index.php → App/Route/pages.php
  ├─ ?page=views    → views.php    → App/Views/*.view.php  (tampil data, include Model)
  └─ ?page=controls → controls.php → App/Controls/*.control.php (proses POST/GET → include Model → redirect/include View)
```

**Authentication:** Session `$_SESSION['user_login'] = ['id','username','nama_lengkap','level']`. `level` = `admin`/`user` menentukan redirect & akses Dashboard. Password di tabel `users` menggunakan `password_hash()` + `password_verify()`.

**Database:** MySQL via `mysqli`. Model berinteraksi langsung dengan DB. Gunakan **prepared statement** untuk keamanan (contoh: lihat `login.model.php`).

### ATURAN EMAS
1. Jangan hapus `session_start()` di `index.php`.
2. Ikuti konvensi penamaan: `*.control.php` / `*.view.php` / `*.model.php`.
3. Daftarkan setiap view/controller BARU dengan `case` di router terkait (`views.php` / `controls.php`).
4. Hubungkan menu dari `Dashboard/admin/index.php` atau `Dashboard/user/index.php` ke `?page=views&views=NAMAView`.
5. Untuk query DB, gunakan prepared statement (hindari string interpolation langsung).
6. Setelah proses simpan/update/hapus di controller, redirect kembali ke view via `echo "<script>document.location='?page=views&views=NAMAView';</script>"; exit;`.

---

## TUGAS YANG DIMINTA

Buatkan aplikasi berikut menggunakan FrameworkByDMZ:

**[DESKRIPSI APLIKASI ANDA — ISI DI SINI]**
> Contoh: "Sistem Perpustakaan sederhana untuk mengelola data buku (kode buku, judul, pengarang, tahun) dengan fitur tambah, edit, hapus, dan lihat daftar. Ada halaman login, dashboard admin, dan dashboard user."

**Langkah yang harus kamu lakukan:**
1. Rancang struktur tabel MySQL baru (tambahkan ke `Database/Schema.sql` atau buat migrasi terpisah) sesuai kebutuhan aplikasi.
2. Buat Model (`App/Models/NAMA.model.php`) berisi fungsi CRUD dengan prepared statement.
3. Buat View (`App/Views/NAMA.view.php` + `NAMA.form.php`) untuk menampilkan & memasukkan data (gunakan pola modal seperti `data.view.php`/`data.form.php`).
4. Buat Controller (`App/Controls/NAMA.control.php`) untuk memproses `submit`/`update`/`kdhapus`/`kdedit`.
5. Daftarkan route baru di `App/Route/views.php` dan `App/Route/controls.php`.
6. Tambahkan menu di `Dashboard/admin/index.php` (dan `Dashboard/user/index.php` jika perlu) mengarah ke view baru.
7. Jelaskan cara menjalankan & menguji aplikasi (import DB, akses URL).

**Output yang diharapkan:**
- Kode lengkap tiap file yang dibuat/diubah (bukan ringkasan).
- Penjelasan singkat alur aplikasi yang dibuat sesuai pola framework ini.
- Jika ada yang perlu diubah dari struktur inti framework, sebutkan dengan jelas dan jangan merusak flow yang sudah ada.

---

## CARA MENGGUNAKAN FILE INI
1. Buka `promt.md`.
2. Ganti teks di dalam `[DESKRIPSI APLIKASI ANDA — ISI DI SINI]` dengan aplikasi yang ingin dibuat.
3. Salin seluruh isi dan tempel ke AI (Claude/Cline/ChatGPT/dll) bersama konteks project (atau biarkan AI membaca `CLAUDE.md` & `README.md` di folder ini).
4. AI akan menghasilkan file-file aplikasi sesuai framework & alur yang sudah ditetapkan.