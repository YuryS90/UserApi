<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/** Создание */
class StoreController extends AbstractController
{
    protected function run(): Response
    {
        // Приходит request, который валидируем на правило required
        $request = $this->request->getParsedBody();
        //$data = $this->validate($request)

        unset($request['csrf_name']);
        unset($request['csrf_value']);

        // Добавление в БД...
        $this->categoryRepo->insertOrUpdate($request);

        // редирект на indexcontroller
        return $this->response
            ->withHeader('Location', '/categories')
            ->withStatus(302);
    }
}