<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

class TestController extends AbstractController
{

    protected function run(): Response
    {

        $products = [
            [
                "id" => 1,
                "title" => "Мужские Кроссовки Nike Blazer Mid Suede",
                "price" => 12999,
                //"imageUrl" => "/images/sneakers/sneakers-1.jpg"
                "imageUrl" => "http://userapi/public/images/sneakers-1.jpg"
            ],
            [
                "id" => 2,
                "title" => "Мужские Кроссовки Nike Air Max 270",
                "price" => 15600,
                "imageUrl" => "http://userapi/public/images/sneakers-2.jpg"
            ],
            [
                "id" => 3,
                "title" => "Мужские Кроссовки Nike Blazer Mid Suede",
                "price" => 8499,
                "imageUrl" => "http://userapi/public/images/sneakers-3.jpg"
            ],
            [
                "id" => 4,
                "title" => "Кроссовки Puma X Aka Boku Future Rider",
                "price" => 7800,
                "imageUrl" => "http://userapi/public/images/sneakers-4.jpg"
            ],
//            [
//                "id" => 5,
//                "title" => "Кроссовки Future Rider",
//                "price" => 9550,
//                "imageUrl" => "/images/sneakers/sneakers-5.jpg"
//            ],
//            [
//                "id" => 6,
//                "title" => "Кроссовки Black Edition",
//                "price" => 16999,
//                "imageUrl" => "/images/sneakers/sneakers-6.jpg"
//            ],
//            [
//                "id" => 7,
//                "title" => "Кроссовки Orange Boomb Edition",
//                "price" => 7499,
//                "imageUrl" => "/images/sneakers/sneakers-7.jpg"
//            ],
//            [
//                "id" => 8,
//                "title" => "Кроссовки Nike Air Max 270",
//                "price" => 15600,
//                "imageUrl" => "/images/sneakers/sneakers-8.jpg"
//            ],
//            [
//                "id" => 9,
//                "title" => "Кроссовки Nike Air Force 1",
//                "price" => 5900,
//                "imageUrl" => "/images/sneakers/sneakers-9.jpg"
//            ],
//            [
//                "id" => 10,
//                "title" => "Кроссовки Adidas Ultraboost",
//                "price" => 11500,
//                "imageUrl" => "/images/sneakers/sneakers-10.jpg"
//            ],
//            [
//                "id" => 11,
//                "title" => "Кроссовки Puma Clyde All-Pro",
//                "price" => 7600,
//                "imageUrl" => "/images/sneakers/sneakers-11.jpg"
//            ],
//            [
//                "id" => 12,
//                "title" => "Кроссовки Converse Chuck Taylor All-Star",
//                "price" => 13000,
//                "imageUrl" => "/images/sneakers/sneakers-12.jpg"
//            ]
        ];


        return $this->responseJson(200, $products);
    }
}