<?php

namespace App\Common;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Message;
use Slim\Psr7\Response;

trait ServiceTrait
{
    use HelperTrait;

    /**
     * @return object|ResponseInterface|Message|Response
     */
    public function respondError(int $status, string $message)
    {
        return $this->responseJson($status, $this->getResponse(false, $message));
    }

    /**
     * @return ResponseInterface|Message|Response
     */
    public function respondException(int $status, object $e)
    {
        // Получаем из config сообщение по статусу
        $message = $this->getMessage('errors', $status);

        // Регистрируем лог
        $this->log([
            'place' => get_class($this),
            'message' => $message,
            'exception' => $e
        ], true);

        return $this->responseJson($status, $this->getResponse(false, $message));
    }

    /**
     * @return object|ResponseInterface|Message|Response
     */
    public function respondSuccess(int $status, string $slug, array $data = [])
    {
        $message = $this->getMessage('success', $slug);

        // Регистрируем лог
        $this->log([
            'place' => get_class($this),
            'message' => $message,
            'login' => $data['login'],
            'email' => $data['email'],
        ], false);

        return $this->responseJson($status, $this->getResponse(true, $message));
    }

    /**
     * @return object|ResponseInterface|Message|Response
     */
    public function responseJson(int $status, array $data)
    {
        // В случае middleware
        if (empty($this->response)) {
            $this->response = new Response();
        }
        // Запись ответа в Body
        $this->response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus($status);
    }

    /**
     * Получаем сообщение по типу: валидация, ошибка, успех и т.д.
     */
    public function getMessage(string $type, string $key): string
    {
        return $this->messages[$type][$key] ?? 'Сообщение не найдено!';
    }

    /**
     * Ответ клиенту в зависимости от - успех или нет
     */
    public function getResponse(bool $success, string $msg = ''): array
    {
        return $success ? ['success' => true, 'message' => $msg] : ['error' => true, 'message' => $msg];
    }
}