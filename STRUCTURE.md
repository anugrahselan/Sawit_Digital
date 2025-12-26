# Struktur Folder - Sawit Digital

## Pemisahan Admin dan User

Proyek ini telah dipisahkan menjadi dua bagian utama: **Admin** dan **User/Public** dengan struktur folder yang jelas.

## Struktur Folder

```
application/
├── controllers/
│   ├── admin/                    # Controllers untuk admin panel
│   │   ├── Admin_auth.php
│   │   ├── Admin_dashboard.php
│   │   ├── Admin_harga_tbs.php
│   │   ├── Admin_perusahaan.php
│   │   ├── Admin_kabupaten.php
│   │   ├── Admin_pupuk.php
│   │   ├── Admin_penyakit.php
│   │   ├── Admin_informasi.php
│   │   ├── Admin_tanah.php
│   │   ├── Admin_kalkulator_panen.php
│   │   ├── Admin_users.php
│   │   └── Admin_settings.php
│   │
│   └── user/                     # Controllers untuk user/public
│       ├── Beranda.php
│       ├── Informasi.php
│       ├── Autentikasi.php
│       ├── Pupuk.php
│       ├── Panen.php
│       ├── Penyakit.php
│       ├── Pencarian.php
│       └── Api.php
│
├── models/                       # Models (shared)
│   ├── Harga_tbs_model.php
│   ├── Informasi_tambahan_model.php
│   ├── Pengguna_model.php
│   ├── Jenis_pupuk_model.php
│   ├── Kabupaten_model.php
│   ├── Perusahaan_model.php
│   └── ...
│
└── views/
    ├── admin/                    # Views untuk admin panel
    │   ├── auth/
    │   │   └── login.php
    │   ├── dashboard/
    │   │   └── index.php
    │   ├── layout/
    │   │   ├── header.php
    │   │   └── footer.php
    │   ├── harga_tbs/
    │   ├── perusahaan/
    │   ├── kabupaten/
    │   ├── pupuk/
    │   ├── penyakit/
    │   ├── informasi/
    │   ├── tanah/
    │   ├── kalkulator_panen/
    │   ├── users/
    │   └── settings/
    │
    └── user/                     # Views untuk user/public
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
├── css/
│   ├── global.css               # CSS global (shared)
│   ├── admin/                    # CSS untuk admin
│   │   └── main.css
│   └── user/                     # CSS untuk user/public
│       ├── beranda.css
│       ├── informasi.css
│       ├── autentikasi.css
│       ├── kalkulator_pupuk.css
│       ├── kalkulator_panen.css
│       ├── jenis_pupuk.css
│       └── penyakit.css
│
└── js/
    ├── admin/                    # JavaScript untuk admin
    │   └── main.js
    └── user/                     # JavaScript untuk user/public
        ├── beranda.js
        ├── informasi.js
        ├── kalkulator_pupuk.js
        ├── kalkulator_panen.js
        ├── pencarian.js
        └── dropdown.js
```

## Routing

### User/Public Routes
- `/beranda` → `user/beranda/index`
- `/informasi` → `user/informasi/index`
- `/kalkulator-pupuk` → `user/pupuk/index`
- `/kalkulator-panen` → `user/panen/index`
- `/masuk` → `user/autentikasi/login`
- `/daftar` → `user/autentikasi/register`
- `/api/*` → `user/api/*`

### Admin Routes
- `/admin/login` → `admin/Admin_auth/login`
- `/admin/dashboard` → `admin/Admin_dashboard/index`
- `/admin/harga_tbs` → `admin/Admin_harga_tbs/index`
- `/admin/perusahaan` → `admin/Admin_perusahaan/index`
- `/admin/kabupaten` → `admin/Admin_kabupaten/index`
- `/admin/pupuk` → `admin/Admin_pupuk/index`
- `/admin/penyakit` → `admin/Admin_penyakit/index`
- dll.

## Cara Menggunakan

### Untuk Controller User
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

### Untuk Controller Admin
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

## Keuntungan Struktur Ini

1. **Pemisahan yang Jelas**: Admin dan user terpisah dengan jelas di semua level (controllers, views, CSS, JS)
2. **Mudah Maintenance**: Perubahan di admin tidak mempengaruhi user dan sebaliknya
3. **Scalability**: Mudah menambah fitur baru di masing-masing bagian
4. **Security**: Lebih mudah mengontrol akses berdasarkan folder
5. **Organization**: Struktur lebih rapi dan mudah dicari
6. **Code Reusability**: Models tetap shared, bisa digunakan oleh admin dan user

## Catatan Penting

- **Controllers**: CodeIgniter 3 mendukung subfolder dengan format `folder/controller/method` di routes
- **Views**: Sudah dipisah ke `admin/` dan `user/`
- **CSS/JS**: Sudah dipisah ke `admin/` dan `user/`
- **Models**: Tetap di root karena shared antara admin dan user
- **Routes**: Semua routes sudah diupdate untuk menggunakan format `folder/controller`
