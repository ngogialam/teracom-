<?php

return [
    'url' => [
        'domain' => env('ACCOUNT_SERVICE_URL'),
        'department' => [
            'list' => env('ACCOUNT_SERVICE_DEPARTMENT_LIST_URL'),
            'activate' => env('ACCOUNT_SERVICE_DEPARTMENT_ACTIVATE_URL'),
            'deactivate' => env('ACCOUNT_SERVICE_DEPARTMENT_DEACTIVATE_URL'),
        ],
        'role' => env('ACCOUNT_SERVICE_ROLE_URL'),
        'user' => [
            'full' => env('ACCOUNT_SERVICE_USER_FULL_INFO_LIST_URL'),
            'paging' => env('ACCOUNT_SERVICE_USER_PAGING_URL'),
            'info'   => env('ACCOUNT_SERVICE_USER_INFO_URL'),
            'list'   => env('ACCOUNT_SERVICE_USER_LIST_URL'),
            'update' => env('ACCOUNT_SERVICE_USER_UPDATE_URL'),
        ],
        'group' => [
            'paging' => env('ACCOUNT_SERVICE_GROUP_PAGING_URL'),
            'store' => env('ACCOUNT_SERVICE_GROUP_STORE_URL'),
            'update' => env('ACCOUNT_SERVICE_GROUP_UPDATE_URL'),
            'delete' => env('ACCOUNT_SERVICE_GROUP_DELETE_URL'),
            'list' => env('ACCOUNT_SERVICE_GROUP_LIST_URL')
        ],
        'permission' => [
            'list' => env('ACCOUNT_SERVICE_PERMISSION_LIST_URL'),
            'store' => env('ACCOUNT_SERVICE_PERMISSION_STORE_URL'),
            'update' => env('ACCOUNT_SERVICE_PERMISSION_UPDATE_URL'),
            'delete' => env('ACCOUNT_SERVICE_PERMISSION_DELETE_URL')
        ],
        'generate-token' => env('ACCOUNT_SERVICE_GENERATE_TOKEN_URL')
    ],
    'email' => env('ACCOUNT_SERVICE_EMAIL'),
    'api_key' => env('ACCOUNT_SERVICE_API_KEY'),
];
