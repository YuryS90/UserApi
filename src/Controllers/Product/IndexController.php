<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null products
 */
class IndexController extends AbstractController
{
    private string $template = 'product/index.twig';

    protected function run(): Response
    {
        // Имена полей таблицы users
        //$columns = $this->listByParams(self::REPO_PRODUCT_FIELD, [
        //    'column' => true
        //]);


        // return $this->render($this->template, [
        //     // Пользователи с учётом их ролей
        //     'users' => $this->listByParams(self::REPO_USER, [
        //         'usersJoin' => true
        //     ]),
        //     // Имена полей в нужном порядке
        //     'fields' => $this->generateColumns($columns)
        // ]);

        return $this->render($this->template, [
            'products' => $this->products ?? [],
            //'fields' => $this->setFieldOrder($columns, 'PROD')
           //'fields' => array_column(
           //    $this->productRepo->getColumnsName(),
           //    "Comment",
           //    "Field"
           //)
        ]);
    }
}