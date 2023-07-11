<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class CreateController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function run(): Response
    {
        // 1
        // request = $this->request->getParsedBody();
        $request = [
            'login' => "Sp2wN45",
            'email' => "yurkesson45@yandex.by",
        ];

        // 2
        $error = $this->validClass->validated($request, $this->validate['rules']['signUp']);

        if (!$error['error']) {

            // 3 Генерация пароля
            //$passwordSend = $this->genClass->password(12);
            $passwordSend = "123";

            $this->userRepo->insertOrUpdate($request);
            $this->dd('--------------------');

            // 5 Отправка письма с паролем
            $send = $this->mailClass->sendEmail($request['email'],
                [
                    'login' => $request['login'],
                    'pwdSend' => $passwordSend
                ]);

            $this->dd($send);

            return $this->responseJson([
                'message' => "Регистрация прошла успешно. Пароль был отправлен на {$request['email']}"
            ], 201);
        }
        return $this->responseJson($error, 400);
    }
}