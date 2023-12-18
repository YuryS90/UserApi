<?php

namespace App\Middleware\Category;

use App\Middleware\AbstractMiddleware;
use Psr\Http\Message\ResponseInterface;

/**
 * Category ($this->categories)
 *
 * Метод    Шаблон      Route   Используется
 * GET      /        |index |       Да  |+|
 * _________________________________________
 * GET      /create  |create|       Нет |+|
 * _________________________________________
 * GET  /{user}/edit |edit  |       Нет |+|
 * _________________________________________
 * GET  /{user}/     |show  |       Нет |+|
 *
 * =========================================
 *
 * Product($this->categories)
 *
 * Метод    Шаблон      Route   Используется
 * GET      /        |index |       ? ||
 * _________________________________________
 * GET      /create  |create|       ? ||
 * _________________________________________
 * GET  /{user}/edit |edit  |       ? ||
 * _________________________________________
 * GET  /{user}/     |show  |       ? ||
 *
 * Получение категорий
 * @property mixed|null $categoryRepo
 * @property $categories
 */
class GetCategoriesMiddleware extends AbstractMiddleware
{
    //const CREATE_ROUTE = 'product.create';

    public function run(): ResponseInterface
    {
        if ($this->getMethod() == 'GET') {

            $args = $this->getRouteArgs();
            //$this->dd($this->getPattern());
            // Для группы маршрутов категорий
            // $this->categories не попадает в create и где в параметре есть id
            if (!preg_match('/create/', $this->getPattern()) && empty($args)) {

                // Регистрация полученных категорий в DI
                $this->categories = $this->categoryRepo->filter([
                    'fields' => ['id', 'parent_id', 'title'],
                    'is_del' => 0
                ]);
            }

//$this->dd($this->getPattern());
            // Для группы маршрутов товаров
            if (preg_match("/products\/create/", $this->getPattern())) {
                //$this->dd($this->getPattern(), 1);
                // Регистрация полученных категорий в DI
                $this->categories = $this->categoryRepo->filter([
                    'fields' => ['id', 'parent_id', 'title'],
                    'is_del' => 0
                ]);
            }
            //$this->dd($this->getPattern(), 2);
        }

        // TODO: Все категории уже получены в CRUD с категориями - объединить!
        //if ($this->nameRoute() == self::CREATE_ROUTE) {
//
        //    // Регистрация полученных категорий в DI
        //    $this->categories = $this->categoryRepo->filter([
        //        'fields' => ['id', 'parent_id', 'title']
        //    ]);
        //}

        return $this->handle();
    }
}