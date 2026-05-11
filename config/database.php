<?php

return [
    'driver' => 'sqlite',
    'sqlite' => [
        'path' => __DIR__ . '/../storage/database/database.sqlite'
    ],
    'mysql' => [
        'host' => 'localhost',
        'database' => 'pastebin',
        'username' => 'root',
        'password' => ''
    ]
];
