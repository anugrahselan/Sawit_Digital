# Home Controller - Di Mana Digunakan?

## 📍 Lokasi Penggunaan

### 1. **Routes Configuration**
**File:** `application/config/routes.php` (Baris 53)

```php
$route['default_controller'] = 'Home';
```

**Penjelasan:**
- `default_controller` adalah route khusus di CodeIgniter
- Dipanggil ketika user mengakses **root URL** tanpa path tambahan
- Home controller ditetapkan sebagai default controller

---

## 🌐 URL yang Memicu Home Controller

### **URL yang Memanggil Home Controller:**

1. **Root URL (tanpa path):**
   ```
   http://localhost/Sawit_Digital/
   http://localhost/Sawit_Digital/index.php
   ```

2. **URL dengan Home controller:**
   ```
   http://localhost/Sawit_Digital/Home
   http://localhost/Sawit_Digital/Home/index
   ```

### **URL yang TIDAK Memanggil Home Controller:**

- `/beranda` → Langsung ke `user/Beranda/index`
- `/login` → Langsung ke `Auth/login`
- `/admin` → Langsung ke `admin/Admin_dashboard/index`
- URL lainnya yang sudah didefinisikan di routes

---

## 🔄 Alur Kerja Home Controller

### **Step-by-Step:**

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

---

## 💡 Mengapa Home Controller Diperlukan?

### **Masalah:**
CodeIgniter 3 **tidak mendukung subfolder** di `default_controller`.

**Tidak bisa langsung:**
```php
$route['default_controller'] = 'user/Beranda'; // ❌ ERROR
```

### **Solusi:**
Membuat wrapper controller di root:
```php
$route['default_controller'] = 'Home'; // ✅ BISA
```

Home controller kemudian melakukan redirect ke controller di subfolder.

---

## 📂 Struktur File

```
application/
└── controllers/
    ├── Home.php              ← Default controller (root)
    └── user/
        └── Beranda.php       ← Controller tujuan (subfolder)
```

---

## 🎯 Kapan Home Controller Dipanggil?

### **Dipanggil ketika:**
1. ✅ User mengakses root URL (`/`)
2. ✅ User mengakses URL tanpa path
3. ✅ URL tidak cocok dengan route lain

### **Tidak dipanggil ketika:**
1. ❌ User mengakses `/beranda` (langsung ke Beranda)
2. ❌ User mengakses `/login` (langsung ke Auth)
3. ❌ User mengakses URL yang sudah didefinisikan di routes

---

## 🔍 Contoh Praktis

### **Scenario 1: User membuka website**
```
URL: http://localhost/Sawit_Digital/
→ Home::index() dipanggil
→ Redirect ke /beranda
→ user/Beranda::index() ditampilkan
```

### **Scenario 2: User klik logo/home di navbar**
```
URL: http://localhost/Sawit_Digital/beranda
→ Langsung ke user/Beranda::index()
→ Home controller TIDAK dipanggil
```

### **Scenario 3: User bookmark root URL**
```
URL: http://localhost/Sawit_Digital/
→ Home::index() dipanggil
→ Redirect ke /beranda
```

---

## ✅ Kesimpulan

**Home Controller berfungsi di:**
- ✅ Sebagai **default_controller** di routes.php
- ✅ Dipanggil saat user mengakses **root URL** (`/`)
- ✅ Sebagai **wrapper/redirect** ke `user/Beranda`

**Tujuan:**
- Memastikan user yang mengakses root URL langsung diarahkan ke halaman beranda
- Solusi untuk keterbatasan CodeIgniter 3 yang tidak mendukung subfolder di default_controller

