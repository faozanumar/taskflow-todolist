# 📋 TaskFlow — Aplikasi Todo List Laravel

Aplikasi manajemen tugas harian berbasis web menggunakan **Laravel** dengan database **SQLite**.

---

## 🛠️ Teknologi

| Teknologi | Versi |
|-----------|-------|
| PHP | >= 8.1 |
| Laravel | ^10.x / ^11.x |
| Database | SQLite (local) |
| CSS Framework | Bootstrap 5.3 |
| Date Picker | Flatpickr |
| Icons | Bootstrap Icons |

---

## ✅ Fitur Aplikasi

### Input Types yang Tersedia
| Tipe Input | Field | Keterangan |
|------------|-------|------------|
| **TextField** | Judul, Deskripsi | Input teks bebas |
| **Dropdown** | Kategori, Status | Pilih satu dari list |
| **Radio Button** | Prioritas | Pilih satu (Rendah/Sedang/Tinggi/Kritis) |
| **CheckBox** | Tags | Pilih lebih dari satu |
| **Switch/Toggle** | Tandai Penting | On/Off |
| **Date Picker** | Tanggal Deadline | Kalender interaktif (Flatpickr) |

### Fungsi CRUD
- ✅ **Create** — Form tambah todo dengan validasi lengkap
- ✅ **Read** — Tampilan list dengan filter, search, dan statistik
- ✅ **Update** — Form edit dengan data pre-filled
- ✅ **Delete** — Konfirmasi alert dialog sebelum hapus

### Fitur Tambahan
- 📊 Dashboard statistik (total, belum, selesai, terlambat)
- 🔍 Filter berdasarkan status, kategori, prioritas, dan pencarian judul
- ⏰ Indikator otomatis untuk todo yang terlambat (overdue)
- ✅ Toggle cepat tandai selesai langsung dari list
- 🔴 Garis warna prioritas di sisi kiri setiap item
- ⭐ Tandai todo sebagai penting
- 📱 Responsive (sidebar tersembunyi di mobile)
- 🌐 Bahasa Indonesia

---

## 🚀 Cara Instalasi

### 1. Prasyarat
Pastikan sudah terinstall:
- PHP >= 8.1
- Composer
- Git (opsional)

### 2. Clone / Extract Project
```bash
# Jika dari Git
git clone <repo-url> todoapp
cd todoapp

# Jika dari ZIP, extract lalu masuk ke folder
cd todoapp
```

### 3. Install Dependencies
```bash
composer install
```

### 4. Setup Environment
```bash
# Copy file .env
cp .env.example .env

# Generate app key
php artisan key:generate
```

### 5. Setup Database SQLite
```bash
# Buat file database SQLite (kosong)
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate

# (Opsional) Isi data contoh
php artisan db:seed
```

### 6. Jalankan Aplikasi
```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 📁 Struktur File Penting

```
todoapp/
├── app/
│   ├── Http/Controllers/
│   │   └── TodoController.php     ← CRUD Controller
│   └── Models/
│       └── Todo.php               ← Model + konstanta pilihan
├── database/
│   ├── migrations/
│   │   └── ..._create_todos_table.php  ← Skema tabel
│   ├── seeders/
│   │   └── TodoSeeder.php         ← Data contoh
│   └── database.sqlite            ← File database (dibuat manual)
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php          ← Layout utama + sidebar
│   └── todos/
│       ├── index.blade.php        ← Halaman list (READ)
│       ├── create.blade.php       ← Halaman tambah (CREATE)
│       ├── edit.blade.php         ← Halaman edit (UPDATE)
│       ├── show.blade.php         ← Halaman detail
│       └── _form.blade.php        ← Form partial (reusable)
├── routes/
│   └── web.php                    ← Definisi route
└── .env.example                   ← Contoh konfigurasi
```

---

## 🗄️ Struktur Tabel `todos`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint | Primary key |
| `judul` | varchar(255) | Judul todo (wajib) |
| `deskripsi` | text | Deskripsi detail (opsional) |
| `kategori` | varchar | pekerjaan/pribadi/belanja/kesehatan/pendidikan/lainnya |
| `prioritas` | varchar | rendah/sedang/tinggi/kritis |
| `tags` | json | Array tag (rumah/kantor/segera/dll) |
| `is_penting` | boolean | Tandai sebagai penting |
| `tanggal_deadline` | date | Batas waktu pengerjaan |
| `status` | varchar | belum/proses/selesai/dibatalkan |
| `created_at` | timestamp | Waktu dibuat |
| `updated_at` | timestamp | Waktu diperbarui |

---

## 🛣️ Daftar Route

| Method | URL | Name | Fungsi |
|--------|-----|------|--------|
| GET | `/todos` | `todos.index` | List semua todo |
| GET | `/todos/create` | `todos.create` | Form tambah |
| POST | `/todos` | `todos.store` | Simpan todo baru |
| GET | `/todos/{id}` | `todos.show` | Detail todo |
| GET | `/todos/{id}/edit` | `todos.edit` | Form edit |
| PUT | `/todos/{id}` | `todos.update` | Simpan perubahan |
| DELETE | `/todos/{id}` | `todos.destroy` | Hapus todo |
| PATCH | `/todos/{id}/toggle-selesai` | `todos.toggle-selesai` | Toggle status selesai |

---

## ✔️ Validasi Form

Semua field wajib divalidasi. Pesan error yang muncul jika kosong:

- **Judul** → "Judul belum diisi." (min 3 karakter)
- **Kategori** → "Kategori belum dipilih."
- **Prioritas** → "Prioritas belum dipilih."
- **Tanggal Deadline** → "Tanggal deadline belum diisi."
- **Status** → "Status belum dipilih."

---

## 👨‍💻 Dibuat dengan Laravel + Bootstrap 5
