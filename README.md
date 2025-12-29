# Sistem Penyuluhan Sawit Digital

Platform lengkap untuk petani sawit mendapatkan informasi, kalkulator, dan edukasi terbaik tentang budidaya sawit.

## Deskripsi

Sistem Penyuluhan Sawit Digital adalah aplikasi web berbasis CodeIgniter 3 yang menyediakan berbagai fitur untuk membantu petani sawit dalam mengelola perkebunan mereka. Aplikasi ini mencakup kalkulator pupuk, kalkulator panen, informasi penyakit, artikel edukasi, dan harga TBS terkini.

## Prasyarat

Sebelum menginstal aplikasi ini, pastikan sistem Anda memenuhi persyaratan berikut:

- **PHP**: Versi 7.4 atau lebih tinggi
- **MySQL**: Versi 5.7 atau lebih tinggi (atau MariaDB 10.2+)
- **Web Server**: Apache 2.4+ atau Nginx
- **Extension PHP**: 
  - mysqli
  - mbstring
  - openssl
  - json
  - session

## Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd Sawit_Digital
```

### 2. Konfigurasi Database

1. Buat database MySQL dengan nama `sawit`:
```sql
CREATE DATABASE sawit CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Import tabel-tabel yang sudah ada ke database `sawit`:
   - `harga_tbs` - Tabel harga TBS per kabupaten
   - `users` - Tabel pengguna
   - `pupuk` - Tabel jenis pupuk
   - `artikel` - Tabel artikel/informasi
   - `penyakit` - Tabel penyakit sawit
   - `dosis` - Tabel dosis pupuk
   - `tanah` - Tabel jenis tanah
   - `kabupaten` - Tabel kabupaten
   - `kalkulasi_panen` - Tabel kalkulasi panen (opsional)

3. Edit file `application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',        // Sesuaikan dengan username MySQL Anda
    'password' => '',            // Sesuaikan dengan password MySQL Anda
    'database' => 'sawit',
    'dbdriver' => 'mysqli',
    // ... konfigurasi lainnya
);
```

### 3. Konfigurasi Base URL

Edit file `application/config/config.php` dan set base URL sesuai dengan lokasi instalasi Anda:

```php
$config['base_url'] = 'http://localhost/Sawit_Digital/';
```

Atau untuk production:
```php
$config['base_url'] = 'https://yourdomain.com/';
```

### 4. Set Permissions (Linux/Mac)

```bash
chmod -R 755 application/cache
chmod -R 755 application/logs
chmod -R 755 assets
```

### 5. Upload Directory

Pastikan folder `uploads` ada di root project untuk menyimpan gambar:
```bash
mkdir uploads
mkdir uploads/artikel
mkdir uploads/penyakit
chmod -R 755 uploads
```

## Menjalankan Aplikasi

1. Pastikan web server (Apache/Nginx) sudah berjalan
2. Pastikan MySQL sudah berjalan
3. Buka browser dan akses URL aplikasi:
   - **User Panel**: `http://localhost/Sawit_Digital/beranda`
   - **Admin Login**: `http://localhost/Sawit_Digital/admin/login`

### Login Admin Default
- **Email**: `admin@gmail.com`
- **Password**: `admin123`
- Password akan otomatis di-hash saat login pertama kali jika belum di-hash

## Struktur Folder

```
Sawit_Digital/
├── application/
│   ├── config/
│   │   ├── database.php      # Konfigurasi database
│   │   ├── routes.php        # Routing
│   │   └── autoload.php      # Auto-load libraries & helpers
│   ├── controllers/
│   │   ├── Dashboard.php     # Controller dashboard
│   │   ├── Auth.php          # Controller autentikasi
│   │   ├── Fertilizer.php    # Controller kalkulator pupuk
│   │   ├── Panen.php         # Controller kalkulator panen
│   │   ├── Penyakit.php      # Controller penyakit
│   │   ├── Informasi.php    # Controller informasi/artikel
│   │   ├── SearchController.php # Controller pencarian
│   │   └── Api.php           # Controller API AJAX
│   ├── models/
│   │   ├── Tbs_model.php     # Model harga TBS
│   │   ├── Article_model.php # Model artikel
│   │   ├── User_model.php    # Model pengguna
│   │   └── Fertilizer_model.php # Model pupuk
│   └── views/
│       ├── templates/
│       │   ├── header.php    # Template header
│       │   └── footer.php     # Template footer
│       ├── partials/
│       │   ├── shortcut_card.php
│       │   ├── tbs_table.php
│       │   └── article_card.php
│       ├── dashboard.php
│       ├── login.php
│       ├── register.php
│       ├── kalkulator_pupuk.php
│       ├── kalkulator_panen.php
│       ├── jenis_pupuk.php
│       ├── penyakit.php
│       ├── informasi.php
│       └── informasi_detail.php
├── assets/
│   ├── css/
│   │   ├── global.css
│   │   ├── dashboard.css
│   │   ├── kalkulator_pupuk.css
│   │   ├── kalkulator_panen.css
│   │   ├── jenis_pupuk.css
│   │   ├── penyakit.css
│   │   ├── informasi.css
│   │   └── auth.css
│   └── js/
│       ├── dashboard.js
│       ├── kalkulator_pupuk.js
│       ├── kalkulator_panen.js
│       └── search.js
└── README.md
```

## Fitur Utama

### Fitur Admin Panel

#### Menu Sidebar (Urutan sesuai requirement):
1. **Dashboard** - Ringkasan statistik
2. **Jenis Pupuk** - CRUD dengan upload gambar
3. **Jenis Penyakit** - CRUD dengan upload gambar
4. **Kabupaten** - CRUD
5. **Perusahaan** - CRUD dengan relasi kabupaten
6. **Informasi Tambahan** - CRUD artikel dengan upload gambar
7. **Harga TBS** - CRUD harga per perusahaan
8. **Jenis Tanah** - CRUD
9. **Kalkulasi Panen** - Lihat data dari user
10. **Dosis Pupuk** - Lihat data dari user
11. **Users** - Kelola pengguna (admin only)

#### CRUD dengan File Upload:
- **Jenis Pupuk**: Upload gambar ke `assets/img/pupuk/`
- **Jenis Penyakit**: Upload gambar ke `assets/img/penyakit/`
- **Informasi Tambahan**: Upload gambar header & thumbnail ke `assets/img/articles/`

### Fitur User Panel

#### Halaman Publik:
1. **Beranda** - Tampilkan harga TBS, fitur utama, artikel terbaru
2. **Kalkulator Pupuk** - Hitung dosis pupuk, **bisa save ke database**
3. **Kalkulator Panen** - Hitung hasil panen, **bisa save ke database**
4. **Jenis Pupuk** - Lihat data dari admin
5. **Penyakit** - Lihat data dari admin
6. **Informasi** - Lihat artikel dari admin
7. **Harga TBS** - Lihat harga dari admin

#### User Input → Admin View:
- **Kalkulator Panen**: Data tersimpan di `kalkulasi_panen`, terlihat di Admin → Kalkulasi Panen
- **Dosis Pupuk**: Data tersimpan di `dosis_pupuk`, terlihat di Admin → Dosis Pupuk

### Alur Data

#### Admin → User (Master Data):
1. Admin input data di admin panel (Jenis Pupuk, Penyakit, dll)
2. Data otomatis tersimpan di database
3. User melihat data di halaman publik

#### User → Admin (Kalkulasi):
1. User isi form kalkulator (Panen atau Pupuk)
2. User klik "Simpan Hasil Perhitungan"
3. Data tersimpan di database
4. Admin melihat data di admin panel

## Keamanan

### CSRF Protection
Aktifkan CSRF protection di `application/config/config.php`:
```php
$config['csrf_protection'] = TRUE;
```

### Password Hashing
Aplikasi menggunakan `password_hash()` dan `password_verify()` untuk keamanan password. Pastikan PHP versi 7.4+ untuk dukungan penuh.

### Input Validation
Semua input form divalidasi menggunakan CodeIgniter Form Validation library.

### SQL Injection Prevention
Menggunakan CodeIgniter Query Builder untuk mencegah SQL injection.

## Sistem Login Berdasarkan Role

### Deskripsi
Sistem login otomatis mengarahkan user ke halaman yang sesuai berdasarkan role mereka:
- **Admin** → Halaman Admin (`admin/dashboard`)
- **User** → Halaman User (`beranda`)

### Cara Kerja

#### Login User (Halaman User)
**URL:** `masuk` atau `login`  
**Controller:** `user/Autentikasi/login`

**Alur:**
1. User memasukkan email dan password
2. Sistem verifikasi kredensial
3. Setelah login berhasil, sistem cek role:
   - Jika `role = 'admin'` → Redirect ke `admin/dashboard`
   - Jika `role = 'user'` → Redirect ke `beranda`

#### Login Admin (Halaman Admin)
**URL:** `admin/login`  
**Controller:** `admin/Admin_auth/login`

**Alur:**
1. Admin memasukkan email dan password
2. Sistem verifikasi kredensial
3. Sistem cek role:
   - Hanya `role = 'admin'` yang bisa login
   - Jika role bukan admin → Error: "Anda tidak memiliki akses admin"
4. Setelah login berhasil → Redirect ke `admin/dashboard`

### Link Login

#### Untuk User:
- `http://localhost/Sawit_Digital/masuk`
- `http://localhost/Sawit_Digital/login`

#### Untuk Admin:
- `http://localhost/Sawit_Digital/admin/login`

### Catatan Penting Login

✅ **Satu Form Login untuk Semua**
- User bisa login di halaman `masuk` dengan email/password apapun
- Sistem otomatis redirect berdasarkan role

✅ **Admin Bisa Akses User**
- Admin yang sudah login bisa akses halaman user
- Ada link "Kembali ke Beranda" di header admin
- Ada link "Kembali ke Admin" di header user (jika admin)

✅ **User Tidak Bisa Akses Admin**
- User biasa tidak bisa akses halaman admin
- Akan di-redirect dengan error message

## Role-Based Access

### Roles dan Akses
- **Admin**: Full CRUD semua master data
- **User**: Read-only untuk master data, bisa input kalkulasi

### Proteksi Route
Routes are protected via `MY_Controller`:
- `require_login()`: Check if user is logged in
- `require_role(['admin', 'penyuluh'])`: Check specific roles
- `require_admin()`: Admin only
- `require_admin_or_penyuluh()`: Admin or penyuluh
- `can_edit()`: Check if user can edit
- `can_delete()`: Check if user can delete (admin only)

### User (Default)
- Akses ke semua kalkulator
- Melihat informasi dan artikel
- Melihat harga TBS
- Melihat jenis pupuk dan penyakit

### Admin
- Semua akses user
- Tambah/edit/hapus artikel
- Tambah/edit/hapus pupuk
- Manajemen data lainnya

## API Endpoints

### AJAX Endpoints

1. **GET /api/tbs_prices**
   - Parameter: `id_kabupaten` (opsional)
   - Return: HTML tabel harga TBS

2. **GET /api/search**
   - Parameter: `q` (keyword)
   - Return: JSON hasil pencarian

## Sinkronisasi Data Admin dan User

### Konsistensi Data

✅ **Ya, codingan sudah sama dan konsisten!**

Admin dan User menggunakan **model yang sama** (`Harga_tbs_model`), sehingga:
- ✅ Data yang di-update di admin **langsung** terlihat di user
- ✅ Tidak ada delay atau cache
- ✅ Perubahan langsung tersinkronisasi

### Sinkronisasi Real-time

✅ **Tidak Perlu Refresh Manual**
- Data langsung tersinkronisasi karena menggunakan database yang sama
- Tidak ada cache yang menghalangi
- Perubahan langsung terlihat setelah admin update

### Contoh Alur Sinkronisasi:
1. **Admin update harga** di `admin/harga_tbs/update/1`
   - Harga: Rp 3.300 → Rp 3.400
   - Data langsung ter-update di database

2. **User refresh halaman** `beranda`
   - Sistem membaca data terbaru dari database
   - Harga langsung terlihat: Rp 3.400
   - Perbandingan otomatis dihitung ulang

### Perbandingan Harga

#### Logika Perbandingan:
1. Ambil data hari ini dari database
2. Cari data kemarin (atau data terakhir yang tersedia)
3. Hitung selisih
4. Tampilkan dengan warna:
   - 🟢 Hijau: Naik
   - 🔴 Merah: Turun
   - ⚪ Strip (-): Tidak ada perubahan

#### Update Otomatis:
- Ketika admin update harga hari ini → Perbandingan otomatis dihitung ulang
- Ketika admin update harga kemarin → Perbandingan otomatis berubah
- Semua menggunakan data real-time dari database

## Troubleshooting

### Database Error
- Pastikan database `sawit` sudah dibuat
- Periksa kredensial di `database.php`
- Pastikan semua tabel sudah di-import

### 404 Error
- Pastikan `.htaccess` file ada di root (untuk Apache)
- Periksa konfigurasi `base_url` di `config.php`
- Pastikan mod_rewrite aktif (Apache)

### Session Error
- Pastikan folder `application/cache` dan `application/logs` writable
- Periksa konfigurasi session di `config.php`

### CSS/JS Tidak Load
- Periksa path `base_url()` di views
- Pastikan folder `assets` ada di root
- Periksa permission folder `assets`
- Clear browser cache, pastikan `base_url` di config benar

### Login Admin Gagal
- Jalankan `fix_admin_password.php` untuk hash password
- Pastikan email dan password benar
- Cek role user di database

### Gambar Tidak Muncul
- Cek path file, pastikan folder ada dan writable
- Pastikan folder `assets/img/` dan subfoldernya memiliki permission write
- File upload maksimal 2MB
- Format gambar: JPG, PNG, GIF, WEBP

### Data Tidak Tersimpan
- Cek permission folder, pastikan database connection benar
- Pastikan folder `assets/img/` dan subfoldernya memiliki permission write
- Cek log error di `application/logs/`
- Browser console untuk error JavaScript

## Pengembangan

### Menambah Fitur Baru

1. Buat controller di `application/controllers/`
2. Buat model di `application/models/` (jika perlu)
3. Buat view di `application/views/`
4. Tambahkan route di `application/config/routes.php`
5. Tambahkan CSS/JS jika diperlukan

### Database Migration

Aplikasi ini menggunakan tabel yang sudah ada. Untuk menambah tabel baru:
1. Buat migration SQL
2. Import ke database
3. Update model yang relevan

## Branding & Colors

- **Primary**: #1B5E20 (hijau gelap)
- **Background**: #FAFAFA (putih krem)
- **Success**: #2E7D32
- **Warning**: #F9A825
- **Danger**: #C62828
- **Info**: #0277BD

## Catatan Penting

1. Pastikan folder `assets/img/` dan subfoldernya memiliki permission write
2. File upload maksimal 2MB
3. Format gambar: JPG, PNG, GIF, WEBP
4. Semua label dan instruksi menggunakan bahasa Indonesia yang sederhana
5. Data yang diinput user (kalkulasi) hanya terlihat di admin panel

---

## Developer Guide

Dokumentasi lengkap untuk developer yang mengembangkan atau memelihara sistem Sawit Digital.

### 📋 Daftar Isi Developer Guide

1. [Struktur Folder Lengkap](#struktur-folder-lengkap)
2. [Routing Detail](#routing-detail)
3. [Features Implemented](#features-implemented-detail)
4. [Access Control Detail](#access-control-detail)
5. [Path Gambar Detail](#path-gambar-detail)
6. [Setup Instructions Admin](#setup-instructions-admin)
7. [Sistem Backup Data Harga TBS](#sistem-backup-data-harga-tbs-detail)
8. [Color Scheme & Dependencies](#color-scheme--dependencies-detail)
9. [Next Steps Development](#next-steps-development)

### Struktur Folder Lengkap

Proyek ini dipisahkan menjadi dua bagian utama: **Admin** dan **User/Public** dengan struktur folder yang jelas.

```
application/
├── core/
│   └── MY_Controller.php          # Base controller with role checking
│
├── controllers/
│   ├── admin/                     # Controllers untuk admin panel
│   │   ├── Admin_auth.php         # Admin authentication
│   │   ├── Admin_dashboard.php     # Dashboard controller
│   │   ├── Admin_harga_tbs.php    # Harga TBS CRUD
│   │   ├── Admin_perusahaan.php   # Perusahaan CRUD
│   │   ├── Admin_kabupaten.php    # Kabupaten CRUD
│   │   ├── Admin_pupuk.php        # Pupuk CRUD
│   │   ├── Admin_penyakit.php     # Penyakit CRUD
│   │   ├── Admin_informasi.php    # Informasi/Artikel CRUD
│   │   ├── Admin_tanah.php         # Tanah CRUD
│   │   ├── Admin_kalkulator_panen.php
│   │   ├── Admin_users.php         # Users management
│   │   └── Admin_settings.php      # Settings
│   │
│   └── user/                      # Controllers untuk user/public
│       ├── Beranda.php            # Beranda controller
│       ├── Informasi.php           # Informasi controller
│       ├── Autentikasi.php        # Authentication
│       ├── Pupuk.php              # Kalkulator pupuk
│       ├── Panen.php              # Kalkulator panen
│       ├── Penyakit.php           # Penyakit
│       ├── Pencarian.php           # Search
│       └── Api.php                # API endpoints
│
├── models/                        # Models (shared)
│   ├── Harga_tbs_model.php        # Harga TBS model
│   ├── Perusahaan_model.php       # Perusahaan model
│   ├── Kabupaten_model.php        # Kabupaten model
│   ├── Informasi_tambahan_model.php
│   ├── Pengguna_model.php
│   ├── Jenis_pupuk_model.php
│   └── ... (other models)
│
└── views/
    ├── admin/                     # Views untuk admin panel
    │   ├── auth/
    │   │   └── login.php          # Admin login page
    │   ├── dashboard/
    │   │   └── index.php          # Dashboard view
    │   ├── layout/
    │   │   ├── header.php         # Admin layout header
    │   │   └── footer.php         # Admin layout footer
    │   ├── harga_tbs/
    │   │   ├── index.php          # List view
    │   │   └── form.php           # Create/Update form
    │   ├── perusahaan/
    │   │   ├── index.php          # List view
    │   │   └── form.php           # Create/Update form
    │   ├── kabupaten/
    │   │   ├── index.php          # List view
    │   │   └── form.php           # Create/Update form
    │   ├── pupuk/
    │   ├── penyakit/
    │   ├── informasi/
    │   ├── tanah/
    │   ├── kalkulator_panen/
    │   ├── users/
    │   └── settings/
    │
    └── user/                      # Views untuk user/public
        ├── autentikasi/
        │   ├── masuk.php
        │   └── daftar.php
        ├── beranda/
        │   └── index.php
        ├── informasi/
        │   ├── index.php
        │   └── detail.php
        ├── kalkulator/
        │   ├── pupuk.php
        │   └── panen.php
        ├── penyakit/
        │   └── index.php
        ├── pupuk/
        │   └── jenis.php
        ├── pencarian/
        │   └── hasil.php
        ├── partials/
        │   ├── kartu_artikel.php
        │   ├── kartu_shortcut.php
        │   └── tabel_tbs.php
        └── templates/
            ├── header.php
            └── footer.php

assets/
├── img/
│   ├── articles/          # Gambar artikel/informasi
│   ├── hero/              # Gambar hero banner
│   ├── logo/              # Logo aplikasi
│   ├── penyakit/          # Gambar penyakit sawit
│   ├── pupuk/             # Gambar pupuk
│   └── users/             # Foto profil user
│
├── css/
│   ├── global.css         # CSS global (shared)
│   ├── admin/             # CSS untuk admin
│   │   └── main.css
│   └── user/              # CSS untuk user/public
│       ├── beranda.css
│       ├── informasi.css
│       ├── autentikasi.css
│       ├── kalkulator_pupuk.css
│       ├── kalkulator_panen.css
│       ├── jenis_pupuk.css
│       └── penyakit.css
│
└── js/
    ├── admin/             # JavaScript untuk admin
    │   └── main.js
    └── user/              # JavaScript untuk user/public
        ├── beranda.js
        ├── informasi.js
        ├── kalkulator_pupuk.js
        ├── kalkulator_panen.js
        ├── pencarian.js
        └── dropdown.js
```

**Keuntungan Struktur Ini:**
1. **Pemisahan yang Jelas**: Admin dan user terpisah dengan jelas di semua level
2. **Mudah Maintenance**: Perubahan di admin tidak mempengaruhi user dan sebaliknya
3. **Scalability**: Mudah menambah fitur baru di masing-masing bagian
4. **Security**: Lebih mudah mengontrol akses berdasarkan folder
5. **Organization**: Struktur lebih rapi dan mudah dicari
6. **Code Reusability**: Models tetap shared, bisa digunakan oleh admin dan user

### Routing Detail

#### User/Public Routes
- `/beranda` → `user/Beranda/index`
- `/informasi` → `user/Informasi/index`
- `/kalkulator-pupuk` → `user/Pupuk/index`
- `/kalkulator-panen` → `user/Panen/index`
- `/masuk` → `user/Autentikasi/login`
- `/daftar` → `user/Autentikasi/register`
- `/api/*` → `user/Api/*`

#### Admin Routes
- `/admin` → Dashboard
- `/admin/login` → Login page
- `/admin/logout` → Logout
- `/admin/dashboard` → Dashboard
- `/admin/harga_tbs` → Harga TBS management
- `/admin/perusahaan` → Perusahaan management
- `/admin/kabupaten` → Kabupaten management
- `/admin/pupuk` → Pupuk management
- `/admin/penyakit` → Penyakit management
- `/admin/informasi` → Informasi management
- dll.

#### Contoh Controller User
```php
// File: application/controllers/user/Beranda.php
class Beranda extends CI_Controller {
    public function index() {
        // Load view user
        $this->load->view('user/templates/header', $data);
        $this->load->view('user/beranda/index', $data);
        $this->load->view('user/templates/footer');
        
        // Load CSS/JS user
        $data['page_css'] = 'user/beranda.css';
        $data['page_js'] = 'user/beranda.js';
    }
}
```

#### Contoh Controller Admin
```php
// File: application/controllers/admin/Admin_dashboard.php
class Admin_dashboard extends MY_Controller {
    public function index() {
        // Load view admin
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/layout/footer');
        
        // Load CSS/JS admin
        $data['page_css'] = 'dashboard.css';  // Akan dicari di assets/css/admin/
        $data['page_js'] = 'dashboard.js';    // Akan dicari di assets/js/admin/
    }
}
```

### Features Implemented Detail

#### ✅ Completed
1. **Authentication System** - Admin login, role-based access control, session management
2. **Admin Layout** - Fixed left sidebar, top header, responsive design
3. **Dashboard** - Statistics cards, latest TBS prices, price change indicators, weekly trends chart
4. **Harga TBS Management** - CRUD with filters, price change calculation, validation
5. **Perusahaan Management** - CRUD operations, unique validation per kabupaten
6. **Kabupaten Management** - CRUD operations, unique validation

#### 🚧 To Be Completed
1. Kalkulator Panen (Admin view)
2. Dosis & Jenis Pupuk (Master-detail)
3. Jenis Tanah (CRUD)
4. Penyakit (CRUD with image upload)
5. Informasi/Artikel (CRUD with rich text editor)
6. Users & Roles (CRUD, password reset, avatar upload)
7. Settings / Audit Log

### Access Control Detail

#### Route Protection
Routes are protected via `MY_Controller`:
- `require_login()`: Check if user is logged in
- `require_role(['admin'])`: Check specific roles
- `require_admin()`: Admin only
- `can_edit()`: Check if user can edit (admin only)
- `can_delete()`: Check if user can delete (admin only)

### Path Gambar Detail

#### Struktur Folder Gambar
Semua file gambar harus disimpan di folder `assets/img/` dan diakses menggunakan `base_url('assets/img/...')`.

#### Aturan Path Gambar
1. **Selalu gunakan `base_url()`** untuk path gambar
2. **Format path**: `base_url('assets/img/{folder}/{filename}')`
3. **Nama file di database**: Simpan hanya nama file (tanpa path)
4. **Normalisasi path**: Jika database menyimpan path lengkap, ambil hanya nama file dengan `basename()`

#### Contoh Kode
```php
<?php
// Jika database menyimpan path lengkap
$gambar = $article->thumbnail; // "assets/img/articles/image.jpg"
if (strpos($gambar, 'assets/img/articles/') !== false) {
    $gambar = basename($gambar); // "image.jpg"
}
?>
<img src="<?= base_url('assets/img/articles/' . $gambar) ?>" alt="...">
```

#### Upload Gambar (Admin)
Semua upload gambar harus disimpan di folder yang sesuai:
- **Pupuk**: `./assets/img/pupuk/`
- **Penyakit**: `./assets/img/penyakit/`
- **Artikel**: `./assets/img/articles/`
- **Users**: `./assets/img/users/`

### Setup Instructions Admin

#### 1. Database
Ensure all tables exist in the `sawit` database:
- `kabupaten`, `perusahaan`, `harga_tbs`, `kalkulasi_panen`, `jenis_tanah`, `jenis_pupuk`, `dosis_pupuk`, `jenis_penyakit`, `informasi_tambahan`, `users`

#### 2. Create Admin User
```sql
INSERT INTO users (username, email, password, role, nama_lengkap) 
VALUES ('admin', 'admin@sawitdigital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Administrator');
-- Password: password
```

#### 3. Routes
Admin routes are configured in `application/config/routes.php`

#### 4. Access
1. Navigate to `/admin/login`
2. Login with admin credentials
3. Access dashboard at `/admin/dashboard`

### Sistem Backup Data Harga TBS Detail

#### Setup Database Backup
**Via phpMyAdmin:**
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Pilih database `sawit`
3. Klik tab **"SQL"**
4. Copy-paste isi file `database/backup_harga_tbs.sql`
5. Klik tombol **"Go"**

**Via MySQL Command Line:**
```bash
mysql -u root -p sawit < database/backup_harga_tbs.sql
```

#### Cara Kerja Backup
- **Backup Otomatis Saat Delete**: Ketika admin menghapus data harga TBS, sistem otomatis mem-backup ke tabel `harga_tbs_backup`
- **Auto-Delete Data Kemarin**: Ketika admin menambahkan data baru untuk hari ini, sistem otomatis menghapus data kemarin (setelah di-backup)
- **Pencarian Data**: Sistem mencari data dengan prioritas (tabel utama → tabel backup)

#### Struktur Tabel Backup
```sql
harga_tbs_backup
├── id_backup (AUTO_INCREMENT, PRIMARY KEY)
├── id_harga_original
├── id_kabupaten
├── id_perusahaan
├── tanggal
├── harga_per_kg
├── deleted_at
└── deleted_by
```

#### Cleanup Backup (Opsional)
```sql
-- Hapus backup lebih dari 1 tahun
DELETE FROM harga_tbs_backup 
WHERE deleted_at < DATE_SUB(NOW(), INTERVAL 1 YEAR);
```

#### Restore Data
```sql
INSERT INTO harga_tbs (id_kabupaten, id_perusahaan, tanggal, harga_per_kg)
SELECT id_kabupaten, id_perusahaan, tanggal, harga_per_kg
FROM harga_tbs_backup
WHERE id_backup = ?;
```

### Color Scheme & Dependencies Detail

#### Color Scheme
- **Primary**: #1B5E20 (dark green)
- **Secondary**: #2E7D32 (medium green)
- **Accent**: #388E3C (light green)
- **Success**: #2E7D32
- **Warning**: #F9A825
- **Danger**: #C62828
- **Info**: #0277BD
- **Background**: #FAFAFA

#### Dependencies
- Bootstrap 5.3.0 (CDN)
- Bootstrap Icons 1.11.0 (CDN)
- Chart.js 4.4.0 (CDN)
- jQuery 3.7.0 (CDN)

### Next Steps Development

1. Create remaining controllers following the pattern of `Admin_harga_tbs.php`
2. Create views for each module
3. Implement file upload for images (penyakit, informasi, users)
4. Add rich text editor for artikel content
5. Implement audit log system
6. Add data export functionality (Excel/PDF)
7. Implement advanced search and filtering
8. Add bulk operations

### Notes Developer

- All admin controllers extend `MY_Controller` for role-based access
- Forms use CodeIgniter's form validation library
- Pagination is implemented using CI's pagination library
- Flash messages are used for user feedback
- All database operations use prepared statements via CI's query builder

---

## Kontribusi

Silakan buat issue atau pull request untuk kontribusi pada proyek ini.

## Lisensi

Proyek ini menggunakan lisensi MIT.

## Kontak

Untuk pertanyaan atau dukungan, silakan hubungi:
- Email: info@sawitdigital.com
- Website: https://sawitdigital.com

---

**Catatan**: Pastikan untuk mengubah kredensial database dan konfigurasi lainnya sebelum deploy ke production!

---

## Dokumentasi Implementasi dan Perbaikan

### 1. Sistem Login Terpadu

✅ **File**: `application/controllers/Auth.php`
- Semua user (admin dan user biasa) login melalui satu halaman: `auth/login`
- Setelah login, sistem redirect berdasarkan role:
  - `role = 'admin'` → `admin/dashboard`
  - `role = 'user'` → `beranda` (home page)
- Session menyimpan: `id_user`, `username`, `role`, `nama_lengkap`, `email`, `foto_profil`
- Password menggunakan hash (PASSWORD_DEFAULT) dan verifikasi dengan `password_verify()`

### 2. Kalkulator Panen

✅ **File**: `application/controllers/user/Panen.php`
- Method `save()` sekarang:
  - Mengecek apakah user sudah login
  - Mengambil `id_user` dan `username` dari session
  - Menyimpan `id_user`, `username`, dan `hasil_bersih` ke tabel `kalkulasi_panen`
  - Menghitung `hasil_bersih` jika tidak dikirim dari frontend

✅ **File**: `assets/js/user/kalkulator_panen.js`
- Sudah mengirim `hasil_bersih` ke server saat save

### 3. Kalkulator Dosis Pupuk

✅ **File**: `application/controllers/user/Pupuk.php`
- Method `save_dosis()` sekarang:
  - Mengecek apakah user sudah login
  - Mengambil `id_user` dari session
  - Menyimpan data ke tabel `kalkulasi_dosis_pupuk` (BUKAN `dosis_pupuk`)
  - Struktur data sesuai dengan tabel `kalkulasi_dosis_pupuk`:
    - `id_user`, `id_pupuk`, `id_tanah`
    - `usia_tanaman` (dalam bulan, bukan min/max)
    - `jumlah_pohon`, `dosis_per_pohon`, `total_dosis`
    - `dosis_per_periode`, `periode_per_tahun`
    - `rekomendasi_pupuk`, `keterangan_aplikasi`
    - `tanggal_kalkulasi`

### 4. Form Kalkulator Pupuk - Lengkap

✅ **Halaman User - Kalkulator Pupuk** (`application/views/user/kalkulator_pupuk/index.php`)

**Struktur Form:**
1. **👤 Username** (Otomatis dari Session)
   - Menampilkan username dari session login
   - Menampilkan nama lengkap jika ada
   - Styling khusus dengan background hijau

2. **📌 Pilih Jenis Tanah** (Dropdown dari `jenis_tanah`)
   - Dropdown dengan semua jenis tanah
   - Info box otomatis muncul saat dipilih, menampilkan:
     - pH Minimum dan Maksimum
     - Kandungan N, P, K (%)
     - Rekomendasi

3. **📌 Pilih Jenis Pupuk** (Dropdown dari `jenis_pupuk`)
   - Dropdown dengan semua jenis pupuk
   - Info box otomatis muncul saat dipilih, menampilkan:
     - Kandungan
     - Fungsi

4. **🌱 Usia Tanaman (bulan)**
   - Input number
   - Placeholder: "Contoh: 12"
   - Required field

5. **🌳 Jumlah Pohon**
   - Input number
   - Default value: 1
   - Placeholder: "Contoh: 100"
   - Required field

6. **📆 Periode Pemupukan per Tahun**
   - Input number
   - Default value: 4
   - Placeholder: "Contoh: 4"
   - Required field

7. **📝 Keterangan Aplikasi**
   - Textarea (opsional)
   - 3 rows
   - Placeholder: "Masukkan keterangan tambahan untuk aplikasi pupuk (opsional)"

8. **🔍 Button: Hitung Dosis**
   - Submit button dengan icon
   - Menghitung dosis berdasarkan input

9. **📤 Button: Simpan Kalkulasi**
   - Muncul setelah hasil perhitungan
   - Menyimpan semua data ke `kalkulasi_dosis_pupuk`

### 5. Perbaikan Database

#### Tabel `kalkulasi_panen`
- ✅ Kolom yang sudah ada: `hasil_bersih` (decimal(10,2), NOT NULL)
- ✅ Kolom yang ditambahkan:
  - `id_user` (INT NOT NULL) - setelah `id_kalkulasi`
  - `username` (VARCHAR(50) NOT NULL) - setelah `id_user`

#### Tabel `kalkulasi_dosis_pupuk` (BUKAN `dosis_pupuk`)
- ⚠️ **Nama tabel yang benar**: `kalkulasi_dosis_pupuk`
- ✅ Kolom yang sudah ada: `id_user` (INT NOT NULL)
- ✅ Kolom yang ditambahkan: `username` (VARCHAR(50) NULL) - setelah `id_user` (opsional)

**Struktur Tabel `kalkulasi_dosis_pupuk`:**
```sql
CREATE TABLE kalkulasi_dosis_pupuk (
  id_kalkulasi INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT NOT NULL,
  id_pupuk INT NOT NULL,
  id_tanah INT NOT NULL,
  usia_tanaman INT NOT NULL,               -- Bukan min/max, tapi single value
  jumlah_pohon INT NOT NULL,
  dosis_per_pohon DECIMAL(10,2) NOT NULL,
  total_dosis DECIMAL(10,2) NOT NULL,
  dosis_per_periode DECIMAL(10,2) NULL,
  rekomendasi_pupuk VARCHAR(100) NULL,
  periode_per_tahun INT NOT NULL,
  keterangan_aplikasi TEXT NULL,
  tanggal_kalkulasi DATETIME NULL DEFAULT CURRENT_TIMESTAMP
);
```

#### Tabel `jenis_tanah`
- ✅ Kolom yang ditambahkan:
  - `ph_min` (decimal(3,1), NULL)
  - `ph_max` (decimal(3,1), NULL)
  - `kandungan_n` (decimal(5,2), NULL)
  - `kandungan_p` (decimal(5,2), NULL)
  - `kandungan_k` (decimal(5,2), NULL)
  - `rekomendasi` (text, NULL)

### 6. Admin View - Kalkulasi

✅ **Kalkulasi Panen** (`application/controllers/admin/Admin_kalkulator_panen.php`)
- Join dengan tabel `users` untuk mengambil `username` dan `nama_lengkap`
- View menampilkan kolom **ID User** dan **Username** (dengan nama lengkap jika ada)
- Menampilkan `hasil_bersih` dari database atau menghitung jika tidak ada

✅ **Kalkulasi Pupuk** (`application/controllers/admin/Admin_kalkulator_pupuk.php`)
- Join dengan tabel `users` untuk mengambil `username` dan `nama_lengkap`
- View menampilkan kolom sesuai struktur database:
  - ID User, Username
  - Usia Tanaman (bukan min/max)
  - Jumlah Pohon
  - Dosis per Pohon
  - Total Dosis
  - Periode per Tahun
  - Tanggal Kalkulasi

### 7. Perbaikan Halaman User

✅ **Halaman User - Kalkulator Pupuk**
- Menambahkan field **Periode per Tahun** di form
- Menambahkan info box untuk menampilkan detail jenis tanah saat dipilih
- Data atribut tanah disimpan di `data-*` attributes pada option select
- JavaScript menampilkan info tanah dan mengirim data lengkap
- CSS untuk styling info box tanah dengan animasi slide-in

✅ **Halaman Admin - Jenis Tanah**
- Form input untuk semua atribut: pH min/max, kandungan NPK, rekomendasi
- Tabel menampilkan kolom baru: pH (range min-max), Kandungan NPK, Rekomendasi

### 8. SQL Script

✅ **File**: `database/update_tables_structure.sql`
- Menambahkan kolom `id_user` dan `username` ke `kalkulasi_panen`
- Menambahkan kolom `username` ke `kalkulasi_dosis_pupuk` (id_user sudah ada)
- Menambahkan index untuk performa query

### 9. Upload File Gambar

✅ **Perbaikan Upload Gambar** (`application/controllers/admin/Admin_pupuk.php`)
- Menggunakan manual upload dengan `move_uploaded_file()` untuk menghindari validasi MIME type yang terlalu ketat
- Validasi ekstensi file (jpg, jpeg, png, gif, webp)
- Validasi dengan `getimagesize()` untuk memastikan file adalah gambar valid
- Validasi ukuran file (maksimal 2MB)
- Menambahkan dukungan WebP di `application/config/mimes.php`

### Catatan Penting

1. **Tabel Master vs Kalkulasi**:
   - `dosis_pupuk` = Tabel master untuk rekomendasi dosis (jika ada)
   - `kalkulasi_dosis_pupuk` = Tabel untuk menyimpan hasil kalkulasi user

2. **Kolom `username`**:
   - Di `kalkulasi_panen`: NOT NULL (wajib)
   - Di `kalkulasi_dosis_pupuk`: NULL (opsional, karena bisa diambil dari join dengan users)

3. **Login Required**: Kalkulator sekarang memerlukan login sebelum menyimpan data

4. **Format File Upload**: JPG, JPEG, PNG, GIF, WEBP (maksimal 2MB)

### 10. Redesign Halaman Login & Register

✅ **Desain Split Screen (45:55)**

**Left Side - Illustration Section (45%)**
- Background gradient: #E8F5E9 → #C8E6C9
- Logo dengan icon sawit (50x50px, rounded 12px)
- Logo text: "SAWIT DIGITAL" dan "Sistem Penyuluhan"
- Main illustration: Icon sawit 3D (200x200px) dengan floating animation
- Text: "Selamat Datang" dan deskripsi
- Footer: Copyright "© 2025 Sawit Digital | Powered by UKM"
- Background blur circles effect

**Right Side - Form Section (55%)**
- Background: Pure White
- Padding: 60px
- Max-width form: 400px
- Center aligned content

**Form Login:**
- Title: "Login" (32px, bold, #1B5E20)
- Subtitle: "Silakan masuk ke akun Anda" (14px, #757575)
- Field Username/Email dengan label "Username Or Email"
- Field Password dengan label "Password"
- Link "Lupa Password?" (right aligned)
- Button "Login" dengan gradient dan hover effect
- Toggle: "Belum punya akun? Daftar Sekarang"
- Footer: "Terms and Services"

**Form Register:**
- Title: "Daftar" (32px, bold, #1B5E20)
- Subtitle: "Buat akun baru Anda" (14px, #757575)
- Field Username (max 50 karakter)
- Field Nama Lengkap (max 100 karakter)
- Field Email (max 100 karakter, optional)
- Field Password (min 8 karakter)
- Field Confirm Password (min 8 karakter)
- Button "Daftar" dengan gradient
- Toggle: "Sudah punya akun? Login"
- Footer: "Dengan mendaftar, Anda menyetujui Terms and Services"

**Fitur Toggle Form:**
- JavaScript untuk toggle antara login dan register
- Smooth scroll ke top saat toggle
- Form register muncul otomatis jika ada error
- Form login muncul otomatis jika tidak ada error register

**Controller & Backend:**
- Method `login()` - sudah ada, redirect sesuai role
- Method `register()` - baru ditambahkan
- Auto login setelah register
- Validasi form dengan CodeIgniter form_validation
- Password hashing menggunakan `password_hash()`

**Routes:**
- `auth/login` → `Auth/login`
- `auth/register` → `Auth/register`
- `masuk` → `Auth/login`
- `daftar` → `Auth/register`

**CSS Styling:**
- Color Scheme: Primary #1B5E20, Secondary #2E7D32, Accent #4CAF50
- Background Gradient: #E8F5E9 → #C8E6C9
- Typography: Font Family 'Poppins', 'Inter', 'Segoe UI'
- Animations: Floating icon, button hover, input focus
- Responsive: Mobile (<968px) stack layout

**Security Features:**
- Password hashing dengan `password_hash()`
- Form validation di frontend dan backend
- CSRF protection (CodeIgniter default)
- Input sanitization dengan `trim()`
- Max length validation
- Email validation
- Username/Email uniqueness check

**File yang Diubah/Dibuat:**
1. ✅ `application/views/auth/login.php` - Redesign lengkap
2. ✅ `assets/css/auth/login.css` - CSS baru sesuai spesifikasi
3. ✅ `application/controllers/Auth.php` - Method register ditambahkan
4. ✅ `application/config/routes.php` - Routes register diupdate

### 11. Cleanup File yang Tidak Terpakai

✅ **File yang Sudah Dihapus:**

**View File:**
- ❌ `application/views/user/autentikasi/daftar.php`
  - **Alasan:** Form register sekarang ada di `application/views/auth/login.php` dengan toggle
  - **Pengganti:** Form register di halaman login (split screen design)

**Controller File:**
- ❌ `application/controllers/user/Autentikasi.php`
  - **Alasan:** Routes sudah diarahkan ke `Auth/register`
  - **Pengganti:** Method `register()` di `application/controllers/Auth.php`

**Alasan Perubahan:**
1. **Unified Auth System:** Semua autentikasi (login & register) sekarang di `Auth` controller
2. **Better UX:** Login dan register di halaman yang sama dengan toggle
3. **Code Organization:** Semua auth logic di satu tempat, lebih mudah maintenance

**Routes Baru (Aktif):**
```php
$route['daftar'] = 'Auth/register';
$route['register'] = 'Auth/register';
```

### 12. Home Controller Usage

✅ **Lokasi Penggunaan:**

**Routes Configuration:**
- File: `application/config/routes.php` (Baris 53)
- `$route['default_controller'] = 'Home';`

**URL yang Memicu Home Controller:**
1. Root URL (tanpa path): `http://localhost/Sawit_Digital/`
2. URL dengan Home controller: `http://localhost/Sawit_Digital/Home`

**Alur Kerja:**
```
1. User mengakses: http://localhost/Sawit_Digital/
   ↓
2. CodeIgniter Router memeriksa routes.php
   ↓
3. Router menemukan: $route['default_controller'] = 'Home'
   ↓
4. Router memanggil: Home::index()
   ↓
5. Home::index() menjalankan: redirect('beranda')
   ↓
6. Browser redirect ke: http://localhost/Sawit_Digital/beranda
   ↓
7. Routes memanggil: user/Beranda::index()
   ↓
8. Halaman beranda ditampilkan
```

**Mengapa Home Controller Diperlukan?**
- CodeIgniter 3 **tidak mendukung subfolder** di `default_controller`
- Tidak bisa langsung: `$route['default_controller'] = 'user/Beranda';` (ERROR)
- Solusi: Membuat wrapper controller di root yang melakukan redirect ke controller di subfolder

**Kapan Home Controller Dipanggil?**
- ✅ User mengakses root URL (`/`)
- ✅ User mengakses URL tanpa path
- ✅ URL tidak cocok dengan route lain

**Tidak dipanggil ketika:**
- ❌ User mengakses `/beranda` (langsung ke Beranda)
- ❌ User mengakses `/login` (langsung ke Auth)
- ❌ User mengakses URL yang sudah didefinisikan di routes

#   S a w i t - D i g i t a l 
 
 