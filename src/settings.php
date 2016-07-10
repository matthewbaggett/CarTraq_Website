<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        // Database settings
        'database' => [
            'technology' => 'Mysql',
            'hostname'     => 'sql.thru.io',
            'port'     => '3306',
            'username' => 'cartraq',
            'password' => '551i10dh3UU031e',
            'database' => 'cartraq',
        ],
    ],
];
