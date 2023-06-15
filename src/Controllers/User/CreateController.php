<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Http\Message\ResponseInterface as Response;

class CreateController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function run(): Response
    {
        // 1 Поймал данные
        // 2 Обработал их, если ошибка, вернул её (статус 400)
        // 3 Сгенерироривал пароль
        // 4 1-й этап добавления со сгенерированным паролем
        // 5 Отправка на почту пароля
        // 6 Вернул статус 201


        // добавить пользователя в базу данных после генерации пароля и перед отправкой письма
        // request = $this->request->getParsedBody();

        // 1
        $request = [
            'login' => "Sp2wN",
            'email' => "yurkesson@yandex.by",
        ];


        // Правила валидации
        // TODO: Вынести в файл конфига validateconfig.php
        // про крон, воркер
        $rules = [
            'reg' => [
                'login' => 'required|string|login|min:5|max:50|unique:users,login',
                'email' => 'required|string|email|min:5|max:255|unique:users,email',
            ]
        ];

        // 2
        $error = $this->valid->validated($request, $rules);

        if ($error['error']) {
            $this->response->getBody()->write(json_encode($error, JSON_UNESCAPED_UNICODE));

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }

        // 3 Генерация пароля
        $password = $this->generatePassword(12);
        $this->dd(password_hash($password, PASSWORD_DEFAULT));

        // password_hash()

        // 5 Отправка письма с паролем
        $this->sendEmail($request['email'], $password);

        // Отображение сообщения об успешной предварительной регистрации
        // Отправка ответа
        // должен получить это сообщение по слагу (новая таблица? id slug settinggs формат json(варчар)(key(на каком языке) значение перевод сооббщения))
        // т.е. новое обращение к БД
        $responseData = [
            'message' => "Регистрация прошла успешно. Пароль был отправлен на {$request['email']}"
        ];

        $this->response->getBody()->write(json_encode($responseData, JSON_UNESCAPED_UNICODE));



        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }


    /**
     * @throws \Exception
     */
    private function generatePassword(int $length = 10): string
    {
        // в конфиг поместить
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!#$%^&*()-_=+';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $password;
    }

    private function sendEmail($email, $password)
    {
        $mail = new PHPMailer(true);

        try {
            // Настройки SMTP
            // Метод указывает, что используется SMTP-сервер для отправки писем
            $mail->isSMTP();

            // Адрес и порт SMTP-сервера
            $mail->Host = 'smtp.mail.ru';
            $mail->Port = 465;

            // Протокол шифрования SSL/TLS (тип безопасного соединения)
            $mail->SMTPSecure = 'ssl';

            // Параметры аутентификации, которые используются для авторизации на SMTP-сервере.
            // true - определяет, требуется ли аутентификация для подключения
            $mail->SMTPAuth = true;
            $mail->Username = 'projectyury@mail.ru';
            $mail->Password = 'TA8dP7YQgm2MXRFSxncP';

            // Чтобы почта приходила без иероглифов
            $mail->CharSet = "UTF-8";

            // Отправитель и получатель
            $mail->setFrom('projectyury@mail.ru', 'User API');
            $mail->addAddress($email);

            // Тема и содержимое письма
            $mail->Subject = 'Ваш пароль для MyApp';
            $mail->Body = 'Ваш новый пароль: ' . $password;

            // Отправка письма
            $mail->send();

        } catch (\Exception $e) {
            die(json_encode("При отправке письма произошла ошибка: {$mail->ErrorInfo}", JSON_UNESCAPED_UNICODE));
        }
    }
}