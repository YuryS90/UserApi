<?php

namespace App\Modules\Log;

use App\Modules\MainModule;

class ActionLog extends MainModule
{
    private string $log = '';

    public function setLog(string $log): void
    {
        $this->log = $log;
    }

    public function getLog(): string
    {
        return $this->log;
    }

    public function logger(array $params = [], bool $error = false): void
    {
        $log = [
            'time' => date('H:i:s d-m-Y') ?? null,
            'place' => $params['place'] ?? null,
            'message' => $params['message'] ?? null,
            'route' => $_SERVER['REQUEST_URI'] ?? null,
            'user' => [
                'ip' => $this->ip ?? null,
                'device' => $this->userAgent ?? null,
            ],
        ];

        if (!empty($params['login']) && !empty($params['email'])) {
            $log['user'] += [
                'login' => $params['login'],
                'email' => $params['email'],
            ];
        }

        if (!empty($params['exception'])) {
            $exception = $params['exception'];
            $log['exception'] = [
                'exception' => get_class($exception) ?? null,
                'message' => $exception->getMessage() ?? null,
                'code' => $exception->getCode() ?? null,
                'path' => $exception->getFile() ?? null,
                'str' => $exception->getLine() ?? null,
            ];
        }
        $this->setLog(json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL);

        // Запись в соответствии типа лога
        $logFile = $error ? $this->paths['log']['error'] : $this->paths['log']['success'];
        $this->saveData($logFile);
    }

    private function saveData(string $file): void
    {
        $logs = file_get_contents($file);
        $logs = $this->getLog() . $logs;

        // "Свежий" лог записывается в начало файла
        // LOCK_EX - предотвратит ошибки при параллельной записи логов
        file_put_contents($file, $logs, LOCK_EX);
    }
}