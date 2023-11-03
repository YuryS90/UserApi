<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class ShowController extends AbstractController
{
    protected function run(): Response
    {
        // По аргументу получаем данные о пользователе
        $user = $this->userRepo->filter([
            'id' => $this->args['user'],
            'single' => true
        ]);


        if ($user['rolesId'] === 1) {
            $user['rolesId'] = 'Админ';
        }

        if ($user['rolesId'] === 2) {
            $user['rolesId'] = 'Менеджер';
        }
        if ($user['rolesId'] === 3) {
            $user['rolesId'] = 'Пользователь';
        }
        if ($user['isEmail'] == 0) {
            $user['isEmail'] = 'Нет';
        } else {
            $user['isEmail'] = 'Да';
        }

        $columns = $this->db->showColumns('users');
        $fields = [];
        foreach ($columns as $column) {
            $fields[$column['Field']] = $column['Comment'];
            if ($fields['password'] && $fields['is_del'] && $fields['created'] && $fields['updated']) {
                unset($fields['password']);
                unset($fields['is_del']);
                unset($fields['created']);
                unset($fields['updated']);
            }
        }

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'user/show.twig', [
            'user' => $user,
            'fields' => $fields,
        ]);
    }
}