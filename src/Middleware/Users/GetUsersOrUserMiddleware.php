<?php

namespace App\Middleware\Users;

use App\Middleware\AbstractMiddleware;
use Psr\Http\Message\ResponseInterface;

/**
 * Метод Шаблон         Имя     Доступно             Недоступно
 * GET  /            |index | $this->users, | + |   $this->user,    | + |
 *                            $this->userFields | + |   $this->roles    | - |
 * _______________________________________________________________________
 * GET  /create      |create| $this->roles  | + |   $this->user,    | + |
 *                                                  $this->users,   | + |
 *                                                  $this->userFields,  | + |
 * _______________________________________________________________________
 * GET  /{user}/edit |edit  | $this->user   | + |   $this->users,   | + |
 *                            $this->roles  | + |   $this->userFields,  | + |
 * _______________________________________________________________________
 * GET  /{user}/     |show  | $this->user   | + |   $this->users,   | + |
 *                            $this->userFields | + |   $this->roles    | - |
 * Получение данных для отображения таблицы с пользователями
 * @property array $users
 * @property mixed|null $userRepo
 * @property array $user
 * @property int|null $id
 */
class GetUsersOrUserMiddleware extends AbstractMiddleware
{
    private array $params = [
        'fields' => ['id', 'email', 'name', 'address', 'roles_id', 'is_email'],
        'joinRole' => [
            'fields' => ['id_role', 'name_role'],
        ],
        'is_del' => 0
    ];

    public function run(): ResponseInterface
    {
        if ($this->getMethod() == 'GET') {

            $args = $this->getRouteArgs();

            if (preg_match('/edit/', $this->getPattern()) || !empty($args)) {
                $this->params['id'] = $this->id ?? null;
                $this->params['single'] = true;

                // Получение одного пользователя
                $this->user = $this->userRepo->filter($this->params) ?? null;
            }

            // $this->users не попадает в create и где в параметре есть id
            if (!preg_match('/create/', $this->getPattern()) && empty($args)) {

                // Получение всех пользователей
                $this->users = $this->userRepo->filter($this->params) ?? [];
            }
        }

        return $this->handle();
    }
}