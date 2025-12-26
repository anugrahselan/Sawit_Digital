# Sistem Auto-Delete Data Kemarin

## Deskripsi
Sistem otomatis menghapus data kemarin (1 hari sebelumnya) ketika admin menambahkan data baru untuk hari ini. Data kemarin akan di-backup terlebih dahulu sebelum dihapus.

## Cara Kerja

### 1. Admin Menambahkan Data Baru
Ketika admin menambahkan data harga TBS untuk hari ini:
- Sistem menyimpan data baru ke database
- **Otomatis** mencari data kemarin untuk perusahaan dan kabupaten yang sama
- **Otomatis** mem-backup data kemarin ke tabel `harga_tbs_backup`
- **Otomatis** menghapus data kemarin dari tabel utama

### 2. Kondisi Penghapusan
Data kemarin akan dihapus jika:
- ✅ Data baru berhasil dibuat
- ✅ Perusahaan sama (`id_perusahaan`)
- ✅ Kabupaten sama (`id_kabupaten`)
- ✅ Tanggal kemarin (1 hari sebelum tanggal data baru)

### 3. Backup Otomatis
Sebelum dihapus, data kemarin akan:
- ✅ Di-backup ke tabel `harga_tbs_backup`
- ✅ Menyimpan semua informasi (kabupaten, perusahaan, tanggal, harga)
- ✅ Mencatat waktu penghapusan dan user yang menghapus

## Contoh Skenario

### Skenario 1: Data Baru untuk Hari Ini
**Tanggal:** 26/12/2025
**Perusahaan:** PT ABC
**Kabupaten:** Bangka
**Harga:** Rp 3.400

**Yang Terjadi:**
1. Data baru (26/12/2025) disimpan
2. Sistem mencari data kemarin (25/12/2025) untuk PT ABC di Bangka
3. Jika ada, data kemarin di-backup
4. Data kemarin dihapus dari tabel utama

### Skenario 2: Data Baru untuk Tanggal Lain
**Tanggal:** 25/12/2025 (kemarin)
**Perusahaan:** PT ABC
**Kabupaten:** Bangka
**Harga:** Rp 3.300

**Yang Terjadi:**
1. Data baru (25/12/2025) disimpan
2. Sistem mencari data kemarin (24/12/2025) untuk PT ABC di Bangka
3. Jika ada, data kemarin di-backup
4. Data kemarin dihapus dari tabel utama

## Manfaat

✅ **Database Tetap Bersih**
- Hanya menyimpan data hari ini
- Data lama otomatis terhapus

✅ **Backup Aman**
- Data kemarin tetap tersimpan di backup
- Bisa digunakan untuk perbandingan harga

✅ **Otomatis**
- Tidak perlu manual delete
- Semua dilakukan otomatis saat create

## Catatan Penting

⚠️ **Hanya Saat Create**
- Auto-delete hanya terjadi saat **menambahkan data baru**
- **Tidak terjadi** saat update data yang sudah ada

⚠️ **Perusahaan & Kabupaten Sama**
- Hanya menghapus data kemarin untuk perusahaan dan kabupaten yang sama
- Data perusahaan/kabupaten lain tidak terpengaruh

⚠️ **Backup Wajib**
- Pastikan tabel `harga_tbs_backup` sudah dibuat
- Jika belum, backup tidak akan berfungsi (tapi data tetap dihapus)

## Testing

### Test Auto-Delete:
1. Login sebagai admin
2. Tambahkan data harga TBS untuk hari ini (misalnya 26/12/2025)
3. Pastikan ada data kemarin (25/12/2025) untuk perusahaan dan kabupaten yang sama
4. Setelah create, cek:
   - ✅ Data baru sudah ada di tabel `harga_tbs`
   - ✅ Data kemarin sudah di-backup di `harga_tbs_backup`
   - ✅ Data kemarin sudah dihapus dari `harga_tbs`

### Test Perbandingan:
1. Setelah auto-delete, buka halaman user beranda
2. ✅ Perbandingan harga tetap berfungsi (menggunakan data dari backup)

## Troubleshooting

**Q: Data kemarin tidak terhapus?**
A: Pastikan:
- Data kemarin ada untuk perusahaan dan kabupaten yang sama
- Tanggal data baru adalah hari ini atau setelah kemarin
- Tabel backup sudah dibuat (untuk backup)

**Q: Data kemarin terhapus tapi tidak ter-backup?**
A: Pastikan tabel `harga_tbs_backup` sudah dibuat dengan menjalankan script SQL.

**Q: Apakah update juga menghapus data kemarin?**
A: Tidak, auto-delete hanya terjadi saat **create** data baru, bukan saat **update**.

