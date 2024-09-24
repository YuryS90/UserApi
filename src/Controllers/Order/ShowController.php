<?php

namespace App\Controllers\Order;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class ShowController extends AbstractController
{
    private string $template = 'order/show.twig';

    protected function run(): Response
    {
        $order = $this->orderItemRepo->filter([
            'order_id' => $this->id,

            'joinProduct' => [
                'fields' => ['id', 'title', 'price'],
                //'is_del' => 0 // потом добавить...
            ],
        ]);

        $totalPrice = 0;

        // Проходим по массиву $list и суммируем price с учетом quantity
        foreach ($order as $item) {
            if (isset($item["price"])) {
                $totalPrice += $item["price"] * $item["quantity"];
            }
        }

        return $this->render($this->template, [
            'number' => current($order)['orderId'] ?? '',
            'order' => $order ?? [],
            'totalPrice' => $totalPrice ?? 0,
        ]);
    }
}