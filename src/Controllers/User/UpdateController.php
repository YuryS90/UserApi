<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

/**
 * @property mixed|null $userRepo
 */
class UpdateController extends AbstractController
{
    protected function run(): Response
    {
        $id = (int)$this->args['user'];
        // TODO
        //      Проверка на то если пользователя нет в БД, например, если в args будет 100000,
        //       то выбросить исключение или 404
        //      Проверить $id на 0
        //      Обработать пришедшие данные! $request и $this->args

        $request = $this->request->getParsedBody();

        //$data = $this->validate($request)

        // Исключаем лишние ключи
        // array_flip() - значения становятся ключами
        $unsetValue = ['_METHOD', 'csrf_name', 'csrf_value'];
        $request = array_diff_key($request, array_flip($unsetValue));

        // Обновляем в БД, передав id
        $this->userRepo->insertOrUpdate([
            'id' => $id,
            'name' => $request['name'] ?? null,
            'address' => $request['address'] ?? null,
            'roles_id' => $request['roles_id'] ?? null,
        ]);

        return $this->response
            ->withHeader('Location', '/users')
            ->withStatus(302);
    }
}