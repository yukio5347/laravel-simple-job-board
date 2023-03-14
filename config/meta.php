<?php

return [
    'home' => [
        'title' => env('HOME_TITLE'),
        'description' => env('HOME_DESCRIPTION'),
    ],

    'jobs' => [
        'index' => [
            'title' => env('JOBS_INDEX_TITLE'),
            'description' => env('JOBS_INDEX_DESCRIPTION'),
        ],
        'create' => [
            'title' => env('JOBS_CREATE_TITLE'),
            'description' => env('JOBS_CREATE_DESCRIPTION'),
        ],
        'show' => [
            'title' => env('JOBS_SHOW_TITLE'),
            'description' => env('JOBS_SHOW_DESCRIPTION'),
        ],
        'edit' => [
            'title' => env('JOBS_EDIT_TITLE'),
            'description' => env('JOBS_EDIT_DESCRIPTION'),
        ],
        'destroy.confirm' => [
            'title' => env('JOBS_DESTROY_CONFIRM_TITLE'),
            'description' => env('JOBS_DESTROY_CONFIRM_DESCRIPTION'),
        ],
        'apply' => [
            'title' => env('JOBS_APPLY_TITLE'),
            'description' => env('JOBS_APPLY_DESCRIPTION'),
        ],
    ],
    'contact' => [
        'title' => env('CONTACT_TITLE'),
        'description' => env('CONTACT_DESCRIPTION'),
    ],
];
