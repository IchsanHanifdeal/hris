<?php

return [
    'title' => 'Work Schedules',
    'subtitle' => 'Monitor employee working hours and shift assignments.',
    'stats' => [
        'total' => 'Total Schedules (Range)',
        'active_shift' => 'Active Shifts',
    ],
    'filter' => [
        'title' => 'Filter Date Range',
        'apply' => 'Apply Filter',
        'start' => 'Start Date',
        'end' => 'End Date',
    ],
    'table' => [
        'title' => 'Duty Roster',
        'th_date' => 'Date',
        'th_employee' => 'Employee',
        'th_shift' => 'Shift Name',
        'th_time' => 'Time Range',
        'th_action' => 'Action',
        'empty' => 'No schedules found for this period.',
    ],
    'modal' => [
        'delete_title' => 'Delete Schedule',
        'delete_confirm' => 'Are you sure you want to delete the duty schedule for :name?',
    ],
];
