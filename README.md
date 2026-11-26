# Sistem Rekam Medis

Aplikasi manajemen rekam medis dengan fitur Timeline Antrean menggunakan Laravel 11 dan Vue 3.

## Tech Stack

- **Backend:** Laravel 11
- **Frontend:** Vue 3 + Vite
- **Database:** SQLite
- **UI Template:** Able Pro Tailwind
- **HTTP Client:** Axios

## Features

### Master Data
- Manajemen Dokter (dengan foto)
- Manajemen Perawat
- Manajemen Pasien
- Jadwal Dokter (per hari & shift)

### Registrasi Pasien
- Form registrasi dengan AJAX
- Auto-load jadwal dokter
- Validasi real-time

### Antrean V2 - Timeline Scheduler
- **Day View:** Timeline horizontal dengan dokter di baris vertikal, jam di kolom horizontal
- **Month View:** Calendar grid dengan max 3 appointments per tanggal
- Dynamic data filtering berdasarkan tanggal
- Color coding: Kuning (menunggu), Biru (dipanggil), Hijau (selesai)
- Empty state untuk shift tanpa dokter

## Installation

```bash
# Clone repository
git clone git@github.com:abidardiansyah/rekam-medis.git
cd rekam-medis

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
touch database/database.sqlite
php artisan migrate --seed

# Build assets
npm run build

# Start server
php artisan serve
```

## Default Login

- Email: `admin@rekammedis.com`
- Password: `password`

## Development

```bash
# Run dev server
php artisan serve

# Run Vite dev server (in separate terminal)
npm run dev
```

## License

Proprietary
