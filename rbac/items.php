<?php
return [
    'createNotification' => [
        'type' => 2,
        'description' => 'Create notification',
    ],
    'createArticle' => [
        'type' => 2,
        'description' => 'Create article',
    ],
    'viewArticle' => [
        'type' => 2,
        'description' => 'View article',
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'createNotification',
            'createArticle',
            'viewArticle',
        ],
    ],
    'user' => [
        'type' => 1,
        'children' => [
            'viewArticle',
        ],
    ],
];
