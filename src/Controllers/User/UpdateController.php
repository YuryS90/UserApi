<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class UpdateController extends AbstractController
{
    protected function run(): Response
    {

        $request = $this->request->getParsedBody();
$this->dd($request);
//  "_METHOD" => "PATCH"
//  "csrf_name" => "csrf654379d2874fe"
//  "csrf_value" => "qzL12HYng94jjgq49Vr7nUH8pFw9wzp6+r7VmJw/SpyYUMO8EBW05hO2M96Ub8modciROAX6WBifjO2q/ghyrg=="


        unset($request['_METHOD']);
        unset($request['csrf_name']);
        unset($request['csrf_value']);
        // Убираем возможность менять пароль, мыло и логин,
        // а валидируем оставшиеся поля
        //$data = $this->validate($request)

        ////  "name" => "ОЛег"
        ////  "address" => "Чапаева"
        ////  "roles_id" => "1"

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

        return $view->render($this->response, 'main/index.twig', [
            'user' => $request,
        ]);
    }
}