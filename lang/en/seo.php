<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | SEO & Meta Tags Language Lines
    |--------------------------------------------------------------------------
    |
    | These lines are used for meta tags, open graph, and page titles.
    | Remember, image URLs are set in Blade using asset(), not here.
    |
    */

    'app_name' => 'HRIS Management',

    'default_title' => 'HRIS Management | Modern HRIS & Payroll Platform',
    'tagline'       => 'Integrated Employee Management Solution',
    'author'        => 'Kelola SDM Engineering Team',

    'description'   => 'All-in-one HRIS platform for streamlining company operations. Features include GPS Attendance (Leaflet), Automated Payroll, Shift Management, and Employee Performance Appraisal.',
    'keywords'      => 'HRIS Indonesia, GPS Attendance App, Payroll System, HR Management, Online Pay Slip, Employee Self Service, HR Software, Laravel HRIS',

    'og_title'       => 'Kelola SDM - HR Efficiency at Your Fingertips',
    'og_description' => 'Leave manual processes behind. Manage attendance, leave, and employee payroll in real-time, accurately, and with GPS-based location tracking.',
    'og_locale'      => 'en_US',
    'og_site_name'   => 'Kelola SDM Enterprise',

    'twitter_title'       => 'Kelola SDM - Modern GPS-Based HRIS',
    'twitter_description' => 'Track team attendance and manage payroll effortlessly. Try our modern HRIS application demo now.',

    'pages' => [
        'login'           => 'Sign In',
        'dashboard'       => 'Main Dashboard',
        'attendance_log'  => 'Attendance & Location History',
        'approvals'       => 'Leave & Permit Approvals',
        'profile'         => 'Employee Profile: :name',
        'payroll_slip'    => 'Pay Slip for Period :period',
        'recruitment'     => 'Job Vacancy Portal',
    ],

    'status' => [
        '404' => 'Page Not Found - 404',
        '403' => 'Access Denied - 403',
        '500' => 'Internal Server Error - 500',
    ],
];
