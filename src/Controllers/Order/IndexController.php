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

        return $this->render($this->template, [
            'orders' => $orders
        ]);
    }
}