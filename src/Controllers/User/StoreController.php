<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    protected function run(): Response
    {
        // Приходит request, который валидируем на правило required
        $request = $this->request->getParsedBody();

        unset($request['csrf_name']);
        unset($request['csrf_value']);

        //  "email" => "sviridenkoanzela8@gmail.com"
        //  "password" => "11111111"
        //  "name" => "Юрий"
        //  "address" => "DF"
        //  "role" => "admin"

        // Если не почта существует, то при добавлении идёт перезапись...
        // Валидация на уникальность и всё остальное
        //$data = $this->validate($request)

        // Добавить признак уникальности по мылу и логину firstOrCreate([])
        // Пароль валидировать на confirmed


        // Добавление в БД...
        $this->userRepo->insertOrUpdate($request);

        // редирект на indexcontroller
        return $this->response
            ->withHeader('Location', '/users')
            ->withStatus(302);
    }
}