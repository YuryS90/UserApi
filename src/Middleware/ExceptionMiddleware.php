<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Psr7\Response;

class ExceptionMiddleware
{
    private string $logFilePath = __DIR__ . '/../../log/log.json';

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (HttpBadRequestException $exception) {
            $this->log($exception);
            // Обработка исключения HttpBadRequestException

            // Создание и возвращение ответа с ошибкой в формате JSON
            $response = new Response();
            $response->getBody()->write(json_encode([
                'error' => 'Bad Request',
                'message' => $exception->getMessage()
            ], JSON_UNESCAPED_UNICODE));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);

        } catch (HttpForbiddenException $exception) {
            $this->log($exception);
            // Обработка исключения HttpForbiddenException

            // Создание и возвращение ответа с ошибкой в формате JSON
            $response = new Response();
            $response->getBody()->write(json_encode([
                'error' => 'Forbidden',
                'message' => $exception->getMessage()
            ], JSON_UNESCAPED_UNICODE));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(403);

        } catch (\Exception $exception) {
            $this->log($exception);
            // Перехватываем все исключения (\Exception) или более конкретные типы исключений, если необходимо

            // Преобразование исключения в формат массива
            $errorData = [
                'error' => 'Internal Server Error',
                'message' => 'An unexpected error occurred.',
                'details' => [
                    'exception' => get_class($exception),
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];

            // Создание и возвращение ответа с ошибкой в формате JSON
            $response = new Response();
            $response->getBody()->write(json_encode($errorData, JSON_UNESCAPED_UNICODE));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }

    private function logException(\Exception $exception)
    {
        $logMessage = sprintf(
            "[%s] %s: %s\n%s\n\n",
            date('Y-m-d H:i:s'),
            get_class($exception),
            $exception->getMessage(),
            $exception->getTraceAsString()
        );

        file_put_contents($this->logFilePath, $logMessage, FILE_APPEND);
    }

    private function log(\Exception $exception)
    {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ];

        $logMessage = json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . ",\n";

        file_put_contents($this->logFilePath, $logMessage, FILE_APPEND | LOCK_EX);

        //$logMessage = json_encode($logData, JSON_UNESCAPED_UNICODE) . "\n";

        //file_put_contents($this->logFilePath, $logMessage, FILE_APPEND);
    }
}
