<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class UpdateController extends AbstractController
{
    private string $template = 'main/index.twig';

    protected function run(): Response
    {
        $this->dd($this->args);

        // TODO
        //      Проверка на то если пользователя нет в БД, например, если в args будет 100000,
        //       то выбросить исключение или 404
        //      Проверить $id на 0
        //      Обработать пришедшие данные! $request и $this->args

        $request = $this->request->getParsedBody();

        // Исключаем ключи
        // array_flip() - значения становятся ключами
        $unsetValue = ['_METHOD', 'csrf_name', 'csrf_value'];
        $request = array_diff_key($request, array_flip($unsetValue));

        $this->dd($request);


        // Убираем возможность менять пароль, мыло и логин,
        // а валидируем оставшиеся поля
        //$data = $this->validate($request)


        // обновлем в бд
        $this->userRepo->insertOrUpdate([
            'id' => $this->args['user'],
            'name' => $request['name'],
            'address' => $request['address'],
            'roles_id' => $request['roles_id'],
        ]);

        $id = $this->args['id'] = $this->args['user'];
        $request['id'] = $id;

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, $this->template, [
            'user' => $request,
        ]);
    }
}