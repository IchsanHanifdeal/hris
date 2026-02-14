# MyHRIS — Human Resource Information System

Sistem manajemen SDM berbasis web yang dibangun dengan **Laravel 12**. Dirancang untuk mempermudah pengelolaan data karyawan, kehadiran, jadwal kerja, pengajuan cuti, dan penggajian dalam satu platform terpadu.

![PHP](https://img.shields.io/badge/PHP-8.2+-purple?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-red?logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-4-blue?logo=tailwindcss&logoColor=white)
![DaisyUI](https://img.shields.io/badge/DaisyUI-5-green?logo=daisyui&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7-yellow?logo=vite&logoColor=white)

---

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Tech Stack](#tech-stack)
- [Arsitektur Aplikasi](#arsitektur-aplikasi)
- [Struktur Folder](#struktur-folder)
- [Database Schema](#database-schema)
- [Roles & Permissions](#roles--permissions)
- [Instalasi](#instalasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Seeder & Dummy Data](#seeder--dummy-data)
- [Routing](#routing)
- [Multi Bahasa](#multi-bahasa)
- [Struktur Modul](#struktur-modul)
- [Blade Components](#blade-components)
- [Screenshot](#screenshot)
- [Lisensi](#lisensi)

---

## Fitur Utama

### 👥 Manajemen Karyawan
- CRUD data karyawan lengkap (nama, email, jenis kelamin, tempat/tanggal lahir, alamat, telepon)
- Kode karyawan otomatis (format: `EMP-DDMMYYYYHHMMSS`)
- Relasi ke jabatan dan departemen
- Status karyawan: `active`, `inactive`, `leave`, `probation`
- Soft delete (data tidak hilang permanen)

### 🏢 Departemen & Jabatan
- Manajemen departemen (Information Technology, Human Resources, Finance, Operations, dll.)
- Manajemen jabatan beserta **gaji pokok** per jabatan
- Soft delete untuk kedua entitas

### ⏰ Shift & Jadwal Kerja
- Pengaturan shift kerja: nama shift, jam masuk, jam keluar
- Default 3 shift: Morning (08-17), Middle (12-21), Night (22-07)
- Jadwal kerja bulanan — assign shift ke karyawan per tanggal
- Tampilan matrix jadwal bulanan di dashboard

### 📋 Kehadiran (Attendance)
- Pencatatan check-in dan check-out harian
- Data yang dicatat per kehadiran:
  - Waktu masuk & keluar (`time_in`, `time_out`)
  - Koordinat GPS masuk & keluar (`lat_in`, `long_in`, `lat_out`, `long_out`)
  - Foto selfie masuk & keluar (`photo_in`, `photo_out`)
- Status otomatis: `on_time`, `late`, `overtime`
- Detail kehadiran dengan peta lokasi (Leaflet.js)
- Statistik harian: jumlah hadir, terlambat, cuti

### 📝 Pengajuan Cuti (Leave Request)
- Karyawan mengajukan cuti dengan memilih tipe, tanggal mulai/selesai, alasan, dan lampiran
- Tipe cuti tersedia: Annual, Sick, Maternity, Paternity, Bereavement, Unpaid
- Setiap tipe cuti memiliki kuota tahunan (default: 12 hari)
- Approval / rejection oleh Admin atau HRD
- Catatan penolakan (`rejection_note`) untuk feedback ke karyawan
- Statistik: pending, disetujui bulan ini, total tipe cuti

### 💰 Penggajian (Payroll)
- Perhitungan gaji otomatis berdasarkan data kehadiran bulanan
- Komponen gaji:
  - **Gaji Pokok** — diambil dari jabatan karyawan
  - **Tunjangan** — input manual
  - **Lembur** — dihitung otomatis (Rp 50.000/jam jika lebih dari 1 jam setelah shift selesai)
  - **Potongan** — dihitung otomatis:
    - Keterlambatan: Rp 35.000 per kejadian
    - Absensi: Rp 100.000 per hari absen (asumsi 22 hari kerja/bulan)
- Proses batch: hitung semua karyawan aktif sekaligus
- Edit slip gaji manual untuk penyesuaian
- Status: `draft` (belum dibayar) → `paid` (sudah dibayar)
- **Simulasi gaji** — hitung perkiraan gaji bersih secara real-time
- **Cetak slip gaji** — format A4 dengan header perusahaan, rincian pendapatan & potongan, kolom tanda tangan

### 🌐 Multi Bahasa (i18n)
- Bahasa Indonesia dan English
- Switching bahasa langsung dari UI profil
- Preferensi bahasa disimpan di kolom `locale` pada tabel `users`
- File terjemahan tersedia untuk semua modul: dashboard, employee, attendance, payroll, leave, shift, schedule, department, position, profile, login

### 👤 Profil & Keamanan
- Edit nama dan email
- Ubah password
- Autentikasi via Laravel Breeze (login, register, forgot password, email verification)
- Role-based access menggunakan Spatie Permission

---

## Tech Stack

| Layer       | Teknologi                                                                    |
| ----------- | ---------------------------------------------------------------------------- |
| Backend     | PHP 8.2+, Laravel 12                                                         |
| Frontend    | Blade Templates, Alpine.js 3                                                 |
| Styling     | Tailwind CSS 4, DaisyUI 5, @tailwindcss/forms                               |
| Build Tool  | Vite 7 + laravel-vite-plugin                                                 |
| Icons       | Lucide Icons (via `mallardduck/blade-lucide-icons`)                          |
| Maps        | Leaflet.js (untuk peta lokasi kehadiran)                                     |
| Auth        | Laravel Breeze                                                               |
| Permissions | Spatie Laravel Permission v6                                                 |
| i18n        | laravel-lang/common                                                          |
| HTTP Client | Axios                                                                        |
| Testing     | Pest PHP 4                                                                   |

---

## Arsitektur Aplikasi

Aplikasi ini menggunakan arsitektur **Service Layer Pattern**:

```
Request → Route → Controller → Service → Model → Database
                                  ↓
                              Response ← View (Blade)
```

**Mengapa Service Layer?**
- Controller tetap ringan — hanya menangani request/response
- Business logic terpusat di service class — mudah diuji dan di-maintain
- Reusable — service bisa dipanggil dari controller, artisan command, maupun job

Setiap modul mengikuti pola yang konsisten:
1. `Controller` — menerima request, memanggil service, mengembalikan view
2. `Service` — logika bisnis (query, kalkulasi, validasi lanjutan)
3. `Model` — representasi tabel database + relasi Eloquent
4. `FormRequest` — validasi input dari user
5. `Blade View` — tampilan UI dengan komponen reusable

---

## Struktur Folder

```
hris/
├── app/
│   ├── Console/Commands/          # Artisan commands
│   │   ├── AttendanceDummy.php    # Generate dummy data kehadiran
│   │   ├── DummyLeaveRequest.php  # Generate dummy pengajuan cuti
│   │   ├── DummyPayroll.php       # Generate dummy payroll
│   │   └── makeServices.php       # Generator service class
│   │
│   ├── Http/
│   │   ├── Controllers/           # Controller per modul
│   │   │   ├── Auth/              # Auth controllers (Breeze)
│   │   │   ├── AttendanceController.php
│   │   │   ├── DepartmentController.php
│   │   │   ├── EmployeeController.php
│   │   │   ├── LeaveRequestController.php
│   │   │   ├── LeaveTypeController.php
│   │   │   ├── LocalizationController.php
│   │   │   ├── PayrollController.php
│   │   │   ├── PositionController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── SchedulesController.php
│   │   │   └── ShiftController.php
│   │   │
│   │   ├── Middleware/
│   │   │   └── SetLocale.php      # Set bahasa berdasarkan user preference
│   │   │
│   │   └── Requests/              # Form request validation
│   │       ├── AttendanceRequest.php
│   │       ├── EmployeeRequest.php
│   │       ├── LeaveRequestRequest.php
│   │       ├── PayrollRequest.php
│   │       ├── SchedulesRequest.php
│   │       └── ...
│   │
│   ├── Models/                    # Eloquent models
│   │   ├── Attendance.php
│   │   ├── Department.php
│   │   ├── Employee.php
│   │   ├── LeaveRequest.php
│   │   ├── LeaveType.php
│   │   ├── Payroll.php
│   │   ├── Position.php
│   │   ├── Schedule.php
│   │   ├── Shift.php
│   │   └── User.php
│   │
│   └── Services/                  # Business logic layer
│       ├── AttendanceService.php
│       ├── DepartmentService.php
│       ├── EmployeeService.php
│       ├── LeaveRequestService.php
│       ├── PayrollService.php
│       ├── SchedulesService.php
│       └── ...
│
├── database/
│   ├── migrations/                # Skema database
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RolePermissionSeeder.php   # Roles & permissions
│       └── MasterDataSeeder.php       # Data awal (dept, jabatan, shift, dll.)
│
├── lang/
│   ├── id/                        # Terjemahan Bahasa Indonesia (24 file)
│   ├── en/                        # Terjemahan English (20 file)
│   ├── id.json                    # JSON translations (ID)
│   └── en.json                    # JSON translations (EN)
│
├── resources/views/
│   ├── auth/                      # Halaman login, register, forgot password
│   ├── dashboard/                 # Halaman modul utama
│   │   ├── index.blade.php        # Dashboard utama
│   │   ├── employee/              # CRUD karyawan (index, create, edit)
│   │   ├── attendance.blade.php   # Tabel kehadiran
│   │   ├── schedules.blade.php    # Matrix jadwal kerja
│   │   ├── leave-request.blade.php
│   │   ├── payroll.blade.php      # Tabel + cetak slip gaji
│   │   ├── department.blade.php
│   │   ├── positions.blade.php
│   │   ├── shift.blade.php
│   │   └── leave-type.blade.php
│   │
│   ├── components/                # Blade components
│   │   ├── dashboard/             # Komponen dashboard
│   │   │   ├── main.blade.php     # Layout utama dashboard
│   │   │   ├── aside.blade.php    # Sidebar navigasi
│   │   │   ├── navbar.blade.php   # Top navbar
│   │   │   ├── card/              # Komponen kartu (info, stat, table)
│   │   │   └── modal/             # Komponen modal (add, edit, delete, detail)
│   │   └── pwa/                   # Komponen PWA (mobile view)
│   │
│   ├── profile/                   # Halaman profil & ubah password
│   └── pwa/                       # PWA dashboard untuk role karyawan
│
├── routes/
│   ├── web.php                    # Route utama aplikasi
│   ├── auth.php                   # Route autentikasi (Breeze)
│   └── console.php                # Artisan route
│
└── public/
    └── build/                     # Asset hasil build Vite
```

---

## Database Schema

### Tabel Utama

| Tabel              | Kolom Penting                                                                                             | Relasi                                          |
| ------------------ | --------------------------------------------------------------------------------------------------------- | ----------------------------------------------- |
| `users`            | name, email, password, locale                                                                             | → Employee (1:1)                                |
| `departments`      | name                                                                                                      | ← Employee (1:N)                                |
| `positions`        | name, basic_salary                                                                                        | ← Employee (1:N)                                |
| `employees`        | user_id, department_id, position_id, employee_code, gender, place_of_birth, date_of_birth, phone, address, status | → User, → Department, → Position               |
| `shifts`           | name, start_time, end_time                                                                                | ← Schedule (1:N)                                |
| `schedules`        | employee_id, shift_id, date                                                                               | → Employee, → Shift                             |
| `attendances`      | employee_id, shift_id, schedule_id, date, time_in/out, lat/long_in/out, photo_in/out, status              | → Employee, → Shift, → Schedule                 |
| `leave_types`      | name, quota                                                                                               | ← LeaveRequest (1:N)                            |
| `leave_requests`   | employee_id, leave_type_id, start_date, end_date, reason, attachment, status, approved_by, rejection_note | → Employee, → LeaveType, → User (approver)      |
| `payrolls`         | employee_id, period_start, period_end, basic_salary, allowances, overtime_pay, deductions, net_salary, status | → Employee                                      |

### Status Enum

| Tabel            | Kolom    | Values                                   |
| ---------------- | -------- | ---------------------------------------- |
| `employees`      | status   | `active`, `inactive`, `leave`, `probation` |
| `attendances`    | status   | `on_time`, `late`, `overtime`            |
| `leave_requests` | status   | `pending`, `approved`, `rejected`        |
| `payrolls`       | status   | `draft`, `paid`                          |

---

## Roles & Permissions

Aplikasi menggunakan **Spatie Laravel Permission** dengan 5 role dan 7 permission:

| Role       | Permissions                                                                   |
| ---------- | ----------------------------------------------------------------------------- |
| `admin`    | Semua permission (full access)                                                |
| `hrd`      | view_dashboard, manage_users, manage_shifts, manage_payroll, approve_leave    |
| `manager`  | view_dashboard, approve_leave                                                 |
| `karyawan` | view_dashboard, view_own_payslip, submit_attendance                           |
| `direktur` | view_dashboard                                                                |

Middleware `role:admin|hrd` diterapkan pada route grup `/dashboard` untuk membatasi akses.

---

## Instalasi

### Prasyarat

| Software   | Versi Minimum |
| ---------- | ------------- |
| PHP        | 8.2+          |
| Composer   | 2.x           |
| Node.js    | 18+           |
| NPM        | 9+            |
| MySQL      | 8.0+          |

### Langkah Setup

```bash
# 1. Clone repository
git clone https://github.com/ichsanhanifdeal/hris.git
cd hris

# 2. Install semua dependencies + setup otomatis
composer setup
```

Perintah `composer setup` secara otomatis menjalankan:

| Step | Perintah                       | Keterangan                           |
| ---- | ------------------------------ | ------------------------------------ |
| 1    | `composer install`             | Install PHP dependencies             |
| 2    | Copy `.env.example` → `.env`  | Buat file konfigurasi                |
| 3    | `php artisan key:generate`     | Generate application key             |
| 4    | `php artisan migrate --force`  | Jalankan migrasi database            |
| 5    | `npm install`                  | Install JS dependencies              |
| 6    | `npm run build`                | Build assets untuk production        |

### Konfigurasi Database

Edit file `.env` sesuai koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hris
DB_USERNAME=root
DB_PASSWORD=
```

### Jalankan Seeder

```bash
php artisan db:seed
```

Seeder akan membuat:
- **Roles & Permissions** — 5 role (admin, hrd, manager, karyawan, direktur) dan 7 permission
- **Master Data** — 4 departemen, 4 jabatan, 3 shift, 6 tipe cuti
- **Akun Admin** — `admin@gmail.com` / `password`

---

## Menjalankan Aplikasi

```bash
composer run dev
```

Perintah ini menjalankan 4 proses secara bersamaan:

| Warna | Proses             | Perintah                                  |
| ----- | ------------------ | ----------------------------------------- |
| 🟦    | Laravel Server     | `php artisan serve`                       |
| 🟣    | Queue Listener     | `php artisan queue:listen --tries=1`      |
| 🟥    | Log Viewer         | `php artisan pail --timeout=0`            |
| 🟧    | Vite Dev Server    | `npm run dev`                             |

Aplikasi akan tersedia di: **http://localhost:8000**

### Login Default

| Email             | Password   | Role    |
| ----------------- | ---------- | ------- |
| admin@gmail.com   | password   | Admin   |

---

## Seeder & Dummy Data

### Database Seeder

```bash
php artisan db:seed
```

Membuat data master lengkap:

| Data         | Jumlah | Contoh                                                |
| ------------ | ------ | ----------------------------------------------------- |
| Departemen   | 4      | Information Technology, Human Resources, Finance, Ops |
| Jabatan      | 4      | Senior Backend Engineer (Rp 15jt), HR Manager (Rp 12jt), dll. |
| Shift        | 3      | Morning (08-17), Middle (12-21), Night (22-07)        |
| Tipe Cuti    | 6      | Annual, Sick, Maternity, Paternity, Bereavement, Unpaid |
| User Admin   | 1      | Ichsan Hanifdeal (admin@gmail.com)                    |

### Artisan Commands (Dummy Data)

Untuk keperluan testing dan demo:

```bash
# Generate data kehadiran beserta jadwal
php artisan app:attendance-dummy

# Generate pengajuan cuti random
php artisan app:dummy-leave-request
php artisan app:dummy-leave-request --count=20    # custom jumlah

# Generate payroll berdasarkan data kehadiran yang sudah ada
php artisan app:dummy-payroll
php artisan app:dummy-payroll --month=1 --year=2026    # custom periode
```

### Custom Artisan: Generate Service Class

```bash
php artisan make:service NamaService
```

Otomatis membuat file service baru di `app/Services/`.

---

## Routing

Semua route utama berada di dalam grup middleware `auth` + `verified`, prefix `/dashboard`:

### Resource Routes (CRUD Lengkap)

| Route                    | Controller               | Akses        |
| ------------------------ | ------------------------ | ------------ |
| `/dashboard/departments` | DepartmentController     | admin, hrd   |
| `/dashboard/positions`   | PositionController       | admin, hrd   |
| `/dashboard/shifts`      | ShiftController          | admin, hrd   |
| `/dashboard/employees`   | EmployeeController       | admin, hrd   |
| `/dashboard/schedules`   | SchedulesController      | admin, hrd   |
| `/dashboard/attendances` | AttendanceController     | admin, hrd   |
| `/dashboard/leave-types` | LeaveTypeController      | admin, hrd   |
| `/dashboard/leave-requests` | LeaveRequestController | admin, hrd  |
| `/dashboard/payrolls`    | PayrollController        | admin, hrd   |

### Route Tambahan

| Method   | Route                                         | Keterangan                        |
| -------- | --------------------------------------------- | --------------------------------- |
| `PATCH`  | `/dashboard/leave-requests/{id}/{status}`     | Approve / reject cuti             |
| `POST`   | `/dashboard/payrolls/batch-generate`          | Hitung gaji semua karyawan        |
| `PATCH`  | `/dashboard/payrolls/{id}/pay`                | Tandai payroll sebagai "dibayar"  |
| `GET`    | `/lang/{locale}`                              | Switch bahasa (id / en)           |
| `GET`    | `/dashboard/profile`                          | Halaman profil                    |
| `PATCH`  | `/dashboard/profile`                          | Update profil                     |
| `PUT`    | `/dashboard/profile/password`                 | Update password                   |

---

## Multi Bahasa

Aplikasi mendukung **Bahasa Indonesia** dan **English** secara penuh.

### File Terjemahan

```
lang/
├── id/                     # 24 file PHP
│   ├── dashboard.php
│   ├── employee.php
│   ├── attendances.php
│   ├── payroll.php
│   ├── leave.php
│   ├── schedules.php
│   ├── shift.php
│   ├── department.php
│   ├── position.php
│   ├── profile.php
│   ├── login.php
│   ├── menu.php
│   └── ...
├── en/                     # 20 file PHP
│   └── (mirror dari id/)
├── id.json                 # JSON translations
└── en.json                 # JSON translations
```

### Cara Kerja

1. Preferensi bahasa disimpan di kolom `users.locale` (default: `id`)
2. Middleware `SetLocale` membaca preference user dan men-set `App::setLocale()`
3. Semua string di Blade menggunakan `{{ __('module.key') }}` atau `@lang()`
4. User bisa switch bahasa di halaman profil → request dikirim ke `/lang/{locale}`

---

## Struktur Modul

Setiap modul mengikuti pola yang konsisten:

| Modul          | Controller               | Service                | Model          | FormRequest             | View                       |
| -------------- | ------------------------ | ---------------------- | -------------- | ----------------------- | -------------------------- |
| Dashboard      | (closure)                | —                      | —              | —                       | `dashboard/index`          |
| Karyawan       | EmployeeController       | EmployeeService        | Employee       | EmployeeRequest         | `dashboard/employee/*`     |
| Departemen     | DepartmentController     | DepartmentService      | Department     | StoreDepartmentRequest  | `dashboard/department`     |
| Jabatan        | PositionController       | PositionService        | Position       | PositionRequest         | `dashboard/positions`      |
| Shift          | ShiftController          | ShiftService           | Shift          | ShiftRequest            | `dashboard/shift`          |
| Jadwal Kerja   | SchedulesController      | SchedulesService       | Schedule       | SchedulesRequest        | `dashboard/schedules`      |
| Kehadiran      | AttendanceController     | AttendanceService      | Attendance     | AttendanceRequest       | `dashboard/attendance`     |
| Tipe Cuti      | LeaveTypeController      | LeaveTypeService       | LeaveType      | LeaveTypeRequest        | `dashboard/leave-type`     |
| Pengajuan Cuti | LeaveRequestController   | LeaveRequestService    | LeaveRequest   | LeaveRequestRequest     | `dashboard/leave-request`  |
| Penggajian     | PayrollController        | PayrollService         | Payroll        | PayrollRequest          | `dashboard/payroll`        |
| Profil         | ProfileController        | —                      | User           | ProfileUpdateRequest    | `profile/edit`             |
| Lokalisasi     | LocalizationController   | —                      | —              | —                       | —                          |

---

## Blade Components

Aplikasi menggunakan sistem komponen Blade untuk konsistensi UI:

### Dashboard Components

| Component                   | File                              | Kegunaan                                  |
| --------------------------- | --------------------------------- | ----------------------------------------- |
| `<x-dashboard.main>`       | `components/dashboard/main`       | Layout utama dashboard (sidebar + content)|
| `<x-dashboard.aside>`      | `components/dashboard/aside`      | Sidebar navigasi                          |
| `<x-dashboard.navbar>`     | `components/dashboard/navbar`     | Top navigation bar                        |
| `<x-dashboard.footer>`     | `components/dashboard/footer`     | Footer dashboard                          |
| `<x-dashboard.brand>`      | `components/dashboard/brand`      | Logo & nama aplikasi                      |
| `<x-dashboard.card.info>`  | `components/dashboard/card/info`  | Kartu statistik (icon, title, value)      |
| `<x-dashboard.card.stat>`  | `components/dashboard/card/stat`  | Kartu statistik alternatif                |
| `<x-dashboard.card.table>` | `components/dashboard/card/table` | Wrapper tabel data dengan pagination     |

### Modal Components

| Component                     | Kegunaan                       |
| ----------------------------- | ------------------------------ |
| `<x-dashboard.modal.add>`    | Modal form tambah data         |
| `<x-dashboard.modal.edit>`   | Modal form edit data           |
| `<x-dashboard.modal.delete>` | Modal konfirmasi hapus data    |
| `<x-dashboard.modal.detail>` | Modal detail data              |

---

## Screenshot

> _Tambahkan screenshot aplikasi di sini_

---

## Lisensi

Project ini bersifat private dan dikembangkan oleh **Ichsan Hanifdeal** untuk keperluan internal.
