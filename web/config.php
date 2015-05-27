<?php

$config = [
    'db_host' => 'db',
    'db_user' => 'root',
    'db_database_name' => 'invoice',
    'db_password' => 'invoice',
    'db_port' => '3306'
];

$pages = [
    'dashboard' => [
        'icon' => 'fa-dashboard',
        'name' => 'Dashboard',
        'menu' => true
    ],
    'invoices' => [
        'icon' => 'fa-list',
        'name' => 'Invoices List',
        'menu' => true
    ],
    'invoice-add' => [
        'icon' => 'fa-file-text',
        'name' => 'Create new invoice',
        'menu' => true
    ],
    'invoice-edit' => [
        'icon' => 'fa-file-text',
        'name' => 'Edit invoice',
        'menu' => false
    ],
    'invoice-delete' => [
        'icon' => 'fa-file-text',
        'name' => 'Remove invoice',
        'menu' => false
    ],
    'user-profile' => [
        'icon' => 'fa-file-text',
        'name' => 'User profile',
        'menu' => false
    ]
];

try {
    $connection = new \PDO('mysql:host='. $config['db_host'] .';port='. $config['db_port'] .';dbname='. $config['db_database_name'], $config['db_user'], $config['db_password']);
} catch (\PDOException $exception) {
    die ('Cannot connect to database');
}

