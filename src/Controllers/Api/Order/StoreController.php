<?php

namespace App\Controllers\Api\Order;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    protected function run(): Response
    {
        $order = $this->request->getParsedBody();
        $jwt = $this->request->getAttribute('jwt_token')['data'];

        // Сделать проверку приходит ли токен, если нет то 401

        // Сделать проверку на total_price иначе пользователь придумает свою сумму
        // и только после этого добавить заказ

        $orderId = $this->orderRepo->insertOrUpdate([
            'user_id' => $jwt->id,
            'total_price' => $order['totalPrice'],
            'status_id' => 1
        ]);

       foreach ($order['items'] as $item) {
           $this->orderItemRepo->insertOrUpdate([
               'order_id' => $orderId,
               'test_id' => $item
           ]);
       }

        // Отправка данных на WebSocket сервер
        $this->sendToWebSocketServer([
            'orderNo' => $orderId,
            'userId' => $jwt->email ?? 'test', // Добавляем email клиента
            'address' => $order['address'] ?? 'Не добавлен!',
            'totalPrice' => $order['totalPrice'] ?? '100',
            'statusId' => 'Ожидание',
            'created' => date('Y-m-d H:i:s'),
            'message' => 'Новый заказ оформлен!'
        ]);

        return $this->responseJson(201, [
            'orderNo' => 123,
            'message' => 'Заказ оформлен!'
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