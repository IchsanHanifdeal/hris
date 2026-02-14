<?php

return [
    'title' => 'Leave Request Queue',
    'subtitle' => 'Manage and review employee leave requests efficiently.',
    'stats' => [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'total_types' => 'Leave Types',
    ],
    'table' => [
        'employee' => 'Employee',
        'type' => 'Type',
        'duration' => 'Duration',
        'reason' => 'Reason',
        'status' => 'Status',
        'action' => 'Action',
        'empty' => 'Queue is Empty.',
    ],
    'modal' => [
        'reject_title' => 'Reject Request',
        'reject_note' => 'Rejection Note (Required)',
        'reject_placeholder' => 'Provide a reason for rejecting this request...',
        'btn_cancel' => 'Cancel',
        'btn_confirm' => 'Confirm Rejection',
    ],
];
