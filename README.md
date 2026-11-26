# Sistem Rekam Medis

Sistem Rekam Medis berbasis Laravel 11 dengan template Able Pro Tailwind CSS.

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.3+
- Composer
- Node.js & NPM
- PostgreSQL (opsional, saat ini menggunakan SQLite)

### Cara Menjalankan

1. **Clone atau navigasi ke project**
   ```bash
   cd /home/jvchoo/project/rekam-medis
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Build assets**
   ```bash
   npm run build
   ```

5. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Jalankan server**
   ```bash
   php artisan serve
   ```

7. **Akses aplikasi**
   - URL: http://localhost:8000
   - Email: admin@rekammedis.com
   - Password: password

## 📁 Struktur Project

```
rekam-medis/
├── app/
│   └── Http/
│       └── Controllers/
│           ├── AuthController.php      # Handle login/logout
│           └── DashboardController.php # Handle dashboard
├── public/
│   └── assets/                         # Assets dari Able Pro
│       ├── css/
│       ├── js/
│       ├── fonts/
│       └── images/
├── resources/
│   ├── views/
��   │   ├── layouts/
│   │   │   └── app.blade.php          # Main layout
│   │   ├── components/
│   │   │   ├── sidebar.blade.php      # Sidebar component
│   │   │   └── topbar.blade.php       # Topbar component
│   │   ├── auth/
│   │   │   └── login.blade.php        # Login page
│   │   └── dashboard.blade.php        # Dashboard page
│   └── css/
│       └── app.css                     # Tailwind CSS
├── routes/
│   └── web.php                         # Routes definition
└── tailwind.config.js                  # Tailwind configuration
```

## 🎨 Fitur yang Sudah Diimplementasikan

### ✅ Authentication System
- Login page dengan desain dari Able Pro (login-v2.html)
- Logout functionality
- Session management
- Remember me feature

### ✅ Dashboard
- Blank dashboard page (dari sample-page.html)
- Sidebar navigation
- Topbar dengan user profile, notifications, theme switcher
- Responsive layout

### ✅ UI Components
- Sidebar dengan user profile card
- Topbar dengan dropdown menus
- Dark/Light mode switcher
- Notification dropdown
- User profile dropdown

## 🗄️ Database

Saat ini menggunakan **SQLite** untuk kemudahan development.

### Migrasi ke PostgreSQL

Jika ingin menggunakan PostgreSQL, edit file `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=rekam_medis
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Kemudian jalankan:
```bash
php artisan migrate:fresh --seed
```

## 🔐 Default User

- **Email**: admin@rekammedis.com
- **Password**: password

## 🛠️ Development

### Build CSS untuk development
```bash
npm run dev
```

### Build CSS untuk production
```bash
npm run build
```

### Clear cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📝 Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | / | login | Show login page |
| POST | /login | - | Process login |
| GET | /dashboard | dashboard | Show dashboard (auth required) |
| POST | /logout | logout | Process logout (auth required) |

## 🎯 Next Steps

Untuk pengembangan selanjutnya, Anda bisa menambahkan:

1. **Manajemen Pasien**
   - CRUD pasien
   - Form pendaftaran pasien
   - Tabel daftar pasien

2. **Rekam Medis**
   - Form rekam medis
   - Riwayat kunjungan
   - Diagnosa dan resep

3. **Manajemen Dokter**
   - CRUD dokter
   - Jadwal praktek
   - Spesialisasi

4. **Appointment System**
   - Booking jadwal
   - Kalender appointment
   - Notifikasi

5. **Billing & Pembayaran**
   - Invoice
   - Riwayat pembayaran
   - Laporan keuangan

## 📦 Assets

Semua assets dari Able Pro sudah dicopy ke folder `public/assets/`:
- CSS: `public/assets/css/style.css`
- JavaScript: `public/assets/js/`
- Fonts: `public/assets/fonts/`
- Images: `public/assets/images/`

## 🔧 Troubleshooting

### Error: Vite manifest not found
```bash
npm run build
```

### Error: Database connection
Pastikan database sudah dibuat dan konfigurasi di `.env` sudah benar.

### Error: Permission denied
```bash
chmod -R 775 storage bootstrap/cache
```

## 📄 License

Project ini menggunakan template Able Pro. Pastikan Anda memiliki lisensi yang valid untuk penggunaan komersial.

---

**Dibuat dengan Laravel 11 + Able Pro Tailwind Template**
