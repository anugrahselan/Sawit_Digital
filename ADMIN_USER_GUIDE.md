# Sawit Digital - Admin & User Website Guide

## 🎯 Overview
Sistem lengkap untuk mengelola data sawit dengan dua panel: **Admin Panel** untuk input master data dan **User Panel** untuk melihat data dan input kalkulasi.

## 🚀 Cara Menjalankan

### 1. Setup Database
- Database: `sawit`
- Import schema MySQL jika belum ada
- Pastikan semua tabel sudah dibuat sesuai schema

### 2. Konfigurasi
- Edit `application/config/database.php`:
  ```php
  'hostname' => 'localhost',
  'username' => 'root',
  'password' => '',
  'database' => 'sawit',
  ```

### 3. Akses Aplikasi
- **User Panel**: `http://localhost/Sawit_Digital/beranda`
- **Admin Login**: `http://localhost/Sawit_Digital/admin/login`

### 4. Login Admin
- **Email**: `admin@gmail.com`
- **Password**: `admin123`
- Password akan otomatis di-hash saat login pertama kali jika belum di-hash

## 📋 Fitur Admin Panel

### Menu Sidebar (Urutan sesuai requirement):
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

### CRUD dengan File Upload:
- **Jenis Pupuk**: Upload gambar ke `assets/img/pupuk/`
- **Jenis Penyakit**: Upload gambar ke `assets/img/penyakit/`
- **Informasi Tambahan**: Upload gambar header & thumbnail ke `assets/img/articles/`

## 📋 Fitur User Panel

### Halaman Publik:
1. **Beranda** - Tampilkan harga TBS, fitur utama, artikel terbaru
2. **Kalkulator Pupuk** - Hitung dosis pupuk, **bisa save ke database**
3. **Kalkulator Panen** - Hitung hasil panen, **bisa save ke database**
4. **Jenis Pupuk** - Lihat data dari admin
5. **Penyakit** - Lihat data dari admin
6. **Informasi** - Lihat artikel dari admin
7. **Harga TBS** - Lihat harga dari admin

### User Input → Admin View:
- **Kalkulator Panen**: Data tersimpan di `kalkulasi_panen`, terlihat di Admin → Kalkulasi Panen
- **Dosis Pupuk**: Data tersimpan di `dosis_pupuk`, terlihat di Admin → Dosis Pupuk

## 🔄 Alur Data

### Admin → User (Master Data):
1. Admin input data di admin panel (Jenis Pupuk, Penyakit, dll)
2. Data otomatis tersimpan di database
3. User melihat data di halaman publik

### User → Admin (Kalkulasi):
1. User isi form kalkulator (Panen atau Pupuk)
2. User klik "Simpan Hasil Perhitungan"
3. Data tersimpan di database
4. Admin melihat data di admin panel

## 🎨 Branding & Colors
- **Primary**: #1B5E20 (hijau gelap)
- **Background**: #FAFAFA (putih krem)
- **Success**: #2E7D32
- **Warning**: #F9A825
- **Danger**: #C62828
- **Info**: #0277BD

## 📁 Struktur Folder
```
assets/
├── img/
│   ├── pupuk/          # Gambar pupuk (admin upload)
│   ├── penyakit/       # Gambar penyakit (admin upload)
│   ├── articles/       # Gambar artikel (admin upload)
│   └── users/          # Foto profil user
├── css/
│   ├── admin/          # CSS admin panel
│   └── user/           # CSS user panel
└── js/
    ├── admin/          # JS admin panel
    └── user/           # JS user panel
```

## 🔐 Access Control
- **Admin**: Full CRUD semua master data
- **Penyuluh**: Read + Create/Update (no delete)
- **User**: Read-only untuk master data, bisa input kalkulasi

## 📝 Catatan Penting
1. Pastikan folder `assets/img/` dan subfoldernya memiliki permission write
2. File upload maksimal 2MB
3. Format gambar: JPG, PNG, GIF, WEBP
4. Semua label dan instruksi menggunakan bahasa Indonesia yang sederhana
5. Data yang diinput user (kalkulasi) hanya terlihat di admin panel

## 🛠️ Troubleshooting
- **CSS tidak muncul**: Clear browser cache, pastikan `base_url` di config benar
- **Gambar tidak muncul**: Cek path file, pastikan folder ada dan writable
- **Login admin gagal**: Jalankan `fix_admin_password.php` untuk hash password
- **Data tidak tersimpan**: Cek permission folder, pastikan database connection benar

## 📞 Support
Untuk pertanyaan atau masalah, periksa:
1. Log error di `application/logs/`
2. Browser console untuk error JavaScript
3. Database connection di `application/config/database.php`

---

**Dibuat dengan CodeIgniter 3 + Bootstrap 5**


