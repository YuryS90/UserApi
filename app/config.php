<?php
declare(strict_types=1);

// Сохранение параметров в $_ENV
(\Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

return [

    'messages' => [
        'validate' => [
            'login.required' => 'Заполните поле логин!',
            'login.string' => 'Логин должен соответствовать строчному типу!',
            'login.login' => 'Логин должен содержать только кириллические буквы, латинские буквы, цифры и знаки подчеркивания',
            'login.min' => 'Логин слишком короткий: минимум 5 символов!',
            'login.max' => 'Логин слишком длинный: максимум 10 символов!',
            'login.unique' => 'Пользователь с таким логином уже существует!',

            'email.required' => 'Заполните поле email!',
            'email.string' => 'Email должен соответствовать строчному типу!',
            'email.email' => 'Email должен соответствовать формату mail@some.com',
            'email.min' => 'Email слишком короткое: минимум 5 символов!',
            'email.max' => 'Email слишком длинное: максимум 10 символов!',
            'email.unique' => 'Пользователь с таким email уже существует!',

            'empty' => 'Недостаточно данных для валидации!',
            'table' => 'Такой таблицы нет!',
            'method' => 'Метод для rule не создан!',
        ],
        'errors' => [
            '400' => '400 Bad Request. Сервер не может обрабатывать запрос из-за очевидной ошибки клиента.',
            '403' => '403 Forbidden. Ограничение или отсутствие доступа к материалу на странице, которую вы пытаетесь загрузить.',
            '404' => '404 Not Found. Запрашиваемый ресурс не найден. Пожалуйста, проверьте URI и повторите попытку.',
            '500' => '500 Exception. Внутренняя ошибка сервера.',
            '520' => '520 Unknown Error. Неизвестная ошибка.',
        ],
        'success' => [
            'register' => 'Предварительная регистрация прошла успешно. ' .
                'Пароль был отправлен на Вашу почту. Авторизуйтесь для окончательной регистрации',
        ],
        'email' => [],
    ],

    'validate' => [
        'rules' => [
            'signUp' => [
                'login' => 'required|string|login|min:5|max:50|unique:users,login',
                'email' => 'required|string|email|min:5|max:255|unique:users,email',
            ],
        ],
    ],

    'generate' => [
        'password' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!#$%^&*()-_=+'
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
        ]
    ]
];