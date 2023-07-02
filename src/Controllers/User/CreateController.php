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
            'login' => "Sp2wN",
            'email' => "yurkesson@yandex.by",
        ];

        // 2
        $error = $this->validClass->validated($request, $this->validate['rules']['signUp']);

        if (!$error['error']) {

            // 3 Генерация пароля
            //$passwordSend = $this->genClass->password(12);
            $passwordSend = "123";

            //$data = require 'app/payload.php';
            //$this->dd($data['createUser']);

            // 4
            $payload = [
                'login' => $request['login'],
                'email' => $request['email'],
                'pwd' => password_hash($passwordSend, PASSWORD_DEFAULT),
                'roles_id' => 3
            ];

            //$this->userRepo->insertOrUpdate($payload);

            // 5 Отправка письма с паролем
            $send = $this->mailClass->sendEmail($request['email'], [
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