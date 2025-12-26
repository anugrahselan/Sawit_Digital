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
   - Development: `http://localhost/Sawit_Digital/`
   - Atau sesuai konfigurasi virtual host Anda

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

### 1. Dashboard
- Tampilan ringkasan informasi
- Shortcut ke fitur utama
- Tabel harga TBS terkini
- Artikel edukasi terbaru

### 2. Kalkulator Pupuk
- Hitung dosis pupuk berdasarkan:
  - Jenis pupuk
  - Jenis tanah
  - Usia tanaman
  - Jumlah pohon
- Menampilkan hasil perhitungan dan tips aplikasi

### 3. Kalkulator Panen
- Hitung estimasi hasil panen dan keuntungan
- Input: harga per KG, berat kotor, potongan, biaya, dll
- Output: hasil bersih dengan breakdown detail
- Grafik visualisasi

### 4. Jenis Pupuk
- Daftar lengkap jenis pupuk
- Informasi kandungan, fungsi, waktu aplikasi
- Catatan khusus untuk setiap pupuk

### 5. Penyakit Sawit
- Daftar penyakit yang menyerang sawit
- Informasi penyebab, gejala, dan cara pengendalian
- Ilustrasi gambar penyakit

### 6. Informasi & Edukasi
- Artikel edukasi tentang budidaya sawit
- Kategori artikel
- Pagination untuk navigasi
- Detail artikel lengkap

### 7. Pencarian
- Pencarian artikel, pupuk, dan penyakit
- Hasil pencarian terorganisir

### 8. Autentikasi
- Login dan registrasi pengguna
- Role-based access (admin/user)
- Session management

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

## Role-Based Access

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

#   S a w i t - D i g i t a l  
 