# Dokumentasi Path Gambar - Sawit Digital

Semua file gambar harus disimpan di folder `assets/img/` dan diakses menggunakan `base_url('assets/img/...')`.

## Struktur Folder Gambar

```
assets/img/
├── articles/          # Gambar artikel/informasi
├── hero/              # Gambar hero banner
├── logo/              # Logo aplikasi
├── penyakit/          # Gambar penyakit sawit
├── pupuk/             # Gambar pupuk
└── users/             # Foto profil user
```

## Path Gambar di Views

### 1. User Views

#### `user/templates/header.php`
- Logo: `base_url('assets/img/logo/logo.png')` atau `logo.svg`
- Foto Profil: `base_url('assets/img/users/' . $foto)`
- Hero Banner: `base_url('assets/img/hero/hero-banner.{ext}')`

#### `user/partials/kartu_artikel.php`
- Thumbnail Artikel: `base_url('assets/img/articles/' . $gambar)`
- Otomatis mengambil hanya nama file jika path sudah lengkap

#### `user/informasi/detail.php`
- Gambar Header: `base_url('assets/img/articles/' . $gambar)`
- Fallback ke thumbnail jika gambar_header tidak ada

#### `user/pupuk/jenis.php`
- Gambar Pupuk: `base_url('assets/img/pupuk/' . $gambar_pupuk)`

#### `user/penyakit/index.php`
- Gambar Penyakit: `base_url('assets/img/penyakit/' . $gambar_penyakit)`

#### `user/pencarian/hasil.php`
- Gambar Pupuk: `base_url('assets/img/pupuk/' . $gambar_pupuk)`

### 2. Admin Views

#### `admin/layout/header.php`
- Foto Profil: `base_url('assets/img/users/' . $foto_profil)`
- Default: `base_url('assets/img/users/default.png')`

#### `admin/pupuk/index.php`
- Gambar Pupuk: `base_url('assets/img/pupuk/' . $gambar_pupuk)`
- **Normalisasi path**: Otomatis mengambil hanya nama file jika database menyimpan path lengkap
- **Error handling**: Menampilkan "-" jika gambar gagal dimuat

#### `admin/pupuk/form.php`
- Preview Gambar: `base_url('assets/img/pupuk/' . $gambar_pupuk)`
- **Normalisasi path**: Otomatis mengambil hanya nama file jika database menyimpan path lengkap
- **Error handling**: Menyembunyikan gambar jika gagal dimuat

#### `admin/penyakit/index.php`
- Gambar Penyakit: `base_url('assets/img/penyakit/' . $gambar_penyakit)`
- **Normalisasi path**: Otomatis mengambil hanya nama file jika database menyimpan path lengkap
- **Error handling**: Menampilkan "-" jika gambar gagal dimuat

#### `admin/layout/header.php`
- Foto Profil: `base_url('assets/img/users/' . $foto_profil)`
- **Normalisasi path**: Otomatis mengambil hanya nama file jika database menyimpan path lengkap
- **Fallback**: Default ke `default.png` jika foto tidak ada atau gagal dimuat

## Aturan Path Gambar

1. **Selalu gunakan `base_url()`** untuk path gambar
2. **Format path**: `base_url('assets/img/{folder}/{filename}')`
3. **Nama file di database**: Simpan hanya nama file (tanpa path)
4. **Normalisasi path**: Jika database menyimpan path lengkap, ambil hanya nama file dengan `basename()`

## Contoh Kode

### Menampilkan Gambar dari Database
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

### Menampilkan Gambar dengan Fallback
```php
<?php
$foto = $this->session->userdata('foto_profil');
if (!empty($foto)) {
    $foto = strpos($foto, 'assets/img/users/') !== false ? basename($foto) : basename(trim($foto));
    ?>
    <img src="<?= base_url('assets/img/users/' . $foto) ?>" 
         alt="Profile" 
         onerror="this.style.display='none';">
    <?php
}
?>
```

### Menampilkan Gambar dengan Error Handling
```php
<img src="<?= base_url('assets/img/articles/' . $gambar) ?>" 
     alt="<?= htmlspecialchars($article->judul) ?>" 
     onerror="this.onerror=null; this.style.display='none';">
```

## Upload Gambar (Admin)

Semua upload gambar harus disimpan di folder yang sesuai:

- **Pupuk**: `./assets/img/pupuk/`
- **Penyakit**: `./assets/img/penyakit/`
- **Artikel**: `./assets/img/articles/`
- **Users**: `./assets/img/users/`

### Contoh Upload (Controller)
```php
$config['upload_path'] = './assets/img/pupuk/';
$config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
$config['max_size'] = 2048; // 2MB
$config['encrypt_name'] = TRUE;
```

## Catatan Penting

1. **Jangan hardcode path** seperti `/assets/img/...` atau `../assets/img/...`
2. **Selalu gunakan `base_url()`** untuk memastikan path benar di semua environment
3. **Normalisasi path** jika database menyimpan path lengkap
4. **Gunakan `onerror`** untuk handle gambar yang tidak ditemukan
5. **Gunakan `basename()`** untuk mengambil hanya nama file dari path lengkap


