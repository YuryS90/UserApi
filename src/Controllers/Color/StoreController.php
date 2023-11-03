<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

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
        $this->colorRepo->insertOrUpdate($request);

        // редирект на indexcontroller
        return $this->response
            ->withHeader('Location', '/colors')
            ->withStatus(302);
    }
}