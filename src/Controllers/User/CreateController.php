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
        // План предварительной регистрации
        // 1 Поймал данные
        // 2 Обработал их, если ошибка, вернул её (статус 400)
        // 3 Сгенерироривал пароль
        // 4 1-й этап добавления со сгенерированным паролем
        // 5 Отправка на почту пароля
        // 6 Вернул статус 201

        // 1
        // request = $this->request->getParsedBody();

        // 1 (временное)
        $request = [
            'login' => "Sp2wN@",
            'email' => "yurkesson@yandex.by",
        ];

        // 2
        $error = $this->validClass->validated($request, $this->validate['rules']['signUp']);

        if ($error['error']) {
            return $this->responseJson($error, 400);
        }

        // 3 Генерация и хэширование пароля
        $password = password_hash($this->genClass->password(12), PASSWORD_DEFAULT);
        $this->dd($password);

        // 5 Отправка письма с паролем
        $this->sendEmail($request['email'], $password);

        // Отображение сообщения об успешной предварительной регистрации
        // Отправка ответа
        // должен получить это сообщение по слагу (новая таблица? id slug settinggs формат json(варчар)(key(на каком языке) значение перевод сооббщения))
        // т.е. новое обращение к БД
        $responseData = [
            'message' => "Регистрация прошла успешно. Пароль был отправлен на {$request['email']}"
        ];

        return $this->responseJson($responseData, 201);
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