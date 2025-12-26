# Sistem Backup Data Harga TBS

## Deskripsi
Sistem backup otomatis untuk menyimpan data harga TBS yang sudah dihapus, sehingga perbandingan harga tetap akurat meskipun data lama sudah dihapus.

## Cara Menggunakan

### 1. Setup Database
Jalankan script SQL untuk membuat tabel backup:

```sql
-- File: database/backup_harga_tbs.sql
-- Jalankan script ini di database MySQL/MariaDB
```

Atau jalankan melalui phpMyAdmin/Laragon:
1. Buka phpMyAdmin
2. Pilih database `sawit_digital` (atau nama database Anda)
3. Klik tab "SQL"
4. Copy-paste isi file `database/backup_harga_tbs.sql`
5. Klik "Go" untuk menjalankan

### 2. Cara Kerja

#### Backup Otomatis
- Ketika admin menghapus data harga TBS, sistem akan **otomatis** mem-backup data tersebut ke tabel `harga_tbs_backup`
- Data yang di-backup meliputi:
  - ID original (sebelum dihapus)
  - ID Kabupaten
  - ID Perusahaan
  - Tanggal
  - Harga per KG
  - Waktu penghapusan
  - User yang menghapus

#### Pencarian Data untuk Perbandingan
Sistem akan mencari data dengan prioritas:
1. **Prioritas 1**: Data kemarin di tabel utama (`harga_tbs`)
2. **Prioritas 2**: Data kemarin di tabel backup (`harga_tbs_backup`)
3. **Prioritas 3**: Data terakhir di tabel utama sebelum tanggal saat ini
4. **Prioritas 4**: Data terakhir di tabel backup sebelum tanggal saat ini

### 3. Struktur Tabel Backup

```sql
harga_tbs_backup
├── id_backup (AUTO_INCREMENT, PRIMARY KEY)
├── id_harga_original (ID dari tabel harga_tbs sebelum dihapus)
├── id_kabupaten
├── id_perusahaan
├── tanggal
├── harga_per_kg
├── deleted_at (Waktu data dihapus)
└── deleted_by (ID user yang menghapus)
```

### 4. Manfaat

✅ **Perbandingan Harga Tetap Akurat**
- Meskipun data lama dihapus, sistem tetap bisa membandingkan harga
- Data kemarin yang sudah dihapus tetap bisa digunakan untuk perbandingan

✅ **Data Aman**
- Data yang dihapus tidak benar-benar hilang
- Bisa digunakan untuk audit atau analisis historis

✅ **Otomatis**
- Tidak perlu manual backup
- Backup dilakukan setiap kali data dihapus

### 5. Catatan Penting

⚠️ **Tabel Backup Harus Dibuat**
- Jika tabel `harga_tbs_backup` belum dibuat, backup tidak akan berfungsi
- Sistem akan tetap berfungsi, tapi tanpa backup

⚠️ **Ukuran Database**
- Tabel backup akan terus bertambah seiring waktu
- Disarankan untuk melakukan cleanup berkala (misalnya hapus backup lebih dari 1 tahun)

### 6. Cleanup Backup (Opsional)

Jika ingin menghapus backup lama, jalankan query:

```sql
-- Hapus backup lebih dari 1 tahun
DELETE FROM harga_tbs_backup 
WHERE deleted_at < DATE_SUB(NOW(), INTERVAL 1 YEAR);

-- Atau hapus backup lebih dari 30 hari
DELETE FROM harga_tbs_backup 
WHERE deleted_at < DATE_SUB(NOW(), INTERVAL 30 DAY);
```

### 7. Restore Data (Jika Diperlukan)

Jika ingin restore data dari backup:

```sql
-- Contoh restore data
INSERT INTO harga_tbs (id_kabupaten, id_perusahaan, tanggal, harga_per_kg)
SELECT id_kabupaten, id_perusahaan, tanggal, harga_per_kg
FROM harga_tbs_backup
WHERE id_backup = ?;
```

## Troubleshooting

**Q: Backup tidak berfungsi?**
A: Pastikan tabel `harga_tbs_backup` sudah dibuat dengan menjalankan script SQL.

**Q: Data masih tidak muncul di perbandingan?**
A: Pastikan data yang dihapus sudah ter-backup dengan cek tabel `harga_tbs_backup`.

**Q: Bagaimana cara cek apakah backup berfungsi?**
A: Hapus satu data, lalu cek tabel `harga_tbs_backup` apakah data tersebut sudah ada.

