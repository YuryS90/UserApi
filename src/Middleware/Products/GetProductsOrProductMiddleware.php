<?php

namespace App\Middleware\Products;

use App\Middleware\AbstractMiddleware;
use Psr\Http\Message\ResponseInterface;

/**
 * Метод    Шаблон      Route   Использует                  Не должно использовать
 * GET      /        |index |   $this->products,     | + |  $this->product  |  |
 *                              $this->productFields | + |
 * _______________________________________________________________________
 * GET      /create  |create|                               $this->product,       |  |
 *                                                          $this->products,      |  |
 *                                                          $this->productFields, |  |
 * _______________________________________________________________________
 * GET  /{user}/edit |edit  |   $this->product       | + |  $this->products,      |  |
 *                                                          $this->productFields, |  |
 * _______________________________________________________________________
 * GET  /{user}/     |show  |   $this->product       | + |  $this->products       |  |
 *                              $this->productFields | + |
 * Получение данных для отображения таблицы с пользователями
 * @property int|null $id
 * @property array $products
 * @property mixed|null $productRepo
 * @property null $product
 */
class GetProductsOrProductMiddleware extends AbstractMiddleware
{
    private array $params = [
        'fields' => ['id', 'article', 'brand', 'description', 'preview_image', 'new_price', 'old_price', 'count', 'category_id'],
        'is_del' => 0
    ];

    public function run(): ResponseInterface
    {
        if ($this->getMethod() == 'GET') {

            $args = $this->getRouteArgs();

            if (preg_match('/edit/', $this->getPattern()) || !empty($args)) {
                $this->params['id'] = $this->id ?? null;
                $this->params['single'] = true;

                // Получение одного пользователя
                $this->product = $this->productRepo->filter($this->params) ?? null;
            }

            // $this->users не попадает в create и где в параметре есть id
           if (!preg_match('/create/', $this->getPattern()) && empty($args)) {

               // Получение всех пользователей
               $this->products = $this->productRepo->filter($this->params) ?? [];
           }
        }

        return $this->handle();
    }
}