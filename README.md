# frameworkbyDMZ

Framework MVC sederhana berbasis **PHP Native** dengan struktur **Model - View - Controller (MVC)** dan sistem routing sederhana menggunakan parameter URL.

---

## Fitur

- CRUD Data
- Struktur MVC sederhana
- Routing berbasis URL
- Mudah dikembangkan menjadi modul baru
- Cocok untuk pembelajaran PHP Native

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
├── index.php                  # Entry point aplikasi
│
├── Route/
│   ├── pages.php              # Router utama
│   ├── views.php              # Router View
│   └── controls.php           # Router Controller
│
├── Views/
│   ├── data.view.php          # Halaman data
│   └── data.form.php          # Form tambah/edit
│
├── Controls/
│   └── data.control.php       # Controller CRUD
│
├── Models/
│   └── data.model.php         # Query database
│
└── Librari/
    └── inc.koneksi.php        # Koneksi database
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

# Format URL

## Menampilkan Halaman

```
?page=views&views=dataViews
```

## Proses Form

```
?page=controls&controls=dataControl
```

## Hapus Data

```
?page=controls&controls=dataControl&kdhapus=ID
```

## Edit Data

```
?page=views&views=dataViews&idData=ID
```

---

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
┌──────────────┐
│   Browser    │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│   Routing    │
└──────┬───────┘
       │
 ┌─────┴────────────┐
 ▼                  ▼
View           Controller
 │                  │
 └────────┬─────────┘
          ▼
        Model
          │
          ▼
      MySQL Database
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

Misalnya membuat modul **User**.

## 1. Model

```
Models/user.model.php
```

```php
function getAllUser($koneksi) {}
function tambahUser($koneksi) {}
function updateUser($koneksi) {}
function hapusUser($koneksi) {}
```

---

## 2. View

```
Views/user.view.php
```

---

## 3. Form

```
Views/user.form.php
```

---

## 4. Controller

```
Controls/user.control.php
```

---

## 5. Tambahkan Routing

### Route/views.php

```php
case 'userViews':
    include __DIR__ . '/../Views/user.view.php';
    break;
```

### Route/controls.php

```php
case 'userControl':
    include __DIR__ . '/../Controls/user.control.php';
    break;
```

---

## 6. Tambahkan Menu

```php
<a href="?page=views&views=userViews">
    User
</a>
```

---

# Fungsi Model

| Fungsi | Deskripsi |
|---------|-----------|
| `tambahData()` | Menambah data |
| `updateData()` | Mengubah data |
| `hapusData()` | Menghapus data |
| `getAllData()` | Mengambil seluruh data |
| `getDataById()` | Mengambil data berdasarkan ID |

---

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