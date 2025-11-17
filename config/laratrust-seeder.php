<?php

return [
    'sidebars' => [
        [
            'title' => 'Calendar',
            'permissions' => 'c,r,u,d',
        ],
        [
            'title' => 'Event',
            'permissions' => 'c,r,u,d,approve,reject',
        ],
        [
            'title' => 'Companies',
            'permissions' => 'c,r,u,d',
        ],
        [
            'title' => 'Event Category',
            'permissions' => 'c,r,u,d',
        ],
        [
            'title' => 'Settings',
            'child' => [
                [
                    'title' => 'User Management',
                    'permissions' => 'r,u,d,approve,reject',
                ],
            ],
        ],
    ],
    'roles' => [
        [
            'role' => 'Administrator',
        ]
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'approve' => 'approve',
        'reject' => 'reject',
    ]
];
