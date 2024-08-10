<?php

namespace App\Common;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Psr7\Message;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @property array $queryParams
 */
trait ServiceTrait
{
    use HelperTrait;

//    /** @return object|ResponseInterface|Message|Response */
//    public function respondError(int $status, string $message)
//    {
//        return $this->responseJson($status, $this->getResponse(false, $message));
//    }
//
    /** @return ResponseInterface|Message|Response */
    public function respondException(int $status, object $e)
    {
        // Получаем из config сообщение по статусу
        $message = $this->getMessage('exception', $status);

        // Регистрируем лог
        $this->log([
            'place' => get_class($this),
            'message' => $message,
            // В $e храниться сообщение, которое нельзя показывать клиенту
            'exception' => $e
        ], true);

        return $this->responseJson($status, $this->getResponse(false, $message));
    }
//
//    /** @return object|ResponseInterface|Message|Response */
//    public function respondSuccess(int $status, string $slug, array $data = [], string $token = '')
//    {
//        $message = $this->getMessage('success', $slug);
//
//        // Регистрируем лог
//        $this->log([
//            'place' => get_class($this),
//            'message' => $message,
//            'login' => $data['login'],
//            'email' => $data['email'],
//        ], false);
//
//        return $this->responseJson($status, $this->getResponse(true, $message), $token);
//    }
//

    public function getRoute(): ?\Slim\Interfaces\RouteInterface
    {
        $routeContext = RouteContext::fromRequest($this->request);

        return $routeContext->getRoute();
    }

    public function getRouteArgument(string $name): ?string
    {
        return $this->getRoute()->getArgument($name) ?? null;
    }

    public function nameRoute(): ?string
    {
        return $this->getRoute()->getName();
    }

    public function getRouteArgs(): array
    {
        return $this->getRoute()->getArguments();
    }

    public function getPattern(): string
    {
        return $this->getRoute()->getPattern();
    }

    public function getMethod(): string
    {
        return $this->request->getMethod();
    }


    /**
     * Делаем перезагрузку страницы на указанный адрес
     * @param string $url
     * @return Message|Response
     */
    public function redirect(string $url = '/')
    {
        $response = new Response();
        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }

    /** @return object|ResponseInterface|Message|Response */
    public function responseJson(int $status, array $data, $token = '')
    {
        // В случае middleware
        if (empty($this->response)) {
            $this->response = new Response();
        }

        if ($token) {
            $data['token'] = $token;
        }

        // Запись ответа в Body
        $this->response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->response
            ->withHeader('Content-Type', 'application/json; charset=UTF-8')
            ->withStatus($status);
    }

    /** Получаем сообщение по типу: валидация, ошибка, успех и т.д. */
    public function getMessage(string $type, string $key): string
    {
        return $this->messages[$type][$key] ?? 'Сообщение не найдено!';
    }

    /** Ответ клиенту в зависимости от - успех или нет */
    public function getResponse(bool $success, string $msg = ''): array
    {
        return $success ? ['success' => true, 'message' => $msg] : ['error' => true, 'message' => $msg];
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $template, array $params = []): ResponseInterface
    {
        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, $template, $params);
    }

    /**
     * Получаем и обрабатываем данные пришедшие из GET
     */
    public function getQueryParams(): array
    {
        if (!$this->queryParams) {
            $this->queryParams = $this->request->getQueryParams() ?? [];
        }

        return $this->queryParams;
    }

    public function getClassName(): string
    {
        // Из строки "App\\Controllers\\Product\\StoreController" оставляю Product => product
        // ([^\\\\]+) — захватывающая группа для извлечения названия сущности.
        // Она ищет любую последовательность символов, кроме обратной косой черты.
        preg_match(
            '/^App\\\\Controllers\\\\([^\\\\]+)/',
            get_class($this),
            $match
        );
        return strtolower($match[1]);
    }

    /**
     * @throws \Exception
     * Перемещает файл, и присваивает ему уникальное имя.
     * Возвращает название файла с уникальным именем.
     */
    public function moveUploadedFile(string $directory, UploadedFileInterface $image): string
    {
        $extension = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);

        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $image->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}