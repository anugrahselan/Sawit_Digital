# Admin Dashboard - Sawit Digital

## Overview
Admin Dashboard untuk Sistem Penyuluhan Sawit Digital dengan CodeIgniter 3 + Bootstrap 5.

## Features Implemented

### ✅ Completed
1. **Authentication System**
   - Admin login page (`/admin/login`)
   - Role-based access control (admin, penyuluh, user)
   - Session management

2. **Admin Layout**
   - Fixed left sidebar (collapsible)
   - Top header with breadcrumbs, search, and user menu
   - Responsive design
   - Color scheme: #1B5E20 (primary), #FAFAFA (background)

3. **Dashboard**
   - Statistics cards (Total Perusahaan, Kabupaten, Harga TBS, Users)
   - Latest TBS prices table with price change indicators
   - Price change widget (📈 green for increase, 📉 red for decrease, ➖ gray for no change)
   - Weekly trends chart (Chart.js)

4. **Harga TBS Management**
   - List with filters (kabupaten, perusahaan, date range)
   - Create/Update/Delete (with role-based permissions)
   - Price change calculation
   - One active price per company per day validation

5. **Perusahaan Management**
   - CRUD operations
   - Unique nama_perusahaan per kabupaten validation
   - Relational select to kabupaten

6. **Kabupaten Management**
   - CRUD operations
   - Unique nama_kabupaten validation

### 🚧 To Be Completed

1. **Kalkulator Panen**
   - Form: berat_kotor, potongan %, upah_panen, transportasi, potong_hutang
   - Result card: hasil_bersih with breakdown
   - Controller: `Admin_kalkulator_panen.php`
   - View: `admin/kalkulator_panen/index.php`

2. **Dosis & Jenis Pupuk**
   - Master-detail: jenis_pupuk + dosis_pupuk by jenis_tanah and usia_tanaman
   - Controller: `Admin_pupuk.php`
   - Views: `admin/pupuk/index.php`, `admin/pupuk/dosis.php`

3. **Jenis Tanah**
   - Simple CRUD
   - Controller: `Admin_tanah.php`
   - View: `admin/tanah/index.php`

4. **Penyakit**
   - Master table with gejala, penyebab, pengendalian
   - Image upload functionality
   - Controller: `Admin_penyakit.php`
   - View: `admin/penyakit/index.php`

5. **Informasi (Artikel)**
   - CRUD: judul, kategori, penulis, gambar_header, thumbnail, konten (rich text), tanggal
   - Rich text editor integration (TinyMCE or CKEditor)
   - Controller: `Admin_informasi.php`
   - View: `admin/informasi/index.php`

6. **Users & Roles**
   - CRUD users
   - Assign role
   - Password reset (hash)
   - Avatar upload
   - Controller: `Admin_users.php`
   - View: `admin/users/index.php`

7. **Settings / Audit Log**
   - System settings
   - Audit log viewer
   - Controller: `Admin_settings.php`
   - View: `admin/settings/index.php`

## File Structure

```
application/
├── core/
│   └── MY_Controller.php          # Base controller with role checking
├── controllers/
│   └── admin/
│       ├── Admin_auth.php          # Admin authentication
│       ├── Admin_dashboard.php     # Dashboard controller
│       ├── Admin_harga_tbs.php    # Harga TBS CRUD
│       ├── Admin_perusahaan.php   # Perusahaan CRUD
│       ├── Admin_kabupaten.php    # Kabupaten CRUD
│       └── ... (other controllers)
├── models/
│   ├── Perusahaan_model.php       # Perusahaan model
│   ├── Harga_tbs_model.php        # Updated with CRUD methods
│   ├── Kabupaten_model.php        # Updated with CRUD methods
│   └── ... (other models)
└── views/
    └── admin/
        ├── layout/
        │   ├── header.php          # Admin layout header
        │   └── footer.php          # Admin layout footer
        ├── auth/
        │   └── login.php           # Admin login page
        ├── dashboard/
        │   └── index.php           # Dashboard view
        ├── harga_tbs/
        │   ├── index.php           # List view
        │   └── form.php            # Create/Update form
        ├── perusahaan/
        │   ├── index.php           # List view
        │   └── form.php            # Create/Update form
        └── kabupaten/
            ├── index.php           # List view
            └── form.php            # Create/Update form

assets/
├── css/
│   └── admin/
│       └── main.css               # Admin styles
└── js/
    └── admin/
        └── main.js                # Admin JavaScript
```

## Access Control

### Roles
- **admin**: Full CRUD + settings access
- **penyuluh**: Read + create/update on domain tables (no destructive deletes), limited user visibility
- **user**: Read-only public info + calculators

### Route Protection
Routes are protected via `MY_Controller`:
- `require_login()`: Check if user is logged in
- `require_role(['admin', 'penyuluh'])`: Check specific roles
- `require_admin()`: Admin only
- `require_admin_or_penyuluh()`: Admin or penyuluh
- `can_edit()`: Check if user can edit
- `can_delete()`: Check if user can delete (admin only)

## Setup Instructions

### 1. Database
Ensure all tables exist in the `sawit` database:
- `kabupaten`
- `perusahaan`
- `harga_tbs`
- `kalkulasi_panen`
- `jenis_tanah`
- `jenis_pupuk`
- `dosis_pupuk`
- `jenis_penyakit`
- `informasi_tambahan`
- `users`

### 2. Create Admin User
Run this SQL to create an admin user:

```sql
INSERT INTO users (username, email, password, role, nama_lengkap) 
VALUES ('admin', 'admin@sawitdigital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Administrator');
-- Password: password
```

Or use the registration form and manually update the role to 'admin' in the database.

### 3. Routes
Admin routes are configured in `application/config/routes.php`:
- `/admin` → Dashboard
- `/admin/login` → Login page
- `/admin/logout` → Logout
- `/admin/dashboard` → Dashboard
- `/admin/harga_tbs` → Harga TBS management
- `/admin/perusahaan` → Perusahaan management
- `/admin/kabupaten` → Kabupaten management
- etc.

### 4. Access
1. Navigate to `/admin/login`
2. Login with admin credentials
3. Access dashboard at `/admin/dashboard`

## Color Scheme

- **Primary**: #1B5E20 (dark green)
- **Secondary**: #2E7D32 (medium green)
- **Accent**: #388E3C (light green)
- **Success**: #2E7D32
- **Warning**: #F9A825
- **Danger**: #C62828
- **Info**: #0277BD
- **Background**: #FAFAFA
- **White**: #FAFAFA

## Dependencies

- Bootstrap 5.3.0 (CDN)
- Bootstrap Icons 1.11.0 (CDN)
- Chart.js 4.4.0 (CDN)
- jQuery 3.7.0 (CDN)

## Next Steps

1. Create remaining controllers following the pattern of `Admin_harga_tbs.php`
2. Create views for each module
3. Implement file upload for images (penyakit, informasi, users)
4. Add rich text editor for artikel content
5. Implement audit log system
6. Add data export functionality (Excel/PDF)
7. Implement advanced search and filtering
8. Add bulk operations

## Notes

- All admin controllers extend `MY_Controller` for role-based access
- Forms use CodeIgniter's form validation library
- Pagination is implemented using CI's pagination library
- Flash messages are used for user feedback
- All database operations use prepared statements via CI's query builder


