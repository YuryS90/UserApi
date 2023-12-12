<?php

namespace App\Middleware\Users;

use App\Middleware\AbstractMiddleware;
use Psr\Http\Message\ResponseInterface;

/**
 * @property mixed|null $roleRepo
 * @property array $roles
 */
class GetRolesMiddleware extends AbstractMiddleware
{
    public function run(): ResponseInterface
    {
        if (!$this->roles) {
            $this->roles = $this->roleRepo->filter([]) ?? [];
        }

        return $this->handle();
    }
}