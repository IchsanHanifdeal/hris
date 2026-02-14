# MyHRIS — Human Resource Information System

Sistem manajemen SDM berbasis web yang dibangun dengan Laravel 12. Dirancang untuk mempermudah pengelolaan data karyawan, kehadiran, jadwal kerja, pengajuan cuti, dan penggajian dalam satu platform terpadu.

![PHP](https://img.shields.io/badge/PHP-8.2+-purple?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-red?logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-4-blue?logo=tailwindcss&logoColor=white)
![DaisyUI](https://img.shields.io/badge/DaisyUI-5-green?logo=daisyui&logoColor=white)

---

## Fitur Utama

### 👥 Manajemen Karyawan
- CRUD data karyawan lengkap (data pribadi, jabatan, departemen)
- Kode karyawan otomatis
- Onboarding karyawan baru via profil

### 🏢 Struktur Organisasi
- Manajemen **departemen** dan **jabatan**
- Relasi antar entitas (departemen → jabatan → karyawan)

### ⏰ Shift & Jadwal Kerja
- Pengaturan shift kerja (jam masuk, jam keluar)
- Jadwal kerja bulanan dalam tampilan matrix
- Penugasan shift per karyawan per hari

### 📋 Kehadiran (Attendance)
- Pencatatan kehadiran harian (time-in, time-out)
- Statistik harian: hadir, terlambat, lembur
- Filter berdasarkan tanggal
- Detail kehadiran dengan lokasi GPS & peta (Leaflet.js)
- Integrasi foto check-in/check-out

### 📝 Pengajuan Cuti (Leave Request)
- Pengajuan cuti oleh karyawan
- Approval / rejection oleh HR dengan catatan penolakan
- Manajemen tipe cuti (Annual, Sick, Maternity, dll.)
- Statistik: pending, disetujui, jenis cuti

### 💰 Penggajian (Payroll)
- Perhitungan gaji otomatis berdasarkan data kehadiran
- Komponen: gaji pokok, tunjangan, lembur, potongan
- Potongan otomatis untuk keterlambatan & absensi
- Simulasi gaji real-time
- Edit slip gaji manual
- **Cetak slip gaji** (format A4, siap print)
- Filter berdasarkan bulan & tahun

### 🌐 Multi Bahasa
- Dukungan penuh **Bahasa Indonesia** dan **English**
- Switching bahasa langsung dari UI

### 👤 Profil & Keamanan
- Edit profil pengguna
- Ubah password
- Role-based access control (Admin, HRD) via Spatie Permission

---

## Tech Stack

| Layer       | Teknologi                                                          |
| ----------- | ------------------------------------------------------------------ |
| Backend     | PHP 8.2+, Laravel 12                                               |
| Frontend    | Blade, Alpine.js, Tailwind CSS 4, DaisyUI 5                       |
| Build Tool  | Vite 7                                                             |
| Icons       | Lucide Icons (via blade-lucide-icons)                              |
| Maps        | Leaflet.js                                                         |
| Auth        | Laravel Breeze                                                     |
| Permissions | Spatie Laravel Permission                                          |
| i18n        | Laravel Lang                                                       |

---

## Arsitektur

```
app/
├── Console/Commands/      # Artisan commands (dummy data generators)
├── Http/
│   ├── Controllers/       # Request handlers per modul
│   └── Requests/          # Form request validation
├── Models/                # Eloquent models
└── Services/              # Business logic layer

resources/
├── views/
│   ├── dashboard/         # Halaman modul (attendance, payroll, dll.)
│   └── components/        # Reusable Blade components
└── lang/
    ├── id/                # Terjemahan Bahasa Indonesia
    └── en/                # Terjemahan English
```

Aplikasi menggunakan pola **Service Layer** — setiap controller mendelegasikan business logic ke service class masing-masing, menjaga controller tetap ringan dan mudah diuji.

---

## Instalasi

### Prasyarat
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL / SQLite

### Langkah Setup

```bash
# 1. Clone repository
git clone https://github.com/ichsanhanifdeal/hris.git
cd hris

# 2. Install dependencies & setup otomatis
composer setup
```

Perintah `composer setup` akan menjalankan:
- `composer install`
- Copy `.env.example` → `.env`
- Generate application key
- Jalankan migrasi database
- `npm install` & `npm run build`

### Konfigurasi Database

Sesuaikan file `.env` dengan koneksi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hris
DB_USERNAME=root
DB_PASSWORD=
```

### Jalankan Development Server

```bash
composer run dev
```

Perintah ini akan menjalankan secara bersamaan:
- 🟦 Laravel server (`php artisan serve`)
- 🟣 Queue listener
- 🟥 Log viewer (Pail)
- 🟧 Vite dev server

---

## Dummy Data

Untuk keperluan testing, tersedia perintah Artisan untuk generate data dummy:

```bash
# Generate data kehadiran & jadwal
php artisan app:attendance-dummy

# Generate pengajuan cuti (default: 10 data)
php artisan app:dummy-leave-request --count=20

# Generate payroll berdasarkan data kehadiran
php artisan app:dummy-payroll --month=2 --year=2026
```

---

## Struktur Modul

| Modul          | Controller               | Service                | Model          |
| -------------- | ------------------------ | ---------------------- | -------------- |
| Dashboard      | —                        | —                      | —              |
| Karyawan       | EmployeeController       | EmployeeService        | Employee       |
| Departemen     | DepartmentController     | DepartmentService      | Department     |
| Jabatan        | PositionController       | PositionService        | Position       |
| Shift          | ShiftController          | ShiftService           | Shift          |
| Jadwal Kerja   | SchedulesController      | SchedulesService       | Schedule       |
| Kehadiran      | AttendanceController     | AttendanceService      | Attendance     |
| Tipe Cuti      | LeaveTypeController      | LeaveTypeService       | LeaveType      |
| Pengajuan Cuti | LeaveRequestController   | LeaveRequestService    | LeaveRequest   |
| Penggajian     | PayrollController        | PayrollService         | Payroll        |
| Profil         | ProfileController        | —                      | User           |

---

## Lisensi

Project ini bersifat private dan dikembangkan untuk keperluan internal.
