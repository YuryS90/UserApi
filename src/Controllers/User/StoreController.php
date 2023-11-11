<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $userRepo
 */
class StoreController extends AbstractController
{
    protected function run(): Response
    {
        $request = $this->request->getParsedBody() ?? [];

        // Исключаем лишние ключи sanitization()
        // array_flip() - значения становятся ключами
        $unsetValue = ['_METHOD', 'csrf_name', 'csrf_value'];
        $request = array_diff_key($request, array_flip($unsetValue));

        $res = $this->validated($request);
        $this->dd($res);

        // Добавить признак уникальности по мылу и логину firstOrCreate([])
        
        // Добавление в БД
        // Если почта существует, то при добавлении идёт перезапись...
        $this->userRepo->insertOrUpdate($request);

        return $this->response
            ->withHeader('Location', '/users')
            ->withStatus(302);
    }
}