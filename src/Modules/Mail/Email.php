<?php

namespace App\Modules\Mail;

use App\Common\HelperTrait;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

class Email
{
    use HelperTrait;

    private ?PHPMailer $mailer = null;
    private array $config;
    private array $templatesCache = [];

    public function __construct(array $config = [])
    {
        // Для избежания создания экземпляра при каждом создании объекта Email
        if ($this->mailer === null) {
            // true - при ошибки, будет выброшено исключение PHPMailer\Exception
            $this->mailer = new PHPMailer(true);
        }

        $this->config = $config;
    }

    /**
     * Настройки SMTP
     * @return void
     */
    private function configSMTP(): void
    {
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

        // Cообщения об ошибках
        $this->mailer->setLanguage('ru');
    }

    /**
     * Настройка отправки письма
     * @return void
     */
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
     * @throws Exception
     */
    public function sendEmail(string $email, array $data): array
    {
        //try {
            $this->configSMTP();

            // Отправитель и получатель
            if (!empty($this->config['fromAddress'])) {

                $this->mailer->setFrom($this->config['fromAddress'], 'User API');
                $this->mailer->addAddress($email);

            }

            $this->configSending();

            $this->mailer->Body = $this->renderTemplate($data);

            // Отправка письма
            if (!$this->mailer->send()) {
                die(json_encode("При отправке письма произошла ошибка: {$this->mailer->ErrorInfo}", JSON_UNESCAPED_UNICODE));                //die(json_encode("При отправке письма произошла ошибка: {$this->mailer->ErrorInfo}", JSON_UNESCAPED_UNICODE));

            }

        //} catch (Exception $e) {
            return [
                'error' => true,
                'message' => "Ошибка при отправке... {$this->mailer->ErrorInfo}",
                //'error_code' => $e->getCode()
            ];
        //}

        //return [
        //    'error' => true,
        //    'message' => "При отправке письма произошла ошибка: {$this->mailer->ErrorInfo} $e->getCode(), {$e}"
        //];

        die(json_encode("123При отправке письма произошла ошибка: {$this->mailer->ErrorInfo}", JSON_UNESCAPED_UNICODE));                //die(json_encode("При отправке письма произошла ошибка: {$this->mailer->ErrorInfo}", JSON_UNESCAPED_UNICODE));

    }

    /**
     * Получение HTML-шаблона для письма из локального кэша или файла
     * @param array $data
     * @return string
     */
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
        return str_replace(['{{login}}', '{{pwdSend}}'], [$data['login'], $data['pwdSend']], $this->templatesCache[$templatePath]);
    }
}