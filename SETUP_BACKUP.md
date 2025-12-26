# Setup Sistem Backup Harga TBS

## Langkah-langkah Setup

### 1. Buat Tabel Backup di Database

#### Via phpMyAdmin:
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Pilih database `sawit` (atau nama database Anda)
3. Klik tab **"SQL"**
4. Copy-paste isi file `database/backup_harga_tbs.sql`
5. Klik tombol **"Go"** untuk menjalankan

#### Via MySQL Command Line:
```bash
mysql -u root -p sawit < database/backup_harga_tbs.sql
```

### 2. Verifikasi Tabel Backup

Setelah script dijalankan, pastikan tabel `harga_tbs_backup` sudah dibuat:

**Struktur Tabel:**
- `id_backup` (AUTO_INCREMENT, PRIMARY KEY)
- `id_harga_original` (ID dari tabel harga_tbs sebelum dihapus)
- `id_kabupaten` (sama dengan harga_tbs)
- `id_perusahaan` (sama dengan harga_tbs)
- `tanggal` (sama dengan harga_tbs)
- `harga_per_kg` (sama dengan harga_tbs)
- `deleted_at` (waktu data dihapus)
- `deleted_by` (ID user yang menghapus)

### 3. Cara Kerja Sistem

#### Otomatis:
- ✅ Setiap kali admin menghapus data harga TBS, sistem **otomatis** mem-backup data tersebut
- ✅ Data yang di-backup memiliki struktur yang sama dengan tabel `harga_tbs`
- ✅ Sistem akan mencari data di tabel utama dan backup untuk perbandingan harga

#### Pencarian Data:
Sistem mencari data dengan prioritas:
1. **Tabel utama** (`harga_tbs`) - data kemarin
2. **Tabel backup** (`harga_tbs_backup`) - data kemarin yang sudah dihapus
3. **Tabel utama** - data terakhir sebelum tanggal saat ini
4. **Tabel backup** - data terakhir yang sudah dihapus

### 4. Testing

#### Test Backup:
1. Login sebagai admin
2. Buka halaman **Harga TBS**
3. Hapus satu data harga TBS
4. Cek tabel `harga_tbs_backup` di phpMyAdmin
5. Data yang dihapus seharusnya sudah ada di tabel backup

#### Test Perbandingan:
1. Hapus data kemarin untuk satu perusahaan
2. Input data baru untuk hari ini
3. Buka halaman **Beranda** (user)
4. Kolom "Perubahan" seharusnya tetap menampilkan perbandingan dengan data dari backup

### 5. Catatan Penting

⚠️ **Tabel Backup Harus Dibuat**
- Sistem backup tidak akan berfungsi jika tabel belum dibuat
- Sistem akan tetap berfungsi normal, tapi tanpa backup

✅ **Struktur Sama**
- Struktur tabel backup sama dengan `harga_tbs`
- Ditambah kolom `deleted_at` dan `deleted_by` untuk tracking

✅ **Otomatis**
- Tidak perlu manual backup
- Backup dilakukan setiap kali data dihapus

### 6. Troubleshooting

**Q: Backup tidak berfungsi?**
A: Pastikan tabel `harga_tbs_backup` sudah dibuat dengan menjalankan script SQL.

**Q: Bagaimana cara cek apakah backup berfungsi?**
A: 
1. Hapus satu data harga TBS
2. Buka phpMyAdmin
3. Pilih tabel `harga_tbs_backup`
4. Klik "Browse"
5. Data yang dihapus seharusnya sudah ada di sana

**Q: Data tidak muncul di perbandingan?**
A: Pastikan:
- Tabel backup sudah dibuat
- Data yang dihapus sudah ter-backup
- Query pencarian sudah benar (cek log error jika ada)

