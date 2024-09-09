<?php

namespace App\Controllers\Api\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    // Длина сгенерированного пароля
    const CHAR_COUNT = 12;

    protected function run(): Response
    {
        $user = $this->request->getParsedBody();

        // Обработка данных клиента
        //$error= $this->validated($user);

        // Если нет сообщения, то значит ошибок при валидации нет
        //if (!empty($error)) {
        //    return ResourceError::make(400, $error);
        //}

        // Генерация пароля
        $plainPassword = $this->genMod->createPassword(self::CHAR_COUNT);

        // Хеширование пароля перед сохранением в БД
        $user['password'] = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Добавление нового клиента в БД
        $this->userRepo->insertOrUpdate($user);

        // Отправка письма с паролем новому клиенту
        $this->mailMod->sendEmail([
            'email' => $user['email'],
            'password' => $plainPassword
        ]);

        // Ресурс занимается тем что собирает массив, который отдаёт в результат
        return $this->responseJson(201, ['message' => 'Пользователь добавлен!']);
    }
}