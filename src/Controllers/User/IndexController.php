<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class IndexController extends AbstractController
{
    protected function run(): Response
    {
        //SELECT email, name, address, is_email, name_role
        //FROM user_roles, users
        //WHERE roles_id = id_role
        //AND email = 'sviridenkoanzela8@gmail.com'
        //AND is_del = 1;

        // Получаем список юзеров, которые не удалены
        $users = $this->userRepo->filter([
                'is_del' => 0
            ]) ?? [];

        foreach ($users as &$user) {

            if ($user['rolesId'] == 1) {
                $user['rolesId'] = 'Админ';
            }
            if ($user['rolesId'] == 2) {
                $user['rolesId'] = 'Менеджер';
            }

            if ($user['rolesId'] == 3) {

                $user['rolesId'] = 'Пользователь';
            }

            if ($user['isEmail'] == 0) {
                $user['isEmail'] = 'Нет';
            } else {
                $user['isEmail'] = 'Да';
            }
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

        return $view->render($this->response, 'user/index.twig', [
            'users' => $users,
            'fields' => $fields,
        ]);
    }
}