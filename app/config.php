<?php
declare(strict_types=1);

// Сохранение параметров в $_ENV
(\Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

return [
    'messages' => [
        'exception' => [
            '400' => '400 Bad Request. Сервер не может обрабатывать запрос из-за ошибки клиента.',
            '403' => '403 Forbidden. Ограничение или отсутствие доступа к материалу на странице, которую вы пытаетесь загрузить.',
            '404' => '404 Not Found. Запрашиваемый ресурс не найден. Пожалуйста, проверьте URI и повторите попытку.',
            '500' => '500 Exception. Внутренняя ошибка сервера.',
            '520' => '520 Unknown Error. Неизвестная ошибка.',
        ],
//            'success' => [
//                'register' => 'Предварительная регистрация прошла успешно. ' .
//                    'Пароль был отправлен на Вашу почту. Авторизуйтесь для окончательной регистрации',
//                'auth' => 'Вы авторизовались!',
//                'profile' => 'Доступ разрешен. Добро пожаловать user!'
//            ],

        'auth' => [
            'unauth' => 'Ошибка авторизации. Попробуйте ещё раз!',
        ],
    ],

    'jwt' => [
        'secret' => $_ENV['JWT_SECRET'],
    ],

    'generate' => [
        'password' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!#$%^&()-_=+'
    ],

    'settings' => [
        'email' => [
            'host' => $_ENV['MAIL_HOST'],
            'port' => $_ENV['MAIL_PORT'],
            'secure' => $_ENV['MAIL_ENCRYPTION'],
            'name' => $_ENV['MAIL_USERNAME'],
            'password' => $_ENV['MAIL_PASSWORD'],
            'fromAddress' => $_ENV['MAIL_FROM_ADDRESS'],
            'charset' => 'UTF-8',
            'subject' => 'Пароль для авторизации',
        ]
    ],

    'paths' => [
        'log' => [
            'error' => __DIR__ . '/../src/Modules/Log/storage/error.log',
            'success' => __DIR__ . '/../src/Modules/Log/storage/success.log',
        ],
        'cache' => dirname(__DIR__) . '/tmp/cache',
        'img' => dirname(__DIR__) . '/public/images/',
    ]
];