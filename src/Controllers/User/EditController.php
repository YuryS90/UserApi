<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class EditController extends AbstractController
{
    protected function run(): Response
    {
        // Попробывать выполнить чтобы не получать отдельно роли
        //SELECT email, name, address, is_email, name_role
        //FROM user_roles, users
        //WHERE roles_id = id_role
        //AND email = 'sviridenkoanzela8@gmail.com'
        //AND is_del = 1;


        $this->dd($this->request, 123, $this->args);

        //  #attributes: array:8 [▼
        //    "csrf_name" => "csrf6544cb52c0218"
        //    "csrf_value" => "0hg7y5aoA7qe0LXFYtQBHzg+FBr815cCDjUCTRnrAji3K16opZEyg6+zjfUHsGcnWwctL8/h82BqBWEpKNMxWg=="
        //    "__routeParser__" => Slim\Routing\RouteParser {#30 ▶}
        //    "__routingResults__" => Slim\Routing\RoutingResults {#168 ▶}
        //    "__route__" => Slim\Routing\Route {#140 ▶}
        //    "view" => Slim\Views\Twig {#39 ▶}
        //    "__basePath__" => ""
        //    "user" => "6"
        //  ]

        // По аргументу получаем данные об этой категории
        $user = $this->userRepo->filter([
            'fields' => ['email', 'name', 'address', 'is_email', 'name_role']
            //'id' => $this->args['user'],
            //'single' => true
        ]);

        // Получить все роли
        $roles = $this->roleRepo->filter([]);

        $view = Twig::fromRequest($this->request);
//$this->dd($user, $roles);
        return $view->render($this->response, 'user/edit.twig', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }
}