<?php

return [
    'title' => 'Manajemen Absensi',
    'subtitle' => 'Pantau kehadiran, keterlambatan, dan lokasi GPS karyawan.',
    
    'stats' => [
        'present' => 'Hadir Hari Ini',
        'late' => 'Terlambat',
        'on_leave' => 'Sedang Cuti',
        'overtime' => 'Lembur',
    ],

    'table' => [
        'title' => 'Log Absensi Harian',
        'th_employee' => 'Karyawan',
        'th_shift' => 'Shift',
        'th_time_in' => 'Jam Masuk',
        'th_time_out' => 'Jam Keluar',
        'th_status' => 'Status',
        'th_location' => 'Lokasi',
        'th_action' => 'Aksi',
        'empty' => 'Tidak ada data absensi untuk tanggal ini.',
    ],

    'status' => [
        'on_time' => 'TEPAT WAKTU',
        'late' => 'TERLAMBAT',
        'overtime' => 'LEMBUR',
        'absent' => 'ALFA',
    ],

    'modal' => [
        'detail_title' => 'Detail Lokasi Absensi',
        'view_map' => 'Lihat di Peta',
        'photo_in' => 'Foto Masuk',
        'photo_out' => 'Foto Keluar',
        'coordinates' => 'Koordinat',
    ],

    'filter' => [
        'label' => 'Pilih Tanggal',
        'apply' => 'Filter Data',
    ],

    'notification' => [
        'store_success' => 'Absensi berhasil dicatat. Selamat bekerja!',
        'update_success' => 'Data absensi berhasil diperbarui.',
        'delete_success' => 'Data absensi telah dihapus.',
        'already_checked_in' => 'Anda sudah melakukan absen masuk hari ini.',
        'out_of_range' => 'Anda berada di luar radius lokasi yang diizinkan!',
    ],
];