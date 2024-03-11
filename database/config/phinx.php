<?php
declare(strict_types=1);

// Сохранение параметров в $_ENV
(\Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2)))->load();

return [
    'paths_phinx' => [
        'migrations' => __DIR__ . '/../migrations',
        'seeds' => __DIR__ . '/../seeds'
    ],

    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'dev',

        'dev' => [
            'adapter' => $_ENV['DB_CONNECTION'],
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ],

    ],

    'version_order' => 'creation'
];