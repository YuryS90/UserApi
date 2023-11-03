<?php

namespace App\resources;

use Slim\Psr7\Response;

class ResourceError extends AbstractResource implements ResourceInterface
{
    public static function make(int $status, array $data): Response
    {
        $payload = [
            'success' => false,
            'message' => self::getMessage($data['msg']) ? self::getMessage($data['msg']) : $data['msg']
        ];

        // TODO
        //      В respond реализовать логирование. Дополнительно передавать this с модуля и всё остальное

        return self::respond($status, $payload);
    }

    private static function getMessage(string $type): string
    {
        $messages = self::messages();
        return $messages[$type] ?? '';
    }

    public static function messages(): array
    {
        return [
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

            'password.required' => 'Заполните поле password!',
            'password.string' => 'Пароль должен соответствовать строчному типу!',
            'password.password' => 'Пароль содержит недопустимые символы!',
            'password.size' => 'Пароль должен содержать 12 символов!',
            'password.verify' => 'Пароль не прошёл верификацию!',

            // Это внутренние (для меня) сообщения
            //'empty' => 'Недостаточно данных для валидации!',
            //'table' => 'Такой таблицы нет!',
            //'method' => 'Метод для rule не создан!',

            'unauth' => 'Ошибка авторизации. Попробуйте ещё раз!',

        ];
    }


}