# Sistem Login Berdasarkan Role

## Deskripsi
Sistem login otomatis mengarahkan user ke halaman yang sesuai berdasarkan role mereka:
- **Admin/Penyuluh** → Halaman Admin (`admin/dashboard`)
- **User** → Halaman User (`beranda`)

## Cara Kerja

### 1. Login User (Halaman User)
**URL:** `masuk` atau `login`  
**Controller:** `user/Autentikasi/login`

**Alur:**
1. User memasukkan email dan password
2. Sistem verifikasi kredensial
3. Setelah login berhasil, sistem cek role:
   - Jika `role = 'admin'` atau `'penyuluh'` → Redirect ke `admin/dashboard`
   - Jika `role = 'user'` → Redirect ke `beranda`

### 2. Login Admin (Halaman Admin)
**URL:** `admin/login`  
**Controller:** `admin/Admin_auth/login`

**Alur:**
1. Admin memasukkan email dan password
2. Sistem verifikasi kredensial
3. Sistem cek role:
   - Hanya `role = 'admin'` atau `'penyuluh'` yang bisa login
   - Jika role bukan admin/penyuluh → Error: "Anda tidak memiliki akses admin"
4. Setelah login berhasil → Redirect ke `admin/dashboard`

## Skenario Login

### Skenario 1: Admin Login via Halaman User
- **URL:** `masuk` atau `login`
- **Email:** admin@gmail.com
- **Password:** admin123
- **Hasil:** Redirect ke `admin/dashboard` (karena role = admin)

### Skenario 2: User Login via Halaman User
- **URL:** `masuk` atau `login`
- **Email:** user@gmail.com
- **Password:** user123
- **Hasil:** Redirect ke `beranda` (karena role = user)

### Skenario 3: Admin Login via Halaman Admin
- **URL:** `admin/login`
- **Email:** admin@gmail.com
- **Password:** admin123
- **Hasil:** Redirect ke `admin/dashboard`

### Skenario 4: User Mencoba Login via Halaman Admin
- **URL:** `admin/login`
- **Email:** user@gmail.com
- **Password:** user123
- **Hasil:** Error: "Anda tidak memiliki akses admin. Role Anda: user"

## Proteksi Akses

### Halaman Admin
- **Proteksi:** `require_admin_or_penyuluh()` di `MY_Controller`
- **Akses:** Hanya admin dan penyuluh
- **User biasa:** Akan di-redirect dengan error "Akses ditolak"

### Halaman User
- **Proteksi:** Tidak ada (bisa diakses semua orang)
- **Akses:** Semua user (termasuk admin yang sudah login)
- **Admin yang login:** Bisa akses halaman user, ada link "Kembali ke Admin" di header

## Link Login

### Untuk User:
- `http://localhost/Sawit_Digital/masuk`
- `http://localhost/Sawit_Digital/login`

### Untuk Admin:
- `http://localhost/Sawit_Digital/admin/login`

## Catatan Penting

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

## Testing

### Test 1: Admin Login via User Page
1. Buka `masuk`
2. Login dengan email admin
3. ✅ Harus redirect ke `admin/dashboard`

### Test 2: User Login via User Page
1. Buka `masuk`
2. Login dengan email user
3. ✅ Harus redirect ke `beranda`

### Test 3: User Mencoba Akses Admin
1. Login sebagai user
2. Coba akses `admin/dashboard`
3. ✅ Harus di-redirect dengan error

### Test 4: Admin Akses User Page
1. Login sebagai admin
2. Akses `beranda`
3. ✅ Harus bisa akses (tidak di-block)

