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
        ],
        'destroy' => [
            'title' => env('JOBS_DESTROY_TITLE'),
        ],
        'apply' => [
            'title' => env('JOBS_APPLY_TITLE'),
        ],
    ],
    'contact' => [
        'title' => env('CONTACT_TITLE'),
        'description' => env('CONTACT_DESCRIPTION'),
    ],
];
