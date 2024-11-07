<?php

use Workerman\Worker;

require_once __DIR__ . '/../../vendor/autoload.php';

// Создание веб-сокет-сервера на порту 2346
$wsWorker = new Worker("websocket://0.0.0.0:2346");

// Количество процессов, которые будет обрабатывать подключения от клиентов
$wsWorker->count = 4;

// Обработка callback для подключения пользователя и принимает соединение ($connection)
$wsWorker->onConnect = function ($connection) {
    echo "Привет user \n";
};

// Обработка входящих сообщений от клиента
$wsWorker->onMessage = function ($connection, $data) use ($wsWorker) {
    // Здесь мы можем обрабатывать сообщения от клиента, если нужно
    // Декодируем полученные данные
    $orderData = json_decode($data, true);

    if ($orderData) {
        echo "Получен новый заказ:\n";
        print_r($orderData);

        // Отправляем сообщение обратно всем подключенным клиентам
        foreach ($wsWorker->connections as $clientConnection) {
            // Каждому клиенту закидываем информацию
            $clientConnection->send(json_encode($orderData));
        }
    } else {
        echo "Некорректные данные: $data\n";
    }
};

// Обработка события отключения
$wsWorker->onClose = function ($connection) {
    echo "Connection closed\n";
};

// Запуск веб-сокет-сервера
Worker::runAll();
