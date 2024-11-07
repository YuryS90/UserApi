<?php

namespace App\Controllers\Order;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends AbstractController
{
    private string $template = 'order/index.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        $orders = $this->orderRepo->filter([
            'joinUser' => [
                'fields' => ['id', 'email', 'address'],
                'is_del' => 0
            ],
            'joinStatus' => [
                'fields' => ['id', 'st_name'],
                'is_del' => 0
            ],
            'orderByIdDesc' => true,
        ]);

        // Отправка данных на WebSocket сервер
//        $this->sendToWebSocketServer([
//
//            'orders' => $orders,
//            'message' => 'Новый заказ оформлен!'
//        ]);

        return $this->render($this->template, [
            'orders' => $orders
        ]);
    }

    private function sendToWebSocketServer(array $data)
    {
        try {
            $wsUrl = 'ws://127.0.0.1:2346';
            $client = new \WebSocket\Client($wsUrl);
            $client->send(json_encode($data));
            $client->close();
        } catch (\Exception $e) {
            echo "Ошибка при отправке данных на WebSocket-сервер: " . $e->getMessage();
        }
    }
}