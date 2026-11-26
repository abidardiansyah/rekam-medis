# 📋 Panduan Instalasi Sistem Rekam Medis

## ✅ Status Instalasi

Sistem sudah **BERHASIL DIINSTALL** dan siap digunakan!

## 🎉 Akses Aplikasi

**URL**: http://localhost:8000

**Login Credentials**:
- Email: `admin@rekammedis.com`
- Password: `password`

## 🚀 Cara Menjalankan Server

```bash
cd /home/jvchoo/project/rekam-medis
php artisan serve
```

Server akan berjalan di: http://localhost:8000

## 📊 Database

Saat ini menggunakan **SQLite** (file: `database/database.sqlite`)

Database sudah berisi:
- ✅ Tabel users
- ✅ Tabel cache
- ✅ Tabel jobs
- ✅ 1 user admin (admin@rekammedis.com)

## 🎨 UI Template

Template **Able Pro Tailwind** sudah terintegrasi:
- ✅ Login page (dari login-v2.html)
- ✅ Dashboard layout (dari sample-page.html)
- ✅ Sidebar navigation
- ✅ Topbar dengan notifications & user menu
- ✅ Dark/Light mode switcher

## 📁 Assets Location

Semua assets Able Pro ada di:
```
public/assets/
├── css/style.css
├── js/
├── fonts/
└── images/
```

## 🔄 Development Workflow

### 1. Edit CSS/Tailwind
```bash
npm run dev    # Development mode (watch)
npm run build  # Production build
```

### 2. Edit Blade Templates
File views ada di: `resources/views/`
- `layouts/app.blade.php` - Main layout
- `components/sidebar.blade.php` - Sidebar
- `components/topbar.blade.php` - Topbar
- `auth/login.blade.php` - Login page
- `dashboard.blade.php` - Dashboard page

### 3. Edit Routes
File: `routes/web.php`

### 4. Edit Controllers
Folder: `app/Http/Controllers/`

## 🗺️ Routes yang Tersedia

| URL | Method | Deskripsi | Auth Required |
|-----|--------|-----------|---------------|
| `/` | GET | Login page | No |
| `/login` | POST | Process login | No |
| `/dashboard` | GET | Dashboard | Yes |
| `/logout` | POST | Logout | Yes |

## 🔧 Commands Berguna

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Reset database
php artisan migrate:fresh --seed

# Create new controller
php artisan make:controller NamaController

# Create new model
php artisan make:model NamaModel -m

# Create new migration
php artisan make:migration create_nama_table

# Run migrations
php artisan migrate

# Run seeder
php artisan db:seed
```

## 📝 Struktur File Penting

```
rekam-medis/
├── .env                          # Environment config
├── routes/web.php                # Routes definition
├── app/Http/Controllers/         # Controllers
├── resources/views/              # Blade templates
├── public/assets/                # Able Pro assets
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
└── tailwind.config.js            # Tailwind config
```

## 🎯 Next Development Steps

### 1. Manajemen Pasien
- Buat migration untuk tabel `pasien`
- Buat model `Pasien`
- Buat controller `PasienController`
- Buat views untuk CRUD pasien

### 2. Rekam Medis
- Buat migration untuk tabel `rekam_medis`
- Relasi dengan tabel pasien
- Form input rekam medis

### 3. Manajemen Dokter
- Buat migration untuk tabel `dokter`
- CRUD dokter
- Jadwal praktek

### 4. Appointment
- Buat migration untuk tabel `appointments`
- Sistem booking
- Kalender

## 🐛 Troubleshooting

### Server tidak bisa diakses
```bash
# Stop server yang sedang berjalan
pkill -f "php artisan serve"

# Start ulang
php artisan serve
```

### Error 500 - Vite manifest not found
```bash
npm run build
```

### Permission error
```bash
chmod -R 775 storage bootstrap/cache
```

### Database error
```bash
# Reset database
php artisan migrate:fresh --seed
```

## 📞 Support

Jika ada masalah, cek:
1. Log file: `storage/logs/laravel.log`
2. Browser console untuk error JavaScript
3. Network tab untuk error API

---

**Status**: ✅ READY TO USE
**Version**: 1.0.0
**Last Updated**: 2026-11-26
