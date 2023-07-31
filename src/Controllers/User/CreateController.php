<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class CreateController extends AbstractController
{
    const SLUG_MSG = 'register';
    const CHAR_COUNT = 12;

    /**
     * @throws \Exception
     */
    public function run(): Response
    {
        // Получение данных клиента
        // request = $this->request->getParsedBody();
        $request = ['login' => "Sp2wN499", 'email' => "sviridenkoanzela8@gmail.com",]; // Для отладки

        // Обработка данных клиента
        $message = $this->validMod->validated($request, $this->validate['rules']['signUp'] ?? '');

        // Если нет сообщения, то значит ошибок при валидации нет
        if (empty($message)) {
            // Генерация пароля
            $request['pwd'] = $this->genMod->password(self::CHAR_COUNT);

            // Добавление нового клиента в БД
            $this->userRepo->insertOrUpdate($request);

            // Отправка письма с паролем новому клиенту
            $this->mailMod->sendEmail($request);

            return $this->respondSuccess(201, self::SLUG_MSG, $request);
        }
        return $this->respondError(400, $message);
    }
}