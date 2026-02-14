.
├── README.md
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── AttendancesController.php
│   │   │   ├── Auth
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── ConfirmablePasswordController.php
│   │   │   │   ├── EmailVerificationNotificationController.php
│   │   │   │   ├── EmailVerificationPromptController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   ├── Controller.php
│   │   │   ├── DepartmentController.php
│   │   │   ├── EmployeeController.php
│   │   │   ├── LeaveTypeController.php
│   │   │   ├── LocalizationController.php
│   │   │   ├── PayrollController.php
│   │   │   ├── PositionController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── SchedulesController.php
│   │   │   └── ShiftController.php
│   │   ├── Middleware
│   │   │   └── SetLocale.php
│   │   └── Requests
│   │       ├── Auth
│   │       │   └── LoginRequest.php
│   │       ├── PositionRequest.php
│   │       ├── ProfileUpdateRequest.php
│   │       └── StoreDepartmentRequest.php
│   ├── Models
│   │   ├── Attendances.php
│   │   ├── Department.php
│   │   ├── Employee.php
│   │   ├── LeaveRequest.php
│   │   ├── LeaveType.php
│   │   ├── Payroll.php
│   │   ├── Position.php
│   │   ├── Schedules.php
│   │   ├── Shift.php
│   │   └── User.php
│   ├── Providers
│   │   └── AppServiceProvider.php
│   ├── Services
│   │   ├── DepartmentService.php
│   │   └── PositionService.php
│   └── View
│       └── Components
│           ├── AppLayout.php
│           └── GuestLayout.php
├── artisan
├── bootstrap
│   ├── app.php
│   ├── cache
│   │   ├── packages.php
│   │   └── services.php
│   └── providers.php
├── composer.json
├── composer.lock
├── config
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── permission.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database
│   ├── factories
│   │   └── UserFactory.php
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_02_13_181023_create_shifts_table.php
│   │   ├── 2026_02_13_181113_create_attendances_table.php
│   │   ├── 2026_02_13_181329_create_payrolls_table.php
│   │   └── 2026_02_13_181654_create_permission_tables.php
│   └── seeders
│       ├── DatabaseSeeder.php
│       ├── RolePermissionSeeder.php
│       └── UserSeeder.php
├── lang
│   ├── en
│   │   ├── actions.php
│   │   ├── auth.php
│   │   ├── dashboard.php
│   │   ├── department.php
│   │   ├── employee.php
│   │   ├── http-statuses.php
│   │   ├── leave-type.php
│   │   ├── login.php
│   │   ├── menu.php
│   │   ├── pagination.php
│   │   ├── passwords.php
│   │   ├── position.php
│   │   ├── profile.php
│   │   ├── seo.php
│   │   ├── shift.php
│   │   └── validation.php
│   ├── en.json
│   ├── id
│   │   ├── actions.php
│   │   ├── auth.php
│   │   ├── dashboard.php
│   │   ├── department.php
│   │   ├── employee.php
│   │   ├── http-statuses.php
│   │   ├── leave-type.php
│   │   ├── login.php
│   │   ├── menu.php
│   │   ├── pagination.php
│   │   ├── passwords.php
│   │   ├── position.php
│   │   ├── profile.php
│   │   ├── pwa.php
│   │   ├── seo.php
│   │   ├── shift.php
│   │   └── validation.php
│   └── id.json
├── package-lock.json
├── package.json
├── phpunit.xml
├── public
│   ├── build
│   │   ├── assets
│   │   │   ├── app-ByF9ZGEq.css
│   │   │   └── app-CBbTb_k3.js
│   │   └── manifest.json
│   ├── favicon.ico
│   ├── hot
│   ├── index.php
│   └── robots.txt
├── resources
│   ├── css
│   │   └── app.css
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views
│       ├── auth
│       │   ├── confirm-password.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── reset-password.blade.php
│       │   └── verify-email.blade.php
│       ├── components
│       │   ├── application-logo.blade.php
│       │   ├── auth-session-status.blade.php
│       │   ├── danger-button.blade.php
│       │   ├── dashboard
│       │   │   ├── aside.blade.php
│       │   │   ├── brand.blade.php
│       │   │   ├── card
│       │   │   │   ├── info.blade.php
│       │   │   │   └── table.blade.php
│       │   │   ├── footer.blade.php
│       │   │   ├── main.blade.php
│       │   │   ├── modal
│       │   │   │   ├── add.blade.php
│       │   │   │   ├── delete.blade.php
│       │   │   │   └── edit.blade.php
│       │   │   └── navbar.blade.php
│       │   ├── dropdown-link.blade.php
│       │   ├── dropdown.blade.php
│       │   ├── input-error.blade.php
│       │   ├── input-label.blade.php
│       │   ├── main
│       │   │   ├── brands.blade.php
│       │   │   ├── footer.blade.php
│       │   │   ├── head.blade.php
│       │   │   └── main.blade.php
│       │   ├── modal.blade.php
│       │   ├── nav-link.blade.php
│       │   ├── primary-button.blade.php
│       │   ├── pwa
│       │   │   ├── bottom-nav.blade.php
│       │   │   ├── main.blade.php
│       │   │   └── top-bar.blade.php
│       │   ├── responsive-nav-link.blade.php
│       │   ├── secondary-button.blade.php
│       │   └── text-input.blade.php
│       ├── dashboard
│       │   ├── attendace.blade.php
│       │   ├── department.blade.php
│       │   ├── index.blade.php
│       │   ├── jadwal-kerja.blade.php
│       │   ├── karyawan.blade.php
│       │   ├── leave-type.blade.php
│       │   ├── leave.blade.php
│       │   ├── payroll.blade.php
│       │   ├── positions.blade.php
│       │   └── shift.blade.php
│       ├── dashboard.blade.php
│       ├── layouts
│       │   ├── app.blade.php
│       │   ├── guest.blade.php
│       │   └── navigation.blade.php
│       ├── profile
│       │   ├── edit.blade.php
│       │   └── partials
│       │       ├── delete-user-form.blade.php
│       │       ├── update-password-form.blade.php
│       │       └── update-profile-information-form.blade.php
│       ├── pwa
│       │   └── dashboard.blade.php
│       └── welcome.blade.php
├── routes
│   ├── auth.php
│   ├── console.php
│   └── web.php
├── struktur_folder.md
├── tests
│   ├── Feature
│   │   ├── Auth
│   │   │   ├── AuthenticationTest.php
│   │   │   ├── EmailVerificationTest.php
│   │   │   ├── PasswordConfirmationTest.php
│   │   │   ├── PasswordResetTest.php
│   │   │   ├── PasswordUpdateTest.php
│   │   │   └── RegistrationTest.php
│   │   ├── ExampleTest.php
│   │   └── ProfileTest.php
│   ├── Pest.php
│   ├── TestCase.php
│   └── Unit
│       └── ExampleTest.php
└── vite.config.js

47 directories, 190 files
