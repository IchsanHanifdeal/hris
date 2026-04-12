<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | SEO & Meta Tags Language Lines
    |--------------------------------------------------------------------------
    |
    | Baris ini digunakan untuk meta tags, open graph, dan judul halaman.
    | Jangan lupa, image URL diatur di Blade pake asset(), bukan disini.
    |
    */

    'app_name' => 'HRIS Kelola SDM',
    
    'default_title' => 'Kelola SDM | Platform HRIS & Payroll Modern',
    'tagline'       => 'Solusi Manajemen Karyawan Terintegrasi',
    'author'        => 'Tim Engineering Kelola SDM',

    'description'   => 'Platform HRIS all-in-one untuk efisiensi operasional perusahaan. Fitur mencakup Absensi GPS (Leaflet), Penggajian (Payroll) Otomatis, Manajemen Shift, dan Penilaian Kinerja Karyawan.',
    'keywords'      => 'HRIS Indonesia, Aplikasi Absensi GPS, Payroll System, Manajemen SDM, Slip Gaji Online, Employee Self Service, HR Software, Laravel HRIS',

    'og_title'       => 'Kelola SDM - Efisiensi HR dalam Satu Genggaman',
    'og_description' => 'Tinggalkan cara manual. Kelola absensi, cuti, dan gaji karyawan secara real-time, akurat, dan berbasis lokasi (GPS).',
    'og_locale'      => 'id_ID',
    'og_site_name'   => 'Kelola SDM Enterprise',
    'loading'        => 'Memuat...',
    'please_wait'    => 'Mohon tunggu...',

    'twitter_title'       => 'Kelola SDM - HRIS Modern Berbasis GPS',
    'twitter_description' => 'Pantau kehadiran tim dan kelola gaji tanpa ribet. Coba demo aplikasi HRIS modern sekarang.',

    'pages' => [
        'login'           => 'Masuk ke Sistem',
        'dashboard'       => 'Dashboard Utama',
        'attendance_log'  => 'Riwayat Absensi & Lokasi',
        'approvals'       => 'Persetujuan Izin & Cuti',
        'profile'         => 'Profil Karyawan: :name',
        'payroll_slip'    => 'Slip Gaji Periode :period',
        'recruitment'     => 'Portal Lowongan Kerja',
    ],

    'status' => [
        '404' => 'Halaman Tidak Ditemukan - 404',
        '403' => 'Akses Ditolak - 403',
        '500' => 'Terjadi Kesalahan Server - 500',
    ],
];