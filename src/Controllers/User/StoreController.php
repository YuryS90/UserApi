<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    protected function run(): Response
    {
        // В валидации стоит confirmed - это означает что обязательно должны быть поля
        // У первого в инпуте должно name="password_confirmation", у второго инпута
        // name="password", т.е. у первого должно быть добавлено _confirmation
        // Решение сохранять успешные данные в сессию под ключом почты

        // Приходит request, который валидируем на правило required
        $request = $this->request->getParsedBody();

        //$this->dd($request);
        // Исключаем лишние ключи
        // array_flip() - значения становятся ключами
        $unsetValue = ['_METHOD', 'csrf_name', 'csrf_value'];
        $request = array_diff_key($request, array_flip($unsetValue));
        //$this->dd();
        // "email" => "sviridenko@gmail.com"
        //  "password" => "12345678"
        //  "password_confirmation" => ""
        //  "name" => "Анжела"
        //  "address" => "Чкалова 49"
        //  "roles_id" => "1"


        $this->validated($request);

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