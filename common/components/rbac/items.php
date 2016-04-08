<?php
return [
    'event' => [
        'type' => 2,
        'description' => 'EVENT',
    ],
    'superAdmin' => [
        'type' => 1,
        'description' => 'super admin',
        'ruleName' => 'userRole',
        'children' => [
            'admin',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'AdminEvent',
        'ruleName' => 'userRole',
    ],
];
