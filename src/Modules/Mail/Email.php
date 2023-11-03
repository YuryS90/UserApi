<?php

namespace App\Modules\Mail;

use App\Modules\Main\Module;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email extends Module
{
    private ?PHPMailer $mailer = null;
    private array $templatesCache = [];

    /** Настройки SMTP */
    private function configSMTP(): void
    {
        // Для избежания создания экземпляра при каждом создании объекта Email
        if ($this->mailer === null) {

            // true - при ошибки, будет выброшено исключение PHPMailer\Exception
            $this->mailer = new PHPMailer(true);
        }

        // Метод указывает, что используется SMTP-сервер для отправки писем
        $this->mailer->isSMTP();

        // Адрес и порт SMTP-сервера
        $this->mailer->Host = $this->config['host'] ?? '';
        $this->mailer->Port = intval($this->config['port'] ?? 0);

        // Протокол шифрования SSL/TLS (тип безопасного соединения)
        $this->mailer->SMTPSecure = $this->config['secure'] ?? '';

        // Параметры аутентификации, которые используются для авторизации на SMTP-сервере
        if (!empty($this->config['name']) && !empty($this->config['password'])) {
            // true - определяет, требуется ли аутентификация для подключения
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $this->config['name'];
            $this->mailer->Password = $this->config['password'];
        }

        // Отображение сообщения об ошибках на русском
        $this->mailer->setLanguage('ru');
    }

    /** Настройка отправки письма */
    private function configSending(): void
    {
        // Чтобы почта приходила без иероглифов
        $this->mailer->CharSet = $this->config['charset'] ?? 'UTF-8';

        // Тема сообщения
        $this->mailer->Subject = $this->config['subject'] ?? '';

        // Установка HTML-шаблона в тело письма
        $this->mailer->isHTML(true);
    }

    /**
     * Отправка на почту
     * @throws Exception
     */
    public function sendEmail($data): void
    {
        try {
            $this->configSMTP();

            // Отправитель и получатель
            if (!empty($this->config['fromAddress'])) {
                $this->mailer->setFrom($this->config['fromAddress'], 'User API');
                $this->mailer->addAddress($data['email']);
            }
            $this->configSending();

            $this->mailer->Body = $this->renderTemplate($data);

            // Отправка письма
            $this->mailer->send();

        } catch (Exception $e) {
            throw new Exception($this->mailer->ErrorInfo);
        }
    }

    /** Получение HTML-шаблона для письма из локального кэша или файла */
    private function renderTemplate(array $data): string
    {
        $templatePath = __DIR__ . '/template/email.html';

        // Если шаблон не кэширован в свойстве $templatesCache
        if (!isset($this->templatesCache[$templatePath])) {

            // Если файл найден, то чтение HTML-шаблона и сохранение в $html
            $html = file_exists($templatePath) ? file_get_contents($templatePath) : '';

            // Сохраняем HTML в кэш
            $this->templatesCache[$templatePath] = $html;
        }

        // Замена переменных в шаблоне
        return str_replace(
            ['{{login}}', '{{pwd}}'], [$data['login'], $data['pwd']], $this->templatesCache[$templatePath]
        );
    }
}