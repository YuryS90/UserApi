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

        return $this->responseJson(201, [
            'orderNo' => $orderId,
            'message' => 'Заказ оформлен!'
        ]);
    }
}