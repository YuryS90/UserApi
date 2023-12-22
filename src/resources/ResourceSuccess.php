<?php

namespace App\resources;

use Slim\Psr7\Response;

class ResourceSuccess extends AbstractResource implements ResourceInterface
{
    /** Сборка данных в нужный формат для ответа */
    public static function make(int $status, string $message): Response
    {
        $payload = [
            'success' => true,
            'message' => $message
        ];

       //if ($data['token']) {
       //    $payload['token'] = $data['token'];
       //}

        //if ($data['data']) {
        //    $payload['data'] = $data['data'];
        //}
        return self::respond($status, $payload);
    }

//    private static function getMessage(string $type): string
//    {
//        $messages = self::messages();
//        return $messages[$type] ?? '';
//    }
//
//    public static function messages(): array
//    {
//        return [
//            'register' => 'Предварительная регистрация прошла успешно. ' .
//                'Пароль был отправлен на Вашу почту. Авторизуйтесь для окончательной регистрации',
//            'auth' => 'Вы авторизовались!',
//            'profile' => 'Доступ разрешен. Добро пожаловать user!'
//        ];
//    }
}