<?php

namespace App\Controllers\Api\Order;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    protected function run(): Response
    {

        $order = $this->request->getParsedBody();
        $this->dd($order);
        // array:2 [
        //  "items" => array:2 [
        //    0 => array:7 [
        //      "id" => 12
        //      "title" => "Кроссовки Converse Chuck Taylor All-Star"
        //      "price" => 13000
        //      "imageUrl" => "http://userapi/public/images/sneakers-12.jpg"
        //      "isFavorite" => false
        //      "favoriteId" => null
        //      "isAdded" => true
        //    ]
        //    1 => array:7 [
        //      "id" => 6
        //      "title" => "Кроссовки Black Edition"
        //      "price" => 16999
        //      "imageUrl" => "http://userapi/public/images/sneakers-6.jpg"
        //      "isFavorite" => true
        //      "favoriteId" => 26
        //      "isAdded" => true
        //    ]
        //  ]
        //  "totalPrice" => 29999
        //]

        $id = $this->orderRepo->insertOrUpdate([]) ?? [];

        return $this->responseJson(201, ['id' => $id, 'message' => 'Заказ оформлен!']);
    }
}